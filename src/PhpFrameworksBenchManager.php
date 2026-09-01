<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;
use RuntimeException;

/** Orchestrates framework fixtures without depending on an external load generator. */
final class PhpFrameworksBenchManager
{
    private const LIFECYCLE_ACTIONS = ['setup', 'update', 'clean', 'clear-cache'];
    private const SERVICES = ['apache', 'nginx', 'php-fpm'];

    public function __construct(private readonly PhpFrameworksBenchSuite $suite) {}

    /**
     * @param list<string> $targets
     * @return array<string, mixed>
     */
    public function doctor(array $targets = []): array
    {
        $selected = $this->resolveTargets($targets);
        $executables = [];
        foreach (['php', 'composer', 'curl', 'bash', 'docker', 'systemctl'] as $executable) {
            $executables[$executable] = self::findExecutable($executable);
        }

        $targetChecks = [];
        foreach ($selected as $target) {
            $scripts = [];
            foreach (self::LIFECYCLE_ACTIONS as $action) {
                $scripts[$action] = is_file($this->lifecycleScript($target, $action));
            }
            $targetChecks[$target] = [
                'directory' => is_dir($this->targetDirectory($target)),
                'helloWorld' => is_file($this->lifecycleScript($target, 'hello_world')),
                'scripts' => $scripts,
            ];
        }

        $server = ['reachable' => false, 'php' => null, 'opcache' => null, 'environment' => null, 'error' => null];
        try {
            $environment = $this->serverEnvironment();
            $server['reachable'] = true;
            $server['php'] = $environment['phpVersion'] ?? null;
            $server['opcache'] = ($environment['opcache']['enabled'] ?? false) ? 'On' : 'Off';
            $server['environment'] = $environment;
            $disabled = trim($this->httpText($this->suite->getBaseUrl() . '/libs/php_disable_functions.php'));
            $server['fastcgiFinishRequestDisabled'] = in_array(
                'fastcgi_finish_request',
                array_filter(array_map('trim', explode(',', $disabled))),
                true,
            );
        } catch (RuntimeException $exception) {
            $server['error'] = $exception->getMessage();
        }

        return [
            'suiteDirectory' => $this->suite->getProjectDirectory(),
            'baseUrl' => $this->suite->getBaseUrl(),
            'loadGenerator' => [
                'phpVersion' => PHP_VERSION,
                'curlVersion' => curl_version()['version'] ?? 'unknown',
                'curlExtension' => extension_loaded('curl'),
                'xdebugLoaded' => extension_loaded('xdebug'),
            ],
            'executables' => $executables,
            'server' => $server,
            'targets' => $targetChecks,
        ];
    }

    /**
     * Read the runtime configuration from the web server that receives benchmark traffic.
     *
     * @return array<string, mixed>
     */
    public function serverEnvironment(): array
    {
        $text = trim($this->httpText($this->suite->getBaseUrl() . '/libs/php_config.php'));

        return self::parseServerEnvironment($text);
    }

    /** @return array<string, mixed> */
    private static function parseServerEnvironment(string $text): array
    {
        $decoded = json_decode($text, true);
        if (is_array($decoded) && is_array($decoded['opcache'] ?? null)) {
            return $decoded;
        }

        // Accept the original text fixture when benchmarking an older checked-out suite.
        $environment = [
            'phpVersion' => null,
            'phpSapi' => null,
            'loadedIni' => null,
            'opcache' => [
                'extensionLoaded' => null,
                'enabled' => false,
            ],
        ];
        foreach (preg_split('/\R/', $text) ?: [] as $line) {
            if (str_starts_with($line, 'PHP:')) {
                $environment['phpVersion'] = trim(substr($line, 4));
            } elseif (str_starts_with($line, 'OPCache:')) {
                $environment['opcache']['enabled'] = strcasecmp(trim(substr($line, 8)), 'On') === 0;
            }
        }
        if ($environment['phpVersion'] === null) {
            throw new RuntimeException('The benchmark server returned invalid PHP configuration data');
        }

        return $environment;
    }

