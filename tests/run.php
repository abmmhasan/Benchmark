<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark {
    final class FakeCurl
    {
        public static string $response = '{"ok":true}';
        public static int $status = 200;
        public static int $result = CURLE_OK;
        public static array $lastOptions = [];
        public static int $execCount = 0;

        public static function reset(): void
        {
            self::$response = '{"ok":true}';
            self::$status = 200;
            self::$result = CURLE_OK;
            self::$lastOptions = [];
            self::$execCount = 0;
        }
    }

    function curl_init(): object
    {
        return (object) ['options' => []];
    }

    function curl_setopt_array(object $handle, array $options): bool
    {
        $handle->options = $options;
        FakeCurl::$lastOptions = $options;
        return true;
    }

    function curl_exec(object $handle): string|false
    {
        ++FakeCurl::$execCount;
        return FakeCurl::$result === CURLE_OK ? FakeCurl::$response : false;
    }

    function curl_getinfo(object $handle, ?int $option = null): array|int|float
    {
        if ($option === CURLINFO_HTTP_CODE) {
            return FakeCurl::$status;
        }

        return [
            'http_code' => FakeCurl::$status,
            'connect_time' => 0.0001,
            'starttransfer_time' => 0.0005,
            'total_time' => 0.001,
        ];
    }

    function curl_errno(object $handle): int { return FakeCurl::$result; }
    function curl_error(object $handle): string { return FakeCurl::$result === CURLE_OK ? '' : 'fake error'; }
    function curl_close(object $handle): void {}
    function curl_reset(object $handle): void { $handle->options = []; }

    function curl_multi_init(): object { return (object) ['queue' => []]; }
    function curl_multi_setopt(object $multi, int $option, mixed $value): bool { return true; }

    function curl_multi_add_handle(object $multi, object $handle): int
    {
        $multi->queue[] = $handle;
        return CURLM_OK;
    }

    function curl_multi_exec(object $multi, ?int &$running): int
    {
        $running = $multi->queue === [] ? 0 : 1;
        return CURLM_OK;
    }

    function curl_multi_select(object $multi, float $timeout): int { return 1; }

    function curl_multi_info_read(object $multi): array|false
    {
        $handle = array_shift($multi->queue);
        return $handle === null
            ? false
            : ['handle' => $handle, 'result' => FakeCurl::$result];
    }

    function curl_multi_getcontent(object $handle): string|false { return FakeCurl::$response; }
    function curl_multi_remove_handle(object $multi, object $handle): int { return CURLM_OK; }
    function curl_multi_close(object $multi): void {}
}

namespace {
    use AbmmHasan\Benchmark\BenchmarkConfig;
    use AbmmHasan\Benchmark\BenchmarkHistory;
    use AbmmHasan\Benchmark\BenchmarkRunner;
    use AbmmHasan\Benchmark\ContainerStats;
    use AbmmHasan\Benchmark\FakeCurl;
    use AbmmHasan\Benchmark\HttpMethod;
    use AbmmHasan\Benchmark\PipingMode;
    use AbmmHasan\Benchmark\PhpFrameworksBenchSuite;
    use AbmmHasan\Benchmark\PhpFrameworksBenchManager;
    use AbmmHasan\Benchmark\RequestBenchmark;
    use AbmmHasan\Benchmark\UnitBenchmark;

    require dirname(__DIR__) . '/vendor/autoload.php';

    $tests = 0;

    $assert = static function (bool $condition, string $message) use (&$tests): void {
        ++$tests;
        if (!$condition) {
            throw new RuntimeException("Assertion failed: {$message}");
        }
    };

    $expectException = static function (string $class, callable $callback, string $message) use ($assert): void {
        try {
            $callback();
        } catch (Throwable $exception) {
            $assert($exception instanceof $class, $message . ' (wrong exception: ' . $exception::class . ')');
            return;
        }
        $assert(false, $message . ' (no exception)');
    };

    $validator = static fn(string $body): bool => $body === '{"ok":true}';
    $resolvedConfig = static fn(array $overrides = []): BenchmarkConfig => new BenchmarkConfig(
        url: $overrides['url'] ?? 'http://example.test',
        method: $overrides['method'] ?? HttpMethod::GET,
        body: $overrides['body'] ?? null,
        threads: $overrides['threads'] ?? 2,
        count: $overrides['count'] ?? 100,
        piping: $overrides['piping'] ?? PipingMode::Optimal,
        timeout: $overrides['timeout'] ?? 1,
        name: $overrides['name'] ?? 'test',
        skipPreflight: $overrides['skipPreflight'] ?? true,
        responseValidator: $overrides['validator'] ?? $validator,
        responseMemoryExtractor: $overrides['memoryExtractor'] ?? null,
        responseMetricsExtractor: $overrides['metricsExtractor'] ?? null,
    );

    $assert(enum_exists(HttpMethod::class), 'HttpMethod autoloads directly');
    $assert(enum_exists(PipingMode::class), 'PipingMode autoloads directly');

    $expectException(
        InvalidArgumentException::class,
        static fn() => new BenchmarkConfig('http://example.test'),
        'response validation is mandatory',
    );
    $expectException(
        InvalidArgumentException::class,
        static fn() => new BenchmarkConfig('http://example.test', timeout: 0, responseValidator: $validator),
        'unbounded timeout is rejected',
    );

    $rawConfig = new BenchmarkConfig(
        'http://example.test',
        responseValidator: $validator,
    );
    $runner = BenchmarkRunner::make()->threads(2)->count(100)->sampleEvery(7);
    $applyDefaults = new ReflectionMethod($runner, 'applyDefaults');
    $defaulted = $applyDefaults->invoke($runner, $rawConfig);
    $assert($defaulted->getSampleInterval() === 7.0, 'runner sampling default is applied');
    $expectException(
        InvalidArgumentException::class,
        static fn() => BenchmarkRunner::make()->repetitions(4),
        'repetitions are capped at three',
    );

    $duplicateRunner = BenchmarkRunner::make();
    $duplicateRunner->addConfigs($resolvedConfig(['name' => 'duplicate']));
    $expectException(
        InvalidArgumentException::class,
        static fn() => $duplicateRunner->addConfigs($resolvedConfig(['name' => 'duplicate'])),
        'duplicate names are rejected',
    );

    $invalidBodyConfig = $resolvedConfig(['method' => HttpMethod::POST, 'body' => ['bad' => "\xB1"]]);
    $prepareOptions = new ReflectionMethod(new RequestBenchmark($invalidBodyConfig), 'prepareOptions');
    $expectException(
        JsonException::class,
        static fn() => $prepareOptions->invoke(new RequestBenchmark($invalidBodyConfig)),
        'malformed JSON request bodies fail safely',
    );

    FakeCurl::reset();
    $postConfig = $resolvedConfig([
        'method' => HttpMethod::POST,
        'body' => ['write' => true],
        'skipPreflight' => false,
    ]);
    (new RequestBenchmark($postConfig))->preflight();
    $assert(FakeCurl::$lastOptions[CURLOPT_CUSTOMREQUEST] === 'HEAD', 'preflight forces HEAD');
    $assert(FakeCurl::$lastOptions[CURLOPT_NOBODY] === true, 'preflight is bodyless');
    $assert(!isset(FakeCurl::$lastOptions[CURLOPT_POSTFIELDS]), 'preflight removes configured request body');

    FakeCurl::reset();
    FakeCurl::$status = 503;
    $expectException(
        RuntimeException::class,
        static fn() => (new RequestBenchmark($resolvedConfig(['skipPreflight' => false])))->preflight(),
        'preflight rejects server-side not-ready responses',
    );
    FakeCurl::$status = 405;
    (new RequestBenchmark($resolvedConfig(['skipPreflight' => false])))->preflight();
    $assert(true, 'preflight allows endpoints that reject HEAD without a server failure');

