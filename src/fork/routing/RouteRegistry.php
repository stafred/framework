<?php

namespace Stafred\Routing;

/**
 * Class RoutePrototype
 * @package Stafred\Routing
 */
class RouteRegistry extends RouteDecorator
{
    /**
     * @param String $url
     * @param String $controller_method
     * @throws \Exception
     */
    public static function get(String $url, String $controller_method): void
    {
        self::register(__FUNCTION__, $url, $controller_method);
    }

    /**
     * @param String $url
     * @param String $controller_method
     * @throws \Exception
     */
    public static function post(String $url, String $controller_method): void
    {
        self::register(__FUNCTION__, $url, $controller_method);
    }
}