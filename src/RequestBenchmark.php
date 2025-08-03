<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use CurlMultiHandle;
use Exception;

/**
 * Executes the actual HTTP traffic for one concrete BenchmarkConfig and
 * returns latency/RPS statistics (single-thread + multi-thread).
 *
 * Container-level memory/CPU collection is handled by BenchmarkRunner and
 * merged into the final stats – this class remains unaware of it.
 */
final class RequestBenchmark
{
    private array $remoteMem = [];

    public function __construct(
        private readonly BenchmarkConfig $config,
        private readonly ?ContainerStats $sampler = null,
    ) {}

    /** Run the full benchmark and return metrics array. */
    public function run(): array
    {
        $opts = $this->prepareOptions();

        if (!$this->config->skipPreflight()) {
            $this->checkConnection($opts);
        }

        $t0 = microtime(true);
        $single = $this->singleThreaded($opts);
        $total = round(microtime(true) - $t0, 5);
        $this->sampler?->maybeSample();
        $t0 = microtime(true);
        $multi = $this->multiThreaded($opts);
        $total += round(microtime(true) - $t0, 5);
        $this->sampler?->maybeSample();

        return [
            'name' => $this->config->getName(),
            'single' => $single,
            'multiple' => $multi,
            'totalDuration' => $total,
            'remoteMemoryMB' => $this->remoteMem ? self::bytesToMB(array_sum($this->remoteMem) / count($this->remoteMem)) : null,
        ];
    }

    /* --------------------------------------------------------------------- *
     *  Internals                                                            *
     * --------------------------------------------------------------------- */

    /** Base curl options common to single & multi modes. */
    private function baseCurlOptions(): array
    {
        $ssl = $this->config->isVerifySsl() ?? true;

        $sslOpts = $ssl
            ? [CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_SSL_VERIFYPEER => true]
            : [CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => false];

        return $sslOpts + [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_CONNECTTIMEOUT => $this->config->getTimeout(),
                CURLOPT_TIMEOUT => $this->config->getTimeout(),
            ] + $this->config->getCurlOptions();
    }

    private function captureRemoteMem(mixed $response): void
    {
        if (!is_string($response) || $response === '' || $response[0] !== '{') {
            return;
        }
        try {
            $json = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
            if (is_array($json) && isset($json['memory']) && is_numeric($json['memory'])) {
                $this->remoteMem[] = (int)$json['memory'];
            }
        } catch (\JsonException) {
            /* ignore malformed JSON */
        }
    }

