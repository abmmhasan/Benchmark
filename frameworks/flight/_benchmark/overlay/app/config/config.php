<?php

declare(strict_types=1);

return [
    'app' => [
        'env' => 'production',
        'debug' => false,
        'base_url' => '/',
        'timezone' => 'UTC',
    ],
    'database' => [
        'driver' => '',
        'host' => 'localhost',
        'dbname' => '',
        'user' => '',
        'password' => '',
        'file_path' => '',
        'charset' => 'utf8mb4',
    ],
    'session' => [
        'prefix' => 'flight_benchmark_',
        'save_path' => null,
    ],
    'runway' => [
        'index_root' => 'public/index.php',
        'app_root' => 'app/',
    ],
];

