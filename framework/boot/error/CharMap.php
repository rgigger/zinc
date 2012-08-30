<?php
class CharMap
{
	private $map, $width;
	const alignLeft = 0, alignRight = 1;
	
	function __construct($width)
	{
		$this->width = $width;
		$this->map = array();
	}
	
	public function wrapLines($x, $y, $width, $text, $align = self::alignLeft)
	{
		$wrapped = wordwrap($text, $width, "\n", true);
		$lines = explode("\n", $wrapped);
		foreach($lines as $lineNumber => $line)
			$this->writeString($x, $y + $lineNumber, $line, $align);
	}
	
	public function writeString($x, $y, $string, $align = self::alignLeft)
	{
		$string = (string)$string;
		
		if($align == self::alignRight)
			$x -= strlen($string) - 1;
		
		if($x + strlen($string) > $this->width)
			trigger_error("string is to long to write on the charmap");
		
		for($index = 0; $index < strlen($string); $index++)
			$this->setChar($x + $index, $y, $string[$index]);
	}
	
	public function setChar($x, $y, $char)
	{
		if( !isset($this->map[$y]) )
			$this->map[$y] = array();
		
		// when we render we want to go line by line, not column by column
		$this->map[$y][$x] = $char;
	}
	
	public function render()
	{
		if(empty($this->map))
			return;
		
		$maxy = max(array_keys($this->map));
		
		for($y = 0; $y <= $maxy; $y++)
		{
			if(!isset($this->map[$y]))
			{
				echo "\n";
				continue;
			}
			
			$maxx = max(array_keys($this->map[$y]));
			
			for($x = 0; $x <= $maxx; $x++)
			{
				if(isset($this->map[$y][$x]))
					echo $this->map[$y][$x];
				else
					echo ' ';
			}
			echo "\n";
		}
	}
}
