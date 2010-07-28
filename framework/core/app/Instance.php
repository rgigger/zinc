<?php
class Instance
{
	private $app;
	
	function __construct()
	{
		include app_dir . '/App.php';
		$this->app = new App();
		$this->app->init();
	}
	
	public function handleRequest()
	{
		$this->app->handleRequest();
	}
}