<?php
class Request extends DbObject
{
	protected function init()
	{
		$this->belongsTo('Person', array('local_field' => 'owner_id'));
		$this->fieldOptions('priority');
		$this->addGetter('description');
	}
	
	public function getDescription()
	{
		return $this->html_desc ? $this->html_desc : $this->text_desc;
	}
}
