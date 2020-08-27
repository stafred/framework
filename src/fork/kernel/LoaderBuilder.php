<?php
namespace Stafred\Kernel;

/**
 * Class Loader
 * @package Stafred\Kernel
 */
final class LoaderBuilder
{
    /**
     * Loader constructor.
     */
    public function __construct()
    {
        (new ClassLoader())->mount();
    }
}