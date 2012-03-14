<?php
class File implements Iterator
{
	protected $fs, $path, $res, $lineno, $curLine;
	
	function __construct($path = null, $fsInfo = 'default')
	{
		// maybe put some of this logic into FsFactory
		if($fsInfo instanceof FileSystem)
			$this->fs = $fsInfo;
		else if(is_array($fsInfo))
			$this->fs = FsFactory::getFileSystem($fsInfo, null);
		else if(is_string($fsInfo))
			$this->fs = FsModule::getFs($fsInfo);
		else
			trigger_error("unsupported file system designation type");
		
		// $this->path = $this->fs->instanceToRealPath($path);
		$this->path = $path;
		$this->res = null;
	}
	
	//
	// this (the stream function) is all wrong now
	//
	// all of the local filesystem functions that are called here need to be implemented in FSLocal and called here
	//
	
	public function stream()
	{
		session_nowrite();
		session_write_close();
		if(!is_file($this->path))
		{
			header('HTTP/1.1 404 Not Found');
			trigger_error("File Not Found: $this->path");
		}
		
		//unset some caching headers
		header('Pragma: ');
		header('Expires: ');
		header('Cache-Control: ');
		$mtime = filemtime($this->path);
		header('Last-Modified: ' . gmdate('r', $mtime));
		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
		{
			$cacheDate = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
			if($cacheDate <= $mtime)
				header('HTTP/1.1 304 Not Modified');
			die();
		}
		$filesize = filesize($this->path);
		$start = 0;
		$end = $filesize;
		//because it's start-end inclusive, we add +1 to get the length.
		header('Content-Length: ' . $filesize);
		
		$fileInfo = pathinfo($this->path);
		if($fileInfo['extension'] == 'ogg')
			header('Content-Type: video/ogg');
		else if($fileInfo['extension'] == 'mp4')
			header('Content-Type: video/mp4');
		else if($fileInfo['extension'] == 'jpg')
			header('Content-Type: image/jpeg');
		else if($fileInfo['extension'] == 'gif')
			header('Content-Type: image/gif');
		
		readfile($this->path);
		die();
	}
	
	public function lines($max)
	{
		$lines = array();
		$i = 0;
		foreach($this as $line)
		{
			if($i == $max)
				break;
			$lines[] = $line;			
			$i++;
		}
		return $lines;
	}
	
	public function line()
	{
		return $this->fs->line($this->res);
	}
	
	public function size()
	{
		return $this->fs->size($this->path);
	}
	
	public function name()
	{
		return $this->path;
	}
	
	//
	// implement the iterator interface
	//
	
	public function rewind()
	{
		if(!$this->res)
			$this->res = $this->fs->getRes($this->path);
		else
			$this->fs->rewind($this->res);
		assert($this->res);
		
		$this->lineno = 0;
		
		$this->curLine = $this->line();
	}

	public function current()
	{
		return $this->curLine;
	}

	public function key() 
	{
		return $this->lineno;
	}

	public function next() 
	{
		$this->lineno++;
		return $this->curLine = $this->line();
	}

	public function valid()
	{
		return $this->res && ($this->curLine !== false);
	}
	
	//
	// end implement the iterator interface
	//
}
