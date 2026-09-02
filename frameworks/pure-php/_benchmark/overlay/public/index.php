<?php

declare(strict_types=1);

$path = $_SERVER['PATH_INFO'] ?? null;
if (!is_string($path) || $path === '') {
    $requestPath = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH);
    $scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '');
    $path = is_string($requestPath) ? $requestPath : '/';
    if ($scriptName !== '' && str_starts_with($path, $scriptName)) {
        $path = substr($path, strlen($scriptName)) ?: '/';
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $path === '/hello/index') {
    http_response_code(405);
    header('Allow: GET');
    echo 'Method Not Allowed';
} elseif (!in_array($path, [
    '/hello/index',
    '/hello/42/index',
    '/hello/index/42',
    '/42/hello/index',
    '/hello/pair/42/84',
    '/hello/benchmark/fixed',
], true)) {
    http_response_code(404);
    echo 'Not Found';
} else {
    echo 'Hello World!';
}

require dirname(__DIR__, 3) . '/libs/output_data.php';
