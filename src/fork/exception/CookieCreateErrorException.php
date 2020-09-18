<?php


namespace Stafred\Exception;

use Exception;
use Stafred\Utils\Header;


final class CookieCreateErrorException extends Exception
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
            'The cookie was not created.';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}