<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;

final class BenchmarkConfig
{
    private const VALID_METHODS = ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'PATCH'];
    private const VALID_PIPING = ['optimal', 'max'];

    private string $name;
    private string $url;
    private string $method;
    private array $headers;
    private array|string|null $body;
    private int $expectedStatus;
    private int $threads;
    private int $count;
    private string $piping;
    private int $timeout;
    private bool $enableHttp2;
    private array $curlOptions;

    /**
     * @param string $url Full URL to hit.
     * @param string $method HTTP verb.
     * @param array $headers Any extra headers.
     * @param array|string|null $body Request body (array→JSON, or raw string).
     * @param int $expectedStatus HTTP status you expect (<500).
     * @param int $threads Concurrent connections (>=2).
     * @param int $count Total requests (>=100, ≥ threads).
     * @param string $piping "optimal" or "max".
     * @param int $timeout connect+response timeout in seconds.
     * @param bool $enableHttp2 Enable HTTP/2 multiplexing.
     * @param array $curlOptions Any extra CURLOPT_* overrides.
     * @param string|null $name A label (defaults to URL).
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $url,
        string $method = 'GET',
        array $headers = ['Cache-Control' => 'no-cache'],
        array|string|null $body = null,
        int $expectedStatus = 200,
        int $threads = 10,
        int $count = 1000,
        string $piping = 'optimal',
        int $timeout = 1,
        bool $enableHttp2 = false,
        array $curlOptions = [],
        ?string $name = null,
    ) {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Invalid URL: {$url}");
        }
        $method = strtoupper($method);
        if (!in_array($method, self::VALID_METHODS, true)) {
            throw new InvalidArgumentException("Invalid HTTP method: {$method}");
        }
        if ($expectedStatus < 100 || $expectedStatus >= 500) {
            throw new InvalidArgumentException("Invalid expected status: {$expectedStatus}");
        }
        if ($threads < 2) {
            throw new InvalidArgumentException("Threads must be ≥ 2");
        }
        if ($count < 100) {
            throw new InvalidArgumentException("Count must be ≥ 100");
        }
        if ($count < $threads) {
            throw new InvalidArgumentException("Count ({$count}) must be ≥ threads ({$threads})");
        }
        if (!in_array($piping, self::VALID_PIPING, true)) {
            throw new InvalidArgumentException("Invalid piping: {$piping}");
        }
        if ($timeout < 0) {
            throw new InvalidArgumentException("Timeout must be ≥ 0");
        }

        $this->url = $url;
        $this->method = $method;
        $this->headers = $headers;
        $this->body = $body;
        $this->expectedStatus = $expectedStatus;
        $this->threads = $threads;
        $this->count = $count;
        $this->piping = $piping;
        $this->timeout = $timeout;
        $this->enableHttp2 = $enableHttp2;
        $this->curlOptions = $curlOptions;
        $this->name = $name ?? $url;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): array|string|null
    {
        return $this->body;
    }

    public function getExpectedStatus(): int
    {
        return $this->expectedStatus;
    }

    public function getThreads(): int
    {
        return $this->threads;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPiping(): string
    {
        return $this->piping;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function isHttp2Enabled(): bool
    {
        return $this->enableHttp2;
    }

    public function getCurlOptions(): array
    {
        return $this->curlOptions;
    }
}
