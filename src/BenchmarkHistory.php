<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use JsonException;
use RuntimeException;
use Throwable;

/** Stores, lists, compares, renders, and safely removes benchmark run archives. */
final class BenchmarkHistory
{
    public function __construct(
        private readonly string $root,
        private readonly ?int $maximumEntries = null,
        private readonly bool $replaceMonthly = false,
    ) {
        if ($this->maximumEntries !== null && $this->maximumEntries < 1) {
            throw new InvalidArgumentException('maximumEntries must be at least 1');
        }
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    /** @param array<string, mixed> $payload */
    public function save(array $payload, string $markdown): string
    {
        $this->ensureRoot();
        $payload['schemaVersion'] ??= 1;
        $payload['recordedAt'] ??= gmdate(DATE_ATOM);
        $recordedAt = self::dateTime((string) $payload['recordedAt']);
        if ($recordedAt === null) {
            throw new InvalidArgumentException('recordedAt must be a valid date and time');
        }
        $recordedAt = $recordedAt->setTimezone(new DateTimeZone('UTC'));
        $payload['recordedAt'] = $recordedAt->format(DATE_ATOM);

        $prefix = $recordedAt->format('Y-m-d\THis\Z');
        $directory = '';
        for ($attempt = 0; $attempt < 100; ++$attempt) {
            $identifier = $prefix . ($attempt === 0 ? '' : sprintf('-%02d', $attempt));
            $candidate = rtrim($this->root, '/') . '/' . $identifier;
            if (@mkdir($candidate, 0777)) {
                $directory = $candidate;
                $payload['id'] = $identifier;
                break;
            }
        }
        if ($directory === '') {
            throw new RuntimeException("Unable to allocate a unique result directory under {$this->root}");
        }

        $this->write($directory . '/results.json', self::encode($payload) . PHP_EOL);
        $this->write($directory . '/report.md', $markdown);
        $this->write($directory . '/dashboard.html', BenchmarkDashboard::render($payload));
        $this->prune($payload['id'], $recordedAt);
        $this->writeIndex();

        return $directory;
    }

    /** @return list<array{id:string, recordedAt:string, recordedAtDisplay:string, targets:int, path:string}> */
    public function entries(): array
    {
        if (!is_dir($this->root)) {
            return [];
        }
        $directories = glob(rtrim($this->root, '/') . '/*', GLOB_ONLYDIR) ?: [];
        rsort($directories, SORT_STRING);
        $entries = [];
        foreach ($directories as $directory) {
            $id = basename($directory);
            if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{6}Z(?:-\d{2})?$/', $id) !== 1) {
                continue;
            }
            try {
                $payload = self::readPayloadFile($directory . '/results.json');
            } catch (RuntimeException) {
                continue;
            }
            $entries[] = [
                'id' => $id,
                'recordedAt' => (string) ($payload['recordedAt'] ?? $id),
                'recordedAtDisplay' => self::humanDateTime((string) ($payload['recordedAt'] ?? $id)),
                'targets' => count(self::results($payload)),
                'path' => $directory,
            ];
        }

        usort($entries, static function (array $left, array $right): int {
            $leftTimestamp = self::dateTime($left['recordedAt'])?->getTimestamp() ?? PHP_INT_MIN;
            $rightTimestamp = self::dateTime($right['recordedAt'])?->getTimestamp() ?? PHP_INT_MIN;
            $byDate = $rightTimestamp <=> $leftTimestamp;
            return $byDate !== 0 ? $byDate : strcmp($right['id'], $left['id']);
        });

        return $entries;
    }

    /** @return array<string, mixed> */
    public function load(string|int $identifier): array
    {
        $directory = $this->resolveDirectory($identifier);
        $file = $directory . '/results.json';
        return self::readPayloadFile($file);
    }

    /** @return array<string, mixed> */
    private static function readPayloadFile(string $file): array
    {
        $contents = file_get_contents($file);
        if (!is_string($contents)) {
            throw new RuntimeException("Unable to read benchmark results: {$file}");
        }
        try {
            $payload = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException("Invalid benchmark results JSON: {$file}", previous: $exception);
        }
        if (!is_array($payload)) {
            throw new RuntimeException("Invalid benchmark result payload: {$file}");
        }

        return $payload;
    }

