<?php
// get the location of the init.php file according to the following rules
// 1. if there is one in the current directory then use it
// 2. check for a -D flag. If it is set then use that as the directory
// 3. check for a -I flag. If it is set then check for the user config to see if
//		there is an instance name and directory set up.  If so use that
// 4. if there is an environmental variable INSTANCE_DIR set then use that

// 2-4 above not done

// include the basic Zinc stuff
if(file_exists('./init.php'))
	include 'init.php';
else
{
	include dirname(dirname(__dir__)) . '/Zinc.php';
	Zinc::registerLib('core');
	Zinc::loadMod('cli');
}

// load the default zn config
Config::suggest(__dir__ . '/config.yaml');

// process the command line args and determine which Command* class to use
$args = $argv;
array_shift($args);
$wordlist = Config::get('zn.commands');

$counts = array();
foreach(Config::get('zn.commands') as $commandName => $keywords)
{
	$count = 0;
	foreach($keywords as $word)
	{
		if(in_array($word, $args))
			$count++;
	}
	$counts[$commandName] = $count;
}

$highestCommand = false;
$highestCount = 0;
foreach($counts as $commandName => $count)
{
	if($count && $count > $highestCount)
	{
		$highestCommand = $commandName;
		$highestCount = $count;
	}
}

// if we found a class to use then pass on the request info to it
if($highestCommand)
{
	$className = "Command$highestCommand";
	include __dir__ . "/commands/$className.php";
	$command = new $className();
	$command->handleRequest($argv);
	echo "\n\n";
	die();
}

// if we didn't match the command args up with a class just give the usage info
//if(defined('instance_dir'))
{
	echo "zn COMMAND [ARGS]\n";
	foreach(Config::get('zn.commands') as $commandClass => $commands)
	{
		include __dir__ . "/commands/Command{$commandClass}.php";
		foreach(call_user_func(array('Command'.$commandClass, 'usage')) as $usage)
			echo "zn " . $usage . "\n";
	}
}
/*else
{
	echo "usage: zn create app APP_NAME\n";
	echo "       zn create instance INSTANCE_NAME APP_DIR\n";
	echo "       zn create pub PUB_NAME INSTANCE_DIR\n";
	echo "\n";
}*/

//
// some basic utility functions for use in zn
//

function GetWebUser()
{
	// this will basically only work as-is if you are using the default apache config on Mac OSX and Ubuntu 
	//	since there is no way for the command link to actually know what web server you are using and how it is
	//	configured this should also draw from a user defined configuration and use the following only as a fallback
	if(PHP_OS == 'Darwin')
		return 'www';
	else if(PHP_OS == 'Linux')
		return 'www-data';
}
