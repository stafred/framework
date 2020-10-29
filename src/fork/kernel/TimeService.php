<?php

namespace Stafred\Kernel;

use Stafred\Cache\Buffer;

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
        Buffer::output()->timing($class);
    }

    /**
     * @param string $class
     */
    public static function finish(string $class): void
    {
        Buffer::output()->timing($class, false);
    }
}