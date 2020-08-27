<?php

namespace Stafred\Kernel;

use Stafred\Utils\Arr;

/**
 * Class ClassLoader
 * @package Stafred\Kernel
 */
final class ClassLoader extends ClassList
{
    /**
     * @var bool
     */
    private $declared = false;

    /**
     * ClassLoader constructor.
     * @param bool $declared
     */
    public function __construct(bool $declared = false)
    {
        $this->declared = $declared;
        $this->controller();
    }

    /**
     * @return void
     */
    public function mount()
    {
        $this->all(Arr::merge(self::MASTER,self::SLAVE,self::ADDON));
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
        if(LoaderHelper::isPrimary()) {
            throw new \Exception("Restart of the primary autoloader of classes is prohibited.");
        }

        if(LoaderHelper::isSlave()) {
            throw new \Exception("Restart of the slave autoloader of classes is prohibited.");
        }

        if(LoaderHelper::isSlave()) {
            throw new \Exception("Restart of the others autoloader of classes is prohibited.");
        }
    }

    private function set()
    {
        LoaderHelper::setPrimary();
        LoaderHelper::setSlave();
        LoaderHelper::setOthers();
    }
}