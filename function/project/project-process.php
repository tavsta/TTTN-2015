<?php
	include_once("function/project/project-core.php");
	
	if(isset($_POST["createProject"])){
		define ("PROJECT_EMPTY_NAME", "PROJECT_EMPTY_NAME");
		define ("PROJECT_EMPTY_DESCIPTION", "PROJECT_EMPTY_DESCIPTION");
		define ("PROJECT_EMPTY_START_DATE", "PROJECT_EMPTY_START_DATE");
		define ("PROJECT_EMPTY_END_DATE", "PROJECT_EMPTY_END_DATE");
		define ("PROJECT_NOT_ENOUGHT_INFO", "PROJECT_NOT_ENOUGHT_INFO");
		define ("PROJECT_SUCCESS", "PROJECT_SUCCESS");
		define ("PROJECT_FAILED", "PROJECT_FAILED");
		
		$createProjectResult = NONE;
		
		if($_POST["name"] == "" || $_POST["description"] == "" || $_POST["startdate"] == "" || $_POST["enddate"] == "")
			$createProjectResult = PROJECT_NOT_ENOUGHT_INFO;
		else{
			if(mysql_query("INSERT INTO global(name, description, leaderid, startdate, enddate, type) VALUES('$_POST[name]', '$_POST[description]', '".getUserIDFromCookie()."', '$_POST[startdate]', '$_POST[enddate]', 'PROJECT')")){
				$ids = mysql_query("SELECT id FROM global ORDER BY id DESC");
				$id = mysql_fetch_array($ids)["id"];
				
				if(isset($_POST["member"])){
					foreach($_POST["member"] as $mem){		
						mysql_query("INSERT INTO global_member(globalid, memberid) VALUES('$id', '$mem')");						
					}
				}
				
				if(isset($_POST["quality"])){
					for( $i = 0; $i <sizeof($_POST["quality"]); $i++){
						if($_POST["quality"][$i] > 0)
							mysql_query("INSERT INTO global_equipment(globalid, equipmentid, quality) VALUES('$id', '".$_POST["equipment"][$i]."', '".$_POST["quality"][$i]."')");
					}
				}
				
				header("Location: ".SITE."?action=project");
				$createProjectResult = PROJECT_SUCCESS;
			}else{
				echo mysql_error();
				$createProjectResult = PROJECT_FAILED;
			}
		}
	}
?>

<?php
	
	if(isset($_POST["action"])){
		switch($_POST["action"]){		
			case "createattribute":
				$attribute = new Attribute();
				$task = Task::findTask($_POST["taskid"]);
				$project = $task->getProject();
				
				$attribute->setName($_POST["name"]);
				$attribute->setProjectID($project->getID());
				$attribute->setDescription($_POST["description"]);
				//$attribute->setType($_POST["type"]);

				$attribute->persitence();
				$project->generateAttributeForAllTaskOfProject($attribute->getNextID(), $_POST["taskid"], $_POST["value"]);
				
				header(reload());
				
				createAttribute($_POST["taskid"], $_POST["name"], $_POST["value"]);
				break;
			
			case "editTask":
			
				$task = Task::findTask($_POST["id"]);
				$task->setName($_POST["name"]);
				$task->setStartDate($_POST["startdate"]);
				$task->setEndDate($_POST["enddate"]);
				
				if(isset($_POST["leaderid"]))
					$task->setLeaderID($_POST["leaderid"]);
					
				if(isset($_POST["description"]))
					$task->setDescription($_POST["description"]);

				if(isset($_POST["type"]))
					$task->setType($_POST["type"]);
								
				$task->persitence();
				
				mysql_query("DELETE FROM `global_member` WHERE global_member.globalid = '$_POST[id]'");
						
				$member = $_POST["member"];
				$mission = $_POST["mission"];
				for($i = 0; $i < sizeof($member); $i++){
					mysql_query("INSERT INTO global_member(globalid, memberid, mission) VALUES('$_POST[id]', '$member[$i]', '".$mission[$member[$i]]."')");
				}				
				$task->setAttribute($_POST["attribute"]);
				header(reload());
				break;
			
			case "addTask":
				$task = new Task();
				$task->setName($_POST["name"]);
				$task->setStartDate($_POST["startdate"]);
				$task->setEndDate($_POST["enddate"]);
				$task->setBelongto($_POST["id"]);
				if(isset($_POST["leaderid"]))
					$task->setLeaderID($_POST["leaderid"]);
					
				if(isset($_POST["description"]))
					$task->setDescription($_POST["description"]);

//				if(isset($_POST["type"]))
//					$task->setType($_POST["type"]);
						
				$task->persitence();
				
				$globalid = mysql_fetch_array(mysql_query("SELECT `auto_increment` as id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'global'"))["id"] - 1;
				$isCreateAndSet = true;

				if(isset($_POST["member"])){
					$member = $_POST["member"];
					$mission = $_POST["mission"];
					for($i = 0; $i < sizeof($member); $i++){
						mysql_query("INSERT INTO global_member(globalid, memberid, mission) VALUES('$globalid', '$member[$i]', '".$mission[$member[$i]]."')");
					}				
				}
				if(isset($_POST["attribute"]))
					setOtherAttribute($_POST["attribute"], $isCreateAndSet);
					
				header(reload());
			break;
		}
	}			
?>
