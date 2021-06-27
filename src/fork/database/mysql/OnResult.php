<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnResult
 * @package Stafred\Database\Mysql
 */
interface OnResult
{
    /**
     * @return string
     */
    public function toSql(): string;

    /**
     * @return array
     */
    public function toProperties(): array;

    /**
     * @return string
     */
    public function toError(): string;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return mixed|\StdClass
     */
    public function first();

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return mixed
     */
    public function toObject();
}