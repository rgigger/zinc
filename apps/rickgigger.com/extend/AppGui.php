<?php
class AppGui extends Gui
{
	public function display($templateName)
	{
		$this->assign('loggedInUser', Person::getLoggedInUser());
		$this->assign('topnav', Config::get('app.topnav'));
		$this->assign('randoms', $this->getRandoms());
		
		parent::display($templateName);
	}
	
	private function getRandoms()
	{
		$options = array('design');
		$choice = array_rand($options);
		$choice = $options[$choice];
		return array($choice);
	}
}
