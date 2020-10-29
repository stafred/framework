<?php

namespace Stafred\Cookie;

use Stafred\Utils\Arr;
use Stafred\Utils\Session;
use Stafred\Exception\Cookie\CookieMissingParameterException;
use Stafred\Exception\Cookie\CookieCreateErrorException;

/**
 * Class CookieSetDecorator
 * @package Stafred\Cookie
 */
final class CookieSetDecorator
{
    private $name;
    private $value;
    private $expires;
    private $path;
    private $domain;
    private $secure;
    private $httponly;
    private $samesite;
    /**
     * @var string[]
     */
    private $keys = [
        'name',
        'value',
        'expires',
        'path',
        'domain',
        'secure',
        'httponly',
        'samesite'
    ];

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string|null $domain
     */
    public function setDomain(string $domain = NULL): void
    {
        $this->domain = $domain;
    }

    /**
     * @param int $expires
     */
    public function setExpires(int $expires): void
    {
        $this->expires = time() + $expires;
    }

    /**
     * @param bool|null $httponly
     */
    public function setHttponly(bool $httponly = NULL): void
    {
        $this->httponly = $httponly;
    }

    /**
     * @param string|null $path
     */
    public function setPath(string $path = NULL): void
    {
        $this->path = $path;
    }

    /**
     * @param string|null $samesite
     */
    public function setSamesite(string $samesite = NULL): void
    {
        $this->samesite = $samesite;
    }

    /**
     * @param mixed $security
     */
    public function setSecurity(bool $security = NULL): void
    {
        $this->security = $security;
    }

    /**
     * @param mixed $value
     */
    public function setValue(string $value = NULL): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $cookie
     * @return $this
     * @throws CookieMissingParameterException
     */
    public function all(array $cookie)
    {
        $missing = Arr::missingKeys($this->keys, $cookie);
        if (!empty($missing)) {
            throw new CookieMissingParameterException($missing);
        }

        foreach ($this->keys as $key) {
            $this->{$key} = $cookie[$key];
        }

        return $this;
    }

    /**
     * @throws CookieCreateErrorException
     */
    public function make()
    {
        $cookie = [
            'expires' => time() + $this->expires,
            'path' => $this->path,
            'domain' => $this->domain,
            'secure' => $this->secure,
            'httponly' => $this->httponly,
            'samesite' => $this->samesite
        ];

        $session_secure =  Session::get('_https');
        $env_secure = env('SESSION_HTTPS_ENABLE');
        $cookie_secure = $this->secure;

        if(strtolower($this->samesite) == 'none' && $this->secure === false) {
            $cookie['secure'] = true;
        }

        if(!$env_secure) {
            $cookie['secure'] = false;
            unset($cookie['samesite']);
        }

        $cookie = setcookie($this->getName(), $this->value, $cookie);

        if ($cookie === false) {
            throw new CookieCreateErrorException();
        }
    }
}