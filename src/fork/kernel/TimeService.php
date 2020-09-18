<?php


namespace Stafred\Kernel;

use Stafred\Cache\CacheManager;

/**
 * Class TimeService
 * @package Stafred\Kernel
 */
final class TimeService
{
    /**
     * @var string
     */
    private static $class = '';

    /**
     * @param string $class
     */
    public static function start(string $class): void
    {
        CacheManager::setCacheTimeStart($class);
    }

    /**
     * @param string $class
     */
    public static function finish(string $class): void
    {
        CacheManager::setCacheTimeFinish($class);
    }

    public static function get()
    {
        debug(CacheManager::getCacheTimeService());
    }
}