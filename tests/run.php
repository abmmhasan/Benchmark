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
    use AbmmHasan\Benchmark\BenchmarkRunner;
    use AbmmHasan\Benchmark\ContainerStats;
    use AbmmHasan\Benchmark\FakeCurl;
    use AbmmHasan\Benchmark\HttpMethod;
    use AbmmHasan\Benchmark\PipingMode;
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
    $perConfigRunner = BenchmarkRunner::make()
        ->warmUpRequests(0)
        ->minimumDuration(0)
        ->stabilityThreshold(10_000)
        ->addConfigs(
            $resolvedConfig(['threads' => 4, 'name' => 'per-config']),
            $resolvedConfig(['threads' => 4, 'name' => 'rotation-target']),
        );
    $results = $perConfigRunner->runAll();
    $result = $results['per-config'];
    $assert(count($result['runs']) === 3, 'three repeated runs are recorded');
    $assert(array_keys($result['throughputCurve']) === [2, 4], 'default concurrency curve is recorded');
    $assert($result['score'] === $result['multiple']['req_per_min'], 'ranking score is validated RPM');
    $assert(isset($result['multiple']['req_per_min_mad']), 'repeated-run RPM variance is recorded');
    $assert($result['configuration']['responseValidation'] === true, 'reproduction metadata is recorded');
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
    $assert(str_contains($markdown, '## Ranking'), 'Markdown output has a concise ranking group');
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
        str_contains($markdown, '## Target-specific configuration'),
        'target-specific configuration has its own table',
    );
    $assert(!str_contains($markdown, 'configuration.'), 'Markdown avoids flattened configuration keys');
    $assert(!str_contains($markdown, '| RPS |'), 'derived RPS is not duplicated beside RPM');
    $assert(
        str_contains($markdown, 'Run 1 RPM') && str_contains($markdown, 'Run 3 RPM'),
        'per-run RPM remains visible',
    );
    preg_match('/## Ranking\R\R(?<table>.*?)(?=\R\R## )/s', $markdown, $summaryMatch);
    $assert(
        !str_contains($summaryMatch['table'] ?? '', 'RPS')
        && !str_contains($summaryMatch['table'] ?? '', 'p99'),
        'ranking does not repeat detailed throughput or latency fields',
    );

    $groupData = ['first' => $result, 'second' => $result];
    $groupData['second']['configuration']['url'] = 'http://second.example.test';
    $groupConfiguration = new ReflectionMethod(BenchmarkRunner::class, 'groupConfiguration');
    [$commonConfiguration, $specificConfiguration] = $groupConfiguration->invoke(null, $groupData);
    $assert(isset($commonConfiguration['method']), 'identical configuration is grouped once');
    $assert(
        isset($specificConfiguration['first']['url'], $specificConfiguration['second']['url']),
        'different target configuration remains per target',
    );
    $comparisonMarkdown = $toMarkdownTable->invoke($perConfigRunner, $groupData);
    $assert(
        str_contains($comparisonMarkdown, '| Setting | first | second |'),
        'target-specific configuration is pivoted for comparison',
    );
    $assert(!str_contains($comparisonMarkdown, '| Recorded at |'), 'timestamps are not presented as configuration');

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
        $inconclusive['score'] === null && $inconclusive['rankingStatus'] === 'inconclusive',
        'a target with no stable concurrency is excluded from ranking',
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

    $toBytes = new ReflectionMethod(ContainerStats::class, 'toBytes');
    $assert($toBytes->invoke(null, '1.5GiB') === 1_610_612_736.0, 'Docker memory units are parsed');
    $containerStats = new ContainerStats('test-container');
    $consumeLine = new ReflectionMethod(ContainerStats::class, 'consumeLine');
    $consumeLine->invoke($containerStats, "\033[2J\033[H28.35MiB / 15.33GiB,0.36%");
    $memorySamples = new ReflectionProperty(ContainerStats::class, 'memory');
    $assert(count($memorySamples->getValue($containerStats)) === 1, 'Docker ANSI prefixes are stripped');

    fwrite(STDOUT, "OK ({$tests} assertions)\n");
}
