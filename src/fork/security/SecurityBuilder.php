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
        TimeService::start(__CLASS__);

        parent::__construct();
        $this->run();

        TimeService::finish(__CLASS__);
    }

    private function run()
    {
        foreach ($this->methods as $method) {
            $this->{$method}();
        }
    }

}