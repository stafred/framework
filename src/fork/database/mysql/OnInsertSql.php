<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnInsertSql
 * @package Stafred\Database\Mysql
 */
interface OnInsertSql
{
    /**
     * @param string $table
     * @param array $data
     * @param array $rename
     * @return OnResultWithId
     */
    public function insert(string $table, array $data, array $rename = []): OnResultWithId;
}