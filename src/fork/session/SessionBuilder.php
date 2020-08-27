<?php
namespace Stafred\Session;

use Stafred\Cache\CacheManager;

/**
 * Class SessionBuilder
 * @package Stafred\Session
 */
final class SessionBuilder extends SessionHelper
{
    /**
     * SessionBuilder constructor.
     */
    public function __construct()
    {
        if(empty($this->getName())){
            $this->setName();
        }

        if($this->missing()){
            $this->create();
        } else {
            $this->read();
        }

        $this->setHash();
    }

    private function setHash()
    {
        CacheManager::setHashSessionStorage();
    }
}