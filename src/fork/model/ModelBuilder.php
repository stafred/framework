<?php

namespace Stafred\Model;

use App\Models\Kernel\Debug;
use Stafred\Utils\DB;

/**
 * Class ModelBuilder
 * @package Stafred\Model\Model
 */
class ModelBuilder extends ModelHelper
{
    /**
     * @var string
     */
    private string $table = '';

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function query()
    {

    }

    public function select()
    {

    }

    public function insert()
    {

    }

    public function update()
    {

    }

    /**
     * where: column => [expression, value, ]
     * @param array $where
     * @return \Stafred\Database\Mysql\QueryWrapper
     */
    public function delete(...$where): \Stafred\Database\Mysql\QueryWrapper
    {
        $helper = $this->where($where);
        return DB::delete($this->table, $helper["where"], $helper["parameters"]);
    }

    protected function run(){

    }
}