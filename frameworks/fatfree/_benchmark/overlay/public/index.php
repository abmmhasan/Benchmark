<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

$app = Base::instance();
$app->set('DEBUG', 0);
$hello = static function (): void { echo 'Hello World!'; };
$app->route('GET /index.php/hello/index', $hello);
$app->route('GET /index.php/hello/@value/index', $hello);
$app->route('GET /index.php/hello/index/@value', $hello);
$app->route('GET /index.php/@value/hello/index', $hello);
$app->route('GET /index.php/hello/pair/@first/@second', $hello);
$app->route('GET /index.php/hello/benchmark/fixed', $hello);
$app->route('GET /index.php/hello/@value/fixed', $hello);
$app->run();
require dirname(__DIR__, 3) . '/libs/output_data.php';
