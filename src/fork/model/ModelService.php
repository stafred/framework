<?php

namespace Stafred\Model;

/**
 * Class ModelService
 * @package Stafred\Model
 */
class ModelService implements ModelServiceGet
{
    /**
     * @var array
     */
    private $buffer = [];

    /**
     * @return ModelServiceGet
     */
    public function where(): ModelServiceGet
    {
        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
       return $this->buffer;
    }
}