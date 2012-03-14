<?php
class CsvFile extends File
{
	public $separator = ',';
	
	public function detectFieldSeparator()
	{
		assert(is_null($this->lineno));
		
		if(!$this->res)
			$this->res = $this->fs->getRes($this->path);
		assert($this->res);
		
		$line = $this->fs->line($this->res);
		$sepChars = array(',', "\t", ';');
		$high = 0;
		foreach($sepChars as $sepChar)
		{
			$count = substr_count($line, $sepChar);
			if($count > $high)
			{
				$count = $high;
				$this->separator = $sepChar;
			}
		}
		
		assert(!is_null($this->separator));
		
		$this->rewind();
	}
	
	public function line()
	{
		return $this->fs->csvline($this->res, $this->separator);
	}
}