<?php


namespace Stafred\Exception;

use Exception;


class SessionNameNotDefinedException extends Exception
{
    /**
     * CookieDisableSecurityException constructor.
     */
    public function __construct()
    {
        $message =
            'Session name not defined.';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}