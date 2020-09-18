<?php

namespace Stafred\Exception;

use Exception;
use Stafred\Utils\Header;

/**
 * Class SessionErrorException
 * @package Stafred\Exception
 */
final class SessionErrorException extends Exception
{
    public function __construct()
    {
        $header = Header::make();
        $header->setStatus(406);
        $header->setStatusText('Error session');
        parent::__construct('The session has expired or has been deleted due to unauthorized access.', 406);
    }
}