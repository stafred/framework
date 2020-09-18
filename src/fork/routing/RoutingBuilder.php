<?php

namespace Stafred\Routing;

use Stafred\Kernel\TimeService;

/**
 * Class RoutingBuilder
 * @package Stafred\Routing
 */
class RoutingBuilder extends RoutingHelper
{
    /**
     * RoutingBuilder constructor.
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