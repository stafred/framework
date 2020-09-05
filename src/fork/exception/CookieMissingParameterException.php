<?php


namespace Stafred\Exception;

use Exception;

/**
 * Class CookieMissingParameterException
 * @package Stafred\Exception
 */
final class CookieMissingParameterException extends Exception
{
    /**
     * CookieMissingParameterException constructor.
     * @param array $parameter
     */
    public function __construct(array $parameter = [])
    {
        $message =
            'Invalid parameter for creating a cookie (' . implode(", ", $parameter) . ').';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}