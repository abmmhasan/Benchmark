<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

$app = Base::instance();
$app->set('DEBUG', 0);
$app->route('GET /index.php/hello/index', static function (): void {
    echo 'Hello World!';
    require dirname(__DIR__, 3) . '/libs/output_data.php';
});
$app->run();
