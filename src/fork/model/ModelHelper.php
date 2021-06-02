<?php

namespace Stafred\Model;

/**
 * Class ModelHelper
 * @package Stafred\Model
 */
class ModelHelper
{
    /**
     * @param array $data
     */
    protected function where(array $data)
    {
        $_where = [];
        $_param = [];

        foreach ($data as $k => $v){
            if(!isset($v[0])){
                throw new \Exception("expression not found", 500);
            }
            if(!isset($v[1])){
                throw new \Exception("value not found", 500);
            }
            $operator = isset($v[2]) ? " {$v[2]} " : "";

            $_where[] = "{$k}{$v[0]}?$operator";
            $_param[] = $v[1];
        }

        return [
            "where" => implode(" ", $_where),
            "parameters" => $_param
        ];
    }
}