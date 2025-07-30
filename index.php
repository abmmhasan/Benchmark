<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AbmmHasan\Benchmark\BenchmarkConfig;
use AbmmHasan\Benchmark\BenchmarkRunner;

//
// 1) Define your configurations
//
$config1 = new BenchmarkConfig(
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

$config2 = new BenchmarkConfig(
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

$config3 = new BenchmarkConfig(
    url:            'https://localhost.internal/',
    method:         'GET',
    headers:        ['Accept' => 'application/json'],
    body:           null,
    expectedStatus: 200,
    threads:        5,
    count:          500,
    piping:         'optimal',
    timeout:        2,
    enableHttp2:    true,
    name:           'wr-home'
);

//
// 2) Create the runner with as many configs as you like
//
$runner = new BenchmarkRunner($config1, $config2, $config3);
//$runner = new BenchmarkRunner($configOrders);

//
// 3) Execute all benchmarks and collect results
//
echo $runner->runAll('table');
