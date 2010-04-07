<?php
/**
 * Object extends the Smarty templating system to allow easy separation of business and
 * presentation logic
 *
 */
class GuiSmarty3 extends Smarty
{
	function __construct()
	{
		$config = GuiModule::sGetConfig();
		$tmpPath = Zoop::getTmpDir();
		
		//	call the parent contructor
		parent::__construct();
		$this->template_dir = array();
   		
   		//	set the default for the base template dir
		//	this should be using the new config stuff, not defines
   		if(!defined("gui_template_dir") )
   			define("gui_template_dir", app_dir . "/templates");
   		
   		//	set the standard template directory and any others registerd with zoop
   		$this->addTemplateDir(gui_template_dir);
		
		//	set the compile directory
		$this->setCompileDir($tmpPath . "/smarty2");
		
		//	set the cache_dir directory
		//	what does this even do?  I'm pretty sure that is not set up
		$this->setCacheDir($tmpPath . "/guicache");
		
		//	set the config directory
		//	what does this even do?  I'm pretty sure that is not set up
		$this->setConfigDir(app_dir . "/guiconfig");
		
		//	set the plugin directories
		$this->addPluginsDir(dirname(__file__) . '/plugins');	//	one for plugins added into gui
		$this->addPluginsDir(app_dir . "/guiplugins");			//	one or plugins specific to the app
	}	
}
