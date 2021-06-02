<?php

namespace Stafred\Utils;

use App\Models\kernel\Debug;

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
     * merge without keys
     * @param mixed ...$value
     * @return array
     */
    public static function merge(...$value)
    {
        return self::toOne($value, false);
    }

    /**
     * merge within keys
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
     * @param bool $reverse
     * @return array
     */
    public static function receive(array $keys, array $values, bool $reverse = false): array
    {
        if ($reverse) {
            $keys = array_flip($keys);
        }

        $original = [];
        foreach ($keys as $key) {
            $original[$key] = NULL;
        }
        return array_intersect_key($values, $original);
    }


    /**
     * @param array $keys
     * @param array $values
     */
    public static function intersect(array $keys, array $values): array
    {
        return array_intersect_key($values, $keys);
    }


    /**
     * @param array $values
     * @return array
     */
    public static function flip(array $values): array
    {
        return array_flip($values);
    }

    /**
     * @param array $keys
     * @param array $values
     * @return bool
     */
    public static function existsKeys(array $keys, array $values): bool
    {
        return empty(self::missingKeys($keys, $values));
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
     * @param bool $reset_keys
     * @return array
     */
    public static function cutValue(array $value, array $array, bool $reset_keys = false)
    {
        $arr = array_diff($array, $value);
        return $reset_keys ? array_values($arr) : $arr;
    }

    /**
     * @param array $keys
     * @param array $array
     * @return array
     */
    public static function cutKeys(array $keys, array $array)
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * @param array $value
     * @return array
     */
    public static function removeEmpty(array $value)
    {
        return array_filter($value);
    }

    /**
     * @param array $unique
     */
    public static function unique(array $value)
    {
        return array_unique($value);
    }

    /**
     * @param $key
     * @param array $search
     * @return bool
     */
    public static function isKey($key, array $search): bool
    {
        return array_key_exists($key, $search);
    }

    /**
     * @param $value
     * @param array $search
     * @return bool
     */
    public static function isValue($value, array $search): bool
    {
        return in_array($value, $search);
    }

    /**
     * @param array $array
     */
    public static function isEmpty(array $array): bool
    {
        return empty($array);
    }

    /**
     * @param mixed ...$values
     * @return bool
     */
    public static function isValuesEmpty(...$values): bool
    {
        $arr = self::toOne($values);
        $result = true;
        foreach ($arr as $val) {
            $result = empty($val);
            if ($result === false) break;
        }
        return $result;
    }

    /**
     * может удалить существующие ключи
     * если ключи совпадают, то массив попадает последний
     * @param array $current
     * @param array $change
     * @return array
     */
    public static function renameKeys(array $current, array $change): array
    {
        $arr = [];
        array_walk($current, function ($v, $k) use (&$arr, $change) {
            /*возможна ошибка при получении пустого значения и ключа перевертыша*/
            if($change[$k] != NULL) $arr[$change[$k]] = $v;
            else $arr[$k] = $v;
        });
        return $arr;
    }

    /**
     * @param $items
     * @return array
     */
    public static function removeNumericKeys($items)
    {
        $result = [];
        foreach ($items as $key => $value){
            if(is_string($key)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}