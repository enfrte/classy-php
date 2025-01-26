<?php

namespace ClassyPhp\Classy\Classes;

class Config
{
	private static $config = [
		// Database configuration
		'db_driver' => 'sqlite',
	
		// If using sqlite
		'db_path' => '/home/me/dev/go/blogog/example.db',
		// If using mysql
		'db_host' => '',
		'db_name' => '',
		'db_user' => '',
		'db_pass' => ''
	];

	public function __construct() {}

	public static function get($key, $default = null)
	{
		return isset(self::$config[$key]) ? self::$config[$key] : $default;
	}

	public static function set($key, $value)
	{
		self::$config[$key] = $value;
	}
}
?>