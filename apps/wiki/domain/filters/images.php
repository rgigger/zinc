<?php
class ImagesFilter extends ContentFilter
{
	private $cacheAssets;
	
	public function filter($content, $cacheAssets = false)
	{
		$this->cacheAssets = $cacheAssets;
		return preg_replace_callback("/!\[([\w ]*)\]{([\w:,. ]*)}/", array($this, 'imageCallback'), $content);
	}
	
	public function imageCallback($matches)
	{
		// var_dump($matches);
		$pairs = explode(',', $matches[2]);
		// var_dump($pairs);
		$params = array();
		foreach($pairs as $pair)
		{
			$parts = explode(':', $pair);
			$params[trim($parts[0])] = trim($parts[1]);
		}
		
		if(!isset($params['url']))
			trigger_error("images must have an 'url' attribute");
		
		// echo_r($params);
		// echo_r($this);
		
		$srcFile = $this->assetSrcDir . '/' . $params['url'];
		if($this->cacheAssets)
		{
			$originalFile = $this->assetCacheDir . '/' . $params['url'];
			copy($srcFile, $originalFile);
		}
		
		$assetEndUrl = $assetOriginalUrl = $params['url'];
		if($params['width'])
		{
			// resize the image you just copied to be the correct width, then include this one in 
			list($width, $height, $type) = $info = getimagesize($srcFile);
			
			if($type == IMAGETYPE_PNG)
			{
				$createFunctionName = 'imagecreatefrompng';
				$imageFunctionName = 'imagepng';
				$extention = '.png';
			}
			
			$newWidth = $params['width'];
			$percent = $newWidth / $width;
			$newHeight = (int)($height * $percent);
			$info = pathinfo($this->cacheAssets ? $originalFile : $srcFile);
			$newFilename = $info['filename'] . '_' . $newWidth . 'x' . $newHeight;
			$newFile = $info['dirname'] . '/' . $newFilename;
			
			if($this->cacheAssets)
			{
				$image_p = imagecreatetruecolor($newWidth, $newHeight);
				$image = $createFunctionName($originalFile);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				$imageFunctionName($image_p, $newFile . $extention);
			}
			
			//	update the url to use the one you just made
			$info = pathinfo($assetEndUrl);
			$dirname = $info['dirname'] != '.' ? $info['dirname'] . '/' : '';
			$assetEndUrl = $dirname . $newFilename . $extention;
		}
		
		return '<div align="center"><a target="_new" rel="lightbox" class="lightbox" href="' . $this->assetBaseUrl . '/' . $assetOriginalUrl . '"><img src="' . $this->assetBaseUrl . '/' . $assetEndUrl . '"></a></div>';
	}
}

