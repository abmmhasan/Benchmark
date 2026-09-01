<?php

declare(strict_types=1);

use Infocyph\Webrick\Response\Response;

final class BenchmarkWebrickHandler
{
    public static function hello(): Response
    {
        return self::response();
    }

    public static function dynamic(string $value): Response
    {
        unset($value);

        return self::response();
    }

    private static function response(): Response
    {
        return Response::create(
            'Hello World!',
            headers: ['Content-Type' => 'text/plain; charset=UTF-8'],
        );
    }
}
