<?php declare(strict_types=1);
/*
    PHP-Frameworks-Bench
    this is a simple hello world controller to make benchmark
 */
namespace app\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;

// such simple controller
class HelloController extends Controller {
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['index' => ['GET']],
            ],
        ];
    }

    public function actionIndex(?string $value = null) {
        return 'Hello World!';
    }
}
