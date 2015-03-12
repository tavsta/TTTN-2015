<?php
	class Core{
		public function getNextID($tableName = ''){
			return $globalid = mysql_fetch_array(mysql_query("SELECT `auto_increment` as id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'global'"))["id"];
		}
	}
?>