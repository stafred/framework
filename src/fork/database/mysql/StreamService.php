<?php

namespace Stafred\Database\Mysql;

/**
 * Class StreamService
 * @package Stafred\Database\Mysql
 */
abstract class StreamService
{
    /**
     * @param bool $wait
     * @return bool|array
     */
    abstract function get(bool $wait = false);
    abstract function cache();
    abstract function toString();
    abstract function getProperties();

    /**
     * only server, only development
     * @invisible
     * @undoc
     * @param \PDO $pdo
     * @return \PDOStatement
     */
    /*abstract function _get_stream_(\PDO $pdo): \PDOStatement;*/
}