<?php

namespace Stafred\View;

use Stafred\Cache\Buffer;

/**
 * Class ViewWrapper
 * @package Stafred\View
 */
final class ViewWrapper extends ViewAbstract
{
    /**
     * @param String $viewName
     * @return View|null
     * @throws \Exception
     */
    public static function make(string $name)
    {
        if (empty($name)) {
            throw new \Exception('views name missing'/*, 500*/);
        }

        self::$viewName = preg_replace("/\.|\\|\_|\-/", '/', $name);
        self::$inst = new self;
        return self::$inst;
    }

    /**
     * @return String|NULL
     * @throws \Exception
     */
    public function return(): string
    {
        return self::getContents();
    }

    /**
     * @throws \Exception
     */
    public function echo(): void
    {
        echo self::getContents();
    }
}