<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

/* *** PHP-Frameworks-Bench *** */
$routes->get('hello/index', 'HelloWorld::index');
$routes->get('hello/(:segment)/index', 'HelloWorld::index/$1');
$routes->get('hello/index/(:segment)', 'HelloWorld::index/$1');
$routes->get('(:segment)/hello/index', 'HelloWorld::index/$1');
$routes->get('hello/pair/(:segment)/(:segment)', 'HelloWorld::index/$1/$2');
$routes->get('hello/benchmark/fixed', 'HelloWorld::index');
$routes->get('hello/(:segment)/fixed', 'HelloWorld::index/$1');
$routes->post('hello/index', 'HelloWorld::methodNotAllowed');
