<?php
if (!function_exists('env')) {
    /**
     * @param string $value
     * @return false|mixed
     */
    function env(string $value)
    {
        if(!defined($value)) {
            return false;
        } else {
            return constant($value);
        }
    }
}