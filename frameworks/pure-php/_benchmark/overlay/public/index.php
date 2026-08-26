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

if ($path !== '/hello/index') {
    http_response_code(404);
    echo 'Not Found';
    exit;
}

echo 'Hello World!';
require dirname(__DIR__, 2) . '/libs/output_data.php';
