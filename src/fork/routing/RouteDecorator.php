<?php

namespace Stafred\Routing;

use Stafred\Cache\Buffer;
use Stafred\Utils\Hash;

/**
 * Class RouteDecorator
 * @package Stafred\Routing
 */
abstract class RouteDecorator
{
    /**
     * @param String $url
     * @param String $controller_method
     */
    abstract public static function get(String $url, String $controller_method): void;

    /**
     * @param String $url
     * @param String $controller_method
     */
    abstract public static function post(String $url, String $controller_method): void;

    /**
     * @param array $route
     */
    abstract public static function group(array $route): void;

    /**
     * @param String $method
     * @param String $uri
     * @param String $controller_method
     */
    protected static function register(string $method, string $uri, string $controller_method)
    {
        Buffer::output()->routing(Hash::value($method . $controller_method, 'crc32'), [
            'method' => $method,
            'uri' => $uri,
            'controller_method' => $controller_method,
            "args" => [
                "value"=>[],
                "name"=>[]
            ]
        ]);
    }
}