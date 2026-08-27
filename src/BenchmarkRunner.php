<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use Closure;
use InvalidArgumentException;
use JsonException;
use LogicException;
use RuntimeException;
use Throwable;

final class BenchmarkRunner
{
    private ?int $defaultThreads = null;
    private ?int $defaultCount = null;
    private ?PipingMode $defaultPiping = null;
    private ?int $defaultTimeout = null;
    private ?bool $defaultHttp2 = null;
    private ?bool $defaultVerifySsl = null;
    private ?float $defaultSampleEvery = null;
    private int $repetitions = 3;
    private int $warmUpRequests = 10;
    private float $minimumDurationSeconds = 10.0;
    private float $maximumRpmSpreadPercent = 5.0;
    private ?Closure $beforeRepetition = null;

    /** @var list<int> */
    private array $requestedConcurrencyLevels = [];

    /** @var array<string, BenchmarkConfig> */
    private array $configs = [];

    private readonly BenchmarkConsole $console;

    private function __construct()
    {
        $this->console = new BenchmarkConsole();
    }

    public static function make(): self
    {
        return new self();
    }

    public function threads(int $threads): self
    {
        self::validateThreads($threads);
        $this->defaultThreads = $threads;
        return $this;
    }

    public function count(int $count): self
    {
        self::validateCount($count);
        $this->defaultCount = $count;
        return $this;
    }

    public function piping(PipingMode $mode): self
    {
        $this->defaultPiping = $mode;
        return $this;
    }

    public function timeout(int $seconds): self
    {
        if ($seconds < 1 || $seconds > BenchmarkConfig::MAX_TIMEOUT_SECONDS) {
            throw new InvalidArgumentException(sprintf(
                'Timeout must be between 1 and %d seconds',
                BenchmarkConfig::MAX_TIMEOUT_SECONDS,
            ));
        }
        $this->defaultTimeout = $seconds;
        return $this;
    }

    public function enableHttp2(bool $enabled = true): self
    {
        $this->defaultHttp2 = $enabled;
        return $this;
    }

    public function verifySsl(bool $enabled = true): self
    {
        $this->defaultVerifySsl = $enabled;
        return $this;
    }

    public function sampleEvery(float $seconds): self
    {
        if ($seconds < 1) {
            throw new InvalidArgumentException('sampleEvery must be ≥ 1 second');
        }
        $this->defaultSampleEvery = $seconds;
        return $this;
    }

    public function repetitions(int $repetitions): self
    {
        if ($repetitions < 1 || $repetitions > 3) {
            throw new InvalidArgumentException('Repetitions must be between 1 and 3');
        }
        $this->repetitions = $repetitions;
        return $this;
    }

    public function stabilityThreshold(float $maximumRpmSpreadPercent): self
    {
        if ($maximumRpmSpreadPercent < 0 || $maximumRpmSpreadPercent > 10_000) {
            throw new InvalidArgumentException('Stability threshold must be between 0 and 10000 percent');
        }
        $this->maximumRpmSpreadPercent = $maximumRpmSpreadPercent;
        return $this;
    }

    public function warmUpRequests(int $requests): self
    {
        if ($requests < 0 || $requests > 10_000) {
            throw new InvalidArgumentException('Warm-up requests must be between 0 and 10000');
        }
        $this->warmUpRequests = $requests;
        return $this;
    }

    public function minimumDuration(float $seconds): self
    {
        if ($seconds < 0 || $seconds > BenchmarkConfig::MAX_PHASE_DURATION_SECONDS) {
            throw new InvalidArgumentException(sprintf(
                'Minimum duration must be between 0 and %d seconds',
                BenchmarkConfig::MAX_PHASE_DURATION_SECONDS,
            ));
        }
        $this->minimumDurationSeconds = $seconds;
        return $this;
    }

    public function concurrencyLevels(int ...$levels): self
    {
        if ($levels === []) {
            throw new InvalidArgumentException('At least one concurrency level is required');
        }
        foreach ($levels as $level) {
            self::validateThreads($level);
        }

        $levels = array_values(array_unique($levels));
        sort($levels, SORT_NUMERIC);
        $this->requestedConcurrencyLevels = $levels;
        return $this;
    }

    /** Register setup work that runs before every target repetition and outside measurement. */
    public function beforeRepetition(?callable $callback): self
    {
        $this->beforeRepetition = $callback === null ? null : Closure::fromCallable($callback);
        return $this;
    }

    public function addConfigs(BenchmarkConfig ...$configs): self
    {
        foreach ($configs as $config) {
            $name = $config->getName();
            if (isset($this->configs[$name])) {
                throw new InvalidArgumentException("Duplicate benchmark name: {$name}");
            }
            $this->configs[$name] = $config;
        }
        return $this;
    }

    /** @param 'array'|'json'|'table'|'csv' $format */
    public function runAll(string $format = 'array'): array|string
    {
        $data = $this->runAllRaw();

        return $this->formatResults($data, $format);
    }

    /**
     * Format previously collected results without executing benchmark traffic again.
     *
     * @param array<string, array<string, mixed>> $data
     * @param 'array'|'json'|'table'|'csv' $format
     */
    public function formatResults(array $data, string $format = 'array'): array|string
    {
        return match ($format) {
            'json' => json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
            'table' => $this->toMarkdownTable($data),
            'csv' => $this->toCsv($data),
            'array' => $data,
            default => throw new InvalidArgumentException("Unknown format: {$format}"),
        };
    }

