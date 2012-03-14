<?php
class GuiMessage
{
	// private $gui, $message;
	private $message, $assigns;
	
	function __construct()
	{
		$this->message = new MailMessage();
	}
	
	private function getGui()
	{
		return new AppGui();
		
		// I will put this back in once we actually run into a situation where we want this flexibility and understand
		// better how we want it to be implemented
		// 
		// if($this->gui)
		// 	return $this->gui;
		// else if(class_exists('AppGui'))
		// 	$className = 'AppGui';
		// else
		// 	$className = 'Gui';
		// 
		// return new $className();
	}
	
	// public function setGui($gui)
	// {
	// 	$this->gui = $gui;
	// }
	
	private function getMessage()
	{
		return $this->message;
	}
	
	// public function setMessage($message)
	// {
	// 	$this->message = $message;
	// }
	
	public function setSubject($subject)
	{
		$this->message->setSubject($subject);
	}
	
	public function setFrom($address, $name = null)
	{
		$this->message->setFrom($address, $name);
	}
	
	public function addTo($address, $name = null)
	{
		$this->message->addTo($address, $name);
	}
	
	public function assign($name, $value)
	{
		$this->assigns[$name] = $value;
	}
	
	public function send($textTemplate, $htmlTemplate = null)
	{
		$gui = $this->getGui();
		
		foreach($this->assigns as $name => $value)
			$gui->assign($name, $value);
		
		// implement the headers filter stuff here
		// echo "$textTemplate";
		// echo $gui->fetch($textTemplate);
		// die();
		// $this->message->setSubject('this is some other subject');
		
		$this->message->setText($gui->fetch($textTemplate));
		if($htmlTemplate)
			$this->message->setHtml($gui->fetch($htmlTemplate));
		$this->message->send();
	}
}
