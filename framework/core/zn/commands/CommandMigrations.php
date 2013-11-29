<?php
class CommandMigrations
{
	static public function usage()
	{
		if(defined('instance_dir'))
			return array('[apply|redo] [migration|migrations]', '[apply|redo] [seed|seeds]');
		else
			return array();
	}
	
	public function handleRequest($p)
	{
		Zinc::loadLib('migration');
		$methodName = "handle" . $p[1];
		var_dump($methodName);
		die();
		if(method_exists($this, $methodName))
			$this->$methodName($p);
		else
			trigger_error("invalid command\n\n");
	}
	
	public function handleApply($p)
	{
		if($p[2] == 'migrations')
			$type = 'migration';
		else if($p[2] == 'seeds')
			$type = 'seed';
		else
			trigger_error("invalid migration type: " . $p[2]);
		
		SqlBeginTransaction();
		
		//	make sure the migrations table exists
		Migration::initDB($type);
		
		//	have it scan the migrations directory for all available migrations
		$versions = Migration::getAllMigrationNames($type);
		
		//	query the db for applied migrations
		$applied = Migration::getAllAppiedMigrationNames($type);
		
		//	apply anything that hasn't been done yet, in the proper order
		$unapplied = array_diff($versions, $applied);
		
		foreach($unapplied as $key => $needsApplied)
		{
			Migration::apply($key, $needsApplied, $type);
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
