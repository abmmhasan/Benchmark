<?php
declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use CurlMultiHandle;
use Exception;

final class RequestBenchmark
{
    private BenchmarkConfig $config;
    private CurlMultiHandle $cmh;

    public function __construct(BenchmarkConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Run both single- and multi-threaded benchmarks,
     * collect rich stats, and return everything in one array.
     */
    public function run(): array
    {
        $opts = $this->prepareOptions();
        $this->checkConnection($opts);

        $t0     = microtime(true);
        $single = $this->singleThreaded($opts);
        $multi  = $this->multiThreaded($opts);
        $total  = round(microtime(true) - $t0, 5);

        return [
            'name'          => $this->config->getName(),
            'single'        => $single,
            'multiple'      => $multi,
            'totalDuration' => $total,
        ];
    }

    /** central “base” curl options (no CURLOPT_PIPELINING here) */
    private function baseCurlOptions(): array
    {
        return [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_CONNECTTIMEOUT => $this->config->getTimeout(),
                CURLOPT_TIMEOUT        => $this->config->getTimeout(),
            ] + $this->config->getCurlOptions();
    }

    /** merge URL, method, headers, body, plus base options */
    private function prepareOptions(): array
    {
        $o = [
            CURLOPT_URL           => $this->config->getUrl(),
            CURLOPT_CUSTOMREQUEST => $this->config->getMethod(),
        ];

        // auto-JSON-encode arrays
        $body = $this->config->getBody();
        if (is_array($body)) {
            $o[CURLOPT_POSTFIELDS] = json_encode($body);
            $hdrs                  = $this->config->getHeaders();
            $hdrs['Content-Type']  = 'application/json';
            // rebuild config to include the new header
            $this->config = new BenchmarkConfig(
                $this->config->getUrl(),
                $this->config->getMethod(),
                $hdrs,
                $body,
                $this->config->getExpectedStatus(),
                $this->config->getThreads(),
                $this->config->getCount(),
                $this->config->getPiping(),
                $this->config->getTimeout(),
                $this->config->isHttp2Enabled(),
                $this->config->getCurlOptions(),
                $this->config->getName()
            );
        } elseif (is_string($body)) {
            $o[CURLOPT_POSTFIELDS] = $body;
        }

        if ($this->config->getHeaders()) {
            $o[CURLOPT_HTTPHEADER] = array_map(
                fn($k, $v) => "$k: $v",
                array_keys($this->config->getHeaders()),
                $this->config->getHeaders()
            );
        }

        // include HTTP/2 version if enabled
        if ($this->config->isHttp2Enabled()) {
            $o[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_2_0;
        }

        return $o + $this->baseCurlOptions();
    }

    /**
     * quick HEAD-check for connectivity & expected status
     * — force HTTP/1.1 and disable pipelining for the check
     */
    private function checkConnection(array $opts): void
    {
        $ch = curl_init();

        // prepare HEAD-specific options
        $headOpts = $opts;
        $headOpts[CURLOPT_NOBODY]       = true;
        $headOpts[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;

        curl_setopt_array($ch, $headOpts);
        $resp = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($resp === false) {
            throw new Exception("Connectivity failed ({$this->config->getUrl()}): {$err}");
        }
        if ($info['http_code'] !== $this->config->getExpectedStatus()) {
            throw new Exception(
                "Connectivity: expected {$this->config->getExpectedStatus()}, got {$info['http_code']}"
            );
        }
    }

    /** single-user series; tracks per-request times, connect/TTFB, and computes min/max/median/p95 */
    private function singleThreaded(array $opts): array
    {
        $ch = curl_init();
        curl_setopt_array($ch, $opts);

        $times    = [];
        $connects = [];
        $ttfbs    = [];

        try {
            for ($i = 0; $i < $this->config->getCount(); $i++) {
                $t0   = microtime(true);
                $resp = curl_exec($ch);
                $info = curl_getinfo($ch);
                $err  = curl_error($ch);

                if ($info['http_code'] !== $this->config->getExpectedStatus()) {
                    throw new Exception("Single-thread: HTTP {$info['http_code']} ({$err})");
                }

                $dur = microtime(true) - $t0;
                $times[]    = $dur;
                $connects[] = $info['connect_time'];
                $ttfbs[]    = $info['starttransfer_time'];
            }
        } finally {
            curl_close($ch);
        }

        sort($times);
        $n      = count($times);
        $total  = array_sum($times);
        $median = $times[(int) floor($n / 2)];
        $p95    = $times[(int) floor($n * 0.95)];

        return [
            'req_per_sec'      => round($n / $total, 5),
            'avg'              => round($total / $n, 5),
            'min'              => round($times[0], 5),
            'max'              => round($times[$n - 1], 5),
            'median'           => round($median, 5),
            'p95'              => round($p95, 5),
            'avg_connect_time' => round(array_sum($connects) / $n, 5),
            'avg_ttfb'         => round(array_sum($ttfbs) / $n, 5),
        ];
    }

    /** multi-user: set up curl_multi with pipelining/multiplexing, then exec & verify codes */
    private function multiThreaded(array $opts): array
    {
        $mh       = curl_multi_init();
        $threads  = $this->config->getThreads();
        $count    = $this->config->getCount();
        $expected = $this->config->getExpectedStatus();

        // 1) concurrency & pipelining
        curl_multi_setopt($mh, CURLMOPT_MAX_TOTAL_CONNECTIONS, $threads);
        curl_multi_setopt($mh, CURLMOPT_MAX_HOST_CONNECTIONS,  $threads);
        $pipeline = match ($this->config->getPiping()) {
            'optimal' => $this->config->isHttp2Enabled() ? CURLPIPE_MULTIPLEX : 0,
            'max'     => CURLPIPE_MULTIPLEX,
        };
        curl_multi_setopt($mh, CURLMOPT_PIPELINING, $pipeline);
        curl_multi_setopt($mh, CURLMOPT_MAX_PIPELINE_LENGTH,
            $this->config->getPiping() === 'optimal'
                ? (int) ceil($count / $threads)
                : $count
        );

        // 2) add handles
        $handles = [];
        for ($i = 0; $i < $count; $i++) {
            $h = curl_init();
            curl_setopt_array($h, $opts);
            curl_multi_add_handle($mh, $h);
            $handles[] = $h;
        }

        // 3) run with select() to wait for I/O
        $active = null;
        $start  = microtime(true);
        do {
            $mrc = curl_multi_exec($mh, $active);
            if ($mrc !== CURLM_OK) {
                throw new Exception("curl_multi_exec error: $mrc");
            }
            // wait up to 1s for activity
            curl_multi_select($mh, 1.0);
        } while ($active > 0);
        $duration = microtime(true) - $start;

        // 4) collect HTTP codes and cleanup
        $codes = [];
        foreach ($handles as $h) {
            $codes[] = curl_getinfo($h, CURLINFO_HTTP_CODE);
            curl_multi_remove_handle($mh, $h);
            curl_close($h);
        }
        curl_multi_close($mh);

        // 5) verify
        $bad = array_diff($codes, [$expected]);
        if ($bad) {
            throw new Exception("Multi-thread: unexpected status codes: ".implode(', ',$bad));
        }

        return [
            'req_per_sec' => round($count / $duration, 5)
        ];
    }
}
