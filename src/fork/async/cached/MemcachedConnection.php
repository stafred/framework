<?php

namespace Stafred\Async\Cached;

/**
 * Class MemcachedConnection
 * @package Stafred\Async\Cached
 */
class MemcachedConnection
{
    /**
     * @var \Memcached
     */
    protected $memcached;

    /**
     * MemcachedConnection constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->memcached = new \Memcached("STAFRED");
    }

    /**
     * @return \Memcached
     */
    public function get(): \Memcached
    {
        return $this->memcached;
    }
}