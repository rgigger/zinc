<?php
class AppGui extends Gui
{
	function fetch($tpl_file, $cache_id = null, $compile_id = null, $display = false)
	{
		$this->assign("TEMPLATE_CONTENT", $tpl_file);
		
		$this->assign('topnav', Config::get('app.topnav'));
		$this->assign('randomBlock', $this->getRandomBlockMarkup());
		
		return parent::fetch('layouts/main.tpl', $cache_id, $compile_id, $display);
	}
	
	private function getRandomBlockMarkup()
	{
		$options = array('design');
		$choice = array_rand($options);
		$choice = $options[$choice];
		return parent::fetch("blocks/{$choice}.tpl");
	}
}