    /**
     * Perform one validated request per selected target.
     *
     * @param list<string> $targets
     * @return array<string, array<string, mixed>>
     */
    public function checkTargets(array $targets = []): array
    {
        $results = [];
        foreach ($this->suite->configs($targets) as $config) {
            foreach ($config->getRouteScenarios() as $scenario) {
                $handle = curl_init();
                try {
                    if (!curl_setopt_array($handle, [
                        CURLOPT_URL => $scenario->getUrl(),
                        CURLOPT_CUSTOMREQUEST => $scenario->getMethod()->value,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_FOLLOWLOCATION => false,
                        CURLOPT_CONNECTTIMEOUT => 5,
                        CURLOPT_TIMEOUT => 10,
                        CURLOPT_SSL_VERIFYHOST => 2,
                        CURLOPT_SSL_VERIFYPEER => true,
                        CURLOPT_HTTPHEADER => ['Accept: text/plain, application/json', 'Cache-Control: no-cache'],
                    ])) {
                        throw new RuntimeException(sprintf(
                            'Unable to configure check for %s · %s',
                            $config->getName(),
                            $scenario->getLabel(),
                        ));
                    }
                    $response = curl_exec($handle);
                    $info = curl_getinfo($handle);
                    $status = (int) ($info['http_code'] ?? 0);
                    $valid = is_string($response)
                        && $status === $scenario->getExpectedStatus()
                        && ($scenario->getResponseValidator())($response, $info);
                    $results[$config->getName() . ' · ' . $scenario->getLabel()] = [
                        'url' => $scenario->getUrl(),
                        'method' => $scenario->getMethod()->value,
                        'expectedStatus' => $scenario->getExpectedStatus(),
                        'status' => $status,
                        'valid' => $valid,
                        'curlError' => curl_errno($handle) === CURLE_OK ? null : curl_error($handle),
                        'memoryBytes' => is_string($response)
                            ? ($config->getResponseMemoryExtractor())?->__invoke($response, $info)
                            : null,
                        'metrics' => is_string($response)
                            ? (($config->getResponseMetricsExtractor())?->__invoke($response, $info) ?? [])
                            : [],
                    ];
                } finally {
                    curl_close($handle);
                }
            }
        }

        return $results;
    }

    /**
     * @param 'setup'|'update'|'clean'|'clear-cache' $action
     * @param list<string> $targets
     * @param null|callable(string):void $output
     * @return list<array<string, mixed>>
     */
    public function lifecycle(
        string $action,
        array $targets = [],
        bool $dryRun = false,
        bool $allowDestructive = false,
        ?callable $output = null,
    ): array {
        if (!in_array($action, self::LIFECYCLE_ACTIONS, true)) {
            throw new InvalidArgumentException("Unknown lifecycle action: {$action}");
        }
        if (in_array($action, ['setup', 'update', 'clean'], true) && !$dryRun && !$allowDestructive) {
            throw new RuntimeException("{$action} requires explicit destructive-operation approval");
        }
        if (!$dryRun && self::findExecutable('bash') === null) {
            throw new RuntimeException('bash is required for framework lifecycle scripts');
        }

        $results = [];
        foreach ($this->resolveTargets($targets) as $target) {
            if ($action === 'clear-cache' && $target === 'nette-3') {
                $cacheDirectory = $this->targetDirectory($target) . '/temp/cache';
                $command = ['internal:clear-directory', $cacheDirectory];
                if (!$dryRun) {
                    self::clearBoundedDirectory($cacheDirectory, $this->targetDirectory($target));
                }
                $results[] = [
                    'target' => $target,
                    'action' => $action,
                    'status' => $dryRun ? 'dry-run' : 'completed',
                    'command' => $command,
                    'cwd' => $this->targetDirectory($target),
                    'exitCode' => $dryRun ? null : 0,
                    'stdout' => '',
                    'stderr' => '',
                ];
                continue;
            }

            $script = $this->lifecycleScript($target, $action);
            if (!is_file($script)) {
                $results[] = [
                    'target' => $target,
                    'action' => $action,
                    'status' => 'unsupported',
                    'command' => [],
                    'exitCode' => null,
                    'stdout' => '',
                    'stderr' => '',
                ];
                continue;
            }

            // Keep extglob enabled for compatibility with external legacy suites.
            $command = ['bash', '-O', 'extglob', $script];
            if ($dryRun) {
                $results[] = [
                    'target' => $target,
                    'action' => $action,
                    'status' => 'dry-run',
                    'command' => $command,
                    'cwd' => $this->targetDirectory($target),
                    'exitCode' => null,
                    'stdout' => '',
                    'stderr' => '',
                ];
                continue;
            }

            $result = self::runProcess($command, $this->targetDirectory($target), $output);
            $results[] = [
                'target' => $target,
                'action' => $action,
                'status' => $result['exitCode'] === 0 ? 'completed' : 'failed',
                'command' => $command,
                'cwd' => $this->targetDirectory($target),
            ] + $result;
            if ($result['exitCode'] !== 0) {
                throw new RuntimeException(sprintf(
                    '%s failed for %s with exit code %d',
                    $action,
                    $target,
                    $result['exitCode'],
                ));
            }
        }

        return $results;
    }

