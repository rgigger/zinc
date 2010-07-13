<?php
class AppZone extends GuiZone
{
	function __construct()
	{
		$this->layout = 'main';
	}
	
	// function chooseGui($guiType)
	// {
	// 	switch($guiType)
	// 	{
	// 		case 'main':
	// 			$gui = new AppGui();
	// 			$gui->setLayout($this->layout);
	// 			break;
	// 		
	// 		default:
	// 			trigger_error("unknown gui type: $guiType");
	// 			break;
	// 	}
	// 	
	// 	$gui->assign('showTopNav', 1);
	// 	// $gui->assign('topnav', array('Tasks' => 'task', 'Important' => 'important', 'Work Today' => 'worktoday'));
	// 	$gui->assign('topnav', array());
	// 	
	// 	return $gui;
	// }
	
	function closePages($p, $z)
	{
		if(!$this->displayed())
			$this->display($p[0]);
	}
	
	//	there's probably a better way to do this.  this is just to change the default for guiType
	//	we could just make NULL mean 'main' in chooseGui above
	// function display($templateName, $guiType = 'main')
	// {
	// 	parent::display($templateName, $guiType);
	// }
}
