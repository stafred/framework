<?php


namespace Stafred\Exception;

use Exception;
use Stafred\Utils\Header;

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
        $header = Header::make();
        $header->setStatus(500);
        $header->setStatusText('Error cookie');

        $message =
            'Invalid parameter for creating a cookie (' . implode(", ", $parameter) . ').';
        $code = 500;
        parent::__construct($message, $code, NULL);
    }
}