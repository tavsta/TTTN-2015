<?php
	$hostname = 'localhost';
	$db_type = 'mysql';
	$database_name = 'tttn';
	$db_username = 'root';
	$db_password = '';

	mysql_connect($hostname, $db_username, $db_password);
	mysql_query("SET character_set_results=utf8");
	mysql_select_db($database_name);
	mysql_query("SET NAMES 'utf8'");
?>