<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath((string) ($_SERVER['SCRIPT_NAME'] ?? ''));
$app->get('/hello/index', static function ($request, $response) {
    ob_start();
    require dirname(__DIR__, 2) . '/libs/output_data.php';
    $telemetry = ob_get_clean();
    $response->getBody()->write('Hello World!' . (is_string($telemetry) ? $telemetry : ''));

    return $response;
});
$app->run();
