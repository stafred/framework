<?php

namespace Stafred\Kernel;

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
    }

    /**
     * @return void
     */
    public function mountPrimary()
    {
        if(LoaderHelper::isPrimary()) {
            throw new \Exception("Restart of the primary autoloader of classes is prohibited.");
        }
        LoaderHelper::setPrimary();
        $this->all(self::PRIMARY);
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
}