<?php

namespace Stafred\Utils;

/**
 * Class Hash
 * @package Stafred\Utils
 */
final class Hash
{
    const ASKEY = 'APP_SECRET_KEY';

    /**
     * @param string $algo
     * @param bool $crypt
     * @return bool|string
     */
    public static function set(string $algo = 'sha512', bool $crypt = true)
    {
        if ($crypt) {
            return substr(crypt(
                $_SERVER['REMOTE_ADDR'] . constant(self::ASKEY) . microtime(true),
                '$1$1'
            ), 0, 40);
        } else {
            return hash(
                $algo,
                $_SERVER['REMOTE_ADDR'] .
                constant(self::ASKEY) .
                $_SERVER['HTTP_USER_AGENT']);
        }
    }

    /**
     * @param string $data
     * @param string $algo
     * @return string
     */
    public static function value(string $data, string $algo = 'sha512')
    {
        return hash($algo, $data);
    }

    /**
     * @param string $algo
     * @param string|null $salt
     * @return string
     */
    public static function random(string $algo, string $salt = NULL)
    {
        return hash(
            $algo,
            APP_SECRET_KEY .
            Http::getUserIp() .
            microtime(true) .
            rand(1, 1000000) .
            $salt
        );
    }
}