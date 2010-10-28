<?php
function command()
{
	$args = func_get_args();
	$command = call_user_func_array('sprintf', $args);
	echo "$command\n";
	passthru($command);
}