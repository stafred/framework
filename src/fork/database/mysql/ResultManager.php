<?php

namespace Stafred\Database\Mysql;

/**
 * Class ResultManager
 * @package Stafred\Database\Mysql
 */
final class ResultManager
{
    /**
     * @var \PDOStatement|null
     */
    private $statment = NULL;
    /**
     * @var int
     */
    private $count = 0;
    /**
     * @var null|int
     */
    protected $lastID = 0;

    /**
     * ResultManager constructor.
     * @param \PDOStatement $statement
     * @param int $count
     * @param int $lastId
     */
    public function __construct(\PDOStatement $statement, int $count, int $lastId)
    {
        $this->statment = $statement;
        $this->count = $count;
        $this->lastID = $lastId;
    }

    /**
     * @return mixed
     */
    public function fetch()
    {
        return $this->statment->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * WARNING
     * Possibly the result of an error. You will need to fix.
     * @param int $style
     * @return array|null
     */
    public function fetchAll(int $style = \PDO::FETCH_ASSOC): ?array
    {
        if ($this->count <= 0) {
            return NULL;
        } else if ($this->count == 1) {
            return $this->statment->fetchAll($style);
        } else {
            $result = [];
            do {
                $result[] = $this->statment->fetchAll($style);
            } while ($this->statment->nextRowset());
            return $result;
        }
    }

    /**
     * @return \stdClass
     */
    public function fetchObject(): \stdClass
    {
        return $this->statment->fetchObject();
    }

    /**
     * @return int
     */
    public function rowCount(): int
    {
        return $this->statment->rowCount();
    }

    /**
     * @return bool
     */
    public function nextRow(): bool
    {
        return $this->statment->nextRowset();
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->statment->rowCount() > 0;
    }

    /**
     * @return bool
     */
    public function isFail(): bool
    {
        return $this->statment->errorCode() !== "00000";
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->statment->queryString;
    }

    /**
     * @return string
     */
    public function errorCode(): string
    {
        return $this->statment->errorCode();
    }

    /**
     * @param bool $arr
     * @return array|mixed
     */
    public function errorInfo(bool $arr = false)
    {
        return $arr
            ? $this->statment->errorInfo()
            : $this->statment->errorInfo()[2];
    }

    /**
     * @return bool
     */
    public function isID(): bool
    {
        return $this->lastID > 0;
    }

    /**
     * @return int
     */
    public function id(): int
    {
        return $this->lastID;
    }

    /**
     * @return \PDOStatement|null
     */
    public function getStatment(): ?\PDOStatement
    {
        return $this->statment;
    }
}