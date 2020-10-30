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
     * @return false|string
     */
    public static function encode(array $value)
    {
        return json_encode($value);
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