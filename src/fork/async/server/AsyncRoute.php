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
    public static function post(string $url, string $controller_method)
    {
        self::get($url, $controller_method);
    }

    /**
     * @param array $route
     * @param string|null $prefix
     */
    public static function group(array $route, ?string $prefix = NULL)
    {
        parent::group($route, $prefix);
    }
}