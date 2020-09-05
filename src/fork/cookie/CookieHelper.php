<?php

namespace Stafred\Cookie;

use Stafred\Cache\CacheManager;

/**
 * Class CookieHelper
 * @package Stafred\Cookie
 */
class CookieHelper
{
    /**
     * @var null
     */
    protected $name = NULL;
    /**
     * @var null
     */
    protected $key = NULL;
    /**
     * @var CookieSetDecorator
     */
    protected $setting;

    /**
     * CookieHelper constructor.
     * @param string|null $name
     */
    public function __construct(string $name = NULL)
    {
        $this->name = $name;
        $this->setting = new CookieSetDecorator();
    }

    /**
     * @param string $key
     * @return CookieKeyDecorator
     */
    public function key(string $key)
    {
        $this->key = $key;
        return CookieKeyDecorator::run($key, $this->get());
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return CookieSetDecorator
     */
    final public function set(): CookieSetDecorator
    {
        return $this->setting;
    }

    /**
     * @return mixed
     */
    final public function get()
    {
        return $_COOKIE[$this->getName()];
    }

    /**
     * @return array
     */
    final public function getAll()
    {
        return $_COOKIE;
    }

    /**
     * @return bool
     */
    final public function isset(): bool
    {
        return isset($_COOKIE[$this->getName()]);
    }

    /**
     * @return bool
     */
    final public function empty(): bool
    {
        return empty($_COOKIE[$this->getName()]);
    }

    /**
     * @param array $value
     * @return string
     */
    final public function encode(array $value)
    {
        return base64_encode(json_encode($value));
    }

    /**
     * @return bool
     */
    final public function isHttpOnly(): bool
    {
        return env("COOKIE_SET_HTTPONLY");
    }

    /**
     * @return array
     */
    protected function getSession()
    {
        return CacheManager::getAllSessionStorage();
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return $this->name;
    }
}