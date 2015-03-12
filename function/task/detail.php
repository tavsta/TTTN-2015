<style>
	
</style>
<?php
	function displayMember($taskID){
		echo '<div>Nhân sự</div>';
		echo '<div>Nhân sự</div>';
		echo '<div>Nhân sự</div>';
	}
	
	function displayResource($taskID){
		echo '<div>Tài nguyên</div>';
		echo '<div>Tài nguyên</div>';
		echo '<div>Tài nguyên</div>';
	}
	
	function displayTask($parent, $level = 0){
		$taskList = getGlobalBelongTo($parent);
		if($level != 0)
			$hidden = "";
		while($task = mysql_fetch_array($taskList)){		
			echo '
				<tr class="e'.$task["id"].'">
					<td>
						<input name="obj" type="radio" class="checkbox"/>
					</td>
					<td>'.$task["id"].'</td>
					<td style="padding-left: '.($level*10).'px">'.$task["name"].'</td>
					<td>sẽ tính</td>
					<td>'.$task["startdate"].'</td>
					<td>'.$task["enddate"].'</td>
					<td>';
						displayMember($task["id"]);
			echo '			
					<td>';
						displayResource($task["id"]);
			echo '
				</tr>
			';
			displayTask($task["id"], $level + 1);
		}		
	}

?>
<h2><span class="label label-danger">Dự án phần mềm</span></h2><br><br>
<div class="control">
	<span id="add" class="btn btn-default" title="Thêm công việc con">Thêm</span>
	<span id="edit" class="btn btn-default" title="Thêm công việc con">Sửa</span>
	<span id="delete" class="btn btn-default" title="Thêm công việc con">Xóa</span>
</div><br>
<div class="alert alert-success" role="alert"><h4>Tên dự án:</h4>
	<table class="table" id="task">
		<tr>
			<th></th>
			<th>ID</th>
			<th>Tên</th>
			<th>Thời gian</th>
			<th>Bắt đầu</th>
			<th>Kết thúc</th>
			<th>Nhân sự</th>
			<th>Thiết bị</th>
		</tr>
<?php
		displayTask(12);
?>
	</table>
</div>