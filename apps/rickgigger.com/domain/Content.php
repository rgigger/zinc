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
		
		$sql = "UPDATE entry
				SET published_order = orders.rank
				FROM (SELECT id, row_number() over (order by published_date, id) as rank from entry where published_date is not null) orders
				WHERE orders.id = entry.id";
		SqlUpdateRows($sql, array());
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
	
	static public function getMaxPages()
	{
		return SqlFetchCell("SELECT ceil(max(published_order)/10) FROM entry", array());
	}
	
	static public function getPageOfEntries($page)
	{
		$min = $page * 10 + 1;
		$max = $min + 9;
		// SqlEchoOn();
		$sql = "SELECT * from entry where published_order >= $min and published_order <= $max order by published_date desc";
		$entries = DbObject::_findBySql('Entry', $sql, array());
		// SqlEchoOff();
		return $entries;
	}

	static public function getDrafts()
	{
		$sql = "SELECT * from entry where published_date is null order by id desc";
		$entries = DbObject::_findBySql('Entry', $sql, array());
		return $entries;
	}
}