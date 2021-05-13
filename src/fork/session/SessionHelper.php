<?php

namespace Stafred\Session;

use App\Models\Kernel\Debug;
use Stafred\Cache\Buffer;
use Stafred\Cache\CacheStorage;
use Stafred\Cookie\CookieHelper;
use Stafred\Exception\SessionErrorException;
use Stafred\Exception\SessionNotFoundException;
use Stafred\Header\HeaderHelper;
use Stafred\Security\Encrypt;
use Stafred\Utils\Cookie;
use Stafred\Utils\Hash;
use Stafred\Utils\Header;
use Stafred\Utils\Http;
use Stafred\Utils\Str;

/**
 * Class SessionHelper
 * @package Stafred\Session
 */
class SessionHelper
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    protected $defaultPath = "../factory/storage/session";

    /**
     * @var array
     */
    protected $defaultSession = [
        "_name" => NULL,
        "_code" => NULL,
        "_security" => NULL,
        "_https" => NULL,
        "_csrf" => NULL,
        "_ip" => NULL,
        "_udps" => NULL,
        "symlink" => NULL,
    ];

    /***
     * @var
     */
    protected $sessionHeaderName;

    /********************/

    /**
     * @return CookieHelper
     */
    protected function cookie(): CookieHelper
    {
        return new CookieHelper($this->getHeaderName());
    }

    /**
     * @return Header
     */
    protected function header(): Header
    {
        return Header::make();
    }

    protected function create()
    {
        $this->setIp();
        $this->setOutputSecurity();
        $this->setOutputCode();
        $this->setOutputName();
        $this->setOutputSymlink();
        $this->setOutputProtocol();
        $this->putAllCache($this->defaultSession);
    }

    protected function rewrite()
    {
        $this->setIp();
        $this->setOutputCode();
        $this->setInputName();
        $this->putAllCache($this->defaultSession);
    }

    /**
     * @return string
     */
    protected function read(): string
    {
        $cookie = $this->cookie();
        $_name = $cookie->key('_name')->getValue();
        $_security = $cookie->key('_security')->getValue();
        $this->code = $cookie->key('_code')->getValue();
        return $this->setInputSymlink($_name, $_security);
    }

    /**
     * @return string
     */
    public function inspect()
    {
        return $this->read();
    }

    protected function get()
    {
        $this->defaultSession = $this->unserialize(
            file_get_contents($this->getSymlink())
        );
    }

    /**
     * @param array $value
     */
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
        return Buffer::input()->session('symlink');
    }

    /**
     * @param array $value
     */
    protected function putAllCache(array $value): void
    {
        Buffer::output()->putAll()->session($value);
        $this->defaultSession = NULL;
    }

    /**
     * @return bool
     */
    protected function exists(): bool
    {
        return file_exists($this->getSymlink());
    }

    /**
     * @return bool
     */
    protected function missing(): bool
    {
        return !file_exists($this->getSymlink());
    }

    /**
     * @return bool
     */
    protected function failed(): bool
    {
        return $this->code !== $this->defaultSession['_code'];
    }

    protected function clear()
    {
        $cookie = $this->cookie()->set();
        $cookie->setName($this->getHeaderName());
        $cookie->setValue(NULL);
        $cookie->setExpires(time() - 3600);
    }

    protected function remove()
    {
        if (file_exists($this->getSymlink())) {
            unlink($this->getSymlink());
        }
    }

    /**
     * @throws SessionErrorException
     */
    protected function reloadPage()
    {
        if (Http::isAjax()) {
            throw new SessionErrorException();
        } else {
            $this->header()->redirectIndex();
        }
    }

    /**
     * @return string
     */
    protected function getSessionCode(): string
    {
        return $this->sessionCode;
    }

    /**
     * @return bool
     */
    protected function getProtocol(): bool
    {
        return $this->defaultSession['_https'];
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
            ? Hash::value(
                substr($_SERVER["SSL_SESSION_ID"] ?? env("app.secret.key"), 0, 32),
                'whirlpool'
            )
            : Hash::random('whirlpool');
    }

    private function setOutputName()
    {
        $this->defaultSession["_name"] = Hash::random('md5', 'new_session_name');
    }

    private function setOutputSymlink(): void
    {
        $symlink = $this->path() . $this->prefix() . '_' .
            $this->file(
                $this->getName(),
                $this->getOutputSecurity()
            );
        $this->defaultSession["symlink"] = $symlink;
    }

    private function setOutputProtocol()
    {
        $this->defaultSession["_https"] = Http::isSecurity();
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

    /**
     * @param string $name
     * @param string $security
     * @return string
     */
    private function setInputSymlink(string $name, string $security): string
    {
        $symlink = $this->path() . $this->prefix() . '_' .
            $this->file($name, $security);

        Buffer::output()->session('symlink', $symlink);
        return $symlink;
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

    private function setInputName(): void
    {
        $value = cookie($this->getHeaderName())->key('_name')->getValue();
        /*warning: maybe injection code hack*/
        $this->defaultSession['_name'] = Str::cut(Str::PATTERN_CUT_SYMBOLS, $value);
    }

    private function getInputValue(string $value, string $code)
    {
        return base64_decode($value);
    }
    /**********************/
    /****** symlink *******/
    /**********************/
    /**
     * @return string
     */
    private function path(): string
    {
        return (!defined('SESSION_FILE_DIRPATH')
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
        if ($this->missing()) {
            $this->reloadPage();
            throw new SessionNotFoundException($this->getSymlink());
        }
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

    /**
     * @return string
     * @deprecated var $end
     */
    private function getHeaderName(): string
    {
        $end = '';

        $this->sessionHeaderName = empty($this->sessionHeaderName)
            ? env("SESSION_HEADER_NAME")
            : $this->sessionHeaderName;
        return strtoupper($this->sessionHeaderName . $end);
    }

    /**
     * @return array
     */
    final public function getDefaultSession(): array
    {
        return $this->defaultSession;
    }
}