    /**
     * @param list<'apache'|'nginx'|'php-fpm'> $services
     * @param null|callable(string):void $output
     * @return list<array<string, mixed>>
     */
    public function restartServices(array $services, bool $dryRun = false, ?callable $output = null): array
    {
        $results = [];
        foreach ($services as $service) {
            if (!in_array($service, self::SERVICES, true)) {
                throw new InvalidArgumentException("Unknown service: {$service}");
            }
            $unit = $service === 'php-fpm'
                ? sprintf('php%d.%d-fpm', PHP_MAJOR_VERSION, PHP_MINOR_VERSION)
                : ($service === 'apache' ? 'apache2' : 'nginx');
            $command = [...self::privilegePrefix(), 'systemctl', 'restart', $unit];
            if ($dryRun) {
                $results[] = ['service' => $service, 'unit' => $unit, 'command' => $command, 'status' => 'dry-run'];
                continue;
            }
            $result = self::runProcess($command, $this->suite->getProjectDirectory(), $output);
            $results[] = ['service' => $service, 'unit' => $unit, 'command' => $command] + $result;
            if ($result['exitCode'] !== 0) {
                throw new RuntimeException("Unable to restart {$unit}: " . trim($result['stderr']));
            }
        }

        return $results;
    }

    /** @return array{status:string, response:?string, url:string} */
    public function resetOpcache(bool $dryRun = false): array
    {
        $url = $this->suite->getBaseUrl() . '/libs/reset_opcache.php';
        if ($dryRun) {
            return ['status' => 'dry-run', 'response' => null, 'url' => $url];
        }
        $response = trim($this->httpText($url));

        return ['status' => 'completed', 'response' => $response, 'url' => $url];
    }

