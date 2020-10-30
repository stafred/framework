<?php

namespace Stafred\Exception;

use Stafred\Utils\Header;

/**
 * Class BaseException
 * @package Stafred\Exception
 */
class BaseException extends \Exception
{
    const ENUM_COOKIE      = 'COOKIE';
    const ENUM_ROUTE       = 'ROUTE';
    const ENUM_SESSION     = 'SESSION';
    const ENUM_SQL         = 'SQL';
    const ENUM_LOADER      = 'LOADER';
    const ENUM_MEMCACHE    = 'MEMCACHE';
    const ENUM_LOG         = "LOG";

    /**
     * Bad Request
     */
    const CODE_400   = 400;
    /**
     * Forbidden
     */
    const CODE_403   = 403;
    /**
     *  Internal Server Error
     */
    const CODE_500   = 500;

    /**
     * @param null $pointer
     */
    final public function run($pointer = NULL): void
    {
        $header = Header::make();
        $header->setStatus($this->code());
        $header->setStatusText('Error ' . strtolower($this->enum()));
        parent::__construct($this->debug($pointer), $this->code(), $this->getPrevious());
    }
}