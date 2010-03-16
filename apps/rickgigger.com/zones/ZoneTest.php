<?php
class ZoneTest extends AppZone
{
	public function pageDefault()
	{
		$this->redirect('one');
	}
	
	public function pageOne($p, $z)
	{
		die('one');
	}
	
	public function pageTwo($p, $z)
	{
		$this->redirect('three');
	}
	
	public function pageThree($p, $z)
	{
		die('three');
	}
}