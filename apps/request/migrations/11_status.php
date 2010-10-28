<?php
class Migration_11 extends Migration
{
	function up()
	{
		$sql = "CREATE TABLE status
				(
				    id integer primary key,
					name text,
					list_order integer
				)";
		SqlAlterSchema($sql);
		
		$sql = "INSERT INTO status (id, name, list_order) VALUES (:id, :name, :listOrder)";
		SqlUpdateRow($sql, array('id' => 1, 'name' => 'new', 'listOrder' => 1));
		SqlUpdateRow($sql, array('id' => 4, 'name' => 'resolved', 'listOrder' => 4));
		
		$sql = "ALTER TABLE request ADD COLUMN status_id INTEGER REFERENCES status NOT NULL DEFAULT 1";
		SqlAlterSchema($sql);		
	}
	
	function down()
	{
		$sql = "ALTER TABLE request DROP COLUMN status_id";
		SqlAlterSchema($sql);
		
		$sql = "DROP TABLE status";
		SqlAlterSchema($sql);
	}
}
