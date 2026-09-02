<?php

declare(strict_types=1);

require_once __DIR__ . '/benchmark-handler.php';

$registrar->get(
    '/hello/index',
    [BenchmarkWebrickHandler::class, 'hello'],
    'hello.index',
);
$registrar->get(
    '/hello/{value}/index',
    [BenchmarkWebrickHandler::class, 'dynamic'],
    'hello.dynamic-middle',
);
$registrar->get(
    '/hello/index/{value}',
    [BenchmarkWebrickHandler::class, 'dynamic'],
    'hello.dynamic-last',
);
$registrar->get(
    '/{value}/hello/index',
    [BenchmarkWebrickHandler::class, 'dynamic'],
    'hello.dynamic-first',
);
$registrar->get(
    '/hello/pair/{first}/{second}',
    [BenchmarkWebrickHandler::class, 'multiple'],
    'hello.multiple',
);
$registrar->get(
    '/hello/benchmark/fixed',
    [BenchmarkWebrickHandler::class, 'hello'],
    'hello.static-precedence',
);
$registrar->get(
    '/hello/{value}/fixed',
    [BenchmarkWebrickHandler::class, 'dynamic'],
    'hello.dynamic-overlap',
);