    private function runAllRaw(): array
    {
        if ($this->configs === []) {
            throw new LogicException('Add at least one benchmark configuration before running');
        }

        $suiteStartedAt = hrtime(true);
        $this->console->startSuite(count($this->configs), $this->repetitions);

        $resolvedConfigs = [];
        foreach ($this->configs as $name => $rawConfig) {
            $resolvedConfigs[$name] = $this->applyDefaults($rawConfig);
        }
        $this->validateAllTargets($resolvedConfigs);

        $states = [];
        foreach ($resolvedConfigs as $name => $config) {
            $states[$name] = [
                'config' => $config,
                'levels' => $this->resolveConcurrencyLevels($config->getThreads()),
                'runs' => [],
                'containerStats' => [],
                'totalDuration' => 0.0,
                'completedPhases' => 0,
            ];
        }

        $targetNames = array_keys($states);
        for ($run = 1; $run <= $this->repetitions; ++$run) {
            $targetOrder = self::rotate($targetNames, $run - 1);
            foreach ($targetOrder as $name) {
                $this->console->startTarget($name);
                try {
                    $iteration = $this->runRepetition(
                        $name,
                        $states[$name]['config'],
                        $states[$name]['levels'],
                        $run,
                        $states[$name]['completedPhases'],
                    );
                    $iteration['run']['targetOrder'] = $targetOrder;
                    $states[$name]['runs'][] = $iteration['run'];
                    $states[$name]['containerStats'][] = $iteration['container'];
                    $states[$name]['totalDuration'] += $iteration['duration'];
                    $totalPhases = $this->repetitions * (count($states[$name]['levels']) + 1);
                    $this->console->pauseTarget(
                        $run,
                        $this->repetitions,
                        $states[$name]['completedPhases'] / $totalPhases,
                    );
                } catch (Throwable $exception) {
                    $this->console->failTarget($exception->getMessage());
                    throw $exception;
                }
            }
        }

        $results = [];
        foreach ($states as $name => $state) {
            $stats = $this->aggregateConfig(
                $name,
                $state['config'],
                $state['levels'],
                $state['runs'],
                $state['containerStats'],
                $state['totalDuration'],
            );
            $results[$name] = $stats;
            $this->console->startTarget($name);
            $this->console->finishTarget(
                $stats['multiple']['req_per_min'],
                $stats['multiple']['concurrency'],
                $stats['totalDuration'],
                $stats['multiple']['error_rate'],
                $stats['rankingStatus'],
            );
        }

        uasort($results, self::compareResults(...));
        $rank = 1;
        foreach ($results as &$result) {
            $result['rank'] = $result['score'] === null ? null : $rank++;
        }
        unset($result);

        $this->console->finishSuite(count($results), self::secondsSince($suiteStartedAt));

        return $results;
    }

    /**
     * @param list<int> $levels
     * @return array{run: array<string, mixed>, container: array<string, int|float>, duration: float}
     */
    private function runRepetition(
        string $name,
        BenchmarkConfig $config,
        array $levels,
        int $run,
        int &$completedPhases,
    ): array
    {
        $totalPhases = $this->repetitions * (count($levels) + 1);
        $baseProgress = $completedPhases / $totalPhases;
        if ($this->beforeRepetition !== null) {
            $this->console->updateTarget($baseProgress, 'preparing runtime');
            ($this->beforeRepetition)($config, $run);
        }
        $this->console->updateTarget($baseProgress, 'restarting container');
        $this->restartContainer($config->getContainer());
        $sampler = $config->getContainer() !== null
            ? new ContainerStats($config->getContainer(), $config->getSampleInterval())
            : null;
        $startedAt = hrtime(true);
        $containerStats = [];

        try {
            $probe = new RequestBenchmark($config);
            if (!$config->skipPreflight()) {
                $this->console->updateTarget($baseProgress, 'waiting for endpoint');
                $this->waitForEndpoint($probe, $name);
            }
            $safeWarmUp = in_array($config->getMethod(), [HttpMethod::GET, HttpMethod::HEAD], true)
                ? $this->warmUpRequests
                : 0;
            $this->console->updateTarget($baseProgress, "warming {$safeWarmUp} requests");
            $probe->warmUp($safeWarmUp);
            $sampler?->start();

            $progress = function (
                int $completed,
                int $minimumRequests,
                float $elapsed,
                float $minimumDuration,
                string $phase,
            ) use (&$completedPhases, $totalPhases, $run, $sampler): void {
                $sampler?->maybeSample();
                $requestProgress = min(1.0, $completed / $minimumRequests);
                $durationProgress = $minimumDuration > 0
                    ? min(1.0, $elapsed / $minimumDuration)
                    : 1.0;
                $phaseProgress = min($requestProgress, $durationProgress);
                $overallProgress = ($completedPhases + $phaseProgress) / $totalPhases;
                $this->console->updateTarget(
                    $overallProgress,
                    sprintf(
                        'run %d/%d · %s · %d req · %.1fs',
                        $run,
                        $this->repetitions,
                        $phase,
                        $completed,
                        $elapsed,
                    ),
                );
            };

            $benchmark = new RequestBenchmark($config, $progress);
            $benchmark->resetMeasurements();
            $single = $benchmark->runSingleThreaded();
            ++$completedPhases;
            $sampler?->maybeSample();

            $concurrent = [];
            $concurrencyOrder = self::rotate($levels, $run - 1);
            foreach ($concurrencyOrder as $level) {
                $concurrent[$level] = $benchmark->runConcurrent($level, $this->minimumDurationSeconds);
                ++$completedPhases;
                $sampler?->maybeSample();
            }

            $measurement = [
                'single' => $single,
                'concurrency' => $concurrent,
                'concurrencyOrder' => $concurrencyOrder,
                'remoteMemoryMB' => $benchmark->getRemoteMemoryMB(),
                'remoteMetrics' => $benchmark->getRemoteMetrics(),
            ];
        } finally {
            if ($sampler !== null) {
                $containerStats = $sampler->finish();
            }
        }

        return [
            'run' => $measurement,
            'container' => $containerStats,
            'duration' => self::secondsSince($startedAt),
        ];
    }

