<?php
class Content
{
	static public function scan()
	{
		$dir = Config::get('app.blog.contentDir');
		$entries = array_merge(glob($dir . '/*/content.md'), glob($dir . '/*.md'));
		
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
		if($parts[count($parts) - 1] == 'content.md')
		{
			$infoPart = $parts[count($parts) - 2];
			$simple = false;
		}
		else
		{
			$infoPart = $parts[count($parts) - 1];
			$simple = true;
		}
		
		$info = pathinfo($infoPart);
		$infoPart = $info['filename'];		
		$id = substr($infoPart, 0, strpos($infoPart, '_'));
		$name = substr($infoPart, strpos($infoPart, '_') + 1);
		
		//	do the database part
		$entry = new Entry((int)$id);
		$entry->name = $name;
		$entry->simple = $simple;
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