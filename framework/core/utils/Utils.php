<?php

function fileLines($filename)
{
	$handle = fopen($filename, "r");
	
	if($handle)
	{
		while(($buffer = fgets($handle, 4096)) !== false)
		{
			yield $buffer;
		}
		
		fclose($handle);
	}
	else
		trigger_error("file $filename could not be opened");
}


/**
 * Returns true if the current page was requested with the GET method
 *
 * @return boolean
 */
function RequestIsGet()
{
	return $_SERVER['REQUEST_METHOD'] == 'GET' ? 1 : 0;
}

/**
 * Returns true if the current page was requested with the POST method
 *
 * @return boolean
 */
function RequestIsPost()
{
	return $_SERVER['REQUEST_METHOD'] == 'POST' ? 1 : 0;
}

function WrapHeader($header)
{
	if(php_sapi_name() == "cli")
		echo  "header => $header\n";
	else
		header($header);
}

/**
 * Evaluates the POST variables and creates a standard "year-month-day Hour24:minute:second -7:00" date from a POSTed form
 * The fields in the form should be as follows:
 * <name>Month, <name>Day, <name>Year
 * <name>Hour, <name>Minute, <name>Second
 * <name>Meridian (<-- "am" or "pm")
 * 
 * @param $name Prefix of the POST variables to evaluate
 * @return string Date string
 */

function GetFormDate($name, $src = null)
{
	if(!$src)
		$src = $_POST;
	
	if(is_array($src[$name]))
	{
		$year = $src[$name]['Date_Year'];
		$month = $src[$name]['Date_Month'];
		$day = $src[$name]['Date_Day'];
	}
	else
	{
		$name = "{$name}_";
		$month = $src[$name . 'Month'];
		$day = $src[$name . 'Day'];
		$year = $src[$name . 'Year'];
	}
	
	return "$year-$month-$day";
}

/*
there should be separate functions for date and time
function GetPostDate($name)
{
	//echo_r($_POST);
	$name = "{$name}_";
	$month = $_POST[$name . 'Month'];
	$day = $_POST[$name . 'Day'];
	$year = $_POST[$name . 'Year'];
	$hour = $_POST[$name . 'Hour'];
	$minute = $_POST[$name . 'Minute'];
	$second = $_POST[$name . 'Second'];
	$meridian = $_POST[$name . 'Meridian'];
	
	$hour = $meridian == 'pm' ? ($hour + 12) : $hour;
	
	return "$year-$month-$day $hour:$minute:$second -7:00";
}
*/


/**
 * print_r the contents of the variable $var along with a full function backtrace to indicate where in the program this is occurring (great for debugging)
 *
 * @param mixed $var Variable to print
 * @param boolean $supressBacktrace True if you wish to suppress the backtrace (default: False)
 */
