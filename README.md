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
    ->stabilityThreshold(5)
    ->concurrencyLevels(2, 25, 50, 100)
    ->warmUpRequests(10)
    ->addConfigs($config)
    ->runAll('json');

echo $results;
```

## Self-contained framework benchmarks

The repository includes its own framework suite under `frameworks/`; the sibling
`PHP-Frameworks-Bench` checkout is no longer required.

`setup` and `update` recreate targets from the newest stable Composer project
release compatible with the current PHP runtime.

Each `frameworks/<target>/` directory is a benchmark-owned wrapper. Composer
installs the framework application into its ignored `asset/` directory, while
`.gitignore` and `_benchmark/` remain at the wrapper root. The generated
framework therefore keeps its own `.gitignore` inside `asset/` without replacing
or affecting the benchmark definition.

The bundled targets are `cakephp`, `codeigniter`, `fatfree`, `flight`,
`infbyte`, `kumbia`, `laravel`, `laravel-api`, `leaf`, `lumen`, `nette`,
`pure-php`, `slim`, `symfony`, and `yii-basic`. The API target remains separate
because it measures Laravel's API routing/JSON response path rather than its web
route. Dashboard classifications are defined in `frameworks/config`: Full Stack
or Micro by framework type, and MVC/HMVC or Component-Based by architecture.
Pure PHP remains a separate comparison baseline.

### Run all targets

Omitting `--target` selects every framework listed in `frameworks/config`.

#### Generate

```bash
# Create every framework application from its latest compatible release.
composer benchmark:frameworks -- setup --force

# Later, recreate every application from the latest compatible release.
composer benchmark:frameworks -- update --force

# Start the bundled Apache server on an automatically selected free port.
composer benchmark:frameworks -- docker

# Validate every endpoint before measurement.
composer benchmark:frameworks -- check

# Benchmark every configured framework.
composer benchmark:frameworks -- run
```

#### View results

```bash
# List archived runs and regenerate the newest visual dashboard.
composer benchmark:frameworks -- list
composer benchmark:frameworks -- dashboard --run=0
```

#### Clean

```bash
# Stop and remove the bundled benchmark server.
composer benchmark:frameworks -- docker-stop

# Remove every generated application while preserving benchmark scripts.
composer benchmark:frameworks -- clean --force
```

### Manual targets

Start by inspecting the environment and validating target responses:

```bash
composer benchmark:frameworks -- doctor
composer benchmark:frameworks -- setup --target=slim,symfony,laravel-api --force
composer benchmark:frameworks -- check --target=slim,symfony,laravel-api
```

Run using the built-in PHP load generator:

```bash
composer benchmark:frameworks -- \
  --target=slim,symfony,laravel-api \
  --connections=250 \
  --concurrency=10,50,100,250 \
  --count=5000 \
  --duration=30
```

The integration understands both response shapes used by the fixture project:
`Hello World!` and its JSON equivalent, followed by the memory, execution-time,
and included-files telemetry suffix. Every measured response must have the
expected HTTP status, valid body, and valid telemetry. Remote peak-memory bytes
are imported into the report. Server execution time and included-file counts are
reported separately from end-to-end libcurl latency.

The suite base URL, duration, connection count, and unversioned target list are
defined in `frameworks/config`. Use `--suite` only to exercise a compatible
external suite. `connections` maps to this runner's maximum
concurrency for the built-in PHP load generator.

Framework folders are not auto-discovered. A target must be listed in
`frameworks/config` and provide `_benchmark/hello_world.sh`; the config controls
which targets run and in what order.

Results are printed as Markdown and archived under `.benchmark-output/<UTC time>/`
as canonical `results.json`, `report.md`, and an interactive Bootstrap 5.3.8
`dashboard.html`. The history root also gets an `index.html` linking all runs.
Browser reports display dates using the visitor's locale and time zone; CLI
history listings use a human-readable UTC format. Pass `--no-archive` to disable
files. Each artifact records the target web server's PHP version, SAPI, loaded
configuration, and actual OPcache/JIT settings separately from the CLI load
generator environment.

The `Framework benchmarks` GitHub Actions workflow runs on day 1 of every month,
after non-docs changes land on `main`, or manually. It uses a 10% RPM stability
threshold and opens or updates a pull request containing the generated `docs/`
reports instead of committing directly to `main`. After the results PR is
reviewed and merged, the separate `Benchmark Pages` workflow deploys `docs/` to
GitHub Pages. Set the repository's Pages source to **GitHub Actions** and enable
**Allow GitHub Actions to create and approve pull requests** in the repository
Actions settings. Published docs retain one result per UTC calendar month; a
newer result replaces the earlier result from that month, with at most 61 monthly
records retained.

### Framework lifecycle and runtime preparation

Use `--target` to limit scope. Setup, update, and cleanup replace generated files
and therefore require `--force`; every command supports `--dry-run`:

```bash
composer benchmark:frameworks -- setup --target=slim --dry-run
composer benchmark:frameworks -- setup --target=slim --force
composer benchmark:frameworks -- update --target=slim --force
composer benchmark:frameworks -- clear-cache --target=slim
composer benchmark:frameworks -- clean --target=slim --force
```

Fresh-install mode composes cleanup, setup, validation, and measurement:

```bash
composer benchmark:frameworks -- run --target=slim --fresh --force
```

Cache clearing, service restarts, and OPCache reset can run before every target
repetition, outside the measurement window:

```bash
composer benchmark:frameworks -- run \
  --clear-cache \
  --service=apache,php-fpm \
  --reset-opcache
