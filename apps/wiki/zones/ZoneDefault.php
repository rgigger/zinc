<?php
class ZoneDefault extends AppZone
{
	public function initPages($p, $z)
	{
		$this->assign('curtab', $p[0]);
	}
	
	public function pageDefault()
	{
		$this->assign('entries', Content::getAllPublishedEntriesAlpha());
	}
	
	public function pageEntry($p, $z)
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
