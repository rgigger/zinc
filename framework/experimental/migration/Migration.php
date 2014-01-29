<?php
class Migration
{
	static function initDb($type)
	{
		if($type != 'migration' && $type != 'seed')
			trigger_error("invalid migration type: $type");
		
		//	create the migration table if it does not exist
		$schema = SqlGetSchema();
		if(!$schema->tableExists($type))
		{
			$sql = "create table $type (
						id serial primary key, 
						name text not null,
						applied int2 not null default 0)";
			SqlAlterSchema($sql, array());
		}
	}
	
	static function getAllMigrationNames($type)
	{
		if($type != 'migration' && $type != 'seed')
			trigger_error("invalid migration type: $type");
		
		$dirname = self::getDirName($type);
		$filenames = ListDir(app_dir . '/' . $dirname, array('extentions' => array('php')));
		sort($filenames);
		$versions = array();
		foreach($filenames as $thisFilename)
		{
			$parts = explode('_', $thisFilename);
			$version = $parts[0];
			$versions[$thisFilename] = $version;
		}
		
		return $versions;
	}
	
	static public function getMaxMigration($type)
	{
		$ms = self::getAllMigrationNames($type);
		$max = 0;
		foreach($ms as $num)
			if($num > $max)
				$max = $num;
		return $max;
	}
	
	static function filenameFromVersion($version, $type)
	{
		if($type != 'migration' && $type != 'seed')
			trigger_error("invalid migration type: $type");
		
		$dirname = self::getDirName($type);
		
		$filenames = ListDir(app_dir . '/' . $dirname, array('extentions' => array('php')));
		
		foreach($filenames as $thisFilename)
		{
			$parts = explode('_', $thisFilename);
			$thisVersion = str_replace('.', '_', $parts[0]);
			if($version == $thisVersion)
				return $thisFilename;
		}
		
		trigger_error("version not found: " . $version);
	}
	
	static function getDirName($type)
	{
		if($type == 'seed')
		{	
			if(!($subdir = Config::get('zinc.migrations.seedName')))
				trigger_error("configuration for seed subdirectory is missing");
			return $type . 's/' . $subdir;
		}
		else
			return 'migrations';
	}
	
	static function getAllAppiedMigrationNames($type)
	{
		if($type != 'migration' && $type != 'seed')
			trigger_error("invalid migration type: $type");
		return SqlFetchColumn("select name from $type where applied = 1", array());
	}
	
	static function apply($filename, $name, $type)
	{
		if($type != 'migration' && $type != 'seed')
			trigger_error("invalid migration type: $type");
		
		$dirname = self::getDirName($type);
		
		include_once(app_dir . '/' . $dirname . '/' . $filename);
		
		$className = ucfirst($type);
		$className = $className . '_' . str_replace('.', '_', $name);
		$migration = new $className();
		$migration->up();
		
		//	mark it as applied
		SqlUpsertRow($type, array('name' => $name), array('applied' => 1));
		
		print_r($migration);
	}
	
	static function undo($filename, $name, $type)
	{
		if($type != 'migration' && $type != 'seed')
			trigger_error("invalid migration type: $type");
		
		$dirname = self::getDirName($type);
		
		include_once(app_dir . '/' . $dirname . '/' . $filename);
		
		$className = ucfirst($type);
		$className = $className . '_' . str_replace('.', '_', $name);
		$migration = new $className();
		$migration->down();
		
		//	mark it as applied
		SqlUpsertRow($type, array('name' => $name), array('applied' => 0));
		
		print_r($migration);
	}
}
