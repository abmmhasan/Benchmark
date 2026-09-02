<?php

declare(strict_types=1);

use Infocyph\Webrick\Response\Emitter\DefaultEmitter;

$assetDirectory = dirname(__DIR__);

require $assetDirectory . '/vendor/autoload.php';
require $assetDirectory . '/benchmark-kernel.php';

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

$kernel = benchmarkWebrickKernel($assetDirectory);
$response = $kernel->handle();

(new DefaultEmitter())->emit($response);