function echo_r($var, $showBacktrace = NULL)
{
	if(is_null($showBacktrace))
		$showBacktrace = Config::get('zinc.debug.echorShowBacktrace');
	
	if($showBacktrace)
		EchoBacktrace();
	
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

/**
 * Redirect the client browser to $url
 *
 * @param string $url URL to which to send them
 */
function Redirect($url = NULL)
{
	if(!$url)
		$url = virtual_url;
	header("location: $url");
	die();
}

/**
 * Redirects the client to a URL relative to the project (index.php/<url>)
 *
 * @param string $virtualPath Path inside the project to which to send them
 */
function BaseRedirect($virtualPath)
{
	Redirect(script_url . '/' . $virtualPath);
}

function sendAjaxSuccess($params = array())
{
	if(!isset($params['success']))
		$params['success'] = true;
	header('Content-type: application/json');
	define('app_logprofile_skip_print', true);
	echo json_encode($params);
	die();
}


/**
 * Echos an HTML-formatted backtrace
 *
 * @param unknown_type $value I don't know what this is for
 */
function EchoBacktrace($value='')
{
	echo FormatBacktraceHtml(debug_backtrace());
}


/**
 * Generates and prints backtrace information in readable HTML
 *
 * @param debug_backtrace() $backtraceInfo The results of a debug_backtrace() function call
 */
function FormatBacktraceHtml($backtraceInfo)
{
	// debug_print_backtrace();
	// return;
	//echo_r($backtraceInfo);
?>
<table border="1">
	<tr>
		<th>File</th><th>Line</th><th>Function</th>
	</tr>
	<?php  foreach($backtraceInfo as $thisRow): 
		$lineInfo = FormateBacktraceLineHtml($thisRow);
	?><tr>
		<td><?php echo $lineInfo['file']; ?></td>
		<td><?php echo $lineInfo['line']; ?></td>
		<td><?php echo $lineInfo['function']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php
}

function FormateBacktraceLineHtml($lineInfo)
{
	// echo_r($lineInfo);
	$result = array();
	$result['file'] = isset($lineInfo['file']) ? $lineInfo['file'] : 'php function';
	$result['line'] = isset($lineInfo['line']) ? $lineInfo['line'] : 'na';
	$result['function'] = FormatBacktraceFunctionCellHtml($lineInfo);
	return $result;
}

function FormatBacktraceFunctionCellHtml($lineInfo)
{
//	echo "here we are<br>";
//	var_dump($lineInfo);
//	echo_r($lineInfo);
	$call = '';
	$call .= isset($lineInfo['class']) ? ($lineInfo['class'] . $lineInfo['type']) : '';
	$call .= $lineInfo['function'] . '(';
	$argStrings = array();
	
	if(isset($lineInfo['args']))
	foreach($lineInfo['args'] as $thisArg)
	{
//		echo '<b>arg = ' . $thisArg . '</b><br>';
//		echo '<b>type = ' . gettype($thisArg) . '</b>';
//		echo_r($thisArg);
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
		
//		echo '<strong>call = ' . $call . '</strong><br>';
	}
	
	$call .= implode(', ', $argStrings);
	
	$call .= ')';
	
	return $call;
}


function FormatBytes($bytes, $precision = 1)
{
	$base = log($bytes) / log(1024);
	$suffixes = array('B', 'KB', 'MB', 'GB', 'TB');	 
	
	return number_format(round(pow(1024, $base - floor($base)), $precision), $precision, '.', '') . ' ' . $suffixes[floor($base)];
}


function UniqueId($prefix = "")
{
	return str_replace('.', '', uniqid($prefix, true));
}

/**
 * Given a filename, outputs the contents of the file to the client
 *
 * @param string $filename Path and filename of the file to output
 */
function EchoStaticFile($filename)
{
	$fp = fopen($filename, 'rb');
	
	//	send the headers
	//header("Content-Type: image/png");	//	figure out what should really be done here
	header("Content-Length: " . filesize($filename));	//	also we want to be able to properly set the cache headers here
	
	fpassthru($fp);
}


/**
 * Returns a list of files in the specified directory, optionally filtered by the values in array $extention
 *
 * @param string $path $path Directory path to scan
 * @param array $params Array of file extensions (without leading ".")
 * @return array Array of filenames found in the directory
 */
function ListDir($path, $params)
{
	$entries = array();
	$d = dir($path);
	while (false !== ($entry = $d->read()))
	{
		$keep = 1;
		if(isset($params['extentions']))
		{
			$keep = 0;
			$extention = GetFileExtention($entry);
			
			if(in_array($extention, $params['extentions']))
				//echo $extention . "\n";
				$keep = 1;
		}
		
		if($keep)
			$entries[] = $entry;
	}
	$d->close();
	
	return $entries;
}

function WalkDir($dir, $action)
{
	trigger_error("this function is not done");
	$d = dir($dir);
	while (false !== ($entry = $d->read()))
	{
		if($entry == '.' || $entry == '..')
			continue;
		
		echo $entry."\n";
		$action($entry);
	}
	$d->close();
}

function dir_r($path, $action)
{
	$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
	foreach($it as $filename => $cur)
	{
		$action($it, $cur);
	}
}

/**
 * Return the extension of the given filename
 *
 * @param string $filename Filename to process
 * @return string extension of the filename
 */
function GetFileExtention($filename)
{
	$parts = explode('.', $filename);
	return array_pop($parts);
}

function ext($filename)
{
	$info = pathinfo($filename);
	return $info['extension'];
}

/**
 * Appends a prefix to a string, if given prefix doesn't already exist
 *
 * @param string $string String to analyze
 * @param string $prefix Prefix to append (if it isn't already there)
 * @return string Prefixed string
 */
function str_prefix($string, $prefix)
{
	return substr($string, 0, strlen($prefix)) == $prefix ? 1 : 0;
}

function StripMagicQuotesFromPost()
{
	_StripMagicQuotes($_POST);
}

function StripMagicQuotesFromGet()
{
	_StripMagicQuotes($_GET);
}

function _StripMagicQuotes(&$cur)
{
	foreach($cur as $key => $val)
	{
		if(gettype($val) == 'string')
			$cur[$key] = stripslashes($val);
		else if(gettype($val) == 'array')
			_StripMagicQuotes($cur[$key]);
	}
}

//	adapted from the excellent phpass security package
function GetRandomBytes($count, $allowFallback = false)
{
	$output = '';
	if(($fh = fopen('/dev/urandom', 'rb')))
	{
		$output = fread($fh, $count);
		fclose($fh);
	}

	if (strlen($output) < $count)
	{
		if(!$allowFallback)
			trigger_error('system could not generate enough random data');
		
		$output = '';
		for ($i = 0; $i < $count; $i += 16) {
			$this->random_state =
			    md5(microtime() . $this->random_state);
			$output .=
			    pack('H*', md5($this->random_state));
		}
		$output = substr($output, 0, $count);
	}

	return $output;
}

function RandString($chars)
{
	$final = '';
	$charsLeft = $chars;
	
	do {
		$readChars = $chars;
		$contents = GetRandomBytes($charsLeft);
		
		$contents = preg_replace('/[^a-zA-Z0-9]+/', '', base64_encode($contents));
		$final .= substr($contents, 0, $charsLeft);
		$charsLeft = $chars - strlen($final);
	}
	while($charsLeft);
	
	return $final;
}

function GetNonEmptyLines($text)
{
	$lines = array();
	$text = str_replace("\r", "\n", $text);
	$allLines = explode("\n", $text);
	foreach($allLines as $line)
	{
		if($line)
			$lines[] = $line;
	}
	
	return $lines;
}

function ForceSSL()
{
	// if(!IsSSL())
	// 	Redirect(ssl_virtual_url);
}

function ForcePlain()
{
	// if(IsSSL())
	// 	Redirect(plain_virtual_url);
}

function IsSSL()
{
	return true;
	return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on";
}

if(!function_exists('password_hash'))
{
	define('PASSWORD_BCRYPT', 1);
	
	function password_hash($password, $method = PASSWORD_BCRYPT)
	{
		switch($method)
		{
			case PASSWORD_BCRYPT:
				// make sure blowfish is available
				if(!defined('CRYPT_BLOWFISH') || CRYPT_BLOWFISH !== 1)
					trigger_error('blowfish encryption not supported');
				
				// create the salt
				if(version_compare(PHP_VERSION, '5.3.7') >= 0)
					$salt = '$2y$08$';
				else
					$salt = '$2a$08$';
				$salt .= RandString(22);
				
				// get the hash
				$hash = crypt($password, $salt);
				
				// make sure it returned a valid hash
				if(strlen($hash) !== 60)
					trigger_error("invalid salt caused crypt to fail");
				break;
			default:
				trigger_error("unknown hash method");
		}
		
		return $hash;
	}
	
	function password_verify($password, $hash)
	{
		return crypt($password, $hash) === $hash ? true : false;
	}
}
