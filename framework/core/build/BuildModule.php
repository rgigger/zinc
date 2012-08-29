<?php
class BuildModule extends ZoopModule
{
	protected function init()
	{
		$this->addClass('BuildProject');
	}
	
	function getIncludes()
	{
		return array('functions.php');
	}
	
	// function getClasses()
	// {
	// 	return array('BuildProject');
	// }
}
