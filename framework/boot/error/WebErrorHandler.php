<?php
class WebErrorHandler
{
	static function throwException($errno, $errstr, $errfile, $errline, $context, $backtrace = NULL)
	{
		// maybe we should use this here: http://us3.php.net/manual/en/class.errorexception.php
		$e = new Exception($errstr, $errno);
		// echo_r($e);
		// die();
		// $e->setFile($errfile);
		// $e->setLine($errline);
		throw $e;
	}
	
	static function handleError($errno, $errstr, $errfile, $errline, $context, $backtrace = NULL)
	{
		header('HTTP/1.1 500 Internal Server Error');
		
		if((error_reporting() & $errno) !== $errno)
			return true;
			
		if(!defined('app_status'))
			define('app_status', 'dev');
		
		$configStatus = Config::get('zinc.error.reportStatus');
		$errorStatus = $configStatus ? $configStatus : app_status;
		
		switch($errorStatus)
		{
			case 'dev':
				self::handleDevError($errno, $errstr, $errfile, $errline, $context, $backtrace);
				break;
			
			case 'test':
				self::handleTestError($errno, $errstr, $errfile, $errline, $context, $backtrace);
				// trigger_error('status not handled:' . app_status);
				break;
			
			case 'live':
				trigger_error('status not handled:' . app_status);
				break;
			
			default:
				trigger_error('status not handled:' . app_status);
				break;
		}
	}
	
	static function handleDevError($errno, $errstr, $errfile, $errline, $context, $backtraceInfo)
	{
		$errorLine = self::formatErrorLineHtml($errno, $errstr, $errfile, $errline, $context, $backtraceInfo);
		echo '<p>' . $errorLine . '</p>';
		$backtraceInfo = $backtraceInfo ? $backtraceInfo : debug_backtrace();
		$backtrace = new Backtrace($backtraceInfo);
		$backtrace->display();
	}
	
	static function handleTestError($errno, $errstr, $errfile, $errline, $context, $backtraceInfo)
	{
		// generate a unique id for this entry in the error log
		$errorId = uniqid();
		
		// format the backtrace and log the error
		$errorLine = self::formatErrorLineHtml($errno, $errstr, $errfile, $errline, $context, $backtraceInfo);
		error_log("<p>error #{$errorId}:</p>", 3, instance_dir . '/var/log/error.html');
		error_log('<p>' . $errorLine . '</p>', 3, instance_dir . '/var/log/error.html');
		$backtraceInfo = $backtraceInfo ? $backtraceInfo : debug_backtrace();
		$backtrace = new Backtrace($backtraceInfo);
		error_log($backtrace->toHtml(), 3, instance_dir . '/var/log/error.html');
		
		// wipe out all output buffers
		while (ob_get_level()) { 
			ob_end_clean(); 
		}
		
		// display the error code 
		echo "error #{$errorId}";
		die();
	}
	
	static function formatErrorLineHtml($errno, $errstr, $errfile, $errline, $context)
	{
		$line = '';
		switch ($errno)
		{
			case E_ERROR:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
				die('this should never happen');
				break;
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_STRICT:
//			case E_RECOVERABLE_ERROR:
				$line .= '<strong>Error type not yet handled: ' . $errno . '</strong>';
				break;
			case E_WARNING:
				$line .= '<strong>Warning:</strong>';
				break;
			case E_NOTICE:
				$line .= '<strong>Notice:</strong>';
				break;
			case E_USER_NOTICE:
				$line .= '<strong>User Notice:</strong>';
				break;
			case E_DEPRECATED:
				$line .= '<strong>Depricated:</strong>';
				break;
			case E_USER_ERROR:
				$line .= '<strong>User Error:</strong>';
				break;
			case E_USER_WARNING:
				$line .= '<strong>User Warning:</strong>';
				break;
			case 0:
				$line .= '<strong>Exception:</strong>';
				break;
			default:
				$line .= '<strong>Undefined error type: ' . $errno . '</strong>';
			break;
		}
		
		$line .= ' "' . $errstr . '"';
		$line .= ' in file ' . $errfile;
		$line .= ' ( on line  ' . $errline . ')';
		
		return $line;
	}
	
	static function exceptionHandler($exception)
	{
		echo '<b>' . get_class($exception) . "</b><br>\n";
		self::handleError($exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine(), NULL, $exception->getTrace());
	}
}

