<?php

namespace Stafred\Async;

/**
 * Class Header
 * @package Stafred\Async
 */
abstract class Header
{
    /**
     * @return string
     */
    abstract public function getData(): string;
}