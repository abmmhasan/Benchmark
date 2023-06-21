<?php

namespace AbmmHasan\Benchmark;

class UnitBenchmark
{
    private static array $usage = [];

    private static array $times = [];

    /**
     * @return int
     */
    public static function snapshot(): int
    {
        return self::$usage[] = memory_get_usage();
    }

    /**
     * @return array
     */
    public static function setStart(): array
    {
        return self::$times = [
            'time' => microtime(true),
            'peak' => memory_get_peak_usage()
        ];
    }

    /**
     * @return array
     */
    public static function calculate(): array
    {
        self::snapshot();
        return [
            'duration' => microtime(true) - self::$times['time'],
            'peakMemory' => memory_get_peak_usage(),
            'peakDiff' => memory_get_peak_usage() - self::$times['peak'],
            'memory' => array_sum(self::$usage) / count(self::$usage)
        ];
    }
}
