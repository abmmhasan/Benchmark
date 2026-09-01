<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

$app = Base::instance();
$app->set('DEBUG', 0);
$hello = static function (): void { echo 'Hello World!'; };
$app->route('GET /index.php/hello/index', $hello);
$app->route('GET /index.php/hello/@value/index', $hello);
$app->route('GET /index.php/hello/index/@value', $hello);
$app->run();
require dirname(__DIR__, 3) . '/libs/output_data.php';
