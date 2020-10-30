<?php
namespace Stafred\Utils;

use Stafred\Kernel\Enviroment;

/**
 * Class Env
 * @package Stafred\Utils
 */
final class Env extends Enviroment
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public static function value(string $key)
    {
        parent::get();
        return self::$env[$key] ?? NULL ;
    }
}