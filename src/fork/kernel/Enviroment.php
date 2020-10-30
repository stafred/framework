<?php

namespace Stafred\Kernel;

use Stafred\Utils\Str;

/**
 * Class Enviroment
 * @package Stafred\Kernel
 */
abstract class Enviroment
{
    /**
     * @var string
     */
    protected static $name = '.env';
    /**
     * @var array
     */
    protected static $exec = false;

    public static function get()
    {
        if (self::$exec) return;

        if(file_exists("../".self::$name))
        {
            self::$name = "../".self::$name;
        }

        $env = parse_ini_file(
            self::$name, true, 2
        );

        foreach ($env as $k => $v) {
            foreach ($v as $key => $value) {
                $key = Str::upper(
                    Str::replace("/[\.\-]+/", "_", $k . "_" . $key)
                );
                define($key, $value);
            }
        }
        self::$exec = true;
    }
    
    /**
     * @param $key
     * @return mixed
     */
    abstract public static function value(string $key);
}