<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AbmmHasan\Benchmark\{
    BenchmarkConfig,
    BenchmarkRunner,
    HttpMethod,
    PipingMode
};

/* ------------------------------------------------------------------ *
 *  1)  Define the­ “unique” parts for each target endpoint            *
 * ------------------------------------------------------------------ */
$webrick = new BenchmarkConfig(
    url: 'https://webrick.localhost/json',
    method: HttpMethod::GET,
    headers: ['Accept' => 'application/json'],
    expectedStatus: 200,
    container: 'PHP_8.4',
    name: 'webrick',
);

$laravel = new BenchmarkConfig(
    url: 'https://kam.sslcommerz.localhost/api/json',
    method: HttpMethod::GET,
    headers: ['Accept' => 'application/json'],
    expectedStatus: 200,
    container: 'PHP_8.4',
    name: 'laravel',
);

$raw = new BenchmarkConfig(
    url: 'https://test.localhost',
    method: HttpMethod::GET,
    headers: ['Accept' => 'application/json'],
    expectedStatus: 200,
    container: 'PHP_8.4',
    name: 'raw',
);

/* ------------------------------------------------------------------ *
 *  2)  Build the runner with shared defaults via fluent chain         *
 * ------------------------------------------------------------------ */
$runner = BenchmarkRunner::make()
    ->threads(100)
    ->count(5000)
    ->piping(PipingMode::Optimal)
    ->timeout(2)
    ->enableHttp2(false)
    ->verifySsl(false)
    ->addConfigs($raw, $laravel, $webrick)
    ->sampleEvery(1.0);

/* ------------------------------------------------------------------ *
 *  3)  Execute and print a Markdown comparison table                  *
 * ------------------------------------------------------------------ */
echo $runner->runAll('table');
