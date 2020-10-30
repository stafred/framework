<?php
namespace Stafred\Session;

use Stafred\Cache\CacheManager;
use Stafred\Cookie\CookieHelper;
use Stafred\Kernel\TimeService;
use Stafred\Utils\Header;
use Stafred\Utils\Http;

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

        if($cookie->missing()) {
            $this->create();
            return;
        }

        $this->read();

        if($this->missing()) {
            $cookie->remove();
            $this->create();
            return;
        }

        $this->get();

        if($this->failed()) {
            $cookie->remove();
            $this->create();
            return;
        }
        else {
            $this->recreate();
        }
    }
}