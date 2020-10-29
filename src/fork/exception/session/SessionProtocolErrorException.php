<?php

namespace Stafred\Exception\Session;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class SessionProtocolErrorException
 * @package Stafred\Exception\Session
 */
final class SessionProtocolErrorException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * SessionProtocolErrorException constructor.
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
        return 'It is forbidden to create a session with the current connection protocol.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_403;
    }
}