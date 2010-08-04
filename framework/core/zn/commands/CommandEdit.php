<?php
class CommandEdit
{
	public function handleRequest($p)
	{
		$methodName = "handle" . $p[2];
		if(method_exists($this, $methodName))
			$this->$methodName($p);
		else
			die("invalid command\n\n");
	}
	
	public function handleInstance()
	{
		passthru("mate .");
	}
	
	public function handleApplication()
	{
		passthru("mate " . app_dir);
	}
	
	public function handleZinc()
	{
		passthru("mate " . zinc_dir);
	}
}
