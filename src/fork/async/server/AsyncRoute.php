<?php

namespace Stafred\Async\Server;

use Stafred\Routing\RouteRegistry;

/**
 * Class AsyncRoute
 * @package Stafred\Async\Server
 */
final class AsyncRoute extends RouteRegistry
{
    /**
     * @param string $url
     * @param string $controller_method
     */
    public static function post(string $url, string $controller_method): void
    {
        self::get($url, $controller_method);
    }

    /**
     * @param array $route
     */
    public static function group(array $route): void
    {
        parent::group($route);
    }
}