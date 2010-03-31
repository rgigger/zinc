<?php
class ZoneAdmin extends AppZone
{
	public function pageDefault()
	{
		//	the ultimate in secure authorization
		die("you don't have permission to acces this page");
	}
	
	public function pageRefresh()
	{
		Content::scan();
	}
}