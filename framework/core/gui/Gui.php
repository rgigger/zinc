<?php
class Gui
{
	public $driver;
	
	function __construct($driverSpec = 'default')
	{
		if(is_string($driverSpec))
			$this->driver = GuiModule::getInstance($driverSpec);
		else if($driverSpec instanceof GuiDriver)
			$this->driver = $driverSpec;
		else
			$this->driver = GuiModule::getInstance();
	}
	
	public function init()
	{
	}
	
	public function setLayout($layout)
	{
		$this->driver->setLayout($layout);
	}
	
	public function autoInherit()
	{
		$this->driver->autoInherit();
	}
	
	private function assignUrlInfo()
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
	}
	
	public function fetch($templateName)
	{
		$this->assignUrlInfo();
		return $this->driver->fetch($templateName);
	}
	
	public function display($templateName)
	{
		$this->assignUrlInfo();
		$this->driver->display($templateName);
	}
	
	public function assign($name, $value)
	{
		$this->driver->assign($name, $value);
	}
}
