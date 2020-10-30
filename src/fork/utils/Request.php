<?php


namespace Stafred\Utils;

use Stafred\Cache\Buffer;
use Stafred\Cache\CacheStorage;

/**
 * Class Request
 * @package Stafred\Utils
 */
class Request
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return Buffer::input()->getAll()->request()["request"]["resource"];
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function value(string $key)
    {
        $arr = $this->toArray();
        return Arr::isKey($key,$arr) ? $arr[$key] : NULL;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function allHeaders(): array
    {
        return getallheaders();
    }

    /**
     * необходимо использовать валидатор дл япроверки полученных значений
     * @param string $key
     * @return array
     */
    public function getHeader(string $key): array
    {
        return htmlentities(getallheaders()[$key]);
    }
}