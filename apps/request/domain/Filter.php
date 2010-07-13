<?php
class Filter extends DbObject
{
	static public function jsonToSql($json)
	{
		return self::sqlify(json_decode($json)->subs[0]);
	}
	
	static function sqlify($data)
	{
		$parts = array();
		foreach($data->fields as $field)
			$parts[] = self::sqlifyField($field);
		foreach($data->subs as $sub)
			$parts[] = '(' . self::sqlify($sub) . ')';
		$boolOp = $data->anyall == 'any' ? ' OR ' : ' AND ';
		return implode($boolOp, $parts);
	}

	static function sqlifyField($field)
	{
		$config = Config::get('app.filter');
		$name = $config['fields'][$field->field]['field'];
		$type = $config['fields'][$field->field]['type'];
		$operator = $field->operator;
		$widgit = $config['type_operator_map'][$type][$field->operator]['widgit'];

		// echo_r(array($type, $operator, $widgit));

		$left = $name;

		if($operator == 'is')
		{
			$op = '=';
			$right = $field->operandValues->menu;
		}
		else if($operator == 'is_not')
		{
			$op = '<>';
			$right = $field->operandValues->menu;
		}
		else if($operator == 'in')
		{
			$op = 'IN';
			$right = '(' . implode(', ', $field->operandValues->multi) . ')';
		}
		else if($operator == 'not_in')
		{
			$op = 'NOT IN';
			$right = '(' . implode(', ', $field->operandValues->multi) . ')';
		}
		else if($operator == 'less_than')
		{
			$op = ' < ';
			$right = $field->operandValues->menu;
		}
		else if($operator == 'greater_than')
		{
			$op = ' > ';
			$right = $field->operandValues->menu;
		}
		else if($operator == 'less_than_equal')
		{
			$op = ' <= ';
			$right = $field->operandValues->menu;
		}
		else if($operator == 'greater_than_equal')
		{
			$op = ' >= ';
			$right = $field->operandValues->menu;
		}
		else if($operator == 'in_the_range')
		{
			$all = "($left >= {$field->operandValues->menu1} AND $left <= {$field->operandValues->menu2})";
			return $all;
		}
		else
		{
			trigger_error("unrecognized operator '$operator'");
		}

		return "($left $op $right)";
	}
}