<?php

namespace Stafred\Session;

use Stafred\Cache\Buffer;
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
        $this->toPack();
    }

    private function toPack(): void
    {
        $cache = Buffer::input()->getAll()->session();

        if(count($cache) > 1) {
            $this->write($cache);
        }
    }
}