<?php
	include ('config.php');
	include ('core_model.php');
	include ('skill_model.php');
	include ('account_model.php');
	include ('equipment_model.php');
	include ('task_model.php');
	include ('attribute_model.php');
	
	function destroy($objArray){
		for($i = 0; $i < sizeof($objArray); $i++){
			$objArray[$i] = null;
		}
	}
?>

<?php
	function getGlobalByID($id){
		return mysql_fetch_array(mysql_query("SELECT * FROM global WHERE id = '$id'"));
	}
	
	//*****get data with $type: TEAM, PROJECT, SPRINT, TASK
	function getGlobalWithType($type){
		return mysql_query("SELECT * FROM global WHERE type = '$type'");
	}
	
	//*****get data belong to it's parent
	function getGlobalBelongTo($parent){
		return mysql_query("SELECT * FROM global WHERE belongto = '$parent'");
	}
	
	function getProjectOfTask($taskID){
		$task = getGlobalByID($taskID);
		if($task["type"] == PROJECT)
			return $task;
			
		return getProjectOfTask($task["belongto"]);
	}
	
	//*****get Member belong to it's parent id (TASK id)
	function getMemberBelongTo($generalid){
		return mysql_query("SELECT account.id AS id, name FROM global_member, account WHERE globalid = '$generalid' AND memberid = account.id");
	}
	
	//*****get data with $type: TEAM, PROJECT, SPRINT, TASK but current user joined it
	function getJoinedGlobalWithType($type){
		$id = getUserIDFromCookie();
		return mysql_query("SELECT global.id, global.name, global.startdate,  global.enddate FROM global_member, global WHERE global_member.memberid = '$id' AND global.type = '$type'");		
	}
	
	//*****insert data with information provided
	function createGlobal($name, $startdate, $enddate, $description, $type, $belongto = NOT_BELONGTO_OTHER){
		mysql_query("INSERT INTO `global`(`belongto`, `startdate`, `leaderid`, `description`, `enddate`, `name`, `type`)
					VALUES (`$belongto`, `$startdate`, '".getUserIDFromCookie()."', `$description`, `$enddate`, `$type`)");	
	}
	
	function removeGlobal($id){
		$childList = getGlobalBelongTo($id);
		while($child = mysql_fetch_array($childList)){
			removeGlobal($child["id"]);
		}
		mysql_query("DELETE FROM `global` WHERE id = '$id'");
	}
	//*****get member list in system
	function getMemberList($key = ""){
		return mysql_query("SELECT * FROM account WHERE name like '%".$key."%' ORDER BY name ASC");
	}
	
	function getMember($id = null){
		if($id)
			return mysql_fetch_array(mysql_query("SELECT * FROM account WHERE id = '$id'"));
		else 
			return mysql_fetch_array(mysql_query("SELECT * FROM account WHERE"));
	}
	
	function getAccount($id = null){
		return getMember($id);
	}
	//***** update changed information to database
	function updateAccount($name, $sex, $birthdate, $email, $telephone, $address, $password = null){
		if(!$password){
			mysql_query("UPDATE account SET
			`name`				= '$name',
			`sex`				= '$sex',
			`birthdate`			= '$birthdate',
			`email`				= '$email',
			`telephone`			= '$telephone',
			`address`			= '$address'
			WHERE md5(id) = '$_COOKIE[account]'");
		}else{
			mysql_query("UPDATE account SET
			`name`				= '$name',
			`sex`				= '$sex',
			`birthdate`			= '$birthdate',
			`email`				= '$email',
			`telephone`			= '$telephone',
			`address`			= '$address',
			`password`			= md5('$password')
			WHERE md5(id) = '$_COOKIE[account]'");
		}		
	}
	
	//*****add team to database
	function addTeam($name, $description, $members = null){
		mysql_query("INSERT INTO global(name, type, description, leaderid) VALUES('$name', '".TEAM."', '$description', '".getUserIDFromCookie()."')");
		$team = mysql_query("SELECT * FROM global WHERE name = '$name' ");
		$teamID = mysql_fetch_array($team)["id"];
		
		mysql_query("INSERT INTO global_member(globalid, memberid, status) VALUES('$teamID', '".getUserIDFromCookie()."', '".LEADER."')");
		if(isset($members) && is_array($members)){
			foreach($members as $member){
				mysql_query("INSERT INTO global_member(globalid, memberid) VALUES('$teamID', '$member')");
			}		
		}
		
		return SUCCESS;
	}
	
	//*****get Leader information of team
	function getLeaderInfo($globalID){
		return mysql_fetch_array(mysql_query("SELECT account.id, account.firstname, account.lastname FROM account, global_member WHERE global_member.globalid = '$globalID' AND global_member.memberid = account.id"));
	}
	
	###################################################
	//*********** Send request or invitation to take part in a team ********///////////
	
	//*****check if global is exist
	function checkExistGlobal($globalID){
		if(mysql_num_rows(mysql_query("SELECT * FROM global WHERE id = '$globalID'")) > 0)
			return GLOBAL_IS_EXIST;
		else 
			return GLOBAL_NOT_EXIST;			
	}
	
	//***** obj is object receive request 	
	function sendJoinOrInvitationRequest($objID, $requestType){
		switch($requestType){
			case INVITE:
				mysql_query();
				break;
			case JOIN:
				if(isUser() != NEW_USER) return JOINED_TO_OTHER_GLOBAL;	
				
				if(checkExistGlobal($objID) == GLOBAL_IS_EXIST){
					mysql_query("INSERT INTO global_member(memberid, globalid, status) VALUES('".getUserIDFromCookie()."', '$objID', '".JOIN."')");
					return SEND_REQUEST_SUCCESS;
				}else
					return SEND_REQUEST_NOT_EXIST_GLOBAL;
					
			case ACCEPT_JOIN:
				return ACCEPT_JOIN;
			case ACCEPT_INVITE:
				return ACCEPT_INVITE;
		}
	}
	
	function getJoinOrInviteRequest(){
		if(isUser() == LEADER){
			return mysql_query("SELECT account.id, account.firstname as firstname, account.lastname as lastname, g2.id as relationid, global.name as globalname FROM account, global, global_member as g1, global_member as g2 WHERE g1.memberid = '".getUserIDFromCookie()."' AND g1.status = '".LEADER."' AND g1.globalid = g2.globalid AND g2.status = '".JOIN."' AND g2.globalid = global.id AND g2.memberid = account.id");
		}
		return null;
	}
	
	function sendAcceptOrEject($relationid, $status){
		mysql_query("UPDATE global_member SET status = '$status' WHERE id = '$relationid'");
	}
	
	##############3
	function getMemberWithTask($taskID, $isAddTask = false){
		$membersArray = array();
		$memberIDArray = array();
		
		$allMemberList = mysql_query("SELECT  account.id, account.name, '' as mission FROM account");
		
		if(!$isAddTask){
			$memberInTaskList = mysql_query("SELECT  account.id, account.name, global_member.mission as mission FROM global_member, account WHERE globalid = '$taskID' AND memberid = account.id");
		}else{
			$memberInTaskList = mysql_query("SELECT  account.id, account.name, '' as mission FROM account LIMIT 0");
		}
			
		while($member = mysql_fetch_array($memberInTaskList)){
			$taskList = mysql_query("SELECT * FROM global_member WHERE memberid = '$member[id]'");
			$taskArray = array();
			while($task = mysql_fetch_array($taskList)){
				array_push($taskArray, $task);
			}
			
			$member["isInTask"] = true; //Member is in task
			$member["taskArray"] = $taskArray;
			
			array_push($membersArray, $member);
			array_push($memberIDArray, $member["id"]);
		}		
		
		while($member = mysql_fetch_array($allMemberList)){
			if(!in_array($member["id"], $memberIDArray)){
				$taskList = mysql_query("SELECT * FROM global_member WHERE memberid = '$member[id]'");
				$taskArray = array();
				while($task = mysql_fetch_array($taskList)){
					array_push($taskArray, $task);
				}
				
				$member["isInTask"] = false; //Member is not in task
				$member["taskArray"] = $taskArray;
				
				array_push($membersArray, $member);
			}
		}		
				
		return $membersArray;
	}
?>