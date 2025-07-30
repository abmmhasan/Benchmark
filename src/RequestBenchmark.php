<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use CurlMultiHandle;
use Exception;

final class RequestBenchmark
{
    private BenchmarkConfig $config;

    public function __construct(BenchmarkConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Run both single- and multi-threaded benchmarks and return rich stats.
     */
    public function run(): array
    {
        $opts = $this->prepareOptions();

        if (!$this->config->skipPreflight()) {
            $this->checkConnection($opts);
        }

        $t0 = microtime(true);
        $single = $this->singleThreaded($opts);
        $multi = $this->multiThreaded($opts);
        $total = round(microtime(true) - $t0, 5);

        return [
            'name' => $this->config->getName(),
            'single' => $single,
            'multiple' => $multi,
            'totalDuration' => $total,
        ];
    }

    /* ---------------------------------------------------------------------
     * Internals
     * ------------------------------------------------------------------- */

    /** Base curl options common to both modes (no pipelining here). */
    private function baseCurlOptions(): array
    {
        return [
//                CURLOPT_SSL_VERIFYHOST => 2,
//                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_CONNECTTIMEOUT => $this->config->getTimeout(),
                CURLOPT_TIMEOUT => $this->config->getTimeout(),
            ] + $this->config->getCurlOptions();
    }

    /** Merge URL, method, headers, body, plus base options. */
    private function prepareOptions(): array
    {
        $o = [
            CURLOPT_URL => $this->config->getUrl(),
            CURLOPT_CUSTOMREQUEST => $this->config->getMethod()->value,
        ];

        $body = $this->config->getBody();
        $headers = $this->config->getHeaders();

        // auto-JSON encode arrays
        if (is_array($body)) {
            $o[CURLOPT_POSTFIELDS] = json_encode($body);
            $headers['Content-Type'] ??= 'application/json';
        } elseif (is_string($body)) {
            $o[CURLOPT_POSTFIELDS] = $body;
        }

        if ($headers) {
            $o[CURLOPT_HTTPHEADER] = array_map(
                static fn($k, $v) => "{$k}: {$v}",
                array_keys($headers),
                $headers,
            );
        }

        // include HTTP/2 version if enabled
        if ($this->config->isHttp2Enabled()) {
            $o[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
        }

        return $o + $this->baseCurlOptions();
    }

    /**
     * Quick HEAD-check for connectivity & expected status.
     * Uses HTTP/1.1 & no pipelining for maximum compatibility.
     */
    private function checkConnection(array $opts): void
    {
        $ch = curl_init();

        // HEAD specific tweaks
        $headOpts = $opts;
        $headOpts[CURLOPT_NOBODY] = true;
        $headOpts[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;

        curl_setopt_array($ch, $headOpts);
        $resp = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($resp === false) {
            throw new Exception("Connectivity failed ({$this->config->getUrl()}): {$err}");
        }
        if ($info['http_code'] !== $this->config->getExpectedStatus()) {
            throw new Exception(
                "Connectivity: expected {$this->config->getExpectedStatus()}, got {$info['http_code']}",
            );
        }
    }

    /* ---------- single-threaded benchmark -------------------------------- */

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
                curl_exec($ch);
                $info = curl_getinfo($ch);

                if ($info['http_code'] !== $this->config->getExpectedStatus()) {
                    throw new Exception("Single-thread: unexpected HTTP {$info['http_code']}");
                }

                $times[] = microtime(true) - $t0;
                $connects[] = $info['connect_time'];
                $ttfbs[] = $info['starttransfer_time'];
            }
        } finally {
            curl_close($ch);
        }

        sort($times);
        $n = count($times);
        $total = array_sum($times);
        $median = $times[(int)floor($n / 2)];
        $p95Idx = max(0, (int)ceil($n * 0.95) - 1);
        $p95 = $times[$p95Idx];

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

    /* ---------- multi-threaded benchmark --------------------------------- */

    private function multiThreaded(array $opts): array
    {
        /** @var CurlMultiHandle $cmh */
        $cmh = curl_multi_init();
        $threads = $this->config->getThreads();
        $total = $this->config->getCount();

        curl_multi_setopt($cmh, CURLMOPT_MAX_TOTAL_CONNECTIONS, $threads);
        curl_multi_setopt($cmh, CURLMOPT_MAX_HOST_CONNECTIONS, $threads);

        // choose pipelining / multiplex flags
        $pipeline = match ($this->config->getPiping()) {
            PipingMode::Optimal => $this->config->isHttp2Enabled() ? CURLPIPE_MULTIPLEX : 0,
            PipingMode::Max => CURLPIPE_MULTIPLEX,
        };
        curl_multi_setopt($cmh, CURLMOPT_PIPELINING, $pipeline);

        $maxPipe = $this->config->getPiping() === PipingMode::Optimal
            ? (int)ceil($total / $threads)
            : $total;
        curl_multi_setopt($cmh, CURLMOPT_MAX_PIPELINE_LENGTH, $maxPipe);

        // queue helpers ----------------------------------------------------
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

        // prime the queue
        $initial = min($threads, $total);
        for ($i = 0; $i < $initial; $i++) {
            $enqueue();
        }

        // main loop
        do {
            curl_multi_exec($cmh, $running);
            curl_multi_select($cmh, 1.0);

            while ($info = curl_multi_info_read($cmh)) {
                $codes[] = curl_getinfo($info['handle'], CURLINFO_HTTP_CODE);

                curl_multi_remove_handle($cmh, $info['handle']);
                curl_close($info['handle']);
                $inFlight--;

                // keep queue full until we've launched $total requests
                if ($launched < $total) {
                    $enqueue();
                }
            }
        } while ($running || $inFlight > 0);

        $duration = microtime(true) - $startTime;
        curl_multi_close($cmh);

        // verify all HTTP codes
        $bad = array_diff($codes, [$this->config->getExpectedStatus()]);
        if ($bad) {
            throw new Exception("Multi-thread: unexpected status codes: " . implode(', ', array_unique($bad)));
        }

        return ['req_per_sec' => round($total / $duration, 5)];
    }
}
