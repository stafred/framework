<?php


namespace Stafred\Database\Mysql;

/**
 * Class OnQueryFields
 * @package Stafred\Database\Mysql
 */
abstract class OnQueryFields
{
    /**
     * @var bool
     */
    protected bool $exec = false;

    /**
     * @var \PDOStatement|null
     */
    protected ?\PDOStatement $statment = null;
    /**
     * @var string
     */
    protected string $event = '';
    /**
     * @var string|null
     */
    protected ?string $error = '';
    /**
     * @var null
     */
    protected $code = null;
    /**
     * @var int
     */
    protected int $count = 0;

    /**
     * @var string|null
     */
    protected ?string $sql = null;

    /**
     * @var string
     */
    protected string $select = '';

    /**
     * @var string
     */
    protected string $insert = '';

    /**
     * @var string
     */
    protected string $update = '';

    /**
     * @var array
     */
    protected array $tables = [];

    /**
     * @var array
     */
    protected array $form = [];

    /**
     * @var string
     */
    protected string $into = '';

    /**
     * @var array
     */
    protected array $columns = [];

    /**
     * @var array|null
     */
    protected ?array $set = null;
    /**
     * @var array
     */
    protected array $properties = [];
    /**
     * @var array
     */
    protected array $values = [];
    /**
     * @var array
     */
    protected array $wheres = [];
}