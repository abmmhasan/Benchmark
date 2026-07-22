<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use Closure;
use InvalidArgumentException;

/* ------------------------------------------------------------------ */
/*  Immutable DTO with optional Docker-stats fields                   */

/* ------------------------------------------------------------------ */

final class BenchmarkConfig
{
    public const MAX_COUNT = 1_000_000;
    public const MAX_THREADS = 1_000;
    public const MAX_TIMEOUT_SECONDS = 3_600;
    public const MAX_PHASE_DURATION_SECONDS = 600;

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
    private Closure $responseValidator;

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
        ?float $sampleEvery = null,

        array $curlOptions = [],
        ?string $name = null,
        bool $skipPreflight = false,
        ?callable $responseValidator = null,
    ) {
        /* ---------- basic validation ---------- */
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid URL: {$url}");
        }
        if ($expectedStatus < 100 || $expectedStatus >= 500) {
            throw new InvalidArgumentException("Invalid expected status: {$expectedStatus}");
        }
        if ($threads !== null && ($threads < 2 || $threads > self::MAX_THREADS)) {
            throw new InvalidArgumentException(sprintf('Threads must be between 2 and %d', self::MAX_THREADS));
        }
        if ($count !== null && ($count < 100 || $count > self::MAX_COUNT)) {
            throw new InvalidArgumentException(sprintf('Count must be between 100 and %d', self::MAX_COUNT));
        }
        if ($threads !== null && $count !== null && $count < $threads) {
            throw new InvalidArgumentException("Count ({$count}) must be ≥ threads ({$threads})");
        }
        if ($timeout !== null && ($timeout < 1 || $timeout > self::MAX_TIMEOUT_SECONDS)) {
            throw new InvalidArgumentException(sprintf('Timeout must be between 1 and %d seconds', self::MAX_TIMEOUT_SECONDS));
        }
        if ($sampleEvery !== null && $sampleEvery < 1) {
            throw new InvalidArgumentException('sampleEvery must be ≥ 1 second');
        }
        if ($responseValidator === null) {
            throw new InvalidArgumentException('A response validator is required so only correct responses count as successful');
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
        $this->responseValidator = Closure::fromCallable($responseValidator);
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

    /** @return Closure(string, array<string, mixed>):bool */
    public function getResponseValidator(): Closure
    {
        return $this->responseValidator;
    }
}
