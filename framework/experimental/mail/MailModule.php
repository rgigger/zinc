<?php
class MailModule extends ZoopModule
{
	private static $connections = array();
	
	/**
	 * Returns a MailConnection identified in the config as "$name"
	 *
	 * @param string $name
	 * @return MailConnection
	 */
	static function getConnection($name)
	{
		if(!isset(self::$connections[$name]))
			trigger_error("connection '$name' does not exist");
		return self::$connections[$name];
	}
	
	/**
	 * Returns a MailConnection object for the default database connection
	 *
	 * @return MailConnection
	 */
	static function getDefaultConnection()
	{
		return self::getConnection('default');
	}
	
	protected function init()
	{
		$this->addClasses(array('MailConnection', 'MailFactory', 'MailSwift', 'MailMessage', 'GuiMessage'));
	}
	
	/**
	 * This method is overridden to tell zinc which files to include with this module
	 *
	 * @return array of filenames to include
	 */
	function getIncludes()
	{
		return array();
	}
	
	/**
	 * This method reads the configuration options (using the getConfig method)
	 * and initializes the database connections.
	 *
	 */
	function configure()
	{
		$connections = $this->getConfig();
		if($connections)
			foreach($connections as $name => $params)
				self::$connections[$name] = MailFactory::getConnection($params, $name);
	}
}
