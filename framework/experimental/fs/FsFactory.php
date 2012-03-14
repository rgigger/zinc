<?php
class FsFactory
{
	private static $classMap = array('local' => 'FsLocal');
	
	static function getFileSystem($params, $name)
	{
		if(!isset(self::$classMap[$params['driver']]))
			trigger_error("unknown driver type: " . $params['driver']);
		else
			$className = self::$classMap[$params['driver']];
		
		return new $className($params, $name);
	}

}
