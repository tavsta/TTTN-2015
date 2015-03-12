<?php
	class Attribute extends Core{
		private $id = null;
		private $name = "";
		private $description = "";
		private $type = "NORMAL";
		private $projectid = null;
		

		public function __construct($attribute = null){
			if($attribute){
				$this->setID($attribute["id"]);
				$this->setName($attribute["name"]);
				$this->setDescription($attribute["description"]);
				$this->setType($attribute["type"]);
				$this->setProjectID($attribute["projectid"]);
			}
		}

		public function getID(){return $this->id;}
		public function setID($id){$this->id = $id;}
		
		public function getName(){return $this->name;}
		public function setName($name){$this->name = $name;}
		
		public function getDescription(){return $this->description;}
		public function setDescription($description){$this->description = $description;}
		
		public function getType(){return $this->type;}
		public function setType($type){$this->type = $type;}
		
		public function getProjectID(){return $this->projectid;}
		public function setProjectID($projectid){$this->projectid = $projectid;}
		
		public function getValue($taskID){
			return mysql_fetch_array(mysql_query("SELECT * FROM global_attribute WHERE attributeid = '$this->id' AND globalid = '$taskID'"))["value"];
		}
		
		public function getAttributeID($taskID){
			$id = mysql_fetch_array(mysql_query("SELECT * FROM global_attribute WHERE attributeid = '$this->id' AND globalid = '$taskID'"))["id"];
			if($id){
				return $id;
			}else{
				$id = $this->getNextID();
				mysql_query("INSERT INTO `global_attribute`(`globalid`, `attributeid`) VALUES ('$taskID', '$this->id')");
			}
		}
		
		public function getNextID(){
			return $attributeid = mysql_fetch_array(mysql_query("SELECT `auto_increment`  as id FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'attr'"))["id"];
		}
		
		public function __destruct(){
		}
		
		public function persitence(){
			if($this->id){
				mysql_query("UPDATE `attr` SET `name`='$this->name',`description`='$this->description' WHERE id = '$this->id'");
			}else{
				mysql_query("INSERT INTO `attr`(`name`, `description`, `projectid`)
								VALUES ('$this->name', '$this->description', '$this->projectid')");
			}			
		}
		//------------------
		public static function findAttribute($id = null){
			if($id){
				return new Attribute(mysql_fetch_array(mysql_query("SELECT * FROM `attr` WHERE id = '$id'")));
			}
			
			$attributeArray = array();
			$attributes = mysql_query("SELECT * FROM attr");
			while($attribute = mysql_fetch_array($attributes)){
				array_push($attributeArray, new Attribute($attribute));
			}
			
			return $attributeArray;
		}				
	}
?>