    FakeCurl::reset();
    FakeCurl::$response = '{"wrong":true}';
    $invalidResponse = new RequestBenchmark($resolvedConfig());
    $serial = $invalidResponse->runSingleThreaded();
    $assert($serial['successful_requests'] === 0, 'invalid serial responses are not successful');
    $assert($serial['validation_failures'] === 100, 'serial validation failures are counted');
    $concurrent = $invalidResponse->runConcurrent(2);
    $assert($concurrent['successful_requests'] === 0, 'invalid concurrent responses are not successful');
    $assert($concurrent['validation_failures'] === 100, 'concurrent validation failures are counted');

    FakeCurl::reset();
    FakeCurl::$result = CURLE_PARTIAL_FILE;
    $transferFailure = (new RequestBenchmark($resolvedConfig()))->runConcurrent(2);
    $assert($transferFailure['successful_requests'] === 0, 'partial concurrent transfers are not successful');
    $assert($transferFailure['transfer_errors'] === 100, 'concurrent transfer errors are counted');

    FakeCurl::reset();
    $progressUpdates = [];
    $progressBenchmark = new RequestBenchmark(
        $resolvedConfig(),
        static function (
            int $completed,
            int $minimumRequests,
            float $elapsed,
            float $minimumDuration,
            string $phase,
        ) use (&$progressUpdates): void {
            $progressUpdates[] = compact(
                'completed',
                'minimumRequests',
                'elapsed',
                'minimumDuration',
                'phase',
            );
        },
    );
    $progressBenchmark->runSingleThreaded();
    $steady = $progressBenchmark->runConcurrent(2, 0.001);
    $assert($steady['minimum_window_reached'] === true, 'concurrent phases honor minimum duration');
    $assert($steady['attempted_requests'] >= 100, 'minimum request count is preserved');
    $lastProgress = $progressUpdates[array_key_last($progressUpdates)];
    $assert($lastProgress['completed'] >= 100, 'progress reports completed iterations');
    $assert($lastProgress['phase'] === 'concurrency 2', 'progress identifies the active phase');

    FakeCurl::reset();
    $withoutMemoryExtractor = new RequestBenchmark($resolvedConfig());
    $withoutMemoryExtractor->runSingleThreaded();
    $assert($withoutMemoryExtractor->getRemoteMemoryMB() === null, 'response memory extraction is opt-in');
    $withMemoryExtractor = new RequestBenchmark($resolvedConfig([
        'memoryExtractor' => static fn(string $body): int => 1_048_576,
    ]));
    $withMemoryExtractor->runSingleThreaded();
    $assert($withMemoryExtractor->getRemoteMemoryMB() === 1.0, 'optional response memory is measured in bytes');
    $withMetricsExtractor = new RequestBenchmark($resolvedConfig([
        'metricsExtractor' => static fn(string $body): array => [
            'server_execution_ms' => 1.25,
            'included_files' => 17,
            'Invalid Name' => 99,
            'negative' => -1,
        ],
    ]));
    $withMetricsExtractor->runSingleThreaded();
    $remoteMetrics = $withMetricsExtractor->getRemoteMetrics();
    $assert(
        $remoteMetrics['server_execution_ms']['average'] === 1.25
        && $remoteMetrics['included_files']['average'] === 17.0,
        'generic response metrics are aggregated',
    );
    $assert(
        !isset($remoteMetrics['Invalid Name'], $remoteMetrics['negative']),
        'invalid response metrics are ignored safely',
    );

    FakeCurl::reset();
    $failFastRunner = BenchmarkRunner::make()
        ->warmUpRequests(0)
        ->minimumDuration(0)
        ->addConfigs(
            $resolvedConfig(['name' => 'valid-target', 'skipPreflight' => false]),
            $resolvedConfig([
                'name' => 'invalid-target',
                'skipPreflight' => false,
                'validator' => static fn(string $body): bool => false,
            ]),
        );
    $expectException(
        RuntimeException::class,
        static fn() => $failFastRunner->runAll(),
        'all targets are validated before benchmark measurement begins',
    );
    $assert(FakeCurl::$execCount === 4, 'fail-fast target validation performs no benchmark traffic');

    FakeCurl::reset();
    $preparedRepetitions = [];
    $perConfigRunner = BenchmarkRunner::make()
        ->warmUpRequests(0)
        ->minimumDuration(0)
        ->stabilityThreshold(10_000)
        ->beforeRepetition(static function (BenchmarkConfig $config, int $run) use (&$preparedRepetitions): void {
            $preparedRepetitions[] = [$config->getName(), $run];
        })
        ->addConfigs(
            $resolvedConfig(['threads' => 4, 'name' => 'per-config']),
            $resolvedConfig(['threads' => 4, 'name' => 'rotation-target']),
        );
    $results = $perConfigRunner->runAll();
    $result = $results['per-config'];
    $assert(
        count($preparedRepetitions) === 6
        && $preparedRepetitions[0] === ['per-config', 1],
        'runtime preparation hooks run before every target repetition',
    );
    $assert(count($result['runs']) === 3, 'three repeated runs are recorded');
    $assert(array_keys($result['throughputCurve']) === [2, 4], 'default concurrency curve is recorded');
    $assert($result['score'] === $result['stable']['req_per_min'], 'ranking score is stable RPM');
    $assert(
        $result['peak']['req_per_min'] >= $result['stable']['req_per_min'],
        'peak observation is retained separately from sustainable throughput',
    );
    $assert(isset($result['multiple']['req_per_min_mad']), 'repeated-run RPM variance is recorded');
    $assert($result['configuration']['responseValidation'] === true, 'reproduction metadata is recorded');
    $assert(
        $result['configuration']['loadGenerator'] === 'php-curl-multi',
        'load-generator implementation is recorded',
    );
    $assert(
        array_key_exists('cliOpcacheEnabled', $result['configuration'])
        && array_key_exists('cliOpcacheJit', $result['configuration'])
        && !array_key_exists('opcacheEnabled', $result['configuration']),
        'load-generator OPcache metadata is explicitly labeled as CLI configuration',
    );
    $assert(
        $result['runs'][0]['targetOrder'] === ['per-config', 'rotation-target']
        && $result['runs'][1]['targetOrder'] === ['rotation-target', 'per-config'],
        'target order rotates between repetitions',
    );
    $assert(
        $result['runs'][0]['concurrencyOrder'] === [2, 4]
        && $result['runs'][1]['concurrencyOrder'] === [4, 2],
        'concurrency order rotates between repetitions',
    );
    $assert($result['rankingStatus'] === 'stable', 'stable results remain rankable');

