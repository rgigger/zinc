<?php
class FormModule extends ZincModule
{
	public function init()
	{
		$this->addClasses(array('Form', 'FormBinding'));
	}
	
	public function getDepends()
	{
		return array('session', 'gui');
	}
}
