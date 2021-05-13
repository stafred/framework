<?php

namespace Stafred\Routing;

use App\Controllers\Ajax\Axios\AxiosController;
use App\Models\Kernel\Debug;
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
    public static function get(String $url, String $controller_method)
    {
        self::register(__FUNCTION__, $url, $controller_method);
    }

    /**
     * @param String $url
     * @param String $controller_method
     */
    public static function post(String $url, String $controller_method)
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
     * @param string|null $prefix
     */
    public static function group(array $route, ?string $prefix = NULL)
    {
        $prefix = $prefix === NULL ? '' : "/" . $prefix;

        foreach ($route as $method => $action)
        {
            foreach ($action as $uri => $cm_or_arr)
            {
                if(is_array($cm_or_arr)){
                    $controller_method = $cm_or_arr[0] . "::" . $cm_or_arr[1];
                }
                else {
                    $controller_method = $cm_or_arr;
                }
                self::register(Str::lower($method), $prefix . $uri, $controller_method);
            }
        }
    }

    /**
     * @param string $prefix
     * @param array $route
     */
    public static function groupWithPrefix(string $prefix, array $route)
    {
        self::group($route, $prefix);
    }
}