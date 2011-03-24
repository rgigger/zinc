<?php
class ZoneDefault extends AppZone
{
	function pageDefault()
	{
		Port::import(Config::get('app.datafile'));
		die();
	}
}
