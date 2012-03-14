<?php
class Person extends DbObject
{
	static public function hashPassword($password, $salt = null)
	{
		if(is_null($salt))
		{
			$longSalt = sha1(rand());
			$salt = substr($longSalt, 0, 5);
		}
		$hash = sha1($salt . $password);
		return 'sha1$' . $salt . '$' . $hash;
	}
	
	static public function auth($username, $password)
	{
		$userInfo = SqlFetchRow("SELECT id, password from person where username = :username", array('username' => $username));
		if(!$userInfo)
			return false;
		
		$parts = explode('$', $userInfo['password']);
		assert($parts[0] == 'sha1');
		$salt = $parts[1];
		if( self::hashPassword($password, $salt) !== $userInfo['password'] )
			return false;
		
		return $userInfo['id'];
	}
	
	static public function getLoggedInUser()
	{
		if(!isset($_SESSION['personId']) || !$_SESSION['personId'])
			return false;
		
		return new Person($_SESSION['personId']);
	}
	
	public function login()
	{
		$_SESSION['personId'] = $this->id;
		session::saveChangesUnsafe();
	}
	
	public function getName()
	{
		return "{$this->firstname} {$this->lastname}";
	}
	
	public function getEmail()
	{
		return $this->username;
	}
	
	public function generateToken($func)
	{
		assert($this->getBound());
		return Token::factory($this->id, $func, null);
	}
}
