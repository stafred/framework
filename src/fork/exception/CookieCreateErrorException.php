<?php


namespace Stafred\Exception;

use Exception;


final class CookieCreateErrorException extends Exception
{
    /**
     * CookieDisableSecurityException constructor.
     */
    public function __construct()
    {
        $message =
            'The cookie was not created.';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}