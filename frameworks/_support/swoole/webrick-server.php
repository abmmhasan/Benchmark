<?php

declare(strict_types=1);

use Infocyph\Webrick\Request\Core\Stream;
use Infocyph\Webrick\Request\Request;
use Infocyph\Webrick\Response\Emitter\SwooleEmitter;
use Infocyph\Webrick\Response\Response;
use Infocyph\Webrick\Router\Definition\Registrar;
use Infocyph\Webrick\Router\Kernel\RouterKernel;
use Infocyph\Webrick\Router\Matching\FusedMatcher;
use Infocyph\Webrick\Router\Matching\GeneratedMatcher;
use Infocyph\Webrick\Router\Matching\ShardedMatcher;
use Psr\Log\NullLogger;
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

$matcherMode = require $assetDirectory . '/matcher.php';
$matcher = match ($matcherMode) {
    'fused' => FusedMatcher::make(),
    'generated' => GeneratedMatcher::make(),
    'sharded' => ShardedMatcher::make(),
    default => throw new RuntimeException('Unsupported Webrick benchmark matcher.'),
};
$routeCache = match ($matcherMode) {
    'fused' => $assetDirectory . '/.route-cache/__routes.php',
    'generated' => $assetDirectory . '/.route-cache/__generated.php',
    default => $assetDirectory . '/.route-cache',
};
$kernel = RouterKernel::bootWithRegistrar(
    log: new NullLogger(),
    matcher: $matcher,
    register: static function (Registrar $registrar) use ($assetDirectory): void {
        require $assetDirectory . '/routes.php';
    },
    routeCache: $routeCache,
    fallbackAliasesFromRegistrar: false,
    debug: false,
);

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
) use ($kernel): void {
    $startedAt = microtime(true);

    try {
        $swooleServer = is_array($incoming->server ?? null) ? $incoming->server : [];
        $headers = is_array($incoming->header ?? null) ? $incoming->header : [];
        $query = is_array($incoming->get ?? null) ? $incoming->get : [];
        $post = is_array($incoming->post ?? null) ? $incoming->post : [];
        $cookies = is_array($incoming->cookie ?? null) ? $incoming->cookie : [];
        $path = (string) ($swooleServer['request_uri'] ?? '/');
        $queryString = (string) ($swooleServer['query_string'] ?? '');
        $host = (string) ($headers['host'] ?? '127.0.0.1');
        $uri = 'http://' . $host . $path . ($queryString !== '' ? '?' . $queryString : '');
        $serverParameters = [];
        foreach ($swooleServer as $name => $value) {
            $serverParameters[strtoupper((string) $name)] = $value;
        }
        $serverParameters['REQUEST_TIME_FLOAT'] = $startedAt;
        $request = new Request(
            method: (string) ($swooleServer['request_method'] ?? 'GET'),
            uri: $uri,
            server: $serverParameters,
            headers: $headers,
            body: new Stream($incoming->rawContent() ?: ''),
            httpVer: (string) ($swooleServer['server_protocol'] ?? '1.1'),
            parsed: $post,
            query: $query,
            cookies: $cookies,
        );
        $request = $request->withAttribute('swoole.response', $outgoing);
        $response = $kernel->handle($request);
        $telemetry = sprintf(
            "\n%' 8d:%f:%'.03d",
            memory_get_peak_usage(),
            max(0.0, microtime(true) - $startedAt),
            max(0, count(get_included_files()) - 1),
        );
        $response = Response::create(
            (string) $response->getBody() . $telemetry,
            $response->getStatusCode(),
            $response->getHeaders(),
        );
        new SwooleEmitter()->emit($response, $request);
    } catch (Throwable $exception) {
        error_log($exception->__toString());
        if (!$outgoing->isWritable()) {
            return;
        }
        $outgoing->status(500);
        $outgoing->header('Content-Type', 'text/plain; charset=utf-8');
        $outgoing->end('Internal Server Error');
    }
});

$server->start();
