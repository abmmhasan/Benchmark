<?php

declare(strict_types=1);

use Infocyph\InterMix\DI\ContainerBuilder;
use Infocyph\Webrick\Router\Build\ReleaseManifestLoader;
use Infocyph\Webrick\Router\Kernel\CompiledRouterKernel;
use Infocyph\Webrick\Router\Matching\FusedMatcher;
use Infocyph\Webrick\Router\Matching\GeneratedMatcher;
use Infocyph\Webrick\Router\Matching\MatcherInterface;
use Infocyph\Webrick\Router\Matching\ShardedMatcher;
use Psr\Log\NullLogger;

function benchmarkWebrickKernel(string $assetDirectory): CompiledRouterKernel
{
    require_once $assetDirectory . '/benchmark-handler.php';

    $release = new ReleaseManifestLoader()->load(
        $assetDirectory . '/.benchmark-release/release.json',
    );

    $builder = ContainerBuilder::create('benchmark.webrick')->setEnvironment('production');
    $container = $builder->productionPrevalidated(
        (string) $release['intermix']['path'],
        (string) $release['intermix']['digest'],
    );

    return CompiledRouterKernel::fromPrevalidatedArtifact(
        log: new NullLogger(),
        matcher: benchmarkWebrickMatcher($assetDirectory),
        container: $container,
        artifactPath: (string) $release['webrick']['path'],
        trustedArtifactFingerprint: (string) $release['webrick']['fingerprint'],
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
