<?php
class SessionModule extends ZoopModule
{
	private static $engine;
	
	protected function init()
	{
		$this->addClass('Session');
		$this->addClass('SessionPgsql');
		$this->addClass('SessionDb');
		$this->addClass('SessionFactory');
		$this->depend('db');
		$this->hasConfig = true;
	}
	
	static function getEngine()
	{
		return self::$engine;
	}
	
	protected function configure()
	{
		$params = $this->getConfig();
		
		if(!isset($params['lifetime']))
			$params['lifetime'] = ini_get('session.cookie_lifetime');
		
		// we should also implement path, domain, secure, and httponly here
		
		self::$engine = SessionFactory::getEngine($params);
		Session::start();
	}
}
