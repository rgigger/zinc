<?php
class Gui
{
	public $driver;
	
	function __construct($driverName = null)
	{
		if(!$driverName)
			$driverName = Config::get('zinc.gui.driver');
		
		$className = 'Gui' . ucfirst($driverName);
		$this->driver = new $className();
		$this->init();
	}
	
	public function init()
	{
	}
	
	public function setLayout($layout)
	{
		$this->driver->setLayout($layout);
	}
	
	public function fetch($templateName)
	{
		return $this->driver->fetch($templateName);
	}
	
	public function display($templateName)
	{
		if(defined('script_url'))
			$this->assign('scriptUrl', script_url);
		if(defined('ssl_script_url'))
			$this->assign('sslScriptUrl', ssl_script_url);
		if(defined('base_url'))
			$this->assign('baseUrl', base_url);
		if(defined('virtual_url'))
			$this->assign('virtualUrl', virtual_url);
		if(defined('ssl_virtual_url'))
			$this->assign('sslVirtualUrl', ssl_virtual_url);
		
		$this->driver->display($templateName);
	}
	
	public function assign($name, $value)
	{
		$this->driver->assign($name, $value);
	}
}
