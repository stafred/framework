<?php

namespace Stafred\Kernel;

use Stafred\Exception\LoaderClassAllreadyMountException;
use Stafred\Utils\Arr;
use Stafred\Utils\Cookie;

/**
 * Class ClassLoader
 * @package Stafred\Kernel
 */
final class ClassLoader extends ClassList
{
    /**
     * ClassLoader constructor.
     * @param bool $declared
     */
    public function __construct()
    {
        $this->controller();
    }

    /**
     * @return void
     */
    public function mount()
    {
        $this->all(Arr::merge(
            self::KERNEL,
            self::MASTER,
            self::SLAVE,
            self::ADDON
        ));
        $this->set();
    }

    /**
     * @param array $clazz
     */
    public function all(array $clazz)
    {
        foreach ($clazz as $key => $clazz) {
            new $clazz;
        }
    }

    /**
     * @param string $clazz
     * @return void
     */
    public function single(string $clazz)
    {
        new $clazz;
    }

    /**
     * @throws \Exception
     */
    private function controller()
    {
        if(LoaderSingleton::isMount()) {
            throw new LoaderClassAllreadyMountException();
            exit;
        }
    }

    private function set()
    {
        LoaderSingleton::setMount();
    }
}