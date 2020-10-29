<?php

namespace Stafred\Exception\Routing;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class RoutingControllerNotFoundException
 * @package Stafred\Exception
 */
final class RoutingControllerNotFoundException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * RoutingControllerNotFoundException constructor.
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
        return self::ENUM_ROUTE;
    }

    /**
     * @param null $pointer
     * @return string
     */
    public function debug($pointer = NULL): string
    {
        return 'Controller not found.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }

}