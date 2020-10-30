<?php
namespace Stafred\Exception\Log;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;
use Throwable;

/**
 * Class LogDirectoryNotCreatedException
 * @package Stafred\Exception\Log
 */
final class LogDirectoryNotCreatedException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * LogDirectoryNotCreatedException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function enum(): string
    {
        return self::ENUM_LOG;
    }

    /**
     * @param null $pointer
     * @return string
     */
    public function debug($pointer = NULL): string
    {
        return 'Directory for storing logs not found or not created.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_400;
    }
}