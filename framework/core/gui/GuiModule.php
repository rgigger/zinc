<?php
class GuiModule extends ZoopModule
{
	static private $instances = array();
	
	/**
	 * Returns a Gui instance in the config as "$name"
	 *
	 * @param string $name
	 * @return Gui -- this should actually be an interface that everything implements
	 */
	static function getInstance($name = 'default')
	{
		if(!isset(self::$instances[$name]))
			trigger_error("instance '$name' does not exist");
		return self::$instances[$name];
	}
	
	/**
	 * Returns the default Gui instance
	 *
	 * @return Gui
	 */
	static function getDefaultInstance()
	{
		return self::getConnection();
	}
	
	protected function init()
	{
		$this->addClass('Gui');
		$this->depend('smarty2');
		$this->depend('smarty3');
		// $this->addInclude('utils.php');
		$this->addClass('GuiFactory');
		$this->addClass('GuiDriver');
		$this->addClass('GuiSmarty2');
		$this->addClass('GuiSmarty3');
		$this->addClass('LayoutHandler');
		$this->addClass('SmartyCustomInternalTemplate');
		$this->hasConfig = true;
	}
	
	/**
	 * This method reads the configuration options (using the getConfig method)
	 * and initializes the database connections.
	 *
	 */
	function configure()
	{
		$instances = $this->getConfig();
		if($instances)
			foreach($instances as $name => $params)
				self::$instances[$name] = GuiFactory::getConnection($params, $name);
	}	
}
