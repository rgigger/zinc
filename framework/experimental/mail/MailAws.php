<?php
class MailAws extends MailConnection
{
	private $connection;
	
	public function init()
	{
	}
	
	public function getRequireds()
	{
		return array('key', 'secretKey');
	}
	
	private function connect()
	{
		//	lazy connection to the database
		if(!$this->connection)
			$this->connection = new AmazonSES($this->params['key'], $this->params['secretKey']);
	}
	
	public function send($message)
	{
		// handle the from
		$oldFrom = $message->getFrom();
		if($oldFrom['name'])
			$newFrom = $oldFrom['name'] . ' <' . $oldFrom['address'] . '>';
		else
			$newFrom = $oldFrom['address'];
		
		// handle the tos
		$tos = array();
		foreach($message->getTos() as $to)
			if($to['name'])
				$tos[] = $to['name'] . ' <' . $to['address'] . '>';
			else
				$tos[] = $to['address'];
		
		// send the message
		$this->connect();
		$response = $this->connection->send_email(
			$newFrom,
			array(
				'ToAddresses' => $tos
			),
			array(
				'Subject.Data' => $message->getSubject(),
				'Body.Text.Data' => $message->getText(),
				'Body.Html.Data' => $message->getHtml()
		    )
		);
		
		if($response->status != 200)
			trigger_error("ses error: {$response->body->Error->Type} : {$response->body->Error->Code} : {$response->body->Error->Message}");
	}	
}
