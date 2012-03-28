<?php
class CommandMigrations
{
	public function usage()
	{
		if(defined('instance_dir'))
			return array('[apply|redo] [migration|migrations]');
		else
			return array();
	}
	
	public function handleRequest($p)
	{
		Zinc::loadLib('migration');
		
		$methodName = "handle" . $p[1];
		
		if(method_exists($this, $methodName))
			$this->$methodName($p);
		else
			trigger_error("invalid command\n\n");
	}
	
	public function handleApply()
	{
		SqlBeginTransaction();
		
		//	make sure the migrations table exists
		Migration::initDB();
		
		//	have it scan the migrations directory for all available migrations
		$versions = Migration::getAllMigrationNames();
		
		//	query the db for applied migrations
		$applied = Migration::getAllAppiedMigrationNames();
		
		//	apply anything that hasn't been done yet, in the proper order
		$unapplied = array_diff($versions, $applied);
		
		foreach($unapplied as $key => $needsApplied)
		{
			Migration::apply($key, $needsApplied);
		}
		
		SqlCommitTransaction();
	}
	
	public function handleRedo($p)
	{
		$version = $p[3];
		SqlBeginTransaction();
		$filename = Migration::filenameFromVersion($version);
		Migration::undo($filename, $version);
		Migration::apply($filename, $version);
		SqlCommitTransaction();
		
		die();
	}
}
