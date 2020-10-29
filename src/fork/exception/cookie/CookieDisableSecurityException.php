<?php

namespace Stafred\Exception\Cookie;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

final class CookieDisableSecurityException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * CookieDisableSecurityException constructor.
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
        return self::ENUM_COOKIE;
    }

    /**
     * @param null $pointer
     * @return string
     */
    public function debug($pointer = NULL): string
    {
       return 'You have disabled security for the HTTPS connection (your setting: set.httponly=false).';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}