<?php

namespace ClassyPhp\Classy\Classes;

/**
 * This file contains the Router class which is responsible for handling
 * the routing of HTTP requests to the appropriate controller and action.
 */
class Router {
    private $controller;
    private $method;
	private $routes = [];

    public function __construct() {
        $this->parseUrl();
    }

    private function parseUrl() {
        $requestScriptName = $_SERVER['SCRIPT_NAME'];
        $requestUrl = $_SERVER['REDIRECT_URL'];

        $scriptParts = explode('/', $requestScriptName);
        $urlParts = explode('/', $requestUrl);

        $path = array_values(array_diff($urlParts, $scriptParts));

        $this->controller = isset($path[0]) ? $path[0] : 'defaultController';
        $this->method = isset($path[1]) ? $path[1] : 'defaultMethod';
    }

    public function getController() {
        return $this->controller;
    }

    public function getMethod() {
        return $this->method;
    }

	public function setDefaultRoute($controller, $method) {
		$this->controller = $controller;
		$this->method = $method;
	}

	public function addRoute($controller, $method) {
		$this->routes[$controller] = $method;
	}
}