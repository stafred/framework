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

    /**
     * @param array $keys
     * @param array $values
     * @return array
     */
    public static function receive(array $keys, array $values): array
    {
        $original = [];
        foreach ($keys as $key) {
            $original[$key] = NULL;
        }
        return array_intersect_key($values, $original);
    }

    /**
     * @param array $keys
     * @param array $values
     * @return bool
     */
    public static function existsKeys(array $keys, array $values): bool
    {
        return empty(self::missingKeys($keys,$values));
    }

    /**
     * @param array $keys
     * @param array $values
     * @return bool
     */
    public static function invalidKeys(array $keys, array $values): bool
    {
        return !self::existsKeys($keys, $values);
    }

    /**
     * only returns the first invalid key
     * @param array $keys
     * @param array $values
     * @return mixed|null
     */
    public static function missingKey(array $keys, array $values)
    {
        foreach ($keys as $key) {
            if (!$values[$key] !== false) {
                return $key;
            }
        }
        return NULL;
    }

    /**
     * returns all missing keys
     * @param array $keys
     * @param array $values
     * @return array
     */
    public static function missingKeys(array $keys, array $values)
    {
        $keys = array_flip(self::toOne($keys, false));
        $missing = array_diff_key($keys, $values);
        return array_flip($missing);
    }

    /**
     * @param array $value
     * @param array $array
     * @return array
     */
    public static function cutValue(array $value, array $array)
    {
        return array_diff($array, $value);
    }
}