<?php

namespace Stafred\Http;

/**
 * Interface IHttp
 * @package Stafred\Http
 */
interface IHttp
{
    public static function isSecurity(): bool;

    public static function isMobile(): bool;
    
    public static function isAjax(): bool;

    public static function getUserAgent(): string;

    public static function getUserIp(): string;

    public static function getServerName(): string;

    public static function getServerIp(): string;

    public static function getDocRoot(): string;

    public static function getQueryString(): ?string;

    public static function getReferer(): string;

    public static function getRequestMethod(): string;

    public static function getScheme(): string;

    public static function getMethod(): string;
}