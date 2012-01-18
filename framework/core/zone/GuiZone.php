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
	
	protected function chooseGui()
	{
		return new AppGui();
		
		// I will put this back in once we actually run into a situation where we want this flexibility and understand
		// better how we want it to be implemented
		// 
		// if($this->guiClass)
		// 	$className = $this->guiClass;
		// else if(class_exists('AppGui'))
		// 	$className = 'AppGui';
		// else
		// 	$className = 'Gui';
		// 
		// return new $className($this->guiDriver);
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
	
	function display($templateName, $depricated = NULL)
	{
		// this is a depricated paramater so throw and error if someone is still using it
		assert($depricated === NULL);
		
		$gui = $this->chooseGui();
		$gui->setLayout($this->layout);
		
		foreach($this->assigns as $name => $value)
			$gui->assign($name, $value);
		
		$gui->assign('zoneUrl', $this->getUrl());
 		
		if(!$this->baseDir)
			$dirName = $this->getTemplateDir();
		else
			$dirName = $this->baseDir;
		$gui->display($dirName . '/'. $templateName . '.tpl');
		$this->displayed = true;
	}
}
