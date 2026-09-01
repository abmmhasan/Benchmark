<?php

declare(strict_types=1);

use Infocyph\Webrick\Response\Response;

$registrar->get(
    '/hello/index',
    static fn(): Response => Response::create(
        'Hello World!',
        headers: ['Content-Type' => 'text/plain; charset=UTF-8'],
    ),
    'hello.index',
);
$registrar->get(
    '/hello/{value}/index',
    static fn(): Response => Response::create(
        'Hello World!',
        headers: ['Content-Type' => 'text/plain; charset=UTF-8'],
    ),
    'hello.dynamic-middle',
);
$registrar->get(
    '/hello/index/{value}',
    static fn(): Response => Response::create(
        'Hello World!',
        headers: ['Content-Type' => 'text/plain; charset=UTF-8'],
    ),
    'hello.dynamic-last',
);
