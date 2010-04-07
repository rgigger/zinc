<?php
class SmartyModule extends ZoopModule
{
	protected function init()
	{
		$this->depend('smarty2');
	}
}
