<?php

namespace Stafred\Utils;

use Stafred\Header\HeaderHelper;
use Stafred\Http\HttpObserver;
use Stafred\Http\IHttp;

/**
 * Class Http
 * @package Stafred\Utils
 */
final class Http extends HeaderHelper implements IHttp
{
    public static function getDocRoot(): string
    {
        return $_SERVER["DOCUMENT_ROOT"];
    }

    public static function getQueryString(): ?string
    {
        return $_SERVER['QUERY_STRING'];
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

    public static function getServerIp(): string
    {
        return $_SERVER['SERVER_ADDR'];
    }

    /**
     * @return string
     */
    public static function getServerPort(): string
    {
        return $_SERVER['SERVER_PORT'];
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
        return isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on';
    }

    public static function getScheme(): string
    {
        return $_SERVER['REQUEST_SCHEME'];
    }

    public static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}