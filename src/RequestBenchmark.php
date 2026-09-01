<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use Closure;
use LogicException;
use RuntimeException;
use Throwable;

/** Executes and classifies HTTP benchmark traffic for one resolved configuration. */
final class RequestBenchmark
{
    private float $remoteMemoryTotal = 0.0;
    private int $remoteMemorySamples = 0;

    /** @var array<string, list<float>> */
    private array $remoteMetrics = [];

    private readonly ?Closure $progress;

    public function __construct(
        private readonly BenchmarkConfig $config,
        ?callable $progress = null,
    ) {
        $this->progress = $progress === null ? null : Closure::fromCallable($progress);
        if (
            $config->getThreads() === null
            || $config->getCount() === null
            || $config->getPiping() === null
            || $config->getTimeout() === null
        ) {
            throw new LogicException('RequestBenchmark requires a configuration with resolved runtime defaults');
        }
    }

    /** Run one serial and one configured-concurrency measurement. */
    public function run(): array
    {
        $this->resetMeasurements();

        if (!$this->config->skipPreflight()) {
            $this->preflight();
        }

        $startedAt = hrtime(true);
        $single = $this->runSingleThreaded();
        $multiple = $this->runConcurrent($this->config->getThreads());

        return [
            'name' => $this->config->getName(),
            'single' => $single,
            'multiple' => $multiple,
            'totalDuration' => self::secondsSince($startedAt),
            'remoteMemoryMB' => $this->getRemoteMemoryMB(),
            'remoteMetrics' => $this->getRemoteMetrics(),
        ];
    }

    /** Perform a non-mutating connectivity probe. */
    public function preflight(): void
    {
        foreach ($this->config->getRouteScenarios() as $scenario) {
            $options = $this->prepareOptions($scenario);
            unset($options[CURLOPT_POSTFIELDS]);
            $options[CURLOPT_CUSTOMREQUEST] = HttpMethod::HEAD->value;
            $options[CURLOPT_NOBODY] = true;

            $handle = curl_init();
            try {
            if (!curl_setopt_array($handle, $options)) {
                throw new RuntimeException('Unable to configure the preflight request');
            }

            $response = curl_exec($handle);
            $status = (int) curl_getinfo($handle, CURLINFO_HTTP_CODE);
            if ($response === false || $status === 0) {
                throw new RuntimeException(sprintf(
                    'Connectivity failed (%s): [%d] %s',
                    $scenario->getUrl(),
                    curl_errno($handle),
                    curl_error($handle),
                ));
            }
            if ($status >= 500) {
                throw new RuntimeException(sprintf(
                    'Endpoint is not ready (%s): HTTP %d',
                    $scenario->getUrl(),
                    $status,
                ));
            }
            } finally {
                curl_close($handle);
            }
        }
    }

    /** Warm safe read-only endpoints without including the traffic in results. */
    public function warmUp(int $requests): void
    {
        if ($requests < 0) {
            throw new LogicException('Warm-up request count cannot be negative');
        }
        if ($requests === 0) {
            return;
        }
        $handle = curl_init();
        try {
            $iteration = 0;
            foreach ($this->config->getRouteScenarios() as $scenario) {
                if (!$scenario->isSafeForWarmUp()) {
                    continue;
                }
                $options = $this->prepareOptions($scenario);
                for ($i = 0; $i < $requests; ++$i) {
                    if ($iteration++ > 0) {
                        curl_reset($handle);
                    }
                    if (!curl_setopt_array($handle, $options)) {
                        throw new RuntimeException('Unable to configure a warm-up request');
                    }

                    $response = curl_exec($handle);
                    $info = curl_getinfo($handle);
                    $failure = $this->classify($scenario, $response, $info, curl_errno($handle));
                    if ($failure !== null) {
                        $detail = match ($failure) {
                            'status' => sprintf(
                                'expected HTTP %d, received HTTP %d',
                                $scenario->getExpectedStatus(),
                                (int) ($info['http_code'] ?? 0),
                            ),
                            'timeout' => 'request timed out',
                            'transfer' => sprintf('[%d] %s', curl_errno($handle), curl_error($handle)),
                            'validation' => 'response validator rejected the body',
                        };
                        throw new RuntimeException(sprintf(
                            'Warm-up request failed validation for %s: %s',
                            $scenario->getLabel(),
                            $detail,
                        ));
                    }
                }
            }
        } finally {
            curl_close($handle);
        }
    }

