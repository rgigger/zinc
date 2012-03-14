<?php
class Migration_[[$version]] extends Migration
{
	function up()
	{
		$sql = "CREATE TABLE <tablename>
		(
			id serial primary key,
			<otherfield> text not null
		);";
		SqlAlterSchema($sql, array());
	}
	
	function down()
	{
		$sql = "DROP TABLE <tablename>";
		SqlAlterSchema($sql, array());
	}
}
