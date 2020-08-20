<?php
namespace Stafred\Cache;

use Stafred\Utils\Hash;

/**
 * Class CacheHelper
 * @package Stafred\Cache
 */
class CacheHelper
{
    /**
     * @var array
     */
    protected static $sharedStorage = [];
    /**
     * @var array
     */
    protected static $sharedStorageDB = [];
    /**
     * @return array
     */
    public static function getSharedStorage(): array
    {
        return self::$sharedStorage;
    }

    /**
     * @param string $key
     * @return \PDO|NULL
     */
    public static function getSharedStorageDB(string $key): ?\PDO
    {
        return self::$sharedStorageDB[Hash::value($key, 'crc32')];
    }

    /**
     * @param array $sharedStorage
     */
    public static function setSharedStorage(array $sharedStorage): void
    {
        self::$sharedStorage = $sharedStorage;
    }

    /**
     * @param string $key
     * @param \PDO $value
     */
    public static function setSharedStorageDB(string $key, \PDO $value): void
    {
        self::$sharedStorageDB[Hash::value($key, 'crc32')] = $value;
    }
}