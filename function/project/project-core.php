<?php
	function getAttributeGroup($projectID){
		return mysql_query("SELECT name FROM attribute WHERE taskid = '$projectID'");
	}
	
	function getAttributeByID($id){
		return mysql_fetch_array(mysql_query("SELECT * FROM attribute WHERE id = '$id'"));
	}

	function getAttribute($taskID, $attributeName, $attributeValue = ""){
		$attribute = mysql_query("SELECT * FROM attribute WHERE taskid = '$taskID' AND name = '$attributeName'");
		if(mysql_num_rows($attribute) == 0){
			mysql_query("INSERT INTO attribute(taskid, name, value) VALUES('$taskID', '$attributeName', '$attributeValue')");
			
			$attribute = mysql_fetch_array(mysql_query("SELECT * FROM attribute WHERE taskid = '$taskID' AND name = '$attributeName'"));
			
			if($attributeValue != "")
				mysql_query("UPDATE attribute SET value = '$attributeValue' WHERE id = '$attribute[id]' ");
			return array("id" => $attribute["id"], "name" => $attributeName, "value" => $attributeValue, "action" => "insert");
		}else{		
			$attribute = mysql_fetch_array($attribute);
			
			if($attributeValue != "")
				mysql_query("UPDATE attribute SET value = '$attributeValue' WHERE id = '$attribute[id]' ");
			
			return getAttributeByID($attribute["id"]);
		}
	}
	
	function setOtherAttribute($attributeList, $isCreateAndSet = false){
		if($isCreateAndSet){
			//$query = 'INSERT INTO glo';
		}else{
			foreach ($attributeList as $id => $value){
				mysql_query("UPDATE attribute SET value = '$value' WHERE id = '$id'");			
			}		
		}
	}
	
	function createAttribute($taskID, $attributeName, $attributeValue){
		$project = getProjectOfTask($taskID);
		getAttribute($project["id"], $attributeName);
		
		getAttribute($taskID, $attributeName, $attributeValue);
	}
	
	function displayOtherAttributeOfTask($taskID, $isForm = true, $isHeading = false, $isAddTask = false){
		$task = Task::findTask($taskID);
		$project = $task->getProject();
		
		$attributes = $project->getAttribute();
		
		foreach($attributes as $attribute){			
			if($isForm){
				if($isAddTask){
					$attributeName = $attribute->getName();
					$attributeValue = "";
				}else
					$attributeName = $attribute->getName();
				
				echo'
				<div class="form-group">
					<label for="key'.$attribute->getAttributeID($task->getID()).'" class="col-sm-4 control-label">'.$attribute->getName().'</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="key'.$attribute->getAttributeID($task->getID()).'" name="attribute['.$attribute->getAttributeID($task->getID()).']" value="'.$attribute->getValue($task->getID()).'" placeholder="'.$attribute->getName().'">
					</div>
				</div>';
			}else{
				if(!$isHeading){
					echo
						'<td>'.$attribute->getValue($task->getID());
				}else{
					echo 
						'<th class="attribute">'.$attribute->getName().'<br>
							<span class="glyphicon glyphicon-remove"></span>
							<span class="glyphicon glyphicon-edit"></span>';
				}
			}
		}
	}
	
	function generateMemberWithTaskCode($taskID, $isAddTask = false){
		$memberArray = getMemberWithTask($taskID, $isAddTask);
		
	
		$checked = array(
			false	=> "",
			true	=> "checked"
		);
		
		echo'
		<div class="row">';
		for($i = 0; $i < sizeof($memberArray); $i++){
			echo'
			<div class="col-md-6">
				<div class="form-control">
					<input type="checkbox" id="member" name="member[]" value="'.$memberArray[$i]["id"].'" '.$checked[$memberArray[$i]["isInTask"]].'>
					<a href="?action=profile&id='.$memberArray[$i]["id"].'">
						'.$memberArray[$i]["name"].'
					</a>
					<span class="badge">'.sizeof($memberArray[$i]["taskArray"]).'</span>
				</div>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" id="mssion" name="mission['.$memberArray[$i]["id"].']" value="'.$memberArray[$i]["mission"].'" >
			</div>';
		}
				
		echo'
		</div>';				
	}
	
	function displayTaskDetail($taskID = "", $parentID = ""){
		$isForm = true;
		$isHeading = false;
		
		if($parentID == ""){//$taskID is not empty
			$task = Task::findTask($taskID);
			$parent = $task->getParent();
			
			if($parent)
				$minOfStart = $parent->getStartDate();
			else 
				$minOfStart = '';
				
			$maxOfStart = $task->getEndDate();
			$minOfEnd = $task->getStartDate();
			
			if($parent)
				$maxOfEnd = $parent->getEndDate();
			else
				$maxOfEnd = '';
						
			$action = "editTask";
			$modal = "editTaskModal";
			$label = "Lưu thay đổi";
			$isAddTask = false;
		}else{
			$parent = Task::findTask($parentID);
			$task = new Task();

			$taskID = $parentID;
			
			$minOfStart = $parent->getStartDate();
			$maxOfStart = $parent->getEndDate();
			$minOfEnd = $parent->getStartDate();
			$maxOfEnd = $parent->getEndDate();
			
			$action = "addTask";
			$modal = "addTaskModal";
			$label = "Tạo";
			$isAddTask = true;
		}
		
		echo'
<div class="modal fade" id="'.$modal.$taskID.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 100% !important">
		<div class="modal-dialog" style="width: 60% !important">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Thêm hoặc sửa công việc</h4>
				</div>
				<div class="modal-body">
				
					<form class="form-horizontal" role="form" method="post">
						<div class="form-group">
							<label for="name" class="col-sm-4 control-label">Tên công việc</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="name" name="name" value="'.$task->getName().'" placeholder="Tên công việc" required>
							</div>
						</div>
						
						<div class="form-group">
							<label for="description" class="col-sm-4 control-label">Mô tả</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="description" name="description" value="'.$task->getDescription().'" placeholder="Mô tả công việc">
							</div>
						</div>
						
						<div class="form-group">
							<label for="startdate" class="col-sm-4 control-label">Ngày bắt đầu</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" id="startdate" name="startdate" value="'.$task->getStartDate().'" min="'.$minOfStart.'" max="'.$maxOfStart.'" required>
							</div>
						</div>

						<div class="form-group">
							<label for="enddate" class="col-sm-4 control-label">Ngày kết thúc</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" id="enddate" name="enddate" value="'.$task->getEndDate().'" min="'.$minOfEnd.'" max="'.$maxOfEnd.'" required>
							</div>
						</div>

						<div class="form-group">
							<label for="leader" class="col-sm-4 control-label">Người quản lý</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="leader" name="leader" value="'.$task->getLeaderID().'" placeholder="Người quản lý">
							</div>
						</div>

						<div class="form-group">
							<label for="member" class="col-sm-4 control-label">Thành viên của công việc</label>
							<div class="col-sm-8">
								<div class="form-control" style="height: 4cm; overflow-y: scroll;  overflow-x: auto">';
								
									generateMemberWithTaskCode($taskID, $isAddTask);
								
echo'
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label for="equipment" class="col-sm-4 control-label">Tên trang thiết bị</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="equipment" name="equipment" value="" placeholder="Tên trang thiết bị">
							</div>
						</div>';
					
						displayOtherAttributeOfTask($taskID, $isForm, $isHeading, $isAddTask);
						
					echo '
						<input type="hidden" name="id" value="'.$taskID.'" />
						<input type="hidden" name="action" value="'.$action.'"/>
						
						<div class="panel-footer">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label"></label>
								<div class="col-sm-8">
									<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
									<button type="submit" class="btn btn-primary">Lưu thay đổi</button>
								</div>
							</div>
						</div>
						
					</form>
					<script>
						$("#startdate").change(function(){
							alert("sdffk");
						});
					</script>
				</div>
			</div>
		</div>
</div>';	
	}
	
	function displayTimeLine($taskID){
		$link = ereg_replace('([^0-9])[0-9]+', '\\1',getCurrentPageURL());
		$task = Task::findTask($taskID);
		
		$parent = $task->getParent();
		
		if($parent){
			displayTimeLine($parent->getID());
		}else{
			echo '<a href="?action=project">Danh sách các dự án</a>';
		}
		echo ' > <a href="'.$link.$task->getID().'">'.$task->getName().'</a>';
	}
	
?>