    /**
     * Disable fastcgi_finish_request in the web server's loaded php.ini.
     *
     * @return array<string, mixed>
     */
    public function disableFastcgiFinishRequest(bool $dryRun = false, bool $allowDestructive = false): array
    {
        $iniUrl = $this->suite->getBaseUrl() . '/libs/php_ini.php';
        $disabledUrl = $this->suite->getBaseUrl() . '/libs/php_disable_functions.php';
        $iniPath = trim($this->httpText($iniUrl));
        $disabled = array_values(array_filter(array_map(
            'trim',
            explode(',', trim($this->httpText($disabledUrl))),
        )));
        if (in_array('fastcgi_finish_request', $disabled, true)) {
            return ['status' => 'already-disabled', 'phpIni' => $iniPath, 'restartRequired' => false];
        }
        if ($iniPath === '' || !str_starts_with($iniPath, '/') || basename($iniPath) !== 'php.ini') {
            throw new RuntimeException("The server returned an unsafe php.ini path: {$iniPath}");
        }
        if ($dryRun) {
            return ['status' => 'dry-run', 'phpIni' => $iniPath, 'restartRequired' => true];
        }
        if (!$allowDestructive) {
            throw new RuntimeException('Disabling fastcgi_finish_request requires explicit destructive-operation approval');
        }

        $contents = file_get_contents($iniPath);
        if (!is_string($contents)) {
            throw new RuntimeException("Unable to read {$iniPath}; run the command with suitable privileges");
        }
        $disabled[] = 'fastcgi_finish_request';
        $setting = 'disable_functions = ' . implode(',', array_unique($disabled));
        $updated = preg_replace('/^\s*disable_functions\s*=.*$/m', $setting, $contents, 1, $count);
        if (!is_string($updated)) {
            throw new RuntimeException("Unable to update {$iniPath}");
        }
        if ($count === 0) {
            $updated = rtrim($updated) . PHP_EOL . $setting . PHP_EOL;
        }
        $backup = $iniPath . '.benchmark.bak';
        if (!is_file($backup) && !copy($iniPath, $backup)) {
            throw new RuntimeException("Unable to create php.ini backup at {$backup}");
        }
        if (file_put_contents($iniPath, $updated, LOCK_EX) === false) {
            throw new RuntimeException("Unable to write {$iniPath}; the backup is {$backup}");
        }

        return [
            'status' => 'completed',
            'phpIni' => $iniPath,
            'backup' => $backup,
            'restartRequired' => true,
        ];
    }

    /**
     * @return list<array{command:list<string>, cwd:string, status:string, exitCode?:int, stdout?:string, stderr?:string}>
     */
    public function dockerApache(
        ?int $port = null,
        string $name = 'benchmark-frameworks-apache',
        bool $dryRun = false,
        ?callable $output = null,
    ): array {
        return $this->dockerContainer(
            runtime: 'opcache',
            port: $port,
            name: $name,
            dockerfileName: 'apache.dockerfile',
            image: 'benchmark/php-frameworks-apache',
            containerPort: 80,
            volumeTarget: '/var/www/html/frameworks',
            basePath: '/frameworks',
            runAsHostUser: false,
            dryRun: $dryRun,
            output: $output,
        );
    }

    /**
     * @return list<array{command:list<string>, cwd:string, status:string, exitCode?:int, stdout?:string, stderr?:string}>
     */
    public function dockerSwoole(
        ?int $port = null,
        string $name = 'benchmark-frameworks-swoole',
        bool $dryRun = false,
        ?callable $output = null,
    ): array {
        return $this->dockerContainer(
            runtime: 'swoole',
            port: $port,
            name: $name,
            dockerfileName: 'swoole.dockerfile',
            image: 'benchmark/php-frameworks-swoole',
            containerPort: 9500,
            volumeTarget: '/app/frameworks',
            basePath: '',
            runAsHostUser: true,
            dryRun: $dryRun,
            output: $output,
        );
    }

    /**
     * @return list<array{command:list<string>, cwd:string, status:string, exitCode?:int, stdout?:string, stderr?:string}>
     */
    public function dockerRuntime(
        string $runtime,
        ?int $port = null,
        ?string $name = null,
        bool $dryRun = false,
        ?callable $output = null,
    ): array {
        return match ($runtime) {
            'opcache' => $this->dockerApache(
                $port,
                $name ?? 'benchmark-frameworks-apache',
                $dryRun,
                $output,
            ),
            'swoole' => $this->dockerSwoole(
                $port,
                $name ?? 'benchmark-frameworks-swoole',
                $dryRun,
                $output,
            ),
            default => throw new InvalidArgumentException("Unknown benchmark runtime: {$runtime}"),
        };
    }

