<?php

namespace Stafred\Controller;

use Stafred\Cache\Buffer;
use Stafred\Controller\SearchRoute;
use Stafred\Exception\Routing\RoutingControllerNoNameException;
use Stafred\Exception\Routing\RoutingInvalidControllerNameException;
use Stafred\Exception\Routing\RoutingInvalidMethodNameException;

/**
 * Class ControllerMapper
 * @package Stafred\Controller
 */
final class ControllerMapper
{
    private $buffer = [];
    private $request = [];
    private $routes = [];
    private $controller = '';
    private $method = '';

    public function __construct()
    {
        $this->request = Buffer::input()->getAll()->request();
        $this->buffer = Buffer::input()->getAll()->routing();
        $this->route = $this->setRoute()->getResult();
        $this->controller = $this->setController();
        $this->method = $this->setMethod();
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->route["args"]["name"];
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->route["args"]["value"];
    }

    /**
     * @return string
     */
    public function setController(): string
    {
        preg_match(
            "/^(?<controller>[_a-z][_a-z0-9]*)(::|@|->)/i",
            $this->route['controller_method'], $matcher
        );
        $controller = $matcher["controller"] ?? NULL;
        if(empty($controller)){
            throw new RoutingInvalidControllerNameException();
        }
        return $controller;
    }

    /**
     * @return string
     */
    public function setMethod(): string
    {
        preg_match(
            "/(::|@|->)(?<method>[_a-z][_a-z0-9]*)$/i",
            $this->route['controller_method'], $matcher
        );
        $method = $matcher["method"] ?? NULL;
        if(empty($method)){
            throw new RoutingInvalidMethodNameException();
        }
        return $method;
    }

    /**
     * @return \Stafred\Controller\SearchRoute
     */
    public function setRoute()
    {
        $this->setRequestResource();
        return new SearchRoute(
            $this->request['urn'],
            $this->request['request'],
            $this->buffer
        );
    }

    private function setRequestResource()
    {
        $resource = explode("/", $this->request['urn']);
        $this->request['request']['resource'] = array_values(array_diff($resource, array('', NULL, "\0")));
    }
}