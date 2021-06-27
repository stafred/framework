<?php


namespace Stafred\Database\Mysql;

/**
 * Interface OnResultWithId
 * @package Stafred\Database\Mysql
 */
interface OnResultWithId
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
     * @param string|null $name
     * @return int
     */
    public function id(?string $name = null): int;
}