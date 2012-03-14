<?php
// echo_backtrace();
// die('here');
class SmartyCustomInternalTemplate extends Smarty_Internal_Template
{ 
	public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false)
	{
		if($this->source->type == 'extends')
		{
			$templates = explode('|', $this->source->name);
			// foreach($templates as $thisTemplate)
			// 	echo "\nexternal template = {$thisTemplate}<br>\n";
		}
		
		return parent::fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
	}
	
	// function getResourceTypeName ($template_resource, &$resource_type, &$resource_name) 
	// { 
	// 	echo "template_resource = $template_resource<br>";
	// 	echo "resource_type = $resource_type<br>";
	// 	echo "resource_name = $resource_name<br>";
	// 	parent::getResourceTypeName($template_resource, $resource_type, $resource_name); 
	// } 
}