    /**
     * @param list<int> $levels
     * @param list<array<string, mixed>> $runs
     * @param list<array<string, int|float>> $containerStats
     */
    private function aggregateConfig(
        string $name,
        BenchmarkConfig $config,
        array $levels,
        array $runs,
        array $containerStats,
        float $totalDuration,
    ): array {
        $throughputCurve = [];
        foreach ($levels as $level) {
            $measurements = [];
            foreach ($runs as $run) {
                $measurements[] = $run['concurrency'][$level];
            }
            $throughputCurve[$level] = self::medianMetrics(
                $measurements,
                $this->maximumRpmSpreadPercent,
            );
        }

        $singleMeasurements = [];
        $remoteMemoryMeasurements = [];
        $remoteMetricMeasurements = [];
        foreach ($runs as $run) {
            $singleMeasurements[] = $run['single'];
            if ($run['remoteMemoryMB'] !== null) {
                $remoteMemoryMeasurements[] = $run['remoteMemoryMB'];
            }
            $remoteMetricMeasurements[] = $run['remoteMetrics'] ?? [];
        }

        $selectedConcurrency = null;
        $peakConcurrency = null;
        $minimumWindowFound = false;
        foreach ($levels as $level) {
            if ($throughputCurve[$level]['minimum_window_reached'] !== true) {
                continue;
            }
            $minimumWindowFound = true;
            if (
                $peakConcurrency === null
                || $throughputCurve[$level]['req_per_min'] > $throughputCurve[$peakConcurrency]['req_per_min']
            ) {
                $peakConcurrency = $level;
            }

            if ($throughputCurve[$level]['rpm_stability'] === 'stable') {
                if (
                    $selectedConcurrency === null
                    || $throughputCurve[$level]['req_per_min'] > $throughputCurve[$selectedConcurrency]['req_per_min']
                ) {
                    $selectedConcurrency = $level;
                }
            }
        }
        if (!$minimumWindowFound || $peakConcurrency === null) {
            throw new RuntimeException(sprintf(
                'No concurrency phase for %s reached the %.2f second minimum before the request safety limit',
                $name,
                $this->minimumDurationSeconds,
            ));
        }

        $rankingStatus = 'stable';
        if ($selectedConcurrency === null) {
            $rankingStatus = $throughputCurve[$peakConcurrency]['rpm_stability'];
            $selectedConcurrency = $peakConcurrency;
        }

        $multiple = $throughputCurve[$selectedConcurrency];
        $peak = $throughputCurve[$peakConcurrency];
        $stable = $rankingStatus === 'stable' ? $multiple : null;
        $safeWarmUp = in_array($config->getMethod(), [HttpMethod::GET, HttpMethod::HEAD], true)
            ? $this->warmUpRequests
            : 0;
        return [
            'name' => $name,
            'single' => self::medianMetrics($singleMeasurements, $this->maximumRpmSpreadPercent),
            'multiple' => $multiple,
            'stable' => $stable,
            'peak' => $peak,
            'throughputCurve' => $throughputCurve,
            'runs' => $runs,
            'totalDuration' => round($totalDuration, 5),
            'remoteMemoryMB' => $remoteMemoryMeasurements === []
                ? null
                : round(self::median($remoteMemoryMeasurements), 2),
            'remoteMetrics' => self::combineRemoteMetrics($remoteMetricMeasurements),
            'container' => self::combineContainerStats($containerStats),
            'configuration' => $this->configurationMetadata($config, $levels, $safeWarmUp),
            'rankingStatus' => $rankingStatus,
            'score' => $stable === null ? null : (float) $stable['req_per_min'],
        ];
    }

    /** @param array<string, BenchmarkConfig> $configs */
    private function validateAllTargets(array $configs): void
    {
        $containers = [];
        foreach ($configs as $config) {
            $container = $config->getContainer();
            if ($container !== null) {
                $containers[$container] = true;
            }
        }
        try {
            foreach (array_keys($containers) as $container) {
                $this->restartContainer($container);
            }
        } catch (Throwable $exception) {
            $this->console->validationFailed('container readiness', $exception->getMessage());
            throw $exception;
        }

        $position = 0;
        $validated = 0;
        $skipped = 0;
        foreach ($configs as $name => $config) {
            ++$position;
            if ($config->skipPreflight()) {
                ++$skipped;
                continue;
            }

            $this->console->validating($name, $position, count($configs));
            try {
                $benchmark = new RequestBenchmark($config);
                $this->waitForEndpoint($benchmark, $name);
                $benchmark->validateTarget();
                ++$validated;
            } catch (Throwable $exception) {
                $this->console->validationFailed($name, $exception->getMessage());
                throw $exception;
            }
        }
        $this->console->validated($validated, $skipped);
    }

    private function applyDefaults(BenchmarkConfig $config): BenchmarkConfig
    {
        $threads = $config->getThreads() ?? $this->defaultThreads;
        $count = $config->getCount() ?? $this->defaultCount;
        if ($threads === null) {
            throw new LogicException("Benchmark {$config->getName()} needs threads on the config or runner");
        }
        if ($count === null) {
            throw new LogicException("Benchmark {$config->getName()} needs count on the config or runner");
        }
        if ($count < $threads) {
            throw new InvalidArgumentException("Count {$count} must be at least threads {$threads}");
        }

        return new BenchmarkConfig(
            url: $config->getUrl(),
            method: $config->getMethod(),
            headers: $config->getHeaders(),
            body: $config->getBody(),
            expectedStatus: $config->getExpectedStatus(),
            threads: $threads,
            count: $count,
            piping: $config->getPiping() ?? $this->defaultPiping ?? PipingMode::Optimal,
            timeout: $config->getTimeout() ?? $this->defaultTimeout ?? 10,
            enableHttp2: $config->isHttp2Enabled() ?? $this->defaultHttp2 ?? false,
            verifySsl: $config->isVerifySsl() ?? $this->defaultVerifySsl ?? true,
            container: $config->getContainer(),
            sampleEvery: $config->getSampleInterval() ?? $this->defaultSampleEvery ?? 1.0,
            curlOptions: $config->getCurlOptions(),
            name: $config->getName(),
            skipPreflight: $config->skipPreflight(),
            responseValidator: $config->getResponseValidator(),
            responseMemoryExtractor: $config->getResponseMemoryExtractor(),
            responseMetricsExtractor: $config->getResponseMetricsExtractor(),
        );
    }

    /** @return list<int> */
    private function resolveConcurrencyLevels(int $maximum): array
    {
        if ($this->requestedConcurrencyLevels !== []) {
            if (max($this->requestedConcurrencyLevels) > $maximum) {
                throw new InvalidArgumentException("A concurrency level exceeds configured maximum {$maximum}");
            }
            return $this->requestedConcurrencyLevels;
        }

        $levels = [2, max(2, (int) round($maximum / 4)), max(2, (int) round($maximum / 2)), $maximum];
        $levels = array_values(array_unique($levels));
        sort($levels, SORT_NUMERIC);
        return $levels;
    }

