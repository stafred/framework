<?php

namespace Stafred\Async\Client;

/**
 * Class Pack
 * @package Stafred\Async
 */
final class Pack
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var string
     */
    private $session;
    /**
     * @var array
     */
    private $result = [];

    /**
     * Pack constructor.
     * @param string $token
     */
    public function __construct(string $token, string $session = NULL)
    {
        $this->token = $token;
        $this->session = $session;
    }

    /**
     * @param $event
     * @param $action
     * @param $method
     * @param $message
     * @return Pack
     */
    public function wrap($event, $action, $method, $message): Pack
    {
        $this->result[] = [
            //"token" => $this->token,
            "event" => $event,
            "action" => $action . "::" . $method,
            "message" => $message,
        ];
        return $this;
    }

    public function wrapObject(WrapObject $object): Pack
    {
        $this->result[] = $object->async($this->token);
        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->result;
    }
}