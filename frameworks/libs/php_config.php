<?php

declare(strict_types=1);

$iniBoolean = static fn(string $name): bool => filter_var(
    ini_get($name),
    FILTER_VALIDATE_BOOL,
);
$opcacheStatus = function_exists('opcache_get_status') ? opcache_get_status(false) : false;
$opcacheStatus = is_array($opcacheStatus) ? $opcacheStatus : [];
$jitStatus = is_array($opcacheStatus['jit'] ?? null) ? $opcacheStatus['jit'] : [];

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'phpVersion' => PHP_VERSION,
    'phpSapi' => PHP_SAPI,
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
], JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES) . PHP_EOL;