    private function restartContainer(?string $container): void
    {
        if ($container === null) {
            return;
        }

        [$exitCode, , $error] = self::runProcess(['docker', 'restart', $container]);
        if ($exitCode !== 0) {
            throw new RuntimeException("Unable to restart container {$container}: " . trim($error));
        }

        $deadline = hrtime(true) + 30_000_000_000;
        do {
            [$inspectCode, $stateJson] = self::runProcess([
                'docker',
                'inspect',
                '--format',
                '{{json .State}}',
                $container,
            ]);
            if ($inspectCode === 0) {
                try {
                    $state = json_decode(trim($stateJson), true, 32, JSON_THROW_ON_ERROR);
                    if (($state['Running'] ?? false) === true) {
                        return;
                    }
                } catch (JsonException) {
                    // Retry until the bounded readiness deadline.
                }
            }
            usleep(300_000);
        } while (hrtime(true) < $deadline);

        throw new RuntimeException("Container {$container} did not enter the running state within 30 seconds");
    }

    private function waitForEndpoint(RequestBenchmark $benchmark, string $name): void
    {
        $deadline = hrtime(true) + 30_000_000_000;
        $lastFailure = null;

        do {
            try {
                $benchmark->preflight();
                return;
            } catch (RuntimeException $exception) {
                $lastFailure = $exception;
                usleep(300_000);
            }
        } while (hrtime(true) < $deadline);

        throw new RuntimeException(
            "Endpoint {$name} did not become reachable within 30 seconds: "
            . ($lastFailure?->getMessage() ?? 'unknown connectivity failure'),
            previous: $lastFailure,
        );
    }

    /** @return array{int, string, string} */
    private static function runProcess(array $command, float $timeoutSeconds = 10.0): array
    {
        $pipes = [];
        $process = proc_open(
            $command,
            [
                0 => ['file', '/dev/null', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ],
            $pipes,
        );
        if (!is_resource($process)) {
            throw new RuntimeException('Unable to start process: ' . implode(' ', $command));
        }

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);
        $output = '';
        $error = '';
        $deadline = hrtime(true) + (int) ($timeoutSeconds * 1_000_000_000);
        $timedOut = false;

        do {
            $stdoutChunk = stream_get_contents($pipes[1]);
            $stderrChunk = stream_get_contents($pipes[2]);
            if ($stdoutChunk !== false) {
                $output .= $stdoutChunk;
            }
            if ($stderrChunk !== false) {
                $error .= $stderrChunk;
            }

            $status = proc_get_status($process);
            if (!$status['running']) {
                break;
            }
            if (hrtime(true) >= $deadline) {
                $timedOut = true;
                proc_terminate($process);
                usleep(50_000);
                $status = proc_get_status($process);
                if ($status['running']) {
                    proc_terminate($process, 9);
                }
                break;
            }
            usleep(10_000);
        } while (true);

        $stdoutChunk = stream_get_contents($pipes[1]);
        $stderrChunk = stream_get_contents($pipes[2]);
        if ($stdoutChunk !== false) {
            $output .= $stdoutChunk;
        }
        if ($stderrChunk !== false) {
            $error .= $stderrChunk;
        }
        fclose($pipes[1]);
        fclose($pipes[2]);
        $closeCode = proc_close($process);
        $exitCode = $timedOut ? 124 : (($status['exitcode'] ?? -1) >= 0 ? $status['exitcode'] : $closeCode);

        if ($timedOut) {
            $error .= "\nProcess timed out after {$timeoutSeconds} seconds";
        }

        return [$exitCode, $output, $error];
    }

    /** @param list<array<string, int|float|bool|null>> $measurements */
    private static function medianMetrics(array $measurements, float $maximumRpmSpreadPercent): array
    {
        $result = [];
        foreach (array_keys($measurements[0]) as $key) {
            $values = [];
            foreach ($measurements as $measurement) {
                $value = $measurement[$key];
                if (is_int($value) || is_float($value) || is_bool($value)) {
                    $values[] = $value;
                }
            }
            if ($values === []) {
                $result[$key] = null;
                continue;
            }

            $median = self::median($values);
            $result[$key] = match (true) {
                is_bool($measurements[0][$key]) => $median >= 0.5,
                is_int($measurements[0][$key]) => (int) round($median),
                default => round($median, 5),
            };
        }

        $rpmValues = array_column($measurements, 'req_per_min');
        $rpmMedian = self::median($rpmValues);
        $deviations = [];
        foreach ($rpmValues as $rpm) {
            $deviations[] = abs($rpm - $rpmMedian);
        }
        $result['req_per_min_min'] = round((float) min($rpmValues), 5);
        $result['req_per_min_max'] = round((float) max($rpmValues), 5);
        $result['req_per_min_mad'] = round(self::median($deviations), 5);
        $result['req_per_min_spread_percent'] = round(
            $rpmMedian > 0 ? ((max($rpmValues) - min($rpmValues)) / $rpmMedian) * 100 : 0,
            5,
        );
        $result['rpm_stability'] = count($rpmValues) < 2
            ? 'unverified'
            : (
                $result['req_per_min_spread_percent'] <= $maximumRpmSpreadPercent
                    ? 'stable'
                    : 'unstable'
            );
        return $result;
    }

    /** @param list<mixed> $values */
    private static function rotate(array $values, int $offset): array
    {
        $count = count($values);
        if ($count < 2) {
            return array_values($values);
        }

        $offset %= $count;
        return [...array_slice($values, $offset), ...array_slice($values, 0, $offset)];
    }

