<?php
function GetTerminalCols()
{
	if(getenv('TERM') !== false)
		return exec('tput cols');
	else
		return 80;
}

function GetTerminalLines()
{
	if(getenv('TERM') !== false)
		return exec('tput lines');
	else
		return 20;
}

function error_print_r($var)
{
	if(is_null($var))
		error_var_dump($var);
	else
		error_write_to_log(print_r($var, true));
}

function error_var_dump($var)
{
	ob_start(); 
	var_dump($var);
	error_write_to_log(ob_get_contents());
	ob_end_clean();
}

function error_write_to_log($debugString)
{
	if(defined('instance_dir') && instance_dir)
	{
		$logdir = instance_dir . '/var/log';
		$logfile = "$logdir/debug.log";
	}
	else
		trigger_error("no location defined for debug logging");
	
	// if(!file_exists($logdir))
	// 	mkdir($logdir, 0750, true);
	
	$success = error_log($debugString . "\n", 3, $logfile);
	if(!$success)
		trigger_error("attempt to write to error log failed");
}
