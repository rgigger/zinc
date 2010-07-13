<?php
class Migration_4 extends Migration
{
	function up()
	{
		$sql = "CREATE TABLE filter
				(
					id serial primary key,
					name text,
					content text
				)";
		SqlAlterSchema($sql);
	}
	
	function down()
	{
		$sql = "DROP TABLE filter";
		SqlAlterSchema($sql);
	}
}