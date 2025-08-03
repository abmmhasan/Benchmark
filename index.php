<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AbmmHasan\Benchmark\{
    BenchmarkConfig,
    BenchmarkRunner,
    HttpMethod,
    PipingMode
};

/* unique-piece configs */
$c1 = new BenchmarkConfig(
    url: 'https://localhost.internal/json',
    method: HttpMethod::GET,
    expectedStatus: 200,
    name: 'webrick',
);
$c2 = new BenchmarkConfig(
    url: 'https://local.easy.com.bd/api/json',
    method: HttpMethod::GET,
    expectedStatus: 200,
    name: 'laravel',
);
$c3 = new BenchmarkConfig(
    url: 'https://localhost.internal/',
    method: HttpMethod::GET,
    expectedStatus: 200,
    name: 'wr-home',
);

/* runner with shared defaults (incl. SSL) */
$runner = BenchmarkRunner::make()
    ->threads(5)
    ->count(500)
    ->piping(PipingMode::Optimal)
    ->timeout(2)
    ->enableHttp2()
    ->verifySsl(false)          // ← NEW: toggle to false to allow self-signed
    ->addConfigs($c1, $c2, $c3);

/* run */
echo $runner->runAll('table');
