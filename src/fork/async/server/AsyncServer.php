<?php

namespace Stafred\Async\Server;

interface AsyncServer
{
    /**
     * @return string
     */
    public function getSessionId(): string;
    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId): void;

    public function start(): void;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return mixed
     */
    public function toArray();

    /**
     * @return false|string|null
     */
    public function get();

    /**
     * @return string
     */
    public function pure(): string;

    /**
     * @param Request $request
     */
    public function bindRequest(Request $request);
}