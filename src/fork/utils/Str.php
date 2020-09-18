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
}