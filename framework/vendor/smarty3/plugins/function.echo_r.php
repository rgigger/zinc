<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Name:     echo_r
 * Purpose:  print out a variable with echo_r
 * -------------------------------------------------------------
 */

function smarty_function_echo_r($params, &$smarty)
{
	if(is_null($params['var']))
	{
		echo 'NULL';
		return;
	}
	
    if(!isset($params['var']))
    {
		trigger_error("assign: missing 'var' parameter");
        return;
    }
	
	echo_r($params['var']);
}
