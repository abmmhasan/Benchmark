<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$bootstrap = new App\Bootstrap;
$container = $bootstrap->bootWebApplication();
$application = $container->getByType(Nette\Application\Application::class);
$application->run();

/* *** PHP-Frameworks-Bench *** */
require dirname(__DIR__, 3) . '/libs/output_data.php';
