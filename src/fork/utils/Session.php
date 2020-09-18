<?php

namespace Stafred\Utils;

use Stafred\Session\SessionInterface;
use Stafred\Session\SessionDecorator;

/**
 * Class Session
 * @package Stafred\Utils
 */
final class Session implements SessionInterface
{
    /**
     * @var SessionDecorator|null
     */
    private static $instance = null;

    /**
     * @return Session
     */
    private static function getInstance(): SessionDecorator
    {
        if (self::$instance === null) {
            self::$instance = new SessionDecorator();
        }

        return self::$instance;
    }

    /**
     * @param bool $arr
     * @return array|object
     */
    public static function all(bool $arr = true)
    {
        return self::getInstance()->getAll($arr);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        return self::getInstance()->getValue($key);
    }

    /**
     * @param string $key
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    public static function set(string $key, $value): void
    {
        self::getInstance()->setValue($key, $value);
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