<?php
class CommandScript
{
	public function handleRequest($p)
	{
		print_r($p);
		if(count($p) < 3)
			die("error: no script specified\n\n");
		
		$command = $p[2];
		$filepath = app_dir . "/bin/$command.php";
		echo "executing $filepath\n";
		if(file_exists($filepath))
			include $filepath;
		else
			die("error: command $command not found\n\n");
	}
}
