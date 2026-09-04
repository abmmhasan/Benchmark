<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use InvalidArgumentException;
use JsonException;
use RuntimeException;

/** Adapts a framework fixture suite to validated BenchmarkConfig targets. */
final class PhpFrameworksBenchSuite
{
    /** @var list<string> */
    public const RUNTIME_PROFILES = [
        'opcache',
        'fpm',
        'swoole',
        'frankenphp',
        'roadrunner',
        'workerman',
    ];

    private readonly string $projectDirectory;
    private readonly string $baseUrl;
    private readonly string $config;

    public function __construct(string $projectDirectory, ?string $baseUrl = null)
    {
        $resolvedDirectory = realpath($projectDirectory);
        if ($resolvedDirectory === false || !is_dir($resolvedDirectory)) {
            throw new InvalidArgumentException("Framework suite directory does not exist: {$projectDirectory}");
        }

        $configFile = $resolvedDirectory . '/config';
        $config = is_file($configFile) ? file_get_contents($configFile) : false;
        if (!is_string($config)) {
            throw new InvalidArgumentException("Framework suite config was not found: {$configFile}");
        }

        $resolvedBaseUrl = $baseUrl
            ?? self::runtimeBaseUrl($resolvedDirectory)
            ?? self::shellConfigValue($config, 'base');
        if ($resolvedBaseUrl === null || filter_var($resolvedBaseUrl, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('A valid base URL is required for the framework suite');
        }

        $this->projectDirectory = $resolvedDirectory;
        $this->baseUrl = rtrim($resolvedBaseUrl, '/');
        $this->config = $config;
    }

    public function getProjectDirectory(): string
    {
        return $this->projectDirectory;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getSuggestedConcurrency(): int
    {
        $connections = self::shellConfigInteger($this->config, 'connections');
        return $connections === null
            ? 100
            : max(2, min(BenchmarkConfig::MAX_THREADS, $connections));
    }

    public function getSuggestedDuration(): int
    {
        $duration = self::shellConfigInteger($this->config, 'duration');
        return $duration === null
            ? 30
            : max(1, min(BenchmarkConfig::MAX_PHASE_DURATION_SECONDS, $duration));
    }

    /** @return list<string> */
    public function targets(): array
    {
        if (preg_match('/^frameworks_list\s*=\s*"(?<targets>.*?)"\s*$/ms', $this->config, $match) !== 1) {
            throw new RuntimeException('Unable to read frameworks_list from framework suite config');
        }

        $targets = preg_split('/\s+/', trim($match['targets']), flags: PREG_SPLIT_NO_EMPTY);
        if (!is_array($targets) || $targets === []) {
            throw new RuntimeException('Framework suite does not define any framework targets');
        }

        $available = [];
        foreach ($targets as $target) {
            self::assertTargetName($target);
            if (is_file($this->helloWorldFile($target))) {
                $available[] = $target;
            }
        }

        if ($available === []) {
            throw new RuntimeException('No framework target contains _benchmark/hello_world.sh');
        }

        return $available;
    }

    /**
     * Return execution-runtime capabilities keyed by target name.
     *
     * @param list<string> $targets Empty means every available target.
     * @return array<string, string>
     */
    public function runtimes(array $targets = []): array
    {
        $runtimes = $this->classifications('framework_runtimes', $targets);
        foreach ($runtimes as $target => $runtime) {
            $profiles = $runtime === 'both' ? ['opcache', 'swoole'] : explode('-', $runtime);
            if ($profiles === [] || array_diff($profiles, self::RUNTIME_PROFILES) !== []) {
                throw new RuntimeException("Invalid framework_runtimes definition for target: {$target}");
            }
        }

        return $runtimes;
    }

    /** @return list<string> */
    public function targetsForRuntime(string $runtime): array
    {
        if (!in_array($runtime, self::RUNTIME_PROFILES, true)) {
            throw new InvalidArgumentException("Unknown benchmark runtime: {$runtime}");
        }

        return array_keys(array_filter(
            $this->runtimes(),
            static fn(string $targetRuntime): bool => $targetRuntime === 'both'
                ? in_array($runtime, ['opcache', 'swoole'], true)
                : in_array($runtime, explode('-', $targetRuntime), true),
        ));
    }

    /**
     * Return dashboard category slugs keyed by target name.
     *
     * @param list<string> $targets Empty means every available target.
     * @return array<string, string>
     */
    public function categories(array $targets = []): array
    {
        return $this->classifications('framework_categories', $targets);
    }

    /**
     * Return dashboard architecture slugs keyed by target name.
     *
     * @param list<string> $targets Empty means every available target.
     * @return array<string, string>
     */
    public function architectures(array $targets = []): array
    {
        return $this->classifications('framework_architectures', $targets);
    }

    /**
     * Return whether each target's framework ships first-party DI support.
     *
     * @param list<string> $targets Empty means every available target.
     * @return array<string, string>
     */
    public function builtInDi(array $targets = []): array
    {
        return $this->binaryClassifications('framework_built_in_di', $targets);
    }

    /**
     * Return whether each target ships a full-featured route dispatcher.
     *
     * @param list<string> $targets Empty means every available target.
     * @return array<string, string>
     */
    public function fullFeaturedRouteDispatchers(array $targets = []): array
    {
        return $this->binaryClassifications('framework_full_featured_route_dispatchers', $targets);
    }

    /**
     * Return installed framework releases keyed by target name.
     *
     * @param list<string> $targets Empty means every available target.
     * @return array<string, string>
     */
    public function versions(array $targets = [], ?string $serverPhpVersion = null): array
    {
        $selected = $this->selectTargets($targets);
        $packages = $this->versionPackages();
        $versions = [];
        foreach ($selected as $target) {
            if ($target === 'pure-php') {
                $versions[$target] = $serverPhpVersion === null || $serverPhpVersion === ''
                    ? 'PHP'
                    : 'PHP ' . $serverPhpVersion;
                continue;
            }

            $package = $packages[$target] ?? null;
            $versions[$target] = is_string($package)
                ? ($this->installedPackageVersion($target, $package) ?? 'Version unavailable')
                : 'Version unavailable';
        }

        return $versions;
    }

    /**
     * @param list<string> $targets
     * @return array<string, string>
     */
    private function classifications(string $configKey, array $targets): array
    {
        $available = $this->targets();
        $selected = $this->selectTargets($targets);

        $classifications = array_fill_keys($available, 'uncategorized');
        $pattern = '/^' . preg_quote($configKey, '/') . '\s*=\s*"(?<definitions>.*?)"\s*$/ms';
        if (preg_match($pattern, $this->config, $match) === 1) {
            $definitions = preg_split('/\s+/', trim($match['definitions']), flags: PREG_SPLIT_NO_EMPTY);
            foreach (is_array($definitions) ? $definitions : [] as $definition) {
                if (preg_match('/^(?<target>[a-zA-Z0-9][a-zA-Z0-9._-]*):(?<value>[a-z][a-z0-9-]*)$/', $definition, $parts) !== 1) {
                    throw new RuntimeException("Invalid {$configKey} definition: {$definition}");
                }
                if (isset($classifications[$parts['target']])) {
                    $classifications[$parts['target']] = $parts['value'];
                }
            }
        }

        return array_intersect_key($classifications, array_flip($selected));
    }

    /** @param list<string> $targets @return array<string, string> */
    private function binaryClassifications(string $configKey, array $targets): array
    {
        $classifications = $this->classifications($configKey, $targets);
        foreach ($classifications as $target => $value) {
            if (!in_array($value, ['yes', 'no'], true)) {
                throw new RuntimeException("Missing yes/no {$configKey} definition for target: {$target}");
            }
        }

        return $classifications;
    }

    /** @param list<string> $targets @return list<string> */
    private function selectTargets(array $targets): array
    {
        $available = $this->targets();
        $selected = $targets === [] ? $available : array_values($targets);
        $unknown = array_values(array_diff($selected, $available));
        if ($unknown !== []) {
            throw new InvalidArgumentException('Unknown framework target(s): ' . implode(', ', $unknown));
        }

        return $selected;
    }

    /** @return array<string, string> */
    private function versionPackages(): array
    {
        if (preg_match('/^framework_version_packages\s*=\s*"(?<definitions>.*?)"\s*$/ms', $this->config, $match) !== 1) {
            return [];
        }
        $packages = [];
        $definitions = preg_split('/\s+/', trim($match['definitions']), flags: PREG_SPLIT_NO_EMPTY);
        foreach (is_array($definitions) ? $definitions : [] as $definition) {
            if (preg_match('/^(?<target>[a-zA-Z0-9][a-zA-Z0-9._-]*):(?<package>[a-z0-9_.-]+\/[a-z0-9_.-]+)$/', $definition, $parts) !== 1) {
                throw new RuntimeException("Invalid framework_version_packages definition: {$definition}");
            }
            $packages[$parts['target']] = $parts['package'];
        }

        return $packages;
    }

    private function installedPackageVersion(string $target, string $package): ?string
    {
        $asset = $this->projectDirectory . '/' . $target . '/asset';
        $lock = self::readJson($asset . '/composer.lock');
        foreach ($lock['packages'] ?? [] as $installed) {
            if (is_array($installed) && ($installed['name'] ?? null) === $package) {
                return self::stableVersion($installed['pretty_version'] ?? $installed['version'] ?? null);
            }
        }

        $projectVersion = $this->installedProjectVersion($asset, $package);
        if ($projectVersion !== null) {
            return $projectVersion;
        }

        $installedPhp = $asset . '/vendor/composer/installed.php';
        if (!is_file($installedPhp)) {
            return null;
        }
        $metadata = require $installedPhp;
        if (!is_array($metadata)) {
            return null;
        }
        $sets = isset($metadata['root']) ? [$metadata] : $metadata;
        foreach ($sets as $set) {
            if (!is_array($set)) {
                continue;
            }
            $root = $set['root'] ?? null;
            if (is_array($root) && ($root['name'] ?? null) === $package) {
                return self::stableVersion($root['pretty_version'] ?? $root['version'] ?? null);
            }
            $versions = $set['versions'] ?? [];
            if (is_array($versions) && is_array($versions[$package] ?? null)) {
                return self::stableVersion(
                    $versions[$package]['pretty_version'] ?? $versions[$package]['version'] ?? null,
                );
            }
        }

        return null;
    }

    private function installedProjectVersion(string $asset, string $package): ?string
    {
        $marker = $asset . '/.benchmark-project-version';
        if (!is_file($marker)) {
            return null;
        }

        $lines = file($marker, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!is_array($lines) || ($lines[0] ?? null) !== $package) {
            return null;
        }

        return self::stableVersion($lines[1] ?? null);
    }

    /** @return array<string, mixed> */
    private static function readJson(string $file): array
    {
        if (!is_file($file)) {
            return [];
        }
        $decoded = json_decode((string) file_get_contents($file), true);

        return is_array($decoded) ? $decoded : [];
    }

    private static function cleanVersion(mixed $version): ?string
    {
        if (!is_string($version) || trim($version) === '') {
            return null;
        }

        return trim($version);
    }

    private static function stableVersion(mixed $version): ?string
    {
        $version = self::cleanVersion($version);
        if ($version === null) {
            return null;
        }

        $normalized = strtolower($version);
        if (
            str_starts_with($normalized, 'dev-')
            || str_ends_with($normalized, '-dev')
            || in_array($normalized, ['main', 'master'], true)
        ) {
            return null;
        }

        return $version;
    }

    /**
     * @param list<string> $targets Empty means every configured target.
     * @return list<BenchmarkConfig>
     */
    public function configs(array $targets = []): array
    {
        $available = $this->targets();
        $selected = $targets === [] ? $available : array_values($targets);
        if (count(array_unique($selected)) !== count($selected)) {
            throw new InvalidArgumentException('Framework targets must be unique');
        }

        $unknown = array_values(array_diff($selected, $available));
        if ($unknown !== []) {
            throw new InvalidArgumentException('Unknown framework target(s): ' . implode(', ', $unknown));
        }

        $configs = [];
        foreach ($selected as $target) {
            self::assertTargetName($target);
            $routeScenarios = $this->targetRouteScenarios($target);
            $staticScenario = $routeScenarios[0];
            $configs[] = new BenchmarkConfig(
                url: $staticScenario->getUrl(),
                method: $staticScenario->getMethod(),
                headers: [
                    'Accept' => 'text/plain, application/json',
                    'Cache-Control' => 'no-cache',
                ],
                expectedStatus: $staticScenario->getExpectedStatus(),
                name: $target,
                responseValidator: $staticScenario->getResponseValidator(),
                responseMemoryExtractor: self::extractMemoryBytes(...),
                responseMetricsExtractor: self::extractResponseMetrics(...),
                routeScenarios: $routeScenarios,
            );
        }

        return $configs;
    }

    public static function isExpectedResponse(string $response): bool
    {
        $telemetry = self::parseTelemetry($response);
        if ($telemetry === null) {
            return false;
        }

        $payload = $telemetry['payload'];
        if ($payload === 'Hello World!') {
            return true;
        }

        try {
            $json = json_decode($payload, true, 32, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return false;
        }

        return is_array($json)
            && ($json['status'] ?? null) === true
            && ($json['message'] ?? null) === 'Hello World!';
    }

    public static function hasTelemetry(string $response): bool
    {
        return self::parseTelemetry($response) !== null;
    }

    public static function isExpectedErrorResponse(string $response): bool
    {
        return trim($response) !== '';
    }

    public static function extractMemoryBytes(string $response): int|float|null
    {
        return self::parseTelemetry($response)['memoryBytes'] ?? null;
    }

    /** @return array{server_execution_ms:float, included_files:int}|array{} */
    public static function extractResponseMetrics(string $response): array
    {
        $telemetry = self::parseTelemetry($response);
        if ($telemetry === null) {
            return [];
        }

        return [
            'server_execution_ms' => $telemetry['executionSeconds'] * 1_000,
            'included_files' => $telemetry['includedFiles'],
        ];
    }

    /** @return list<RouteScenario> */
    private function targetRouteScenarios(string $target): array
    {
        $definition = file_get_contents($this->helloWorldFile($target));
        if (!is_string($definition)) {
            throw new RuntimeException("Unable to read hello-world definition for {$target}");
        }

        $specifications = [
            ['route_static', 'static', 'Static', false, '/hello/index'],
            ['route_dynamic_first', 'dynamic-first', 'Dynamic first', false, '/{value}/hello/index'],
            ['route_dynamic_middle', 'dynamic-middle', 'Dynamic middle', false, '/hello/{value}/index'],
            ['route_dynamic_last', 'dynamic-last', 'Dynamic last', false, '/hello/index/{value}'],
            ['route_multiple', 'multiple-parameters', 'Multiple parameters', false, '/hello/pair/{first}/{second}'],
            ['route_static_precedence', 'static-precedence', 'Static precedence', false, '/hello/benchmark/fixed'],
            ['route_not_found', 'not-found', '404', false, '/benchmark/not-found'],
            ['route_method_not_allowed', 'method-not-allowed', '405', true, '/hello/index'],
        ];
        $scenarios = [];
        foreach ($specifications as [$variable, $key, $label, $safeForWarmUp, $routePattern]) {
            $definitionPattern = '/^\s*' . preg_quote($variable, '/') . '\s*=\s*(["\'])(?<definition>.*?)\1\s*$/m';
            if (preg_match($definitionPattern, $definition, $match) !== 1) {
                throw new RuntimeException("Missing {$variable} definition for {$target}");
            }
            if (preg_match('/^(?<method>[A-Z]+)\s+(?<status>\d{3})\s+(?<url>\S+)$/', $match['definition'], $parts) !== 1) {
                throw new RuntimeException("Invalid {$variable} definition for {$target}");
            }

            $method = HttpMethod::tryFrom($parts['method']);
            if ($method === null) {
                throw new RuntimeException("Unsupported {$variable} HTTP method for {$target}");
            }
            $status = (int) $parts['status'];
            $url = $this->resolveTargetUrl($target, $parts['url']);
            $scenarios[] = new RouteScenario(
                $key,
                $label,
                $url,
                $method,
                $status,
                $status < 400 ? self::isExpectedResponse(...) : self::isExpectedErrorResponse(...),
                safeForWarmUp: $safeForWarmUp ? true : null,
                pattern: $routePattern,
            );
        }

        $static = $scenarios[0];
        if ($static->getMethod() !== HttpMethod::GET || $static->getExpectedStatus() !== 200) {
            throw new RuntimeException("The static route for {$target} must declare GET 200");
        }

        return $scenarios;
    }

    private function resolveTargetUrl(string $target, string $expression): string
    {
        $prefix = '$base/$fw';
        if (!str_starts_with($expression, $prefix)) {
            throw new RuntimeException("Unsupported target URL expression for {$target}");
        }

        $suffix = substr($expression, strlen($prefix));
        if ($suffix === '' || $suffix[0] !== '/' || preg_match('/[`$\\\\]/', $suffix) === 1) {
            throw new RuntimeException("Unsafe target URL suffix for {$target}");
        }

        $url = $this->baseUrl . '/' . $target . $suffix;
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new RuntimeException("Invalid target URL generated for {$target}");
        }

        return $url;
    }

    private function helloWorldFile(string $target): string
    {
        return $this->projectDirectory . '/' . $target . '/_benchmark/hello_world.sh';
    }

    /**
     * @return null|array{payload:string, memoryBytes:float, executionSeconds:float, includedFiles:int}
     */
    private static function parseTelemetry(string $response): ?array
    {
        $matched = preg_match(
            '/(?<memory>\d+):(?<seconds>\d+(?:\.\d+)?):(?<files>\d+)\s*\z/',
            $response,
            $match,
            PREG_OFFSET_CAPTURE,
        );
        if ($matched !== 1) {
            return null;
        }

        $memory = (float) $match['memory'][0];
        $seconds = (float) $match['seconds'][0];
        $files = (int) $match['files'][0];
        if (!is_finite($memory) || !is_finite($seconds) || $memory < 0 || $seconds < 0 || $files < 0) {
            return null;
        }

        return [
            'payload' => trim(substr($response, 0, $match[0][1])),
            'memoryBytes' => $memory,
            'executionSeconds' => $seconds,
            'includedFiles' => $files,
        ];
    }

    private static function shellConfigValue(string $config, string $name): ?string
    {
        $quotedName = preg_quote($name, '/');
        if (preg_match('/^' . $quotedName . '\s*=\s*"(?<value>[^"\r\n]*)"\s*$/m', $config, $match) === 1) {
            return $match['value'];
        }
        if (preg_match('/^' . $quotedName . '\s*=\s*(?<value>[^\s#]+)\s*$/m', $config, $match) === 1) {
            return $match['value'];
        }

        return null;
    }

    private static function runtimeBaseUrl(string $projectDirectory): ?string
    {
        $file = $projectDirectory . '/.benchmark-server.json';
        if (!is_file($file)) {
            return null;
        }

        $contents = file_get_contents($file);
        if (!is_string($contents)) {
            return null;
        }

        try {
            $runtime = json_decode($contents, true, 16, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return null;
        }

        $runtimeUrl = is_array($runtime) ? ($runtime['baseUrl'] ?? null) : null;

        return is_string($runtimeUrl) && filter_var($runtimeUrl, FILTER_VALIDATE_URL) !== false
            ? $runtimeUrl
            : null;
    }

    private static function shellConfigInteger(string $config, string $name): ?int
    {
        $value = self::shellConfigValue($config, $name);
        return $value !== null && preg_match('/^\d+$/', $value) === 1 ? (int) $value : null;
    }

    private static function assertTargetName(string $target): void
    {
        if (preg_match('/^[a-zA-Z0-9][a-zA-Z0-9._-]*$/', $target) !== 1) {
            throw new InvalidArgumentException("Invalid framework target name: {$target}");
        }
    }
}
