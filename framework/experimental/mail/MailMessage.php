<?php
class MailMessage
{
	private $from;
	private $tos = array();
	private $subject;
	private $text;
	private $html;
	
	public function setFrom($address, $name = null)
	{
		$this->from = array('address' => $address, 'name' => $name);
	}
	
	public function getFrom()
	{
		return $this->from;
	}
	
	public function addTo($address, $name = null)
	{
		$this->tos[] = array('address' => $address, 'name' => $name);
	}
	
	public function getTos()
	{
		return $this->tos;
	}
	
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}
	
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function setText($text)
	{
		$this->text = $text;
	}
	
	public function getText()
	{
		return $this->text;
	}
	
	public function setHtml($html)
	{
		$this->html = $html;
	}
	
	public function getHtml()
	{
		return $this->html;
	}
	
	public function send($connectionName = 'default')
	{
		$connection = MailModule::getConnection($connectionName);
		$connection->send($this);		
	}
}
