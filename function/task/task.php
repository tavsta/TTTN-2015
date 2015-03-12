<?php
	function displayMember($taskID){
		$members = getMemberBelongTo($taskID);
		$ids = "";
		$names = "";
		while($member = mysql_fetch_array($members)){
			if($ids == ""){
				$ids = $member["id"];
				$names = $member["name"];
			}else{
				$ids = $ids.",".$member["id"];
				$names = $names.", ".$member["name"];
			}
		}
		echo '<div ids="'.$ids.'" >'.$names.'</div>';
	}
	
	function displayTask($parent, $level = 0){
		$taskList = getGlobalBelongTo($parent);
		if($level != 0)
			$hidden = 'hide';
		else
			$hidden = '';
			
		if(mysql_num_rows($taskList) == 0){
			$children = '<span style="padding-left: '.($level*20 + 10).'px; " class=""></span>';
		}else{
			$children = '<span style="padding-left: '.($level*20).'px; " class="glyphicon glyphicon-collapse-down"></span>';
		}
		
		while($task = mysql_fetch_array($taskList)){		
			echo '
				<tr parent="'.$parent.'" id="'.$task["id"].'" class="'.$hidden.'" >
					<td>'.$task["id"].'</td>
					<td>
						<span class="glyphicon glyphicon-plus-sign add"></span>
						<span class="glyphicon glyphicon-edit edit"></span>
						<span class="glyphicon glyphicon-remove remove" data-toggle="modal" data-target="#deleteConfirmModal"></span>
					<td>'.$children.$task["name"].'</td>
					<td>'.$task["startdate"].'</td>
					<td>'.$task["enddate"].'</td>
					<td>';
						displayMember($task["id"]);
			echo '
				</tr>
			';
			displayTask($task["id"], $level + 1);
		}		
	}

?>

<?php
	if(isset($_GET["id"])){
		$task = getGlobalByID($_GET["id"]);
?>

<style>
	#task .remove, #task .edit,  #task .add{
		color: red;
		font-size: 20px;
		cursor: pointer;
	}
</style>

<h2><span class="label label-danger">Dự án phần mềm</span></h2><br><br>
<div class="control">
	<span id="add" class="btn btn-default" title="Thêm công việc con">Thêm</span>
</div><br>
<div class="alert alert-success" role="alert"><h4><?=$task["name"]?>:</h4>
	<form method="post">
		<input type="hidden" id="parent" name="parent" value="<?=$_GET["id"]?>"/>
		<table class="table" id="task">
			<tr>
				<th style="width: 1cm;">ID</th>
				<th style="width: 3cm;"></th>
				<th>Tên</th>
				<th style="width: 3cm;">Bắt đầu</th>
				<th style="width: 3cm;">Kết thúc</th>
				<th style="width: 7cm;">Nhân sự</th>
			</tr>
<?php
		displayTask($_GET["id"]);
?>
		</table>
		<input type="submit" style="display: none" name="createTask"/>

		<?php include "function/task/memberList.php"; ?>
	</form>
	
		<!-- Modal -->
		<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Xác nhận</h4>
			  </div>
			  <div class="modal-body">
					Bạn thực sự muốn xóa công việc này?
					<div style="display: none" id="removeId" value=""></div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				<span type="button" class="btn btn-primary" data-dismiss="modal" id="deleteSubmit">Đồng ý</span>
			  </div>
			</div>
		  </div>
		</div>		
</div>
<script>
	$("#task .remove").click(function(){
		$("#deleteConfirmModal #removeId").attr("value", $(this).parent().parent().attr("id"));
	});
	
	$("#deleteConfirmModal #deleteSubmit").click(function(){
		$.post("http://localhost/tttnphp/suport-ajax/ajax.php",
		{
		  action: "removeGlobal",
		  id: $("#deleteConfirmModal #removeId").attr("value")
		},
		function(data,status){
			console.log(data);
		});					
		
		$("#" + $("#deleteConfirmModal #removeId").attr("value")).remove();
	});
	
	$("#task .add").click(function(){
		$('.task').remove();
		$("#parent").attr("value", $(this).parent().parent().attr("id"));
		$('<tr class="task"><td></td><td></td><td><input type="text" name="name" class="form-control" placeholder="Tên" required></td><td><input type="date" name="startdate" id="startdate" class="form-control" required/> </td><td><input type="date" name="enddate" id="enddate" class="form-control" required></td><td><div class="input-group"><input type="hidden" id="hidden_human" name="human" value=""/><input type="text" id="human" class="form-control" placeholder="Nhân sự" style="width: 80%;"><span class="glyphicon glyphicon-chevron-down" style="font-size: 30px" aria-hidden="true" data-toggle="modal" data-target="#memberlist"></span></div></td></tr>').insertAfter($(this).parent().parent());
	});

	$("#task .glyphicon").click(function(){
		if($(this).is(".glyphicon-collapse-down")){
			$(this).removeClass("glyphicon-collapse-down").addClass("glyphicon-collapse-up");
			$("#task tr[parent='" + $(this).parent().parent().attr("id") + "']").removeClass("hide");		
		}else{
			$(this).removeClass("glyphicon-collapse-up").addClass("glyphicon-collapse-down");
			$("#task tr[parent='" + $(this).parent().parent().attr("id") + "']").addClass("hide");		
		}
	});
		
</script>
<?php
	}else{
		header("Location: ".SITE."?action=project");
	}
?>