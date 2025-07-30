<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use AbmmHasan\Benchmark\{
    BenchmarkConfig,
    BenchmarkRunner,
    HttpMethod,
    PipingMode
};

//
// 1)  Define your benchmark configurations
//
$config1 = new BenchmarkConfig(
    url:            'https://localhost.internal/json',
    method:         HttpMethod::GET,
    headers:        ['Accept' => 'application/json'],
    expectedStatus: 200,
    threads:        5,
    count:          500,
    piping:         PipingMode::Optimal,
    timeout:        2,
    enableHttp2:    true,
    name:           'webrick'
);

$config2 = new BenchmarkConfig(
    url:            'https://local.easy.com.bd/api/json',
    method:         HttpMethod::GET,
    headers:        ['Accept' => 'application/json'],
    expectedStatus: 200,
    threads:        5,
    count:          500,
    piping:         PipingMode::Optimal,
    timeout:        2,
    enableHttp2:    true,
    name:           'laravel'
);

$config3 = new BenchmarkConfig(
    url:            'https://localhost.internal/',
    method:         HttpMethod::GET,
    headers:        ['Accept' => 'application/json'],
    expectedStatus: 200,
    threads:        5,
    count:          500,
    piping:         PipingMode::Optimal,
    timeout:        2,
    enableHttp2:    true,
    name:           'wr-home'
);

//
// 2)  Create the runner with any number of configs
//
$runner = new BenchmarkRunner($config1, $config2, $config3);

//
// 3)  Execute all benchmarks and print a Markdown table
//
echo $runner->runAll('table');
