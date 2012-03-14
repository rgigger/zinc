<?php
class App extends ZoneApplication
{
	public function init()
	{
		Zinc::loadLib('zone');
		Zinc::loadLib('db');
		//if(php_sapi_name() != "cli")
		//	Zinc::loadLib('session');
		Zinc::loadLib('form');
		Zinc::loadLib('mail');

		//	register classess
		Zinc::reg('AppZone', 'domain');
		Zinc::reg('AppGui', 'domain');
		Zinc::reg('Person', 'domain');
		Zinc::reg('Token', 'domain');
		
		//	register zones
		Zinc::reg('ZoneUser', 'zones');
	}
}
