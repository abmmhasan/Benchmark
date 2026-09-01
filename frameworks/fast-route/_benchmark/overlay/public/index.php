<?php

declare(strict_types=1);

use FastRoute\Dispatcher;

use function FastRoute\cachedDispatcher;

require dirname(__DIR__) . '/vendor/autoload.php';

register_shutdown_function(static function (): void {
    require dirname(__DIR__, 3) . '/libs/output_data.php';
});

$dispatcher = cachedDispatcher(
    require dirname(__DIR__) . '/routes.php',
    [
        'cacheFile' => dirname(__DIR__) . '/.route-cache.php',
        'cacheDisabled' => false,
    ],
);

$uri = $_SERVER['PATH_INFO'] ?? null;
if (!is_string($uri) || $uri === '') {
    $requestPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH);
    $scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '');
    $uri = is_string($requestPath) ? $requestPath : '/';
    if ($scriptName !== '' && str_starts_with($uri, $scriptName)) {
        $uri = substr($uri, strlen($scriptName)) ?: '/';
    }
}

$route = $dispatcher->dispatch(
    (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'),
    rawurldecode($uri),
);

switch ($route[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'Not Found';
        return;

    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        header('Allow: ' . implode(', ', $route[1]));
        echo 'Method Not Allowed';
        return;

    case Dispatcher::FOUND:
        if (($route[1] ?? null) !== 'hello.index') {
            http_response_code(500);
            echo 'Unknown route handler';
            return;
        }
        break;

    default:
        http_response_code(500);
        echo 'Unexpected dispatcher result';
        return;
}

header('Content-Type: text/plain; charset=UTF-8');
echo 'Hello World!', PHP_EOL;
