<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

$hello = static function (): void { echo 'Hello World!'; };
app()->get('/index.php/hello/index', $hello);
app()->get('/index.php/hello/{value}/index', $hello);
app()->get('/index.php/hello/index/{value}', $hello);
app()->get('/index.php/{value}/hello/index', $hello);
app()->get('/index.php/hello/pair/{first}/{second}', $hello);
app()->get('/index.php/hello/benchmark/fixed', $hello);
app()->get('/index.php/hello/{value}/fixed', $hello);
app()->post('/index.php/hello/index', static function (): void {
    response()->plain('Method Not Allowed', 405);
});
app()->run();
require dirname(__DIR__, 3) . '/libs/output_data.php';
