<?php
	class Equipment extends Core{
		private $id = null;
		private $name = "";
		private $description = "";
		private $model = "";
		private $group = "";
		private $taskid = "";
		
		public function getTask(){
			if($this->getTaskID() == null || $this->getTaskID() == "")
				return null;
			else{
				return TASK::findTask($this->getTaskID());
			}
		}
		
		public function __destruct(){
		}
		
		public function __construct($equipment = null){
			if($equipment){
				$this->setID($equipment["id"]);
				$this->setName($equipment["name"]);
				$this->setDescription($equipment["description"]);
				$this->setModel($equipment["model"]);
				$this->setGroup($equipment["group"]);
				$this->setTaskID($equipment["taskid"]);
			}
		}
		
		public function getID(){return $this->id;}
		public function setID($id){$this->id = $id;}
		
		public function getTaskID(){return $this->taskid;}
		public function setTaskID($taskid){$this->taskid = $taskid;}
		
		public function getName(){return $this->name;}
		public function setName($name){$this->name = $name;}
		
		public function getDescription(){return $this->description;}
		public function setDescription($description){$this->description = $description;}
		
		public function getModel(){return $this->model;}
		public function setModel($model){$this->model = $model;}
		
		public function getGroup(){return $this->group;}
		public function setGroup($group){$this->group = $group;}
		
		public function persitence(){
			if($this->id){
				mysql_query("UPDATE `equipment` SET `name`='$this->name',`taskid`='$this->taskid',`model`='$this->model',`group`='$this->group',`description`='$this->description' WHERE id = '$this->id'");
			}else{
				mysql_query("INSERT INTO `equipment`(`name`, `taskid`, `model`, `group`, `description`)
					VALUES ('$this->name','$this->taskid','$this->model','$this->group','$this->description')");
			}
		}
		
		//--------------------------------------//
		
		public static function findEquipment($id = null){
			if($id){
				return new Equipment(mysql_fetch_array(mysql_query("SELECT * FROM equipment WHERE id = '$id'")));
			}
			
			$equipmentArray = array();
			$equipments = mysql_query("SELECT * FROM equipment");
			while($equipment = mysql_fetch_array($equipments)){
				array_push($equipmentArray, new Equipment($equipment));
			}
			
			return $equipmentArray;
		}

		public static function getEquipmentInGroup($groupName = null){
			if($groupName){
			//var_dump($groupName);
			
				$equipments = mysql_query("SELECT * FROM equipment WHERE `group` = '$groupName'");
				$equipmentArray = array();
				while($equipment = mysql_fetch_array($equipments)){
					array_push($equipmentArray, new Equipment($equipment));
				}
				
				return $equipmentArray;
			}else{
				$groupArray = array();
				
				$groupNames = Equipment::getGroupName();
				foreach($groupNames as $groupName){
					$groupArray[$groupName] = Equipment::getEquipmentInGroup($groupName);
				}
				return $groupArray;
			}
		}
		
		public static function getGroupName(){
			$groupArray = array();
			$groups = mysql_query("SELECT `group` FROM equipment GROUP BY `group`");
			while($group = mysql_fetch_array($groups)){
				array_push($groupArray, $group["group"]);
			}
			return $groupArray;			
		}
	}
?>