    $toMarkdownTable = new ReflectionMethod($perConfigRunner, 'toMarkdownTable');
    $markdown = $toMarkdownTable->invoke($perConfigRunner, $results);
    $assert(
        str_contains($markdown, '## Sustainable ranking'),
        'Markdown output has a sustainable ranking group',
    );
    $assert(
        str_contains($markdown, '## Throughput — concurrency 2')
        && str_contains($markdown, '## Throughput — concurrency 4'),
        'each concurrency level has its own comparison table',
    );
    $assert(
        str_contains($markdown, '## Latency — serial')
        && str_contains($markdown, '## Latency — concurrency 2')
        && str_contains($markdown, '## Latency — concurrency 4'),
        'each latency concurrency has its own comparison table',
    );
    $assert(
        str_contains($markdown, '## Reliability — serial')
        && str_contains($markdown, '## Reliability — concurrency 2')
        && str_contains($markdown, '## Reliability — concurrency 4'),
        'each reliability concurrency has its own comparison table',
    );
    $assert(str_contains($markdown, '## Common configuration'), 'common configuration has its own table');
    $assert(
        str_contains($markdown, '## Load-generator environment'),
        'load-generator runtime details have their own table',
    );
    $assert(
        str_contains($markdown, 'CLI OPcache enabled')
        && !str_contains($markdown, '| Opcache enabled |'),
        'Markdown explicitly labels load-generator OPcache as CLI configuration',
    );
    $assert(
        str_contains($markdown, '## Target-specific configuration'),
        'target-specific configuration has its own table',
    );
    $assert(!str_contains($markdown, 'configuration.'), 'Markdown avoids flattened configuration keys');
    $assert(!str_contains($markdown, '| RPS |'), 'derived RPS is not duplicated beside RPM');
    $assert(
        str_contains($markdown, 'Run 1 RPM') && str_contains($markdown, 'Run 3 RPM'),
        'per-run RPM remains visible',
    );
    preg_match('/## Sustainable ranking\R\R(?<table>.*?)(?=\R\R## )/s', $markdown, $summaryMatch);
    $assert(
        !str_contains($summaryMatch['table'] ?? '', 'RPS')
        && !str_contains($summaryMatch['table'] ?? '', 'p99'),
        'ranking does not repeat detailed throughput or latency fields',
    );
    $assert(
        str_contains($summaryMatch['table'] ?? '', 'Best stable RPM')
        && str_contains($summaryMatch['table'] ?? '', 'Peak observed RPM'),
        'ranking distinguishes sustainable throughput from an observed peak',
    );

    $groupData = ['slow' => $result, 'fast' => $result];
    $groupData['slow']['name'] = 'slow';
    $groupData['slow']['rank'] = 2;
    $groupData['slow']['score'] = 100.0;
    $groupData['slow']['stable']['req_per_min'] = 100.0;
    $groupData['slow']['stable']['concurrency'] = 2;
    $groupData['slow']['peak']['req_per_min'] = 300.0;
    $groupData['slow']['peak']['concurrency'] = 2;
    $groupData['slow']['peak']['rpm_stability'] = 'unstable';
    $groupData['slow']['configuration']['url'] = 'http://slow.example.test';
    $groupData['slow']['throughputCurve'][2]['req_per_min'] = 300.0;
    $groupData['slow']['single']['p50'] = 0.04;
    $groupData['slow']['single']['error_rate'] = 0.0;
    $groupData['fast']['name'] = 'fast';
    $groupData['fast']['rank'] = 1;
    $groupData['fast']['score'] = 200.0;
    $groupData['fast']['stable']['req_per_min'] = 200.0;
    $groupData['fast']['stable']['concurrency'] = 2;
    $groupData['fast']['peak']['req_per_min'] = 200.0;
    $groupData['fast']['peak']['concurrency'] = 2;
    $groupData['fast']['peak']['rpm_stability'] = 'stable';
    $groupData['fast']['configuration']['url'] = 'http://fast.example.test';
    $groupData['fast']['throughputCurve'][2]['req_per_min'] = 200.0;
    $groupData['fast']['single']['p50'] = 0.02;
    $groupData['fast']['single']['error_rate'] = 0.1;
    $groupData['unsteady'] = $result;
    $groupData['unsteady']['name'] = 'unsteady';
    $groupData['unsteady']['rank'] = null;
    $groupData['unsteady']['score'] = null;
    $groupData['unsteady']['stable'] = null;
    $groupData['unsteady']['peak']['req_per_min'] = 400.0;
    $groupData['unsteady']['peak']['concurrency'] = 4;
    $groupData['unsteady']['peak']['rpm_stability'] = 'unstable';
    $groupData['unsteady']['configuration']['url'] = 'http://unsteady.example.test';
    $groupConfiguration = new ReflectionMethod(BenchmarkRunner::class, 'groupConfiguration');
    [$commonConfiguration, $specificConfiguration] = $groupConfiguration->invoke(null, $groupData);
    $assert(isset($commonConfiguration['method']), 'identical configuration is grouped once');
    $assert(
        isset(
            $specificConfiguration['slow']['url'],
            $specificConfiguration['fast']['url'],
            $specificConfiguration['unsteady']['url'],
        ),
        'different target configuration remains per target',
    );
    $comparisonMarkdown = $toMarkdownTable->invoke($perConfigRunner, $groupData);
    $assert(
        str_contains($comparisonMarkdown, '| Setting | fast | slow | unsteady |'),
        'target-specific configuration follows overall benchmark rank',
    );
    $assert(!str_contains($comparisonMarkdown, '| Recorded at |'), 'timestamps are not presented as configuration');
    $groupData['fast']['remoteMemoryMB'] = 1.25;
    $groupData['fast']['remoteMetrics'] = [
        'server_execution_ms' => ['samples' => 100, 'average' => 1.25, 'minimum' => 1.0, 'maximum' => 2.0],
        'included_files' => ['samples' => 100, 'average' => 17.0, 'minimum' => 17.0, 'maximum' => 17.0],
    ];
    $resourceMarkdown = $toMarkdownTable->invoke($perConfigRunner, $groupData);
    $assert(
        str_contains($resourceMarkdown, '## Resource telemetry')
        && str_contains($resourceMarkdown, '| fast | 0 | — | — | — | — | 1.25 |'),
        'response memory is reported even when Docker telemetry is unavailable',
    );
    $assert(
        str_contains($resourceMarkdown, '## Server response telemetry')
        && str_contains($resourceMarkdown, '| fast | Server execution ms | 100 | 1.25000 |'),
        'generic server response telemetry is reported',
    );
    $assert(
        str_contains($resourceMarkdown, '## Relative comparison')
        && str_contains($resourceMarkdown, 'Peak throughput'),
        'relative throughput and resource comparisons are reported',
    );
    $tableSection = static function (string $markdown, string $title): string {
        preg_match(
            '/## ' . preg_quote($title, '/') . '\R\R(?<table>.*?)(?=\R\R## |\z)/s',
            $markdown,
            $match,
        );
        return $match['table'] ?? '';
    };
    $appearsBefore = static fn(string $table, string $first, string $second): bool =>
        strpos($table, "| {$first} |") < strpos($table, "| {$second} |");
    $assert(
        $appearsBefore($tableSection($comparisonMarkdown, 'Sustainable ranking'), 'fast', 'slow')
        && $appearsBefore($tableSection($comparisonMarkdown, 'Sustainable ranking'), 'slow', 'unsteady'),
        'stable targets rank by sustainable RPM before targets with only unstable observations',
    );
    $assert(
        str_contains(
            $tableSection($comparisonMarkdown, 'Sustainable ranking'),
            '| — | unsteady | — | — | 400 | 4 | Unstable |',
        ),
        'an unstable peak remains visible without receiving a sustainable rank',
    );
    $flatten = new ReflectionMethod($perConfigRunner, 'flatten');
    [, $flatRows] = $flatten->invoke($perConfigRunner, $groupData);
    $flatMetrics = array_column($flatRows, 0);
    $assert(
        in_array('stableRPM', $flatMetrics, true)
        && in_array('peakObservedRPM', $flatMetrics, true)
        && in_array('peakObservedStability', $flatMetrics, true),
        'flat reports expose stable and observed-peak measurements explicitly',
    );
    $assert(
        $appearsBefore($tableSection($comparisonMarkdown, 'Throughput — concurrency 2'), 'slow', 'fast'),
        'throughput rows are ordered by median RPM descending',
    );
    $assert(
        $appearsBefore($tableSection($comparisonMarkdown, 'Latency — serial'), 'fast', 'slow'),
        'latency rows are ordered by p50 ascending',
    );
    $assert(
        $appearsBefore($tableSection($comparisonMarkdown, 'Reliability — serial'), 'slow', 'fast'),
        'reliability rows are ordered by error rate ascending',
    );

