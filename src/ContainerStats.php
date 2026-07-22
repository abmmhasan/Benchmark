<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use LogicException;
use RuntimeException;

/** Collects Docker CPU and memory samples concurrently with benchmark traffic. */
final class ContainerStats
{
    private const MAX_SAMPLES = 100_000;

    /** @var list<float> */
    private array $memory = [];

    /** @var list<float> */
    private array $cpu = [];

    /** @var resource|null */
    private mixed $process = null;

    /** @var resource|null */
    private mixed $stdout = null;

    private string $buffer = '';
    private int $linesSeen = 0;
    private readonly int $sampleStep;

    public function __construct(
        private readonly string $container,
        private readonly float $interval = 1.0,
    ) {
        if ($container === '') {
            throw new LogicException('Container name cannot be empty');
        }
        if ($interval < 1) {
            throw new LogicException('Container sample interval must be at least one second');
        }

        // Docker emits approximately once per second; retain the requested cadence.
        $this->sampleStep = max(1, (int) round($interval));
    }

    public function start(): void
    {
        if (is_resource($this->process)) {
            throw new LogicException('Container sampling has already started');
        }

        $pipes = [];
        $this->process = proc_open(
            ['docker', 'stats', '--format', '{{.MemUsage}},{{.CPUPerc}}', $this->container],
            [
                0 => ['file', '/dev/null', 'r'],
                1 => ['pipe', 'w'],
                2 => ['file', '/dev/null', 'a'],
            ],
            $pipes,
        );

        if (!is_resource($this->process) || !isset($pipes[1]) || !is_resource($pipes[1])) {
            if (is_resource($this->process)) {
                proc_terminate($this->process, 9);
                proc_close($this->process);
            }
            $this->process = null;
            throw new RuntimeException("Unable to start Docker statistics for {$this->container}");
        }

        $this->stdout = $pipes[1];
        stream_set_blocking($this->stdout, false);
    }

    /** Drain currently available samples without blocking the load generator. */
    public function maybeSample(): void
    {
        if (!is_resource($this->stdout)) {
            return;
        }

        $chunk = stream_get_contents($this->stdout);
        if ($chunk !== false && $chunk !== '') {
            $this->buffer .= $chunk;
            $this->consumeCompleteLines();
        }
    }

    public function finish(): array
    {
        if (!is_resource($this->process)) {
            return [];
        }

        $this->maybeSample();
        proc_terminate($this->process);

        $deadline = hrtime(true) + 500_000_000;
        do {
            $status = proc_get_status($this->process);
            if (!$status['running']) {
                break;
            }
            usleep(10_000);
        } while (hrtime(true) < $deadline);

        if (($status['running'] ?? false) === true) {
            proc_terminate($this->process, 9);
        }

        $this->maybeSample();
        if ($this->buffer !== '') {
            $this->consumeLine(trim($this->buffer));
            $this->buffer = '';
        }

        if (is_resource($this->stdout)) {
            fclose($this->stdout);
        }
        proc_close($this->process);
        $this->stdout = null;
        $this->process = null;

        if ($this->memory === []) {
            return [];
        }

        return [
            'samples' => count($this->memory),
            'avgMemMB' => round((array_sum($this->memory) / count($this->memory)) / 1_048_576, 5),
            'peakMemMB' => round(max($this->memory) / 1_048_576, 5),
            'avgCPU' => round(array_sum($this->cpu) / count($this->cpu), 5),
            'peakCPU' => round(max($this->cpu), 5),
        ];
    }

    private function consumeCompleteLines(): void
    {
        while (($newline = strpos($this->buffer, "\n")) !== false) {
            $line = trim(substr($this->buffer, 0, $newline));
            $this->buffer = substr($this->buffer, $newline + 1);
            $this->consumeLine($line);
        }
    }

    private function consumeLine(string $line): void
    {
        if ($line === '') {
            return;
        }
        if (count($this->memory) >= self::MAX_SAMPLES) {
            return;
        }

        ++$this->linesSeen;
        if (($this->linesSeen - 1) % $this->sampleStep !== 0) {
            return;
        }

        $fields = explode(',', $line, 2);
        if (count($fields) !== 2) {
            return;
        }

        [$memoryField, $cpuField] = array_map('trim', $fields);
        [$currentMemory] = array_map('trim', explode('/', $memoryField, 2));
        $memory = self::toBytes($currentMemory);
        if ($memory === null || preg_match('/^\d+(?:\.\d+)?%$/', $cpuField) !== 1) {
            return;
        }

        $this->memory[] = $memory;
        $this->cpu[] = (float) rtrim($cpuField, '%');
    }

    private static function toBytes(string $value): ?float
    {
        if (preg_match('/^\s*(\d+(?:\.\d+)?)\s*([KMG]?i?)B?\s*$/i', $value, $matches) !== 1) {
            return null;
        }

        $multiplier = match (strtoupper($matches[2])) {
            'K', 'KI' => 1_024,
            'M', 'MI' => 1_048_576,
            'G', 'GI' => 1_073_741_824,
            default => 1,
        };

        return (float) $matches[1] * $multiplier;
    }
}
