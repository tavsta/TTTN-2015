<?php

	function staffTable($staffList){
		echo'
		<table class="table" style="width: 100%">
			<tr style="width: 100%">
				<th style="width: 2cm">STT</th>
				<th>Tên nhân viên</th>
				<th>Ngày sinh</th>
				<th>Điện thoại</th>
				<th>Email</th>
				<th>Công việc đang tham gia</th>
				<th>Công việc đã hoàn thành</th>
			</tr>';
		
		$count = 0;
		while($staff = mysql_fetch_array($staffList)){
			$count++;
			$finishedTask = true;
			
			echo'
			<tr>
				<td>'.$count.'</td>
				<td>
					<a href="?action=profile&id='.$staff["id"].'"><strong>'.$staff["name"].'</strong></a></td>
				<td>'.$staff["birthdate"].'</td>
				<td>'.$staff["telephone"].'</td>
				<td>'.$staff["email"].'</td>
				<td>';
					displayJoinedTask($staff["id"]);
			echo'
				<td>';
					displayJoinedTask($staff["id"], $finishedTask);
			echo'
			</tr>';
		}
		
		echo '
		</table>';
	}
	
	function displayJoinedTask($memberID, $finishedTask = false){
		$taskList = getJoinedTask($memberID, $finishedTask);
		
		while($task = mysql_fetch_array($taskList)){
			if($finishedTask && strtotime(reformatDate($task["enddate"])) > time()){
				echo '<a class="btn btn-info btn-sm" href="?action=project&id='.$task["taskid"].'">'.$task["taskname"].'</a> ';
			}
			if(!$finishedTask && strtotime(reformatDate($task["enddate"])) < time()){
				echo '<a class="btn btn-info btn-sm" href="?action=project&id='.$task["taskid"].'">'.$task["taskname"].'</a> ';
			}
		}
	}

	function getStaffGroup(){
		return mysql_query("SELECT type FROM account GROUP BY type");
	}
	
	function getAllStaff(){
		return mysql_query("SELECT * FROM account");
	}
	
	function getStaffInGroup($group){
		return mysql_query("SELECT * FROM account WHERE type = '$group'");
	}
	
	function getJoinedTask($memberID){		
		return mysql_query("SELECT *, global.id as taskid, global.name as taskname FROM global, global_member WHERE global_member.memberid = '$memberID' AND global_member.globalid = global.id AND global.type = 'TASK'");
	}
?>

<style>
	.group{
		cursor: pointer;
	}
	
	.group div{
		margin: 0px;
	}
</style>

<br><h2><span class="label label-danger">Quản lý nhân viên</span></h2><br><br>

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">Tất cả</a></li>
<?php
$staffGroup = getStaffGroup();
$count = 0;
while($group = mysql_fetch_array($staffGroup)){
	$count++;
	echo '
	<li role="presentation"><a href="#g'.$count.'" aria-controls="g'.$count.'" role="tab" data-toggle="tab">'.$group["type"].'</a></li>';
}

?>	
  </ul>

  <!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="all">
			<?php staffTable(getAllStaff()); ?>
		</div>
<?php
	$count = 0;
	$staffGroup = getStaffGroup();
	while($group = mysql_fetch_array($staffGroup)){
		$count++;
		echo'
		<div role="tabpanel" class="tab-pane" id="g'.$count.'">';
			staffTable(getStaffInGroup($group[0]));
		echo'
		</div>';
	}
?>
	</div>
</div>
