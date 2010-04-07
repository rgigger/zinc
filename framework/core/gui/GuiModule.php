<?php
class GuiModule extends ZoopModule
{
	static private $sConfig = null;
	
	protected function init()
	{
		$this->addClass('Gui');
		$this->depend('smarty');
		// $this->addInclude('utils.php');
		$this->addClass('GuiSmarty2');
		$this->addClass('GuiSmarty3');
		$this->hasConfig = true;
	}
	
	protected function configure()
	{
		self::$sConfig = $this->getConfig();
		
		$this->depend(self::$sConfig['driver']);
	}
	
	static public function sGetConfig()
	{
		return self::$sConfig;
	}	
}