    /**
     * Validate the configured status and response contract before measurement.
     * Mutating methods receive connectivity validation only to avoid side effects.
     */
    public function validateTarget(): void
    {
        try {
            $this->warmUp(1);
        } catch (RuntimeException $exception) {
            throw new RuntimeException(sprintf(
                'Target validation failed (%s): %s',
                $this->config->getUrl(),
                $exception->getMessage(),
            ), previous: $exception);
        }
    }

    public function resetMeasurements(): void
    {
        $this->remoteMemoryTotal = 0.0;
        $this->remoteMemorySamples = 0;
        $this->remoteMetrics = [];
    }

    public function getRemoteMemoryMB(): ?float
    {
        if ($this->remoteMemorySamples === 0) {
            return null;
        }

        return round(($this->remoteMemoryTotal / $this->remoteMemorySamples) / 1_048_576, 2);
    }

    /**
     * @return array<string, array{samples:int, average:float, minimum:float, maximum:float}>
     */
    public function getRemoteMetrics(): array
    {
        $metrics = [];
        foreach ($this->remoteMetrics as $name => $values) {
            if ($values === []) {
                continue;
            }
            $metrics[$name] = [
                'samples' => count($values),
                'average' => round(array_sum($values) / count($values), 5),
                'minimum' => round(min($values), 5),
                'maximum' => round(max($values), 5),
            ];
        }
        ksort($metrics);

        return $metrics;
    }

    public function runSingleThreaded(): array
    {
        $scenarios = $this->config->getRouteScenarios();
        $handle = curl_init();
        $latencies = [];
        $connectTotal = 0.0;
        $ttfbTotal = 0.0;
        $counters = self::emptyCounters();
        $startedAt = hrtime(true);
        $progressStride = max(1, intdiv($this->config->getCount(), 100));
        $nextProgress = $progressStride;
        $lastProgressAt = $startedAt;

        try {
            for ($i = 0, $count = $this->config->getCount(); $i < $count; ++$i) {
                $scenario = $scenarios[$i % count($scenarios)];
                $options = $this->prepareOptions($scenario);
                if ($i > 0) {
                    curl_reset($handle);
                }
                if (!curl_setopt_array($handle, $options)) {
                    throw new RuntimeException('Unable to configure a serial benchmark request');
                }

                $requestStartedAt = hrtime(true);
                $response = curl_exec($handle);
                $elapsed = self::secondsSince($requestStartedAt);
                $info = curl_getinfo($handle);
                $failure = $this->classify($scenario, $response, $info, curl_errno($handle));
                self::recordResult($counters, $failure);

                if ($failure === null) {
                    $latencies[] = $elapsed;
                    $connectTotal += (float) ($info['connect_time'] ?? 0.0);
                    $ttfbTotal += (float) ($info['starttransfer_time'] ?? 0.0);
                    $this->captureRemoteMeasurements($response, $info);
                }

                $completed = $i + 1;
                if ($this->progress !== null && ($completed >= $nextProgress || $completed === $count)) {
                    $now = hrtime(true);
                    if ($completed === $count || $now - $lastProgressAt >= 100_000_000) {
                        $this->notifyProgress($completed, $count, $startedAt, 0.0, 'serial');
                        $lastProgressAt = $now;
                    }
                    $nextProgress = $completed + $progressStride;
                }
            }
        } finally {
            curl_close($handle);
        }

        return self::buildMetrics(
            $counters,
            $latencies,
            self::secondsSince($startedAt),
            $connectTotal,
            $ttfbTotal,
            1,
        );
    }

