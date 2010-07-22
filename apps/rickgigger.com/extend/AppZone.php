<?php
class AppZone extends GuiZone
{
	function __construct()
	{
		$this->layout = 'main';
	}
	
	function closePages($p, $z)
	{
		if(!$this->displayed())
			$this->display($p[0]);
	}
}
