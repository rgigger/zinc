<?php
class Request extends DbObject
{
	protected function init()
	{
		$this->belongsTo('Person', array('local_field' => 'owner_id'));
		$this->hasMany('Comment');
		$this->fieldOptions('priority');
		$this->addGetter('htmlDescription');
	}
	
	public function getHtmlDescription()
	{
		if($this->html_desc)
			return preg_replace_callback('/src="cid:([^"]*)"/', array($this, 'replaceCid'), $this->html_desc);
		else
			return nl2br($this->text_desc);
	}
	
	public function replaceCid($matches)
	{
		$cid = $matches[1];
		$attachment = Attachment::findOne(array('content_id' => $cid));
		return 'src="' . script_url . '/attachment/' . $attachment->id . '"';
	}
}
