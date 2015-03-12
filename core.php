<?php
	include ('constant.php');
	include ('model.php');

	function getCurrentHostURL(){
		 $pageURL = 'http';
		 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
		 } else {
			$pageURL .= $_SERVER["SERVER_NAME"];
		 }
		 return $pageURL."/tttn/";
	}
	
    function getCurrentPageURL() {
		 $pageURL = 'http';
		 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
    }
    
	function reload($link = null){
		if($link){
			return "Location: ".getCurrentHostURL().$link;
		}else{
			return "Location: ".getCurrentPageURL();		
		}		
	}
	//------------------------------------------//

	//*******check current user is LEADER or not
	function isLeader(){
		$account = getAccountDetailFromCookie();
		$countLeader = mysql_query("SELECT * FROM global WHERE leaderid = '$account[id]'");
		if(mysql_num_rows($countLeader) > 0)
			return LEADER;
		else	
			return NOT_LEADER;
	}
	
	//*******Check weather current user is NEW_USER, OLD_USER or LEADER	
	function isUser(){
		$isUser = NEW_USER;
		$account = getAccountDetailFromCookie();
		$countMember = mysql_query("SELECT * FROM global_member WHERE memberid = '$account[id]' AND (status != '".ACCEPT_JOIN."' OR status != '".ACCEPT_INVITE."')");
		if(mysql_num_rows($countMember) > 0){
			if(isLeader() == LEADER)
				$isUser = LEADER;
			else $isUser = OLD_USER;	
		}
		
		return $isUser;
	}
##############################################################################################	

function reformatDate($date){
	$dateArray = split("-", $date);
	if(sizeof($dateArray) == 3)
		return $dateArray[2]."-".$dateArray[1]."-".$dateArray[0];
	
	return $date;
}

?>