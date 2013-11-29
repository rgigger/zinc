<?php
class ErrorModule extends ZoopModule
{
	protected function init()
	{
		$this->addInclude('Error.php');
		$this->addInclude('Utils.php');
		$this->addClasses(array(
			'Object', 'ZoopException', 'WebErrorHandler', 'CliErrorHandler', 'Backtrace',
			'BacktraceViewCli', 'ImmutableArray', 'CharMap'
		));
	}
}
