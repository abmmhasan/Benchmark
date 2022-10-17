<?php

namespace AbmmHasan\Benchmark;

use AbmmHasan\OOF\DI\Container;
use Closure;
use Exception;
use ReflectionException;

class UnitBenchmark extends Container
{
    /**
     * Call the desired closure
     *
     * @param string|Closure|callable $closureAlias
     * @return float
     * @throws Exception
     */
    public function callClosure(string|Closure|callable $closureAlias): float
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
        $startAt = microtime(true);
        (new $this->resolver($this->assets))->closureSettler($closure, $params);
        return $this->calculate($startAt);
    }

    /**
     * Call the desired class (along with the method)
     *
     * @param string $class
     * @param string|null $method
     * @return float
     * @throws ReflectionException
     */
    public function callMethod(string $class, string $method = null): float
    {
        $startAt = microtime(true);
        (new $this->resolver($this->assets))->classSettler($class, $method)['returned'];
        return $this->calculate($startAt);
    }

    /**
     * Get Class Instance
     *
     * @param string $class
     * @return float
     * @throws ReflectionException
     */
    public function getInstance(string $class): float
    {
        $startAt = microtime(true);
        (new $this->resolver($this->assets))->classSettler($class, false)['instance'];
        return $this->calculate($startAt);
    }

    private function calculate($start): float
    {
        return round(microtime(true) - $start, 5);
    }
}
