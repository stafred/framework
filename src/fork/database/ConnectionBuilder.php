<?php

namespace Stafred\Database;

use Stafred\Cache\CacheManager;
use Stafred\Utils\DB;

/**
 * Class ConnectionBuilder
 * @package Stafred\Database
 */
class ConnectionBuilder extends ConnectionHelper
{
    /**
     * ConnectionBuilder constructor.
     */
    public function __construct()
    {
        $this->setAll(
            DATABASE_DRIVER,
            DATABASE_HOST,
            DATABASE_PORT,
            DATABASE_USER,
            DATABASE_PASS,
            DATABASE_NAME,
            DATABASE_CHAR
        );
    }

    /**
     * @return \PDO
     */
    private function PDO()
    {
        return new \PDO(
            $this->dns(),
            $this->getUser(),
            $this->getPassword()
        );
    }

    /**
     * @param \PDO $pdo
     */
    private function sharedStorage(\PDO $pdo)
    {
        CacheManager::setSharedStorageDB($this->getKey(), $pdo);
    }

    /**
     * connect primary DB
     */
    private function connect()
    {
        if (!$this->isNameEmpty()) {
            $this->sharedStorage(
                $this->PDO()
            );
        }
    }

    /**
     * connect
     */
    public function __destruct()
    {
        $this->connect();
    }
}