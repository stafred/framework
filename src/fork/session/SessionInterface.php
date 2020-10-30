<?php

namespace Stafred\Session;

/**
 * Interface
 * @package Stafred\Session
 */
interface SessionInterface
{
    public static function all();

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key);

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public static function set(string $key, $value);
}