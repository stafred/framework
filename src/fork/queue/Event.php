<?php
namespace Stafred\Queue;

/**
 * Class Event
 * @package Stafred\Queue
 */
final class Event
{
    /**
     * @return Await
     */
    public function await(): Await
    {
        return new Await();
    }

    /**
     * @param string|null $value
     * @return Signal
     */
    public function signal(string $value = NULL): Signal
    {
        return new Signal($value);
    }

    /**
     * @return Shutdown
     */
    public function shutdown(): Shutdown
    {
        return new Shutdown();
    }

    /**
     * @return Shutdown
     */
    public function remove(): Remove
    {
        return new Remove();
    }
}