<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AbmmHasan\Benchmark\{
    BenchmarkConfig,
    BenchmarkRunner,
    HttpMethod,
    PipingMode
};

$validJsonResponse = static function (string $response): bool {
    try {
        $payload = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
        return false;
    }

    return is_array($payload)
        && isset($payload['memory'])
        && is_numeric($payload['memory']);
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
    responseValidator: $validJsonResponse,
);

$laravel = new BenchmarkConfig(
    url: 'https://kam.sslcommerz.localhost/api/json',
    method: HttpMethod::GET,
    headers: ['Accept' => 'application/json'],
    expectedStatus: 200,
    container: 'PHP_8.4',
    name: 'laravel',
    responseValidator: $validJsonResponse,
);

$infbyte = new BenchmarkConfig(
    url: 'https://inf.localhost/json',
    method: HttpMethod::GET,
    headers: ['Accept' => 'application/json'],
    expectedStatus: 200,
    container: 'PHP_8.4',
    name: 'infbyte',
    responseValidator: $validJsonResponse,
);

$raw = new BenchmarkConfig(
    url: 'https://test.localhost',
    method: HttpMethod::GET,
    headers: ['Accept' => 'application/json'],
    expectedStatus: 200,
    container: 'PHP_8.4',
    name: 'raw',
    responseValidator: $validJsonResponse,
);

/* ------------------------------------------------------------------ *
 *  2)  Build the runner with shared defaults via fluent chain         *
 * ------------------------------------------------------------------ */
$runner = BenchmarkRunner::make()
    ->threads(100)
    ->count(5000)
    ->minimumDuration(10)
    ->piping(PipingMode::Optimal)
    ->timeout(2)
    ->enableHttp2(false)
    ->verifySsl(false)
    ->addConfigs($raw, $laravel, $webrick, $infbyte)
    ->sampleEvery(1.0);

/* ------------------------------------------------------------------ *
 *  3)  Execute and print a Markdown comparison table                  *
 * ------------------------------------------------------------------ */
echo $runner->runAll('table');
