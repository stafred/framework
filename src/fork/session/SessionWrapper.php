<?php

namespace Stafred\Session;

use Stafred\Cache\CacheManager;
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
        $cache = CacheManager::getAllSessionStorage();
        $this->write($cache);
    }
}