    /**
     * @return list<array{command:list<string>, cwd:string, status:string, exitCode?:int, stdout?:string, stderr?:string}>
     */
    private function dockerContainer(
        string $runtime,
        ?int $port,
        string $name,
        string $dockerfileName,
        string $image,
        int $containerPort,
        string $volumeTarget,
        string $basePath,
        bool $runAsHostUser,
        bool $dryRun,
        ?callable $output,
    ): array {
        if ($port !== null && ($port < 1 || $port > 65_535)) {
            throw new InvalidArgumentException('Docker port must be between 1 and 65535');
        }
        if (preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_.-]*$/', $name) !== 1) {
            throw new InvalidArgumentException('Invalid Docker container name');
        }
        $dockerfile = $this->suite->getProjectDirectory() . '/.docker/' . $dockerfileName;
        if (!is_file($dockerfile)) {
            throw new RuntimeException("Dockerfile not found: {$dockerfile}");
        }
        if ($port === null && !$dryRun) {
            $port = self::availableLoopbackPort();
        }
        $publishedPort = $port === null
            ? "127.0.0.1::{$containerPort}"
            : "127.0.0.1:{$port}:{$containerPort}";
        $runCommand = [
            'docker', 'run', '--detach', '--rm', '--name', $name,
        ];
        if ($runAsHostUser && function_exists('posix_geteuid') && function_exists('posix_getegid')) {
            $runCommand[] = '--user';
            $runCommand[] = posix_geteuid() . ':' . posix_getegid();
        }
        array_push(
            $runCommand,
            '--publish',
            $publishedPort,
            '--volume',
            $this->suite->getProjectDirectory() . ":{$volumeTarget}:rw",
            '--volume',
            $this->suite->getProjectDirectory() . ':' . $this->suite->getProjectDirectory() . ':rw',
            $image . ':latest',
        );
        $commands = [
            [
                'docker', 'build', '--tag', $image,
                '--file', $dockerfile, $this->suite->getProjectDirectory(),
            ],
            $runCommand,
            ['docker', 'port', $name, "{$containerPort}/tcp"],
        ];

        $results = [];
        foreach ($commands as $command) {
            if ($dryRun) {
                $results[] = [
                    'command' => $command,
                    'cwd' => $this->suite->getProjectDirectory(),
                    'status' => 'dry-run',
                ];
                continue;
            }
            $result = self::runProcess($command, $this->suite->getProjectDirectory(), $output);
            $results[] = [
                'command' => $command,
                'cwd' => $this->suite->getProjectDirectory(),
                'status' => $result['exitCode'] === 0 ? 'completed' : 'failed',
            ] + $result;
            if ($result['exitCode'] !== 0) {
                throw new RuntimeException('Docker command failed: ' . trim($result['stderr']));
            }
        }

        if (!$dryRun) {
            $portOutput = $results[2]['stdout'] ?? '';
            if (!is_string($portOutput)
                || preg_match('/127\.0\.0\.1:(?<port>\d+)\s*$/', trim($portOutput), $match) !== 1
            ) {
                throw new RuntimeException('Docker started, but its allocated loopback port could not be determined');
            }
            $port = (int) $match['port'];
            $baseUrl = "http://127.0.0.1:{$port}{$basePath}";
            $runtimeJson = json_encode([
                'baseUrl' => $baseUrl,
                'host' => '127.0.0.1',
                'port' => $port,
                'container' => $name,
                'runtime' => $runtime,
                'startedAt' => gmdate(DATE_ATOM),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
            if (file_put_contents($this->runtimeFile(), $runtimeJson . PHP_EOL, LOCK_EX) === false) {
                throw new RuntimeException('Docker started, but its runtime URL could not be recorded');
            }
            $this->waitForHttp($baseUrl . '/libs/php_config.php');
        }

        return $results;
    }

    private static function availableLoopbackPort(): int
    {
        $errorCode = 0;
        $errorMessage = '';
        $socket = stream_socket_server(
            'tcp://127.0.0.1:0',
            $errorCode,
            $errorMessage,
            STREAM_SERVER_BIND | STREAM_SERVER_LISTEN,
        );
        if ($socket === false) {
            throw new RuntimeException("Unable to allocate a loopback port: {$errorMessage} ({$errorCode})");
        }
        try {
            $address = stream_socket_get_name($socket, false);
            if (!is_string($address) || preg_match('/:(?<port>\d+)$/', $address, $match) !== 1) {
                throw new RuntimeException('Unable to determine the allocated loopback port');
            }

            return (int) $match['port'];
        } finally {
            fclose($socket);
        }
    }

    /** @return array{command:list<string>, cwd:string, status:string, exitCode?:int, stdout?:string, stderr?:string} */
    public function stopDockerApache(
        ?string $name = null,
        bool $dryRun = false,
        ?callable $output = null,
    ): array {
        $runtime = $this->readRuntime();
        $name ??= is_string($runtime['container'] ?? null)
            ? $runtime['container']
            : 'benchmark-frameworks-apache';
        if (preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_.-]*$/', $name) !== 1) {
            throw new InvalidArgumentException('Invalid Docker container name');
        }

        $command = ['docker', 'stop', $name];
        if ($dryRun) {
            return [
                'command' => $command,
                'cwd' => $this->suite->getProjectDirectory(),
                'status' => 'dry-run',
            ];
        }

        $result = self::runProcess($command, $this->suite->getProjectDirectory(), $output);
        if ($result['exitCode'] !== 0) {
            throw new RuntimeException('Unable to stop Docker benchmark server: ' . trim($result['stderr']));
        }
        if (is_file($this->runtimeFile()) && !unlink($this->runtimeFile())) {
            throw new RuntimeException('Docker stopped, but its runtime URL could not be removed');
        }

        return [
            'command' => $command,
            'cwd' => $this->suite->getProjectDirectory(),
            'status' => 'completed',
        ] + $result;
    }

