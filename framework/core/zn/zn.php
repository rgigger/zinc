<?php
// get the location of the init.php file according to the following rules
// 1. if there is one in the current directory then use it
// 2. check for a -D flag. If it is set then use that as the directory
// 3. check for a -I flag. If it is set then check for the user config to see if
//		there is an instance name and directory set up.  If so use that
// 4. if there is an environmental variable INSTANCE_DIR set then use that

// 2-4 above not done

// if we are in an instance load zinc through the instance
// other wise load it through

// //	don't create the instance or the app, we just want bare bones functionality
// define('app_simple', true);

if(file_exists('./init.php'))
	include 'init.php';
else
{
	include dirname(dirname(__dir__)) . '/Zinc.php';
	Zinc::registerLib('core');
	Zinc::loadMod('cli');
}

Config::suggest(__dir__ . '/config.yaml');

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

if($highestCommand)
{
	$className = "Command$highestCommand";
	// echo __dir__ . "/commands/$className.php\n";
	include __dir__ . "/commands/$className.php";
	$command = new $className();
	$command->handleRequest($argv);
	echo "\n\n";
	die();
}

if(defined('instance_dir'))
	echo "zn COMMAND [ARGS]\n";
else
{
	echo "usage: zn create app APP_NAME\n";
	echo "       zn create instance INSTANCE_NAME APP_DIR\n";
	// echo "   create app APP_NAME\n";
	// echo "   create module MODULE_NAME\n";
	echo "\n";
}