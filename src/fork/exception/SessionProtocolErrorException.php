<?php

namespace Stafred\Exception;

use Exception;
use Stafred\Utils\Header;

/**
 * Class SessionProtocolErrorException
 * @package Stafred\Exception
 */
final class SessionProtocolErrorException extends Exception
{
    /**
     * SessionProtocolErrorException constructor.
     */
    public function __construct()
    {
        $header = Header::make();
        $header->setStatus(403);
        $header->setStatusText('Error session');
        $message =
            'It is forbidden to create a session with the current connection protocol.';
        $code = 403;
        parent::__construct($message, $code, NULL);
    }
}