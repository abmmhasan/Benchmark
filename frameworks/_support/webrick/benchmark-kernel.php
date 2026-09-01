<?php

declare(strict_types=1);

use Infocyph\InterMix\DI\ContainerBuilder;
use Infocyph\Webrick\Router\Kernel\CompiledRouterKernel;
use Infocyph\Webrick\Router\Matching\FusedMatcher;
use Infocyph\Webrick\Router\Matching\GeneratedMatcher;
use Infocyph\Webrick\Router\Matching\MatcherInterface;
use Infocyph\Webrick\Router\Matching\ShardedMatcher;
use Psr\Log\NullLogger;

function benchmarkWebrickKernel(string $assetDirectory): CompiledRouterKernel
{
    require_once $assetDirectory . '/benchmark-handler.php';

    $releasePath = $assetDirectory . '/.benchmark-release/release.json';
    $release = json_decode(
        (string) file_get_contents($releasePath),
        true,
        512,
        JSON_THROW_ON_ERROR,
    );
    if (!is_array($release)) {
        throw new RuntimeException('Invalid Webrick benchmark release manifest.');
    }

    $builder = ContainerBuilder::create('benchmark.webrick')->setEnvironment('production');
    $container = $builder->productionPrevalidated(
        (string) $release['intermix']['path'],
        (string) $release['intermix']['sha256'],
    );

    return CompiledRouterKernel::fromPrevalidatedArtifact(
        log: new NullLogger(),
        matcher: benchmarkWebrickMatcher($assetDirectory),
        container: $container,
        artifactPath: (string) $release['webrick']['path'],
        trustedSha256: (string) $release['webrick']['sha256'],
        environment: (string) $release['environment'],
        configFingerprint: (string) $release['config_fingerprint'],
    );
}

function benchmarkWebrickMatcher(string $assetDirectory): MatcherInterface
{
    $matcherMode = require $assetDirectory . '/matcher.php';

    return match ($matcherMode) {
        'fused' => FusedMatcher::make()->enableCache($assetDirectory . '/.route-cache/fused.php'),
        'generated' => GeneratedMatcher::make()->enableCache($assetDirectory . '/.route-cache/generated.php'),
        'sharded' => ShardedMatcher::make()->enableCache($assetDirectory . '/.route-cache'),
        default => throw new RuntimeException('Unsupported Webrick benchmark matcher.'),
    };
}
