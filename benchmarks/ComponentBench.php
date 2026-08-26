<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark\Benchmarks;

use AbmmHasan\Benchmark\BenchmarkConfig;
use AbmmHasan\Benchmark\HttpMethod;
use AbmmHasan\Benchmark\PipingMode;
use AbmmHasan\Benchmark\UnitBenchmark;
use PhpBench\Attributes as Bench;

#[Bench\OutputMode('throughput')]
#[Bench\OutputTimeUnit('seconds', 2)]
final class ComponentBench
{
    #[Bench\Subject]
    public function benchResolvedConfigurationConstruction(): void
    {
        new BenchmarkConfig(
            url: 'https://service.example.test/health',
            method: HttpMethod::GET,
            headers: ['Accept' => 'application/json'],
            expectedStatus: 200,
            threads: 100,
            count: 5_000,
            piping: PipingMode::Optimal,
            timeout: 10,
            name: 'service',
            responseValidator: static fn(string $body): bool => $body !== '',
        );
    }

    #[Bench\Subject]
    public function benchUnitBenchmarkLifecycle(): void
    {
        UnitBenchmark::start();
        UnitBenchmark::snapshot();
        UnitBenchmark::end();
    }
}
