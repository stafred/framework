<?php
namespace Stafred\Header;

/**
 * Class CorsManager
 * @package Stafred\Header
 */
class CorsManager
{
    /**
     * @param string|NULL $origin
     */
    final public function setAllowOrigin(string $origin = NULL)
    {
        $accessOrigin = HEADERS_ALLOW_ORIGIN;
        $accessOrigin = empty($accessOrigin) ? NULL : $accessOrigin;
        $accessOrigin = empty($origin) ? $accessOrigin : $origin;
        if(!empty($accessOrigin))
            header("Access-Control-Allow-Origin: $accessOrigin");
    }

    /**
     * @param string|NULL $methods
     */
    final public function setAllowMethods(string $methods = NULL)
    {
        $accessMethods = HEADERS_ALLOW_METHODS;
        $accessMethods = empty($accessMethods)
            ? NULL
            : $accessMethods
        ;
        $accessMethods = empty($methods) ? $accessMethods : $methods;

        if(!is_null($accessMethods))
            header("Access-Control-Allow-Methods: ".$accessMethods);
    }

    /**
     * @param bool|NULL $credentials
     */
    final public function setAllowCredentials(bool $credentials = NULL)
    {
        if($credentials)
        {
            $accessCredentials = 'true';
        }
        else
        {
            $accessCredentials = HEADERS_ALLOW_CREDENTIALS;
            $accessCredentials = $accessCredentials  ? 'true' : '';
        }

        if($accessCredentials)
            header("Access-Control-Allow-Credentials: {$accessCredentials}");
    }

    /**
     * @param bool|NULL $headers
     */
    final public function setAllowHeaders(bool $headers = NULL)
    {
        $accessHeaders = HEADERS_ALLOW_HEADERS;
        $accessHeaders = empty($accessHeaders) ? '' : $accessHeaders;
        $accessHeaders = empty($headers) ? $accessHeaders : $headers;

        if(!empty($accessHeaders))
            header("Access-Control-Allow-Headers: ".$accessHeaders);
    }

    /**
     * Token and header: Verification
     */
    final public function setTokenVerification()
    {
        $accessVerify = HEADERS_VERIFICATION;
        if($accessVerify)
            header("Verification: " . \Stafred\Utils\Hash::set('sha256', false));
    }
}