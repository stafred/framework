<?php

namespace Stafred\Cookie;

use Stafred\Exception\SessionProtocolErrorException;
use Stafred\Exception\SessionNameNotDefinedException;
use Stafred\Kernel\TimeService;
use Stafred\Utils\Arr;
use Stafred\Utils\Http;
use Stafred\Utils\Session;

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
        TimeService::start(__CLASS__);

        $this->session();
        $this->security();
    }

    /**
     * @throws \Exception
     */
    private function session()
    {
        $cookie = Arr::receive(
            ['_name', '_code', '_security', /*'_ckscr'*/], $this->getSession()
        );

        $cookieSecure = Session::get('_https');

        parent::__construct();

        $this->set()->all([
            'name' => env('SESSION_HEADER_NAME'),
            'value' => $this->encode($cookie),
            'expires' => env("COOKIE_SET_EXPIRES"),
            'path' => env("COOKIE_SET_PATH"),
            'domain' => env("COOKIE_SET_DOMAIN"),
            'secure' => $cookieSecure,
            'httponly' => env("COOKIE_SET_HTTPONLY"),
            'samesite' => env("COOKIE_SET_SAMESITE")
        ])->make();
    }

    private function security()
    {

    }

    public function __destruct()
    {
        TimeService::finish(__CLASS__);
    }
}