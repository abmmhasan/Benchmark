<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Infocyph\Webrick\Response\Response;

final readonly class HelloWorldController
{
    public static function index(): Response
    {
        return self::response();
    }

    public static function dynamic(?string $value = null): Response
    {
        return self::response();
    }

    private static function response(): Response
    {
        return Response::create('Hello World!', headers: ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
