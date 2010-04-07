<?php
class Gui
{
	private $driver;
	
	function __construct($driverName = null)
	{
		if(!$driverName)
			$driverName = Config::get('zoop.gui.driver');
		
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
		$this->driver->display($templateName);
	}
	
	public function assign($name, $value)
	{
		$this->driver->assign($name, $value);
	}
}
