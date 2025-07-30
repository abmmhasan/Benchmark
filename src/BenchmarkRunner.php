<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;

final class BenchmarkRunner
{
    /** @var RequestBenchmark[] */
    private array $benchmarks = [];

    public function __construct(BenchmarkConfig ...$configs)
    {
        foreach ($configs as $cfg) {
            $this->benchmarks[$cfg->getName()] = new RequestBenchmark($cfg);
        }
    }

    /**
     * Run all benchmarks and format the output.
     *
     * @param 'array'|'json'|'table'|'csv' $format
     * @return array|string
     */
    public function runAll(string $format = 'array'): array|string
    {
        $data = $this->runAllRaw();

        return match ($format) {
            'json' => json_encode($data, JSON_PRETTY_PRINT),
            'table' => $this->toMarkdownTable($data),
            'csv' => $this->toCsv($data),
            'array' => $data,
            default => throw new InvalidArgumentException("Unknown format: {$format}"),
        };
    }

    /** @return array<string, array> raw results keyed by config name */
    private function runAllRaw(): array
    {
        $out = [];
        foreach ($this->benchmarks as $name => $bench) {
            $out[$name] = $bench->run();
        }
        return $out;
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
