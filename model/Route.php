<?php

/**
 * Class route
 */
class Route{


    private $method;
    private $controller;
    private $function;
    private $url;

    private static $arrayOfRoutesGET = [];
    private static $arrayOfRoutesPOST = [];

    /**
     * route constructor.
     * @param $method
     * @param $url
     * @param $controller
     * @param $function
     */
    public function __construct($method, $url, $controller, $function)
    {
        $this->method = $method;
        $this->controller = $controller;
        $this->function = $function;
        $this->url = $url;
    }

    /**
     * @param $url
     * @param $controller
     * @param $function
     */
    public static function get($url, $controller, $function){
        global $arrayOfRoutesGET;
        $routeInstance = new route("GET", $url, $controller, $function);
        self::$arrayOfRoutesGET[] = $routeInstance;
    }

    /**
     * @param $url
     * @param $controller
     * @param $function
     */
    public static function post($url, $controller, $function){
        global $arrayOfRoutesPOST;
        $routeInstance = new route("POST", $url, $controller, $function);
        self::$arrayOfRoutesPOST[] = $routeInstance;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $view
     */
    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param mixed $function
     */
    public function setFunction($function): void
    {
        $this->function = $function;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public static function getArrayOfRoutesGET(): array
    {
        return self::$arrayOfRoutesGET;
    }

    /**
     * @return array
     */
    public static function getArrayOfRoutesPOST(): array
    {
        return self::$arrayOfRoutesPOST;
    }

    public function __toString()
    {
        return "Controller: ".$this->getController().'; Function: '.$this->getFunction().'; Method: '.$this->getMethod().'; Function: '.$this->getFunction();
    }


}