<?php

namespace Stafred\Security;


use Stafred\Kernel\TimeService;

/**
 * Class SecurityBuilder
 * @package Stafred\Security
 */
class SecurityBuilder extends SecurityHelper
{
    /**
     * SecurityBuilder constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    private function run()
    {
        foreach ($this->methods as $method) {
            $this->{$method}();
        }
    }
}