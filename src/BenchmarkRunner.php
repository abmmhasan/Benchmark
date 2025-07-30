<?php
declare(strict_types=1);

namespace AbmmHasan\Benchmark;

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
     * @param 'array'|'json'|'table' $format
     * @return array|string
     */
    public function runAll(string $format = 'array'): array|string
    {
        $data = $this->runAllRaw();

        return match ($format) {
            'json'  => json_encode($data, JSON_PRETTY_PRINT),
            'table' => $this->toMarkdownTable($data),
            default => $data,
        };
    }

    /** @return array<string, array> Raw results keyed by config name */
    private function runAllRaw(): array
    {
        $out = [];
        foreach ($this->benchmarks as $name => $bench) {
            $out[$name] = $bench->run();
        }
        return $out;
    }

    /**
     * Turn the raw results into a Markdown comparison table.
     *
     * @param array<string, array> $data
     * @return string
     */
    private function toMarkdownTable(array $data): string
    {
        // 1) Flatten each config's metrics into name→value
        $flattened = [];
        foreach ($data as $name => $result) {
            $map = ['totalDuration' => $result['totalDuration']];
            foreach ($result['single']   as $m => $v) { $map["single.$m"]   = $v; }
            foreach ($result['multiple'] as $m => $v) { $map["multiple.$m"] = $v; }
            $flattened[$name] = $map;
        }

        // 2) Gather all metric keys (no array_merge)
        $allMetrics = [];
        foreach ($flattened as $map) {
            foreach (array_keys($map) as $metric) {
                $allMetrics[$metric] = true;
            }
        }
        $allMetrics = array_keys($allMetrics);
        sort($allMetrics);

        // 3) Build header
        $names     = array_keys($flattened);
        $header    = '| Metric | ' . implode(' | ', $names) . ' |';
        $separator = '| ' . implode(' | ', array_fill(0, count($names) + 1, '---')) . ' |';

        // 4) Build each row
        $rows = [];
        foreach ($allMetrics as $metric) {
            $cells = ["`{$metric}`"];
            foreach ($names as $name) {
                $cells[] = $flattened[$name][$metric] ?? '';
            }
            $rows[] = '| ' . implode(' | ', $cells) . ' |';
        }

        // 5) Join into final table
        return implode("\n", array_merge(
            [$header, $separator],
            $rows
        )). "\n ";
    }
}
