<?php

namespace Stafred\Utils;

use Stafred\Database\Mysql\QueryWrapper;

/**
 * Class DB
 * @package Stafred\Utils
 */
final class DB
{
    /**
     * @param array $query
     * @param array|NULL $parameters
     * @return QueryWrapper
     */
    public static function all(array $query, array $parameters = NULL)
    {
        return new QueryWrapper($query, $parameters, NULL);
    }

    /**
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
     * @param array|NULL $parameters
     * @return QueryWrapper
     */
    public static function query(string $string, array $parameters = NULL)
    {
        return new QueryWrapper([
            'query' => $string,
        ], $parameters, NULL);
    }

    /**
     * @param string $column
     * @param string $table
     * @param string|NULL $where
     * @param string|NULL $others
     * @param array $parameters
     * @return QueryWrapper
     */
    public static function select(
        string $column,
        string $table,
        string $where = NULL,
        string $others = NULL,
        array $parameters = NULL,
        bool $security = true
    )
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
        array $parameters,
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
}