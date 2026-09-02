<?php

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';
$config['components']['urlManager'] = [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => true,
    'rules' => [
        'hello/index' => 'hello/index',
        'hello/<value:[^/]+>/index' => 'hello/index',
        'hello/index/<value:[^/]+>' => 'hello/index',
        '<value:[^/]+>/hello/index' => 'hello/index',
        'hello/pair/<first:[^/]+>/<second:[^/]+>' => 'hello/index',
        'hello/benchmark/fixed' => 'hello/index',
        'hello/<value:[^/]+>/fixed' => 'hello/index',
    ],
];

(new yii\web\Application($config))->run();

/* *** PHP-Frameworks-Bench *** */
require dirname(__DIR__, 3) . '/libs/output_data.php';
