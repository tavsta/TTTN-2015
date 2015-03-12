<?php
	if(isset($_GET["p"])){
		switch($_GET["p"]){
			case "team": 
				include "function/team/team.php";
				break;
			case "project": 
				include "function/project/project.php";
				break;
			case "task": 
				include "function/project/project.php";
				break;
		}
	}else{
		include "function/home/home.php";	
	}
?>