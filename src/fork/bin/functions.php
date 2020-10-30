<?php

use Stafred\Utils\Str;

if (!function_exists('env')) {
    /**
     * @param string $value
     * @return false|mixed
     */
    function env(string $value)
    {
        $value = Str::upper(
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

if (!function_exists('dumper')) {
    /**
     * @param mixed ...$var
     */
    function dumper(...$vars)
    {
        foreach ($vars as $v) {
            \Symfony\Component\VarDumper\VarDumper::dump($v);
        }
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

if (!function_exists('view')) {
    /**
     * @param string $name
     * @return \Stafred\View\View|\Stafred\View\ViewWrapper|null
     * @throws Exception
     */
    function view(string $name)
    {
        return \Stafred\View\ViewWrapper::make($name);
    }
}

if (!function_exists('csrf_token')) {
    /**
     * @return string
     */
    function csrf_token(): string
    {
        return \Stafred\Utils\Hash::random("md5");
    }
}

if (!function_exists('x_icon')) {
    /**
     * @return string
     */
    function x_icon(): string
    {
        return '<link rel="shortcut icon" href="data:image/x-icon;" type="image/x-icon">';
    }
}
if (!function_exists('path')) {
    /**
     * @return \Stafred\Utils\Path
     */
    function path(int $level = 6): \Stafred\Utils\Path
    {
        return new \Stafred\Utils\Path($level);
    }
}
if (!function_exists('redirect')) {
    /**
     * @return \Stafred\Utils\Redirect
     */
    function redirect(): \Stafred\Utils\Redirect
    {
        return new \Stafred\Utils\Redirect();
    }
}

