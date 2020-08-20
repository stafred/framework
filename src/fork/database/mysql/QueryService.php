<?php

namespace Stafred\Database\Mysql;

use Stafred\Cache\CacheManager;

/**
 * Class QueryService
 * @package Stafred\Database\Mysql
 */
class QueryService
{
    /**
     * @var string
     */
    protected $operation = '';
    /**
     * @var string
     */
    protected $query = '';
    /**
     * @var array
     */
    protected $properties = [];
    /**
     * @var bool|\PDOStatement
     */
    protected $statment = false;
    /**
     * @var int
     */
    protected $countQuery = 0;
    /**
     * @var null|int
     */
    protected $lastID = 0;
    /**
     * @var bool
     */
    protected $security = true;

    /**
     * QueryService constructor.
     */
    private function __construct()
    {

    }

    /**
     * @param array $query
     * @param array $parameters
     */
    protected function primary(array $query, array $parameters)
    {
        $this->countQuery = count($query);
        $this->query = $this->toQueryStringPrimary($query);
        $query = NULL;
        $this->properties = array_values($parameters);
    }

    /**
     * Added Name Operation
     * @param array $query
     * @param array $parameters
     * @param string|NULL $operations
     */
    protected function slave(array $query, array $parameters, string $operations = NULL)
    {
        $this->countQuery = 1;
        $this->operation = $operations;
        $this->query = $this->toQueryStringSlave($query, $parameters, $operations);
        $this->properties = \Stafred\Utils\Arr::toOne($parameters);
    }

    /**
     * @param array $query
     * @return mixed
     */
    private function toQueryStringPrimary(array $query): string
    {
        return implode("; ", $query);
    }

    /**
     * @param array $query
     * @param array|NULL $parameters
     * @param string|NULL $operations
     * @return string
     */
    private function toQueryStringSlave(array $query, array $parameters = NULL, string $operations = NULL)
    {
        switch ($operations) {
            case 'select':
                $select = 'SELECT ' . $query['column'];
                $from = 'FROM ' . $query['table'];
                $where = empty($query['where']) ? '' : 'WHERE ' . $query['where'];
                $others = empty($query['others']) ? '' : $query['others'];
                return implode(' ', [$select, $from, $where, $others]);
            case 'insert':
                $insert = 'INSERT INTO ' . $query['table'];
                $column = '(' . implode(',', $query['column']) . ')';
                $values = 'VALUES ' . $this->getBindValues(
                        \Stafred\Utils\Arr::isMulti($parameters),
                        $query["count"],
                        count($parameters)
                    );
                return implode(' ', [$insert, $column, $values]);
            case 'update':
                $update = 'UPDATE ' . $query['table'];
                $set = 'SET ' . $this->getBindSet($query['column']);
                $where = empty($query['where']) ? '' : 'WHERE ' . $query['where'];
                return implode(' ', [$update, $set, $where]);
            case 'delete':
                $delete = 'DELETE FROM ' . $query['table'];
                $where = empty($query['where']) ? '' : 'WHERE ' . $query['where'];
                return implode(' ', [$delete, $where]);
        }
    }

    /**
     * @param bool $separator
     * @return string
     */
    final public function toString(): string
    {
        return $this->query;
    }

    /**
     * @return array
     */
    final public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param $get_id
     * @return ResultManager
     */
    final public function get($get_id = false): ResultManager
    {
        if ($get_id === true) {
            $this->executeLastId();
        } else {
            $this->execute();
        }

        return new ResultManager(
            $this->statment,
            $this->countQuery,
            $this->lastID
        );
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        if ($this->isInsert()) $this->executeLastId();
        return $this->lastID;
    }

    /**
     * @return bool
     */
    private function isInsert(): bool
    {
        return $this->operation == 'insert';
    }

    /**
     * @return \PDO
     */
    private function getPDO(): \PDO
    {
        return CacheManager::getSharedStorageDB(
            DATABASE_DRIVER .
            DATABASE_HOST .
            DATABASE_NAME
        );
    }

    /**
     * @throws \Exception
     */
    private function execute()
    {
        $this->securityParams(DATABASE_SECURITY && $this->security);
        $this->statment = $this->getPDO()->prepare($this->query);
        $this->statment->execute($this->properties);
    }

    /**
     * @throws \Exception
     */
    private function executeLastId()
    {
        $this->securityParams(DATABASE_SECURITY && $this->security);
        $this->statment = $this->getPDO()->prepare($this->query);
        $this->statment->execute($this->properties);
        $this->lastID = $this->getPDO()->lastInsertId();
    }

    /**
     * @param bool $multi
     * @param int $count_column
     * @param int $count_row
     * @return array|string
     */
    private function getBindValues(bool $multi, int $count_column, int $count_row)
    {
        for ($i = 0, $columns = []; $i < $count_column; ++$i, $columns[] = '?') ;
        $columns = '(' . implode(",", $columns) . ')';
        $rows = [];
        if ($multi) {
            for ($i = 0, $rows = []; $i < $count_row; ++$i, $rows[] = $columns) ;
            $rows = implode(", ", $rows);
        } else {
            $rows = $columns;
        }
        return $rows;
    }

    /**
     * @param array $set
     * @return string
     */
    private function getBindSet(array $set)
    {
        $str = [];
        foreach ($set as $v) {
            if (preg_match("/^\s*[^\?=]+\s*$/", $v)) {
                $str[] = $v . ' = ?';
            } else {
                $str[] = $v;
            }
        }
        return implode(', ', $str);
    }

    /**
     * patterns for calc parameters
     * @param string $query
     * @return int
     */
    private function getCountParams(string $query): int
    {
        $operators = '[=\>\<\!]{1,3}';
        $pattern = implode("|", [
            '\s*'.$operators.'\s*[\'\"]', /*pattern string right*/
            '[\'\"]\s*'.$operators.'\s*', /*pattern string left*/
            '\s*'.$operators.'\s*[\d]+', /*pattern number right*/
            '[\d]+\s*'.$operators.'\s*', /*pattern number left*/
        ]);
        preg_match_all("/$pattern/", $query, $matcher);
        return count($matcher[0]);
    }

    /**
     * patterns for security SQL-queries
     * @param string $query
     * @return int
     */
    private function getFindCountParamsSecurity(string $query): int
    {
        preg_match_all("/\s*=\s*\?|\?\s*=\s*/", $query, $matcher);
        return count($matcher[0]);
    }

    /**
     * @param bool $security
     * @throws \Stafred\Exception\SQLSecurityParametersException
     */
    private function securityParams($security = true)
    {
        if ($security === false) return;
        $countTotal = $this->getCountParams($this->toString());
        //var_dump('result: ' . $countTotal);
        if ($countTotal > 0) {
            throw new \Stafred\Exception\SQLSecurityParametersException();
        }
    }
}