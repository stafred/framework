<?php

namespace Stafred\Cache;

use Stafred\Utils\Arr;
use Stafred\Utils\Hash;

/**
 * Class CacheHelper
 * @package Stafred\Cache
 */
class CacheHelper
{
    /**
     * @var string
     */
    protected static $hashSessionStorage = 'd41d8cd98f00b204e9800998ecf8427e';
    /**
     * @var array
     */
    protected static $sharedSessionStorage = [];
    /**
     * @var array
     */
    protected static $sharedStorageDB = [];
    /**
     * @var array
     */
    protected static $sharedStorage = [];
    
    /**
     * @return array
     */
    final public static function getSharedStorage(): array
    {
        return self::$sharedStorage;
    }

    /**
     * @param string $key
     * @return \PDO|NULL
     */
    final public static function getSharedStorageDB(string $key): ?\PDO
    {
        return self::$sharedStorageDB[Hash::value($key, 'crc32')] ?? NULL;
    }

    /**
     * @param string $key
     * @return mixed
     */
    final public static function getSharedSessionStorage(string $key)
    {
        return self::$sharedSessionStorage[$key] ?? NULL;
    }

    /**
     * @return array
     */
    final public static function getAllSessionStorage(): array
    {
        return self::$sharedSessionStorage;
    }

    /**
     * @return string|null
     */
    final public static function getHashSessionStorage(): ?string
    {
        return self::$hashSessionStorage;
    }

    /**
     * @param array $sharedStorage
     */
    final public static function setSharedStorage(array $sharedStorage): void
    {
        self::$sharedStorage = $sharedStorage;
    }

    /**
     * @param string $key
     * @param \PDO $value
     */
    final public static function setSharedStorageDB(string $key, \PDO $value): void
    {
        self::$sharedStorageDB[Hash::value($key, 'crc32')] = $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    final public static function setSharedSessionStorage(string $key, $value): void
    {
        self::$sharedSessionStorage[$key] = $value;
    }

    final public static function setHashSessionStorage(): void
    {
        self::$hashSessionStorage = Arr::hash(self::$sharedSessionStorage);
    }

    /**
     * @param array $value
     */
    final public static function putAllSessionStorage(array $value): void {
        self::$sharedSessionStorage = Arr::combine(self::$sharedSessionStorage, $value);
    }

    /**
     * @param string $key
     * @return bool
     */
    final public static function existsKeyStorageDB(string $key)
    {
        return isset(self::$sharedStorageDB[Hash::value($key, 'crc32')]);
    }


}