    $medianMetrics = new ReflectionMethod(BenchmarkRunner::class, 'medianMetrics');
    $unstableMeasurements = [];
    foreach ([100.0, 101.0, 140.0] as $rpm) {
        $measurement = $steady;
        $measurement['req_per_min'] = $rpm;
        $unstableMeasurements[] = $measurement;
    }
    $unstable = $medianMetrics->invoke(null, $unstableMeasurements, 5.0);
    $assert($unstable['rpm_stability'] === 'unstable', 'spread beyond the threshold is marked unstable');
    $unverified = $medianMetrics->invoke(null, [$unstableMeasurements[0]], 5.0);
    $assert($unverified['rpm_stability'] === 'unverified', 'one repetition is explicitly unverified');

    $stabilityRuns = $result['runs'];
    foreach ([100.0, 101.0, 102.0] as $index => $rpm) {
        $stabilityRuns[$index]['concurrency'][2]['req_per_min'] = $rpm;
    }
    foreach ([200.0, 400.0, 800.0] as $index => $rpm) {
        $stabilityRuns[$index]['concurrency'][4]['req_per_min'] = $rpm;
    }
    $stabilityRunner = BenchmarkRunner::make()
        ->warmUpRequests(0)
        ->minimumDuration(0)
        ->stabilityThreshold(5);
    $aggregateConfig = new ReflectionMethod($stabilityRunner, 'aggregateConfig');
    $stableSelection = $aggregateConfig->invoke(
        $stabilityRunner,
        'stability-test',
        $resolvedConfig(['threads' => 4, 'name' => 'stability-test']),
        [2, 4],
        $stabilityRuns,
        [],
        1.0,
    );
    $assert(
        $stableSelection['multiple']['concurrency'] === 2,
        'an unstable faster concurrency is excluded from selection',
    );
    $assert(
        $stableSelection['stable']['concurrency'] === 2
        && $stableSelection['peak']['concurrency'] === 4,
        'stable and peak concurrency measurements remain independently visible',
    );
    foreach ([100.0, 200.0, 400.0] as $index => $rpm) {
        $stabilityRuns[$index]['concurrency'][2]['req_per_min'] = $rpm;
    }
    $inconclusive = $aggregateConfig->invoke(
        $stabilityRunner,
        'stability-test',
        $resolvedConfig(['threads' => 4, 'name' => 'stability-test']),
        [2, 4],
        $stabilityRuns,
        [],
        1.0,
    );
    $assert(
        $inconclusive['score'] === null
        && $inconclusive['stable'] === null
        && $inconclusive['peak'] === $inconclusive['multiple']
        && $inconclusive['rankingStatus'] === 'unstable',
        'a target with no stable concurrency keeps its observed peak without receiving a rank',
    );
    $unverified = $aggregateConfig->invoke(
        $stabilityRunner,
        'stability-test',
        $resolvedConfig(['threads' => 4, 'name' => 'stability-test']),
        [2, 4],
        [$stabilityRuns[0]],
        [],
        1.0,
    );
    $assert(
        $unverified['score'] === null
        && $unverified['stable'] === null
        && $unverified['rankingStatus'] === 'unverified',
        'a one-repetition observation remains visible without being treated as stable',
    );

    $unit = UnitBenchmark::run(static function (): int {
        $allocation = str_repeat('x', 1024 * 1024);
        UnitBenchmark::snapshot();
        return strlen($allocation);
    });
    $assert($unit['return'] === 1024 * 1024, 'unit benchmark returns callable result');
    $assert($unit['stats']['peakDiff'] > 0, 'unit benchmark resets and measures peak growth');

    UnitBenchmark::start();
    $expectException(
        LogicException::class,
        static fn() => UnitBenchmark::start(),
        'nested unit benchmarks are rejected',
    );
    UnitBenchmark::end();

    $expectException(
        RuntimeException::class,
        static fn() => UnitBenchmark::run(static fn() => throw new RuntimeException('expected')),
        'callable exceptions propagate',
    );
    $afterFailure = UnitBenchmark::run(static fn(): bool => true);
    $assert($afterFailure['return'] === true, 'unit benchmark state resets after exceptions');

    $suiteDirectory = sys_get_temp_dir() . '/benchmark-framework-suite-' . bin2hex(random_bytes(8));
    mkdir($suiteDirectory . '/alpha/_benchmark', 0777, true);
    mkdir($suiteDirectory . '/beta/_benchmark', 0777, true);
    mkdir($suiteDirectory . '/alpha/asset', 0777, true);
    mkdir($suiteDirectory . '/beta/asset/vendor/composer', 0777, true);
    mkdir($suiteDirectory . '/.docker', 0777, true);
    file_put_contents(
        $suiteDirectory . '/config',
        "base=\"http://127.0.0.1/bench\"\nduration=17\nconnections=42\n"
        . "frameworks_list=\"\nalpha\nbeta\n\"\n"
        . "framework_categories=\"\nalpha:full-stack\nbeta:micro\n\"\n"
        . "framework_architectures=\"\nalpha:component-based\nbeta:mvc-hmvc\n\"\n"
        . "framework_built_in_di=\"\nalpha:yes\nbeta:no\n\"\n"
        . "framework_full_featured_route_dispatchers=\"\nalpha:yes\nbeta:yes\n\"\n"
        . "framework_version_packages=\"\nalpha:vendor/alpha\nbeta:vendor/beta\n\"\n",
    );
    file_put_contents(
        $suiteDirectory . '/alpha/_benchmark/hello_world.sh',
        "#!/bin/sh\nurl=\"\$base/\$fw/public/index.php/hello/index\"\n",
    );
    file_put_contents(
        $suiteDirectory . '/beta/_benchmark/hello_world.sh',
        "#!/bin/sh\nurl=\"\$base/\$fw/web/index.php?r=hello/index\"\n",
    );
    file_put_contents($suiteDirectory . '/alpha/_benchmark/setup.sh', "#!/bin/sh\nexit 0\n");
    file_put_contents($suiteDirectory . '/alpha/_benchmark/clean.sh', "#!/bin/sh\nexit 0\n");
    file_put_contents($suiteDirectory . '/alpha/asset/composer.lock', json_encode([
        'packages' => [['name' => 'vendor/alpha', 'version' => 'v3.2.1']],
        'packages-dev' => [],
    ], JSON_THROW_ON_ERROR));
    file_put_contents(
        $suiteDirectory . '/beta/asset/vendor/composer/installed.php',
        "<?php return ['root' => ['name' => 'vendor/beta', 'pretty_version' => 'dev-main'], 'versions' => []];\n",
    );
    file_put_contents($suiteDirectory . '/beta/asset/.benchmark-project-version', "vendor/beta\n2.4.0\n");
    file_put_contents($suiteDirectory . '/.docker/apache.dockerfile', "FROM php:8.4-apache\n");

