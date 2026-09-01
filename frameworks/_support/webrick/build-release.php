<?php

declare(strict_types=1);

use Infocyph\InterMix\DI\ContainerBuilder;
use Infocyph\Webrick\Router\Build\ReleaseCompiler;
use Infocyph\Webrick\Router\Definition\Registrar;

$assetDirectory = __DIR__;
$releaseDirectory = $assetDirectory . '/.benchmark-release';

require $assetDirectory . '/vendor/autoload.php';

if (!is_dir($releaseDirectory) && !mkdir($releaseDirectory, 0775, true) && !is_dir($releaseDirectory)) {
    throw new RuntimeException('Unable to create the Webrick benchmark release directory.');
}

$builder = ContainerBuilder::create('benchmark.webrick')->setEnvironment('production');
$register = static function (Registrar $registrar) use ($assetDirectory): void {
    require $assetDirectory . '/routes.php';
};

(new ReleaseCompiler())->compile(
    builder: $builder,
    register: $register,
    environment: 'production',
    configFingerprint: 'benchmark-routes-v1',
    intermixPath: $releaseDirectory . '/intermix.php',
    routerPath: $releaseDirectory . '/webrick.php',
    releaseManifestPath: $releaseDirectory . '/release.json',
);
