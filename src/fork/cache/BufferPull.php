<?php

namespace Stafred\Cache;

/**
 * Class BufferPull
 * @package Stafred\Cache
 */
class BufferPull
{
    public function session()
    {
        return $this->run(__FUNCTION__); 
    }

    public function request()
    {
        return $this->run(__FUNCTION__);
    }

    public function routing()
    {
        return $this->run(__FUNCTION__);
    }
}