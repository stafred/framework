<?php

namespace Stafred\Utils;

use Stafred\Http\HttpObserver;
use Stafred\Http\IHttp;

/**
 * Class Http
 * @package Stafred\Utils
 */
final class Http implements IHttp
{
    /**
     * @var \Stafred\Http\HttpObserver|null
     */
    private static $instance = NULL;

    /**
     * Http constructor.
     */
    public function __construct()
    {
        if(self::$instance !== NULL){
            self::$instance = new HttpObserver();
        }
    }

    public static function getDocRoot(): string
    {
        return '';
    }

    public static function getQueryString(): string
    {
        return '';
    }

    public static function getReferer(): string
    {
        return '';
    }

    public static function getRequestMethod(): string
    {
        return '';
    }

    public static function getServerName(): string
    {
        return '';
    }

    public static function getUserAgent(): string
    {
        return '';
    }

    public static function getUserIp(): string
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function isAjax(): bool
    {
        $key = 'HTTP_X_REQUESTED_WITH';
        $xhr = 'XMLHttpRequest';
        return isset($_SERVER[$key]) && $_SERVER[$key] === $xhr;
    }

    public static function isMobile(): bool
    {
        return false;
    }

    public static function isSecurity(): bool
    {
        return false;
    }
    
    
}