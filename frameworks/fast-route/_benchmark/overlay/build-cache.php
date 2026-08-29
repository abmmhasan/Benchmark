<?php

declare(strict_types=1);

use function FastRoute\cachedDispatcher;

require __DIR__ . '/vendor/autoload.php';

$cacheFile = __DIR__ . '/.route-cache.php';
if (is_file($cacheFile) && !unlink($cacheFile)) {
    throw new RuntimeException('Unable to clear the FastRoute cache');
}

cachedDispatcher(
    require __DIR__ . '/routes.php',
    [
        'cacheFile' => $cacheFile,
        'cacheDisabled' => false,
    ],
);

if (!is_file($cacheFile)) {
    throw new RuntimeException('FastRoute did not generate its route cache');
}
