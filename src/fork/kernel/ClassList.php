<?php
namespace Stafred\Kernel;

/**
 * Class ClassList
 * @package Stafred\Kernel
 */
class ClassList
{
    /**
     * configuration loader of primary classes
     * ---------------------------------------
     * if you need to add to the initial load,
     * then specify the required class here
     * ---------------------------------------
     * Classes Builders
     */
    const PRIMARY = [
        \Stafred\Header\HeaderBuilder::class,
        \Stafred\Session\SessionBuilder::class,
        \Stafred\Security\SecurityBuilder::class,
        \Stafred\Database\ConnectionBuilder::class,
        \Stafred\Routing\RouteBuilder::class,
    ];
}