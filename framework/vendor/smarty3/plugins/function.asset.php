<?php
function smarty_function_asset($params, &$smarty)
{
	extract($params);
	
    if(!isset($file))
    {
        trigger_error("assign: missing 'file' parameter");
        return;
    }
	
	$extra = '';
	foreach($params as $name => $value)
	{
		if(in_array($name, array('file', 'urlOnly')))
			continue;
		
		$extra .= " $name=\"$value\"";
	}
	
	$prefix = Config::get('app.asset.prefix');
	if(!$prefix)
		trigger_error("app.asset.prefix not set");
	
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	$url = $prefix . '/' . $file;
	if(isset($params['urlOnly']) && $params['urlOnly'] == true)
		echo $url;
	else if($ext == 'js')
		echo '<script type="text/javascript" src="' . $url . '"' . $extra . '></script>';
	else if($ext == 'css')
		echo '<link type="text/css" href="' . $url . '" rel="stylesheet"' . $extra . '/>';
	else if(in_array($ext, array('jpg', 'png')))
		echo '<img src="' . $url . '"' . $extra . '>';
	else
		trigger_error("unknown asset type: $ext");
}
