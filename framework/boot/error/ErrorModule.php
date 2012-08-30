<?php
class ErrorModule extends ZoopModule
{
	protected function init()
	{
		$this->addInclude('Error.php');
		$this->addInclude('Utils.php');
		$this->addClass('ZoopException');
		$this->addClass('WebErrorHandler');
		$this->addClass('CliErrorHandler');
		$this->addClass('Backtrace');
		$this->addClass('ImmutableArray');
		$this->addClass('CharMap');
	}
}
