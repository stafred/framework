<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnSelectFrom
 * @package Stafred\Database\Mysql
 */
interface OnSelectFromSql
{
    /**
     * @param string $first
     * @param string $operator
     * @param string $second
     * @param string $expr
     * @return OnResult
     */
    public function where(string $first, string $operator, string $second, string $expr = "AND");

    /**
     * @param string $condition
     * @param string $expr
     * @return OnResult
     */
    public function whereRaw(string $condition, string $expr = "AND");
}