<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnInstructionSql
 * @package Stafred\Database\Mysql
 */
interface OnInstructionSql
{
    /**
     * @param array $columns
     * @return mixed
     */
    public function select(array $columns = ['*']): OnSelectSql;

    /**
     * @param array $columns
     * @return OnSelect
     */
    public function selectRaw(string $columns = '*'): OnSelectSql;

    /**
     * @param string $table
     * @param array $data
     * @param array $rename
     * @return OnResultWithId
     */
    public function insert(string $table, array $data, array $rename = []): OnResultWithId;

    /**
     * @param array $tables
     * @return OnUpdateSql|OnResult
     */
    public function update(array $tables): OnUpdateSql;

    /**
     * @param string $tables
     * @return OnUpdateSql|OnResult
     */
    public function updateRaw(string $tables): OnUpdateSql;
}