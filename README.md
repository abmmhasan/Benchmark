# Benchmark

A framework-agnostic PHP 8.4 HTTP benchmarking library. It counts only responses
that complete successfully, match the expected status, and pass a caller-supplied
body validator.

## Usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use AbmmHasan\Benchmark\BenchmarkConfig;
use AbmmHasan\Benchmark\BenchmarkRunner;

$config = new BenchmarkConfig(
    url: 'https://service.example.test/health',
    name: 'service',
    responseValidator: static function (string $body): bool {
        $json = json_decode($body, true);
        return is_array($json) && ($json['status'] ?? null) === 'ok';
    },
);

$results = BenchmarkRunner::make()
    ->threads(100)
    ->count(5_000)
    ->minimumDuration(10)
    ->timeout(10)
    ->repetitions(3)
    ->concurrencyLevels(2, 25, 50, 100)
    ->warmUpRequests(10)
    ->addConfigs($config)
    ->runAll('json');

echo $results;
```

The default concurrency curve is derived from the configured maximum when
`concurrencyLevels()` is omitted. Each target is measured at every level for at
least three repetitions. Concurrent phases continue for at least the configured
minimum duration, subject to the hard request safety limit. Ranking uses the peak
median validated requests per minute from phases that reached that duration.

Automatic warm-up is limited to GET and HEAD. Preflight always uses a bodyless
HEAD probe, so configured POST, PUT, PATCH, and DELETE operations are not executed
outside the measured workload. Set `skipPreflight: true` when a target cannot
accept HEAD.

When `container` is configured, the runner restarts it, waits for Docker's running
state, then uses the safe HTTP preflight as the application-readiness gate. Docker
CPU and memory measurements stream concurrently with benchmark traffic.

Before measuring any candidate, the runner performs a fail-fast validation pass
over every configured target. It verifies connectivity for all targets and, for
GET/HEAD targets, requires one unmeasured request to match both the expected HTTP
status and response validator. Mutating methods are not executed during this pass.

## Terminal progress and reports

Termwind and Symfony Console render a dedicated progress line for each benchmark
configuration. Progress combines completed request iterations and the configured
minimum phase duration, so a duration-bound concurrency phase does not appear
complete while it is still collecting steady-state traffic.

Progress is written only to standard error. Redirecting a report therefore keeps
the output file clean while progress remains visible:

```bash
php index.php > benchmark.md
```

The Markdown report is organized for side-by-side comparison. Every concurrency
level gets separate throughput, latency, and reliability tables, while serial
measurements remain in their own latency and reliability tables. Configuration
differences are pivoted by target. Shared settings, runtime environment, and
optional container resources remain separate. JSON is the canonical
machine-readable output and CSV remains available for flat data-processing
workflows.

## Result interpretation

Results include:

- validated RPS and RPM;
- attempted and successful request counts;
- transfer, timeout, status, and response-validation failures;
- p50, p95, and p99 successful-response latency;
- raw repetitions and a concurrency throughput curve;
- minimum, maximum, median absolute deviation, and spread for repeated RPM;
- benchmark configuration and runtime metadata;
- average and peak container CPU/memory when enabled.

Treat differences smaller than normal observed variance as inconclusive. Use the
JSON output when preserving full raw runs and reproduction metadata.

## Development checks

```bash
composer check
```

PHPBench covers isolated component overhead for the library itself:

```bash
composer bench:quick
composer bench
```

These microbenchmarks report operations per second for library operations. They do
not establish application-level HTTP capacity; use `BenchmarkRunner` and its
validated sustained RPM for end-to-end comparisons.
