<?php

namespace Stafred\Utils;

/**
 * Class Str
 * @package Stafred\Utils
 */
final class Str
{
    const PATTERN_CUT_SYMBOLS = '/[^a-z\d]+/i';

    /**
     * @param string $pattern
     * @param string $value
     * @return string|string[]|null
     */
    public static function cut(string $pattern, string $value)
    {
        return preg_replace($pattern, '', $value);
    }

    /**
     * @param $pattern
     * @param $replace
     * @param $value
     * @return string|string[]|null
     */
    public static function replace($pattern, $replace, $value) {
        return preg_replace($pattern, $replace, $value);
    }

    /**
     * @param $value
     * @return string
     */
    public static function lower($value): string {
        return strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public static function upper($value): string {
        return strtoupper($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function reverseSlash(string $value): string
    {
        return str_replace("\\", "/", $value);
    }

    /**
     * @param $value
     * @return bool
     */
    public static function is($value): bool
    {
        return is_string($value);
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isNumeric(string $value)
    {
        return is_numeric($value);
    }
}