<?php

declare(strict_types=1);

use flight\Engine;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = new Engine();
$app->set('flight.base_url', '/');
$app->set('flight.content_length', false);

$hello = static function (): void { echo 'Hello World!'; };
$app->router()->get('/index.php/hello/index', $hello);
$app->router()->get('/index.php/hello/@value/index', $hello);
$app->router()->get('/index.php/hello/index/@value', $hello);

$app->start();
require dirname(__DIR__, 3) . '/libs/output_data.php';
