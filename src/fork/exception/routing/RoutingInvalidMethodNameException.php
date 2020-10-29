<?php


namespace Stafred\Exception\Routing;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;


/**
 * Class RoutingInvalidMethodNameException
 * @package Stafred\Exception\Routing
 */
final class RoutingInvalidMethodNameException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * RoutingInvalidMethodNameException constructor.
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
        return "Invalid method name.";
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }

}