    try {
        $frameworkSuite = new PhpFrameworksBenchSuite($suiteDirectory);
        $assert($frameworkSuite->targets() === ['alpha', 'beta'], 'framework targets follow suite config order');
        $assert($frameworkSuite->getSuggestedConcurrency() === 42, 'suite connection default is imported');
        $assert($frameworkSuite->getSuggestedDuration() === 17, 'suite duration default is imported');
        $assert(
            $frameworkSuite->categories() === ['alpha' => 'full-stack', 'beta' => 'micro']
            && $frameworkSuite->categories(['beta']) === ['beta' => 'micro'],
            'framework categories are imported and retain target selection',
        );
        $assert(
            $frameworkSuite->architectures() === ['alpha' => 'component-based', 'beta' => 'mvc-hmvc']
            && $frameworkSuite->architectures(['alpha']) === ['alpha' => 'component-based'],
            'framework architectures are imported and retain target selection',
        );
        $assert(
            $frameworkSuite->builtInDi() === ['alpha' => 'yes', 'beta' => 'no']
            && $frameworkSuite->builtInDi(['beta']) === ['beta' => 'no'],
            'built-in DI capabilities are imported and retain target selection',
        );
        $assert(
            $frameworkSuite->fullFeaturedRouteDispatchers() === ['alpha' => 'yes', 'beta' => 'yes']
            && $frameworkSuite->fullFeaturedRouteDispatchers(['alpha']) === ['alpha' => 'yes'],
            'route-dispatcher capabilities are imported and retain target selection',
        );
        $assert(
            $frameworkSuite->versions(serverPhpVersion: '8.5.0') === [
                'alpha' => 'v3.2.1',
                'beta' => '2.4.0',
            ],
            'framework versions resolve from production locks and recorded stable create-project releases',
        );
        unlink($suiteDirectory . '/beta/asset/.benchmark-project-version');
        $assert(
            $frameworkSuite->versions(['beta']) === ['beta' => 'Version unavailable'],
            'development branch names are omitted when no stable release can be proven',
        );
        file_put_contents($suiteDirectory . '/beta/asset/.benchmark-project-version', "vendor/beta\n2.4.0\n");
        file_put_contents(
            $suiteDirectory . '/.benchmark-server.json',
            json_encode(['baseUrl' => 'http://127.0.0.1:43210/bench'], JSON_THROW_ON_ERROR),
        );
        $runtimeSuite = new PhpFrameworksBenchSuite($suiteDirectory);
        $assert(
            $runtimeSuite->getBaseUrl() === 'http://127.0.0.1:43210/bench',
            'recorded benchmark server URL overrides the static suite fallback',
        );
        unlink($suiteDirectory . '/.benchmark-server.json');
        $suiteConfigs = $frameworkSuite->configs(['beta']);
        $assert(count($suiteConfigs) === 1, 'framework target selection is supported');
        $assert(
            $suiteConfigs[0]->getUrl() === 'http://127.0.0.1/bench/beta/web/index.php?r=hello/index',
            'framework target URL is imported without executing shell code',
        );

        $textResponse = "Hello World!\n 1048576:0.001250:17";
        $jsonResponse = "{\"status\":true,\"message\":\"Hello World!\"}\n 2097152:0.002500:23";
        $assert(PhpFrameworksBenchSuite::isExpectedResponse($textResponse), 'text framework response is validated');
        $assert(PhpFrameworksBenchSuite::isExpectedResponse($jsonResponse), 'JSON framework response is validated');
        $assert(
            PhpFrameworksBenchSuite::extractMemoryBytes($jsonResponse) === 2_097_152.0,
            'framework response memory telemetry is extracted',
        );
        $assert(
            PhpFrameworksBenchSuite::extractResponseMetrics($jsonResponse) === [
                'server_execution_ms' => 2.5,
                'included_files' => 23,
            ],
            'framework execution time and included-file telemetry are extracted',
        );
        $assert(
            !PhpFrameworksBenchSuite::isExpectedResponse("Wrong response\n 1048576:0.001250:17"),
            'wrong framework response is rejected',
        );
        $expectException(
            InvalidArgumentException::class,
            static fn() => $frameworkSuite->configs(['missing']),
            'unknown framework targets are rejected',
        );

        $frameworkManager = new PhpFrameworksBenchManager($frameworkSuite);
        $parseServerEnvironment = new ReflectionMethod($frameworkManager, 'parseServerEnvironment');
        $parsedServerEnvironment = $parseServerEnvironment->invoke(null, json_encode([
            'phpVersion' => '8.5.0',
            'phpSapi' => 'apache2handler',
            'benchmarkProfile' => 'production',
            'opcache' => ['enabled' => true, 'jitEnabled' => false],
        ], JSON_THROW_ON_ERROR));
        $legacyServerEnvironment = $parseServerEnvironment->invoke(
            null,
            "PHP: 8.4.0\nOPCache: Off\n",
        );
        $assert(
            $parsedServerEnvironment['opcache']['enabled'] === true
            && $parsedServerEnvironment['benchmarkProfile'] === 'production'
            && $legacyServerEnvironment['opcache']['enabled'] === false,
            'target-server configuration accepts structured and legacy fixture responses',
        );
        $setupPlan = $frameworkManager->lifecycle('setup', ['alpha'], dryRun: true);
        $assert(
            $setupPlan[0]['status'] === 'dry-run'
            && $setupPlan[0]['command'] === [
                'bash',
                '-O',
                'extglob',
                $suiteDirectory . '/alpha/_benchmark/setup.sh',
            ],
            'framework setup commands can be inspected without execution',
        );
        $expectException(
            RuntimeException::class,
            static fn() => $frameworkManager->lifecycle('clean', ['alpha']),
            'destructive framework cleanup requires approval',
        );
        $expectException(
            RuntimeException::class,
            static fn() => $frameworkManager->lifecycle('update', ['alpha']),
            'latest-version framework recreation requires approval',
        );
        $restartPlan = $frameworkManager->restartServices(['apache', 'php-fpm'], dryRun: true);
        $assert(
            $restartPlan[0]['unit'] === 'apache2'
            && str_starts_with($restartPlan[1]['unit'], 'php8.4-fpm'),
            'web service restart commands are generated explicitly',
        );
        $dockerPlan = $frameworkManager->dockerApache(dryRun: true);
        $assert(
            $dockerPlan[0]['command'][0] === 'docker'
            && $dockerPlan[1]['status'] === 'dry-run'
            && in_array('127.0.0.1::80', $dockerPlan[1]['command'], true)
            && $dockerPlan[2]['command'] === ['docker', 'port', 'benchmark-frameworks-apache', '80/tcp']
            && !is_file($suiteDirectory . '/.benchmark-server.json'),
            'Docker Apache lets Docker allocate a loopback port and supports dry-run',
        );
        $fixedDockerPlan = $frameworkManager->dockerApache(port: 18_080, dryRun: true);
        $assert(
            in_array('127.0.0.1:18080:80', $fixedDockerPlan[1]['command'], true),
            'Docker Apache supports an explicitly requested loopback port',
        );
        $dockerStopPlan = $frameworkManager->stopDockerApache(dryRun: true);
        $assert(
            $dockerStopPlan['command'] === ['docker', 'stop', 'benchmark-frameworks-apache']
            && $dockerStopPlan['status'] === 'dry-run',
            'Docker Apache stop command supports dry-run',
        );
    } finally {
        unlink($suiteDirectory . '/alpha/_benchmark/setup.sh');
        unlink($suiteDirectory . '/alpha/_benchmark/clean.sh');
        unlink($suiteDirectory . '/alpha/_benchmark/hello_world.sh');
        unlink($suiteDirectory . '/beta/_benchmark/hello_world.sh');
        unlink($suiteDirectory . '/alpha/asset/composer.lock');
        unlink($suiteDirectory . '/beta/asset/.benchmark-project-version');
        unlink($suiteDirectory . '/beta/asset/vendor/composer/installed.php');
        unlink($suiteDirectory . '/.docker/apache.dockerfile');
        unlink($suiteDirectory . '/config');
        rmdir($suiteDirectory . '/alpha/_benchmark');
        rmdir($suiteDirectory . '/alpha/asset');
        rmdir($suiteDirectory . '/alpha');
        rmdir($suiteDirectory . '/beta/_benchmark');
        rmdir($suiteDirectory . '/beta/asset/vendor/composer');
        rmdir($suiteDirectory . '/beta/asset/vendor');
        rmdir($suiteDirectory . '/beta/asset');
        rmdir($suiteDirectory . '/beta');
        rmdir($suiteDirectory . '/.docker');
        rmdir($suiteDirectory);
    }

