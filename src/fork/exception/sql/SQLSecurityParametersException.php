<?php

namespace Stafred\Exception\SQL;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class SQLParametersErrorException
 * @package Stafred\Exception
 */
final class SQLSecurityParametersException
    extends BaseException
    implements ExceptionInterfacenInterface
{
    /**
     * SQLSecurityParametersException constructor.
     * @param null $pointer
     */
    public function __construct($pointer = NULL)
    {
        parent::run($pointer);
    }

    /**
     * @return string
     */
    public function enum(): string
    {
        return self::ENUM_SQL;
    }

    /**
     * @param null $pointer
     * @return string
     */
    public function debug($pointer = NULL): string
    {
        return  "A blocked SQL query that compromises the security of the application. ".
                "All SQL query values must have a special character. " .
                "(example: var = ?, ? = var)";
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}