<?php
/**
 * Configuration class
 * 
 * Provides methods for retrieving configuration options from a YAML config file.
 *
 */
class Config
{
	private static $info = array();
	// private static $file;
	
	static public function suggest($file, $prefix = NULL)
	{
		if($prefix)
			$root = &self::getReference($prefix);
		else
			$root = &self::$info;
		
		$root = self::mergeArray(Yaml::read($file), $root);
	}
	
	static public function insist($file, $prefix = NULL)
	{
		// echo "inisting: $file<br>";
		if($prefix)
			$root = &self::getReference($prefix);
		else
			$root = &self::$info;
		$root = self::mergeArray($root, Yaml::read($file));
	}
	
	static public function mergeArray($suggested, $insisted)
	{
		return self::_mergeArray($suggested, $insisted);
	}
	
	static public function _mergeArray(&$suggested, &$insisted)
	{
		if(is_array($insisted))
		{
			foreach($insisted as $key => $val)
			{
				if(is_array($val))
					self::_mergeArray($suggested[$key], $insisted[$key]);
				else
					$suggested[$key] = $val;
			}
		}
		
		return $suggested;
	}
	
	/**
	 * Specify configuration file to use
	 *
	 * @param string $file Path and filename of the config file to use
	 */
	// static function setConfigFile($file)
	// {
	// 	self::$file = $file;
	// }
	
	/**
	 * Loads the config files
	 *	app_dir/config.yaml
	 * 	instance_dir/config.yaml	
	 */
	static function load()
	{
		self::suggest(zinc_dir . '/config.yaml', 'zinc');
		
		// if(!self::$file)
		// 	self::setConfigFile(app_dir . '/config.yaml');
		// self::insist(self::$file);
		
		if(defined('app_dir') && app_dir)
			self::insist(app_dir . '/config.yaml');
		
		if(defined('instance_dir') && instance_dir)
			self::insist(instance_dir . '/config.yaml');
	}
	
	/**
	 * Returns configuration options based on a path (i.e. zoop.db or zoop.application.info)
	 *
	 * @param string $path Path for which to fetch options
	 * @return array of configuration values
	 */
	static function get($path = '')
	{
		if($path === '')
			return self::$info;
		
		$parts = explode('.', $path);
		$cur = self::$info;
		
		foreach($parts as $thisPart)
			if(isset($cur[$thisPart]))
				$cur = $cur[$thisPart];
			else
				return false;
		
		return $cur;
	}
	
	static function set($path, $val)
	{
		$parts = explode('.', $path);
		$cur = &self::$info;
		
		foreach($parts as $thisPart)
			if(isset($cur[$thisPart]))
				$cur = &$cur[$thisPart];
			else
			{
				$cur[$thisPart] = array();
				$cur = &$cur[$thisPart];
			}
		$cur = $val;
		return $cur;
	}
	
	static function &getReference($path)
	{
		$parts = explode('.', $path);
		$cur = &self::$info;
		
		foreach($parts as $thisPart)
		{
			if(isset($cur[$thisPart]))
				$cur = &$cur[$thisPart];
			else
			{
				$cur[$thisPart] = array();
				$cur = &$cur[$thisPart];
			}
		}
		
		return $cur;
	}
	
	//	functions for getting scalar values and then formatting them
	static public function getFilePath($configPath)
	{
		$config = self::get($configPath);
		assert(is_string($config));
		return Zoop::expandPath($config);
	}
}
