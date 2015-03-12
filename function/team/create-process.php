<?php
	$createTeamResult = NONE;
	if(checkAuthenticated() && isset($_POST["createTeam"]) && !$handledPost){
		$handledPost = true;
		if($_POST["name"] == ""){
			$createTeamResult = EMPTY_NAME;
		}else{
			if(!isset($_POST["member"])) $_POST["member"] = null;
			$createTeamResult = addTeam($_POST["name"], $_POST["description"], $_POST["member"]);			
		}
	}
?>