    $bundledSuiteDirectory = dirname(__DIR__) . '/frameworks';
    $bundledSuite = new PhpFrameworksBenchSuite(
        $bundledSuiteDirectory,
        'http://127.0.0.1:8080/frameworks',
    );
    $bundledTargets = [
        'cakephp', 'codeigniter', 'fatfree', 'fast-route', 'flight', 'infbyte', 'infbyte-full', 'kumbia', 'laravel',
        'laravel-api', 'leaf', 'nette', 'pure-php', 'slim', 'symfony',
        'webrick-sharded', 'webrick-fused', 'yii-basic',
    ];
    $assert($bundledSuite->targets() === $bundledTargets, 'bundled framework targets are unversioned and ordered');
    $assert(
        $bundledSuite->categories() === [
            'cakephp' => 'full-stack',
            'codeigniter' => 'full-stack',
            'fatfree' => 'micro',
            'fast-route' => 'route-only',
            'flight' => 'micro',
            'infbyte' => 'full-stack',
            'infbyte-full' => 'full-stack',
            'kumbia' => 'full-stack',
            'laravel' => 'full-stack',
            'laravel-api' => 'full-stack',
            'leaf' => 'micro',
            'nette' => 'full-stack',
            'pure-php' => 'baseline',
            'slim' => 'micro',
            'symfony' => 'full-stack',
            'webrick-sharded' => 'route-only',
            'webrick-fused' => 'route-only',
            'yii-basic' => 'full-stack',
        ],
        'bundled framework categories cover full-stack, micro, route-only, and baseline targets',
    );
    $assert(
        $bundledSuite->architectures() === [
            'cakephp' => 'mvc-hmvc',
            'codeigniter' => 'mvc-hmvc',
            'fatfree' => 'mvc-hmvc',
            'fast-route' => 'component-based',
            'flight' => 'component-based',
            'infbyte' => 'component-based',
            'infbyte-full' => 'component-based',
            'kumbia' => 'mvc-hmvc',
            'laravel' => 'mvc-hmvc',
            'laravel-api' => 'mvc-hmvc',
            'leaf' => 'component-based',
            'nette' => 'component-based',
            'pure-php' => 'baseline',
            'slim' => 'component-based',
            'symfony' => 'component-based',
            'webrick-sharded' => 'component-based',
            'webrick-fused' => 'component-based',
            'yii-basic' => 'mvc-hmvc',
        ],
        'bundled framework architectures cover MVC/HMVC, component-based, and baseline targets',
    );
    $assert(
        $bundledSuite->builtInDi() === [
            'cakephp' => 'yes',
            'codeigniter' => 'yes',
            'fatfree' => 'no',
            'fast-route' => 'no',
            'flight' => 'no',
            'infbyte' => 'yes',
            'infbyte-full' => 'yes',
            'kumbia' => 'no',
            'laravel' => 'yes',
            'laravel-api' => 'yes',
            'leaf' => 'yes',
            'nette' => 'yes',
            'pure-php' => 'no',
            'slim' => 'no',
            'symfony' => 'yes',
            'webrick-sharded' => 'yes',
            'webrick-fused' => 'yes',
            'yii-basic' => 'yes',
        ],
        'bundled framework DI capabilities are explicit',
    );
    $assert(
        $bundledSuite->fullFeaturedRouteDispatchers() === [
            'cakephp' => 'yes',
            'codeigniter' => 'yes',
            'fatfree' => 'yes',
            'fast-route' => 'yes',
            'flight' => 'yes',
            'infbyte' => 'yes',
            'infbyte-full' => 'yes',
            'kumbia' => 'yes',
            'laravel' => 'yes',
            'laravel-api' => 'yes',
            'leaf' => 'yes',
            'nette' => 'yes',
            'pure-php' => 'no',
            'slim' => 'yes',
            'symfony' => 'yes',
            'webrick-sharded' => 'yes',
            'webrick-fused' => 'yes',
            'yii-basic' => 'yes',
        ],
        'bundled framework route-dispatcher capabilities are explicit',
    );
    $assert(
        $bundledSuite->versions(['pure-php'], '8.5.0') === ['pure-php' => 'PHP 8.5.0'],
        'the Pure PHP baseline displays the benchmark server PHP version',
    );
    $assert(
        $bundledSuite->configs(['symfony'])[0]->getUrl()
            === 'http://127.0.0.1:8080/frameworks/symfony/asset/public/index.php/hello/index',
        'bundled suite URL is generated from its internal config',
    );
    $allLifecycleScriptsExist = true;
    $allGeneratedFilesAreIgnored = true;
    $allTargetsUseAssetDirectory = true;
    foreach ($bundledTargets as $target) {
        foreach (['setup', 'update', 'clean', 'clear-cache', 'hello_world'] as $action) {
            $allLifecycleScriptsExist = $allLifecycleScriptsExist
                && is_file("{$bundledSuiteDirectory}/{$target}/_benchmark/{$action}.sh");
        }
        $ignore = file_get_contents("{$bundledSuiteDirectory}/{$target}/.gitignore");
        $allGeneratedFilesAreIgnored = $allGeneratedFilesAreIgnored
            && is_string($ignore)
            && str_contains($ignore, "/asset/\n")
            && str_contains($ignore, "/.benchmark-create-project/\n");
        $helloWorld = file_get_contents("{$bundledSuiteDirectory}/{$target}/_benchmark/hello_world.sh");
        $allTargetsUseAssetDirectory = $allTargetsUseAssetDirectory
            && is_string($helloWorld)
            && str_contains($helloWorld, '$base/$fw/asset/');
    }
    $assert($allLifecycleScriptsExist, 'every bundled target provides the complete lifecycle script set');
    $assert($allGeneratedFilesAreIgnored, 'every bundled target ignores generated create-project files');
    $assert($allTargetsUseAssetDirectory, 'every bundled target serves its generated application from asset');
    $frameworkIgnore = file_get_contents($bundledSuiteDirectory . '/.gitignore');
    $assert(
        is_string($frameworkIgnore)
        && str_contains($frameworkIgnore, "/*/*\n")
        && str_contains($frameworkIgnore, "!/*/_benchmark/**\n")
        && str_contains($frameworkIgnore, "!/_support/**\n")
        && str_contains($frameworkIgnore, "!/libs/**\n"),
        'framework root ignores generated files for new targets while retaining suite infrastructure',
    );
    $lifecycleSource = file_get_contents($bundledSuiteDirectory . '/_support/lifecycle.sh');
    $assert(
        is_string($lifecycleSource)
        && str_contains($lifecycleSource, 'composer create-project')
        && str_contains($lifecycleSource, '--no-dev --remove-vcs')
        && str_contains($lifecycleSource, '--stability=stable')
        && str_contains($lifecycleSource, '.benchmark-project-version')
        && str_contains($lifecycleSource, 'composer --working-dir="$asset_dir" install --prefer-dist --no-interaction')
        && str_contains($lifecycleSource, '--no-dev --classmap-authoritative --no-progress')
        && str_contains($lifecycleSource, 'cp -a "$build_dir/." "$asset_dir/"')
        && !str_contains($lifecycleSource, 'rm -f -- "$build_dir/.gitignore"')
        && preg_match('/create-project[^\n]*:[0-9]/', $lifecycleSource) !== 1,
        'Composer project creation installs unversioned assets and preserves framework ignore rules',
    );
    $assert(
        is_string($lifecycleSource)
        && str_contains($lifecycleSource, 'configure_production_environment')
        && str_contains($lifecycleSource, 'install_all_infbyte_modules')
        && str_contains($lifecycleSource, 'module:list --json --no-interaction')
        && str_contains($lifecycleSource, 'module:config:publish "$module" --no-interaction')
        && str_contains($lifecycleSource, 'module:schema:sync --no-interaction')
        && str_contains($lifecycleSource, 'CI_ENVIRONMENT production')
        && str_contains($lifecycleSource, 'APP_ENV prod')
        && str_contains($lifecycleSource, 'printf \'production\n\' > "$suite_dir/.benchmark-profile"')
        && str_contains($lifecycleSource, 'optimize_production')
        && substr_count($lifecycleSource, 'chmod -R a+rX "$asset_dir/bootstrap/cache"') === 2
        && str_contains($lifecycleSource, 'SESSION_DRIVER array')
        && str_contains($lifecycleSource, 'chmod a+r "$asset_dir/.env"'),
        'generated web fixtures receive predefined production environments and optimization commands',
    );
    $dockerSource = file_get_contents($bundledSuiteDirectory . '/.docker/apache.dockerfile');
    $assert(
        is_string($dockerSource)
        && str_contains($dockerSource, 'php.ini-production')
        && str_contains($dockerSource, 'SetEnv BENCHMARK_ENVIRONMENT production')
        && !str_contains($dockerSource, 'SetEnv APP_ENV')
        && !str_contains($dockerSource, 'SetEnv APP_DEBUG')
        && !str_contains($dockerSource, 'SetEnv CI_ENVIRONMENT')
        && str_contains($dockerSource, 'opcache.enable=1'),
        'Docker records the shared profile without overriding framework-specific environments',
    );
    $workflowSource = file_get_contents(dirname(__DIR__) . '/.github/workflows/framework-benchmarks.yml');
    $assert(
        is_string($workflowSource)
        && str_contains($workflowSource, 'if: failure()')
        && str_contains($workflowSource, 'docker logs --tail 200 benchmark-frameworks-apache || true'),
        'the automated workflow exposes server errors before stopping a failed benchmark container',
    );
    $assert(
        !is_dir($bundledSuiteDirectory . '/lumen')
        && !str_contains((string) file_get_contents($bundledSuiteDirectory . '/config'), "\nlumen\n"),
        'the unmaintained Lumen target is removed from the bundled suite',
    );
    $assert(
        str_contains((string) file_get_contents($bundledSuiteDirectory . '/kumbia/_benchmark/overlay/default/public/index.php'), 'const PRODUCTION = true;')
        && str_contains((string) file_get_contents($bundledSuiteDirectory . '/nette/_benchmark/overlay/app/Bootstrap.php'), 'setDebugMode(false)')
        && str_contains((string) file_get_contents($bundledSuiteDirectory . '/yii-basic/_benchmark/overlay/web/index.php'), "define('YII_ENV', 'prod')")
        && str_contains((string) file_get_contents($bundledSuiteDirectory . '/fatfree/_benchmark/overlay/public/index.php'), "set('DEBUG', 0)"),
        'framework overlays explicitly disable development behavior where the framework exposes a production switch',
    );
    $assert(
        is_file($bundledSuiteDirectory . '/cakephp/_benchmark/overlay/.htaccess'),
        'CakePHP setup disables the scaffold rewrite that loops on direct front-controller URLs',
    );
    $flightFrontController = file_get_contents(
        $bundledSuiteDirectory . '/flight/_benchmark/overlay/public/index.php',
    );
    $assert(
        is_string($flightFrontController)
        && str_contains($flightFrontController, 'new Engine()')
        && str_contains($flightFrontController, "->router()->get('/index.php/hello/index'")
        && !str_contains($flightFrontController, 'app/config/bootstrap.php'),
        'Flight benchmark uses a minimal framework boot without skeleton session overhead',
    );
    $fastRouteFrontController = file_get_contents(
        $bundledSuiteDirectory . '/fast-route/_benchmark/overlay/public/index.php',
    );
    $fastRouteCacheBuilder = file_get_contents(
        $bundledSuiteDirectory . '/fast-route/_benchmark/overlay/build-cache.php',
    );
    $assert(
        is_string($fastRouteFrontController)
        && is_string($fastRouteCacheBuilder)
        && str_contains($fastRouteFrontController, 'cachedDispatcher(')
        && str_contains($fastRouteFrontController, "Dispatcher::METHOD_NOT_ALLOWED")
        && str_contains($fastRouteFrontController, "'cacheDisabled' => false")
        && str_contains($fastRouteCacheBuilder, "is_file(\$cacheFile)")
        && str_contains($lifecycleSource, 'rebuild_fast_route_cache')
        && str_contains($lifecycleSource, 'strip_fast_route_development_requirements')
        && str_contains($lifecycleSource, 'create_project_options+=(--no-install)'),
        'FastRoute benchmark omits obsolete development requirements and dispatches through its prebuilt production cache',
    );
    $webrickFrontController = file_get_contents(
        $bundledSuiteDirectory . '/_support/webrick/public/index.php',
    );
    $assert(
        is_string($webrickFrontController)
        && str_contains($webrickFrontController, "'fused' => FusedMatcher::make()")
        && str_contains($webrickFrontController, "'sharded' => ShardedMatcher::make()")
        && str_contains($webrickFrontController, "'/hello/index'") === false
        && str_contains($lifecycleSource, '--matcher="$matcher" --cache="$cache"')
        && str_contains($lifecycleSource, '--routes="$asset_dir/routes.php" --alias-fallback=0')
        && trim((string) file_get_contents(
            $bundledSuiteDirectory . '/webrick-sharded/_benchmark/overlay/matcher.php',
        )) === "<?php\n\ndeclare(strict_types=1);\n\nreturn 'sharded';"
        && trim((string) file_get_contents(
            $bundledSuiteDirectory . '/webrick-fused/_benchmark/overlay/matcher.php',
        )) === "<?php\n\ndeclare(strict_types=1);\n\nreturn 'fused';",
        'Webrick targets share one route and isolate the sharded and fused production matchers',
    );

