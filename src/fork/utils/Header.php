<?php

namespace Stafred\Utils;

use Stafred\Cache\Buffer;
use Stafred\Header\HeaderHelper;

/**
 * Class Header
 * @package Stafred\Utils
 */
final class Header extends HeaderHelper
{
    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @return Header
     */
    private static function getInstance(): Header
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Header
     */
    public static function make(): Header
    {
        return self::getInstance();
    }

    public function redirectIndex()
    {
        var_dump($_SERVER);
        dd(Buffer::input()->getAll()->session());
        //header("LOCATION: /");
        exit;
    }
}