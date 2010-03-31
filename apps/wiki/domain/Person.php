<?php
class Person extends DbObject
{
	static public function getLoggedInUser()
	{
		if(isset($_SESSION['personId']))
			return new Person($_SESSION['personId']);
		else
			return false;
	}
}