<?php

namespace Stafred\Cache;

/**
 * Class CacheManager
 * @package Stafred\Cache
 */
final class CacheManager extends CacheHelper
{
    private static $cacheTimeService = [];

    /**
     * @return int
     */

    /**
     * @param string $key
     */
    public static function setCacheTimeStart(string $key): void
    {
        self::$cacheTimeService[$key] = microtime(true);
    }

    /**
     * @param string $key
     */
    public static function setCacheTimeFinish(string $key): void
    {
        self::$cacheTimeService[$key] = microtime(true) - self::$cacheTimeService[$key];
    }

    /**
     * @return array
     */
    public static function getCacheTimeService(): array
    {
        return self::$cacheTimeService;
    }
}