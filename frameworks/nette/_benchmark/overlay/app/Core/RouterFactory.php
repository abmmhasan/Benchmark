<?php

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
    use Nette\StaticClass;

    public static function createRouter(): RouteList
    {
        $router = new RouteList;
        $router
            ->withPath('index.php')
            ->addRoute('hello/<value>/index', 'Hello:middle')
            ->addRoute('hello/index/<value>', 'Hello:last')
            ->addRoute('hello/index', 'Hello:default');

        return $router;
    }
}
