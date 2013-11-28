<?php
class ServiceZone extends Zone
{
	public function initPages()
	{
		ErrorSettings::setDisplayMode('cli');
		header('Content-Type: application/json');
	}
	
	public function runPage($pageName, $pageParams, $zoneParams)
	{
		$pageValue = $this->$pageName($pageParams, $zoneParams);
		echo json_encode($pageValue);
	}
	
}