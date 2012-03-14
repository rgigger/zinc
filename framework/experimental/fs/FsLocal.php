<?php
class FsLocal extends FileSystem
{
	private $root, $cwd;
	
	public function init()
	{
		$this->root = $this->params['root'];
		if($this->root == '~')
			$this->root = instance_dir . '/var';
		$this->cwd = substr($this->params['cwd'], 1);
	}
	
	// protected function getDefaults()
	// {
	// 	return array('root' => '~/var', 'cwd' => '/');
	// }
	
	public function instanceToRealPath($instancePath)
	{
		if($instancePath[0] == '/')
			return "{$this->root}{$instancePath}";
		else
		{
			$cwd = $this->cwd ? "{$this->cwd}/" : '';
			return "{$this->root}/{$cwd}{$instancePath}";
		}
	}
	
	public function moveUploadedFile($tmp, $path)
	{
		move_uploaded_file($tmp, $this->instanceToRealPath($path));
	}
	
	public function getRes($path)
	{
		// echo $this->instanceToRealPath($path) . '<br>';
		return fopen($this->instanceToRealPath($path), 'r');
	}
	
	public function line($res)
	{
		return fgets($res);
	}
	
	public function csvline($res, $separator)
	{
		return fgetcsv($res, 1024, $separator);
	}
	
	public function rewind($res)
	{
		rewind($res);
	}
	
	public function size($path)
	{
		return filesize($this->instanceToRealPath($path));
	}
	
	public function isDir($path)
	{
		return is_dir($this->instanceToRealPath($path));
	}
	
	public function mkdir($path, $mode = null, $recursive = false)
	{
		mkdir($this->instanceToRealPath($path, $mode, $recursive));
	}
	
	// public function importUploadedFiles($path)
	// {
	// 	foreach($_FILES as $name => $info)
	// 	{
	// 		$this->moveUploadedFile($info['tmp_name'], $path . '/' . $info['name']);
	// 	}
	// }
}

// read n lines as csv
// read n lines
// read all lines as csv
// read all lines into a big string
// reall all lines into an array
// reall all lines in a loop
// read all lines with a callback
// get all contents
// put all contents

// copy
// get basename
// get dir path
// get extention
// chgrp, chown, chmod, delete, unlink, 
// get file size
// write arbitrary amound of data
// seek
// touch