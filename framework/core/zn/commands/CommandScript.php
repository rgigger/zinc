<?php
class CommandScript
{
	static public function usage()
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
		
		// add a -v switch that can be added between the "zn ex" and the script name that will not be passed into the script
		// this will necessitate altering what gets passed into the script so it doesn't contain any of the cruft it gets now
		// that will probaly necessitate altering nearly every script you've ever made with zinc
		// right now we just need to delete it though because otherwise we can't use it to create scripts whos output
		// needs to be piped into other scripts
		//
		// echo "executing $filepath\n";
		
		if(file_exists($filepath))
			include $filepath;
		else
			die("error: command $command not found\n\n");
		
		die();
	}
}
