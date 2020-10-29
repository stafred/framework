<?php

namespace Stafred\Exception\Session;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class SessionNotFoundException
 * @package Stafred\Exception
 */
final class SessionNotFoundException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * SessionNotFoundException constructor.
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
        $pointer = is_string($pointer) ? $pointer : 'unknown';
        return 'Session file not found. It was deleted or not created. PATH: ' . $path .
               ' (Warning: remove cookies).';
    }

    /**
     * @return int
     */
    public function code(): int
    {
       return self::CODE_500;
    }
}