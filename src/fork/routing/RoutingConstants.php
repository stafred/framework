<?php

namespace Stafred\Routing;

/**
 * Class RoutingConstants
 * @package Stafred\Routing
 */
class RoutingConstants
{
    const URL_PATTERN       = '/^[^\\?\\#]+/i';
    const LOCATION_PATTERN  = '/^[^\\?\\#]+/i';
    const REQUEST_PATTERN   = '/\/([^\/]+)|\//i';
}