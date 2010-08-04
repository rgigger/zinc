<?php
include 'init.php';
Config::suggest(__dir__ . '/config.yaml');

// $classMap = array();
// foreach(glob(__dir__ . '/words/Word*.php') as $fullpath)
// {
// 	$info = pathinfo($fullpath);
// 	$classMap[strtolower(substr($info['filename'], 4))] = $fullpath;
// }  

// print_r($classMap);
// 
// print_r( $argv );
// print_r(Config::get('zn.commands'));

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
	include __dir__ . "/commands/$className.php";
	$command = new $className();
	$command->handleRequest($argv);
	echo "\n\n";
	die();
}

die("error: no command found\n");