<?php

namespace Stafred\Bin;
/**
 * Class FunctionHelper
 * @package Stafred\Bin
 */
final class ProvideMethods
{
    /**
     * @var
     */
    private $value;
    /**
     * FunctionHelper constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return is_null($this->value);
    }

    /**
     * @return bool
     */
    public function isArray(): bool
    {
        return is_array($this->value);
    }
}