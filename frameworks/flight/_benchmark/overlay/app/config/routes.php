<?php

declare(strict_types=1);

/** @var \flight\net\Router $router */
$hello = static function (): void { echo 'Hello World!'; };
$router->get('/index.php/hello/index', $hello);
$router->get('/index.php/hello/@value/index', $hello);
$router->get('/index.php/hello/index/@value', $hello);
$router->get('/index.php/@value/hello/index', $hello);
$router->get('/index.php/hello/pair/@first/@second', $hello);
$router->get('/index.php/hello/benchmark/fixed', $hello);
$router->get('/index.php/hello/@value/fixed', $hello);
