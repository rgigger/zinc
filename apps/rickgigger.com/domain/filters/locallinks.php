<?php
class LocallinksFilter extends ContentFilter
{
	public function filter($content, $cacheAssets = false)
	{
		return preg_replace_callback('/\[([\w, -\s]*)\]\(([\w:,. \/]*)\)/', array($this, 'imageCallback'), $content);
	}
	
	public function imageCallback($matches)
	{
		$url = $matches[2];
		if(substr($url, 0, 7) == 'http://' || substr($url, 0, 8) == 'https://')
			return $matches[0];
		return '<a href="' . script_url . '/' . $url . '">' . $matches[1] . '</a>';
	}
}

