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
foreach($args as $arg)
{
	foreach(Config::get('zn.commands') as $commandName => $keywords)
	{
		foreach($keywords as $word)
		{
			if(($index = array_search($word, $wordlist[$commandName])) !== false)
				unset($wordlist[$commandName][$index]);
			
			//	all of the keywords were in the arg list
			if(count($wordlist[$commandName]) == 0)
			{
				$className = "Command$commandName";
				include __dir__ . "/commands/Command$commandName.php";
				$command = new $className();
				$command->handleRequest($argv);
				die();
			}
		}
		
	}
}

die("error: no command found\n");