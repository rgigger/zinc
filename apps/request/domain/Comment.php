<?php
class Comment extends DbObject
{
	protected function init()
	{
		$this->belongsTo('Request');
		$this->addGetter('htmlContent');
	}
	
	public function getHtmlContent()
	{
		if($this->html_comment)
			return preg_replace_callback('/src="cid:([^"]*)"/', array($this, 'replaceCid'), $this->html_comment);
		else
			return nl2br($this->text_comment);
	}
	
	public function replaceCid($matches)
	{
		$cid = $matches[1];
		$attachment = Attachment::findOne(array('content_id' => $cid));
		return 'src="' . script_url . '/attachment/' . $attachment->id . '"';
	}
}
