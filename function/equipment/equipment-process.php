<?php
	if(isset($_POST["action"])){
		switch($_POST["action"]){
			case "createequipment":
				$equipment = new Equipment();
				$equipment->setName($_POST["name"]);
				$equipment->setDescription($_POST["description"]);
				$equipment->setModel($_POST["model"]);
				$equipment->setGroup($_POST["group"]);
				$equipment->persitence();
				$equipment = null;
			break;			
			case "editequipment":
				$equipment = new Equipment();
				$equipment->setName($_POST["name"]);
				$equipment->setDescription($_POST["description"]);
				$equipment->setModel($_POST["model"]);
				
				if(isset($_POST["newgroup"]) && $_POST["newgroup"] != "")
					$equipment->setGroup($_POST["newgroup"]);
				else 
					$equipment->setGroup($_POST["group"]);
					
				$equipment->persitence();
				$equipment = null;
			break;			
		}
	}
?>