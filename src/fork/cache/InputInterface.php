<?php

namespace Stafred\Cache;

/**
 * Interface InputInterface
 * @package Stafred\Cache
 */
interface InputInterface
{
    public function db(string $key);
    public function session(string $key);
    public function request(string $key);
    public function general(string $key);
    public function timing(string $key);
}