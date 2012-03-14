<?php
class ZoneDefault extends AppZone
{
	function pageDefault()
	{
		// echo $asdf;
	}
	
	public function pageResetPassword($p, $z)
	{
		$token = Token::lookup($p[1], 'resetPassword');
		if(!$token)
			trigger_error("you should probably handle inadvertant accesses to this page more gracefully than just throwing and error");
		$this->assign('person', $token->Person);
	}
	
	public function postResetPassword($p, $z)
	{
		Form::set('Person', function($person) {
			$person->password = Person::hashPassword($person->password);
		});
		$objects = Form::save();
		
		$person = current($objects);
		assert($person instanceof Person);
		
		$person->login();
		
		$message = new GuiMessage();
		$message->setFrom('thesystem@rickgigger.com', 'The System');
		$message->addTo($person->username);
		$message->setSubject("{$person->firstname}, your password has been reset");
		$message->assign('person', $person);
		$message->send('messages/confirmPasswordReset.tpl');
		
		BaseRedirect('install/list');
	}
	
}
