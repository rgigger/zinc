<?php
class ZoneApplication extends Application
{
	function __construct()
	{
		if(ini_get('magic_quotes_gpc'))
		{
			StripMagicQuotesFromPost();
			StripMagicQuotesFromGet();
		}
	}
	
	static function loadZone($name)
	{
		$name = ucfirst($name);
		include(app_dir . "/zones/Zone$name.php");
	}
	
	function handleRequest()
	{
		self::loadZone('default');
		
		//	get the path parts
		$pathParts = explode('/', virtual_path);
		array_shift($pathParts);
		
		//	special case: see if we need to dish out a static page from a zoop module
		if(isset($pathParts[0]) && $pathParts[0] == 'modpub')
		{
			$this->handleStaticFile($pathParts);
		}
		else
		{
			//	handle the request
			$zoneDefault = new ZoneDefault();
			$zoneDefault->init();
			$zoneDefault->handleRequest($pathParts);
		}
	}
	
	function handleStaticFile($pathParts)
	{
		array_shift($pathParts);
		$modName = str_replace('..', '', array_shift($pathParts));
		$staticPath = str_replace('..', '', implode('/', $pathParts));
		$filePath = zoop_dir . "/$modName/public/" . $staticPath;
		header('Cache-Control: max-age=315360000');
		header("Pragma: public");
		header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 3600) . " GMT");
		EchoStaticFile($filePath);
	}
}
