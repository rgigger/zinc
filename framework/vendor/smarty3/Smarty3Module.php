<?php
class Smarty3Module extends ZoopModule
{
	protected function init()
	{
		$this->addClass('Smarty', 'lib/libs/Smarty.class.php');
	}
}
