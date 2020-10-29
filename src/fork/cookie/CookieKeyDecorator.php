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
     * @param string $value
     * @return CookieKeyDecorator
     */
    public static function run(string $key, string $value)
    {
        self::$key = $key;
        self::$value = self::decode($value);
        return new self();
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return !is_array( self::$value)
            ?  self::$value
            :  self::$value[self::$key];
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

    /**
     * @param string $value
     * @return array|null
     */
    private static function decode(string $value): ?array
    {
        return json_decode(
            gzinflate(
                base64_decode($value)
            ), true
        );
    }
}