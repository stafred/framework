<?php

namespace Stafred\Controller;

use Stafred\Kernel\TimeService;

/**
 * Class ControllerWrapper
 * @package Stafred\Controller
 */
final class ControllerWrapper extends ControllerPrototype
{
    /**
     * ControllerWrapper constructor.
     */
    public function __construct()
    {
        TimeService::start(__CLASS__);

        parent::__construct(new ControllerMapper());
        parent::start();
    }

    public function __destruct()
    {
        TimeService::finish(__CLASS__);
    }
}