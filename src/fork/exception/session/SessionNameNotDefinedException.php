<?php

namespace Stafred\Exception\Session;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class SessionNameNotDefinedException
 * @package Stafred\Exception
 */
final class SessionNameNotDefinedException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * SessionNameNotDefinedException constructor.
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
        return self::ENUM_SESSION;
    }

    /**
     * @param null $pointer
     * @return string
     */
    public function debug($pointer = NULL): string
    {
        return 'Session name not defined.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}