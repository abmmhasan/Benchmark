<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

app()->get('/index.php/hello/index', static function (): void {
    echo 'Hello World!';
    require dirname(__DIR__, 3) . '/libs/output_data.php';
});
app()->run();