    public function compare(string|int $current, string|int $baseline): string
    {
        $currentPayload = $this->load($current);
        $baselinePayload = $this->load($baseline);
        $currentResults = self::results($currentPayload);
        $baselineResults = self::results($baselinePayload);
        $targets = array_values(array_intersect(array_keys($currentResults), array_keys($baselineResults)));
        sort($targets);
        if ($targets === []) {
            throw new RuntimeException('The selected runs have no common targets');
        }

        $rows = [];
        foreach ($targets as $target) {
            $now = $currentResults[$target];
            $before = $baselineResults[$target];
            foreach ([
                'Stable RPM' => [$now['stable']['req_per_min'] ?? null, $before['stable']['req_per_min'] ?? null],
                'Peak RPM' => [$now['peak']['req_per_min'] ?? null, $before['peak']['req_per_min'] ?? null],
                'p50 ms' => [self::milliseconds($now['multiple']['p50'] ?? null), self::milliseconds($before['multiple']['p50'] ?? null)],
                'p99 ms' => [self::milliseconds($now['multiple']['p99'] ?? null), self::milliseconds($before['multiple']['p99'] ?? null)],
                'Error %' => [self::percent($now['multiple']['error_rate'] ?? null), self::percent($before['multiple']['error_rate'] ?? null)],
                'Remote MB' => [$now['remoteMemoryMB'] ?? null, $before['remoteMemoryMB'] ?? null],
                'Server ms' => [self::remoteMetric($now, 'server_execution_ms'), self::remoteMetric($before, 'server_execution_ms')],
                'Included files' => [self::remoteMetric($now, 'included_files'), self::remoteMetric($before, 'included_files')],
            ] as $metric => [$currentValue, $baselineValue]) {
                $rows[] = [
                    $target,
                    $metric,
                    self::display($baselineValue),
                    self::display($currentValue),
                    self::difference($currentValue, $baselineValue),
                ];
            }
        }

        return sprintf(
            "# Benchmark comparison\n\nCurrent: `%s`  \nBaseline: `%s`\n\n%s",
            self::identifier($currentPayload, $current),
            self::identifier($baselinePayload, $baseline),
            self::table(['Target', 'Metric', 'Baseline', 'Current', 'Change'], $rows),
        );
    }

    public function dashboard(string|int $identifier): string
    {
        $directory = $this->resolveDirectory($identifier);
        $file = $directory . '/dashboard.html';
        $this->write($file, BenchmarkDashboard::render($this->load($identifier)));
        $this->writeIndex();

        return $file;
    }

    public function delete(string|int $identifier, bool $allowDestructive = false): string
    {
        if (!$allowDestructive) {
            throw new RuntimeException('Deleting benchmark history requires explicit destructive-operation approval');
        }
        $directory = $this->resolveDirectory($identifier);
        self::removeTree($directory);
        $this->writeIndex();

        return $directory;
    }

    /** @return list<string> */
    public function deleteAll(bool $allowDestructive = false): array
    {
        if (!$allowDestructive) {
            throw new RuntimeException('Deleting all benchmark history requires explicit destructive-operation approval');
        }
        $deleted = [];
        foreach ($this->entries() as $entry) {
            self::removeTree($entry['path']);
            $deleted[] = $entry['path'];
        }
        $this->writeIndex();

        return $deleted;
    }

