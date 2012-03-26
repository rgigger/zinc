<?php
class CommandScript
{
	function usage()
	{
		if(defined('instance_dir'))
			return array('ex APP_COMMAND');
		else
			return array();
	}	
	
	public function handleRequest($p)
	{
		global $argv; // this is so it will be available within the included script file
		
		if(count($p) < 3)
			die("error: no script specified\n\n");
		
		$command = $p[2];
		$filepath = app_dir . "/bin/$command.php";
		echo "executing $filepath\n";
		if(file_exists($filepath))
			include $filepath;
		else
			die("error: command $command not found\n\n");
		
		die();
	}
}
