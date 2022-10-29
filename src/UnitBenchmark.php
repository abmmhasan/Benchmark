<?php

namespace AbmmHasan\Benchmark;

use AbmmHasan\OOF\DI\Container;
use Closure;
use Exception;
use ReflectionException;

class UnitBenchmark extends Container
{
    private static array $usage = [];

    /**
     * Call the desired closure
     *
     * @param string|Closure|callable $closureAlias
     * @return array
     * @throws Exception|ReflectionException
     */
    public function callClosure(string|Closure|callable $closureAlias): array
    {
        if ($closureAlias instanceof Closure || is_callable($closureAlias)) {
            $closure = $closureAlias;
            $params = [];
        } elseif (!empty($this->assets->closureResource[$closureAlias]['on'])) {
            $closure = $this->assets->closureResource[$closureAlias]['on'];
            $params = $this->assets->closureResource[$closureAlias]['params'];
        } else {
            throw new Exception('Closure not registered!');
        }
        $startsAt = $this->getUsage();
        (new $this->resolver($this->assets))->closureSettler($closure, $params);
        return $this->calculate($startsAt);
    }

    /**
     * Call the desired class (along with the method)
     *
     * @param string $class
     * @param string|null $method
     * @return array
     * @throws ReflectionException
     */
    public function callMethod(string $class, string $method = null): array
    {
        $startsAt = $this->getUsage();
        (new $this->resolver($this->assets))->classSettler($class, $method)['returned'];
        return $this->calculate($startsAt);
    }

    /**
     * Get Class Instance
     *
     * @param string $class
     * @return array
     * @throws ReflectionException
     */
    public function getInstance(string $class): array
    {
        $startsAt = $this->getUsage();
        (new $this->resolver($this->assets))->classSettler($class, false)['instance'];
        return $this->calculate($startsAt);
    }

    public static function snapshot()
    {
        self::$usage[] = memory_get_usage();
    }

    /**
     * @return array
     */
    private function getUsage(): array
    {
        return [
            'time' => microtime(true),
            'peak' => memory_get_peak_usage()
        ];
    }

    /**
     * @param $startsAt
     * @return array
     */
    private function calculate($startsAt): array
    {
        $stopsAt = $this->getUsage();
        $memory = null;
        if (!empty(self::$usage)) {
            $memory = array_sum(self::$usage) / count(self::$usage);
        }
        return [
            'duration' => $stopsAt['time'] - $startsAt['time'],
            'peakMemory' => $stopsAt['peak'] - $startsAt['peak'],
            'memory' => $memory
        ];
    }
}
