<?php

namespace Stafred\Exception;
use Stafred\Utils\Header;
use Throwable;

/**
 * Class SQLParametersErrorException
 * @package Stafred\Exception
 */
final class SQLSecurityParametersException extends \Exception
{
    /**
     * SQLParametersErrorException constructor.
     */
    public function __construct()
    {
        $header = Header::make();
        $header->setStatus(500);
        $header->setStatusText('Error security');
        $message =
            "A blocked SQL query that compromises the security of the application. ".
            "All SQL query values must have a special character. " .
            "(example: var = ?, ? = var)";
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}