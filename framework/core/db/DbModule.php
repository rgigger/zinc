<?php
class DbModule extends ZincModule
{
	private static $connections = array();
	
	/**
	 * Returns a DbConnection object to the database called "$name"
	 *
	 * @param string $name
	 * @return DbConnection
	 */
	static function getConnection($name)
	{
		if(!isset(self::$connections[$name]))
			trigger_error("connection '$name' does not exist");
		return self::$connections[$name];
	}
	
	/**
	 * Returns a DbConnection object for the default database connection
	 *
	 * @return DbConnection
	 */
	static function getDefaultConnection()
	{
		return self::getConnection('default');
	}
	
	/**
	 * This method is overridden to tell zinc which files to include with this module
	 *
	 * @return array of filenames to include
	 */
	function getIncludes()
	{
		return array('functions.php');
	}
	
	protected function init()
	{
		$this->addClass('DbConnection');
		$this->addClass('DbFactory');
		$this->addClass('DbSchema');
		$this->addClass('DbObject');
		$this->addClass('DbZone');
		$this->addClass('DbTable');
		$this->addClass('DbField');
		$this->addClass('DbPdo');
		$this->addClass('DbPdoResult');
		$this->addClass('DbPgsql');
		$this->addClass('DbPgResult');
		$this->addClass('DbMysql');
		$this->addClass('DbMysqlResult');
		$this->addClass('DbMssql');
		$this->addClass('DbMssqlResult');
		$this->addClass('DbResultSet');
		$this->addClass('DbRelationshipBelongsTo');
		$this->addClass('DbRelationshipBasic');
		$this->addClass('DbRelationship');
		$this->addClass('DbRelationshipHasMany');
		$this->addClass('DbRelationshipHasOne');
		$this->addClass('DbRelationshipOptions');
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
				self::$connections[$name] = DbFactory::getConnection($params, $name);
	}
}

function db($connectionName)
{
	return DbModule::getConnection($connectionName);
}