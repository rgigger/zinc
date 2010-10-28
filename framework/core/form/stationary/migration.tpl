<?php
class Migration_[[$version]] extends Migration
{
	function up()
	{
		$sql = "CREATE TABLE session_form
				(
				    id serial primary key,
				    session_id text not null,
				    fields text not null
				)";
		SqlAlterSchema($sql);		
	}
	
	function down()
	{
	}
}
