<?php

namespace Stafred\Async\Client;

/**
 * Class WrapObject
 * @package Stafred\Async\Client
 */
abstract class WrapObject
{
    /**
     * @param $token
     * @return array
     */
    abstract public function async($token): array;

    /**
     * @param $token
     * @param $event
     * @param $action
     * @param $method
     * @param $message
     * @return array
     */
    final public function fields($token, $event, $action, $method, $message): array
    {
        return [
            "token"     => $token,
            "event"     => $event,
            "action"    => $action . "::" . $method,
            "message"   => $message,
        ];
    }
}