<?php

namespace Stafred\Database;
/**
 * Class ConnectionHelper
 * @package Stafred\Database
 */
class ConnectionHelper
{
    /**
     * @var null|String
     */
    private $driver;
    /**
     * @var null|String
     */
    private $host;
    /**
     * @var int
     */
    private $port;
    /**
     * @var null|String
     */
    private $user;
    /**
     * @var null|String
     */
    private $password;
    /**
     * @var null|String
     */
    private $name;
    /**
     * @var null|String
     */
    private $charset;
    /**
     * @var null|\PDO
     */
    private $pdo;
    /**
     * @var null|String
     */
    private $key;

    /**
     * @param String|null $driver
     */
    public function setDriver(?String $driver): void
    {
        $this->driver = $driver;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port = 3306): void
    {
        $this->port = $port;
    }

    /**
     * @param String|null $host
     */
    public function setHost(?String $host): void
    {
        $this->host = $host;
    }

    /**
     * @param String|null $password
     */
    public function setPassword(?String $password): void
    {
        $this->password = $password;
    }

    /**
     * @param String|null $name
     */
    public function setName(?String $name): void
    {
        $this->name = $name;
    }

    /**
     * @param String|null $charset
     */
    public function setCharset(?String $charset): void
    {
        $this->charset = $charset;
    }

    /**
     * @param String|null $user
     */
    public function setUser(?String $user): void
    {
        $this->user = $user;
    }

    /**
     * @return String|null
     */
    public function getDriver(): ?String
    {
        return $this->driver;
    }

    /**
     * @return String|null
     */
    public function getHost(): ?String
    {
        return $this->host;
    }

    /**
     * @return String|null
     */
    public function getUser(): ?String
    {
        return $this->user;
    }

    /**
     * @return String|null
     */
    public function getPassword(): ?String
    {
        return $this->password;
    }

    /**
     * @return String|null
     */
    public function getName(): ?String
    {
        return $this->name;
    }

    /**
     * @return String|null
     */
    public function getCharset(): ?String
    {
        return $this->charset;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param string $driver
     * @param int $port
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $name
     */
    public function setAll(
        string $driver,
        string $host,
        int $port,
        string $user,
        string $password,
        string $name,
        string $charset)
    {
        $this->driver = $driver;
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->name = $name;
        $this->charset = $charset;
    }

    /**
     * @return object
     */
    public function getAll(): object
    {
        return (object)[
            "driver" => $this->driver,
            "host" => $this->host,
            "port" => $this->port,
            "user" => $this->user,
            "password" => $this->password,
            "name" => $this->name,
        ];
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        return
            $this->getDriver() .
            $this->getHost() .
            $this->getName();
    }

    /**
     * @return string
     */
    protected function dns()
    {
        return $this->driver .
            ":host=" . $this->host .
            ";port=" . $this->port .
            ";dbname=" . $this->name .
            ";charset=" . $this->charset;
    }

    /**
     * @return bool
     */
    protected function isNameEmpty(): bool
    {
        return empty($this->name);
    }
}