<?php

namespace Stafred\Cookie;

/**
 * Class CookieKeyDecorator
 * @package Stafred\Cookie
 */
final class CookieKeyDecorator
{
    /**
     * @var null
     */
    private static $key = NULL;
    /**
     * @var null
     */
    private static $value = NULL;

    /**
     * @param string $key
     * @param null $value
     * @return CookieKeyDecorator
     */
    public static function run(string $key, $value = NULL)
    {
        self::$key = $key;
        self::$value = $value;
        return new self();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $value = json_decode(base64_decode(self::$value), true);
        return !is_array($value) ? $value : $value[self::$key];
    }

    public function putValue()
    {

    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty(self::$value);
    }
}