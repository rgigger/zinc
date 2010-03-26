<?php
class ZoneEntry extends AppZone
{
	public function initPages($p, $z)
	{
		$this->assign('curtab', $p[0]);
	}
	
	public function page1($p, $z)
	{
		$year = $p[1];
		$month = $p[2];
		$day = $p[3];
		$name = $p[4];
		
		$date = "$year-$month-$day";
		$entry = DbObject::_findOne('Entry', array('published_date' => $date, 'name' => $name));
		
		$this->assign('isList', false);
		$this->assign('entry', $entry);
	}
	
	public function page2($p, $z)
	{
		$entry = new Entry($p[1]);
		$this->assign('isList', false);
		$this->assign('entry', $entry);
	}
	
	public function pageAsset($p, $z)
	{
		$entry = new Entry($p[1]);
		$entry->streamAsset($p[2]);
		die();
	}
}
