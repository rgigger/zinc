<?php
abstract class ZincLibrary
{
	/**
	 * mods is a key value array with one item per module in the library
	 * the key is always the name of the module
	 * the value is either the module object if the mod is loaded or false if it's not
	 */
	private $mods;
	private $path;
	
	/**
	 * Stuff about the constructor
	 *
	 * @return ZoopLibrary
	 */
	final function __construct($path)
	{
		$this->path = $path;
		$this->mods = array();
		$this->init();
	}
	
	protected function registerMod($name)
	{
		if(!isset($this->mods[$name]))
			$this->mods[$name] = false;
	}
	
	public function hasMod($name)
	{
		return isset($this->mods[$name]);
	}
	
	public function getMod($name)
	{
		return $this->mods[$name];
	}
	
	public function loadMod($name)
	{
		//	if this library doesn't have this module then Zoop will have to figure out which one does
		if(!$this->hasMod($name))
			return Zoop::loadMod($name);
		
		if(isset($this->mods[$name]) && $this->mods[$name])
			return;
		$modName = ucfirst($name) . 'Module';
		include("$this->path/$name/$modName.php");
		$this->mods[$name] = new $modName("$this->path/$name", $this);
	}
	
	public function loadMods()
	{
		foreach($this->mods as $name => $mod)
		{
			if(!$mod)
				$this->loadMod($name);
		}
	}
}