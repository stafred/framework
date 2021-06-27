<?php


namespace Stafred\Database\Mysql;

/**
 * Class OnQuery
 * @package Stafred\Database\Mysql
 */
final class OnQuery extends OnQueryAbstract
{
    /**
     * OnQuery constructor.
     */
    public function __construct()
    {

    }

    public function __destruct()
    {
        $this->execute();
    }
}