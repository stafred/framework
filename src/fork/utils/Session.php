<?php

namespace Stafred\Utils;

use Stafred\Session\SessionInterface;
use Stafred\Session\SessionHelper;

/**
 * Class Session
 * @package Stafred\Utils
 */
final class Session implements SessionInterface
{
    /**
     * @var Session|null
     */
    private static $instance = null;

    /**
     * @return Session
     */
    private static function getInstance(): SessionHelper
    {
        if (self::$instance === null) {
            self::$instance = new SessionHelper();
        }

        return self::$instance;
    }

    /**
     * @param bool $arr
     * @return array|object
     */
    public static function all(bool $arr = true)
    {
        return self::getInstance()->all($arr);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        return self::getInstance()->get($key);
    }

    /**
     * @param string $key
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function put(string $key, $value): void
    {
        self::getInstance()->put($key, $value);
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}