    public function runConcurrent(int $threads, float $minimumDurationSeconds = 0.0): array
    {
        if ($threads < 2 || $threads > BenchmarkConfig::MAX_THREADS) {
            throw new LogicException('Concurrent thread count is outside the configured safety bounds');
        }
        if ($minimumDurationSeconds < 0 || $minimumDurationSeconds > BenchmarkConfig::MAX_PHASE_DURATION_SECONDS) {
            throw new LogicException('Minimum phase duration is outside the configured safety bounds');
        }

        $scenarios = $this->config->getRouteScenarios();
        $multi = curl_multi_init();
        $active = [];
        $latencies = [];
        $connectTotal = 0.0;
        $ttfbTotal = 0.0;
        $counters = self::emptyCounters();
        $launched = 0;
        $inFlight = 0;
        $minimumRequests = $this->config->getCount();
        $maximumRequests = BenchmarkConfig::MAX_COUNT;
        $progressStride = max(1, intdiv($minimumRequests, 100));
        $nextProgress = $progressStride;

        foreach ([
            CURLMOPT_MAX_TOTAL_CONNECTIONS => $threads,
            CURLMOPT_MAX_HOST_CONNECTIONS => $threads,
            CURLMOPT_PIPELINING => $this->pipelineMode(),
        ] as $option => $value) {
            if (!curl_multi_setopt($multi, $option, $value)) {
                throw new RuntimeException("Unable to set cURL multi option {$option}");
            }
        }

        $enqueue = function () use ($multi, $scenarios, &$active, &$launched, &$inFlight): void {
            $scenario = $scenarios[$launched % count($scenarios)];
            $options = $this->prepareOptions($scenario);
            $handle = curl_init();
            if (!curl_setopt_array($handle, $options)) {
                curl_close($handle);
                throw new RuntimeException('Unable to configure a concurrent benchmark request');
            }
            if (curl_multi_add_handle($multi, $handle) !== CURLM_OK) {
                curl_close($handle);
                throw new RuntimeException('Unable to add a concurrent benchmark request');
            }

            $active[spl_object_id($handle)] = ['handle' => $handle, 'scenario' => $scenario];
            ++$launched;
            ++$inFlight;
        };

        $startedAt = hrtime(true);
        $lastProgressAt = $startedAt;
        try {
            for ($i = 0, $initial = min($threads, $minimumRequests); $i < $initial; ++$i) {
                $enqueue();
            }

            do {
                do {
                    $multiStatus = curl_multi_exec($multi, $running);
                } while ($multiStatus === CURLM_CALL_MULTI_PERFORM);

                if ($multiStatus !== CURLM_OK) {
                    throw new RuntimeException("cURL multi execution failed with code {$multiStatus}");
                }

                while (($completed = curl_multi_info_read($multi)) !== false) {
                    $handle = $completed['handle'];
                    $activeRequest = $active[spl_object_id($handle)] ?? null;
                    if (!is_array($activeRequest) || !($activeRequest['scenario'] ?? null) instanceof RouteScenario) {
                        throw new RuntimeException('Unable to resolve the completed request route scenario');
                    }
                    $scenario = $activeRequest['scenario'];
                    $response = curl_multi_getcontent($handle);
                    $info = curl_getinfo($handle);
                    $result = (int) ($completed['result'] ?? CURLE_OK);
                    $failure = $this->classify($scenario, $response, $info, $result);
                    self::recordResult($counters, $failure);

                    if ($failure === null) {
                        $latencies[] = (float) ($info['total_time'] ?? 0.0);
                        $connectTotal += (float) ($info['connect_time'] ?? 0.0);
                        $ttfbTotal += (float) ($info['starttransfer_time'] ?? 0.0);
                        $this->captureRemoteMeasurements($response, $info);
                    }

                    $completedRequests = $counters['attempted_requests'];
                    if ($this->progress !== null && $completedRequests >= $nextProgress) {
                        $now = hrtime(true);
                        if ($now - $lastProgressAt >= 100_000_000) {
                            $this->notifyProgress(
                                $completedRequests,
                                $minimumRequests,
                                $startedAt,
                                $minimumDurationSeconds,
                                "concurrency {$threads}",
                            );
                            $lastProgressAt = $now;
                        }
                        $nextProgress = $completedRequests + $progressStride;
                    }

                    curl_multi_remove_handle($multi, $handle);
                    curl_close($handle);
                    unset($active[spl_object_id($handle)]);
                    --$inFlight;

                    $needsMoreRequests = $launched < $minimumRequests
                        || self::secondsSince($startedAt) < $minimumDurationSeconds;
                    if ($needsMoreRequests && $launched < $maximumRequests) {
                        $enqueue();
                    }
                }

                if ($inFlight > 0) {
                    $selected = curl_multi_select($multi, 1.0);
                    if ($selected === -1) {
                        usleep(1_000);
                    }
                }
            } while ($inFlight > 0);
        } finally {
            foreach ($active as $request) {
                $handle = $request['handle'];
                curl_multi_remove_handle($multi, $handle);
                curl_close($handle);
            }
            curl_multi_close($multi);
        }

        $this->notifyProgress(
            $counters['attempted_requests'],
            $minimumRequests,
            $startedAt,
            $minimumDurationSeconds,
            "concurrency {$threads}",
        );

        return self::buildMetrics(
            $counters,
            $latencies,
            self::secondsSince($startedAt),
            $connectTotal,
            $ttfbTotal,
            $threads,
            $minimumDurationSeconds,
        );
    }

