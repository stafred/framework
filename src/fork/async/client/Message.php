<?php

namespace Stafred\Async\Client;

/**
 * Class Message
 * @package Stafred\Async
 */
abstract class Message
{
    abstract public function create(): Pack;
}