<?php
class AppGui extends Gui
{
	public function display($templateName)
	{
		$this->autoInherit();
		
		// do global assigns here
		parent::display($templateName);
	}
}
