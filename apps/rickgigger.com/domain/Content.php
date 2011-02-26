<?php
class Content
{
	static public function newEntry($name)
	{
		$newId = self::getMaxId() + 1;
		$idString = str_pad($newId, 4, "0", STR_PAD_LEFT);
		$filename = "{$idString}_{$name}.md";
		$path = Config::get('app.blog.contentDir') . '/' . $filename;
		$stationaryFilename = app_dir . "/stationary/entry.tpl";
		file_put_contents($path, file_get_contents($stationaryFilename));
	}
	
	static public function getMaxId()
	{
		$maxId = -1;
		self::each(function($path) use (&$maxId) {
			$info = Content::parsePath($path);
			$id = (int)$info['id'];
			if($id > $maxId)
				$maxId = $id;
		});
		
		return $maxId;
	}
	
	static public function scan()
	{
		// $dir = Config::get('app.blog.contentDir');
		// $entries = array_merge(glob($dir . '/*/content.md'), glob($dir . '/*.md'));
		// 
		// foreach($entries as $entry)
		// {
		// 	echo "$entry<br>";
		// 	self::importEntry($entry);
		// }
		
		self::each(function($entry) {
			echo "$entry<br>";
			Content::importEntry($entry);
		});
		
		$sql = "UPDATE entry
				SET published_order = orders.rank
				FROM (SELECT id, row_number() over (order by published_date, id) as rank from entry where published_date is not null) orders
				WHERE orders.id = entry.id";
		SqlUpdateRows($sql, array());
		die();
	}
	
	static public function each($op)
	{
		$dir = Config::get('app.blog.contentDir');
		$entries = array_merge(glob($dir . '/*/content.md'), glob($dir . '/*.md'));
		
		foreach($entries as $entry)
		{
			$op($entry);
		}
	}
	
	static public function parsePath($path)
	{
		$info = array();
		$parts = explode('/', $path);
		if($parts[count($parts) - 1] == 'content.md')
		{
			$infoPart = $parts[count($parts) - 2];
			$info['simple'] = false;
		}
		else
		{
			$infoPart = $parts[count($parts) - 1];
			$info['simple'] = true;
		}
		
		$pathInfo = pathinfo($infoPart);
		$infoPart = $pathInfo['filename'];		
		$info['id'] = substr($infoPart, 0, strpos($infoPart, '_'));
		$info['name'] = substr($infoPart, strpos($infoPart, '_') + 1);
		
		return $info;
	}
	
	static public function importEntry($path)
	{
		$info = self::parsePath($path);
		
		//	do the database part
		$entry = new Entry((int)$info['id']);
		$entry->name = $info['name'];
		$entry->simple = $info['simple'];
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