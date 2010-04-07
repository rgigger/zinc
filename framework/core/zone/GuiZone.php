<?php
class GuiZone extends Zone
{
	protected $displayed = false;
	protected $baseDir = NULL;
	protected $guiClass, $guiDriver, $layout;
	private $assigns = array();
	
	public function init($requestInfo = NULL, $params = array())
	{
		parent::init($requestInfo, $params);
	}
	
	public function setBaseDir($dir)
	{
		$this->baseDir = $dir;
	}
	
	public function getBaseDir()
	{
		return $this->baseDir;
	}
	
	protected function chooseGui($type)
	{
		//	if they want something different they need to extend this class
		assert($type === NULL);
		
		if($this->guiClass)
			$className = $this->guiClass;
		else if(Config::get('zoop.gui.class'))
			$className = Config::get('zoop.gui.class');
		else if(class_exists('AppGui'))
			$className = 'AppGui';
		else
			$className = 'Gui';
		
		return new $className($this->guiDriver);
	}
	
	protected function getTemplateDir()
	{
		$className = get_class($this);
		$zoneName = strtolower(substr($className, 4));
		return $zoneName;
	}
	
	function assign($name, $value)
	{
		$this->assigns[$name] = $value;
	}
	
	function displayed()
	{
		return $this->displayed;
	}
	
	function display($templateName, $guiType = NULL)
	{
		$gui = $this->chooseGui($guiType);
		$gui->setLayout($this->layout);
		
		foreach($this->assigns as $name => $value)
			$gui->assign($name, $value);
		
		if(defined('script_url'))
			$gui->assign('scriptUrl', script_url);
		if(defined('ssl_script_url'))
			$gui->assign('sslScriptUrl', ssl_script_url);
		if(defined('base_url'))
			$gui->assign('baseUrl', base_url);
		if(defined('virtual_url'))
			$gui->assign('virtualUrl', virtual_url);
		if(defined('ssl_virtual_url'))
			$gui->assign('sslVirtualUrl', ssl_virtual_url);
		$gui->assign('zoneUrl', $this->getUrl());
 		
		if(!$this->baseDir)
			$dirName = $this->getTemplateDir();
		else
			$dirName = $this->baseDir;
		$gui->display($dirName . '/'. $templateName . '.tpl');
		$this->displayed = true;
	}
}
