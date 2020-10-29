<?php

namespace Stafred\Queue;

/**
 * Class Message
 * @package Stafred\Queue
 */
final class Message
{
    /**
     * @var
     */
    private $value;

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function set($value): void
    {
        $this->value = $value;
    }
}