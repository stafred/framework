<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnUpdateSql
 * @package Stafred\Database\Mysql
 */
interface OnUpdateSql
{
    /**
     * @param array $data
     * @return OnUpdateSetSql|OnResult
     */
    public function set(array $data, array $rename = []): OnUpdateSetSql;

    /**
     * @param string $data
     * @param array $values
     * @return OnUpdateSetSql|OnResult
     */
    public function setRaw(string $data, array $values): OnUpdateSetSql;
}