    private function writeIndex(): void
    {
        $this->ensureRoot();
        $items = '';
        foreach ($this->entries() as $position => $entry) {
            $id = htmlspecialchars($entry['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $recordedAt = htmlspecialchars($entry['recordedAt'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $date = htmlspecialchars($entry['recordedAtDisplay'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            $latest = $position === 0 ? '<span class="badge text-bg-primary">Latest</span>' : '';
            $items .= "<a class=\"run-card text-decoration-none\" href=\"{$id}/dashboard.html\">"
                . "<span><strong><time datetime=\"{$recordedAt}\" data-local-time>{$date}</time></strong></span>"
                . "<span class=\"run-meta\">{$latest}<span>{$entry['targets']} targets</span><b aria-hidden=\"true\">→</b></span>"
                . "</a>\n";
        }
        if ($items === '') {
            $items = '<div class="empty">No benchmark runs have been archived yet.</div>';
        }
        $html = "<!doctype html><html lang=\"en\"><head><meta charset=\"utf-8\">"
            . "<meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">"
            . "<title>PHP framework benchmark history</title>"
            . "<link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css\" rel=\"stylesheet\" "
            . "integrity=\"sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB\" crossorigin=\"anonymous\">"
            . "<style>:root{color-scheme:light dark;--page:#f4f7fb;--surface:#fff;--text:#172033;--muted:#64748b;--line:#dce3ee;--primary:#5b5bd6;--shadow:rgba(30,41,59,.07);--shadow-hover:rgba(30,41,59,.12)}"
            . "@media(prefers-color-scheme:dark){:root{--page:#07111f;--surface:#0e1b2e;--text:#e8eef8;--muted:#98a9bf;--line:#283b55;--primary:#8b8cf8;--shadow:rgba(0,0,0,.24);--shadow-hover:rgba(0,0,0,.34)}}"
            . "*{box-sizing:border-box}body{margin:0;min-height:100vh;background:radial-gradient(circle at 10% 0,rgba(91,91,214,.15),transparent 32rem),var(--page);color:var(--text);font-family:Inter,system-ui,sans-serif}"
            . ".shell{width:min(920px,calc(100% - 32px));margin:auto;padding:58px 0}.eyebrow{color:var(--primary);font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}"
            . "h1{margin:7px 0 8px;font-size:clamp(30px,6vw,48px);letter-spacing:-.04em}.lead{margin:0 0 28px;color:var(--muted)}.runs{display:grid;gap:11px}"
            . ".run-card{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:17px 19px;border:1px solid var(--line);border-radius:14px;background:var(--surface);color:var(--text);box-shadow:0 12px 34px var(--shadow);transition:.18s ease}"
            . ".run-card:hover{border-color:var(--primary);color:var(--primary);transform:translateY(-2px);box-shadow:0 18px 42px var(--shadow-hover)}"
            . ".run-meta{display:flex;align-items:center;gap:12px;white-space:nowrap;color:var(--muted)}.run-meta b{color:var(--primary);font-size:20px}.empty{padding:32px;border:1px dashed var(--line);border-radius:14px;text-align:center;color:var(--muted);background:var(--surface)}"
            . "@media(max-width:560px){.shell{padding-top:34px}.run-card{align-items:flex-start;flex-direction:column}.run-meta{width:100%;justify-content:space-between}}</style></head>"
            . "<body><main class=\"shell\"><div class=\"eyebrow\">Benchmark archive</div><h1>PHP framework performance</h1>"
            . "<p class=\"lead\">Monthly, reproducible reports generated with validated HTTP responses. Times are shown in your local time zone.</p><div class=\"runs\">{$items}</div></main>"
            . "<script>document.querySelectorAll('time[data-local-time]').forEach(element=>{const date=new Date(element.dateTime);if(Number.isNaN(date.getTime()))return;element.textContent=new Intl.DateTimeFormat(undefined,{year:'numeric',month:'long',day:'numeric',hour:'numeric',minute:'2-digit',timeZoneName:'short'}).format(date)})</script></body></html>";
        $this->write(rtrim($this->root, '/') . '/index.html', $html);
    }

    private function prune(string $currentId, DateTimeImmutable $recordedAt): void
    {
        if ($this->replaceMonthly) {
            $currentMonth = $recordedAt->format('Y-m');
            foreach ($this->entries() as $entry) {
                if ($entry['id'] === $currentId) {
                    continue;
                }
                $entryDate = self::dateTime($entry['recordedAt']);
                if ($entryDate !== null && $entryDate->setTimezone(new DateTimeZone('UTC'))->format('Y-m') === $currentMonth) {
                    self::removeTree($entry['path']);
                }
            }
        }

        if ($this->maximumEntries !== null) {
            foreach (array_slice($this->entries(), $this->maximumEntries) as $entry) {
                self::removeTree($entry['path']);
            }
        }
    }

    public static function humanDateTime(string $value): string
    {
        $date = self::dateTime($value);
        if ($date === null) {
            return $value;
        }

        return $date
            ->setTimezone(new DateTimeZone('UTC'))
            ->format('F j, Y \a\t g:i A \U\T\C');
    }

    private static function dateTime(string $value): ?DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($value);
        } catch (Throwable) {
            return null;
        }
    }

