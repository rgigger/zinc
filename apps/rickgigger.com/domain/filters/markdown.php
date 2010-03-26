<?php
include_once app_dir . '/lib/php_markdown/markdown.php';

class MarkdownFilter extends ContentFilter
{
	public function filter($content, $cacheAssets = false)
	{
		return Markdown($content);
	}
}