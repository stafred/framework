<?php

namespace Stafred\Exception\Loader;

use Stafred\Exception\BaseException;
use Stafred\Exception\ExceptionInterface;

/**
 * Class LoaderClassAllreadyMountException
 * @package Stafred\Exception\Loader
 */
final class LoaderClassAllreadyMountException
    extends BaseException
    implements ExceptionInterface
{
    /**
     * LoaderClassAllreadyMountException constructor.
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
        return self::ENUM_LOADER;
    }

    /**
     * @param null $pointer
     * @return string
     */
    public function debug($pointer = NULL): string
    {
        return 'Remounting of main classes is prohibited.';
    }

    /**
     * @return int
     */
    public function code(): int
    {
        return self::CODE_500;
    }
}