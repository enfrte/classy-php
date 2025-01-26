# classy-php

A collection of classes to make developing quick ideas a bit easier.

## Router 

* Handles the routing of HTTP requests to the appropriate controller and method. 
* Hopefully detects if the app is running in a sub folder. 
* Method args should be passed as `$_GET` parameters.
* Example: `/Controller/method?foo=123&bar=asdf`

## Request

A simple wrapper around PHP's superglobals to make it easier to work with request data.

## Model 

An easy way to work with a relational database. 

## Config

A place to read and set configuration values.