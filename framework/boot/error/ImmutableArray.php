<?php
class ImmutableArray implements Iterator, ArrayAccess, Countable
{
	private $array;
	
	public function __construct($array)
	{
		if(!is_array($array))
			trigger_error("ImmutableArray must be initialized with an existing array");
		
		$this->array = $array;
	}
	
	
	//
	//	begin iterator functions
	//
	
	public function rewind()
	{
		reset($this->array);
	}

	public function current()
	{
		$var = current($this->array);
		return $var;
	}

	public function key()
	{
		$var = key($this->array);
		return $var;
	}

	public function next()
	{
		$var = next($this->array);
		return $var;
	}

	public function valid()
	{
		$var = $this->current() !== false;
		return $var;
	}
	
	
	//
	//	begin array access functions
	//
	
	public function offsetExists($offset)
	{
		return isset($this->array[$offset]);
	}
	
	public function offsetGet($offset)
	{
		if(isset($this->array[$offset]))
			return $this->array[$offset];
		else
			trigger_error("array $offset offset does not exist");
	}
	
	public function offsetSet($offset, $value)
	{
		trigger_error("ImmutableArray does not allow memebers to changed");
	}
	
	public function offsetUnset($offset)
	{
		trigger_error("ImmutableArray does not allow memebers to deleted");
	}
	
	
	//
	//	begin countable functions
	//
	
	public function count()
	{
		return count($this->array);
	}
}