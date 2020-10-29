<?php


namespace Stafred\Exception;

/**
 * Interface ExceptionInterface
 * @package Stafred\Exception
 */
interface ExceptionInterface
{
    /**
     * ExceptionInterface constructor.
     * @param null $pointer
     */
    public function __construct($pointer = NULL);
    /**
     * @return string
     */
    public function enum(): string;

    /**
     * @return string
     */
    public function debug($pointer = NULL): string;

    /**
     * @return int
     */
    public function code(): int;
}