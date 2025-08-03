<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;
use LogicException;

final class BenchmarkRunner
{
    /* -------------------------------------------------- *
     *  Defaults (chain-settable)                         *
     * -------------------------------------------------- */
    private ?int $dThreads = null;
    private ?int $dCount = null;
    private ?PipingMode $dPiping = null;
    private ?int $dTimeout = null;
    private ?bool $dHttp2 = null;
    private ?bool $dVerifySsl = null;

    /** @var BenchmarkConfig[]  configs before defaults applied */
    private array $configs = [];

    private function __construct() {}

    /** Factory entry-point */
    public static function make(): self
    {
        return new self();
    }

    /* --------- Fluent default setters --------- */

    public function threads(int $threads): self
    {
        if ($threads < 2) {
            throw new InvalidArgumentException('Threads must be ≥ 2');
        }
        $this->dThreads = $threads;
        return $this;
    }

    public function count(int $count): self
    {
        if ($count < 100) {
            throw new InvalidArgumentException('Count must be ≥ 100');
        }
        $this->dCount = $count;
        return $this;
    }

    public function piping(PipingMode $mode): self
    {
        $this->dPiping = $mode;
        return $this;
    }

    public function timeout(int $seconds): self
    {
        if ($seconds < 0) {
            throw new InvalidArgumentException('Timeout must be ≥ 0');
        }
        $this->dTimeout = $seconds;
        return $this;
    }

    public function enableHttp2(bool $flag = true): self
    {
        $this->dHttp2 = $flag;
        return $this;
    }

    public function verifySsl(bool $flag = true): self
    {
        $this->dVerifySsl = $flag;
        return $this;
    }

    /* --------- Add targets --------- */

    public function addConfigs(BenchmarkConfig ...$benchmarkConfigs): self
    {
        foreach ($benchmarkConfigs as $cfg) {
            $this->configs[$cfg->getName()] = $cfg;
        }
        return $this;
    }

    /* ================================================== *
     *  Public API – run benchmarks                       *
     * ================================================== */

    /**
     * @param 'array'|'json'|'table'|'csv' $format
     * @return array|string
     */
    public function runAll(string $format = 'array'): array|string
    {
        if ($this->dThreads === null) {
            throw new LogicException('Default threads not set. Call ->threads(#) first.');
        }
        if ($this->dCount === null) {
            throw new LogicException('Default count not set. Call ->count(#) first.');
        }

        $data = $this->runAllRaw();

        return match ($format) {
            'json' => json_encode($data, JSON_PRETTY_PRINT),
            'table' => $this->toMarkdownTable($data),
            'csv' => $this->toCsv($data),
            'array' => $data,
            default => throw new InvalidArgumentException("Unknown format: {$format}"),
        };
    }

    /* -------------------------------------------------- *
     *  Internals                                         *
     * -------------------------------------------------- */

    /** @return array<string, array> */
    private function runAllRaw(): array
    {
        $out = [];

        foreach ($this->configs as $name => $cfg) {
            $cfg = $this->applyDefaults($cfg);
            $out[$name] = new RequestBenchmark($cfg)->run();
        }
        return $out;
    }

    private function applyDefaults(BenchmarkConfig $cfg): BenchmarkConfig
    {
        $threads = $cfg->getThreads() ?? $this->dThreads;
        $count = $cfg->getCount() ?? $this->dCount;
        $piping = $cfg->getPiping() ?? $this->dPiping ?? PipingMode::Optimal;
        $timeout = $cfg->getTimeout() ?? $this->dTimeout ?? 1;
        $enableH2 = $cfg->isHttp2Enabled() ?? $this->dHttp2 ?? false;
        $verifySsl = $cfg->isVerifySsl() ?? $this->dVerifySsl ?? true;

        if ($count < $threads) {
            throw new InvalidArgumentException("Count ({$count}) must be ≥ threads ({$threads})");
        }

        // build a *new* config with concrete values
        return new BenchmarkConfig(
            url: $cfg->getUrl(),
            method: $cfg->getMethod(),
            headers: $cfg->getHeaders(),
            body: $cfg->getBody(),
            expectedStatus: $cfg->getExpectedStatus(),
            threads: $threads,
            count: $count,
            piping: $piping,
            timeout: $timeout,
            enableHttp2: $enableH2,
            verifySsl: $verifySsl,
            curlOptions: $cfg->getCurlOptions(),
            name: $cfg->getName(),
            skipPreflight: $cfg->skipPreflight(),
        );
    }

    /* ------------------------------------------------------------------ */
    /* Helpers: Markdown & CSV                                            */
    /* ------------------------------------------------------------------ */

    private function toMarkdownTable(array $data): string
    {
        [$header, $rows] = $this->flatten($data);

        $separator = '| ' . implode(' | ', array_fill(0, count($header), '---')) . ' |';
        $tableRows = array_map(
            static fn($r) => '| ' . implode(' | ', $r) . ' |',
            $rows,
        );

        return implode("\n", [
                '| ' . implode(' | ', $header) . ' |',
                $separator,
                ...$tableRows,
            ]) . "\n";
    }

    private function toCsv(array $data): string
    {
        [$header, $rows] = $this->flatten($data);

        $fh = fopen('php://memory', 'r+');
        fputcsv($fh, $header);
        foreach ($rows as $row) {
            fputcsv($fh, $row);
        }
        rewind($fh);
        return stream_get_contents($fh);
    }

    /**
     * Flatten nested metric arrays and return [$header, $rows] ready for
     * Markdown or CSV emission.
     */
    private function flatten(array $data): array
    {
        // 1) flatten each benchmark
        $flat = [];
        foreach ($data as $name => $result) {
            $map = ['totalDuration' => $result['totalDuration']];
            foreach ($result['single'] as $m => $v) {
                $map["single.$m"] = $v;
            }
            foreach ($result['multiple'] as $m => $v) {
                $map["multiple.$m"] = $v;
            }
            $flat[$name] = $map;
        }

        // 2) collect unique metric keys – preserve a sensible order
        $preferred = [
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
        ];
        $allMetrics = array_keys(array_reduce($flat, static fn($c, $m) => $c + $m, []));
        $metrics = array_values(array_unique([...$preferred, ...$allMetrics]));

        // 3) build header + rows
        $header = ['Metric', ...array_keys($flat)];
        $rows = [];
        foreach ($metrics as $metric) {
            $cells = [$metric];
            foreach ($flat as $name => $map) {
                $cells[] = $map[$metric] ?? '';
            }
            $rows[] = $cells;
        }

        return [$header, $rows];
    }
}