    /** @param list<array<string, int|float>> $measurements */
    private static function combineContainerStats(array $measurements): array
    {
        $samples = 0;
        $memoryTotal = 0.0;
        $cpuTotal = 0.0;
        $peakMemory = 0.0;
        $peakCpu = 0.0;
        foreach ($measurements as $measurement) {
            $measurementSamples = (int) ($measurement['samples'] ?? 0);
            if ($measurementSamples < 1) {
                continue;
            }
            $samples += $measurementSamples;
            $memoryTotal += (float) $measurement['avgMemMB'] * $measurementSamples;
            $cpuTotal += (float) $measurement['avgCPU'] * $measurementSamples;
            $peakMemory = max($peakMemory, (float) $measurement['peakMemMB']);
            $peakCpu = max($peakCpu, (float) $measurement['peakCPU']);
        }

        if ($samples === 0) {
            return [];
        }

        return [
            'samples' => $samples,
            'avgMemMB' => round($memoryTotal / $samples, 5),
            'peakMemMB' => round($peakMemory, 5),
            'avgCPU' => round($cpuTotal / $samples, 5),
            'peakCPU' => round($peakCpu, 5),
        ];
    }

    /**
     * @param list<array<string, array{samples:int, average:float, minimum:float, maximum:float}>> $measurements
     * @return array<string, array{samples:int, average:float, minimum:float, maximum:float}>
     */
    private static function combineRemoteMetrics(array $measurements): array
    {
        $combined = [];
        foreach ($measurements as $measurement) {
            foreach ($measurement as $name => $metric) {
                $samples = (int) ($metric['samples'] ?? 0);
                if ($samples < 1) {
                    continue;
                }
                $combined[$name]['samples'] = ($combined[$name]['samples'] ?? 0) + $samples;
                $combined[$name]['total'] = ($combined[$name]['total'] ?? 0.0)
                    + ((float) $metric['average'] * $samples);
                $combined[$name]['minimum'] = isset($combined[$name]['minimum'])
                    ? min($combined[$name]['minimum'], (float) $metric['minimum'])
                    : (float) $metric['minimum'];
                $combined[$name]['maximum'] = isset($combined[$name]['maximum'])
                    ? max($combined[$name]['maximum'], (float) $metric['maximum'])
                    : (float) $metric['maximum'];
            }
        }

        $result = [];
        foreach ($combined as $name => $metric) {
            $result[$name] = [
                'samples' => $metric['samples'],
                'average' => round($metric['total'] / $metric['samples'], 5),
                'minimum' => round($metric['minimum'], 5),
                'maximum' => round($metric['maximum'], 5),
            ];
        }
        ksort($result);

        return $result;
    }

    /** @param list<int|float> $values */
    private static function median(array $values): float
    {
        sort($values, SORT_NUMERIC);
        $count = count($values);
        $middle = intdiv($count, 2);
        if ($count % 2 === 1) {
            return (float) $values[$middle];
        }
        return ((float) $values[$middle - 1] + (float) $values[$middle]) / 2;
    }

    /** @param list<int> $levels */
    private function configurationMetadata(
        BenchmarkConfig $config,
        array $levels,
        int $warmUp,
    ): array
    {
        $curl = curl_version();
        return [
            'url' => $config->getUrl(),
            'method' => $config->getMethod()->value,
            'expectedStatus' => $config->getExpectedStatus(),
            'countPerPhase' => $config->getCount(),
            'maxConcurrency' => $config->getThreads(),
            'concurrencyLevels' => $levels,
            'repetitions' => $this->repetitions,
            'maximumRpmSpreadPercent' => $this->maximumRpmSpreadPercent,
            'warmUpRequests' => $warmUp,
            'minimumDurationSeconds' => $this->minimumDurationSeconds,
            'timeoutSeconds' => $config->getTimeout(),
            'http2' => $config->isHttp2Enabled(),
            'verifySsl' => $config->isVerifySsl(),
            'pipingMode' => $config->getPiping()->value,
            'container' => $config->getContainer(),
            'sampleEverySeconds' => $config->getSampleInterval(),
            'skipPreflight' => $config->skipPreflight(),
            'headerNames' => array_keys($config->getHeaders()),
            'hasRequestBody' => $config->getBody() !== null,
            'customCurlOptions' => array_keys($config->getCurlOptions()),
            'responseValidation' => true,
            'responseMemoryExtraction' => $config->getResponseMemoryExtractor() !== null,
            'responseMetricsExtraction' => $config->getResponseMetricsExtractor() !== null,
            'loadGenerator' => 'php-curl-multi',
            'phpVersion' => PHP_VERSION,
            'phpSapi' => PHP_SAPI,
            'memoryLimit' => ini_get('memory_limit'),
            'cliOpcacheEnabled' => filter_var(ini_get('opcache.enable_cli'), FILTER_VALIDATE_BOOL),
            'cliOpcacheJit' => ini_get('opcache.jit'),
            'xdebugLoaded' => extension_loaded('xdebug'),
            'curlVersion' => $curl['version'] ?? 'unknown',
            'operatingSystem' => PHP_OS_FAMILY . ' ' . php_uname('r'),
            'recordedAt' => date(DATE_ATOM),
        ];
    }

