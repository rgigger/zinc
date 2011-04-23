<?php
class CommandStationary
{
	public function usage($p)
	{
		trigger_error("consolidate the usage code here somehow");
	}
	
	public function handleRequest($p)
	{
		// $p1 = strtolower($p[1]);
		// if($p1 == 'create')
		// {
		
		if(isset($p[2]))
			$methodName = "handle" . $p[2];

		if(isset($p[2]) && method_exists($this, $methodName))
			$this->$methodName($p);
		else
		{
			if(defined('instance_dir'))
			{
				echo "usage: zn create migration MIGRATION_NAME\n";
			}
			else
			{
				echo "usage: zn create app APP_NAME\n";
				echo "       zn create instance INSTANCE_NAME APP_DIR\n";
				echo "       zn create pub PUB_NAME INSTANCE_DIR\n";
			}
		}
		
		// }
		// else if($p1 == 'update')
		// {
		// 	if(!($p[2] == 'stationary' && $p[3] == 'config'))
		// 		$this->usage($p);
		// 	
		// 	$this->handleUpdateStationaryConfig($p);
		// }
	}
	
	/**
	 * todo:
	 * 	make it so that running this on an existing directory won't do anything
	 * 		without a -f flag in which case it will overwrite everything
	 */
	
	public function handleApp($p)
	{
		Zinc::loadLib('build');
		
		$appDir = $p[3];
		self::gen_r($appDir, 'basic', array());
		
		// set up the tmp dir
		mkdir($appDir . '/tmp/Smarty2', 0777, true);
		_chmod($appDir . '/tmp', 0777, true);
	}
	
	public function handleInstance($p)
	{
		$instanceName = $p[3];
		$appDir = $p[4];
		self::gen_r($instanceName, 'instance', array('appDir' => $appDir));
	}
	
	public function handlePub($p)
	{
		$pubName = $p[3];
		$instanceDir = $p[4];
		include($instanceDir . '/const.php');
		
		self::gen_r($pubName, 'pub', array('instanceDir' => instance_dir));
		
		// set up a symlink for public
		if(!file_exists("$pubName/public"))
			symlink(app_dir . '/public', "$pubName/public");
	}
	
	public function handleMigration($p)
	{
		Zinc::loadLib('migration');
		Zinc::loadLib('utils');
		
		$max = Migration::getMaxMigration();
		
		$version = $max + 1;
		$moduleName = false;
		
		if($p[count($p) - 2] == 'from')
		{
			$moduleName = $p[count($p) - 1];
			$name = 'init' . ucfirst($moduleName);
		}
		else
			$name = $p[3];
		
		$stationaryFilename = 'migration.tpl';
		
		if($moduleName)
			$stationaryFilename = Zinc::getModDir($moduleName) . "/stationary/$stationaryFilename";			
		else
			$stationaryFilename = app_dir . "/stationary/$stationaryFilename";
		
		if(!file_exists($stationaryFilename))
		{
			echo "stationary file at $stationaryFilename does not exist\n";
			return;
		}
		
		$params = array();
		$params['version'] = str_replace('.', '_', $version);
		
		$dir = app_dir . '/migrations';
		$newFilename = $dir . '/' . $version . '_' . $name . '.php';
		self::gen($stationaryFilename, $newFilename, $params);
	}
	
	/**
	 * gen handles processing one template file at $src and stores the result in at $dst
	 */
	static function gen($src, $dst, $params)
	{
		// set up the smarty object using /tmp
		$gui = new Smarty2();
		$gui->left_delimiter = '[[';
		$gui->right_delimiter = ']]';
		$tmpDir = '/tmp/zn/smarty2';
		if(!file_exists($tmpDir))
			mkdir($tmpDir, 0770, true);
		$gui->compile_dir = $tmpDir;
		
		$stationaryFilename = $src;
		if(!file_exists($stationaryFilename))
		{
			echo "stationary file at $stationaryFilename does not exist\n";
			return;
		}
		
		// get the content
		foreach($params as $key => $val)
			$gui->assign($key, $val);
		$gui->assign('zincDir', zinc_dir);
		echo "fetching stationary from $stationaryFilename\n";
		$contents = $gui->fetch('file:' . $stationaryFilename);
		
		// save the content
		$dstDir = dirname($dst);
		$dstFile = basename($dst);
		if(!file_exists($dstDir))
			mkdir($dir, 0775, true);
		echo "storing file contents in $dst\n";
		file_put_contents($dst, $contents);
	}
	
