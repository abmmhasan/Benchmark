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

    public static function multiple(string $first, string $second): Response
    {
        unset($first, $second);

        return self::response();
    }

    private static function response(): Response
    {
        $startedAt = $GLOBALS['benchmark_webrick_started_at']
            ?? (float) ($_SERVER['REQUEST_TIME_FLOAT'] ?? microtime(true));
        $telemetry = sprintf(
            "\n%' 8d:%f:%'.03d",
            memory_get_peak_usage(),
            max(0.0, microtime(true) - (float) $startedAt),
            max(0, count(get_included_files()) - 1),
        );

        return Response::create(
            'Hello World!' . $telemetry,
            headers: ['Content-Type' => 'text/plain; charset=UTF-8'],
        );
    }
}
