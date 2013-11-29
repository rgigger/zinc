<?php
class AppModule extends ZoopModule
{
	protected function init()
	{
		$this->depend('utils');
		$this->addInclude('Globals.php');
		$this->addClasses(array('Application', 'ApplicationInstance', 'Instance'));
	}
}
