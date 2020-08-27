<?php


namespace Stafred\Http;

/**
 * Class HttpObserver
 * @package Stafred\Http
 */
class HttpObserver
{
    /**
     * HttpObserver constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return bool
     */
    public function isSecurity(): bool
    {
        return !isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== 'on';
    }
}