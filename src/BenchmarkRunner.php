<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;
use LogicException;

final class BenchmarkRunner
{
    /* ---------- chain-settable defaults ---------- */
    private ?int $dThreads = null;
    private ?int $dCount = null;
    private ?PipingMode $dPiping = null;
    private ?int $dTimeout = null;
    private ?bool $dHttp2 = null;
    private ?bool $dVerifySsl = null;
    private ?float $dSampleEvery = null;

    /** @var BenchmarkConfig[] configs before defaults resolved */
    private array $configs = [];
    private int $lastProgressLen = 0;

    private function __construct() {}

    public static function make(): self
    {
        return new self();
    }

    /* ---------- fluent defaults ---------- */

    public function threads(int $n): self
    {
        if ($n < 2) {
            throw new InvalidArgumentException('Threads ≥ 2');
        }
        $this->dThreads = $n;
        return $this;
    }

    public function count(int $n): self
    {
        if ($n < 100) {
            throw new InvalidArgumentException('Count ≥ 100');
        }
        $this->dCount = $n;
        return $this;
    }

    public function piping(PipingMode $m): self
    {
        $this->dPiping = $m;
        return $this;
    }

    public function timeout(int $s): self
    {
        if ($s < 0) {
            throw new InvalidArgumentException('Timeout ≥ 0');
        }
        $this->dTimeout = $s;
        return $this;
    }

    public function enableHttp2(bool $f = true): self
    {
        $this->dHttp2 = $f;
        return $this;
    }

    public function verifySsl(bool $f = true): self
    {
        $this->dVerifySsl = $f;
        return $this;
    }

    public function sampleEvery(float $sec): self
    {
        if ($sec <= 0) {
            throw new InvalidArgumentException('sampleEvery > 0');
        }
        $this->dSampleEvery = $sec;
        return $this;
    }

    public function addConfigs(BenchmarkConfig ...$c): self
    {
        foreach ($c as $cfg) {
            $this->configs[$cfg->getName()] = $cfg;
        }
        return $this;
    }

    /* ---------- public API ---------- */

    /** @param 'array'|'json'|'table'|'csv' $format */
    public function runAll(string $format = 'array'): array|string
    {
        if ($this->dThreads === null) {
            throw new LogicException('call ->threads()');
        }
        if ($this->dCount === null) {
            throw new LogicException('call ->count()');
        }

        $data = $this->runAllRaw();

        return match ($format) {
            'json' => json_encode($data, JSON_PRETTY_PRINT),
            'table' => $this->toMarkdownTable($data),
            'csv' => $this->toCsv($data),
            'array' => $data,
            default => throw new InvalidArgumentException("Unknown format: $format"),
        };
    }

    /* ---------- core ---------- */

    private function runAllRaw(): array
    {
        $out = [];
        $total = count($this->configs);
        $done = 0;

        foreach ($this->configs as $name => $cfgRaw) {
            $cfg = $this->applyDefaults($cfgRaw);

            $this->progress($done++, $total, "Running $name");

            /* optional container sampler */
            $sampler = $cfg->getContainer()
                ? new ContainerStats($cfg->getContainer(), $cfg->getSampleInterval())
                : null;

            $benchStats = new RequestBenchmark($cfg, $sampler)->run();
            if ($sampler) {
                $benchStats['container'] = $sampler->finish();
            }

            $benchStats['score'] = $this->score($benchStats);
            $out[$name] = $benchStats;

            unset($benchStats, $sampler);

            if ($done < $total) {
                $this->progress($done, $total, "Cool-down 5s");
                gc_collect_cycles();
                sleep(5);
            }
        }
        $this->progress($total, $total, "done");  // newline
        /* rank by descending score */
        uasort($out, fn($a, $b) => $b['score'] <=> $a['score']);
        $rank = 1;
        foreach ($out as &$v) {
            $v['rank'] = $rank++;
        }

        return $out;
    }

    /* ---------- helpers ---------- */

    /** very naive scoring: favour high RPS, penalise high avg latency */
    private function score(array $s): float
    {
        return $s['multiple']['req_per_sec'] * 1000
            - $s['single']['avg'] * 100;
    }

