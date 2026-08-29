<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

final class BenchmarkController
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly ResponseInterface $response,
    ) {}

    public function hello(): PsrResponseInterface
    {
        $server = $this->request->getServerParams();
        $startedAt = (float) ($server['request_time_float'] ?? microtime(true));
        $body = sprintf(
            "Hello World!\n%' 8d:%f:%'.03d",
            memory_get_peak_usage(),
            max(0.0, microtime(true) - $startedAt),
            count(get_included_files()),
        );

        return $this->response->raw($body)->withHeader('Content-Type', 'text/plain; charset=utf-8');
    }

    public function environment(): PsrResponseInterface
    {
        $iniBoolean = static fn(string $name): bool => filter_var(ini_get($name), FILTER_VALIDATE_BOOL);
        $opcacheStatus = function_exists('opcache_get_status') ? opcache_get_status(false) : false;
        $opcacheStatus = is_array($opcacheStatus) ? $opcacheStatus : [];
        $jitStatus = is_array($opcacheStatus['jit'] ?? null) ? $opcacheStatus['jit'] : [];

        return $this->response->json([
            'phpVersion' => PHP_VERSION,
            'phpSapi' => PHP_SAPI,
            'benchmarkProfile' => getenv('BENCHMARK_ENVIRONMENT') ?: 'swoole-production',
            'runtime' => [
                'profile' => 'swoole',
                'extensionLoaded' => extension_loaded('swoole'),
                'extensionVersion' => phpversion('swoole') ?: null,
                'persistentWorker' => true,
            ],
            'loadedIni' => php_ini_loaded_file() ?: null,
            'opcache' => [
                'extensionLoaded' => extension_loaded('Zend OPcache'),
                'enabled' => (bool) ($opcacheStatus['opcache_enabled'] ?? false),
                'enableSetting' => $iniBoolean('opcache.enable'),
                'enableCliSetting' => $iniBoolean('opcache.enable_cli'),
                'jitEnabled' => (bool) ($jitStatus['on'] ?? false),
                'jitMode' => (string) ini_get('opcache.jit'),
                'jitBufferSize' => (string) ini_get('opcache.jit_buffer_size'),
                'memoryConsumption' => (string) ini_get('opcache.memory_consumption'),
                'internedStringsBuffer' => (string) ini_get('opcache.interned_strings_buffer'),
                'maxAcceleratedFiles' => (int) ini_get('opcache.max_accelerated_files'),
                'validateTimestamps' => $iniBoolean('opcache.validate_timestamps'),
                'revalidateFrequencySeconds' => (int) ini_get('opcache.revalidate_freq'),
            ],
        ]);
    }

    public function disabledFunctions(): PsrResponseInterface
    {
        return $this->response->raw((string) ini_get('disable_functions'));
    }
}
