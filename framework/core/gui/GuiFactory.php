<?php
class GuiFactory
{
	private static $classMap = array('smarty2' => 'GuiSmarty2', 'smarty3' => 'GuiSmarty3');
	
	static function getConnection($params, $name)
	{
		if(!isset(self::$classMap[$params['driver']]))
			trigger_error("unknown driver type: " . $params['driver']);
		else
			$className = self::$classMap[$params['driver']];
		
		return new $className($params, $name);
	}

}