    private function ensureRoot(): void
    {
        if (!is_dir($this->root) && !mkdir($this->root, 0777, true) && !is_dir($this->root)) {
            throw new RuntimeException("Unable to create benchmark history directory: {$this->root}");
        }
    }

    private function resolveDirectory(string|int $identifier): string
    {
        $entries = $this->entries();
        if (is_int($identifier) || preg_match('/^\d+$/', (string) $identifier) === 1) {
            $index = (int) $identifier;
            if (!isset($entries[$index])) {
                throw new InvalidArgumentException("Benchmark history index does not exist: {$index}");
            }
            return $entries[$index]['path'];
        }

        $id = (string) $identifier;
        if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{6}Z(?:-\d{2})?$/', $id) !== 1) {
            throw new InvalidArgumentException("Invalid benchmark history identifier: {$id}");
        }
        $directory = rtrim($this->root, '/') . '/' . $id;
        if (!is_dir($directory)) {
            throw new InvalidArgumentException("Benchmark history entry does not exist: {$id}");
        }

        return $directory;
    }

    /** @param array<string, mixed> $payload @return array<string, array<string, mixed>> */
    private static function results(array $payload): array
    {
        $results = $payload['results'] ?? $payload;
        return is_array($results) ? $results : [];
    }

    /** @param array<string, mixed> $result */
    private static function remoteMetric(array $result, string $name): int|float|null
    {
        $value = $result['remoteMetrics'][$name]['average'] ?? null;
        return is_int($value) || is_float($value) ? $value : null;
    }

    private static function milliseconds(mixed $value): ?float
    {
        return is_int($value) || is_float($value) ? (float) $value * 1_000 : null;
    }

    private static function percent(mixed $value): ?float
    {
        return is_int($value) || is_float($value) ? (float) $value * 100 : null;
    }

    private static function display(mixed $value): string
    {
        return is_int($value) || is_float($value) ? number_format((float) $value, 2, '.', ',') : '—';
    }

    private static function difference(mixed $current, mixed $baseline): string
    {
        if ((!is_int($current) && !is_float($current)) || (!is_int($baseline) && !is_float($baseline))) {
            return '—';
        }
        if ((float) $baseline == 0.0) {
            return (float) $current == 0.0 ? '0.00%' : '—';
        }

        return sprintf('%+.2f%%', (((float) $current - (float) $baseline) / abs((float) $baseline)) * 100);
    }

    /** @param list<string> $header @param list<list<string>> $rows */
    private static function table(array $header, array $rows): string
    {
        $output = '| ' . implode(' | ', $header) . " |\n| " . implode(' | ', array_fill(0, count($header), '---')) . " |\n";
        foreach ($rows as $row) {
            $output .= '| ' . implode(' | ', array_map(
                static fn(string $value): string => str_replace('|', '\\|', $value),
                $row,
            )) . " |\n";
        }

        return $output;
    }

    /** @param array<string, mixed> $payload */
    private static function identifier(array $payload, string|int $fallback): string
    {
        return (string) ($payload['id'] ?? $fallback);
    }

    /** @param array<string, mixed> $value */
    private static function encode(array $value): string
    {
        try {
            return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Unable to encode benchmark results', previous: $exception);
        }
    }

    private function write(string $path, string $contents): void
    {
        if (file_put_contents($path, $contents, LOCK_EX) === false) {
            throw new RuntimeException("Unable to write {$path}");
        }
    }

    private static function removeTree(string $directory): void
    {
        $items = scandir($directory);
        if (!is_array($items)) {
            throw new RuntimeException("Unable to read {$directory}");
        }
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $path = $directory . '/' . $item;
            if (is_link($path) || is_file($path)) {
                if (!unlink($path)) {
                    throw new RuntimeException("Unable to delete {$path}");
                }
            } elseif (is_dir($path)) {
                self::removeTree($path);
            }
        }
        if (!rmdir($directory)) {
            throw new RuntimeException("Unable to delete {$directory}");
        }
    }
}
