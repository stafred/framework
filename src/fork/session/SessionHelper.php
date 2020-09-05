<?php

namespace Stafred\Session;

use Stafred\Cache\CacheManager;
use Stafred\Cookie\CookieHelper;
use Stafred\Utils\Hash;
use Stafred\Utils\Http;

/**
 * Class SessionHelper
 * @package Stafred\Session
 */
class SessionHelper
{
    /**
     * @var string
     */
    protected $sessionCode;

    /**
     * @var string
     */
    protected $defaultPath = "/factory/storage/session";

    /**
     * @var array
     */
    protected $defaultSession = [
        "_name" => NULL,
        "_code" => NULL,
        "_security" => NULL,
        "_csrf" => NULL,
        "_ip" => NULL
    ];

    /********************/

    /**
     * @return CookieHelper
     */
    protected function cookie(): CookieHelper
    {
        return new CookieHelper(env("SESSION_HEADER_NAME"));
    }

    protected function create()
    {
        /*master*/
        $this->setIp();
        $this->setOutputSecurity();
        $this->setOutputCode();
        /*slave*/
        $this->setOutputName();
        $this->setOutputSymlink();

        $this->putAllCache($this->defaultSession);
    }

    /**
     * @throws \Exception
     */
    protected function read()
    {
        $this->setInputSymlink();
        $this->putAllCache($this->unserialize($this->open()));
        /*master*/
        $this->setIp();
        $this->setOutputSecurity();
        $this->setOutputCode();

        $this->putAllCache($this->defaultSession);

//        $this->getInputSecurity();
//        $this->setOutputSecurity();

        cookie('name')->set($this->getName());
        cookie('_input')->set($this->getOutputSecurity());
    }

    protected function write(array $value)
    {
        file_put_contents(
            $this->getSymlink(),
            $this->serialize($value)
        );
    }

    /**
     * @return string
     */
    protected function getSymlink(): string
    {
        return CacheManager::getSharedSessionStorage('symlink');
    }

    /**
     * @param array $value
     */
    protected function putAllCache(array $value): void
    {
        CacheManager::putAllSessionStorage($value);
        $this->defaultSession = $value;
    }

    /********************/

    private function setIp()
    {
        $this->defaultSession["_ip"] = Http::getUserIp();
    }

    /********************/
    /****** OUTPUT ******/
    /********************/
    private function setOutputCode()
    {
        $this->defaultSession["_code"] = Hash::random('md5') . $this->setExpires();
    }

    private function setOutputSecurity()
    {
        $this->defaultSession["_security"] = Http::isSecurity()
            ? Hash::value(substr($_SERVER["SSL_SESSION_ID"], 0, 32), 'whirlpool')
            : Hash::random('whirlpool');
    }

    private function setOutputName()
    {
        $this->defaultSession["_name"] = Hash::random('md5', 'new_session_name');
    }

    /**
     *
     */
    private function setOutputSymlink(): void
    {
        $symlink = $this->path() . $this->prefix() . '_' .
            $this->file(
                $this->getName(),
                $this->getOutputSecurity()
            );
        CacheManager::setSharedSessionStorage('symlink', $symlink);
    }

    /**
     * @return string
     */
    private function getOutputSecurity(): string
    {
        return $this->defaultSession["_security"];
    }

    /********************/
    /******* INPUT ******/
    /********************/

    private function setInputSymlink()
    {
        $cookie = $this->cookie();
        $_name = $cookie->key('_name')->getValue();
        $_security = $cookie->key('_security')->getValue();
        $symlink = $this->path() . $this->prefix() . '_' .
            $this->file($_name, $_security);
        CacheManager::setSharedSessionStorage('symlink', $symlink);
    }


    /**
     * @return string
     */
    private function setExpires(): string
    {
        return explode(".", microtime(true))[0];
    }

    /**
     * @return string
     */
    private function getName(): string
    {
        return $this->defaultSession["_name"];
    }

    /**********************/
    /****** symlink *******/
    /**********************/
    /**
     * @return string
     */
    private function path(): string
    {
        return '..' . (!defined('SESSION_FILE_DIRPATH')
                ? $this->defaultPath
                : SESSION_FILE_DIRPATH) . '/';
    }

    /**
     * @return string
     */
    private function prefix(): string
    {
        return env("SESSION_FILE_PREFIX");
    }

    /**
     * @return bool|string
     */
    private function open()
    {
        return file_get_contents($this->getSymlink());
    }

    /**
     * @param string $name
     * @param string $security
     * @return string
     */
    protected function file(string $name, string $security): string
    {
        return md5($name . $security);
    }

    /**********************/

    /**
     * @return mixed|null
     */
    private function security()
    {
        return $this->defaultSession['_security'];
    }

    /***********************/
    /****** serialize ******/
    /***********************/
    /**
     * @param array $value
     * @return string
     */
    private function serialize(array $value)
    {
        return json_encode($value);
    }

    /**
     * @param string $value
     * @param bool $arr
     * @return array|object
     */
    private function unserialize(string $value, bool $arr = true)
    {
        return json_decode($value, $arr);
    }
    /***********************/
}