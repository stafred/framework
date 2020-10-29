<?php

namespace Stafred\Async\Server;

use Stafred\Utils\Http;

class Request
{
    /**
     * @var string
     */
    private $pure = '';

    /**
     * @var false|string|null
     */
    private $async;

    public function __construct()
    {
        $this->avoid();

        $this->pure  = $_GET["async"] ?? NULL;
        $this->async = $this->inflate($this->pure);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->async);
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return json_decode($this->get(), true);
    }

    /**
     * @return false|string|null
     */
    public function get()
    {
        return $this->async;
    }

    /**
     * @return string
     */
    public function pure(): string
    {
        return $this->pure;
    }

    private function avoid()
    {
        $async = env("async.host") . ":" . env("async.port");
        $sync  = Http::getServerIp() . ":" . Http::getServerPort();

        if($async != $sync) {
            throw new \Exception('Only async request', 423);
        }
    }

    /**
     * @param string|null $get
     * @return false|string|null
     */
    private function inflate(?string $get)
    {
        return empty($get) ? NULL : gzinflate(base64_decode($this->pure));
    }
}