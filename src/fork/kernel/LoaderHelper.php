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
     * @param bool $primary
     */
    public static function setPrimary(): void
    {
        self::$primary = true;
    }

    /**
     * @return bool
     */
    public static function isPrimary(): bool
    {
        return self::$primary;
    }
}