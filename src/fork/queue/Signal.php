<?php

namespace Stafred\Queue;

/**
 * Class Signal
 * @package Stafred\Queue
 */
final class Signal
{
    /**
     * @var string|null
     */
    private $value;

    /**
     * Signal constructor.
     * @param string|null $value
     */
    public function __construct(string $value = NULL)
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function get(): ?string
    {
        return $this->value;
    }
}