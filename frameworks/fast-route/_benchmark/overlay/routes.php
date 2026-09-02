<?php

declare(strict_types=1);

use FastRoute\RouteCollector;

return static function (RouteCollector $routes): void {
    $routes->addRoute('GET', '/hello/index', 'hello.index');
    $routes->addRoute('GET', '/hello/{value}/index', 'hello.index');
    $routes->addRoute('GET', '/hello/index/{value}', 'hello.index');
    $routes->addRoute('GET', '/{value}/hello/index', 'hello.index');
    $routes->addRoute('GET', '/hello/pair/{first}/{second}', 'hello.index');
    $routes->addRoute('GET', '/hello/benchmark/fixed', 'hello.index');
    $routes->addRoute('GET', '/hello/{value}/fixed', 'hello.index');
};
