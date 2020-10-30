<?php

namespace Stafred\Utils;

use Stafred\Cache\Buffer;
use Stafred\Cache\CacheStorage;
use Stafred\Session\SessionHelper;
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
     * @var string|null
     */
    private static $path = null;
    /**
     * @var string|null
     */
    private static $name = null;
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

    /**
     * @return string
     */
    public static function path(): string
    {
        if(self::$path === NULL){
            self::$path = Buffer::input()->session("symlink");
        }
        return self::$path;
    }

    /**
     * @return bool
     */
    public static function exists(): bool
    {
        return file_exists(self::$path);
    }
    
    /**
     * @return string
     */
    public static function name(): string
    {
        if(self::$name === NULL){
            self::$name = explode("sess_", self::path())[1];
        }
        return self::$name;
    }

    public static function clear(): void
    {
        $default = (new SessionHelper())->getDefaultSession();
        $session = CacheStorage::getAll('session');
        $clear = Arr::intersect($default, $session);
        Buffer::output()->putAll()->session($clear);
    }
}