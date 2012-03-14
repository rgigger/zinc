<?php
abstract class FileSystem
{
	protected $params;
	
	// abstract public function openFile($path);
	// abstract public function closeFile();
	// abstract protected function init();
	abstract public function moveUploadedFile($tmp, $path);
	abstract public function getRes($path);
	abstract public function line($res);
	
	function __construct($params, $fsName)
	{
		$this->params = $params;
		$this->validateParams($fsName);
		$this->init();
	}
	
	public function init() {}
	
	private function validateParams($fsName)
	{
		//	handle the required fields
		$missing = array();
		foreach($this->getRequireds() as $thisRequired)
		{
			if(!isset($this->params[$thisRequired]) || !isset($this->params[$thisRequired]))
				$missing[] = $thisRequired;
		}

		if(!empty($missing))
			throw new ConfigException('fs', $missing, "for connection $connectionName");

		//	handle the defaults
		foreach($this->getDefaults() as $name => $value)
		{
			if(!isset($this->params[$name]))
				$this->params[$name] = $value;
		}
	}
	
	protected function getRequireds()
	{
		return array();
	}

	protected function getDefaults()
	{
		return array();
	}
}
