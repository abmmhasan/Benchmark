<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;

/* ---------- enums ---------- */

enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case HEAD = 'HEAD';
    case PATCH = 'PATCH';
}

enum PipingMode: string
{
    case Optimal = 'optimal';
    case Max = 'max';
}

/* ------------------------------------------------------------------ */
/*  Immutable DTO with optional Docker-stats fields                   */

/* ------------------------------------------------------------------ */

final class BenchmarkConfig
{
    /* -------- unique per-request -------- */
    private string $name;
    private string $url;
    private HttpMethod $method;
    private array $headers;
    private array|string|null $body;
    private int $expectedStatus;

    /* -------- common / defaultable -------- */
    private ?int $threads;
    private ?int $count;
    private ?PipingMode $piping;
    private ?int $timeout;
    private ?bool $enableHttp2;
    private ?bool $verifySsl;

    /* -------- container telemetry -------- */
    private ?string $container;      // Docker container name / ID
    private ?float $sampleInterval; // seconds between stats polls

    /* -------- misc -------- */
    private array $curlOptions;
    private bool $skipPreflight;

    public function __construct(
        string $url,
        HttpMethod $method = HttpMethod::GET,
        array $headers = [],
        array|string|null $body = null,
        int $expectedStatus = 200,

        ?int $threads = null,
        ?int $count = null,
        ?PipingMode $piping = null,
        ?int $timeout = null,
        ?bool $enableHttp2 = null,
        ?bool $verifySsl = null,

        ?string $container = null,
        ?float $sampleEvery = 1.0,

        array $curlOptions = [],
        ?string $name = null,
        bool $skipPreflight = false,
    ) {
        /* ---------- basic validation ---------- */
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: {$url}");
        }
        if ($expectedStatus < 100 || $expectedStatus >= 500) {
            throw new InvalidArgumentException("Invalid expected status: {$expectedStatus}");
        }
        if ($threads !== null && $threads < 2) {
            throw new InvalidArgumentException('Threads must be ≥ 2');
        }
        if ($count !== null && $count < 100) {
            throw new InvalidArgumentException('Count must be ≥ 100');
        }
        if ($threads !== null && $count !== null && $count < $threads) {
            throw new InvalidArgumentException("Count ({$count}) must be ≥ threads ({$threads})");
        }
        if ($timeout !== null && $timeout < 0) {
            throw new InvalidArgumentException('Timeout must be ≥ 0');
        }
        if ($sampleEvery !== null && $sampleEvery <= 0) {
            throw new InvalidArgumentException('sampleEvery must be > 0');
        }

        $headers = $headers ?: ['Cache-Control' => 'no-cache'];

        /* ---------- assignment ---------- */
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
        $this->verifySsl = $verifySsl;

        $this->container = $container;
        $this->sampleInterval = $sampleEvery;

        $this->curlOptions = $curlOptions;
        $this->skipPreflight = $skipPreflight;
        $this->name = $name ?? $url;
    }

    /* ---------- getters ---------- */

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

    public function getThreads(): ?int
    {
        return $this->threads;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function getPiping(): ?PipingMode
    {
        return $this->piping;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function isHttp2Enabled(): ?bool
    {
        return $this->enableHttp2;
    }

    public function isVerifySsl(): ?bool
    {
        return $this->verifySsl;
    }

    /* container telemetry */
    public function getContainer(): ?string
    {
        return $this->container;
    }

    public function getSampleInterval(): ?float
    {
        return $this->sampleInterval;
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
