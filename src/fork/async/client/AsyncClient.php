<?php

namespace Stafred\Async\Client;

/**
 * Interface AsyncClient
 * @package Stafred\Async\Client
 */
interface AsyncClient
{
    /**
     * @return string
     */
    public function getSessionId(): string;
    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId): void;
    /**
     * @param string $controller_method
     * @return mixed
     */
    public function action(string $controller_method);
    /**
     * @param array $identifiers
     * @return mixed
     */
    public function request(array $identifiers): string;

    public function connect();
    public function run(bool $read): void;
}