    private function baseCurlOptions(): array
    {
        $verifySsl = $this->config->isVerifySsl() ?? true;
        $sslOptions = $verifySsl
            ? [CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_SSL_VERIFYPEER => true]
            : [CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => false];

        return $sslOptions + [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => $this->config->getTimeout(),
            CURLOPT_TIMEOUT => $this->config->getTimeout(),
        ] + $this->config->getCurlOptions();
    }

    private function prepareOptions(?RouteScenario $scenario = null): array
    {
        $scenario ??= $this->config->getRouteScenarios()[0];
        $options = [
            CURLOPT_URL => $scenario->getUrl(),
            CURLOPT_CUSTOMREQUEST => $scenario->getMethod()->value,
        ];
        $body = $this->config->getBody();
        $headers = $this->config->getHeaders();

        if (is_array($body)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($body, JSON_THROW_ON_ERROR);
            $headers['Content-Type'] ??= 'application/json';
        } elseif (is_string($body)) {
            $options[CURLOPT_POSTFIELDS] = $body;
        }

        if ($headers !== []) {
            $options[CURLOPT_HTTPHEADER] = [];
            foreach ($headers as $name => $value) {
                if (!is_string($name) || (!is_string($value) && !is_numeric($value))) {
                    throw new LogicException('HTTP headers must be a string-keyed map of scalar values');
                }
                $options[CURLOPT_HTTPHEADER][] = "{$name}: {$value}";
            }
        }

        $options[CURLOPT_HTTP_VERSION] = ($this->config->isHttp2Enabled() ?? false)
            ? CURL_HTTP_VERSION_2_0
            : CURL_HTTP_VERSION_1_1;
        if ($scenario->getMethod() === HttpMethod::HEAD) {
            $options[CURLOPT_NOBODY] = true;
        }

        return $options + $this->baseCurlOptions();
    }

    private function pipelineMode(): int
    {
        return match ($this->config->getPiping()) {
            PipingMode::Optimal => ($this->config->isHttp2Enabled() ?? false) ? CURLPIPE_MULTIPLEX : 0,
            PipingMode::Max => CURLPIPE_MULTIPLEX,
        };
    }

    /** @param array<string, mixed> $info */
    private function classify(
        RouteScenario $scenario,
        string|false $response,
        array $info,
        int $transferResult,
    ): ?string
    {
        if ($transferResult === CURLE_OPERATION_TIMEDOUT) {
            return 'timeout';
        }
        if ($response === false || $transferResult !== CURLE_OK) {
            return 'transfer';
        }
        if ((int) ($info['http_code'] ?? 0) !== $scenario->getExpectedStatus()) {
            return 'status';
        }

        try {
            if (!(($scenario->getResponseValidator())($response, $info))) {
                return 'validation';
            }
        } catch (Throwable) {
            return 'validation';
        }

        return null;
    }

    /** @param array<string, mixed> $info */
    private function captureRemoteMeasurements(string|false $response, array $info): void
    {
        if (!is_string($response)) {
            return;
        }

        $memoryExtractor = $this->config->getResponseMemoryExtractor();
        if ($memoryExtractor !== null) {
            try {
                $memory = $memoryExtractor($response, $info);
                if (is_int($memory) || is_float($memory)) {
                    if (is_finite((float) $memory) && $memory >= 0) {
                        $this->remoteMemoryTotal += (float) $memory;
                        ++$this->remoteMemorySamples;
                    }
                }
            } catch (Throwable) {
                // Optional telemetry must not change response correctness.
            }
        }

        $metricsExtractor = $this->config->getResponseMetricsExtractor();
        if ($metricsExtractor === null) {
            return;
        }

        try {
            $metrics = $metricsExtractor($response, $info);
            if (!is_array($metrics)) {
                return;
            }
            foreach ($metrics as $name => $value) {
                if (
                    !is_string($name)
                    || preg_match('/^[a-z][a-z0-9_]{0,63}$/', $name) !== 1
                    || (!is_int($value) && !is_float($value))
                    || !is_finite((float) $value)
                    || $value < 0
                ) {
                    continue;
                }
                $this->remoteMetrics[$name][] = (float) $value;
            }
        } catch (Throwable) {
            // Optional telemetry must not change response correctness.
        }
    }

