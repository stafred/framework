<?php
namespace Stafred\Exception\SQL;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;
use Throwable;

/**
 * Class SqlErrorException
 * @package Bin\Exception
 */
class SqlErrorException 
    extends BaseException
    implements ExceptionInterface
{
    public function __construct($pointer = NULL)
    {
        parent::run($pointer);
    }

    public function enum(): string
    {
        return self::ENUM_SQL;
    }

    public function debug($pointer = NULL): string
    {
        return $pointer;
    }

    public function code(): int
    {
        return self::CODE_400;
    }
}