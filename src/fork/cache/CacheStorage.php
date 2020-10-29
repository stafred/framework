<?php

namespace Stafred\Cache;

use Stafred\Utils\Arr;

final class CacheStorage extends CacheFields
{
    /**
     * @param string $cache
     * @param string $key
     * @return mixed
     */
    public static function get(string $cache, string $key)
    {
        return self::${$cache}[$key];
    }

    /**
     * @param string $cache
     * @param string $key
     * @param $value
     */
    public static function put(string $cache, string $key, $value): void
    {
        self::${$cache}[$key] = $value;
    }

    /**
     * @param string|null $name
     * @return array
     */
    public static function getAll(string $name = NULL): array
    {
        return empty($name) || !isset(self::${$name})
            ? get_class_vars(__CLASS__)
            : self::${$name};
    }

    /**
     * @param string $cache
     * @param array $value
     */
    public static function putAll(string $cache, array $value) {
        self::${$cache} = $value;
    }

    /**
     * @param string $cache
     * @param string $key
     * @return bool
     */
    public static function isKey(string $cache, string $key)
    {
        return isset(self::${$cache}[$key]);
    }
}