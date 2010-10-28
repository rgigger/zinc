<?php
class CliModule extends ZoopModule
{
	protected function init()
	{
		$this->addInclude('utils.php');
		$this->addClass('Importer');
		$this->addClass('CsvImporter');
		$this->addClass('CliApplication');
	}
}

