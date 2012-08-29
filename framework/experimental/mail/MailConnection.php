<?php
abstract class MailConnection
{
	protected $params;
	
	function __construct($params, $connectionName)
	{
		$this->params = $params;
		$this->validateParams($connectionName);
		$this->init();
	}

	//
	//	Begin configuration funtions
	//

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
			throw new ConfigException('db', $missing, "for connection $connectionName");

		//	handle the defaults
		foreach($this->getDefaults() as $name => $value)
		{
			if(!isset($this->params[$name]))
				$this->params[$name] = $value;
		}
	}

	protected function init()
	{
	}
	
	protected function getDefaultFrom()
	{
		if(isset($this->params['defaultFrom']) && $this->params['defaultFrom'])
			return $this->params['defaultFrom'];
		
		return false;
	}

	protected function getRequireds()
	{
		return array();
	}

	protected function getDefaults()
	{
		return array();
	}

	//
	//	End configuration funtions
	//
	
	abstract protected function send($message);
}
