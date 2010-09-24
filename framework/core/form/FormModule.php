<?php
class FormModule extends ZincModule
{
	public function init()
	{
	}
	
	public function getDepends()
	{
		return array('session', 'gui');
	}
	
	public function getClasses()
	{
		return array('Form', 'FormBinding');
	}
}
