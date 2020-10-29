<?php

namespace Stafred\Session;

use Stafred\Cache\Buffer;
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
        $session = Buffer::input()->getAll()->session();
        return $arr ? (array) $session : (object) $session;
    }

    /**
     * @param string $key
     * @return false|mixed
     */
    public function getValue(string $key)
    {
        $all = $this->getAll(true);
        if(array_key_exists($key,$all)){
            return $all[$key];
        }
        return false;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setValue(string $key, $value)
    {
        Buffer::output()->session($key,$value);
    }
}