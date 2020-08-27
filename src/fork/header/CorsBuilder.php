<?php

namespace Stafred\Header;

use Stafred\Utils\Http;
use Stafred\Utils\Session;

/**
 * Class CorsBuilder
 * @package Stafred\Header
 */
final class CorsBuilder extends HeaderHelper
{
    /**
     * CorsBuilder constructor.
     */
    public function __construct()
    {
        if($this->getAccessCors()){
            $this->setAllowOrigin();
            $this->setAllowMethods();
            $this->setAllowHeaders();
            $this->setAllowCredentials();
            $this->setTokenVerification();
        }
    }

    /**
     * @param string|NULL $origin
     */
    private function setAllowOrigin(string $origin = NULL)
    {
        $accessOrigin = constant('HEADERS_ALLOW_ORIGIN');
        $accessOrigin = empty($accessOrigin) ? NULL : $accessOrigin;
        $accessOrigin = empty($origin) ? $accessOrigin : $origin;
        if (!empty($accessOrigin)){
            $this->setHeader("Access-Control-Allow-Origin" , $accessOrigin);
        }
    }

    /**
     * @param string|NULL $methods
     */
    private function setAllowMethods(string $methods = NULL)
    {
        $accessMethods = constant('HEADERS_ALLOW_METHODS');
        $accessMethods = empty($accessMethods)
            ? NULL
            : $accessMethods;
        $accessMethods = empty($methods) ? $accessMethods : $methods;
        if (!empty($accessMethods)){
            $this->setHeader("Access-Control-Allow-Methods" , $accessMethods);
        }
    }

    /**
     * @param bool|NULL $credentials
     */
    private function setAllowCredentials(bool $credentials = NULL)
    {
        if ($credentials) {
            $accessCredentials = 'true';
        } else {
            $accessCredentials = constant('HEADERS_ALLOW_CREDENTIALS');
            $accessCredentials = $accessCredentials ? 'true' : '';
        }

        if ($accessCredentials){
            $this->setHeader("Access-Control-Allow-Credentialss" , $accessCredentials);
        }
    }

    /**
     * @param bool|NULL $headers
     */
    private function setAllowHeaders(bool $headers = NULL)
    {
        $accessHeaders = constant('HEADERS_ALLOW_HEADERS');
        $accessHeaders = empty($accessHeaders) ? '' : $accessHeaders;
        $accessHeaders = empty($headers) ? $accessHeaders : $headers;
        if (!empty($accessHeaders)){
            $this->setHeader("Access-Control-Allow-Headers" , $accessHeaders);
        }
    }

    /**
     * Token and header: Verification
     */
    private function setTokenVerification()
    {
        $accessVerify = constant('HEADERS_CODE_VERIFICATION');

        if ($accessVerify and !Http::isAjax()) {
            $name = \Stafred\Utils\Hash::random('crc32');
            $token = \Stafred\Utils\Hash::value(
                Http::getUserIp() .
                Http::getQueryString() .
                Http::getRequestMethod()
            );
            $this->setHeader("X-{$name}" , $token);
        }

    }

    /**
     * @return bool
     */
    private function getAccessCors(): bool
    {
        return !empty(constant('HEADERS_BROWSER_CORS'));
    }
}