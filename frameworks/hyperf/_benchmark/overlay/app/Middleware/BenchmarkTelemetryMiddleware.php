<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class BenchmarkTelemetryMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        $startedAt = microtime(true);
        $response = $handler->handle($request);
        if (str_starts_with($request->getUri()->getPath(), '/libs/')) {
            return $response;
        }
        $response->getBody()->write(sprintf(
            "\n%' 8d:%f:%'.03d",
            memory_get_peak_usage(),
            max(0.0, microtime(true) - $startedAt),
            max(0, count(get_included_files()) - 1),
        ));

        return $response;
    }
}
