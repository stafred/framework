<?php
namespace Stafred\Memcache;

use Stafred\Exception\Memcache\MemcacheKeyNotFoundException;

/**
 * Class Connect
 * @package Memcache
 */
class Connect
{
    /**
     * @var string
     */
    private $host = '127.0.0.1';
    /**
     * @var string
     */
    private $port = '11211';

    /**
     * @var \Memcached
     */
    private $memcached;

    /**
     * MemcachedConnection constructor.
     */
    public function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        $this->memcached = new \Memcached();
        $this->memcached->addServer(
            $this->host,
            $this->port
        );
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        $buffer = $this->memcached->get($key);
        if($this->memcached->getResultCode() == \Memcached::RES_NOTFOUND){
            throw new MemcacheKeyNotFoundException();
        }
        return $buffer;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->memcached->set($key, $value);
    }

    /**
     * @return \Memcached
     */
    public function getInstance(): \Memcached
    {
        return $this->memcached;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isKey(string $name): bool
    {
        return empty($this->memcached->get($key));
    }

    public function close(): void
    {
        $this->memcached->quit();
    }
}