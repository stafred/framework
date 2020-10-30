<?php

namespace Stafred\Routing;

use Stafred\Utils\Arr;
use Stafred\Utils\Str;

/**
 * Class RoutePrototype
 * @package Stafred\Routing
 */
abstract class RouteRegistry extends RouteDecorator
{
    /**
     * @param String $url
     * @param String $controller_method
     */
    public static function get(String $url, String $controller_method): void
    {
        self::register(__FUNCTION__, $url, $controller_method);
    }

    /**
     * @param String $url
     * @param String $controller_method
     */
    public static function post(String $url, String $controller_method): void
    {
        self::register(__FUNCTION__, $url, $controller_method);
    }

    /**
     * <pre style="color:#ff8800">
     * Expample:
     * "get" => [
     *     'uri' => 'Controller::Method',
     * ],
     * "post" => [
     *     'uri' => 'Controller::Method',
     * ],
     * </pre>
     * @param array $route
     */
    public static function group(array $route): void
    {
        foreach ($route as $method => $action)
        {
            foreach ($action as $uri => $controller_method)
            {
                self::register(Str::lower($method), $uri, $controller_method);
            }
        }
    }
}