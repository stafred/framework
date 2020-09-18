<?php


namespace Stafred\Exception;

use Exception;
use Stafred\Utils\Header;


final class SessionNameNotDefinedException extends Exception
{
    /**
     * CookieDisableSecurityException constructor.
     */
    public function __construct()
    {
        $header = Header::make();
        $header->setStatus(500);
        $header->setStatusText('Error session');

        $message =
            'Session name not defined.';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}