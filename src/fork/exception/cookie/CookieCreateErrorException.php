<?php
namespace Stafred\Exception\Cookie;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class CookieCreateErrorException
 * @package Stafred\Exception\Cookie
 */
final class CookieCreateErrorException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * CookieCreateErrorException constructor.
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
        return 'The cookie was not created. Perhaps the reason is incorrect data ' .
               'or you are trying to display the content before creating the header.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}