    private function toMarkdownTable(array $data): string
    {
        uasort($data, self::compareResults(...));

        $summaryRows = [];
        $serialLatencyRows = [];
        $concurrentLatencyRows = [];
        $serialReliabilityRows = [];
        $concurrentReliabilityRows = [];
        $curveRows = [];
        $resourceRows = [];
        $remoteMetricRows = [];
        foreach ($data as $name => $result) {
            $stable = $result['stable'];
            $peak = $result['peak'];
            $summaryRows[] = [
                $result['rank'],
                $name,
                self::displayNumber($stable['req_per_min'] ?? null, 0),
                $stable['concurrency'] ?? null,
                self::displayNumber($peak['req_per_min'], 0),
                $peak['concurrency'],
                ucfirst($peak['rpm_stability']),
                self::displayNumber($result['totalDuration'], 1),
            ];

            $serialLatencyRows[$name] = self::latencyRow($name, $result['single']);
            $serialReliabilityRows[$name] = self::reliabilityRow($name, $result['single']);

            foreach ($result['throughputCurve'] as $concurrency => $metrics) {
                $runRpms = [];
                foreach ($result['runs'] as $run) {
                    $runRpms[] = self::displayNumber(
                        $run['concurrency'][$concurrency]['req_per_min'],
                        0,
                    );
                }
                $curveRows[$concurrency][$name] = [
                    $name,
                    self::displayNumber($metrics['req_per_min'], 0),
                    self::displayPercent($metrics['req_per_min_spread_percent']),
                    ucfirst($metrics['rpm_stability']),
                    ...$runRpms,
                ];
                $concurrentLatencyRows[$concurrency][$name] = self::latencyRow($name, $metrics);
                $concurrentReliabilityRows[$concurrency][$name] = self::reliabilityRow($name, $metrics);
            }

            if ($result['container'] !== [] || $result['remoteMemoryMB'] !== null) {
                $resourceRows[] = [
                    $name,
                    $result['container']['samples'] ?? 0,
                    self::displayPercent($result['container']['avgCPU'] ?? null),
                    self::displayPercent($result['container']['peakCPU'] ?? null),
                    self::displayNumber($result['container']['avgMemMB'] ?? null, 2),
                    self::displayNumber($result['container']['peakMemMB'] ?? null, 2),
                    self::displayNumber($result['remoteMemoryMB'], 2),
                ];
            }
            foreach ($result['remoteMetrics'] ?? [] as $metric => $values) {
                $remoteMetricRows[] = [
                    $name,
                    self::humanize($metric),
                    $values['samples'],
                    self::displayNumber($values['average'], 5),
                    self::displayNumber($values['minimum'], 5),
                    self::displayNumber($values['maximum'], 5),
                ];
            }
        }

        $peakBaseline = self::minimumPositive(array_map(
            static fn(array $result): mixed => $result['peak']['req_per_min'] ?? null,
            $data,
        ));
        $memoryBaseline = self::minimumPositive(array_map(
            static fn(array $result): mixed => $result['remoteMemoryMB'] ?? null,
            $data,
        ));
        $executionBaseline = self::minimumPositive(array_map(
            static fn(array $result): mixed => $result['remoteMetrics']['server_execution_ms']['average'] ?? null,
            $data,
        ));
        $filesBaseline = self::minimumPositive(array_map(
            static fn(array $result): mixed => $result['remoteMetrics']['included_files']['average'] ?? null,
            $data,
        ));
        $relativeRows = [];
        foreach ($data as $name => $result) {
            $relativeRows[] = [
                $name,
                self::displayMultiple($result['peak']['req_per_min'] ?? null, $peakBaseline),
                self::displayMultiple($result['remoteMemoryMB'] ?? null, $memoryBaseline),
                self::displayMultiple(
                    $result['remoteMetrics']['server_execution_ms']['average'] ?? null,
                    $executionBaseline,
                ),
                self::displayMultiple(
                    $result['remoteMetrics']['included_files']['average'] ?? null,
                    $filesBaseline,
                ),
            ];
        }

        [$commonConfiguration, $targetConfiguration] = self::groupConfiguration($data);
        $environmentKeys = [
            'loadGenerator',
            'phpVersion',
            'phpSapi',
            'memoryLimit',
            'cliOpcacheEnabled',
            'cliOpcacheJit',
            'xdebugLoaded',
            'curlVersion',
            'operatingSystem',
        ];
        $environmentRows = [];
        foreach ($environmentKeys as $key) {
            if (!array_key_exists($key, $commonConfiguration)) {
                continue;
            }
            if ($commonConfiguration[$key] === null || $commonConfiguration[$key] === '') {
                unset($commonConfiguration[$key]);
                continue;
            }
            $environmentRows[] = [self::humanize($key), self::displayValue($commonConfiguration[$key])];
            unset($commonConfiguration[$key]);
        }
        $usesContainer = false;
        foreach ($data as $result) {
            if (($result['configuration']['container'] ?? null) !== null) {
                $usesContainer = true;
                break;
            }
        }
        $commonRows = [];
        foreach ($commonConfiguration as $key => $value) {
            if ($key === 'responseValidation' || (is_array($value) && $value === [])) {
                continue;
            }
            if (($key === 'container' && $value === null) || ($key === 'sampleEverySeconds' && !$usesContainer)) {
                continue;
            }
            $commonRows[] = [self::humanize($key), self::displayValue($value)];
        }
        $targetKeys = [];
        foreach ($targetConfiguration as $configuration) {
            foreach (array_keys($configuration) as $key) {
                $targetKeys[$key] = true;
            }
        }
        $targetRows = [];
        foreach (array_keys($targetKeys) as $key) {
            if ($key === 'recordedAt') {
                continue;
            }
            $row = [self::humanize($key)];
            foreach ($targetConfiguration as $configuration) {
                $row[] = self::displayValue($configuration[$key] ?? null);
            }
            $targetRows[] = $row;
        }

        $sections = [
            self::markdownTable('Sustainable ranking',
                [
                    'Rank',
                    'Target',
                    'Best stable RPM',
                    'Stable concurrency',
                    'Peak observed RPM',
                    'Peak concurrency',
                    'Peak stability',
                    'Duration s',
                ],
                $summaryRows,
            ),
        ];
        ksort($curveRows, SORT_NUMERIC);
        foreach ($curveRows as $concurrency => $rows) {
            uksort($rows, fn(string $left, string $right): int => self::compareThroughput(
                $data[$left]['throughputCurve'][$concurrency],
                $data[$right]['throughputCurve'][$concurrency],
                $left,
                $right,
            ));
            $runHeaders = [];
            for ($run = 1; $run <= $this->repetitions; ++$run) {
                $runHeaders[] = "Run {$run} RPM";
            }
            $sections[] = self::markdownTable("Throughput — concurrency {$concurrency}",
                ['Target', 'Median RPM', 'RPM spread', 'Stability', ...$runHeaders],
                array_values($rows),
            );
        }
        uksort($serialLatencyRows, fn(string $left, string $right): int => self::compareLatency(
            $data[$left]['single'],
            $data[$right]['single'],
            $left,
            $right,
        ));
        $sections[] = self::markdownTable('Latency — serial',
            ['Target', 'p50 ms', 'p95 ms', 'p99 ms', 'Connect ms', 'TTFB ms'],
            array_values($serialLatencyRows),
        );
        ksort($concurrentLatencyRows, SORT_NUMERIC);
        foreach ($concurrentLatencyRows as $concurrency => $rows) {
            uksort($rows, fn(string $left, string $right): int => self::compareLatency(
                $data[$left]['throughputCurve'][$concurrency],
                $data[$right]['throughputCurve'][$concurrency],
                $left,
                $right,
            ));
            $sections[] = self::markdownTable("Latency — concurrency {$concurrency}",
                ['Target', 'p50 ms', 'p95 ms', 'p99 ms', 'Connect ms', 'TTFB ms'],
                array_values($rows),
            );
        }
        uksort($serialReliabilityRows, fn(string $left, string $right): int => self::compareReliability(
            $data[$left]['single'],
            $data[$right]['single'],
            $left,
            $right,
        ));
        $sections[] = self::markdownTable('Reliability — serial',
            ['Target', 'Attempted', 'Successful', 'Error rate', 'Transfer', 'Timeout', 'Status', 'Validation'],
            array_values($serialReliabilityRows),
        );
        ksort($concurrentReliabilityRows, SORT_NUMERIC);
        foreach ($concurrentReliabilityRows as $concurrency => $rows) {
            uksort($rows, fn(string $left, string $right): int => self::compareReliability(
                $data[$left]['throughputCurve'][$concurrency],
                $data[$right]['throughputCurve'][$concurrency],
                $left,
                $right,
            ));
            $sections[] = self::markdownTable("Reliability — concurrency {$concurrency}",
                ['Target', 'Attempted', 'Successful', 'Error rate', 'Transfer', 'Timeout', 'Status', 'Validation'],
                array_values($rows),
            );
        }
        if ($relativeRows !== []) {
            $sections[] = self::markdownTable('Relative comparison',
                ['Target', 'Peak throughput', 'Remote memory', 'Server time', 'Included files'],
                $relativeRows,
            );
        }
        if ($resourceRows !== []) {
            $sections[] = self::markdownTable('Resource telemetry',
                ['Target', 'Samples', 'Avg CPU', 'Peak CPU', 'Avg MB', 'Peak MB', 'Remote MB'],
                $resourceRows,
            );
        }
        if ($remoteMetricRows !== []) {
            $sections[] = self::markdownTable('Server response telemetry',
                ['Target', 'Metric', 'Samples', 'Average', 'Minimum', 'Maximum'],
                $remoteMetricRows,
            );
        }
        if ($commonRows !== []) {
            $sections[] = self::markdownTable('Common configuration', ['Setting', 'Value'], $commonRows);
        }
        if ($environmentRows !== []) {
            $sections[] = self::markdownTable('Load-generator environment', ['Setting', 'Value'], $environmentRows);
        }
        if ($targetRows !== []) {
            $sections[] = self::markdownTable(
                'Target-specific configuration',
                ['Setting', ...array_keys($targetConfiguration)],
                $targetRows,
            );
        }

        return implode("\n\n", $sections) . "\n";
    }

