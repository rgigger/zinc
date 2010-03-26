<?php
class ZoneDefault extends AppZone
{
	public function initPages($p, $z)
	{
		$this->assign('curtab', $p[0]);
	}
	
	public function pageDefault()
	{
		$this->redirect('home');
	}
	
	public function pageHome()
	{
		$this->assign('isList', true);
		$this->assign('entries', Content::getPageOfEntries());
	}
	
	public function pageContact($p, $z)
	{
	}
	
	public function pageLinks($p, $z)
	{
	}
	
	public function pageBlog($p, $z)
	{
	}
	
	public function pageDrafts($p, $z)
	{
		$this->assign('entries', Content::getDrafts());
	}
	
	public function pageAbout($p, $z)
	{
		$cssFiles = array('1' => 'one.css',
						  '2' => 'two.css',
						  '3' => 'three.css',
						  '4' => 'four.css',
						  'alt1' => 'alt1.css');
		if(isset($p[1]) && isset($cssFiles[$p[1]]))
			$this->assign('cssFile', $cssFiles[$p[1]]);
	}
	
	public function postLogin($p, $z)
	{
		$user = DbObject::_findOne('Person', array('username' => $_POST['username'], 'password' => $_POST['password']));
		if($user)
		{
			$_SESSION['personId'] = $user->id;
			session::saveChangesUnsafe();
		}
		Redirect($_SERVER['HTTP_REFERER']);
	}
}
