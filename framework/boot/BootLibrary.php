<?php
class BootLibrary extends ZincLibrary
{
	protected function init()
	{
		$this->registerMod('config');
		$this->registerMod('error');
	}
}