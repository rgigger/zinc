<?php
class Entry extends DbObject
{
	public function init()
	{
		$this->keyAssignedBy = parent::keyAssignedBy_dev;
	}
	
	public function getDateNameUrl()
	{
		$datePart = substr($this->published_date, 0, strpos($this->published_date, ' '));
		$datePart = str_replace('-', '/', $datePart);
		return $datePart . '/' . $this->name;
	}
	
	public function getBasePath()
	{
		$simple = $this->postgresBoolToPhp($this->simple);
		if($simple)
			return false;
		
		$id = str_pad($this->id, 4, '0', STR_PAD_LEFT);
		return Config::get('app.blog.contentDir') . "/{$id}_{$this->name}";
	}
	
	public function getContentPath()
	{
		$simple = $this->postgresBoolToPhp($this->simple);
		if($simple)
		{
			$id = str_pad($this->id, 4, '0', STR_PAD_LEFT);
			return Config::get('app.blog.contentDir') . "/{$id}_{$this->name}.md";
		}
		else
		{
			return $this->getBasePath() . '/content.md'; 
		}
	}
	
	public function getCacheDir()
	{
		return app_dir . "/tmp/content/{$this->id}";
	}
	
	public function streamAsset($name)
	{
		$info = pathinfo($name);
		if($info['extension'] == 'png')
			header('Content-Type: image/png');
		readfile($this->getCacheDir() . '/' . $name);
	}
	
	public function getHeaders()
	{
		$pre = file($this->getContentPath());
		$headers = array();
		foreach($pre as $line)
		{
			$line = trim($line);
			if(!$line)
				break;
			
			$pos = strpos($line, ':');
			$key = strtolower(trim(substr($line, 0, $pos)));
			$value = trim(substr($line, $pos + 1));
			$headers[$key] = $value;
		}
		
		return $headers;
	}
	
	public function assignHeaders()
	{
		$headers = $this->getHeaders();
		if(isset($headers['archived-publish-date']) && $headers['archived-publish-date'])
			$this->published_date = $headers['archived-publish-date'];
		if(isset($headers['title']))
			$this->title = $headers['title'];
		if(isset($headers['link']))
			$this->link = $headers['link'];
		if(isset($headers['link-text']))
			$this->link_text = $headers['link-text'];
	}
	
	public function getIntro($cacheResults = false)
	{
		return $this->getContent(array('introOnly' => true));
	}
	
	public function getContent($params = array())
	{
		$cacheResults = isset($params['cacheResults']) ? $params['cacheResults'] : false;
		$introOnly = isset($params['introOnly']) ? $params['introOnly'] : false;
		
		$pre = file($this->getContentPath());
		$headers = array();
		$inHeaders = true;
		$content = '';
		foreach($pre as $line)
		{
			if($inHeaders && !trim($line))
			{
				$inHeaders = false;
				continue;
			}
			
			if($inHeaders)
			{
				$pos = strpos($line, ':');
				$key = strtolower(trim(substr($line, 0, $pos)));
				$value = trim(substr($line, $pos + 1));
				$headers[$key] = $value;
			}
			else
				$content .= $line;
		}
		
		$shortened = false;
		$strpos = strpos($content, "\n==\n");
		if($strpos !== false)
		{
			if($introOnly)
			{
				$content = substr($content, 0, $strpos);
				$shortened = true;
			}
			else
			{
				// echo $content;
				$content = substr_replace($content, '', $strpos + 1, 2);
				// echo '<br>===========================<br>';
				// echo $content;
				// die('here');
			}
		}
		
		if($cacheResults)
		{
			$cacheDir = $this->getCacheDir();
			if(!is_dir($cacheDir))
				mkdir($cacheDir, 0770, true);
		}
		
		if(isset($headers['filters']))
		{
			include_once app_dir . '/domain/filters/ContentFilter.php';
			$filterList = explode(',', $headers['filters']);
			foreach($filterList as $filterName)
			{
				if(!$filterName)
					continue;
				
				$filterName = trim($filterName);
				include_once app_dir . "/domain/filters/$filterName.php";
				$className = ucfirst($filterName) . 'Filter';
				$filter = new $className();
				$filter->assetBaseUrl = 'index.php/entry/asset/' . $this->id;
				
				$filter->assetSrcDir = $this->getBasePath();
				if($filter->assetSrcDir && $cacheResults)
				{
					$filter->assetCacheDir = $cacheDir;
				}
				$content = $filter->filter($content, $cacheResults);
			}
		}
		
		//	we shoudl fix this later so that intros are also cached
		//	also, I don't see anywhere where it actually pulls fom the cache,
		//	or does anything with it except store stuff in it
		if($cacheResults && !$introOnly)
		{
			$filename = "$cacheDir/{$this->name}.html";
			file_put_contents($filename, $this->getContent());
		}
		
		if($introOnly)
			$res = array('content' => $content, 'shortened' => $shortened);
		else
			$res = $content;
		
		return $res;
	}
	
	public function cacheContent()
	{
		$this->getContent(array('cacheResults' => true));
	}
	
	public function save()
	{
		if($this->simple != 't' && $this->simple != 'f')
			$this->simple = $this->phpBoolToPostgres($this->simple);
		parent::save();
	}
}