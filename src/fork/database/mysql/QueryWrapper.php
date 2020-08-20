<?php

namespace Stafred\Database\Mysql;

/**
 * Class QueryWrapper
 * @package Stafred\Database\Mysql
 */
final class QueryWrapper extends QueryService
{
    /**
     * QueryWrapper constructor.
     * @param array $query
     * @param array|NULL $parameters
     * @param string|NULL $operations
     */
    public function __construct(
        array $query,
        array $parameters = NULL,
        string $operations = NULL,
        bool $security = true
    )
    {
        $this->security = $security;

        if (empty($operations)) {
            $this->primary($query, $parameters ?? []);
        } else {
            $this->slave($query, $parameters ?? [], $operations);
        }
    }
}