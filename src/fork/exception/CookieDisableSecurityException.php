<?php

namespace Stafred\Exception;

use Exception;
use Stafred\Utils\Header;

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
        $header = Header::make();
        $header->setStatus(500);
        $header->setStatusText('Error cookie');

        $message =
            'You have disabled security for the HTTPS connection (your setting: set.httponly=false).';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}