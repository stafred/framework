<?php

namespace Stafred\Database;

use Stafred\Cache\CacheManager;
use Stafred\Kernel\TimeService;
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
        TimeService::start(__CLASS__);

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
     * @return bool
     */
    private function isShared()
    {
        return CacheManager::existsKeyStorageDB($this->getKey());
    }

    /**
     * connect primary DB
     */
    final public function connect()
    {
        if (!$this->isNameEmpty() || $this->isShared()) {
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
        if(DATABASE_PRELOAD) {
            $this->connect();
        }

        TimeService::finish(__CLASS__);
    }
}