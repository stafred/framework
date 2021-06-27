<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnUpdateSetSql
 * @package Stafred\Database\Mysql
 */
interface OnUpdateSetValuesSql
{
    /**
     * @param string $first
     * @param string $operator
     * @param string $second
     * @param string $expr
     * @return OnResult
     */
    public function where(string $first, string $operator, string $second, string $expr = "AND"): OnResult;

    /**
     * @param string $condition
     * @return OnResult
     */
    public function whereRaw(string $condition, string $expr = "AND"): OnResult;
}