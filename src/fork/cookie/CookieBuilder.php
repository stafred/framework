<?php

namespace Stafred\Cookie;


use Stafred\Exception\SessionProtocolErrorException;
use Stafred\Exception\SessionNameNotDefinedException;
use Stafred\Utils\Arr;
use Stafred\Utils\Http;

/**
 * Class CookieBuilder
 * @package Stafred\Cookie
 */
final class CookieBuilder extends CookieHelper
{
    /**
     * CookieBuilder constructor.
     * @param CookieSetDecorator $setting
     * @throws \Exception
     */
    public function __construct()
    {
        $this->session();
        $this->security();
    }

    /**
     * @throws \Exception
     */
    private function session()
    {
        $value = $this->encode(Arr::receive(
            ['_name', '_code', '_security'], $this->getSession()
        ));

        parent::__construct();
        $this->set()->all([
            'name' => env('SESSION_HEADER_NAME'),
            'value' => $value,
            'expires' => env("COOKIE_SET_EXPIRES"),
            'path' => env("COOKIE_SET_PATH"),
            'domain' => env("COOKIE_SET_DOMAIN"),
            'secure' => Http::isSecurity(),
            'httponly' => env("COOKIE_SET_HTTPONLY"),
            'samesite' => env("COOKIE_SET_SAMESITE")
        ])->make();
    }

    private function security()
    {
        $this->csrf();
    }

    private function csrf()
    {

    }
}