<?php
class Migration_9 extends Migration
{
	function up()
	{
		$sql = "ALTER TABLE request RENAME COLUMN owner_id TO creator_id";
		SqlAlterSchema($sql);
	}
	
	function down()
	{
		$sql = "ALTER TABLE request RENAME COLUMN creator_id TO owner_id";
		$sql = "DROP table comment";
		SqlAlterSchema($sql);
	}
}
