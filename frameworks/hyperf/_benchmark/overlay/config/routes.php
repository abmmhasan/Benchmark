<?php

declare(strict_types=1);

use App\Controller\BenchmarkController;
use Hyperf\HttpServer\Router\Router;

Router::get('/hyperf/hello/index', [BenchmarkController::class, 'hello']);
Router::get('/hyperf/hello/{value}/index', [BenchmarkController::class, 'hello']);
Router::get('/hyperf/hello/index/{value}', [BenchmarkController::class, 'hello']);
Router::get('/hyperf/{value}/hello/index', [BenchmarkController::class, 'hello']);
Router::get('/hyperf/hello/pair/{first}/{second}', [BenchmarkController::class, 'hello']);
Router::get('/hyperf/hello/benchmark/fixed', [BenchmarkController::class, 'hello']);
Router::get('/hyperf/hello/{value}/fixed', [BenchmarkController::class, 'hello']);
Router::get('/libs/php_config.php', [BenchmarkController::class, 'environment']);
Router::get('/libs/php_disable_functions.php', [BenchmarkController::class, 'disabledFunctions']);
