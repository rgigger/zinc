<?php
/**
 * class Application
 *
 * @package app
 * @author Rick Gigger
 **/
class Application
{
	function __construct()
	{
		// the instance now calls $app->init()
		// $this->init();
	}
	
	public function init() {}
	
	/*
	 * 
	 * name: Condition
	 * @param bool 		a true/false condition
	 * @param closure	if !bool, then closure()
	 * @return
	 * 
	 */
	static public function Condition($bool, $closure)
	{
		if(!$bool)
			$closure();
	}
	
	/*
	 * 
	 * name: ConditionBaseRedirect
	 * @param bool
	 * @param url	an application url (everything after index.php)
	 * @return
	 * 
	 */
	static public function ConditionBaseRedirect($bool, $url)
	{
		self::Condition($bool, function () use ($url) {
			BaseRedirect($url);
		});
	}
	
	/*
	 * 
	 * name: ConditionRedirect
	 * @param bool
	 * @param url	a full url
	 * @return
	 * 
	 */
	static public function ConditionRedirect($bool, $url)
	{
		self::Condition($bool, function () use ($url) {
			redirect($url);
		});
	}
	
	/*
	 * 
	 * name: ConditionError
	 * @param bool
	 * @param errorMessage	An error message to log with the error.
	 * @return
	 * 
	 */
	static public function ConditionError($bool, $errorMessage)
	{
		self::Condition($bool, function () use ($errorMessage) {
			trigger_error($errorMessage);
			die();
		});
	}
}
