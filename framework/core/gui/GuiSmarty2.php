<?php
/**
 * Object extends the Smarty templating system to allow easy separation of business and
 * presentation logic
 *
 */
class GuiSmarty2 extends GuiDriver
{
	private $layout, $smarty;
	
	function init()
	{
		$this->smarty = new Smarty2();
		
		$config = $this->params;
		$tmpPath = Zinc::getTmpDir();
		
		$this->smarty->template_dir = array();
   		
   		//	set the default for the base template dir
		//	this should be using the new config stuff, not defines
   		if(!defined("gui_template_dir") )
   			define("gui_template_dir", app_dir . "/templates");
   		
   		//	set the standard template directory and any others registerd with zoop
   		$this->addTemplateDir(gui_template_dir);
		
		//	set the compile directory
		$modTmpDir = $tmpPath . '/smarty2';
		
		if(!is_dir($modTmpDir))
			mkdir($modTmpDir);
		$this->setCompileDir($modTmpDir);
		
		//	set the cache_dir directory
		//	what does this even do?  I'm pretty sure that is not set up
		$this->setCacheDir($tmpPath . "/guicache");
		
		//	set the config directory
		//	what does this even do?  I'm pretty sure that is not set up
		$this->setConfigDir(app_dir . "/guiconfig");
		
		//	set the plugin directories
		$this->addPluginDir(zinc_dir . '/vendor/smarty2/plugins');	//	one for plugins added into gui
		$this->addPluginDir(app_dir . "/guiplugins");			//	one or plugins specific to the app
		
//		$this->smarty->default_modifiers = array('escape:"htmlall"');
		
		$this->smarty->error_reporting = E_ALL;
		
		//	we shouldn't use the blanket app_status define any more, we should use specific varabiles
		//	for each behavior, and it should use the new config system
		// $smarty->debugging = defined('app_status') && app_status == 'dev' ? true : false;
		// $smarty->compile_check = defined('app_status') && app_status == 'dev' ? true : false;
		
		//	we want to run this filter on every single smarty script that we execute
		//	it finds all places where we echo out a simple variable and escapes the html
		//
		//	unfortunately this filters everything.  The entire contents if the template.  I think it is escaping include.
		//	If we can get it to not do that then we can put this back in.
		//
		//$this->smarty->autoload_filters = array('pre' => array("strip_html"));
	}
	
	public function getRequireds()
	{
		return array();
	}
	
	public function getDefaults()
	{
		return array();
	}
	
	function setTemplateDir($inDir)
	{
		$this->smarty->template_dir = $inDir;
	}
	
	function addTemplateDir($inDir)
	{
		$this->smarty->template_dir[] = $inDir;
	}
	
	function setCompileDir($inDir)
	{
		$this->smarty->compile_dir = $inDir;
	}
	
	function setCacheDir($inDir)
	{
		$this->smarty->cache_dir = $inDir;
	}
	
	function setConfigDir($inDir)
	{
		$this->smarty->config_dir = $inDir;
	}
	
	function addPluginDir($inDir)
	{
		$this->smarty->plugins_dir[] = $inDir;
	}
	
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}
	
	public function assign($name, $value)
	{
		$this->smarty->assign($name, $value);
	}
	
	public function fetch($tpl_file, $cache_id = null, $compile_id = null, $display = false)
	{
		if($this->layout)
		{
			$this->smarty->assign("TEMPLATE_CONTENT", $tpl_file);
			return $this->smarty->fetch("layouts/{$this->layout}.tpl", $cache_id, $compile_id, $display);
		}
		
		return $this->smarty->fetch($tpl_file, $cache_id, $compile_id, $display);
	}
	
    function display($resource_name, $cache_id = null, $compile_id = null)
    {
        $this->fetch($resource_name, $cache_id, $compile_id, true);
    }
}
