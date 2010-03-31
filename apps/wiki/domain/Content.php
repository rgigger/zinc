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
		$dir = $parts[count($parts) - 2];
		$id = (int)substr($dir, 0, strpos($dir, '_'));
		$name = substr($dir, strpos($dir, '_') + 1);
		
		//	do the database part
		$entry = new Entry($id);
		$entry->name = $name;
		$entry->assignHeaders();
		$entry->save();
		
		//	do the file system part
		$entry->cacheContent();
	}
	
	static public function getAllPublishedEntriesAlpha()
	{
		$sql = "SELECT * from entry where published_date is not null order by title desc";
		$entries = DbObject::_findBySql('Entry', $sql, array());
		return $entries;
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