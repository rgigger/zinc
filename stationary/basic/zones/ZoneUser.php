<?php
class ZoneUser extends AppZone
{
	public function pageDefault($p, $z)
	{
		die('ZoneUser::pageDefault');
	}
	
	public function pageList($p, $z)
	{
		$this->assign('people', Person::find());
	}
	
	public function pageEdit($p, $z)
	{
		$this->assign('person', new Person);
	}
	
	public function postEdit($p, $z)
	{
		Form::save();
		$this->redirect('list');
	}
	
	public function postSendEmail($p, $z)
	{
		$person = new Person($p[1]);
		$token = $person->generateToken('resetPassword');
		
		$message = new GuiMessage();
		$message->setFrom('thesystem@rickgigger.com', 'The System');
		$message->addTo($person->getEmail(), $person->getName());
		$message->setSubject('password reset');
		
		$message->assign('token', $token);
		$message->send('messages/setPassword.tpl');
		
		die();
	}
}
