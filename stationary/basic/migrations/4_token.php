<?php
class Migration_4 extends Migration
{
	function up()
	{
		$sql = "CREATE table token (
			id serial primary key,
			person_id integer not null references person,
			token text not null unique,
			function text not null,
			expire_date timestamp with time zone
		)";
		SqlAlterSchema($sql);		
	}
	
	function down()
	{
		$sql = "DROP table token";
		SqlAlterSchema($sql);		
	}
}
