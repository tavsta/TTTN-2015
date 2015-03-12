<?php
	include "../config.php";
	include "../model.php";
	if(isset($_POST["action"]) && isset($_POST["id"])){
		$_POST["action"]($_POST["id"]);
	}else{
	}
?>
