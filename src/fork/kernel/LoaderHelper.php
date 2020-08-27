<?php

namespace Stafred\Kernel;

/**
 * Class LoaderHelper
 * @package Stafred\Kernel
 */
final class LoaderHelper
{
    /**
     * @var bool
     */
    private static $primary = false;
    /**
     * @var bool
     */
    private static $slave = false;
    /**
     * @var bool
     */
    private static $others = false;

    
    /**
     * @param bool $primary
     */
    public static function setPrimary(): void
    {
        self::$primary = true;
    }

    /**
     * @param bool $slave
     */
    public static function setSlave(bool $slave): void
    {
        self::$slave = $slave;
    }

    /**
     * @param bool $others
     */
    public static function setOthers(bool $others): void
    {
        self::$others = $others;
    }

    /**
     * @return bool
     */
    public static function isPrimary(): bool
    {
        return self::$primary;
    }

    /**
     * @return bool
     */
    public static function isSlave(): bool
    {
        return self::$slave;
    }

    /**
     * @return bool
     */
    public static function isOthers(): bool
    {
        return self::$others;
    }
}