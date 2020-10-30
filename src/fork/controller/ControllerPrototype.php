<?php

namespace Stafred\Controller;

use Stafred\Cache\Buffer;
use Stafred\Exception\Routing\RoutingControllerNotFoundException;
use Stafred\Exception\Routing\RoutingControllerNoNameException;
use Stafred\Exception\Routing\RoutingMethodNotPublicException;


/**
 * Class ControllerPool
 * @package Stafred\Controller
 */
class ControllerPrototype
{
    /**
     * @var string
     */
    private $namespace = '';
    /**
     * @var string
     */
    private $controller = '';
    /**
     * @var string
     */
    private $method = '';
    /**
     * @var array
     */
    private $args = [];
    /**
     * @var array
     */
    private $values = [];
    /**
     * @var string
     */
    private $dir = 'App\\Controllers\\';
    /**
     * Controller constructor.
     * @param String $controller
     * @param String $method
     * @param array $args
     * @param array $values
     */
    public function __construct(ControllerMapper $data)
    {
        $this->namespace = $data->getNamespace();
        $this->controller = $data->getController();
        $this->method = $data->getMethod();
        $this->args = $data->getArgs();
        $this->values = $data->getValues();
    }

    /**
     * @throws \ReflectionException
     */
    public function start()
    {
        $this->controller = $this->dir  . $this->namespace . $this->controller;

        $this->injectClass();

        $refClass = new \ReflectionClass($this->controller);

        /*может проходит верхний регистр. это нужно отследить.*/
        if (empty($refClass)) {
            throw new \Exception('Сontroller not found'/*, 500*/);
        }

        $refMethod = new \ReflectionMethod($this->controller, $this->method);

        if (!$refMethod->isPublic()) {
            throw new RoutingMethodNotPublicException();
        }

        $getPrm = $refMethod->getParameters();
        $refArgs = [];
        $cArg = count($this->args);
        $cPrm = count($getPrm);

        for ($i = $cArg; $i < $cPrm; $i++) $refArgs = array_merge($getPrm);

        $refParams = new ReflectionParamsController($refArgs);
        $this->args = array_merge($this->args, $refParams->getParameters());
        $this->values = array_merge($this->values, $refParams->getParameters());

        $args = [];
        foreach ($refMethod->getParameters() as $refParam) {
            $typeArg = gettype($refParam->getClass());
            $nameArg = $refParam->name;

            foreach ($this->values as $key => $val) {
                $typeVal = gettype($val);
                $nameVal = $this->args[$key];
                if($typeVal === "object" && $typeArg === "object") {
                    if($refParam->getClass()->name === get_class($val)){
                        $args[] = $this->values[$key];
                    }
                }
                else if($typeVal === "string" && $typeArg === "NULL") {
                    if($refParam->name === $nameVal) {
                        $v = $this->values[$key];
                        $args[] = preg_match("/^[0-9]+$/", $v) ? intval($v) : $v;
                    }
                }
            }

        }
        $this->echoContent($refMethod, $args);
    }

    /**
     * need refactoring
     * @throws \Exception
     */
    private function injectClass()
    {
        if (empty($this->controller)) {
            throw new RoutingControllerNoNameException();
        }

        preg_match_all("/[a-z_0-9]+/i", $this->controller, $match);

        $str = '';

        /*need refactoring*/
        for ($i = 0, $c = count($match[0]); $i < $c; $i++) {
            if ($i < $c - 1) {
                $str .= strtolower($match[0][$i]) . '/';
                continue;
            }
            $str .= $match[0][$i];
        }

        $file = str_replace("\\", "/", dirname(__DIR__, 6) . '/' . $str) . ".php";



        if (!file_exists($file)) {
            throw new RoutingControllerNotFoundException();
        }

        require_once $file;
    }

    /**
     * @param \ReflectionMethod $refMethod
     * @param $values
     */
    private function echoContent(\ReflectionMethod $refMethod, $args)
    {
        $clazz = $refMethod->class;
        $refMethodContent = $refMethod->invokeArgs(new $clazz, $args);
        echo $refMethodContent;
    }
}