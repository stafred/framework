<?php

namespace Stafred\Async\Server;

use Stafred\Utils\Http;

/**
 * Class Handler
 * @package Stafred\Async
 */
class Handler
{
    /**
     * @var Request
     */
    private $resuest;

    /**
     * Handler constructor.
     * @param AsyncRequest $request
     */
    public function __construct(Request $request)
    {
        $this->resuest = $request;
    }

    public function run()
    {
        if(!$this->resuest->isEmpty()){
            file_put_contents("test", $this->resuest->get()."\n");
        }

        var_dump($this->resuest->toArray());
    }

    public function avoid()
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
    public function inflate(?string $get)
    {
        return empty($get) ? NULL : gzinflate(base64_decode($this->pure));
    }
}