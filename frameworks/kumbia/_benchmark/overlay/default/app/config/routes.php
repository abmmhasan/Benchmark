<?php

return [
    'routes' => [
        '/hello/42/index' => '/hello/index/42',
        '/hello/index/*' => '/hello/index/*',
        '/hello/*' => '/hello/index/*',
    ],
];