```

Standalone runtime commands are also available:

```bash
composer benchmark:frameworks -- restart --service=nginx,php-fpm --dry-run
composer benchmark:frameworks -- reset-opcache
composer benchmark:frameworks -- disable-fastcgi --dry-run
composer benchmark:frameworks -- disable-fastcgi --force
composer benchmark:frameworks -- docker --dry-run
composer benchmark:frameworks -- docker
composer benchmark:frameworks -- docker-stop
```

`disable-fastcgi` reads the web server's loaded `php.ini`, creates a
`.benchmark.bak` backup, and requires appropriate local filesystem permissions.
Restart PHP-FPM afterward. Docker mode builds the bundled suite's Apache image,
mounts `frameworks/` at `/var/www/html/frameworks`, and starts a named container
in the background. By default Docker publishes Apache on an available ephemeral
loopback port and records the resulting base URL in the ignored
`frameworks/.benchmark-server.json` file. Later `doctor`, `check`, and `run`
commands load that URL automatically. Pass `--port=N` only when a fixed port is
required. The static URL in `frameworks/config` is only a fallback for a manually
managed web server; it is not used while the Docker runtime file exists.

### Results history and dashboard

```bash
composer benchmark:frameworks -- list
composer benchmark:frameworks -- compare --current=0 --baseline=1
composer benchmark:frameworks -- dashboard --run=0
composer benchmark:frameworks -- delete --run=0 --force
composer benchmark:frameworks -- delete-all --force
```

Indexes use newest-first ordering, so `0` means the latest run. Timestamp
identifiers printed by `list` are also accepted. Comparison reports include stable
and peak RPM, latency, error rate, remote memory, server execution time, and
included-file changes for common targets.

Inspect every command and option with:

```bash
php bin/framework-benchmark --help
```

The native PHP/libcurl engine is the default because it has no extra executable
dependency and can validate every response body. For very high-throughput local
targets, verify that the load-generator host is not saturated. A second run from
another machine with a compiled generator such as `oha` is a useful capacity
cross-check, but its status-based summary is not a substitute for this library's
per-response application-level validation.

The default concurrency curve is derived from the configured maximum when
`concurrencyLevels()` is omitted. Repetitions are configurable from one to three
and default to three. Target and concurrency order rotate between repetitions to
reduce time and phase-order bias. Targets are always benchmarked sequentially:
the runner completely awaits one target before sending benchmark traffic to the
next target. Concurrent phases continue for at least the configured minimum
duration, subject to the hard request safety limit.

With two or three repetitions, a concurrency level is stable only when its RPM
spread is within `stabilityThreshold()` (5% by default). Unstable levels remain in
the report, but only the fastest stable level contributes to the sustainable
ranking. The summary also reports each target's fastest observed median and its
stability independently. A target with no stable level therefore keeps its peak
visible without receiving a sustainable rank. One-repetition results are
explicitly marked unverified and are not treated as stable.

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
complete while it is still collecting measurement-window traffic. Inactive target
lines are explicitly labelled `waiting`; they do not represent concurrent load.

Progress is written only to standard error. Redirecting a report therefore keeps
the output file clean while progress remains visible:

```bash
php index.php > benchmark.md
```

The Markdown report is organized for side-by-side comparison. Every concurrency
level gets separate throughput, latency, and reliability tables, while serial
measurements remain in their own latency and reliability tables. Configuration
differences are pivoted by target. Shared settings, target-server OPcache
configuration, load-generator environment, and optional resource telemetry remain separate. JSON is the canonical
machine-readable output and CSV remains available for flat data-processing
workflows.

Use `formatResults()` to render already collected array results in another format
without sending the benchmark traffic a second time:

```php
$results = $runner->runAll();
$markdown = $runner->formatResults($results, 'table');
$json = $runner->formatResults($results, 'json');
```

The first table is a sustainable ranking rather than a peak-throughput ranking.
It shows the best stable RPM and concurrency beside the peak observed RPM,
concurrency, and stability. Stable targets are ranked first by sustainable RPM;
targets with only unstable or unverified measurements remain unranked and follow
in peak-RPM order. Compare targets at the same concurrency in the detailed tables
when capacity curves differ.

Each throughput table includes the individual run RPM values, total spread, and
stability decision so an outlier cannot be hidden by the median.
Comparison rows are ordered best to worst: highest RPM for throughput, lowest p50
for latency, and lowest error rate for reliability. Resource and configuration
comparisons follow overall benchmark rank because resource usage alone does not
define the fastest sustainable target.

Response-memory telemetry is optional and has no implicit JSON contract. Supply a
callback only when the response exposes memory usage; return bytes or `null`:

```php
$config = new BenchmarkConfig(
    url: 'https://service.example.test/health',
    name: 'service',
    responseValidator: static fn(string $body): bool => $body !== '',
    responseMemoryExtractor: static function (string $body): int|float|null {
        $json = json_decode($body, true);
        return is_array($json) && is_numeric($json['memory'] ?? null)
            ? (float) $json['memory']
            : null;
    },
);
```

## Result interpretation

Results include:

- best stable RPM, fastest observed RPM, and their concurrency levels;
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
