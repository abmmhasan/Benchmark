<?php

declare(strict_types=1);

use App\Controller\BenchmarkController;
use Hyperf\HttpServer\Router\Router;

Router::get('/hyperf/hello/index', [BenchmarkController::class, 'hello']);
Router::get('/libs/php_config.php', [BenchmarkController::class, 'environment']);
Router::get('/libs/php_disable_functions.php', [BenchmarkController::class, 'disabledFunctions']);
