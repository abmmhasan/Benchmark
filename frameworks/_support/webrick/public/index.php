<?php

declare(strict_types=1);

use Infocyph\Webrick\Request\Request;
use Infocyph\Webrick\Response\Emitter\AutoEmitter;
use Infocyph\Webrick\Response\Response;
use Infocyph\Webrick\Router\Definition\Registrar;
use Infocyph\Webrick\Router\Kernel\RouterKernel;
use Infocyph\Webrick\Router\Matching\FusedMatcher;
use Infocyph\Webrick\Router\Matching\GeneratedMatcher;
use Infocyph\Webrick\Router\Matching\ShardedMatcher;
use Psr\Log\NullLogger;

require dirname(__DIR__) . '/vendor/autoload.php';

$matcherMode = require dirname(__DIR__) . '/matcher.php';
$matcher = match ($matcherMode) {
    'fused' => FusedMatcher::make(),
    'generated' => GeneratedMatcher::make(),
    'sharded' => ShardedMatcher::make(),
    default => throw new RuntimeException('Unsupported Webrick benchmark matcher'),
};
$routeCache = match ($matcherMode) {
    'fused' => dirname(__DIR__) . '/.route-cache/__routes.php',
    'generated' => dirname(__DIR__) . '/.route-cache/__generated.php',
    default => dirname(__DIR__) . '/.route-cache',
};

$path = $_SERVER['PATH_INFO'] ?? null;
if (!is_string($path) || $path === '') {
    $requestPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH);
    $scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '');
    $path = is_string($requestPath) ? $requestPath : '/';
    if ($scriptName !== '' && str_starts_with($path, $scriptName)) {
        $path = substr($path, strlen($scriptName)) ?: '/';
    }
}

$query = (string) ($_SERVER['QUERY_STRING'] ?? '');
$_SERVER['REQUEST_URI'] = $path . ($query !== '' ? '?' . $query : '');

$kernel = RouterKernel::bootWithRegistrar(
    log: new NullLogger(),
    matcher: $matcher,
    register: static function (Registrar $registrar): void {
        require dirname(__DIR__) . '/routes.php';
    },
    routeCache: $routeCache,
    fallbackAliasesFromRegistrar: false,
    debug: false,
);
$request = Request::fromGlobals();
$response = $kernel->handle($request);

ob_start();
require dirname(__DIR__, 3) . '/libs/output_data.php';
$benchmarkData = ob_get_clean();

$response = Response::create(
    (string) $response->getBody() . (is_string($benchmarkData) ? $benchmarkData : ''),
    $response->getStatusCode(),
    $response->getHeaders(),
);

new AutoEmitter()->emit($response, $request);
