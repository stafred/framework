<?php

namespace Stafred\Routing;

/**
 * Class RoutingHelper
 * @package Stafred\Routing
 */
class RoutingHelper extends RoutingConstants
{
    /**
     * @var string
     */
    protected $url = '';
    /**
     * @var array
     */
    protected $request = [];

    /**
     * RoutingHelper constructor.
     */
    protected function __construct()
    {
        $this->setUrl();
        $this->setRequest();
    }
    
    private function setUrl()
    {

    }
    private function setRequest()
    {

    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }
}