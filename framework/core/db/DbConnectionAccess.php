<?php
leaving this in in case I decide to come back to it later, I am going to try this another way though
class DbConnectionAccess
{
	public function __get($name)
	{
		return DbModule::getConnection
	}
}