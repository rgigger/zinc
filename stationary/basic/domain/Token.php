<?php
class Token extends DbObject
{
	// for generating a new token
	static public function factory($personId, $function, $expireDate = null)
	{
		$token = new Token();
		$token->person_id = $personId;
		$token->token = str_replace('.', '', uniqid('', true));
		$token->function = $function;
		$token->expire_date = $expireDate;
		$token->save();
		
		return $token;
	}
	
	// for looking up an exisitng token by $tokenString and $function
	static public function lookup($tokenString, $function)
	{
		return Token::findOne(array('token' => $tokenString, 'function' => $function));
	}
	
	public function init()
	{
		$this->belongsTo('Person');
	}
}
