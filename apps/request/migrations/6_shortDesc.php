<?php
class Migration_6 extends Migration
{
	function up()
	{
		$sql = "ALTER table request add column short_desc text";
		SqlAlterSchema($sql);
	}
	
	function down()
	{
		$sql = "ALTER table request drop column short_desc";
		SqlAlterSchema($sql);
	}
}
