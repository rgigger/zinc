<?php
class FormBinding
{
	private $class;
	private $id;
	private $field;
	private $temp;
	
	function __construct($object, $field)
	{
		$this->class = get_class($object);
		$this->id = $object->getBound() ? $object->getId() : $object->getTempId();
		$this->temp = $object->getBound() ? 'perm' : 'temp';
		$this->field = $field;
	}
	
	public function getName()
	{
		return "_zinc_form_element[{$this->class}][{$this->id}][{$this->field}]";
	}
	
	public function getString()
	{
		return "{$this->class}:{$this->temp}:{$this->id}:{$this->field}";
	}
}
