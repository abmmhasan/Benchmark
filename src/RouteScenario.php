<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use Closure;
use InvalidArgumentException;

/** One request shape in a target's evenly distributed route workload. */
final readonly class RouteScenario
{
    private Closure $responseValidator;
    private bool $safeForWarmUp;

    public function __construct(
        private string $key,
        private string $label,
        private string $url,
        private HttpMethod $method,
        private int $expectedStatus,
        callable $responseValidator,
        ?bool $safeForWarmUp = null,
        private ?string $pattern = null,
    ) {
        if (preg_match('/^[a-z][a-z0-9-]{0,63}$/', $key) !== 1) {
            throw new InvalidArgumentException("Invalid route scenario key: {$key}");
        }
        if (trim($label) === '') {
            throw new InvalidArgumentException('Route scenario label cannot be empty');
        }
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Invalid route scenario URL: {$url}");
        }
        if ($expectedStatus < 100 || $expectedStatus >= 500) {
            throw new InvalidArgumentException("Invalid route scenario status: {$expectedStatus}");
        }
        if ($pattern !== null && trim($pattern) === '') {
            throw new InvalidArgumentException('Route scenario pattern cannot be empty');
        }

        $this->responseValidator = Closure::fromCallable($responseValidator);
        $this->safeForWarmUp = $safeForWarmUp
            ?? in_array($method, [HttpMethod::GET, HttpMethod::HEAD], true);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): HttpMethod
    {
        return $this->method;
    }

    public function getExpectedStatus(): int
    {
        return $this->expectedStatus;
    }

    /** @return Closure(string, array<string, mixed>):bool */
    public function getResponseValidator(): Closure
    {
        return $this->responseValidator;
    }

    public function isSafeForWarmUp(): bool
    {
        return $this->safeForWarmUp;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }
}
