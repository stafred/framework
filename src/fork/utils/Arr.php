<?php

namespace Stafred\Utils;

/**
 * Class Arr
 * @package Stafred\Utils
 */
final class Arr
{
    /**
     * @param array $arr
     * @return bool
     */
    public static function isOne(array $arr): bool
    {
        return (count($arr, COUNT_RECURSIVE) - count($arr)) === 0;
    }

    /**
     * @param array $arr
     * @return bool
     */
    public static function isMulti(array $arr): bool
    {
        return (count($arr, COUNT_RECURSIVE) - count($arr)) > 0;
    }

    /**
     * @param array $arr
     * @param bool $use_key
     * @return array
     */
    public static function toOne(array $arr, bool $use_key = false): array
    {
        return iterator_to_array(
            new \RecursiveIteratorIterator(new \RecursiveArrayIterator($arr)),
            $use_key
        );
    }

    /**
     * @param mixed ...$value
     * @return array
     */
    public static function merge(...$value)
    {
        return self::toOne($value, false);
    }

    /**
     * @param mixed ...$value
     * @return array
     */
    public static function combine(...$value)
    {
        return self::toOne($value, true);
    }

    /**
     * @param array $value
     * @return string
     */
    public static function hash(array $value): string
    {
        return md5(json_encode($value));
    }
}