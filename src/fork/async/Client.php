<?php

namespace Stafred\Async;

interface Client
{
    /**
     * @param string $url
     * @param array $data
     */
    public function route(string $url, array $data): void;

    /**
     * @param array $data
     */
    public function header(array $data): void;
    /**
     * @param bool $read
     */
    public function run(bool $read = false): void;

    /**
     * @return bool
     */
    public function shutdown(): bool;

    public function close(): void;
}