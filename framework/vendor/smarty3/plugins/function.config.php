<?php
function smarty_function_config($params, &$smarty)
{
	assert(isset($params['name']));
	return Config::get($params['name']);
}
