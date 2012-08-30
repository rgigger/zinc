<?php
class BacktraceViewCli extends Object
{
	private $info;
	const padding = 4;
	
	function __construct($info)
	{
		$this->info = $info;
		$this->addStatic('padSide', array('file' => STR_PAD_LEFT, 'line' => STR_PAD_RIGHT));
		$this->addStatic('fields', array('file', 'line', 'function'));
		$this->addStatic('padString', str_pad('', self::padding, ' '));
	}
	
	public function display()
	{
		$formattedFields = $this->formatFields();
		$allocatedColumnWidths = $this->allocateColumnWidths($formattedFields);
		
		foreach($formattedFields as $thisRow)
			self::renderBacktraceRow($thisRow, $allocatedColumnWidths);
	}
	
	private function renderBacktraceRow($formattedBacktraceRow, $allocatedColumnWidths)
	{
		$map = new CharMap(GetTerminalCols());
		$colStarts = array(
			'file' => 0,
			'line' => $allocatedColumnWidths['file'] + self::padding,
			'function' => $allocatedColumnWidths['file'] + $allocatedColumnWidths['line'] + (2 * self::padding)
		);
		
		$map->wrapLines($colStarts['file'] + $allocatedColumnWidths['file'] - 1, 0, $allocatedColumnWidths['file'], $formattedBacktraceRow['file'], CharMap::alignRight);
		$map->writeString($colStarts['line'], 0, $formattedBacktraceRow['line']);
		$map->wrapLines($colStarts['function'], 0, $allocatedColumnWidths['function'], $formattedBacktraceRow['function']);
		
		$map->render();
	}
	
	static private function allocateColumnWidths($formattedFields)
	{
		$maxLengths = self::getMaxLengths($formattedFields);
		$maxTermCols = GetTerminalCols();
		
		// if there is not enough space for the biggest line possible line then we need to calculate how much
		//  space each column should actually get
		if(array_sum($maxLengths) + (self::padding * 2) > $maxTermCols)
		{
			// the line field is short, just give it all the space it needs
			$alloced['line'] = $maxLengths['line'];
			
			// now substract the line and buffer space space anddivide the rest between function and file
			$remainingCols = $maxTermCols - ($alloced['line'] + (self::padding * 2));
			
			// experiment with different buffer spaces till you find one that seems "more optimal"
			// currently it assumes that it's the function column that's goign to run us over. 
			// If that's true this needs to be tweaked
			$allocMethod = "50/50";
			if($allocMethod == "50/50")
			{
				$half = (int)$remainingCols/2;
				if($maxLengths['file'] >= $half)
				{
					$alloced['function'] = $half;
					$alloced['file'] = $remainingCols - $alloced['function'];
				}
				else
				{
					$alloced['file'] = $maxLengths['file'];
					$alloced['function'] = $remainingCols - $alloced['file'];
				}
			}
		}
		else
			$alloced = $maxLengths;
		
		return $alloced;
	}
	
	// get the maximum line lengths for each field: file, line, and function
	static private function getMaxLengths($formattedLines)
	{
		$maxLengths = array('file' => 0, 'line' => 0, 'function' => 0);
		foreach($formattedLines as $thisRow)
		{
			foreach($maxLengths as $field => $max)
			{
				if(isset($thisRow[$field]) && strlen($thisRow[$field]) > $max)
					$maxLengths[$field] = strlen($thisRow[$field]);
			}
		}
		
		return $maxLengths;
	}
	
	// organice the data from the backtrace info into distinct file, line, and function fields
	private function formatFields()
	{
		$formatted = array();
		foreach($this->info as $thisRow)
		{
			$lineInfo = $this->formatLine($thisRow);
			$formatted[] = $lineInfo;
		}
		
		return $formatted;
	}
	
	function formatLine($lineInfo)
	{
		$result = array();
		$result['file'] = isset($lineInfo['file']) ? $lineInfo['file'] : 'php function';
		$result['line'] = isset($lineInfo['line']) ? $lineInfo['line'] : 'na';
		$result['function'] = $this->formatFunctionInfo($lineInfo);
		return $result;
	}

	function formatFunctionInfo($lineInfo)
	{
		$call = '';
		$call .= isset($lineInfo['class']) ? ($lineInfo['class'] . $lineInfo['type']) : '';
		$call .= $lineInfo['function'] . '(';
		$argStrings = array();
		if(isset($lineInfo['args']))
		{
			foreach($lineInfo['args'] as $thisArg)
			{
				switch(gettype($thisArg))
				{
					case 'string':
						$argStrings[] = '"' . $thisArg . '"';
						break;
					case 'integer':
						$argStrings[] = $thisArg;
						break;
					case 'array':
						$argStrings[] = '<array>';
						break;
					case 'object':
						$argStrings[] = '{object}';
						break;
					case 'resource':
						$argStrings[] = 'resource: ' . $thisArg;
						break;
					case 'boolean':
						$argStrings[] = 'boolean: -' . $thisArg . '-';
						break;
					case 'NULL':
						$argStrings[] = 'NULL';
						break;
					default:
						die('unhandled type ' . gettype($thisArg));
						break;
				}
			}
		}

		$call .= implode(', ', $argStrings);

		$call .= ')';

		return $call;
	}
}
