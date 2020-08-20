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
}