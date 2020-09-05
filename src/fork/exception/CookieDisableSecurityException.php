<?php

namespace Stafred\Exception;

use Exception;

/**
 * Class CookieDisableSecurityException
 * @package Stafred\Exception
 */
final class CookieDisableSecurityException extends Exception
{
    /**
     * CookieDisableSecurityException constructor.
     */
    public function __construct()
    {
        $message =
            'You have disabled security for the HTTPS connection (your setting: set.httponly=false).';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}