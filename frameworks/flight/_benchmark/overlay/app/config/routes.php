<?php

declare(strict_types=1);

/** @var \flight\net\Router $router */
$router->get('/index.php/hello/index', static function (): void {
    echo 'Hello World!';
    require dirname(__DIR__, 3) . '/libs/output_data.php';
});
