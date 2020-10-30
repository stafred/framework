<?php
namespace Stafred\Kernel;

use Stafred\Kernel\TimeService;

/**
 * Class Loader
 * @package Stafred\Kernel
 */
final class LoaderBuilder
{
    /**
     * Loader constructor.
     */
    public function __construct(bool $async = false)
    {
        TimeService::start(__CLASS__);
        (new ClassLoader())->mount($async);
    }

    public function __destruct()
    {
        TimeService::finish(__CLASS__);
    }
}