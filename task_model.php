<?php
	class Task extends Core{
		private $id = null;
		private $name = "";
		private $description = "";
		private $leaderid = "";
		private $startdate = "";
		private $enddate = "";
		private $type = "TASK";
		private $belongto = 0;
		

		public function __construct($task = null){
			if($task){
				$this->setID($task["id"]);
				$this->setName($task["name"]);
				$this->setDescription($task["description"]);
				$this->setLeaderID($task["leaderid"]);
				$this->setStartDate($task["startdate"]);
				$this->setEndDate($task["enddate"]);
				$this->setType($task["type"]);
				$this->setBelongto($task["belongto"]);
			}
		}

		public function getID(){return $this->id;}
		public function setID($id){$this->id = $id;}
		
		public function getName(){return $this->name;}
		public function setName($name){$this->name = $name;}
		
		public function getDescription(){return $this->description;}
		public function setDescription($description){$this->description = $description;}
		
		public function getLeaderID(){return $this->leaderid;}
		public function setLeaderID($leaderid){$this->leaderid = $leaderid;}
		
		public function getStartDate(){return $this->startdate;}
		public function setStartDate($startdate){$this->startdate = $startdate;}
		
		public function getEndDate(){return $this->enddate;}
		public function setEndDate($enddate){$this->enddate = $enddate;}
		
		public function getType(){return $this->type;}
		public function setType($type){$this->type = $type;}
		
		public function getBelongto(){return $this->belongto;}
		public function setBelongto($belongto){$this->belongto = $belongto;}
		
		public function getChild(){
			$childArray = array();
			
			$childs = mysql_query("SELECT * FROM `global` WHERE belongto = '$this->id'");
			while($child = mysql_fetch_array($childs)){
				array_push($childArray, new Task($child));
			}
			
			return $childArray;
		}
		
		public function getParent(){
			if($this->getBelongto() == 0)
				return null;
				
			return new Task(mysql_fetch_array(mysql_query("SELECT * FROM `global` WHERE id = '$this->belongto'")));
		}
		
		public function getProject(){
			if($this->getType() == 'PROJECT')
				return $this;
			else
				if($this->getParent())
					return $this->getParent()->getProject();
				
				return null;
		}
		
		public function getEquipment(){
			$equipmentArray = array();
			$equipment = mysql_query("SELECT equipment.* FROM equipment JOIN global_equipment ON equipment.id = global_equipment");
			while($equipment = mysql_fetch_array($equipments)){
				array_push($equipmentArray, new Equipment($equipment));
			}
			return $equipmentArray;
		}

		public function getMember(){
			$memberArray = array();
			
			$members = mysql_query("SELECT account.* FROM account JOIN global_member ON account.id = global_member.memberid WHERE global_member.globalid = '$this->id'");
			while($member = mysql_fetch_array($members)){
				array_push($memberArray, new Account($member));
			}
			
			return $memberArray;
		}
		//***start from project
		public function generateAttributeForAllTaskOfProject($attributeid, $taskID, $value){			
			if($this->getID() == $taskID)
				mysql_query("INSERT INTO `global_attribute`(`globalid`, `attributeid`, `value`) VALUES ('$this->id', '$attributeid', '$value')");
			else
				mysql_query("INSERT INTO `global_attribute`(`globalid`, `attributeid`, `value`) VALUES ('$this->id', '$attributeid', '')");
				
			$childs = $this->getChild();
			for($i = 0; $i < sizeof($childs); $i++){
				$childs[$i]->generateAttributeForAllTaskOfProject($attributeid, $taskID, $value);
			}
		}
		
		public function getAttribute(){
			$attributeArray = array();
			
			$attributes = mysql_query("SELECT * FROM attr WHERE attr.projectid = '$this->id'");
			while($attribute = mysql_fetch_array($attributes)){
				array_push($attributeArray, new Attribute($attribute));
			}
			
			return $attributeArray;
		}
		
		public function setAttribute($attributes){
			foreach($attributes as $key => $value){
				mysql_query("UPDATE `global_attribute` SET `value`='$value' WHERE id = '$key'");
			}
		}
		
		public function setEquipment(){
			//Todo
		}
		
		public function __destruct(){
		}
		
		public function persitence(){
			if($this->id){
				mysql_query("UPDATE `global` SET name = '$this->name',description = '$this->description',leaderid = '$this->leaderid',startdate = '$this->startdate',enddate = '$this->enddate',type = '$this->type',belongto = '$this->belongto' WHERE id = '$this->id'");
			}else{
				if(!mysql_query("INSERT INTO `global`(`belongto`, `leaderid`, `description`, `enddate`, `name`, `type`, `startdate`)
												VALUES ('$this->belongto','$this->leaderid','$this->description','$this->enddate','$this->name','$this->type','$this->startdate')")) echo mysql_errno();;
			}			
		}
		//------------------
		public static function findTask($id = null){
			if($id){
				return new Task(mysql_fetch_array(mysql_query("SELECT * FROM `global` WHERE id = '$id'")));
			}
			
			$taskArray = array();
			$tasks = mysql_query("SELECT * FROM global");
			while($task = mysql_fetch_array($tasks)){
				array_push($taskArray, new Task($task));
			}
			
			return $taskArray;
		}
		
		public static function findProject(){
			$projectArray = array();
			$projects = mysql_query("SELECT * FROM global WHERE type='PROJECT' ");
			while($project = mysql_fetch_array($projects)){
				array_push($projectArray, new Task($project));
			}
			
			return $projectArray;			
		}
		
	}
?>