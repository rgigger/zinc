<?php
class Migration_7 extends Migration
{
	function up()
	{
		$sql = "CREATE TABLE attachment
				(
					id serial primary key,
					name text,
					type text,
					content_id text,
					hash text,
					request_id integer references request
				)";
		SqlAlterSchema($sql);
	}
	
	function down()
	{
		$sql = "DROP table attachment";
		SqlAlterSchema($sql);
	}
}
