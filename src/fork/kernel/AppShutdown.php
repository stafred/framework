<?php

namespace Stafred\Kernel;

use App\Models\Kernel\Debug;
use Stafred\Session\SessionBuilder;
use Stafred\Session\SessionHelper;
use Stafred\Session\SessionWrapper;

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