    /** Merge URL, verb, headers, body and base options into one array. */
    private function prepareOptions(): array
    {
        $opts = [
            CURLOPT_URL => $this->config->getUrl(),
            CURLOPT_CUSTOMREQUEST => $this->config->getMethod()->value,
        ];

        $body = $this->config->getBody();
        $headers = $this->config->getHeaders();

        if (is_array($body)) {
            $opts[CURLOPT_POSTFIELDS] = json_encode($body);
            $headers['Content-Type'] ??= 'application/json';
        } elseif (is_string($body)) {
            $opts[CURLOPT_POSTFIELDS] = $body;
        }

        if ($headers) {
            $opts[CURLOPT_HTTPHEADER] = array_map(
                static fn($k, $v) => "{$k}: {$v}",
                array_keys($headers),
                $headers,
            );
        }

        $opts[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
        if (($this->config->isHttp2Enabled() ?? false)) {
            $opts[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
        }

        return $opts + $this->baseCurlOptions();
    }

    /** Lightweight HEAD probe to verify connectivity & status code. */
    private function checkConnection(array $opts): void
    {
        $ch = curl_init();

        $head = $opts;
        $head[CURLOPT_NOBODY] = true;
        $head[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;

        curl_setopt_array($ch, $head);
        $resp = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($resp === false) {
            throw new Exception("Connectivity failed ({$this->config->getUrl()}): $err");
        }
        if ($info['http_code'] !== $this->config->getExpectedStatus()) {
            throw new Exception(
                "Connectivity: expected {$this->config->getExpectedStatus()}, got {$info['http_code']}",
            );
        }
    }

    /* ------------------ single-thread (serial) ------------------- */

    private function singleThreaded(array $opts): array
    {
        $ch = curl_init();
        curl_setopt_array($ch, $opts);

        $times = [];
        $connects = [];
        $ttfbs = [];

        try {
            for ($i = 0; $i < $this->config->getCount(); $i++) {
                if ($i > 0) {
                    curl_reset($ch);
                    curl_setopt_array($ch, $opts);
                }

                $t0 = microtime(true);
                $resp = curl_exec($ch);
                if ($resp === false) {
                    throw new Exception(
                        "cURL error [".curl_errno($ch).']: '.curl_error($ch)
                    );
                }
                $times[] = microtime(true) - $t0;
                $info = curl_getinfo($ch);

                if ($info['http_code'] !== $this->config->getExpectedStatus()) {
                    throw new Exception("Single-thread: unexpected HTTP {$info['http_code']}");
                }

                $connects[] = $info['connect_time'];
                $ttfbs[] = $info['starttransfer_time'];
                $this->captureRemoteMem($resp);
            }
        } finally {
            curl_close($ch);
        }

        sort($times);
        $n = count($times);
        $total = array_sum($times);
        $median = $times[(int)floor($n / 2)];
        $p95 = $times[max(0, (int)ceil($n * 0.95) - 1)];

        return [
            'req_per_sec' => round($n / $total, 5),
            'avg' => round($total / $n, 5),
            'min' => round($times[0], 5),
            'max' => round($times[$n - 1], 5),
            'median' => round($median, 5),
            'p95' => round($p95, 5),
            'avg_connect_time' => round(array_sum($connects) / $n, 5),
            'avg_ttfb' => round(array_sum($ttfbs) / $n, 5),
        ];
    }

    /* ------------------ multi-thread (concurrent) ---------------- */

    private function multiThreaded(array $opts): array
    {
        /** @var CurlMultiHandle $cmh */
        $cmh = curl_multi_init();
        $threads = $this->config->getThreads();
        $total = $this->config->getCount();

        curl_multi_setopt($cmh, CURLMOPT_MAX_TOTAL_CONNECTIONS, $threads);
        curl_multi_setopt($cmh, CURLMOPT_MAX_HOST_CONNECTIONS, $threads);

        $pipeline = match ($this->config->getPiping()) {
            PipingMode::Optimal => ($this->config->isHttp2Enabled() ?? false) ? CURLPIPE_MULTIPLEX : 0,
            PipingMode::Max => CURLPIPE_MULTIPLEX,
        };
        curl_multi_setopt($cmh, CURLMOPT_PIPELINING, $pipeline);

        $maxPipe = $this->config->getPiping() === PipingMode::Optimal
            ? (int)ceil($total / $threads) : $total;
        curl_multi_setopt($cmh, CURLMOPT_MAX_PIPELINE_LENGTH, $maxPipe);

        /* ---------- queue helpers ---------- */
        $launched = 0;
        $inFlight = 0;
        $codes = [];
        $startTime = microtime(true);

        $enqueue = function () use (&$launched, &$inFlight, $total, $opts, $cmh): void {
            $h = curl_init();
            curl_setopt_array($h, $opts);
            curl_multi_add_handle($cmh, $h);
            $launched++;
            $inFlight++;
        };

        /* prime queue */
        for ($i = 0, $initial = min($threads, $total); $i < $initial; $i++) {
            $enqueue();
        }

        /* drive the state machine */
        do {
            curl_multi_exec($cmh, $running);
            curl_multi_select($cmh, 1.0);

            while ($info = curl_multi_info_read($cmh)) {
                $codes[] = curl_getinfo($info['handle'], CURLINFO_HTTP_CODE);
                $this->captureRemoteMem(curl_multi_getcontent($info['handle']));

                curl_multi_remove_handle($cmh, $info['handle']);
                curl_close($info['handle']);
                $inFlight--;

                if ($launched < $total) {
                    $enqueue();
                }
            }
        } while ($running || $inFlight > 0);

        $duration = microtime(true) - $startTime;
        curl_multi_close($cmh);

        /* verify HTTP codes */
        $bad = array_diff($codes, [$this->config->getExpectedStatus()]);
        if ($bad) {
            throw new Exception('Multi-thread: unexpected status codes: ' . implode(', ', array_unique($bad)));
        }

        return ['req_per_sec' => round($total / $duration, 5)];
    }

    private static function bytesToMB(int $b): float
    {
        return round($b / 1_048_576, 2);
    }
}
