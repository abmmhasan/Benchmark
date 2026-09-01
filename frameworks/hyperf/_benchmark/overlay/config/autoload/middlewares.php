<?php

declare(strict_types=1);

use App\Middleware\BenchmarkTelemetryMiddleware;

return [
    'http' => [
        BenchmarkTelemetryMiddleware::class,
    ],
];
