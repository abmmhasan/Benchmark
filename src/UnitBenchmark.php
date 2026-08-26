<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use LogicException;
use Throwable;

/**
 * Tiny helper for *unit-scope* profiling.
 *
 * ```php
 * $stats = UnitBenchmark::run(function () {
 *     // … code under test …
 * });
 * var_dump($stats);
 * ```
 */
final class UnitBenchmark
{
    private const MAX_SAMPLES = 100_000;

    /** @var int[] byte-counts captured at each snapshot */
    private static array $samples = [];

    private static int $t0 = 0;  // hrtime nanoseconds
    private static int $peak0 = 0;  // bytes
    private static bool $active = false;

    /* --------------------------------------------------------------------- */
    /* Life-cycle helpers                                                    */
    /* --------------------------------------------------------------------- */

    /** Reset internal state and mark the start of the benchmark. */
    public static function start(): void
    {
        if (self::$active) {
            throw new LogicException('A unit benchmark is already active; nested measurements are unsupported');
        }

        self::$active = true;
        self::$samples = [];
        memory_reset_peak_usage();
        self::$t0 = hrtime(true);
        self::$peak0 = memory_get_usage(false);
    }

    /**
     * Capture the current memory footprint.
     *
     * @return int bytes
     */
    public static function snapshot(): int
    {
        if (!self::$active) {
            throw new LogicException('Call UnitBenchmark::start() before taking a snapshot');
        }
        if (count(self::$samples) >= self::MAX_SAMPLES) {
            throw new LogicException('Unit benchmark sample limit exceeded');
        }

        return self::$samples[] = memory_get_usage(false);
    }

    /**
     * Stop the benchmark, take a final snapshot and return stats.
     *
     * @return array{
     *     duration_ms: float,
     *     peakMemory: int,
     *     peakDiff:   int,
     *     avgMemory:  float,
     *     minMemory:  int,
     *     maxMemory:  int
     * }
     */
    public static function end(): array
    {
        if (!self::$active) {
            throw new LogicException('Call UnitBenchmark::start() before ending a benchmark');
        }

        if (count(self::$samples) < self::MAX_SAMPLES) {
            self::snapshot();                            // ensure a final sample when capacity permits
        }

        $durationNs = hrtime(true) - self::$t0;
        $peak = memory_get_peak_usage(false);
        self::$active = false;

        return [
            'duration_ms' => $durationNs / 1_000_000,    // nanoseconds → ms
            'peakMemory' => $peak,
            'peakDiff' => $peak - self::$peak0,
            'avgMemory' => array_sum(self::$samples) / count(self::$samples),
            'minMemory' => min(self::$samples),
            'maxMemory' => max(self::$samples),
        ];
    }

    /* --------------------------------------------------------------------- */
    /* Convenience one-shot runner                                           */
    /* --------------------------------------------------------------------- */

    /**
     * Convenience wrapper: run a callable and return the benchmark stats.
     *
     * @template TReturn
     *
     * @param callable():TReturn $fn
     * @return array{stats:array, return:TReturn}
     */
    public static function run(callable $fn): array
    {
        self::start();
        try {
            $result = $fn();
            $stats = self::end();
        } catch (Throwable $exception) {
            self::$active = false;
            self::$samples = [];
            throw $exception;
        }

        return ['stats' => $stats, 'return' => $result];
    }

    /** Disallow instantiation – static-only utility. */
    private function __construct() {}
}
