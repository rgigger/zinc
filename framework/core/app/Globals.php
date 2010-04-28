<?php
/**
 * app::config.php
 *
 * @author Rick Gigger
 * @version $Id$
 * @copyright __MyCompanyName__, 16 February, 2007
 * @package app
 **/

//////////////////////////////////////////////
//
//	What we really want here is to define the following contants:
//
//	1) script_url		the url up to index.php or whatever the script name is
//	2) virtual_path		the virtual path.  this comes directly after scriptname.php
//	3) virtual_url		the url up through index.php and also the virtual path
//
//////////////////////////////////////////////
// echo_r($_SERVER);
if(php_sapi_name() != "cli")
{
	if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
		$protocol = 'https://';
	else
		$protocol = 'http://';
	$sslProtocol = 'https://';
	

	$host = $_SERVER['HTTP_HOST'];
	
	$virtualPath = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : (isset($_SERVER["ORIG_PATH_INFO"]) ? $_SERVER["ORIG_PATH_INFO"] : '');
	//	what other situations besides mod_rewrite set this to 200?
	if(isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == 200)
	{
		$uri = $_SERVER['REQUEST_URI'];
		if($pos = strpos($uri, '?'))
			$uri = substr($uri, 0, $pos);
		
		if( $virtualPath && substr($uri, 0-strlen($virtualPath)) == $virtualPath )
			$realPath = substr($uri, 0, strlen($uri) - strlen($virtualPath));
		else
			$realPath = $_SERVER['SCRIPT_NAME'];
	}
	else
	{
		$realPath = $_SERVER['SCRIPT_NAME'];
	}
	
	define('root_url', $protocol . $host);
	define('ssl_root_url', $sslProtocol . $host);
	if(defined('script_url'))
	{
		define('back_script_url', root_url . $realPath);
		define('back_virtual_url', back_script_url . $virtualPath);
		define('back_pub_url', dirname(back_script_url) . '/public');
	}
	else
	{
		define('script_url', root_url . $realPath);
		define('ssl_script_url', ssl_root_url . $realPath);
	}
	
	define('app_url', dirname(script_url));
	
	if(isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == 200)
		define('base_url', script_url . '/');
	else
		define('base_url', script_url);
	
	define('virtual_path', $virtualPath);
	define('virtual_url', script_url . virtual_path);
	define('ssl_virtual_url', ssl_script_url . virtual_path);
}

if(!defined('E_DEPRECATED'))
	define('E_DEPRECATED', 8192);

define('version_53', version_compare(PHP_VERSION, '5.3.0') >= 0 ? true : false);