    /** simple text progress bar to STDERR */
    private function progress(int $done, int $total, string $msg): void
    {
        /* build new line */
        $pct   = intdiv($done * 100, $total);
        $bars  = intdiv($pct, 5);                 // 20-char bar
        $line  = sprintf(
            "[%s%s] %3d%% %s",
            str_repeat('#', $bars),
            str_repeat('-', 20 - $bars),
            $pct,
            $msg
        );

        /* pad with spaces to fully erase the previous line */
        $padded = str_pad($line, $this->lastProgressLen);

        fwrite(STDERR, "\r{$padded}");
        $this->lastProgressLen = strlen($line);

        if ($done === $total) {
            fwrite(STDERR, PHP_EOL);
            $this->lastProgressLen = 0;           // reset for next run
        }
    }

    /* ---------- default resolver ---------- */

    private function applyDefaults(BenchmarkConfig $cfg): BenchmarkConfig
    {
        $threads = $cfg->getThreads() ?? $this->dThreads;
        $count = $cfg->getCount() ?? $this->dCount;
        if ($count < $threads) {
            throw new InvalidArgumentException("Count $count < threads $threads");
        }

        return new BenchmarkConfig(
            url: $cfg->getUrl(),
            method: $cfg->getMethod(),
            headers: $cfg->getHeaders(),
            body: $cfg->getBody(),
            expectedStatus: $cfg->getExpectedStatus(),

            threads: $threads,
            count: $count,
            piping: $cfg->getPiping() ?? $this->dPiping ?? PipingMode::Optimal,
            timeout: $cfg->getTimeout() ?? $this->dTimeout ?? 1,
            enableHttp2: $cfg->isHttp2Enabled() ?? $this->dHttp2 ?? false,
            verifySsl: $cfg->isVerifySsl() ?? $this->dVerifySsl ?? true,

            container: $cfg->getContainer(),
            sampleEvery: $cfg->getSampleInterval() ?? $this->dSampleEvery ?? 1.0,

            curlOptions: $cfg->getCurlOptions(),
            name: $cfg->getName(),
            skipPreflight: $cfg->skipPreflight(),
        );
    }

    /* ---------- output helpers (only preferred list changed) ---------- */

    private function toMarkdownTable(array $d): string
    {
        [$h, $rows] = $this->flatten($d);
        $sep = '| ' . implode(' | ', array_fill(0, count($h), '---')) . ' |';
        $lines = array_map(fn($r) => '| ' . implode(' | ', $r) . ' |', $rows);
        return implode("\n", ['| ' . implode(' | ', $h) . ' |', $sep, ...$lines]) . "\n";
    }

    private function toCsv(array $d): string
    {
        [$h, $rows] = $this->flatten($d);
        $f = fopen('php://memory', 'r+');
        fputcsv($f, $h);
        foreach ($rows as $r) {
            fputcsv($f, $r);
        }
        rewind($f);
        return stream_get_contents($f);
    }

    private function flatten(array $data): array
    {
        $flat = [];
        foreach ($data as $name => $res) {
            $m = [
                'rank' => $res['rank'],
                'score' => $res['score'],
                'totalDuration' => $res['totalDuration'],
                'remoteMemoryMB' => $res['remoteMemoryMB'],
            ];
            foreach ($res['single'] as $k => $v) {
                $m["single.$k"] = $v;
            }
            foreach ($res['multiple'] as $k => $v) {
                $m["multiple.$k"] = $v;
            }
            if (isset($res['container'])) {
                foreach ($res['container'] as $k => $v) {
                    $m["container.$k"] = $v;
                }
            }
            $flat[$name] = $m;
        }

        $preferred = [
            'rank',
            'score',
            'single.req_per_sec',
            'single.avg',
            'single.p95',
            'single.median',
            'single.min',
            'single.max',
            'single.avg_connect_time',
            'single.avg_ttfb',
            'multiple.req_per_sec',
            'totalDuration',
            'remoteMemoryMB',
            'container.avgMemMB',
            'container.avgCPU',
        ];
        $all = array_keys(array_reduce($flat, fn($c, $m) => $c + $m, []));
        $metrics = array_values(array_unique([...$preferred, ...$all]));

        $header = ['Metric', ...array_keys($flat)];
        $rows = [];
        foreach ($metrics as $m) {
            $row = [$m];
            foreach ($flat as $map) {
                $row[] = $map[$m] ?? '';
            }
            $rows[] = $row;
        }
        return [$header, $rows];
    }
}
