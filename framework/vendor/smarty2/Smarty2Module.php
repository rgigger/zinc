<?php
class Smarty2Module extends ZincModule
{
	protected function init()
	{
		$this->addClass('Smarty2', 'lib/Smarty.class.php');
	}
}
