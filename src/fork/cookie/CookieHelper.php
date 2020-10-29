<?php

namespace Stafred\Cookie;

use Stafred\Cache\Buffer;
use Stafred\Cache\CacheManager;
use Stafred\Security\Encrypt;
use Stafred\Utils\Session;

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
    final public function missing(): bool
    {
        return !isset($_COOKIE[$this->getName()]);
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
        return base64_encode(gzdeflate(json_encode($value)));
    }

    /**
     * @return bool
     */
    final public function isHttpOnly(): bool
    {
        return env("COOKIE_SET_HTTPONLY");
    }

    /**
     * @param string $name
     */
    final public function remove(string $name = NULL)
    {
        $name = empty($name) ? env('session.header.name') : $name;
        $this->set()->all([
            'name' => env('SESSION_HEADER_NAME'),
            'value' => NULL,
            'expires' => env("COOKIE_SET_EXPIRES"),
            'path' => env("COOKIE_SET_PATH"),
            'domain' => env("COOKIE_SET_DOMAIN"),
            'secure' => Session::get('_https'),
            'httponly' => env("COOKIE_SET_HTTPONLY"),
            'samesite' => env("COOKIE_SET_SAMESITE")
        ])->make();
    }

    /**
     * @param bool $secure
     * @param string $code
     * @return string
     */
    final public function encodeSecure(bool $secure, string $code)
    {
        return base64_encode(
            Encrypt::xor(
                ($secure ? 'true' : 'false') . '|'
                . $code . env('app.secret.key')
            )
        );
    }

    /**
     * @return array
     */
    protected function getSession()
    {
        return Buffer::input()->getAll()->session();
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return $this->name;
    }
}