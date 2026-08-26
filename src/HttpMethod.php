<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case HEAD = 'HEAD';
    case PATCH = 'PATCH';
}
