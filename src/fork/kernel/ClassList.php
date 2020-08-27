<?php

namespace Stafred\Kernel;

/**
 * Class ClassList
 * @package Stafred\Kernel
 */
class ClassList
{
    /**
     * configuration loader of master-classes
     * ---------------------------------------
     * if you need to add to the initial load,
     * then specify the required class here
     * ---------------------------------------
     * Classes Builders
     */
    const MASTER = [
        \Stafred\Header\HeaderBuilder::class,
        \Stafred\Header\CorsBuilder::class,
        \Stafred\Session\SessionBuilder::class,
        \Stafred\Security\SecurityBuilder::class,
        \Stafred\Database\ConnectionBuilder::class,
        \Stafred\Routing\RoutingBuilder::class,
    ];

    const SLAVE = [
        \Stafred\Session\SessionWrapper::class
    ];

    const ADDON = [

    ];
}