<?php

declare(strict_types=1);

namespace AbmmHasan\Benchmark;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;

use function Termwind\render;
use function Termwind\renderUsing;

/** Renders benchmark progress exclusively to STDERR. */
final class BenchmarkConsole
{
    private readonly StreamOutput $output;
    private readonly bool $interactive;
    /** @var list<ConsoleSectionOutput> */
    private array $sectionStack = [];
    /** @var array<string, ConsoleSectionOutput> */
    private array $sections = [];
    private ?string $target = null;

    public function __construct()
    {
        $this->interactive = function_exists('stream_isatty') && stream_isatty(STDERR);
        $this->output = new StreamOutput(
            STDERR,
            OutputInterface::VERBOSITY_NORMAL,
            $this->interactive,
        );
        renderUsing($this->output);
    }

    public function startSuite(int $targets, int $repetitions): void
    {
        render(sprintf(
            '<div class="mb-1"><span class="px-1 bg-cyan-600 text-white font-bold">HTTP BENCHMARK</span>'
            . '<span class="ml-1 text-gray">%d targets · %d repetitions</span></div>',
            $targets,
            $repetitions,
        ));
    }

    public function validating(string $target, int $position, int $total): void
    {
        if ($this->interactive) {
            $this->output->write(sprintf(
                "\r\033[2K<fg=yellow>validating</> %d/%d %s",
                $position,
                $total,
                self::consoleText($target),
            ));
        }
    }

    public function validated(int $targets, int $skipped): void
    {
        if ($this->interactive) {
            $this->output->write("\r\033[2K");
        }
        $skipSummary = $skipped > 0 ? sprintf(' · %d explicitly skipped', $skipped) : '';
        render(sprintf(
            '<div class="mb-1"><span class="text-green font-bold">✓</span>'
            . '<span class="ml-1">%d targets validated before measurement%s</span></div>',
            $targets,
            $skipSummary,
        ));
    }

    public function validationFailed(string $target, string $message): void
    {
        if ($this->interactive) {
            $this->output->write("\r\033[2K");
        }
        render(sprintf(
            '<div><span class="text-red font-bold">✗ %s</span>'
            . '<span class="ml-1 text-gray">%s</span></div>',
            self::html($target),
            self::html($message),
        ));
    }

    public function startTarget(string $target): void
    {
        $this->target = $target;
        if (!$this->interactive) {
            return;
        }

        if (isset($this->sections[$target])) {
            return;
        }

        $section = new ConsoleSectionOutput(
            STDERR,
            $this->sectionStack,
            $this->output->getVerbosity(),
            true,
            $this->output->getFormatter(),
        );
        $this->sections[$target] = $section;
        $section->writeln(self::progressLine($target, 0.0, 'preparing'));
    }

    public function updateTarget(float $fraction, string $message): void
    {
        if (!$this->interactive || $this->target === null || !isset($this->sections[$this->target])) {
            return;
        }

        $this->sections[$this->target]->overwrite(self::progressLine($this->target, $fraction, $message));
    }

    public function finishTarget(
        float $rpm,
        int $concurrency,
        float $duration,
        float $errorRate,
        string $stability,
    ): void
    {
        $summary = sprintf(
            'done · %.0f RPM · c=%d · %.1fs · errors %.2f%% · %s',
            $rpm,
            $concurrency,
            $duration,
            $errorRate * 100,
            $stability,
        );

        if ($this->interactive && $this->target !== null && isset($this->sections[$this->target])) {
            $this->sections[$this->target]->overwrite(
                self::progressLine($this->target, 1.0, "<fg=green>{$summary}</>"),
            );
        } else {
            $this->output->writeln(sprintf(
                ' ✓ %-18s %s',
                self::truncate(self::safeText((string) $this->target), 18),
                $summary,
            ));
        }

        unset($this->sections[(string) $this->target]);
        $this->target = null;
    }

    public function failTarget(string $message): void
    {
        $message = 'failed · ' . self::truncate(self::safeText($message), 70);
        if ($this->interactive && $this->target !== null && isset($this->sections[$this->target])) {
            $this->sections[$this->target]->overwrite(
                self::progressLine(
                    $this->target,
                    0.0,
                    '<fg=red>' . self::consoleText($message) . '</>',
                ),
            );
        } else {
            $this->output->writeln(sprintf(
                ' ✗ %-18s %s',
                self::truncate(self::safeText((string) $this->target), 18),
                $message,
            ));
        }

        unset($this->sections[(string) $this->target]);
        $this->target = null;
    }

    public function finishSuite(int $targets, float $duration): void
    {
        render(sprintf(
            '<div class="mt-1"><span class="px-1 bg-green-600 text-white font-bold">COMPLETE</span>'
            . '<span class="ml-1">%d targets · %.1f seconds</span></div>',
            $targets,
            $duration,
        ));
    }

    private static function safeText(string $text): string
    {
        return preg_replace('/[\x00-\x1F\x7F]/u', ' ', $text) ?? '';
    }

    private static function progressLine(string $target, float $fraction, string $message): string
    {
        $fraction = max(0.0, min(1.0, $fraction));
        $complete = (int) floor($fraction * 28);
        $bar = str_repeat('━', $complete);
        $empty = str_repeat('─', 28 - $complete);
        $label = str_pad(self::truncate(self::consoleText($target), 18), 18);

        return sprintf(
            ' <fg=white>%s</> [<fg=cyan>%s</><fg=gray>%s</>] %3d%% <fg=gray>%s</>',
            $label,
            $bar,
            $empty,
            (int) round($fraction * 100),
            str_starts_with($message, '<fg=')
                ? $message
                : self::consoleText(self::truncate($message, 54)),
        );
    }

    private static function consoleText(string $text): string
    {
        return OutputFormatter::escape(self::safeText($text));
    }

    private static function truncate(string $text, int $length): string
    {
        return mb_strimwidth($text, 0, $length, '…');
    }

    private static function html(string $text): string
    {
        return htmlspecialchars(self::safeText($text), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
