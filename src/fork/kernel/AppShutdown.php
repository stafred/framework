<?php

namespace Stafred\Kernel;

/**
 * Class Shutdown
 * @package Stafred\Kernel
 */
final class AppShutdown
{
    /**
     * Shutdown constructor.
     */
    public function __construct()
    {
        foreach (ClassList::SLAVE as $class){
            new $class();
        }
    }
}