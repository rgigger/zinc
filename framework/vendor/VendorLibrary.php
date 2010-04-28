<?php
class VendorLibrary extends ZoopLibrary
{
	protected function init()
	{
		$this->registerMod('phpmailer');
		$this->registerMod('smarty');
		$this->registerMod('smarty2');
		$this->registerMod('smarty3');
		$this->registerMod('spyc');
		$this->registerMod('zend');
		$this->registerMod('swift');
	}
}