<?php
// for backwards compatibility
include_once __dir__ . '/Zoop.php';

// do some bootstrapping
if(!defined("zinc_dir"))
	define("zinc_dir", __dir__);
else
	trigger_error("zinc dir should be defined by including Zinc.php");

// for backwards compatibility
define('zoop_dir', zinc_dir);


function define_once($name, $value)
{
	if(!defined($name))
		define($name, $value);
}

//	now we load the default config for zoop
// include(zoop_dir . '/config.php');	//	this file is now obsolete and depricated, in favor of the new config module
include(zinc_dir . '/ZincLibrary.php');
include(zinc_dir . '/ZincModule.php');
include(zinc_dir . '/ZincLoader.php');

//	we want to load this before we do anything else so that everything else is easier to debug
// include(zoop_dir . '/core/app/Error.php');
// include(zoop_dir . '/core/app/Globals.php');

/**
 * This object is for basic framework management tasks, such as:
 * * Configuring auto-loading of zones and modules
 * * Loading libraries and domains
 */
class Zinc
{
	// static private $loaded = array(), $registered = array();
	static private $libs = array();
	
	/**
	 * registers a library
	 */
	
	static public function registerLib($libName, $path = null)
	{
		if(!$path)
			$path = zinc_dir . '/' . $libName;
		
		if(isset(self::$libs[$libName]))
			return;
		$libClassName = ucfirst($libName) . 'Library';
		include("$path/$libClassName.php");
		self::$libs[$libName] = new $libClassName($path);
	}
	
	/**
	 * loads a library, which just means loading all of it's modules
	 */
	
	static public function loadLib($libName)
	{
		// for check is for backwards compatibility
		//	in the future we can depricate it and change the self::loadMod
		//	call to a trigger_error("lib '$libName' not found") call
		if(isset(self::$libs[$libName]))
			self::$libs[$libName]->loadMods();
		else
			self::loadMod($libName);
	}
	
	/**
	 * finds out what lib a module is in and then loads it
	 */
	
	static public function loadMod($modName)
	{
		foreach(self::$libs as $lib)
			if($lib->hasMod($modName))
				return $lib->loadMod($modName);
		
		trigger_error("mod '$modName' not found");
	}
	
	static public function getModDir($modName)
	{
		foreach(self::$libs as $lib)
		{
			if($lib->hasMod($modName))
				return $lib->getModDir($modName);
		}
		
		trigger_error("mod '$modName' not found");
	}
	
	static public function getMod($modName)
	{
		foreach(self::$libs as $lib)
		{
			if($lib->hasMod($modName))
				return $lib->getMod($modName);
		}
		
		trigger_error("mod '$modName' not found");
	}
	
	static public function expandPath($path)
	{
		if($path[0] == '/')
			return $path;
		
		return app_dir . '/' . $path;
	}
	
	static public function getTmpDir()
	{
		return Config::getFilePath('zinc.tmpDir');;
	}
	
	static public function scan($dirs)
	{
		foreach($dirs as $dir)
		{
			$fullDir = app_dir . '/' . $dir;
			
			// get the timestamp on reg.php
			$regStat = stat(app_dir . '/' . $dir . '/reg.php');
			// echo_r($regStat);
			
			// check the timestamp on the dir
			// ------- you should also be checking any sub directories
			$dirStat = stat(app_dir . '/' . $dir);
			
			// the directory was changed after reg.php then recreate reg.php
			if($dirStat['mtime'] > $regStat['mtime'] && is_writable("$fullDir/reg.php"))
			{
				$classes = array();
				dir_r($fullDir, function($it, $cur) use (&$classes, $dir) {
					$info = pathinfo($cur->getPathName());
					if($info['extension'] == 'php' && $info['basename'] != 'reg.php')
					{
						$subPath = $it->getSubPath() ? "/" . $it->getSubPath() : '';
						$classes[$info['filename']] = "$dir$subPath";
					}
				});
				// echo_r($classes);
				ksort($classes);
				$regString = '<?php' . "\n";
				$regString .= 'Zinc::registerClasses(array(' . "\n";
				foreach($classes as $name => $dir)
					$regString .= "\t'$name' => '$dir',\n";
				$regString .= '));' . "\n";
				
				file_put_contents("$fullDir/reg.php", $regString);
			}
			
			include("$fullDir/reg.php");
		}
	}
	
	/**
	 * static -- Register a class for auto-loading with the name of the class
	 * and the full path of the file that contains it.
	 *
	 * @param string $className
	 * @param string $fullPath
	 */
	static public function registerClass($className, $fullPath)
	{
		ZincLoader::addClass($className, $fullPath);
	}
	
