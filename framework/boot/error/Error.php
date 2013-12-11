<?php
/**
 * class Error Handler
 *
 * @package app
 * @author Rick Gigger
 **/

error_reporting(E_ALL & ~E_STRICT);

Class ErrorSettings
{
	static private $mode; // should be either web or cli
	
	static public function setDisplayMode($mode)
	{
		self::$mode = $mode;
	}
	
	static public function getDisplayMode()
	{
		return self::$mode;
	}
}

if(php_sapi_name() == "cli")
{
	ErrorSettings::setDisplayMode('cli');
	include(zoop_dir . '/boot/error/CliErrorHandler.php');
	set_error_handler(array("CliErrorHandler", "handleError"), E_ALL);
	// set_error_handler(array("CliErrorHandler", "throwException"), E_ALL);
	set_exception_handler(array("CliErrorHandler", "exceptionHandler"));
}
else
{
	ErrorSettings::setDisplayMode('web');
	include(zoop_dir . '/boot/error/WebErrorHandler.php');
	// set_error_handler(array("WebErrorHandler", "throwException"), E_ALL);
	set_error_handler(array("WebErrorHandler", "handleError"), E_ALL);
	set_exception_handler(array("WebErrorHandler", "exceptionHandler"));
}
