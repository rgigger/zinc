<?php
class GuiDriver
{
	function __construct($params, $connectionName)
	{
		$this->params = $params;
		$this->validateParams($connectionName);
		$this->init();
	}
	
	private function validateParams($connectionName)
	{
		//	handle the required fields
		$missing = array();
		foreach($this->getRequireds() as $thisRequired)
		{
			if(!isset($this->params[$thisRequired]))
				$missing[] = $thisRequired;
		}

		if(!empty($missing))
			throw new ConfigException('gui', $missing, "for connection $connectionName");

		//	handle the defaults
		foreach($this->getDefaults() as $name => $value)
		{
			if(!isset($this->params[$name]))
				$this->params[$name] = $value;
		}
	}
	
}
