<?php
class Port
{
	static public function import($datafile)
	{
		db('import')->echoOn();
		db('import')->beginTransaction();
		$data = Yaml::read($datafile);
		$schema = $data['schema'];
		$tables = $data['data'];
		$automap = array();
		foreach($tables as $tableName => $rows)
		{
			foreach($rows as $row)
			{
				$values = array();
				foreach($row as $fieldName => $fieldValue)
				{
					if(!isset($schema[$tableName]['auto']) || !in_array($fieldName, $schema[$tableName]['auto']))
						$values[$fieldName] = $fieldValue;
				}
				
				if(isset($schema[$tableName]['refs']))
				{
					foreach($schema[$tableName]['refs'] as $fieldName => $referee)
					{
						$values[$fieldName] = $automap[$referee[0]][$referee[1]][$row[$fieldName]];
					}
				}
				$id = db('import')->insertArray($tableName, $values);
				$automap[$tableName]['id'][$row['id']] = $id;
			}
		}
		echo_r(db('import')->fetchRows("select * from pm_category_group", array()));
		echo_r(db('import')->fetchRows("select * from pm_category", array()));
		echo_r(db('import')->fetchRows("select * from default_objective", array()));
		db('import')->rollbackTransaction();
	}
}