    /** @return array{command:list<string>, cwd:string, status:string, exitCode?:int, stdout?:string, stderr?:string} */
    public function stopDockerRuntime(
        ?string $name = null,
        bool $dryRun = false,
        ?callable $output = null,
    ): array {
        return $this->stopDockerApache($name, $dryRun, $output);
    }

    private function waitForHttp(string $url): void
    {
        $lastError = null;
        for ($attempt = 0; $attempt < 100; $attempt++) {
            try {
                $this->httpText($url);
                return;
            } catch (RuntimeException $exception) {
                $lastError = $exception;
                usleep(200_000);
            }
        }

        throw new RuntimeException(
            'Docker benchmark server did not become ready: ' . ($lastError?->getMessage() ?? $url),
        );
    }

    private function runtimeFile(): string
    {
        return $this->suite->getProjectDirectory() . '/.benchmark-server.json';
    }

    /** @return array<string, mixed> */
    private function readRuntime(): array
    {
        $contents = is_file($this->runtimeFile()) ? file_get_contents($this->runtimeFile()) : false;
        if (!is_string($contents)) {
            return [];
        }

        try {
            $runtime = json_decode($contents, true, 16, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return [];
        }

        return is_array($runtime) ? $runtime : [];
    }

    /**
     * @param list<string> $command
     * @param null|callable(string):void $output
     * @return array{exitCode:int, stdout:string, stderr:string}
     */
    private static function runProcess(array $command, string $cwd, ?callable $output = null): array
    {
        $pipes = [];
        $process = proc_open(
            $command,
            [
                0 => ['file', '/dev/null', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ],
            $pipes,
            $cwd,
        );
        if (!is_resource($process)) {
            throw new RuntimeException('Unable to start process: ' . implode(' ', $command));
        }
        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);
        $stdout = '';
        $stderr = '';
        do {
            $read = [$pipes[1], $pipes[2]];
            $write = null;
            $except = null;
            @stream_select($read, $write, $except, 0, 200_000);
            foreach ($read as $stream) {
                $chunk = stream_get_contents($stream);
                if (!is_string($chunk) || $chunk === '') {
                    continue;
                }
                if ($stream === $pipes[1]) {
                    $stdout .= $chunk;
                } else {
                    $stderr .= $chunk;
                }
                if ($output !== null) {
                    $output($chunk);
                }
            }
            $status = proc_get_status($process);
        } while ($status['running']);

        foreach ([1, 2] as $index) {
            $chunk = stream_get_contents($pipes[$index]);
            if (is_string($chunk) && $chunk !== '') {
                if ($index === 1) {
                    $stdout .= $chunk;
                } else {
                    $stderr .= $chunk;
                }
                if ($output !== null) {
                    $output($chunk);
                }
            }
            fclose($pipes[$index]);
        }
        $closeCode = proc_close($process);
        $exitCode = ($status['exitcode'] ?? -1) >= 0 ? $status['exitcode'] : $closeCode;

        return ['exitCode' => $exitCode, 'stdout' => $stdout, 'stderr' => $stderr];
    }

    private function httpText(string $url): string
    {
        $handle = curl_init();
        try {
            if (!curl_setopt_array($handle, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_TIMEOUT => 5,
            ])) {
                throw new RuntimeException("Unable to configure request to {$url}");
            }
            $response = curl_exec($handle);
            $status = (int) curl_getinfo($handle, CURLINFO_HTTP_CODE);
            if (!is_string($response) || $status < 200 || $status >= 300) {
                throw new RuntimeException(sprintf(
                    'Request failed (%s): HTTP %d [%d] %s',
                    $url,
                    $status,
                    curl_errno($handle),
                    curl_error($handle),
                ));
            }

            return $response;
        } finally {
            curl_close($handle);
        }
    }

