<?php
class Backtrace
{
	private $backtraceInfo;
	
	function __construct($backtraceInfo = null)
	{
		$this->info = $backtraceInfo ? $backtraceInfo : debug_backtrace();
	}
	
	public function display()
	{
		echo $this->toHtml();
	}

	/**
	 * Format backtrace information as HTML
	 */
	public function toHtml()
	{
		ob_start();
	?>
	<table border="1">
		<tr>
			<th>File</th><th>Line</th><th>Function</th>
		</tr>
		<?php  foreach($this->info as $thisRow): 
			$lineInfo = FormateBacktraceLineHtml($thisRow);
		?><tr>
			<td><?php echo $lineInfo['file']; ?></td>
			<td><?php echo $lineInfo['line']; ?></td>
			<td><?php echo $lineInfo['function']; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php
		return ob_get_clean();
	}
	
	

	public function FormateBacktraceLineHtml($lineInfo)
	{
		$result = array();
		$result['file'] = isset($lineInfo['file']) ? $lineInfo['file'] : 'php function';
		$result['line'] = isset($lineInfo['line']) ? $lineInfo['line'] : 'na';
		$result['function'] = FormatBacktraceFunctionCellHtml($lineInfo);
		return $result;
	}

	public function FormatBacktraceFunctionCellHtml($lineInfo)
	{
		$call = '';
		$call .= isset($lineInfo['class']) ? ($lineInfo['class'] . $lineInfo['type']) : '';
		$call .= $lineInfo['function'] . '(';
		$argStrings = array();

		if(isset($lineInfo['args']))
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
					$argStrings[] = '&lt;array&gt;';
					break;
				case 'object':
					$argStrings[] = '&lt;object&gt;';
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

		$call .= implode(', ', $argStrings);

		$call .= ')';

		return $call;
	}
}
