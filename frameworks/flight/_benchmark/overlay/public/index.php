<?php

declare(strict_types=1);

use flight\Engine;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = new Engine();
$app->set('flight.base_url', '/');
$app->set('flight.content_length', false);

$app->router()->get('/index.php/hello/index', static function (): void {
    echo 'Hello World!';
    require dirname(__DIR__, 3) . '/libs/output_data.php';
});

$app->start();
