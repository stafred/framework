<?php

namespace Stafred\Routing;

use Stafred\Kernel\TimeService;

/**
 * Class RouteObserver
 * @package Stafred\Routing
 */
final class RouteObserver
{
    /**
     * RouteObserver constructor.
     */
    public function __construct()
    {
        TimeService::start(__CLASS__);
    }

    public function __destruct()
    {
        TimeService::finish(__CLASS__);
    }
}