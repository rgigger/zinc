<?php
class VendorLibrary extends ZoopLibrary
{
	protected function init()
	{
		$this->registerMod('pest');
		$this->registerMod('phpmailer');
		$this->registerMod('sfyaml');
		$this->registerMod('smarty');
		$this->registerMod('smarty2');
		$this->registerMod('smarty3');
		$this->registerMod('spyc');
		$this->registerMod('swift');
		$this->registerMod('zend');
	}
}