<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class BenchmarkTelemetrySubscriber implements EventSubscriberInterface
{
    private const string START_ATTRIBUTE = '_benchmark_started_at';

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['start', 4096],
            KernelEvents::RESPONSE => ['finish', -4096],
        ];
    }

    public function start(RequestEvent $event): void
    {
        if ($event->isMainRequest()) {
            $event->getRequest()->attributes->set(self::START_ATTRIBUTE, microtime(true));
        }
    }

    public function finish(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $startedAt = $event->getRequest()->attributes->get(self::START_ATTRIBUTE);
        $startedAt = is_float($startedAt) ? $startedAt : microtime(true);
        $telemetry = sprintf(
            "\n%' 8d:%f:%'.03d",
            memory_get_peak_usage(),
            max(0.0, microtime(true) - $startedAt),
            max(0, count(get_included_files()) - 1),
        );
        $response = $event->getResponse();
        $response->setContent((string) $response->getContent() . $telemetry);
    }
}
