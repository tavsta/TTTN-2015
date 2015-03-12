<?php
	function team(){
		$teamList = mysql_query("SELECT * FROM cat WHERE TYPE = 'team'");
		while($row = mysql_fetch_array($teamList)){
			
		}
	}
	
	function createTeam(){
		#show text and label of fields
	}
	
	function editTeam(){
		#show text and label of fields
	}
	
	if(isset($_GET["sp"])){
		case "create": createTeam(); break;
		case "edit": editTeam(); break;
		default: team();
	}else{
		team();
	}
	
	if(isset($_POST["action"])){
		switch($_POST["action"]){
			case "create": acceptCreateTeam(); break;
			case "edit": acceptEditTeam(); break;
			default: break;
		}
	}
?>