    private static function compareResults(array $left, array $right): int
    {
        if ($left['score'] === null) {
            return $right['score'] === null
                ? (((float) $right['peak']['req_per_min'] <=> (float) $left['peak']['req_per_min'])
                    ?: strcmp((string) $left['name'], (string) $right['name']))
                : 1;
        }
        if ($right['score'] === null) {
            return -1;
        }

        return ((float) $right['score'] <=> (float) $left['score'])
            ?: strcmp((string) $left['name'], (string) $right['name']);
    }

    private static function compareThroughput(
        array $left,
        array $right,
        string $leftName,
        string $rightName,
    ): int {
        return ((float) $right['req_per_min'] <=> (float) $left['req_per_min'])
            ?: ((float) $left['error_rate'] <=> (float) $right['error_rate'])
            ?: ((float) $left['p50'] <=> (float) $right['p50'])
            ?: strcmp($leftName, $rightName);
    }

    private static function compareLatency(
        array $left,
        array $right,
        string $leftName,
        string $rightName,
    ): int {
        return ((float) $left['p50'] <=> (float) $right['p50'])
            ?: ((float) $left['p95'] <=> (float) $right['p95'])
            ?: ((float) $left['p99'] <=> (float) $right['p99'])
            ?: strcmp($leftName, $rightName);
    }

    private static function compareReliability(
        array $left,
        array $right,
        string $leftName,
        string $rightName,
    ): int {
        $leftFailures = $left['attempted_requests'] - $left['successful_requests'];
        $rightFailures = $right['attempted_requests'] - $right['successful_requests'];

        return ((float) $left['error_rate'] <=> (float) $right['error_rate'])
            ?: ($leftFailures <=> $rightFailures)
            ?: ($right['successful_requests'] <=> $left['successful_requests'])
            ?: strcmp($leftName, $rightName);
    }

    private static function latencyRow(string $name, array $metrics): array
    {
        return [
            $name,
            self::displayMilliseconds($metrics['p50']),
            self::displayMilliseconds($metrics['p95']),
            self::displayMilliseconds($metrics['p99']),
            self::displayMilliseconds($metrics['avg_connect_time']),
            self::displayMilliseconds($metrics['avg_ttfb']),
        ];
    }

    private static function reliabilityRow(string $name, array $metrics): array
    {
        return [
            $name,
            $metrics['attempted_requests'],
            $metrics['successful_requests'],
            self::displayPercent($metrics['error_rate'] * 100),
            $metrics['transfer_errors'],
            $metrics['timeout_failures'],
            $metrics['status_failures'],
            $metrics['validation_failures'],
        ];
    }

    /** @return array{array<string, mixed>, array<string, array<string, mixed>>} */
    private static function groupConfiguration(array $data): array
    {
        $allKeys = [];
        foreach ($data as $result) {
            foreach (array_keys($result['configuration']) as $key) {
                $allKeys[$key] = true;
            }
        }

        $common = [];
        $specific = array_fill_keys(array_keys($data), []);
        $alwaysSpecific = ['url' => true, 'recordedAt' => true];
        foreach (array_keys($allKeys) as $key) {
            $values = [];
            $signatures = [];
            foreach ($data as $name => $result) {
                $value = $result['configuration'][$key] ?? null;
                $values[$name] = $value;
                $signatures[json_encode($value, JSON_THROW_ON_ERROR)] = true;
            }

            if (count($signatures) === 1 && !isset($alwaysSpecific[$key])) {
                $common[$key] = reset($values);
                continue;
            }
            foreach ($values as $name => $value) {
                $specific[$name][$key] = $value;
            }
        }

        return [$common, $specific];
    }

