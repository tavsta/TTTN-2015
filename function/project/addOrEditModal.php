<?php
	function displayModal($taskID){
		$task = Task::findTask($taskID);
		displayTaskDetail($task->getID());
		displayTaskDetail("", $task->getID());

		$children = $task->getChild();
		foreach($children as $child){
			displayModal($child->getID());			
		}
	}
	
	######################
	
	displayModal($_GET["id"]);
?>