<?php

namespace Stafred\Session;

use Stafred\Cache\CacheManager;

/**
 * Class SessionDecorator
 * @package Stafred\Session
 */
class SessionDecorator
{
    /**
     * @param bool $arr
     * @return array|object
     */
    public function getAll(bool $arr)
    {
        $session = CacheManager::getAllSessionStorage();
        return $arr ? (array) $session : (object) $session;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getValue(string $key)
    {
        return $this->getAll(true)[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setValue(string $key, $value)
    {
        CacheManager::setSharedSessionStorage($key,$value);
    }
}