<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnSelectSql
 * @package Stafred\Database\Mysql
 */
interface OnSelectSql
{
    /**
     * @param array $tables
     * @return OnSelectFromSql|OnResult
     */
    public function from(array $tables): OnSelectFromSql;

    /**
     * @param string $tables
     * @return OnSelectFromSql|OnResult
     */
    public function fromRaw(string $tables): OnSelectFromSql;
}