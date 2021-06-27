<?php


namespace Stafred\Database\Mysql;

use App\Models\Kernel\Debug;
use Stafred\Cache\Buffer;
use Stafred\Exception\SQL\SqlErrorException;
use Stafred\Utils\Arr;

/**
 * Class OnQueryAbstract
 * @package Stafred\Database\Mysql
 */
abstract class OnQueryAbstract extends OnQueryFields
    implements OnInstructionSql, OnUpdateSql, OnUpdateSetSql,
    OnResult, OnResultWithId, OnSelectSql, OnSelectFromSql
{
    /**
     * @param array|string[] $columns
     * @return OnSelectSql|OnResult
     */
    public function select(array $columns = ['*']): OnSelectSql
    {
        $this->event = 'select';
        $this->columns = $columns;
        return $this;
    }

    /**
     * @param string $columns
     * @return OnSelectSql|OnResult
     */
    public function selectRaw(string $columns = '*'): OnSelectSql
    {
        $this->event = 'select';
        $this->columns[] = $columns === '*' ? ['*'] : explode(",", $columns);
        return $this;
    }

    /**
     * @param array $tables
     * @return OnSelectFrom|OnResult
     */
    public function from(array $tables): OnSelectFromSql {
        $this->tables = $tables;
        return $this;
    }

    /**
     * @param string $tables
     * @return OnSelectFrom|OnResult
     */
    public function fromRaw(string $tables): OnSelectFromSql {
        $this->tables = explode(",", $tables);
        return $this;
    }

    /**
     * @param array $tables
     * @return OnUpdateSql|OnResult
     */
    public function update(array $tables): OnUpdateSql
    {
        $this->event = 'update';
        $this->update = implode(',', $tables);
        return $this;
    }

    /**
     * @param array $tables
     * @return OnUpdateSql|OnResult
     */
    public function updateRaw(string $tables): OnUpdateSql
    {
        $this->event = 'update';
        $this->update = $tables;
        return $this;
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $rename
     * @return OnResultWithId|OnResult
     */
    public function insert(string $table, array $data, array $rename = []): OnResultWithId {
        $this->event = 'insert';
        $this->tables[] = $table;
        $this->columns = [];
        if(Arr::isOne($data)) {
            foreach ($data as $key => $value) {
                $this->properties[] = $value;
                $this->columns[] = $this->renameKey($key, $rename);
                $this->values[] = '?';
            }
            $this->values = ['(' .implode(', ', $this->values) .')'];
        }
        else {
            foreach ($data as $arr) {
                $keys = [];
                $values = [];
                foreach ($arr as $key => $value) {
                    $keys[] = $this->renameKey($key, $rename);
                    $values[] = '?';
                }
                $this->values[] = '(' .implode(', ', $values) .')';
                $this->properties[] = $arr;
                $this->columns = $keys;
            }
        }

        $this->properties = Arr::toOne($this->properties);
        return $this->execute();
    }

    /**
     * @param array $data
     * @param array $rename
     * @return OnUpdateSetSql|OnResult
     */
    public function set(array $data, array $rename = []): OnUpdateSetSql
    {
        foreach ($data as $key => $value) {
            $_key = $this->renameKey($key, $rename);
            $this->set[] = "{$_key} = ?";
            $this->properties[] = $value;
        }
        return $this;
    }

    /**
     * @param string $data
     * @param array $values
     * @return OnUpdateSetSql|OnResult
     */
    public function setRaw(string $data, array $values = []): OnUpdateSetSql
    {
        $this->set[] = $data;
        $this->properties = Arr::merge($this->properties,$values);
        return $this;
    }

    /**
     * @param string $first
     * @param string $operator
     * @param string $second
     * @param string $expr
     * @return OnUpdateSetSql|OnResult
     */
    public function where(string $first, string $operator, string $second, string $expr = "AND")
    {
        $this->wheres[] = (object)["sql" => "{$first} {$operator} ?", "expr" => $expr];
        $this->properties[] = $second;
        return $this;
    }

    /**
     * @param string $condition
     * @param string $expr
     * @return OnUpdateSetSql|OnResult
     */
    public function whereRaw(string $condition, string $expr = "AND")
    {
        $this->wheres[] = (object)["sql" => $condition, "expr" => $expr];
        return $this;
    }

    /**
     * @return string
     */
    public function toSql(): string
    {
        return $this->sql == null ? $this->getSql() : $this->sql;
    }

    /**
     * @return string
     */
    public function toError(): string
    {
        return $this->error == null ? '' : $this->error;
    }

    /**
     * @return array
     */
    public function toProperties(): array
    {
        return $this->properties;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        if($this->statment === null){
            return 0;
        }
        return (int)$this->statment->rowCount();
    }

    /**
     * @param string|null $name
     * @return int
     */
    public function id(?string $name = null): int
    {
        return (int)$this->getPDO()->lastInsertId($name);
    }

    /**
     * @return mixed|\StdClass
     */
    public function first()
    {
        return $this->toObject();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->execute();
        if($this->statment === null){
            return [];
        }
        return $this->statment->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed|\StdClass
     */
    public function toObject()
    {
        $this->execute();
        if($this->statment === null){
            return new \StdClass();
        }
        return $this->statment->fetchObject();
    }

    /**
     * @return OnResultWithId
     * @throws SqlErrorException
     */
    public function execute(): OnResultWithId
    {
        if($this->exec) {
            return $this;
        }

        if ($this->isMissingDB()) {
            (new \Stafred\Database\ConnectionBuilder())->connect();
        }

        try {
            $this->statment = $this->getPDO()->prepare($this->getSql());
            $this->statment->execute($this->properties);
            $this->exec = true;
        }
        catch (\Throwable $e) {
            $this->code = $e->getCode();
            $this->error = "SQL query: (" . $this->sql . "). ". $e->getMessage();
            throw new SqlErrorException($this->error);
        }

        $error = $this->statment->errorInfo();
        $this->code = $error[1];
        $this->error = "SQL query: (" . $this->sql . "). " . $error[2];
        $this->count = $this->statment->rowCount();
        if($this->code != null) {
            throw new SqlErrorException($this->error);
        }
        return $this;
    }

    protected function getSql()
    {
        if ($this->sql != null) return $this->sql;
        if ($this->event == 'select') {
            $this->sqlSelect();
            $this->sqlFrom();
            $this->sqlWheres();
        }
        else if ($this->event == 'update') {
            $this->sqlUpdate();
            $this->sqlSet();
            $this->sqlWheres();
        }
        else if($this->event == 'insert') {
            $this->sqlInsert();
            $this->sqlTables();
            $this->sqlIntoColumns();
            $this->sqlIntoValues();
        }
        return $this->sql;
    }

    protected function sqlSelect()
    {
        $this->sql = 'SELECT ' . implode(",", $this->columns) . ' ';
    }

    protected function sqlFrom()
    {
        $this->sql .= 'FROM ' . implode(", ", $this->tables) . ' ';
    }

    protected function sqlUpdate()
    {
        $this->sql = 'UPDATE ' . $this->update;
    }

    protected function sqlInsert()
    {
        $this->sql = 'INSERT INTO ';
    }

    protected function sqlTables()
    {
        $this->sql .= implode(', ', $this->tables) . ' ';
    }

    protected function sqlSet()
    {
        if ($this->set != null) {
            $this->sql .= ' SET ';
            $this->sql .= implode(", ", $this->set);
        }
    }

    protected function sqlIntoColumns()
    {
        $this->sql .= '(' . implode(', ', $this->columns) . ')';
    }

    protected function sqlIntoValues()
    {
        $this->sql .= ' VALUES ' . implode(', ', $this->values);
    }

    protected function sqlWheres()
    {
        $sql = null;
        foreach ($this->wheres as $where) {
            $sql .= $where->sql . ' ' . $where->expr . ' ';
        }
        if($sql != null) {
            $sql = ' WHERE ' . $sql;
        }
        $this->sql .= preg_replace("/(\s*|\s*AND\s*|\s*OR\s*)$/i", "", $sql);
    }

    /**
     * @param string $key
     * @param array $patterns
     * @return string
     */
    protected function renameKey(string $key, array $patterns = []): string
    {
        if (array_key_exists($key, $patterns)) {
            return $patterns[$key];
        }
        return $key;
    }

    /**
     * @return string
     */
    protected function getKeyPDO(): string
    {
        return DATABASE_DRIVER . DATABASE_HOST . DATABASE_NAME;
    }

    /**
     * @return \PDO
     */
    protected function getPDO(): \PDO
    {
        return Buffer::input()->db($this->getKeyPDO());
    }

    protected function isMissingDB()
    {
        return empty(DATABASE_PRELOAD);
    }
}