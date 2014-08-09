<?php
class DbMysqlResult extends DbResultSet
{
	private $cur;
	private $max;

	function __construct($link, $res)
	{
		parent::__construct($link, $res);
		if (gettype($res) == "boolean")
		{
			$this->res = null;
			$this->cur = 0;
			$this->max = 0;
		}
		else
		{
			$this->cur = 0;
			$this->max = mysqli_num_rows($this->res) - 1;
		}
	}

	function numRows()
	{
		return $this->max + 1;
	}

	function rewind()
	{
		$this->cur = 0;
	}

	function current()
	{
		if($this->max == -1)
			return false;
		mysqli_data_seek($this->res, $this->cur);
		return mysqli_fetch_assoc($this->res);
	}

	function key()
	{
		return $this->cur;
	}

	function next()
	{
		$this->cur++;
		if($this->cur > $this->max)
			return false;
		mysqli_data_seek($this->res, $this->cur);
		return mysqli_fetch_assoc($this->res);
	}

	function valid()
	{
		if($this->cur > $this->max)
			return false;

		return true;
	}

	function affectedRows()
	{
		if ($this->res == null)
			return -1;
		else
			return mysqli_affected_rows($this->link);
	}
}
