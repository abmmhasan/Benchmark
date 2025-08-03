<?php
declare(strict_types=1);

namespace AbmmHasan\Benchmark;

/**
 * Samples `docker stats --no-stream` on-demand and reports
 * *average* memory (MiB) and CPU % for the container.
 */
final class ContainerStats
{
    private array $mem = [];   // bytes
    private array $cpu = [];   // %
    private float $nextSample;

    public function __construct(
        private readonly string $container,
        private readonly float  $interval = 1.0,
    ) {
        $this->nextSample = microtime(true);
    }

    /** Safe to call frequently; runs only once per $interval. */
    public function maybeSample(): void
    {
        if (microtime(true) < $this->nextSample) {
            return;
        }
        $this->nextSample = microtime(true) + $this->interval;

        $fmt = '{{.MemUsage}},{{.CPUPerc}}';
        $cmd = sprintf(
            'docker stats --no-stream --format %s %s 2>/dev/null',
            escapeshellarg($fmt),
            escapeshellarg($this->container),
        );
        $out = trim(shell_exec($cmd) ?? '');
        if ($out === '') return;                 // Docker daemon down / bad name

        [$memField, $cpuField] = array_map('trim', explode(',', $out, 2));
        [$curMem] = array_map('trim', explode('/', $memField, 2)); // left side

        $this->mem[] = self::toBytes($curMem);
        $this->cpu[] = (float) rtrim($cpuField, '%');
    }

    /** Aggregate → average MiB + average CPU %. */
    public function finish(): array
    {
        $this->maybeSample();          // ensure at least one sample
        if (!$this->mem) return [];

        return [
            'avgMemMB' => round((array_sum($this->mem) / count($this->mem)) / 1_048_576, 5),
            'avgCPU'   => round(array_sum($this->cpu) / count($this->cpu), 5),
        ];
    }

    /* ---------- helpers ---------- */

    /** Convert “18.2MiB”, “512kB”, “1.4GiB” → bytes */
    private static function toBytes(string $val): float
    {
        if (preg_match('/^\s*([\d.]+)\s*([KMG]?i?)B?\s*$/i', $val, $m) !== 1) {
            return 0.0;
        }
        [$num, $unit] = [(float) $m[1], strtoupper($m[2])];

        return $num * match ($unit) {
                'K', 'KI' => 1024,
                'M', 'MI' => 1_048_576,
                'G', 'GI' => 1_073_741_824,
                default   => 1,
            };
    }
}
