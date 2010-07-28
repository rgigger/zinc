<?php
class AppModule extends ZoopModule
{
	protected function init()
	{
		$this->addInclude('Globals.php');
		$this->addClass('Application');
		$this->addClass('Instance');
		$this->addClass('Object');
		$this->depend('utils');
	}
}