    /** @param list<string> $targets @return list<string> */
    private function resolveTargets(array $targets): array
    {
        if ($targets === []) {
            return $this->suite->targets();
        }
        // Reuse suite validation and retain the requested order.
        return array_map(
            static fn(BenchmarkConfig $config): string => $config->getName(),
            $this->suite->configs($targets),
        );
    }

    private function targetDirectory(string $target): string
    {
        return $this->suite->getProjectDirectory() . '/' . $target;
    }

    private function lifecycleScript(string $target, string $action): string
    {
        return $this->targetDirectory($target) . '/_benchmark/' . $action . '.sh';
    }

    private static function findExecutable(string $name): ?string
    {
        $path = getenv('PATH');
        if (!is_string($path)) {
            return null;
        }
        foreach (explode(PATH_SEPARATOR, $path) as $directory) {
            $candidate = rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name;
            if (is_file($candidate) && is_executable($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private static function clearBoundedDirectory(string $directory, string $boundary): void
    {
        if (!is_dir($directory)) {
            return;
        }
        $resolvedDirectory = realpath($directory);
        $resolvedBoundary = realpath($boundary);
        if (
            $resolvedDirectory === false
            || $resolvedBoundary === false
            || !str_starts_with($resolvedDirectory . '/', rtrim($resolvedBoundary, '/') . '/')
            || $resolvedDirectory === $resolvedBoundary
        ) {
            throw new RuntimeException("Refusing to clear unbounded cache directory: {$directory}");
        }
        $items = scandir($resolvedDirectory);
        if (!is_array($items)) {
            throw new RuntimeException("Unable to read cache directory: {$resolvedDirectory}");
        }
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            self::removeBoundedPath($resolvedDirectory . '/' . $item, $resolvedBoundary);
        }
    }

    private static function removeBoundedPath(string $path, string $boundary): void
    {
        if (!str_starts_with($path . '/', rtrim($boundary, '/') . '/')) {
            throw new RuntimeException("Refusing to remove path outside target: {$path}");
        }
        if (is_link($path) || is_file($path)) {
            if (!unlink($path)) {
                throw new RuntimeException("Unable to remove cache file: {$path}");
            }
            return;
        }
        if (!is_dir($path)) {
            return;
        }
        $items = scandir($path);
        if (!is_array($items)) {
            throw new RuntimeException("Unable to read cache directory: {$path}");
        }
        foreach ($items as $item) {
            if ($item !== '.' && $item !== '..') {
                self::removeBoundedPath($path . '/' . $item, $boundary);
            }
        }
        if (!rmdir($path)) {
            throw new RuntimeException("Unable to remove cache directory: {$path}");
        }
    }

    /** @return list<string> */
    private static function privilegePrefix(): array
    {
        if (function_exists('posix_geteuid') && posix_geteuid() === 0) {
            return [];
        }

        return ['sudo'];
    }
}
