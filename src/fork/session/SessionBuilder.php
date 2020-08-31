<?php
namespace Stafred\Session;

use Stafred\Cache\CacheManager;
use Stafred\Cookie\CookieHelper;

/**
 * Class SessionBuilder
 * @package Stafred\Session
 */
final class SessionBuilder extends SessionHelper
{
    /**
     * SessionBuilder constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $cookie = $this->cookie();

        if(!$cookie->isset()) {
            $this->create();
        }
        else {
            $this->read();
        }
    }
}