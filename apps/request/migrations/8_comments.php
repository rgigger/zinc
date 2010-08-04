<?php
class Migration_8 extends Migration
{
	function up()
	{
		$sql = "CREATE TABLE comment
				(
					id serial primary key,
					text_comment text,
					html_comment text,
					message_id text,
					request_id integer references request
				)";
		SqlAlterSchema($sql);
	}
	
	function down()
	{
		$sql = "DROP table comment";
		SqlAlterSchema($sql);
	}
}
