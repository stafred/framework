<?php

namespace Stafred\Cache;

/**
 * Class BufferInput
 * @package Stafred\Cache
 */
class BufferInput implements InputInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function db(string $key)
    {
       return $this->run(__FUNCTION__, $key);
    }

    /**
     * @param string $method
     * @param string $key
     * @return bool
     */
    public function isKey(string $method, string $key): bool
    {
        return $this->key($method, $key);
    }

    /**
     * @param string $key
     */
    public function general(string $key)
    {
        return $this->run(__FUNCTION__, $key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function request(string $key)
    {
        return $this->run(__FUNCTION__, $key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function session(string $key)
    {
        return $this->run(__FUNCTION__, $key);
    }

    /**
     * @param string $key
     */
    public function timing(string $key)
    {
        return $this->run(__FUNCTION__, $key);
    }
}