<?php
class Migration_5 extends Migration
{
	function up()
	{
		$sql = "ALTER table request add column message_id text";
		SqlAlterSchema($sql);
		
		$sql = "ALTER table request drop column description";
		SqlAlterSchema($sql);
		
		$sql = "ALTER table request add column text_desc text";
		SqlAlterSchema($sql);
		
		$sql = "ALTER table request add column html_desc text";
		SqlAlterSchema($sql);
	}
	
	function down()
	{
		// $sql = "ALTER table request drop column html_desc";
		// SqlAlterSchema($sql);
		// 
		// $sql = "ALTER table request drop column text_desc";
		// SqlAlterSchema($sql);
		// 
		// $sql = "ALTER table request drop column description";
		// SqlAlterSchema($sql);
		// 
		$sql = "ALTER table request drop column message_id";
		SqlAlterSchema($sql);
	}
}