	static public function registerClasses($classes)
	{
		foreach($classes as $key => $val)
		{
			if(is_int($key))
				self::reg($val);
			else
				self::reg($key, $val);
		}
	}
	
	static public function reg($className, $dirPath = null)
	{
		if($dirPath)
		{
			if($dirPath[0] == '/')
				$fullPath = "$dirPath/$className.php";
			else
				$fullPath = app_dir . "/$dirPath/$className.php";
		}
		else
			$fullPath = app_dir . "/$className.php";
		
		self::registerClass($className, $fullPath);
	}
	
	
	/**
	 * Register a "domain" class for autoload (a domain class is a
	 * class that is located in the "domains" directory under
	 * the project root with the filename <classname>.php)
	 *
	 * @param unknown_type $className
	 */
	static public function registerDomain($className)
	{
		self::registerClass($className, app_dir . '/domain/' . $className . '.php');
	}
	
	// static $libList = array();
	// 
	// /**
	//  * Key => Value list of registered classes and the full path of the file that contains them
	//  *
	//  * @var array
	//  */
	// var $classList;
	// 
	// 
	// /**
	//  * Register a class for auto-loading with the name of the class
	//  * and the full path of the file that contains it.
	//  *
	//  * @param string $className
	//  * @param string $fullPath
	//  */
	// function _registerClass($className, $fullPath)
	// {
	// 	$this->classList[strtolower($className)] = $fullPath;
	// }
	// 
	// /**
	//  * Returns the full path and filename associated with the given registered class
	//  *
	//  * @param string $className
	//  * @return string - full path and filename of the class
	//  */
	// function _getClassPath($className)
	// {
	// 	$className = strtolower($className);
	// 	if(isset($this->classList[$className]))
	// 		return $this->classList[$className];
	// 	
	// 	return false;
	// }
	// 
	// /**
	//  * static -- Register a class for auto-loading with the name of the class
	//  * and the full path of the file that contains it.
	//  *
	//  * @param string $className
	//  * @param string $fullPath
	//  */
	// static function registerClass($className, $fullPath)
	// {
	// 	global $zoop;
	// 	$zoop->_registerClass($className, $fullPath);
	// }
	// 
	// /**
	//  * static -- Returns the full path and filename associated with the given registered class
	//  *
	//  * @param string $className
	//  * @return string - full path and filename of the class
	//  */
	// function getClassPath($className)
	// {
	// 	global $zoop;
	// 	return $zoop->_getClassPath($className);
	// }
	// 
	// /**
	//  * Loads a library of specified name.  Modules are located in the root
	//  * directory of the framework, using the following naming scheme:
	//  * 	<root>/<module>/<module>.php
	//  *
	//  * @param string $name
	//  */
	// static function loadLib($name, $isVendor = false)
	// {
	// 	echo "$name<br>";
	// 	var_dump($isVendor);
	// 	//	put some code in here to make sure we don't reload modules that have already been loaded
	// 	if(isset(self::$libList[$name]))
	// 		return;
	// 	self::$libList[$name] = 1;
	// 	
	// 	//	temporary measure so I can test without having to convert all of the modules over to the new format right away
	// 	if(file_exists(zoop_dir . "/$name/module.php"))
	// 	{
	// 		include(zoop_dir . "/$name/module.php");
	// 	}
	// 	else
	// 	{
	// 		if($isVendor)
	// 		{
	// 			$moduleName = ucfirst($name) . 'Module';
	// 			include(zoop_dir . "/vendor/$moduleName.php");
	// 			$module = new $moduleName();
	// 		}
	// 		else
	// 		{
	// 			$moduleName = ucfirst($name) . 'Module';
	// 			include(zoop_dir . "/$name/$moduleName.php");
	// 			$module = new $moduleName();
	// 		}
	// 	}
	// }
	// 
	
	/**
	 * Automatic class loading handler.  This automatically loads a class using the path
	 * information that was registered using the Zoop::registerClass or ::registerDomain
	 * method 
	 *
	 * @param string $className Name of the class to load
	 */
	/*
	
	moved to ZoopLoader.php
	
	static function autoload($className)
	{
		if(headers_sent())
		{
			echo_r($className);
			die('here');
		}
			
		$classPath = Zoop::getClassPath($className);
		if($classPath)
		{
			require_once($classPath);
		}

		if(substr($className, 0, 5) == 'Zend_')
		{
			$parts = explode('_', $className);
			$modName = $parts[1];
			require_once(zoop_dir . "/Zend/$modName.php");
		}
	}
	*/
}

Zinc::registerLib('boot');
Zinc::registerLib('core');
Zinc::registerLib('experimental');
Zinc::registerLib('vendor');
Zinc::loadLib('boot');