    $historyDirectory = sys_get_temp_dir() . '/benchmark-history-' . bin2hex(random_bytes(8));
    $history = new BenchmarkHistory($historyDirectory, 61, true);
    $historyResult = $result;
    $historyResult['remoteMetrics'] = [
        'server_execution_ms' => ['samples' => 100, 'average' => 1.25, 'minimum' => 1.0, 'maximum' => 2.0],
        'included_files' => ['samples' => 100, 'average' => 17.0, 'minimum' => 17.0, 'maximum' => 17.0],
    ];
    $targetServerEnvironment = [
        'phpVersion' => '8.5.0',
        'phpSapi' => 'apache2handler',
        'loadedIni' => '/usr/local/etc/php/php.ini',
        'benchmarkProfile' => 'production',
        'opcache' => [
            'extensionLoaded' => true,
            'enabled' => true,
            'enableSetting' => true,
            'enableCliSetting' => false,
            'jitEnabled' => false,
            'jitMode' => 'disable',
            'jitBufferSize' => '0',
            'memoryConsumption' => '134217728',
            'internedStringsBuffer' => '8',
            'maxAcceleratedFiles' => 10_000,
            'validateTimestamps' => true,
            'revalidateFrequencySeconds' => 2,
        ],
    ];
    $firstArchive = $history->save([
        'recordedAt' => '2026-06-10T08:15:00+00:00',
        'targetServer' => $targetServerEnvironment,
        'categories' => ['test' => 'full-stack'],
        'architectures' => ['test' => 'component-based'],
        'builtInDi' => ['test' => 'yes'],
        'fullFeaturedRouteDispatchers' => ['test' => 'yes'],
        'versions' => ['test' => 'v3.2.1'],
        'results' => ['test' => $historyResult],
    ], '# First');
    $historyResult['peak']['req_per_min'] *= 1.10;
    $secondArchive = $history->save([
        'recordedAt' => '2026-07-10T12:30:00+00:00',
        'targetServer' => $targetServerEnvironment,
        'categories' => ['test' => 'full-stack'],
        'architectures' => ['test' => 'component-based'],
        'builtInDi' => ['test' => 'yes'],
        'fullFeaturedRouteDispatchers' => ['test' => 'yes'],
        'versions' => ['test' => 'v3.2.1'],
        'results' => ['test' => $historyResult],
    ], '# Second');
    $assert(count($history->entries()) === 2, 'benchmark history lists archived runs');
    $assert(
        is_file($firstArchive . '/results.json')
        && is_file($firstArchive . '/report.md')
        && is_file($firstArchive . '/dashboard.html')
        && is_file($historyDirectory . '/index.html'),
        'history archives canonical JSON, Markdown, dashboards, and an index',
    );
    $comparison = $history->compare(0, 1);
    $assert(
        str_contains($comparison, 'Benchmark comparison')
        && str_contains($comparison, 'Peak RPM')
        && str_contains($comparison, '+10.00%'),
        'history comparison reports metric changes between runs',
    );
    $dashboard = file_get_contents($history->dashboard(0));
    $assert(
        is_string($dashboard)
        && str_contains($dashboard, 'bootstrap@5.3.8')
        && str_contains($dashboard, 'Higher is better · best first')
        && str_contains($dashboard, 'Lower is better · best first')
        && str_contains($dashboard, 'Concurrency curves')
        && str_contains($dashboard, 'All concurrency measurements')
        && str_contains($dashboard, 'data-sortable')
        && str_contains($dashboard, 'humanDateTime')
        && str_contains($dashboard, 'prefers-color-scheme: dark')
        && str_contains($dashboard, 'Theme · Auto')
        && str_contains($dashboard, 'id="category-filter"')
        && str_contains($dashboard, 'aria-label="Open report menu"')
        && str_contains($dashboard, '<svg viewBox="0 0 24 24"')
        && !str_contains($dashboard, '>Report menu</button>')
        && str_contains($dashboard, 'Sustainable leaders')
        && str_contains($dashboard, 'id="architecture-filter"')
        && str_contains($dashboard, 'id="di-filter"')
        && str_contains($dashboard, 'id="route-dispatcher-filter"')
        && str_contains($dashboard, "placeholder:'Type'")
        && str_contains($dashboard, "placeholder:'Architecture'")
        && str_contains($dashboard, "placeholder:'Built-in DI'")
        && str_contains($dashboard, "placeholder:'Route dispatcher'")
        && !str_contains($dashboard, "new Option('All','all')")
        && str_contains($dashboard, 'Pure PHP baseline')
        && str_contains($dashboard, 'data-category="full-stack"')
        && str_contains($dashboard, 'data-category="route-only"')
        && str_contains($dashboard, "allowed:['full-stack','micro','route-only']")
        && str_contains($dashboard, 'data-legend-category')
        && str_contains($dashboard, "entry.category==='baseline'")
        && str_contains($dashboard, 'decorateTargetCells')
        && str_contains($dashboard, 'categoryMap')
        && str_contains($dashboard, 'architectureMap')
        && str_contains($dashboard, 'builtInDiMap')
        && str_contains($dashboard, 'routeDispatcherMap')
        && str_contains($dashboard, "entry.category==='baseline'||filterDefinitions.every")
        && str_contains($dashboard, 'Full-featured route dispatcher')
        && str_contains($dashboard, 'versionMap')
        && str_contains($dashboard, 'badge-version')
        && str_contains($dashboard, 'v3.2.1')
        && str_contains($dashboard, 'diagnosticTitle')
        && str_contains($dashboard, 'target-name-line')
        && !str_contains($dashboard, '>Status</button>')
        && !str_contains($dashboard, '>Failed</button>')
        && !str_contains($dashboard, '>Error %</button>')
        && !str_contains($dashboard, '<th>Failed</th>')
        && !str_contains($dashboard, '<th>Error %</th>')
        && !str_contains($dashboard, '<th>Stability</th>')
        && str_contains($dashboard, 'Target-server environment')
        && str_contains($dashboard, 'Benchmark environment profile')
        && str_contains($dashboard, 'OPcache enabled for web requests')
        && str_contains($dashboard, 'CLI OPcache enabled')
        && str_contains($dashboard, 'serverOpcacheRevalidateFrequencySeconds')
        && str_contains($dashboard, "['Full Stack',entry=>entry.category==='full-stack']")
        && str_contains($dashboard, "['MVC/HMVC',entry=>entry.architecture==='mvc-hmvc']")
        && str_contains($dashboard, 'server_execution_ms'),
        'browser dashboard includes an icon action menu, self-labeling baseline-aware classification and capability filters, five framework-only leaders, system-aware themes, concurrency detail, and sortable data',
    );
    $expectException(
        RuntimeException::class,
        static fn() => $history->delete(0),
        'history deletion requires approval',
    );
    $replacementArchive = $history->save([
        'recordedAt' => '2026-07-20T12:30:00+00:00',
        'targetServer' => $targetServerEnvironment,
        'categories' => ['test' => 'full-stack'],
        'architectures' => ['test' => 'component-based'],
        'builtInDi' => ['test' => 'yes'],
        'fullFeaturedRouteDispatchers' => ['test' => 'yes'],
        'versions' => ['test' => 'v3.2.1'],
        'results' => ['test' => $historyResult],
    ], '# July replacement');
    $historyIndex = file_get_contents($historyDirectory . '/index.html');
    $assert(
        count($history->entries()) === 2
        && !is_dir($secondArchive)
        && is_dir($replacementArchive),
        'a newer benchmark replaces the previous result from the same UTC month',
    );
    $assert(
        is_string($historyIndex)
        && str_contains($historyIndex, 'July 20, 2026 at 12:30 PM UTC')
        && str_contains($historyIndex, 'prefers-color-scheme:dark')
        && str_contains($historyIndex, 'data-local-time')
        && str_contains($historyIndex, 'Monthly, reproducible reports'),
        'history index follows the system theme and localizes readable dates for the visitor',
    );
    $deleted = $history->deleteAll(true);
    $assert(count($deleted) === 2 && !is_dir($firstArchive) && !is_dir($replacementArchive), 'approved history deletion is bounded to run directories');
    unlink($historyDirectory . '/index.html');
    rmdir($historyDirectory);

