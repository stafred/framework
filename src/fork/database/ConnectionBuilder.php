<?php

namespace Stafred\Database;

use Stafred\Kernel\TimeService;
use Stafred\Cache\Buffer;

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
    protected function PDO(): \PDO
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
    protected function sharedStorage(\PDO $pdo)
    {
        Buffer::output()->db($this->getKey(), $pdo);
    }

    /**
     * @return bool
     */
    protected function isShared(): bool
    {
        return Buffer::input()->isKey('db', $this->getKey());
    }

    public function connect()
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
        if(env("database.preload")) {
            $this->connect();
        }
    }
}
