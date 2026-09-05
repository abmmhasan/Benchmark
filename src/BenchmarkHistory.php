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
    /** @var array<string, array{title:string, badge:string, description:string}> */
    private const RUNTIME_PROFILES = [
        'opcache' => [
            'title' => 'OPcache + Apache',
            'badge' => 'Request per process',
            'description' => 'Production OPcache with Apache',
        ],
        'swoole' => [
            'title' => 'Swoole',
            'badge' => 'Persistent worker',
            'description' => 'Native persistent-worker runtime',
        ],
        'fpm' => [
            'title' => 'PHP-FPM + Nginx',
            'badge' => 'Request per process',
            'description' => 'Production OPcache behind Nginx and PHP-FPM',
        ],
        'frankenphp' => [
            'title' => 'FrankenPHP',
            'badge' => 'Persistent worker',
            'description' => 'FrankenPHP worker mode',
        ],
        'roadrunner' => [
            'title' => 'RoadRunner',
            'badge' => 'Persistent worker',
            'description' => 'RoadRunner PSR-7 workers and Laravel Octane',
        ],
        'workerman' => [
            'title' => 'Workerman',
            'badge' => 'Event worker',
            'description' => 'Native Workerman event-loop workers',
        ],
    ];

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
        $this->write(
            $directory . '/dashboard.html',
            BenchmarkDashboard::render($payload, $this->dashboardArchiveUrl()),
        );
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
        $this->write(
            $file,
            BenchmarkDashboard::render($this->load($identifier), $this->dashboardArchiveUrl()),
        );
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
        if ($this->runtimeProfile() !== null) {
            $legacyRuntimeIndex = rtrim($this->root, '/') . '/index.html';
            if (is_file($legacyRuntimeIndex) && !unlink($legacyRuntimeIndex)) {
                throw new RuntimeException("Unable to remove obsolete runtime index: {$legacyRuntimeIndex}");
            }
            $this->writeCombinedIndex(dirname(rtrim($this->root, '/')));
            return;
        }

        $this->writeLocalIndex();
    }

    private function writeLocalIndex(): void
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

    public static function refreshCombinedIndex(string $archiveRoot): void
    {
        (new self($archiveRoot))->writeCombinedIndex($archiveRoot);
    }

    private function writeCombinedIndex(string $archiveRoot): void
    {
        $archiveRoot = rtrim($archiveRoot, '/');
        if ($archiveRoot === '') {
            throw new InvalidArgumentException('Combined archive root cannot be empty');
        }
        if (!is_dir($archiveRoot) && !mkdir($archiveRoot, 0777, true) && !is_dir($archiveRoot)) {
            throw new RuntimeException("Unable to create combined archive directory: {$archiveRoot}");
        }

        /** @var array<string, array{recordedAt:string, timestamp:int, runs:array<string, array{id:string, recordedAt:string, recordedAtDisplay:string, targets:int, path:string}>}> $dates */
        $dates = [];
        foreach (self::RUNTIME_PROFILES as $profile => $_metadata) {
            $runtimeHistory = new self($archiveRoot . '/' . $profile);
            foreach ($runtimeHistory->entries() as $entry) {
                $date = self::dateTime($entry['recordedAt']);
                if ($date === null) {
                    continue;
                }
                $utcDate = $date->setTimezone(new DateTimeZone('UTC'));
                $key = $utcDate->format('Y-m-d');
                $timestamp = $utcDate->getTimestamp();
                $dates[$key] ??= [
                    'recordedAt' => $entry['recordedAt'],
                    'timestamp' => $timestamp,
                    'runs' => [],
                ];
                if ($timestamp > $dates[$key]['timestamp']) {
                    $dates[$key]['recordedAt'] = $entry['recordedAt'];
                    $dates[$key]['timestamp'] = $timestamp;
                }
                $existing = $dates[$key]['runs'][$profile] ?? null;
                if ($existing === null || $timestamp > (self::dateTime($existing['recordedAt'])?->getTimestamp() ?? 0)) {
                    $dates[$key]['runs'][$profile] = $entry;
                }
            }
        }
        uasort($dates, static fn(array $left, array $right): int => $right['timestamp'] <=> $left['timestamp']);

        $cards = '';
        $datePosition = 0;
        foreach ($dates as $dateKey => $date) {
            $recordedAt = self::escape($date['recordedAt']);
            $fallbackDate = self::dateTime($date['recordedAt'])?->format('F j, Y') ?? $date['recordedAt'];
            $runtimeCount = count($date['runs']);
            $runtimeLabel = $runtimeCount === 1 ? '1 runtime report' : "{$runtimeCount} runtime reports";
            $latest = $datePosition === 0 ? '<span class="latest-badge">Latest</span>' : '';
            $options = '';
            foreach (self::RUNTIME_PROFILES as $profile => $metadata) {
                $entry = $date['runs'][$profile] ?? null;
                if ($entry === null) {
                    continue;
                }
                $id = self::escape($entry['id']);
                $time = self::escape($entry['recordedAt']);
                $timeFallback = self::escape($entry['recordedAtDisplay']);
                $title = self::escape($metadata['title']);
                $badge = self::escape($metadata['badge']);
                $description = self::escape($metadata['description']);
                $targets = $entry['targets'];
                $options .= "<a class=\"runtime-option runtime-{$profile}\" href=\"{$profile}/{$id}/dashboard.html\">"
                    . "<span><span class=\"runtime-badge\">{$badge}</span><strong>{$title}</strong>"
                    . "<small>{$description} · {$targets} targets · <time datetime=\"{$time}\" data-local-time>{$timeFallback}</time></small></span>"
                    . '<b aria-hidden="true">→</b></a>';
            }
            $combinedResults = self::combinedResultsSection($date['runs'], $dateKey);
            $open = $datePosition === 0 ? ' open' : '';
            $cards .= "<details class=\"date-card\"{$open}><summary><span><time datetime=\"{$recordedAt}\" data-local-date>"
                . self::escape($fallbackDate)
                . "</time></span><span class=\"date-meta\">{$latest}<span>{$runtimeLabel}</span><b aria-hidden=\"true\"></b></span></summary>"
                . "<div class=\"runtime-options\">{$options}</div>{$combinedResults}</details>";
            ++$datePosition;
        }
        $timelineClass = $cards === '' ? 'timeline timeline-empty' : 'timeline';
        if ($cards === '') {
            $cards = '<div class="empty">No benchmark reports are available yet. The next benchmark workflow will publish them here.</div>';
        }

        $html = <<<HTML
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="color-scheme" content="light dark">
<title>PHP framework benchmark reports</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<style>
:root{color-scheme:light dark;--page:#f4f7fb;--surface:#fff;--surface-2:#f8fafc;--text:#172033;--muted:#64748b;--line:#dce3ee;--primary:#5b5bd6;--cyan:#0891b2;--shadow:rgba(30,41,59,.09)}@media(prefers-color-scheme:dark){:root{--page:#07111f;--surface:#0e1b2e;--surface-2:#132238;--text:#e8eef8;--muted:#98a9bf;--line:#283b55;--primary:#8b8cf8;--cyan:#22d3ee;--shadow:rgba(0,0,0,.28)}}*{box-sizing:border-box}body{margin:0;min-height:100vh;background:radial-gradient(circle at 8% 0,rgba(91,91,214,.15),transparent 30rem),radial-gradient(circle at 95% 5%,rgba(8,145,178,.12),transparent 26rem),var(--page);color:var(--text);font-family:Inter,system-ui,sans-serif}.shell{width:min(980px,calc(100% - 32px));margin:auto;padding:64px 0}.eyebrow{color:var(--primary);font-size:12px;font-weight:800;letter-spacing:.12em;text-transform:uppercase}h1{margin:8px 0;font-size:clamp(34px,6vw,54px);letter-spacing:-.045em}.lead{max-width:760px;margin:0 0 30px;color:var(--muted);font-size:17px}.timeline{display:grid;gap:12px}.date-card{overflow:hidden;border:1px solid var(--line);border-radius:16px;background:var(--surface);box-shadow:0 16px 44px var(--shadow)}.date-card[open]{border-color:color-mix(in srgb,var(--primary) 55%,var(--line))}.date-card summary{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:19px 21px;cursor:pointer;list-style:none;font-weight:850}.date-card summary::-webkit-details-marker{display:none}.date-meta{display:flex;align-items:center;gap:12px;color:var(--muted);font-size:13px;font-weight:700;white-space:nowrap}.date-meta b{width:10px;height:10px;border-right:2px solid var(--primary);border-bottom:2px solid var(--primary);transform:rotate(45deg);transition:transform .18s}.date-card[open] .date-meta b{transform:rotate(225deg)}.latest-badge,.runtime-badge{display:inline-flex;padding:3px 8px;border-radius:999px;background:color-mix(in srgb,var(--primary) 14%,transparent);color:var(--primary);font-size:10px;font-weight:850;text-transform:uppercase;letter-spacing:.05em}.runtime-options{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:11px;padding:0 14px 14px;border-top:1px solid var(--line)}.runtime-option{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-top:14px;padding:16px;border:1px solid var(--line);border-radius:12px;background:var(--surface-2);color:var(--text);text-decoration:none;transition:.18s ease}.runtime-option:hover{border-color:var(--primary);color:var(--text);transform:translateY(-2px)}.runtime-option>span{display:grid;justify-items:start;gap:5px}.runtime-option strong{font-size:17px}.runtime-option small{color:var(--muted)}.runtime-option b{color:var(--primary);font-size:20px}.runtime-swoole .runtime-badge,.runtime-swoole b{color:var(--cyan)}.runtime-swoole .runtime-badge{background:color-mix(in srgb,var(--cyan) 14%,transparent)}.runtime-swoole:hover{border-color:var(--cyan)}.empty{padding:34px;border:1px dashed var(--line);border-radius:16px;background:var(--surface);color:var(--muted);text-align:center}@media(max-width:680px){.shell{padding:38px 0}.date-card summary{align-items:flex-start;flex-direction:column;gap:9px}.date-meta{width:100%;white-space:normal}.date-meta b{margin-left:auto}.runtime-options{grid-template-columns:1fr}}
.timeline{position:relative;padding-left:34px}.timeline::before{content:"";position:absolute;top:27px;bottom:27px;left:9px;width:2px;border-radius:999px;background:linear-gradient(var(--primary),color-mix(in srgb,var(--cyan) 50%,var(--line)),var(--line))}.timeline-empty{padding-left:0}.timeline-empty::before{display:none}.date-card{position:relative;overflow:visible}.date-card::before{content:"";position:absolute;z-index:2;top:23px;left:-31px;width:14px;height:14px;border:3px solid var(--page);border-radius:50%;background:var(--line);box-shadow:0 0 0 2px var(--line)}.date-card[open]::before{background:var(--primary);box-shadow:0 0 0 2px var(--primary),0 0 0 7px color-mix(in srgb,var(--primary) 12%,transparent)}.date-card:first-child::before{background:var(--cyan);box-shadow:0 0 0 2px var(--cyan),0 0 0 7px color-mix(in srgb,var(--cyan) 14%,transparent)}@media(max-width:680px){.timeline:not(.timeline-empty){padding-left:26px}.timeline::before{left:6px}.date-card::before{left:-26px}}
.shell{width:min(1480px,calc(100% - 32px))}.combined-results{margin:0 14px 14px;padding:20px;border:1px solid var(--line);border-radius:14px;background:var(--surface-2)}.combined-heading{display:flex;align-items:flex-end;justify-content:space-between;gap:20px;margin-bottom:15px}.combined-heading h2{margin:0 0 3px;font-size:20px}.combined-heading p{margin:0;color:var(--muted);font-size:13px}.combined-heading>span{color:var(--muted);font-size:12px;font-weight:750;white-space:nowrap}.result-filters{display:grid;grid-template-columns:minmax(220px,1.5fr) repeat(3,minmax(150px,1fr)) auto;gap:10px;align-items:end;margin-bottom:14px}.result-filters label{display:grid;gap:5px;color:var(--muted);font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.04em}.result-filters input,.result-filters select,.reset-filters{width:100%;min-height:40px;padding:8px 11px;border:1px solid var(--line);border-radius:9px;background:var(--surface);color:var(--text);font:inherit;text-transform:none;letter-spacing:normal}.result-filters input:focus,.result-filters select:focus{outline:2px solid color-mix(in srgb,var(--primary) 35%,transparent);border-color:var(--primary)}.reset-filters{width:auto;cursor:pointer;font-weight:750}.reset-filters:hover{border-color:var(--primary);color:var(--primary)}.combined-table-wrap{overflow:auto;border:1px solid var(--line);border-radius:11px;background:var(--surface)}.combined-table{width:100%;min-width:1160px;border-collapse:collapse;font-size:12px}.combined-table th,.combined-table td{padding:10px 11px;border-bottom:1px solid var(--line);text-align:right;white-space:nowrap}.combined-table th{position:sticky;top:0;z-index:1;background:var(--surface-2)}.combined-table th:first-child,.combined-table th:nth-child(2),.combined-table td:first-child,.combined-table td:nth-child(2){text-align:left}.combined-table th button{display:inline-flex;align-items:center;gap:5px;padding:0;border:0;background:transparent;color:var(--muted);font:inherit;font-weight:800;cursor:pointer}.combined-table th button::after{content:"↕";font-size:10px;opacity:.55}.combined-table th button[data-sort-direction="asc"]::after{content:"↑";opacity:1}.combined-table th button[data-sort-direction="desc"]::after{content:"↓";opacity:1}.combined-table tbody tr:hover{background:color-mix(in srgb,var(--primary) 6%,transparent)}.combined-table tbody tr:last-child td{border-bottom:0}.result-target{display:flex;align-items:center;gap:7px}.result-version,.result-traits span{display:inline-flex;padding:2px 6px;border:1px solid color-mix(in srgb,var(--cyan) 45%,var(--line));border-radius:999px;color:var(--cyan);font-size:9px;font-weight:800}.result-traits{display:flex;gap:5px;margin-top:4px}.result-traits span{border-color:var(--line);color:var(--muted)}.system-link{color:var(--primary);font-weight:750;text-decoration:none}.system-link:hover{text-decoration:underline}.empty-table{text-align:center!important;color:var(--muted)}[data-result-row][hidden]{display:none}@media(max-width:960px){.result-filters{grid-template-columns:repeat(2,minmax(0,1fr))}.reset-filters{width:100%}}@media(max-width:600px){.combined-results{margin:0 8px 8px;padding:13px}.combined-heading{align-items:flex-start;flex-direction:column;gap:6px}.result-filters{grid-template-columns:1fr}.runtime-options{padding-left:8px;padding-right:8px}}
</style>
</head>
<body>
<main class="shell"><div class="eyebrow">Benchmark report archive</div><h1>PHP framework performance</h1><p class="lead">Browse reports along the benchmark timeline, expand a date, then choose the execution model you want to inspect. Every runtime uses the same validation, route, concurrency, repetition, stability, latency, and telemetry procedure.</p><div class="{$timelineClass}">{$cards}</div></main>
<script>
document.querySelectorAll('time[data-local-date]').forEach(element=>{const date=new Date(element.dateTime);if(Number.isNaN(date.getTime()))return;element.textContent=new Intl.DateTimeFormat(undefined,{year:'numeric',month:'long',day:'numeric'}).format(date)});
document.querySelectorAll('time[data-local-time]').forEach(element=>{const date=new Date(element.dateTime);if(Number.isNaN(date.getTime()))return;element.textContent=new Intl.DateTimeFormat(undefined,{hour:'numeric',minute:'2-digit',timeZoneName:'short'}).format(date)});
document.querySelectorAll('[data-combined-results]').forEach(section=>{
    const table=section.querySelector('[data-combined-table]'),rows=[...table.querySelectorAll('[data-result-row]')],search=section.querySelector('[data-result-search]'),system=section.querySelector('[data-result-system]'),category=section.querySelector('[data-result-category]'),architecture=section.querySelector('[data-result-architecture]'),count=section.querySelector('[data-results-count]');
    const applyFilters=()=>{const query=search.value.trim().toLowerCase();let shown=0;rows.forEach(row=>{const visible=(!query||row.dataset.filter.includes(query))&&(!system.value||row.dataset.system===system.value)&&(!category.value||row.dataset.category===category.value)&&(!architecture.value||row.dataset.architecture===architecture.value);row.hidden=!visible;if(visible)shown++});count.textContent=shown+(shown===1?' result':' results')+(shown===rows.length?'':' of '+rows.length)};
    search.addEventListener('input',applyFilters);[system,category,architecture].forEach(control=>control.addEventListener('change',applyFilters));
    section.querySelector('[data-reset-results]').addEventListener('click',()=>{search.value='';system.value='';category.value='';architecture.value='';applyFilters();search.focus()});
    table.querySelectorAll('thead button[data-sort-type]').forEach((button,index)=>button.addEventListener('click',()=>{const type=button.dataset.sortType,previous=button.dataset.sortDirection,direction=previous?(previous==='asc'?'desc':'asc'):(type==='number'?'desc':'asc'),factor=direction==='asc'?1:-1;table.querySelectorAll('thead button').forEach(item=>{delete item.dataset.sortDirection;item.closest('th').removeAttribute('aria-sort')});button.dataset.sortDirection=direction;button.closest('th').setAttribute('aria-sort',direction==='asc'?'ascending':'descending');rows.sort((left,right)=>{const leftRaw=left.cells[index].dataset.sort||'',rightRaw=right.cells[index].dataset.sort||'';if(leftRaw===''&&rightRaw==='')return 0;if(leftRaw==='')return 1;if(rightRaw==='')return-1;const comparison=type==='number'?Number(leftRaw)-Number(rightRaw):leftRaw.localeCompare(rightRaw,undefined,{numeric:true,sensitivity:'base'});return comparison*factor});const body=table.tBodies[0];rows.forEach(row=>body.appendChild(row));applyFilters()}));
    applyFilters();
});
</script>
</body>
</html>
HTML;
        $this->write($archiveRoot . '/index.html', $html);
    }

    /**
     * @param array<string, array{id:string, recordedAt:string, recordedAtDisplay:string, targets:int, path:string}> $runs
     */
    private static function combinedResultsSection(array $runs, string $dateKey): string
    {
        $rows = [];
        $categories = [];
        $architectures = [];
        foreach (self::RUNTIME_PROFILES as $profile => $metadata) {
            $entry = $runs[$profile] ?? null;
            if ($entry === null) {
                continue;
            }
            try {
                $payload = self::readPayloadFile($entry['path'] . '/results.json');
            } catch (RuntimeException) {
                continue;
            }
            $versions = is_array($payload['versions'] ?? null) ? $payload['versions'] : [];
            $categoryMap = is_array($payload['categories'] ?? null) ? $payload['categories'] : [];
            $architectureMap = is_array($payload['architectures'] ?? null) ? $payload['architectures'] : [];
            foreach (self::results($payload) as $target => $result) {
                if (!is_string($target) || !is_array($result)) {
                    continue;
                }
                $category = is_string($categoryMap[$target] ?? null) ? $categoryMap[$target] : 'unknown';
                $architecture = is_string($architectureMap[$target] ?? null)
                    ? $architectureMap[$target]
                    : 'unknown';
                $categoryLabel = match ($category) {
                    'full-stack' => 'Full Stack',
                    'micro' => 'Micro',
                    'route-only' => 'Route only',
                    'baseline' => 'Baseline',
                    default => 'Unclassified',
                };
                $architectureLabel = match ($architecture) {
                    'mvc-hmvc' => 'MVC/HMVC',
                    'component-based' => 'Component-based',
                    'baseline' => 'Baseline',
                    default => 'Unclassified',
                };
                $categories[$category] = $categoryLabel;
                $architectures[$architecture] = $architectureLabel;
                $stableRpm = self::numeric($result['stable']['req_per_min'] ?? null);
                $peakRpm = self::numeric($result['peak']['req_per_min'] ?? null);
                $rank = self::numeric($result['rank'] ?? null);
                $peakConcurrency = self::numeric($result['peak']['concurrency'] ?? null);
                $p50 = self::milliseconds($result['multiple']['p50'] ?? null);
                $p99 = self::milliseconds($result['multiple']['p99'] ?? null);
                $memory = self::numeric($result['remoteMemoryMB'] ?? null);
                $serverMs = self::remoteMetric($result, 'server_execution_ms');
                $files = self::remoteMetric($result, 'included_files');
                $rankingStatus = is_string($result['rankingStatus'] ?? null)
                    ? ucfirst(str_replace('-', ' ', $result['rankingStatus']))
                    : 'Unavailable';
                $failedRequests = self::numeric($result['multiple']['failed_requests'] ?? null) ?? 0.0;
                $errorRate = self::percent($result['multiple']['error_rate'] ?? null) ?? 0.0;
                $version = is_string($versions[$target] ?? null) ? trim($versions[$target]) : '';
                $rows[] = [
                    'target' => $target,
                    'version' => $version,
                    'profile' => $profile,
                    'system' => $metadata['title'],
                    'href' => $profile . '/' . $entry['id'] . '/dashboard.html',
                    'category' => $category,
                    'categoryLabel' => $categoryLabel,
                    'architecture' => $architecture,
                    'architectureLabel' => $architectureLabel,
                    'rank' => $rank,
                    'stableRpm' => $stableRpm,
                    'peakRpm' => $peakRpm,
                    'peakConcurrency' => $peakConcurrency,
                    'p50' => $p50,
                    'p99' => $p99,
                    'memory' => $memory,
                    'serverMs' => $serverMs,
                    'files' => $files,
                    'diagnostic' => sprintf(
                        'Status: %s · Failed requests: %s · Error rate: %.3f%%',
                        $rankingStatus,
                        number_format($failedRequests, 0, '.', ','),
                        $errorRate,
                    ),
                ];
            }
        }
        usort($rows, static function (array $left, array $right): int {
            $leftRpm = $left['stableRpm'] ?? -INF;
            $rightRpm = $right['stableRpm'] ?? -INF;
            $byRpm = $rightRpm <=> $leftRpm;
            return $byRpm !== 0
                ? $byRpm
                : strcmp($left['target'] . $left['profile'], $right['target'] . $right['profile']);
        });

        $body = '';
        foreach ($rows as $row) {
            $target = self::escape($row['target']);
            $version = $row['version'] === ''
                ? ''
                : '<span class="result-version">' . self::escape($row['version']) . '</span>';
            $filter = self::escape(strtolower(implode(' ', [
                $row['target'],
                $row['version'],
                $row['system'],
                $row['categoryLabel'],
                $row['architectureLabel'],
            ])));
            $body .= '<tr data-result-row data-filter="' . $filter . '" data-system="'
                . self::escape($row['profile']) . '" data-category="' . self::escape($row['category'])
                . '" data-architecture="' . self::escape($row['architecture']) . '" title="'
                . self::escape($row['diagnostic']) . '">'
                . '<td data-sort="' . self::escape(strtolower($row['target'])) . '"><span class="result-target"><strong>'
                . $target . '</strong>' . $version . '</span><span class="result-traits"><span>'
                . self::escape($row['categoryLabel']) . '</span><span>' . self::escape($row['architectureLabel'])
                . '</span></span></td>'
                . '<td data-sort="' . self::escape(strtolower($row['system'])) . '"><a class="system-link" href="'
                . self::escape($row['href']) . '">' . self::escape($row['system']) . '</a></td>'
                . self::combinedNumericCell($row['rank'], 0)
                . self::combinedNumericCell($row['stableRpm'], 0)
                . self::combinedNumericCell($row['peakRpm'], 0)
                . self::combinedNumericCell($row['peakConcurrency'], 0)
                . self::combinedNumericCell($row['p50'], 2)
                . self::combinedNumericCell($row['p99'], 2)
                . self::combinedNumericCell($row['memory'], 2)
                . self::combinedNumericCell($row['serverMs'], 2)
                . self::combinedNumericCell($row['files'], 0)
                . '</tr>';
        }
        if ($body === '') {
            $body = '<tr><td colspan="11" class="empty-table">No combined result data is available for this date.</td></tr>';
        }

        $systemOptions = '';
        foreach (self::RUNTIME_PROFILES as $profile => $metadata) {
            if (isset($runs[$profile])) {
                $systemOptions .= '<option value="' . self::escape($profile) . '">'
                    . self::escape($metadata['title']) . '</option>';
            }
        }
        $categoryOptions = self::combinedFilterOptions($categories);
        $architectureOptions = self::combinedFilterOptions($architectures);
        $sectionId = 'results-' . (preg_replace('/[^a-zA-Z0-9_-]/', '-', $dateKey) ?? $dateKey);

        return '<section class="combined-results" data-combined-results id="' . self::escape($sectionId) . '">'
            . '<div class="combined-heading"><div><h2>Framework results</h2>'
            . '<p>All runtime results for this date. Overall rank is calculated within each runtime.</p></div>'
            . '<span data-results-count>' . count($rows) . ' results</span></div>'
            . '<div class="result-filters">'
            . '<label class="result-search"><span>Framework</span><input type="search" data-result-search placeholder="Search frameworks…"></label>'
            . '<label><span>System</span><select data-result-system><option value="">All systems</option>' . $systemOptions . '</select></label>'
            . '<label><span>Type</span><select data-result-category><option value="">All types</option>' . $categoryOptions . '</select></label>'
            . '<label><span>Architecture</span><select data-result-architecture><option value="">All architectures</option>' . $architectureOptions . '</select></label>'
            . '<button type="button" class="reset-filters" data-reset-results>Clear</button></div>'
            . '<div class="combined-table-wrap"><table class="combined-table" data-combined-table><thead><tr>'
            . self::combinedHeader('Target', 'string') . self::combinedHeader('System', 'string')
            . self::combinedHeader('Overall rank', 'number') . self::combinedHeader('Stable RPM', 'number')
            . self::combinedHeader('Peak RPM', 'number') . self::combinedHeader('Peak c', 'number')
            . self::combinedHeader('p50 ms', 'number') . self::combinedHeader('p99 ms', 'number')
            . self::combinedHeader('Memory MB', 'number') . self::combinedHeader('Server ms', 'number')
            . self::combinedHeader('Files', 'number')
            . '</tr></thead><tbody>' . $body . '</tbody></table></div></section>';
    }

    /** @param array<string, string> $options */
    private static function combinedFilterOptions(array $options): string
    {
        asort($options, SORT_NATURAL | SORT_FLAG_CASE);
        $html = '';
        foreach ($options as $value => $label) {
            $html .= '<option value="' . self::escape($value) . '">' . self::escape($label) . '</option>';
        }
        return $html;
    }

    private static function combinedHeader(string $label, string $type): string
    {
        return '<th><button type="button" data-sort-type="' . self::escape($type) . '">'
            . self::escape($label) . '</button></th>';
    }

    private static function combinedNumericCell(mixed $value, int $decimals): string
    {
        $numeric = self::numeric($value);
        if ($numeric === null) {
            return '<td data-sort="">—</td>';
        }
        return '<td data-sort="' . self::escape((string) $numeric) . '">'
            . number_format($numeric, $decimals, '.', ',') . '</td>';
    }

    private static function numeric(mixed $value): ?float
    {
        return is_int($value) || is_float($value) ? (float) $value : null;
    }

    private function runtimeProfile(): ?string
    {
        $profile = basename(rtrim($this->root, '/'));
        return array_key_exists($profile, self::RUNTIME_PROFILES) ? $profile : null;
    }

    private function dashboardArchiveUrl(): string
    {
        return $this->runtimeProfile() === null ? '../' : '../../';
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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
