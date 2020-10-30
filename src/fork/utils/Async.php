<?php

namespace Stafred\Utils;

use Stafred\Async\Helper;
use Stafred\Async\Client;
use Stafred\Async\Server;

/**
 * Class Async
 * @package Stafred\Utils
 */
final class Async extends Helper
{
    /**
     * Async constructor.
     */
    public function __construct()
    {
        $this->host = env("async.host");
        $this->port = env("async.port");
        $this->setsdn = env("async.shutdown");
        $this->setsdn = is_bool($this->setsdn) ? "shutdown" : $this->setsdn;
    }

    /**
     * @return Client
     */
    public function client(): Client
    {
        $this->session = Session::name();
        return $this;
    }

    /**
     * @return AsyncServer
     */
    public function server(): Server
    {
        return $this;
    }

    public function __destruct()
    {
        $this->close();
    }
}