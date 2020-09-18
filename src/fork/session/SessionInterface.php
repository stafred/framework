<?php

namespace Stafred\Session;

/**
 * Interface
 * @package Stafred\Session
 */
interface SessionInterface
{
    public static function all();

    public static function get(string $key);

    public static function set(string $key, $value);
}