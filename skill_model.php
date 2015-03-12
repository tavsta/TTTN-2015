<?php	
	class Skill extends Core{	
		private $id = null;
		private $name;
		private $belongto = -1;
		private $skill = array();
		private $account = null;
		private $tableName = "skill";
		private $child = null;
		private $isOfMember = false;
		
		public function __construct($skill = null){
			if($skill){
				$this->id = $skill["id"];
				$this->name = $skill["name"];
				$this->belongto = $skill["belongto"];
				$this->skill = $skill;
			}
		}
		
		public function getID(){ return $this->id;}
		public function setID($id){return $this->id = $id;}
		
		public function getName(){return $this->name;}		
		public function setName($name){return $this->name = $name;}

		public function getBelongto(){return $this->belongto;}		
		public function setBelongto($belongto){return $this->belongto = $belongto;}
		
		public function getIsOfMember(){return $this->isOfMember;}
		public function setIsOfMember($isOfMember = true){$this->isOfMember = $isOfMember;}
		
		public function _get(){return $this->skill;}		
		public function _set($skill){$this->skill = $skill;}
		
		public function getSkillBelongto($belongto = -1){
			$skillArray = array();
			$skills = mysql_query("SELECT * FROM ".$this->tableName." WHERE belongto = '".$belongto."'");
			
			while($skill = mysql_fetch_array($skills)){
				array_push($skillArray, new Skill($skill));
			}

			return $skillArray;
		}
		
		public function getChild(){
			return $this->child;
		}
		
		public function createChild(){
			$this->child = $this->getSkillBelongto($this->id);		
			return $this->child;
		}
		
		public function persitence(){
			if($this->id){
				mysql_query("UPDATE `skill` SET `name`='$this->name',`belongto`='$this->belongto' WHERE id = '$this->id'");
			}else{
				mysql_query("INSERT INTO ".$this->tableName."(name, belongto) VALUES('$this->name', '$this->belongto')");
			}
		}
		
		public function __destruct(){
			$this->persitence();
		}
//-------------------------Static --------------------------------//
		public static function destroy($skillArray = null){
			if($skillArray){
				for($i = 0; $i < sizeof($skillArray); $i++){
					Skill::destroy($skillArray[$i]->child);
					$skillArray[$i] = null;
					print($i." ");
				}
			}
		}
		
		public static function findSkill($id = null, $tableName = 'skill'){
			$skillArray = array();

			if($id){
				$skills = mysql_query("SELECT * FROM $tableName WHERE id = '$id'");
			}else{
				$skills = mysql_query("SELECT * FROM $tableName WHERE belong IS NULL");
			}
			
			while($skill = mysql_fetch_array($skills)){
				array_push($skillArray, new Skill($skill));
			}
			return $skillArray;
		}

		public static function findSkillOfMember($memberID){
			$skillArray = array();
						
			if($memberID){
				$memberIDSkillArray = array();
				$memberSkills = mysql_query("SELECT DISTINCT member_skill.skillid as skillid FROM member_skill WHERE member_skill.memberid = '$memberID'");
				while($memberSkill = mysql_fetch_array($memberSkills)){
					array_push($memberIDSkillArray, $memberSkill["skillid"]);
				}
				
				$skills = mysql_query("SELECT * FROM skill WHERE belongto = -1");
				while($skill = mysql_fetch_array($skills)){
					$skillObj = new Skill($skill);
					if(in_array($skillObj->getID(), $memberIDSkillArray))
						$skillObj->setIsOfMember();
						
					$skillObj->createChild();
					for($i = 0; $i < sizeof($skillObj->getChild()); $i++){
						if(in_array($skillObj->getChild()[$i]->getID(), $memberIDSkillArray))
							$skillObj->getChild()[$i]->setIsOfMember();
							
					}
					
					array_push($skillArray, $skillObj);
				}				
			}else{
				$skills = mysql_query("SELECT * FROM skill WHERE belongto = -1");
				while($skill = mysql_fetch_array($skills)){
					$skillObj = new Skill($skill);
					$skillObj->createChild();
					array_push($skillArray, $skillObj);
				}				
			}
			
			return $skillArray;
		}
	}
?>