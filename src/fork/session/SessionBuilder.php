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
        TimeService::start(__CLASS__);

        $cookie = $this->cookie();

        if($cookie->missing()) {
            $this->create();
            return;
        }

        $this->read();

        if($this->missing()) {
            $cookie->remove();
            $this->reloadPage();
            return;
        }

        $this->get();

        if($this->failed()) {
            $this->remove();
            $this->reloadPage();
            return;
        }
        else {
            $this->recreate();
        }
    }

    public function __destruct()
    {
        TimeService::finish(__CLASS__);
    }
}