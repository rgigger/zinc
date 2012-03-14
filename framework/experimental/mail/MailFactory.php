<?php
class MailFactory
{
	private static $classMap = array('swift' => 'MailSwift', /*'phpmailer' => 'MailPhpMailer',*/ 'aws' => 'MailAws');
	private static $modules = array('swift' => 'swift');
	
	static function getConnection($params, $name)
	{
		if(isset(self::$modules[$params['driver']]))
			Zinc::loadLib(self::$modules[$params['driver']]);
		
		if(!isset(self::$classMap[$params['driver']]))
			trigger_error("unknown driver type: " . $params['driver']);
		else
			$className = self::$classMap[$params['driver']];
		
		return new $className($params, $name);
	}

}
