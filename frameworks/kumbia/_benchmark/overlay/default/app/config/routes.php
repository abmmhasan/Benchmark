<?php

return [
    'routes' => [
        '/hello/42/index' => '/hello/index/42',
        '/42/hello/index' => '/hello/index/42',
        '/hello/pair/42/84' => '/hello/index/42/84',
        '/hello/benchmark/fixed' => '/hello/index',
        '/hello/index/*' => '/hello/index/*',
        '/hello/*' => '/hello/index/*',
    ],
];
