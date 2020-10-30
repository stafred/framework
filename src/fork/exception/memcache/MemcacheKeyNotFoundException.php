<?php
namespace Stafred\Exception\Memcache;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;
use Throwable;

final class MemcacheKeyNotFoundException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * MemcacheKeyNotFoundException constructor.
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
        return self::ENUM_MEMCACHE;
    }

    /**
     * @param null $pointer
     * @return string
     */
    public function debug($pointer = NULL): string
    {
        return 'Invalid key or cache was not generated.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}