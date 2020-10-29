<?php

namespace Stafred\Async\Server;

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
}