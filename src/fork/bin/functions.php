<?php
if (!function_exists('env')) {
    /**
     * @param string $value
     * @return false|mixed
     */
    function env(string $value)
    {
        $value = strtoupper(
            preg_replace("/[\.\-]/", "_", $value)
        );

        if(!defined($value)) {
            return false;
        } else {
            return constant($value);
        }
    }
}

if (!function_exists('debug')) {
    /**
     * @param mixed ...$var
     */
    function debug(...$var)
    {
        dd($var);
    }
}

if (!function_exists('cookie')) {
    /**
     * @param string|null $name
     * @return \Stafred\Cookie\CookieHelper
     */
    function cookie(string $name)
    {
        return new \Stafred\Cookie\CookieHelper($name);
    }
}

if (!function_exists('session')) {
    /**
     * @return \Stafred\Session\SessionHelper
     */
    function session()
    {
        return new \Stafred\Session\SessionHelper();
    }
}

if (!function_exists('session')) {
    /**
     * @return \Stafred\Session\SessionHelper
     */
    function session()
    {
        return new \Stafred\Session\SessionHelper();
    }
}

if (!function_exists('view')) {
    function view(string $name)
    {
        return \Stafred\View\ViewWrapper::make($name);
    }
}