    /** @return array<string, int> */
    private static function emptyCounters(): array
    {
        return [
            'attempted_requests' => 0,
            'successful_requests' => 0,
            'failed_requests' => 0,
            'transfer_errors' => 0,
            'timeout_failures' => 0,
            'status_failures' => 0,
            'validation_failures' => 0,
        ];
    }

    /** @param array<string, int> $counters */
    private static function recordResult(array &$counters, ?string $failure): void
    {
        ++$counters['attempted_requests'];
        if ($failure === null) {
            ++$counters['successful_requests'];
            return;
        }

        ++$counters['failed_requests'];
        ++$counters[match ($failure) {
            'timeout' => 'timeout_failures',
            'transfer' => 'transfer_errors',
            'status' => 'status_failures',
            'validation' => 'validation_failures',
        }];
    }

    /**
     * @param array<string, int> $counters
     * @param list<float> $latencies
     */
    private static function buildMetrics(
        array $counters,
        array $latencies,
        float $duration,
        float $connectTotal,
        float $ttfbTotal,
        int $concurrency,
        float $minimumDurationSeconds = 0.0,
    ): array {
        sort($latencies, SORT_NUMERIC);
        $successes = $counters['successful_requests'];
        $attempted = $counters['attempted_requests'];
        $latencyTotal = array_sum($latencies);
        $requestsPerSecond = $duration > 0 ? $successes / $duration : 0.0;

        return $counters + [
            'concurrency' => $concurrency,
            'duration' => round($duration, 5),
            'req_per_sec' => round($requestsPerSecond, 5),
            'req_per_min' => round($requestsPerSecond * 60, 5),
            'attempted_req_per_sec' => round($duration > 0 ? $attempted / $duration : 0.0, 5),
            'error_rate' => round($attempted > 0 ? $counters['failed_requests'] / $attempted : 0.0, 5),
            'minimum_window_reached' => $duration >= $minimumDurationSeconds,
            'avg' => $successes > 0 ? round($latencyTotal / $successes, 5) : null,
            'min' => $successes > 0 ? round($latencies[0], 5) : null,
            'max' => $successes > 0 ? round($latencies[$successes - 1], 5) : null,
            'median' => self::percentile($latencies, 0.50),
            'p50' => self::percentile($latencies, 0.50),
            'p95' => self::percentile($latencies, 0.95),
            'p99' => self::percentile($latencies, 0.99),
            'avg_connect_time' => $successes > 0 ? round($connectTotal / $successes, 5) : null,
            'avg_ttfb' => $successes > 0 ? round($ttfbTotal / $successes, 5) : null,
        ];
    }

    /** @param list<float> $sorted */
    private static function percentile(array $sorted, float $percentile): ?float
    {
        $count = count($sorted);
        if ($count === 0) {
            return null;
        }

        $position = ($count - 1) * $percentile;
        $lower = (int) floor($position);
        $upper = (int) ceil($position);
        $value = $sorted[$lower];
        if ($upper !== $lower) {
            $value += ($sorted[$upper] - $value) * ($position - $lower);
        }

        return round($value, 5);
    }

    private static function secondsSince(int $startedAt): float
    {
        return (hrtime(true) - $startedAt) / 1_000_000_000;
    }

    private function notifyProgress(
        int $completed,
        int $minimumRequests,
        int $startedAt,
        float $minimumDurationSeconds,
        string $phase,
    ): void {
        if ($this->progress === null) {
            return;
        }

        ($this->progress)(
            $completed,
            $minimumRequests,
            self::secondsSince($startedAt),
            $minimumDurationSeconds,
            $phase,
        );
    }
}
