<?php

namespace Stafred\Routing;

use Stafred\Cache\Buffer;
use Stafred\Utils\Hash;

/**
 * Class RouteDecorator
 * @package Stafred\Routing
 */
class RouteDecorator
{
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