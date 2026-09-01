<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class BenchmarkTelemetry
{
    public const string START_ATTRIBUTE = '_benchmark_started_at';

    public function handle(Request $request, Closure $next): Response
    {
        $startedAt = microtime(true);
        $request->attributes->set(self::START_ATTRIBUTE, $startedAt);
        $response = $next($request);

        return self::append($response, $startedAt);
    }

    public static function append(Response $response, mixed $startedAt = null): Response
    {
        if ($response->headers->has('X-Benchmark-Telemetry')) {
            return $response;
        }
        $startedAt = is_float($startedAt) ? $startedAt : microtime(true);
        $telemetry = sprintf(
            "\n%' 8d:%f:%'.03d",
            memory_get_peak_usage(),
            max(0.0, microtime(true) - $startedAt),
            max(0, count(get_included_files()) - 1),
        );
        $response->setContent((string) $response->getContent() . $telemetry);
        $response->headers->set('X-Benchmark-Telemetry', '1');

        return $response;
    }
}