	static public function gen_r($name, $statName, $params)
	{
		Zinc::loadMod('app');
		Zinc::loadMod('gui');
		
		$statPath = dirname(zinc_dir) . "/stationary/{$statName}";
		
		// get a list of all the files that need to be processed as templates
		$raw = file_get_contents($statPath . '/stationary');
		// replace any separators that may have been used with just single spaces
		$stripped = preg_replace('/[\s,;:]+/' , ' ', $raw);
		$templateFiles = explode(' ', $stripped);
		
		if(!file_exists($name))
			mkdir($name);
		
		// go through each file, if it is a template process it, otherwise just copy it
		dir_r($statPath, function($it, $info) use ($templateFiles, $statPath, $name, $params) {
			$filename = $it->getSubPathName();
			if( ($filename == 'stationary' && $it->isFile()) || $filename == '..' || $filename == '.' )
				return;
			
			$path = "$name/" . $it->getSubPath();
			if($path && !file_exists($path))
				mkdir($path, 0775, true);
			
			if(in_array($filename, $templateFiles))
			{
				echo "processing template $filename\n";
				CommandStationary::gen("$statPath/$filename", "$name/$filename", $params);
			}
			else
			{
				echo "copying file $filename\n";
				copy("$statPath/$filename", "$name/$filename");
			}
		});
	}
	
	// public function handleUpdateStationaryConfig($p)
	// {
	// 	Zinc::loadMod('app');
	// 	
	// 	$path = isset($p[4]) && $p[4] ? $p[4] : getcwd();
	// 	$statyam = $path . '/stationary.yaml';
	// 	$config = Yaml::read($statyam);
	// 	print_r($config);
	// 	
	// 	dir_r($path, function($it, $info) use (&$config) {
	// 		$root = &$config;
	// 		$spn = $it->getSubPathName();
	// 		if($spn == 'stationary.yaml')
	// 			return;
	// 		
	// 		foreach(explode('/', $spn) as $part)
	// 		{
	// 			if(!isset($root[$part]))
	// 				$root[$part] = array();
	// 			
	// 			$root = &$root[$part];
	// 		}
	// 	});
	// 	
	// 	// $dir = new DirectoryIterator($path);
	// 	// foreach($dir as $fileinfo)
	// 	// {
	// 	// 	if(!$fileinfo->isDot())
	// 	// 	{
	// 	// 		if($fileinfo->isDir())
	// 	// 		{
	// 	// 			echo $fileinfo->getFilename() . " is a directory\n";
	// 	// 			foreach($fileinfo as $subinfo)
	// 	// 			{
	// 	// 				echo "\t" . $fileinfo->key() . " => " . $fileinfo->getFilename() . "\n";
	// 	// 			}
	// 	// 		}
	// 	// 		else
	// 	// 			echo $fileinfo->key() . " => " . $fileinfo->getFilename() . "\n";
	// 	// 	}
	// 	// }
	// 	
	// 	// WalkDir($dir, function($name) use (&$config) {
	// 	// 	echo "walkname = $name\n";
	// 	// 	$config['foo'] = 'bar';
	// 	// });
	// 	print_r($config);
	// 	Yaml::write($statyam, $config);
	// 	die();
	// }
	
	// public function handleMigrations($p)
	// {
	// 	$name = $p[3];
	// 	$max = Migration::getMaxMigration();
	// 	
	// 	assert(strlower($p[4]) == 'from');
	// 	$module = $p[5];
	// 	
	// 	$version = $max + 1;
	// 	
	// 	$stationaryFilename = 'migration.tpl';
	// 	
	// 	$gui = new GuiSmarty2();
	// 	$gui->left_delimiter = '[[';
	// 	$gui->right_delimiter = ']]';
	// 	
	// 	if(strpos($stationaryFilename, ':') === false)
	// 		$stationaryFilename = 'file:' . app_dir . "/stationary/$stationaryFilename";
	// 	
	// 	$gui->assign('version', str_replace('.', '_', $version));
	// 	echo "fetching stationary from $stationaryFilename\n";
	// 	$contents = $gui->fetch($stationaryFilename);
	// 	
	// 	$dir = app_dir . '/migrations';
	// 	$newFilename = $dir . '/' . $version . '_' . $name . '.php';
	// 	if(!file_exists($dir))
	// 		mkdir($dir, 0775, true);
	// 	echo "storing file contents in $newFilename\n";
	// 	file_put_contents($newFilename, $contents);
	// }
	// 
}
