<?php

namespace Stafred\Session;

use Stafred\Cache\CacheManager;
use Stafred\Kernel\TimeService;
use Stafred\Utils\Arr;

/**
 * Class SessionWrapper
 * @package Stafred\Session
 */
final class SessionWrapper extends SessionHelper
{
    /**
     * SessionWrapper constructor.
     */
    public function __construct()
    {
        TimeService::start(__CLASS__);

        $this->toPack();
    }

    private function toPack(): void
    {
        $cache = CacheManager::getAllSessionStorage();
        if(count($cache) > 1) {
            $this->write($cache);
        }
    }

    public function __destruct()
    {
        TimeService::finish(__CLASS__);
    }
}