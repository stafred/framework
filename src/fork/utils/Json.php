<?php

namespace Stafred\Utils;

/**
 * Class Json
 * @package Stafred\Utils
 */
final class Json
{
    /**
     * @param array $value
     * @param bool $unicode
     * @return false|string
     */
    public static function encode(array $value, bool $unicode = true)
    {
        return json_encode($value, $unicode == true ? JSON_UNESCAPED_UNICODE : 0);
    }

    /**
     * @param string $value
     * @param bool $array
     * @return mixed
     */
    public static function decode(string $value, bool $array = false)
    {
        return json_decode($value, $array);
    }
}