    $retentionDirectory = sys_get_temp_dir() . '/benchmark-retention-' . bin2hex(random_bytes(8));
    $retentionHistory = new BenchmarkHistory($retentionDirectory, 61, true);
    $oldestArchive = '';
    $month = new DateTimeImmutable('2020-01-01T00:00:00+00:00');
    for ($index = 0; $index < 62; ++$index) {
        $archive = $retentionHistory->save([
            'recordedAt' => $month->modify("+{$index} months")->format(DATE_ATOM),
            'results' => [],
        ], '# Retention');
        $oldestArchive = $index === 0 ? $archive : $oldestArchive;
    }
    $assert(
        count($retentionHistory->entries()) === 61 && !is_dir($oldestArchive),
        'history automatically retains only the newest 61 monthly records',
    );
    $assert(count($retentionHistory->deleteAll(true)) === 61, 'retained history can be cleaned safely');
    unlink($retentionDirectory . '/index.html');
    rmdir($retentionDirectory);

    $toBytes = new ReflectionMethod(ContainerStats::class, 'toBytes');
    $assert($toBytes->invoke(null, '1.5GiB') === 1_610_612_736.0, 'Docker memory units are parsed');
    $containerStats = new ContainerStats('test-container');
    $consumeLine = new ReflectionMethod(ContainerStats::class, 'consumeLine');
    $consumeLine->invoke($containerStats, "\033[2J\033[H28.35MiB / 15.33GiB,0.36%");
    $memorySamples = new ReflectionProperty(ContainerStats::class, 'memory');
    $assert(count($memorySamples->getValue($containerStats)) === 1, 'Docker ANSI prefixes are stripped');

    fwrite(STDOUT, "OK ({$tests} assertions)\n");
}
