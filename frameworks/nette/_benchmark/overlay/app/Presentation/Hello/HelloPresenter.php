<?php

declare(strict_types=1);

namespace App\Presentation\Hello;

use Nette;
use Nette\Application\Responses\TextResponse;

/*
    PHP-Frameworks-Bench
    this is a simple hello world controller to make benchmark
 */
final class HelloPresenter extends Nette\Application\UI\Presenter
{
    public function actionDefault(?string $value = null): void
    {
        if (!$this->getHttpRequest()->isMethod('GET')) {
            $this->getHttpResponse()->setCode(405);
            $this->getHttpResponse()->setHeader('Allow', 'GET');
            $this->sendResponse(new TextResponse('Method Not Allowed'));
        }
        $this->sendResponse(new TextResponse('Hello World!'));
    }

    public function actionMiddle(?string $value = null): void
    {
        $this->sendResponse(new TextResponse('Hello World!'));
    }

    public function actionLast(?string $value = null): void
    {
        $this->sendResponse(new TextResponse('Hello World!'));
    }

    public function actionFirst(?string $value = null): void
    {
        $this->sendResponse(new TextResponse('Hello World!'));
    }

    public function actionMultiple(?string $first = null, ?string $second = null): void
    {
        $this->sendResponse(new TextResponse('Hello World!'));
    }

    public function actionPrecedence(): void
    {
        $this->sendResponse(new TextResponse('Hello World!'));
    }

    public function actionOverlap(?string $value = null): void
    {
        $this->sendResponse(new TextResponse('Hello World!'));
    }
}
