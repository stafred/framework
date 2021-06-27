<?php

namespace Stafred\Utils;

use Stafred\Database\Mysql\OnInstructionSql;
use Stafred\Database\Mysql\OnQuery;
use Stafred\Database\Mysql\QueryService;
use Stafred\Database\Mysql\QueryWrapper;

/**
 * Class DB
 * @package Stafred\Utils
 */
final class DB extends QueryService
{
    /**
     * @return OnInstructionSql
     */
    public static function on(): OnInstructionSql {
        return new OnQuery();
    }

    /**
     * <pre style="color:#ff9900">
     * DB::all([
     * &nbsp;&nbsp;&nbsp;DB::{method_query}(...args)->toString(),
     * &nbsp;&nbsp;&nbsp;...
     * &nbsp;&nbsp;&nbsp;DB::{method_query}(...args)->toString(),
     * ],[...parameters]): QueryWrapper
     * </pre>
     * @param array $query
     * @param array|NULL $parameters
     * @return QueryWrapper
     */
    public static function all(array $query, array $parameters = NULL): QueryWrapper
    {
        return new QueryWrapper($query, $parameters, NULL);
    }

    /**
     * to combine query strings only
     * alternative method - all()
     * @param array $query
     * @param array|NULL $parameters
     * @return QueryWrapper
     */
    public static function combine(array $query, array $parameters = NULL)
    {
        return self::all($query, $parameters, NULL);
    }

    /**
     * @param string $string
     * @param array|null $parameters
     * @param bool $security
     * @return QueryWrapper
     */
    public static function query(string $string, array $parameters = NULL, bool $security = true)
    {
        return new QueryWrapper([
            'query' => $string,
        ], $parameters, NULL, $security);
    }

    /**
     * @param string $column
     * @param string $table
     * @param string|null $where
     * @param string|null $others
     * @param array|null $parameters
     * @param bool $security
     * @return QueryWrapper
     */
    public static function select(string $column, string $table, string $where = NULL, string $others = NULL, array $parameters = NULL, bool $security = true): QueryWrapper
    {
        return new QueryWrapper([
            'column' => $column,
            'table' => $table,
            'where' => $where,
            'others' => $others
        ], $parameters, 'select', $security);
    }

    /**
     * @param string $table
     * @param array $column
     * @param array|NULL $values
     * @return QueryWrapper
     */
    public static function insert(
        string $table,
        array $column,
        array $parameters,
        bool $security = true
    )
    {
        return new QueryWrapper([
            'table' => $table,
            'column' => $column,
            'count' => count($column),
        ], $parameters, 'insert', $security);
    }

    /**
     * @param string $table
     * @param array $column
     * @param array|NULL $values
     * @return QueryWrapper
     */
    public static function update(
        string $table,
        array $column,
        string $where = NULL,
        array $parameters = NULL,
        bool $security = true
    )
    {
        return new QueryWrapper([
            'table' => $table,
            'column' => $column,
            'where' => $where,
        ], $parameters, 'update', $security);
    }

    /**
     * @param string $table
     * @param array $column
     * @param array|NULL $values
     * @return QueryWrapper
     */
    public static function delete(
        string $table,
        string $where = NULL,
        array $parameters = NULL,
        bool $security = true
    )
    {
        return new QueryWrapper([
            'table' => $table,
            'where' => $where,
        ], $parameters, 'delete', $security);
    }

    public function __construct()
    {

    }
    /**
     * @return DB
     */
    public static function stats()
    {
        return new self;
    }

    /**
     * @return \PDO
     */
    public function pdo(): \PDO
    {
        return $this->getPDO();
    }
}