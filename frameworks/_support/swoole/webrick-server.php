<?php

declare(strict_types=1);

use Infocyph\Webrick\Runtime\Http\SwooleRuntimeAdapter;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Swoole\Http\Server;

if (!extension_loaded('swoole')) {
    throw new RuntimeException('The Webrick persistent server requires the Swoole extension.');
}

$assetDirectory = $argv[1] ?? '';
$port = filter_var($argv[2] ?? null, FILTER_VALIDATE_INT);
if (!is_string($assetDirectory) || !is_dir($assetDirectory) || !is_int($port)) {
    throw new InvalidArgumentException('Usage: webrick-server.php ASSET_DIRECTORY PORT');
}

$assetDirectory = realpath($assetDirectory);
if (!is_string($assetDirectory)) {
    throw new RuntimeException('Unable to resolve the Webrick asset directory.');
}

chdir($assetDirectory);
require $assetDirectory . '/vendor/autoload.php';
require $assetDirectory . '/benchmark-kernel.php';

$kernel = benchmarkWebrickKernel($assetDirectory);
$adapter = SwooleRuntimeAdapter::swoole();

$server = new Server('0.0.0.0', $port, SWOOLE_BASE);
$server->set([
    'enable_coroutine' => false,
    'max_request' => 100000,
    'open_tcp_nodelay' => true,
    'worker_num' => swoole_cpu_num(),
]);
$server->on('request', static function (
    SwooleRequest $incoming,
    SwooleResponse $outgoing,
) use ($adapter, $kernel): void {
    $startedAt = microtime(true);
    $GLOBALS['benchmark_webrick_started_at'] = $startedAt;

    try {
        $context = $adapter->context(
            $incoming,
            $outgoing,
            $kernel->requiresHostRouting(),
        );
        $response = $kernel->handleRuntime($context);
        $adapter->write($response, $context);
    } catch (Throwable $exception) {
        error_log($exception->__toString());
        if (!$outgoing->isWritable()) {
            return;
        }
        $outgoing->status(500);
        $outgoing->header('Content-Type', 'text/plain; charset=utf-8');
        $outgoing->end('Internal Server Error');
    } finally {
        unset($GLOBALS['benchmark_webrick_started_at']);
    }
});

$server->start();
