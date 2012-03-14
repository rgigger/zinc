<?php
class FsModule extends ZincModule
{
	private static $fileSystems = array();
	
	protected function init()
	{
		$this->hasConfig = true;
		
		// $this->addInclude('Globals.php');
		$this->addClasses(array('FsFactory', 'FileSystem', 'File', 'CsvFile', 'Directory', 'FsLocal'));
		// $this->depend('utils');
	}
	
	static function getFs($name = 'default')
	{
		if(!isset(self::$fileSystems[$name]))
			trigger_error("file system '$name' has not been defined");
		return self::$fileSystems[$name];
	}
	
	static function getDefaultFs()
	{
		return self::getFs('default');
	}
	
	function configure()
	{
		$fileSystems = $this->getConfig();
		if($fileSystems)
			foreach($fileSystems as $name => $params)
				self::$fileSystems[$name] = FsFactory::getFileSystem($params, $name);
	}
}
