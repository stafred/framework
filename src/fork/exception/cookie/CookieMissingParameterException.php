<?php

namespace Stafred\Exception\Cookie;

use Stafred\Exception\BaseException;

/**
 * Class CookieMissingParameterException
 * @package Stafred\Exception\Cookie
 */
final class CookieMissingParameterException
    extends BaseException
    implements ExceptionInterface
{

    /**
     * CookieMissingParameterException constructor.
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
        $pointer = is_array($pointer) ? ' (' . implode(", ", $pointer) . ')' : '';
        return 'Invalid parameter for creating a cookie' . $pointer .  '.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}
