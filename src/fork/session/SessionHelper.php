<?php

namespace Stafred\Session;

use Stafred\Cache\CacheManager;
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
    protected $defaultPath = "/factory/storage/session";
    /**
     * @var string
     */
    protected $defaultSession = [
        "_check" => NULL,
        "_csrf" => NULL,
        "_ip" => NULL
    ];

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->getSymlink());
    }

    /**
     * @return bool
     */
    public function missing(): bool
    {
        return !$this->exists();
    }

    /**
     * @return bool
     */
    public function isName(): bool
    {
        return is_null($this->getName());
    }

    /**
     * @return bool|string
     */
    final public function open()
    {
        return file_get_contents($this->getSymlink());
    }

    /**
     * @param bool $arr
     * @return array|object
     */
    final public function all(bool $arr = true)
    {
        return $this->unserialize($this->open(), $arr);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    final public function get(string $key)
    {
        $open = $this->unserialize($this->open(), true);
        return $open[$key] ?? NULL;
    }

    /**
     * @param string $key
     * @param String|Numeric $value
     * @throws \Exception
     */
    final public function put(string $key, $value)
    {
        $session = $this->open();
        if (!$session) {
            throw new \Exception("An error occurred while fetching session data", 500);
        }
        $session = $this->unserialize($session);
        $session[$key] = $value;

        file_put_contents(
            $this->getSymlink(),
            $this->serialize($session)
        );
    }

    /**
     * @return string
     */
    protected function getPath(): string
    {
        return '..' .
            (!defined('SESSION_FILE_DIRPATH')
                ? $this->defaultPath
                : SESSION_FILE_DIRPATH) .
            '/';
    }

    /**
     * @return string
     */
    protected function getSymlink(): string
    {
        return $this->getPath() . $this->getFile();
    }

    protected function getFile()
    {
        return $this->getPrefix() . '_' . $this->getName();
    }

    /**
     * @return string
     */
    protected function getPrefix(): string
    {
        return SESSION_FILE_PREFIX;
    }

    /**
     * @return int
     */
    protected function getLifetime(): int
    {
        return SESSION_FILE_LIFETIME;
    }

    /**
     * @return string|null
     */
    protected function getName(): ?string
    {
        return CacheManager::getSharedSessionStorage('name');
    }

    protected function setName()
    {
        CacheManager::setSharedSessionStorage('name', $this->makeName());
    }

    /**
     * @return string
     */
    protected function makeName()
    {
        $ip     = !env('SESSION_BIND_IP')    ? NULL : Http::getUserIp();
        $agent  = !env('SESSION_BIND_AGENT') ? NULL : Http::getUserAgent();
        return md5($ip . $agent . env('APP_SECRET_KEY'));
    }

    protected function create()
    {
        $this->setIp($this->defaultSession);
        file_put_contents($this->getSymlink(), $this->serialize($this->defaultSession));
        $this->putAllCache($this->defaultSession);
    }

    protected function read()
    {
        $session = $this->unserialize($this->open());
        $this->setIp($session);
        $this->putAllCache($session);
    }

    protected function rewrite(array $value)
    {
        file_put_contents($this->getSymlink(), $this->serialize($value));
    }

    /**
     * @param array $value
     * @return string
     */
    protected function serialize(array $value)
    {
        return json_encode($value);
    }

    /**
     * @param string $value
     * @param bool $arr
     * @return array|object
     */
    protected function unserialize(string $value, bool $arr = true)
    {
        return json_decode($value, $arr);
    }

    /**
     * @param array $value
     */
    protected function putAllCache(array $value): void
    {
        CacheManager::putAllSessionStorage($value);
    }

    /**
     * @return array
     */
    protected function getAllCache(): array
    {
        return CacheManager::getAllSessionStorage();
    }

    /**
     * @param array $session
     */
    private function setIp(array &$session)
    {
        $session["_ip"] = Http::getUserIp();
    }
}