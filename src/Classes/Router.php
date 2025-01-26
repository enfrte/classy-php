<?php

namespace ClassyPhp\Classy\Classes;

/**
 * This file contains the Router class which is responsible for handling
 * the routing of HTTP requests to the appropriate controller and action.
 */
class Router {
	private $defaultController = '';
	private $defaultMethod = '';
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

        $this->controller = !empty($path[0]) ? $path[0] : $this->defaultController;
        $this->method = !empty($path[1]) ? $path[1] : $this->defaultMethod;
    }

    public function getController() {
		if (empty($this->controller)) {
			return $this->defaultController;
		}
        return $this->controller;
    }

    public function getMethod() {
		if (empty($this->method)) {
			return $this->defaultMethod;
		}
        return $this->method;
    }

	public function setDefaultRoute($controller, $method) {
		$this->defaultController = $controller;
		$this->defaultMethod = $method;
	}

	public function addRoute($controller, $method) {
		$this->routes[$controller] = $method;
	}
}