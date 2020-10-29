<?php

namespace Stafred\Exception;

use Stafred\Utils\Header;

class BaseException extends \Exception
{
    const ENUM_COOKIE      = 'COOKIE';
    const ENUM_ROUTE       = 'ROUTE';
    const ENUM_SESSION     = 'SESSION';
    const ENUM_SQL         = 'SQL';
    const ENUM_LOADER      = 'LOADER';

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

    final public function run($pointer = NULL)
    {
        $header = Header::make();
        $header->setStatus($this->code());
        $header->setStatusText('Error ' . strtolower($this->enum()));
        parent::__construct($this->debug($pointer), $this->code(), $this->getPrevious());
    }
}