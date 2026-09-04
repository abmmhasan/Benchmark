<?php

declare(strict_types=1);

use Infocyph\Webrick\Request\Request;
use Infocyph\Webrick\Response\Emitter\DefaultEmitter;
use Infocyph\Webrick\Response\Response;

$assetDirectory = __DIR__;
require $assetDirectory . '/vendor/autoload.php';
require $assetDirectory . '/benchmark-kernel.php';

$kernel = benchmarkWebrickKernel($assetDirectory);
$driver = strtolower((string) (getenv('BENCHMARK_DRIVER') ?: ($argv[1] ?? '')));

$handle = static function (Request $request) use ($kernel, $driver): Response {
    $path = $request->getUri()->getPath();
    if ($path === '/libs/php_config.php') {
        return Response::create(json_encode([
            'phpVersion' => PHP_VERSION,
            'phpSapi' => PHP_SAPI,
            'loadedIni' => php_ini_loaded_file() ?: null,
            'benchmarkProfile' => $driver . '-production',
            'runtime' => [
                'profile' => $driver,
                'extensionLoaded' => $driver === 'frankenphp' && extension_loaded('frankenphp'),
                'extensionVersion' => $driver === 'frankenphp' && extension_loaded('frankenphp')
                    ? phpversion('frankenphp')
                    : null,
                'persistentWorker' => true,
            ],
            'opcache' => [
                'extensionLoaded' => extension_loaded('Zend OPcache'),
                'enabled' => filter_var(ini_get('opcache.enable_cli'), FILTER_VALIDATE_BOOL),
            ],
        ], JSON_THROW_ON_ERROR), headers: ['Content-Type' => 'application/json']);
    }
    if ($path === '/libs/php_disable_functions.php') {
        return Response::create(json_encode([
            'disableFunctions' => array_values(array_filter(array_map('trim', explode(',', (string) ini_get('disable_functions'))))),
        ], JSON_THROW_ON_ERROR), headers: ['Content-Type' => 'application/json']);
    }

    $GLOBALS['benchmark_webrick_started_at'] = microtime(true);
    return $kernel->handle($request);
};

if ($driver === 'frankenphp') {
    $callback = static function () use ($handle): void {
        (new DefaultEmitter())->emit($handle(Request::fromGlobals()));
    };
    while (frankenphp_handle_request($callback)) {
        gc_collect_cycles();
    }
    exit(0);
}

if ($driver === 'roadrunner') {
    $factory = new Nyholm\Psr7\Factory\Psr17Factory();
    $worker = new Spiral\RoadRunner\Http\PSR7Worker(
        Spiral\RoadRunner\Worker::create(),
        $factory,
        $factory,
        $factory,
    );
    while (($incoming = $worker->waitRequest()) !== null) {
        try {
            $request = Request::fake(
                query: $incoming->getQueryParams(),
                post: is_array($incoming->getParsedBody()) ? $incoming->getParsedBody() : [],
                headers: $incoming->getHeaders(),
                method: $incoming->getMethod(),
                uri: (string) $incoming->getUri(),
            );
            $worker->respond($handle($request));
        } catch (Throwable $exception) {
            $worker->getWorker()->error((string) $exception);
        }
    }
    exit(0);
}

if ($driver === 'workerman') {
    $port = filter_var($argv[2] ?? null, FILTER_VALIDATE_INT);
    if (!is_int($port)) {
        throw new InvalidArgumentException('Usage: benchmark-worker.php workerman PORT');
    }
    $server = new Workerman\Worker("http://0.0.0.0:{$port}");
    $server->count = max(1, (int) (getenv('BENCHMARK_WORKERS') ?: 1));
    $server->reusePort = true;
    $server->onMessage = static function ($connection, Workerman\Protocols\Http\Request $incoming) use ($handle): void {
        try {
            $response = $handle(Request::fake(method: $incoming->method(), uri: $incoming->uri()));
            $connection->send(new Workerman\Protocols\Http\Response(
                $response->getStatusCode(),
                $response->getHeaders(),
                (string) $response->getBody(),
            ));
        } catch (Throwable $exception) {
            error_log((string) $exception);
            $connection->send(new Workerman\Protocols\Http\Response(500, [], 'Internal Server Error'));
        }
    };
    $GLOBALS['argv'] = [$argv[0], 'start'];
    Workerman\Worker::runAll();
    exit(0);
}

throw new InvalidArgumentException('BENCHMARK_DRIVER must be frankenphp, roadrunner, or workerman');
