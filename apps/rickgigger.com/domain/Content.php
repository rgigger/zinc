<?php
class Content
{
	static public function scan()
	{
		$dir = Config::get('app.blog.contentDir');
		$entries = glob($dir . '/*/content.md');
		
		foreach($entries as $entry)
		{
			echo "$entry<br>";
			self::importEntry($entry);
		}
		die();
	}
	
	static public function importEntry($path)
	{
		$parts = explode('/', $path);
		$info = explode('_', $parts[count($parts) - 2]);
		
		//	do the database part
		$entry = new Entry((int)$info[0]);
		$entry->name = $info[1];
		$entry->assignHeaders();
		$entry->save();
		
		//	do the file system part
		$entry->cacheContent();
	}
	
	static public function getPageOfEntries($pageNum = 1)
	{
		$sql = "SELECT * from entry where published_date is not null order by published_date desc limit 10";
		$entries = DbObject::_findBySql('Entry', $sql, array());
		return $entries;
	}

	static public function getDrafts()
	{
		$sql = "SELECT * from entry where published_date is null order by id desc";
		$entries = DbObject::_findBySql('Entry', $sql, array());
		return $entries;
	}
}