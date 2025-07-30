<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

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
    /** @var int[] byte-counts captured at each snapshot */
    private static array $samples = [];

    private static int $t0 = 0;  // hrtime nanoseconds
    private static int $peak0 = 0;  // bytes

    /* --------------------------------------------------------------------- */
    /* Life-cycle helpers                                                    */
    /* --------------------------------------------------------------------- */

    /** Reset internal state and mark the start of the benchmark. */
    public static function start(): void
    {
        self::$samples = [];
        self::$t0 = hrtime(true);
        self::$peak0 = memory_get_peak_usage(true);
    }

    /**
     * Capture the current memory footprint.
     *
     * @return int bytes
     */
    public static function snapshot(): int
    {
        return self::$samples[] = memory_get_usage(true);
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
        self::snapshot();                                // ensure at least one sample

        $durationNs = hrtime(true) - self::$t0;
        $peak = memory_get_peak_usage(true);

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
        $result = $fn();
        $stats = self::end();

        return ['stats' => $stats, 'return' => $result];
    }

    /** Disallow instantiation – static-only utility. */
    private function __construct() {}
}
