<?php

namespace Stafred\Exception\Routing;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class RoutingMethodNotPublicException
 * @package Stafred\Exception\Routing
 */
final class RoutingMethodNotPublicException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * RoutingMethodNotPublicException constructor.
     * @param null $pointer
     */
    public function __construct($pointer = NULL)
    {
        parent::run($pointer);
    }

    /**
     * @inheritDoc
     */
    public function enum(): string
    {
        return self::ENUM_ROUTE;
    }

    /**
     * @inheritDoc
     */
    public function debug($pointer = NULL): string
    {
        return "Method doesn`t have a public modifier.";
    }

    /**
     * @inheritDoc
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}