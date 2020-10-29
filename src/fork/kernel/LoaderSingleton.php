<?php

namespace Stafred\Kernel;

/**
 * Class LoaderSingleton
 * @package Stafred\Kernel
 */
final class LoaderSingleton
{
    /**
     * @var bool
     */
    private static $mount = false;

    /**
     * @param bool $mount
     */
    public static function setMount(): void
    {
        self::$mount = true;
    }

    /**
     * @return bool
     */
    public static function isMount(): bool
    {
        return self::$mount;
    }
}