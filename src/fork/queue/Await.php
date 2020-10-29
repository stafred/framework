<?php

namespace Stafred\Queue;

/**
 * Class Await
 * @package Stafred\Queue
 */
final class Await
{
    /**
     * @var bool
     */
    public $stop;

    /**
     * Await constructor.
     * @param bool $stop
     */
    public function __construct(bool $stop = false)
    {
        $this->stop = $stop;
    }
}