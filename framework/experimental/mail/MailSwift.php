<?php
class MailSwift extends MailConnection
{
	private $connection;
	
	public function init()
	{
	}
	
	public function getRequireds()
	{
		return array('host', 'port', 'encryption', 'username', 'password');
	}
	
	private function connect()
	{
		//	lazy connection to the database
		if(!$this->connection)
		{
			$transport = Swift_SmtpTransport::newInstance()
				->setHost($this->params['host'])
				->setPort($this->params['port'])
				->setEncryption($this->params['encryption'])
				->setUsername($this->params['username'])
				->setPassword($this->params['password']);
			$this->connection = Swift_Mailer::newInstance($transport);	
		}
	}
	
	public function send($message)
	{
		// create a message
		$swiftMessage = Swift_Message::newInstance($message->getSubject());
		
		// handle the from
		$from = $message->getFrom();
		if(!$from)
			$from = $this->getDefaultFrom();
		
		if(!$from)
			trigger_error("no from address specified");
		
		$swiftMessage->setFrom(array($from['address'] => $from['name']));
		
		// handle the tos
		$tos = array();
		foreach($message->getTos() as $to)
			if($to['name'])
				$tos[$to['address']] = $to['name'];
			else
				$tos[] = $to['address'];
		$swiftMessage->setTo($tos);
		
		// set the body
		// echo $message->getText();
		// die();
		$swiftMessage->addPart($message->getText(), 'text/plain');
		if($message->getHtml())
			$swiftMessage->addPart($message->getHtml(), 'text/html');
		
		// send the message
		$this->connect();
		// print_r($this->connection);
		$numSent = $this->connection->send($swiftMessage);
		
		if($numSent < 1)
			trigger_error("no message sent");
	}	
}