    private static function markdownTable(string $title, array $header, array $rows): string
    {
        $escape = static fn(mixed $value): string => str_replace(
            ['|', "\r", "\n"],
            ['\\|', ' ', ' '],
            (string) ($value ?? '—'),
        );
        $header = array_map($escape, $header);
        $lines = [
            "## {$title}",
            '',
            '| ' . implode(' | ', $header) . ' |',
            '| ' . implode(' | ', array_fill(0, count($header), '---')) . ' |',
        ];
        foreach ($rows as $row) {
            $lines[] = '| ' . implode(' | ', array_map($escape, $row)) . ' |';
        }
        return implode("\n", $lines);
    }

    private static function displayMilliseconds(mixed $seconds): string
    {
        return is_numeric($seconds) ? self::displayNumber((float) $seconds * 1_000, 2) : '—';
    }

    private static function displayNumber(mixed $value, int $decimals): string
    {
        return is_numeric($value) ? number_format((float) $value, $decimals, '.', ',') : '—';
    }

    /** @param array<int|string, mixed> $values */
    private static function minimumPositive(array $values): ?float
    {
        $positive = array_values(array_filter(
            $values,
            static fn(mixed $value): bool => is_numeric($value) && (float) $value > 0,
        ));

        return $positive === [] ? null : (float) min($positive);
    }

    private static function displayMultiple(mixed $value, ?float $baseline): string
    {
        if (!is_numeric($value) || $baseline === null || $baseline <= 0) {
            return '—';
        }

        return number_format((float) $value / $baseline, 2, '.', ',') . '×';
    }

    private static function displayPercent(mixed $value): string
    {
        return is_numeric($value) ? self::displayNumber($value, 2) . '%' : '—';
    }

    private static function displayValue(mixed $value): string
    {
        return match (true) {
            is_bool($value) => $value ? 'yes' : 'no',
            is_array($value) => implode(', ', array_map(static fn(mixed $item): string => (string) $item, $value)),
            $value === null, $value === '' => '—',
            default => (string) $value,
        };
    }

    private static function humanize(string $key): string
    {
        if ($key === 'cliOpcacheEnabled') {
            return 'CLI OPcache enabled';
        }
        if ($key === 'cliOpcacheJit') {
            return 'CLI OPcache JIT mode';
        }
        $words = str_replace('_', ' ', $key);
        $words = preg_replace('/(?<!^)[A-Z]/', ' $0', $words) ?? $words;
        return ucfirst(strtolower($words));
    }

    private function toCsv(array $data): string
    {
        [$header, $rows] = $this->flatten($data);
        $stream = fopen('php://memory', 'r+');
        if ($stream === false) {
            throw new RuntimeException('Unable to open CSV output stream');
        }

        fputcsv($stream, $header);
        foreach ($rows as $row) {
            fputcsv($stream, $row);
        }
        rewind($stream);
        $csv = stream_get_contents($stream);
        fclose($stream);
        if ($csv === false) {
            throw new RuntimeException('Unable to read CSV output stream');
        }
        return $csv;
    }

    private function flatten(array $data): array
    {
        $flat = [];
        foreach ($data as $name => $result) {
            $metrics = [
                'rank' => $result['rank'],
                'stableRPM' => $result['stable']['req_per_min'] ?? null,
                'stableConcurrency' => $result['stable']['concurrency'] ?? null,
                'peakObservedRPM' => $result['peak']['req_per_min'],
                'peakObservedConcurrency' => $result['peak']['concurrency'],
                'peakObservedStability' => $result['peak']['rpm_stability'],
                'totalDuration' => $result['totalDuration'],
                'remoteMemoryMB' => $result['remoteMemoryMB'],
            ];
            foreach ($result['single'] as $key => $value) {
                $metrics["single.{$key}"] = $value;
            }
            foreach ($result['multiple'] as $key => $value) {
                $metrics["multiple.{$key}"] = $value;
            }
            foreach ($result['throughputCurve'] as $level => $curve) {
                foreach (['req_per_min', 'error_rate', 'p99'] as $key) {
                    $metrics["concurrency.{$level}.{$key}"] = $curve[$key];
                }
            }
            foreach ($result['container'] as $key => $value) {
                $metrics["container.{$key}"] = $value;
            }
            foreach ($result['remoteMetrics'] ?? [] as $metric => $values) {
                foreach ($values as $key => $value) {
                    $metrics["remoteMetrics.{$metric}.{$key}"] = $value;
                }
            }
            foreach ($result['configuration'] as $key => $value) {
                $metrics["configuration.{$key}"] = is_array($value) ? implode(',', $value) : $value;
            }
            $flat[$name] = $metrics;
        }

        $metricNames = [];
        foreach ($flat as $metrics) {
            foreach (array_keys($metrics) as $metric) {
                $metricNames[$metric] = true;
            }
        }

        $rows = [];
        foreach (array_keys($metricNames) as $metric) {
            $row = [$metric];
            foreach ($flat as $metrics) {
                $row[] = $metrics[$metric] ?? '';
            }
            $rows[] = $row;
        }

        return [['Metric', ...array_keys($flat)], $rows];
    }

    private static function validateThreads(int $threads): void
    {
        if ($threads < 2 || $threads > BenchmarkConfig::MAX_THREADS) {
            throw new InvalidArgumentException(sprintf(
                'Threads must be between 2 and %d',
                BenchmarkConfig::MAX_THREADS,
            ));
        }
    }

    private static function validateCount(int $count): void
    {
        if ($count < 100 || $count > BenchmarkConfig::MAX_COUNT) {
            throw new InvalidArgumentException(sprintf(
                'Count must be between 100 and %d',
                BenchmarkConfig::MAX_COUNT,
            ));
        }
    }

    private static function secondsSince(int $startedAt): float
    {
        return round((hrtime(true) - $startedAt) / 1_000_000_000, 5);
    }
}
