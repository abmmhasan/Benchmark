<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AbmmHasan\Benchmark\BenchmarkConfig;
use AbmmHasan\Benchmark\BenchmarkRunner;

//
// 1) Define your configurations
//
$configUsers = new BenchmarkConfig(
    url:            'https://localhost.internal/json',
    method:         'GET',
    headers:        ['Accept' => 'application/json'],
    body:           null,
    expectedStatus: 200,
    threads:        5,
    count:          500,
    piping:         'optimal',
    timeout:        2,
    enableHttp2:    true,
    name:           'webrick'
);

$configOrders = new BenchmarkConfig(
    url:            'https://local.easy.com.bd/api/json',
    method:         'GET',
    headers:        ['Accept' => 'application/json'],
    body:           null,
    expectedStatus: 200,
    threads:        5,
    count:          500,
    piping:         'optimal',
    timeout:        2,
    enableHttp2:    true,
    name:           'laravel'
);

//
// 2) Create the runner with as many configs as you like
//
$runner = new BenchmarkRunner($configUsers, $configOrders);
//$runner = new BenchmarkRunner($configOrders);

//
// 3) Execute all benchmarks and collect results
//
echo $runner->runAll('table');
