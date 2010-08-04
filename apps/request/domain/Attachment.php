<?php
class Attachment extends DbObject
{
	protected function init()
	{
		$this->belongsTo('Request');
	}
	
	public function stream()
	{
		$fp = fopen(Config::get('app.var') . '/attachments/' . $this->hash, 'r');
		fpassthru($fp);
	}
}
