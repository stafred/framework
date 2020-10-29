<?php

namespace Stafred\Exception\Routing;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class RoutingControllerNoNameException
 * @package Stafred\Exception\Routing
 */
final class RoutingControllerNoNameException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * RoutingControllerNoNameException constructor.
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
        return 'The controller has no name.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }

}