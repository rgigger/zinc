<?php
class App extends ZoneApplication
{
	public function init()
	{
		Zoop::loadLib('zone');
		Zoop::loadLib('db');
		// if(php_sapi_name() != "cli")
		// 	Zoop::loadLib('session');

		//	register classess
		Zoop::registerClass('AppZone', __dir__ . '/domain/AppZone.php');
		Zoop::registerClass('AppGui', __dir__ . '/domain/AppGui.php');
	}
}
