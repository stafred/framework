<?php

namespace Stafred\Cache;

/**
 * Interface BufferInterface
 * @package Stafred\Cache
 */
interface OutputInterface
{
    public function db(string $key, $value);
    public function session(string $key, $value);
    public function request(string $key, $value);
    public function general(string $key, $value);
    public function timing(string $key, bool $start = true);
}