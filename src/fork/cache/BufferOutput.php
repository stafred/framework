<?php


namespace Stafred\Cache;

use Stafred\UDPS\UDPClient;

/**
 * Class BufferOutput
 * @package Stafred\Cache
 */
class BufferOutput implements OutputInterface
{
    /**
     * @param string $key
     * @param $value
     */
    public function db(string $key, $value): void
    {
        $this->run(__FUNCTION__, $key, $value);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function general(string $key, $value): void
    {
        $this->run(__FUNCTION__, $key, $value);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function request(string $key, $value): void
    {
        $this->run(__FUNCTION__, $key, $value);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function session(string $key, $value)
    {
        $this->run(__FUNCTION__, $key, $value);
    }

    /**
     * @param string $key
     * @param bool $start
     */
    public function timing(string $key, bool $start = true): void
    {
        $time = microtime(true);
        $time = !$start
            ? $time - CacheStorage::get(__FUNCTION__, $key)
            : $time;
        $this->run(__FUNCTION__, $key, $time);
    }

    /**
     * @param string $key
     * @param array $value
     */
    public function routing(string $key, array $value): void
    {
        $this->run(__FUNCTION__, $key, $value);
    }
}