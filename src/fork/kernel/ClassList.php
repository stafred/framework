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
    const KERNEL = [
        \Stafred\Session\SessionBuilder::class,
        \Stafred\Cookie\CookieBuilder::class,
        \Stafred\Header\RequestBuilder::class,
        \Stafred\Header\CorsBuilder::class,
        \Stafred\Security\SecurityBuilder::class,
        \Stafred\Header\HeaderBuilder::class,
        \Stafred\Database\ConnectionBuilder::class,
    ];

    const MASTER = [
        \Stafred\Controller\ControllerWrapper::class,
    ];

    const SLAVE = [
        \Stafred\Session\SessionWrapper::class,
    ];

    const ADDON = [

    ];
}