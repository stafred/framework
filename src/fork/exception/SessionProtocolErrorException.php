<?php


namespace Stafred\Exception;

use Exception;


final class SessionProtocolErrorException extends Exception
{
    public function __construct()
    {
        $message =
            'It is forbidden to create a session with the current connection protocol.';
        $code = 403;
        parent::__construct($message, $code, NULL);
    }
}