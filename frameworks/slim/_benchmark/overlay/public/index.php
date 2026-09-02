<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath((string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$app->addErrorMiddleware(false, true, true);
$hello = static function ($request, $response) {
    $response->getBody()->write('Hello World!');
    return $response;
};
$app->get('/hello/index', $hello);
$app->get('/hello/{value}/index', $hello);
$app->get('/hello/index/{value}', $hello);
$app->get('/{value}/hello/index', $hello);
$app->get('/hello/pair/{first}/{second}', $hello);
$app->get('/hello/benchmark/fixed', $hello);
$app->get('/hello/{value}/fixed', $hello);
$app->run();
require dirname(__DIR__, 3) . '/libs/output_data.php';
