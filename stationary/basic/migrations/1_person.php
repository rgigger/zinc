<?php
class Migration_1 extends Migration
{
	function up()
	{
		$sql = "CREATE TABLE person
		(
			id serial primary key,
			username text not null unique,
			firstname text not null,
			lastname text not null,
			password text
		);";
		SqlAlterSchema($sql, array());
	}
	
	function down()
	{
		$sql = "DROP TABLE <tablename>";
		SqlAlterSchema($sql, array());
	}
}
