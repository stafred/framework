<?php

namespace Stafred\Cache;

/**
 * Class BufferForce
 * @package Stafred\Cache
 */
class BufferForce
{
    /**
     * @param $value
     */
    public function session($value)
    {
        $this->run(__FUNCTION__, $value);
    }
}