<?php

	//*****Remove cookie
	function removeAccountCookie(){	
		unset($_COOKIE[ACCOUNT]);
		setCookie(ACCOUNT, "", time() -3000);
	}
	
	//*****Login with remember password
	function rememberPassword(){
		setCookie(ACCOUNT, $_COOKIE[ACCOUNT], time() + 10000000);		
	}

	function checkAccountCookieExists(){
		if(isset($_COOKIE[ACCOUNT])){
			if($account = mysql_fetch_array(mysql_query("SELECT * FROM account WHERE md5(md5(id)) = '".md5($_COOKIE[ACCOUNT])."'")))
				return $account;
			else{
				removeAccountCookie();
				return null;
			}
		}
	}
	
	//*****Check if user logged and return Account
	function checkAuthenticated(){
		return checkAccountCookieExists();
	}
	
	//*****get account information from cookie
	function getAccountFromCookie(){
		return checkAccountCookieExists();
	}

	//*****get user name from Cookie
	function getUserNameFromCookie(){
		return getAccountFromCookie()["username"];
	}
	
	//*****get user id from Cookie
	function getUserIDFromCookie(){
		return getAccountFromCookie()["id"];
	}
	
	//*****get password from Cookie
	function getPasswordFromCookie(){
		return getAccountFromCookie()["password"];
	}
	
	//*****get account detail information from cookie
	function getAccountDetailFromCookie(){
		return checkAccountCookieExists();
	}
	
	function getCookie(){
		return $_COOKIE["account"];
	}
	
	class Account extends Core{
		private $id = null;
		private $name = "";
		private $type = "NORMAL";
		private $sex = "";
		private $address = "";
		private $telephone = "";
		private $email = "";
		private $username = "";
		private $password = "";
		private $birthdate = "";
		private $job = "";
		private $company = "";
		private $account = null;
		private $skills = null;
	
		public function __construct($id = null){
			if($id){
				if(is_array($id)){
					$account = $id;
				}else{
					$account = mysql_fetch_array(mysql_query("SELECT * FROM account WHERE id = '$id'"));				
				}
				
				if($account){
					$this->account = $account;
					$this->setAddress($account["address"]);
					$this->setName($account["name"]);
					$this->setUsername($account["username"]);
					$this->setBirthdate($account["birthdate"]);
					$this->setPassword($account["password"]);
					$this->setEmail($account["email"]);
					$this->setID($account["id"]);
					$this->setTelephone($account["telephone"]);
				}
			}
		}
		
		public function setID($id){$this->id = $id;}
		public function getID(){return $this->id;}
		
		public function setName($name){$this->name = $name;}
		public function getName(){return $this->name;}
		
		public function setSex($sex){$this->sex = $sex;}
		public function getSex(){return $this->sex;}
		
		public function setAddress($address){$this->address = $address;}
		public function getAddress(){return $this->address;}
		
		public function setTelephone($telephone){$this->telephone = $telephone;}
		public function getTelephone(){return $this->telephone;}
		
		public function setEmail($email){$this->email = $email;}
		public function getEmail(){return $this->email;}
		
		public function setUsername($username){$this->username = $username;}
		public function getUsername(){return $this->username;}
		
		public function setPassword($password){$this->password = $password;}
		public function getPassword(){return $this->password;}
		
		public function setBirthdate($birthdate){$this->birthdate = $birthdate;}
		public function getBirthdate(){return $this->birthdate;}
		
		public function setSkills($skills){$this->skills = $skills;}
		public function getSkills(){return $this->skills;}	

		public function getTask(){
			$tasksArray = array();
			
			$tasks = mysql_query("SELECT global.* FROM global_member, global WHERE global_member.memberid = '$this->id' AND global_member.globalid = global.id");
			
			while($task = mysql_fetch_array($tasks)){
				array_push($tasksArray, new Task($task));
			}
			
			return $tasksArray;
		}
		
		public function getMission($taskID = null){
			if($taskID)
				return mysql_fetch_array(mysql_query("SELECT mission FROM global_member WHERE memberid = '$this->id' AND globalid = '$taskID'"))["mission"];
			else{
				$missionArray = array();
				$missions = mysql_query("SELECT mission FROM global_member WHERE memberid = '$this->id'");
				while($mission = mysql_fetch_array($missions)["mission"]){
					array_push($missionArray, $mission);
				}
				return $missionArray;
			}
		}
		
		public function persitence(){
			if($this->id){
				mysql_query("UPDATE `account` SET `address`= '$this->address',`email`='$this->email',`email`='$this->email',`password`='$this->password',`telephone`='$this->telephone',`sex`='$this->sex',`type`='$this->type',`username`='$this->username',`job`='$this->job',`company`='$this->company',`birthdate`='$this->birthdate' WHERE md5(id) = '".md5($this->id)."'");
			}else{
				mysql_query("INSERT INTO `account`(`address`, `email`, `name`, `password`, `telephone`, `sex`, `type`, `username`, `job`, `company`, `birthdate`) 
											VALUES ('$this->address','$this->email','$this->name','$this->password','$this->telephone','$this->sex','$this->type','$this->username','$this->company','$this->birthdate'");
			}			
		}
		//---------------------------------//
		
		public static function getAccountFromCookie(){
			if(isset($_COOKIE[ACCOUNT])){
				if($account = mysql_fetch_array(mysql_query("SELECT * FROM account WHERE md5(md5(id)) = '".md5($_COOKIE[ACCOUNT])."'")))
					return new Account($account);
				else{
					removeAccountCookie();
					return new Account();
				}
			}			
		}
		
	}
?>