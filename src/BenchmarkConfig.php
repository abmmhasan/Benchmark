<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;

/**
 * HTTP verbs we explicitly allow.
 * Add others here if your benchmark needs them.
 */
enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case HEAD = 'HEAD';
    case PATCH = 'PATCH';
}

/**
 * How aggressively we let cURL multiplex / pipeline.
 */
enum PipingMode: string
{
    case Optimal = 'optimal';
    case Max = 'max';
}

final class BenchmarkConfig
{
    private string $name;
    private string $url;
    private HttpMethod $method;
    private array $headers;
    private array|string|null $body;
    private int $expectedStatus;
    private int $threads;
    private int $count;
    private PipingMode $piping;
    private int $timeout;
    private bool $enableHttp2;
    private array $curlOptions;
    private bool $skipPreflight;

    /**
     * @param string $url Full URL to hit.
     * @param HttpMethod $method HTTP verb.
     * @param array<string,string> $headers Any extra headers.
     * @param array|string|null $body Request body (array→JSON, or raw string).
     * @param int $expectedStatus HTTP status you expect (<500).
     * @param int $threads Concurrent connections (>=2).
     * @param int $count Total requests (>=100, ≥ threads).
     * @param PipingMode $piping "optimal" or "max".
     * @param int $timeout connect+response timeout in seconds.
     * @param bool $enableHttp2 Enable HTTP/2 multiplexing.
     * @param array<int,mixed> $curlOptions Any extra CURLOPT_* overrides.
     * @param string|null $name A label (defaults to URL).
     * @param bool $skipPreflight Skip the initial connectivity HEAD-probe.
     *
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $url,
        HttpMethod $method = HttpMethod::GET,
        array $headers = [],
        array|string|null $body = null,
        int $expectedStatus = 200,
        int $threads = 10,
        int $count = 1000,
        PipingMode $piping = PipingMode::Optimal,
        int $timeout = 1,
        bool $enableHttp2 = false,
        array $curlOptions = [],
        ?string $name = null,
        bool $skipPreflight = false,
    ) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: {$url}");
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
        if ($timeout < 0) {
            throw new InvalidArgumentException("Timeout must be ≥ 0");
        }

        // sensible default header
        $headers = $headers ?: ['Cache-Control' => 'no-cache'];

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
        $this->skipPreflight = $skipPreflight;
        $this->name = $name ?? $url;
    }

    /* ---------- simple value objects ---------- */

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): HttpMethod
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

    public function getPiping(): PipingMode
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

    public function skipPreflight(): bool
    {
        return $this->skipPreflight;
    }
}
