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
	}
	
	public function pageLinks($p, $z)
	{
	}
	
	public function pageBlog($p, $z)
	{
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
}