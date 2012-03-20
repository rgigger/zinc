<?php
class Form
{
	private $id;
	private $bindings;
	private $sessionId;
	static private $setters = array();
	
	function __construct()
	{
		$this->bindings = array();
		$this->sessionId = session_id();
	}
	
	public function addBinding($object, $field)
	{
		$newBinding = new FormBinding($object, $field);
		$this->bindings[] = $newBinding;
		return $newBinding->getName();
	}
	
	public function saveBindings()
	{
		if(empty($this->bindings))
			return;
		$parts = array();
		foreach($this->bindings as $thisBinding)
			$parts[] = $thisBinding->getString();
		$listString = implode(',', $parts);
		
		$this->id = SqlInsertArray('session_form', array('session_id' => $this->sessionId, 'fields' => $listString));
	}
	
	static public function appendBindings($newBindings)
	{
		$formId = getPostInt('_zinc_form_id');
		$sessionId = session_id();
		//	IMPORTANT SECURITY NOTE:
		//		even though session.id is going to be a unique identifier we still need to check to make sure that it 
		//		has the correct session_id to prevent spoofing
		$fieldString = SqlFetchCell("select fields from session_form where session_id = :sessionId and id = :formId",
							array('sessionId' => $sessionId, 'formId' => $formId));
		
		if(!$fieldString)
			trigger_error("session_form row $formId not found.  Possible attempt to spoof session data.");
		
		$parts = array();
		foreach($newBindings as $thisBinding)
		{
			if(is_array($thisBinding))
				$bindingObject = new FormBinding($thisBinding['object'], $thisBinding['field']);
			else
				$bindingObject = $thisBinding;
			$parts[] = $bindingObject->getString();
		}
			
		$appendString = implode(',', $parts);
		
		SqlUpdateRow("update session_form set fields = :newFieldString where session_id = :sessionId and id = :formId",
							array('sessionId' => $sessionId, 'formId' => $formId, 'newFieldString' => $fieldString . ',' . $appendString));		
	}
	
	public function getTagInfo()
	{
		return array('_zinc_form_id', $this->id);
	}
	
	static public function set($class, $setter)
	{
		self::$setters[$class] = $setter;
	}
	
	static public function getObjects()
	{
		if(!isset($_POST['_zinc_form_id']) || !$_POST['_zinc_form_id'])
			return;
		
		$formId = $_POST['_zinc_form_id'];
		$sessionId = session_id();
		//	IMPORTANT SECURITY NOTE:
		//		even though session.id is going to be a unique identifier we still need to check to make sure that it 
		//		has the correct session_id to prevent spoofing
		$fieldString = SqlFetchCell("select fields from session_form where session_id = :sessionId and id = :formId",
							array('sessionId' => $sessionId, 'formId' => $formId));
		
		if(!$fieldString)
			trigger_error("session_form row $formId not found.  Possible attempt to spoof session data.");
			
		$objects = array();
		foreach(explode(',', $fieldString) as $thisFieldString)
		{
			list($class, $temp, $id, $field) = explode(':', $thisFieldString);
			if(!isset($_POST['_zinc_form_element'][$class][$id][$field]))
				continue;
			$objectId = "$class:$id";
			if(!isset($objects[$objectId]))
			{
				if($temp == 'temp')
					$objects[$objectId] = new $class();
				else if($temp == 'perm')
					$objects[$objectId] = new $class($id);
				else
					trigger_error('invalid temp value: ' . $temp);
			}
			
			$objects[$objectId]->$field = trim($_POST['_zinc_form_element'][$class][$id][$field]);
		}
		return $objects;
	}

	static public function save()
	{
		$objects = Form::getObjects();
		
		foreach($objects as $thisObject)
		{
			if(isset(self::$setters[get_class($thisObject)]))
			{
				$setter = self::$setters[get_class($thisObject)];
				$setter($thisObject);
			}
			
			// echo_r($thisObject);
			$thisObject->save();
		}
		
		reset($objects);
		return $objects;
	}
}
