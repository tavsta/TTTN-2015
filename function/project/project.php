<?php
	function generateOtherAttributeForm($taskID, $attribute = null, $isModal = true){
		$title = "Sửa thuộc tính";
		$action = "editattribute";
		if(!$attribute){			
			$title = "Thêm thuộc tính";
			$action = "createattribute";
		}
		
		echo '		
		<div class="modal fade" id="createAttributeModal" tabindex="-1" role="dialog" aria-labelledby="createAttributeModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<form class="form-horizontal" role="form" method="post">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Thêm/Chỉnh sửa thuộc tính</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="name" class="col-sm-4 control-label">Tên thuộc tính</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="name" name="name" value="" placeholder="Tên thuộc tính" required>
								</div>
							</div>

							<div class="form-group">
								<label for="value" class="col-sm-4 control-label">Giá trị</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="value" name="value" value="" placeholder="Giá trị công việc hiện tại">
								</div>
							</div>
							
							<div class="form-group">
								<label for="description" class="col-sm-4 control-label">Mô tả</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="description" name="description" value="" placeholder="Mô tả về thuộc tính">
								</div>
							</div>
							
							<input type="hidden" name="taskid" value="'.$taskID.'"/>
							<input type="hidden" name="action" value="'.$action.'"/>
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
							<button type="submit" class="btn btn-primary">Đồng ý</button>
						</div>
					</form>
				</div>
			</div>
		</div>';		
	}
?>
<br><h2><span class="label label-danger">Quản lý dự án</span></h2><br><br>

<style>
	#task .remove, #task .edit,  #task .add, #task .open{
		color: red;
		font-size: 20px;
		cursor: pointer;
		text-decoration: none;
	}
	
	#task .distance{
		padding: 15px;
		height: 100%;
		border-right: 1px dashed grey;
	}
	
	#task .attribute{
		width: 100px;
	}
	
	#task .task-heading{
		color: red;
	}
</style>

<?php
if(isset($_GET["id"]) && $_GET["id"] != ""){
	function displayMember($taskID){
		$task = Task::findTask($taskID);
		$members = $task->getMember();

		$isStart = true;
		foreach($members as $member){
			if($isStart){
				$isStart = false;
			}else{
				echo ', ';
			}
			
			echo '<a href="?action=profile&id='.$member->getID().'" role="button" data-toggle="popover" data-trigger="hover" title="Công việc cụ thể" data-html="true" data-content="'.$member->getMission($task->getID()).'">'.$member->getName().'</a>';		
		}
	}
	
	function displayTask($parentID, $level = 0){		
		$parent = Task::findTask($parentID);
		$taskList = $parent->getChild();
		
		if($level != 0)
			$hidden = 'hide';
		else
			$hidden = '';
			
		$children ="";
		
		for($i = 0; $i <= $level; $i++){
			$children = $children.'<span class="distance"></span>';
		}
		
		$children = $children.'---<span class="expand glyphicon glyphicon-collapse-down"></span>';
		
		foreach($taskList as $task){		
			echo '
				<tr parent="'.$parentID.'" id="'.$task->getID().'" class="'.$hidden.'" >
					<td>'.$task->getID().'</td>
					<td>
						<span class="glyphicon glyphicon-plus-sign add" data-toggle="modal" data-target="#addTaskModal'.$task->getID().'" title="Thêm công việc con"></span>
						<span class="glyphicon glyphicon-remove remove" data-toggle="modal" data-target="#deleteConfirmModal" title="Xóa công việc"></span>
						<span class="glyphicon glyphicon-edit edit" data-toggle="modal" data-target="#editTaskModal'.$task->getID().'" title="Chỉnh sửa công việc"></span>
					<td>'.$children.'<a href="?action=project&id='.$task->getID().'"><strong><span class="name">'.$task->getName().'</span></strong></a></td>
					<td class="startdate" value="'.$task->getStartDate().'">'.reformatDate($task->getStartDate()).'</td>
					<td class="enddate" value="'.$task->getEndDate().'">'.reformatDate($task->getEndDate()).'</td>
					<td>';
						displayMember($task->getId());
						
					echo '
					</td>';
					
					$isForm = false;
					$isHeading = false;
					
					displayOtherAttributeOfTask($task->getID(), $isForm, $isHeading);
			echo '
				</tr>
			';
			displayTask($task->getID(), $level + 1);
		}		
	}
	

#############################################################################	
	$parentTask = Task::findTask($_GET["id"]);
	
	echo '<div id="timeline">';
	if($parentTask){
		displayTimeLine($parentTask->getID());
	echo '</div>
	
	<div>
		<br>
		<center>
			<h3>'.$parentTask->getName().'</h3>
			 ('.reformatDate($parentTask->getStartDate()).' => '.reformatDate($parentTask->getEndDate()).')
		</center>
			<br><br><br>
		
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#createAttributeModal" title="Tạo thuộc tính mới cho toàn bộ dự án">
		  Tạo thuộc tính mới
		</button><br><br>';
			generateOtherAttributeForm($_GET["id"]);
	
	echo '
		<div class="panel panel-info">
			  <div class="panel-heading">
					<h3 class="panel-title">Danh sách các công việc con</h3>
			  </div>
			  <div class="panel-body">
					<form method="post">
						<input type="hidden" id="parent" name="parent" value="'.$parentTask->getID().'"/>
						<div style="width: 100%; overflow-x: scroll">
							<table class="table table-striped" id="task" style="max-width:none !important;">
								<thead>
									<tr class="task-heading">
										<th cwidth="2">ID</th>
										<th cwidth="10"></th>
										<th cwidth="30">Tên công việc</th>
										<th cwidth="15">Thời gian bắt đầu</th>
										<th cwidth="15">Thời gian kết thúc</th>
										<th cwidth="28">Nhân sự
										<script>
											$("#task tr th").map(function(){
												$(this).width($(this).attr("cwidth") * $(window).width() * 0.95 / 100);	
											});
											$("#task").width($(window).width()*0.95 + 500);
										</script>';
											$isForm = false;
											$isHeading = true;
											
											displayOtherAttributeOfTask($_GET["id"], $isForm, $isHeading);
											
										echo'
										<script>
											$("#task").width($(window).width()*0.95 + 100* $("#task .attribute").size());
										</script>
									</tr>
								</thead>
								<tbody>
									<tr id="'.$parentTask->getID().'">
										<td>'.$parentTask->getID().'</td>
										<td>
											<span class="glyphicon glyphicon-plus-sign add" title="Thêm công việc con" data-toggle="modal" data-target="#addTaskModal'.$parentTask->getID().'"></span>
											<span class="glyphicon glyphicon-remove remove" data-toggle="modal" data-target="#deleteConfirmModal" title="Xóa công việc"></span>
											<span class="glyphicon glyphicon-edit edit" title="Chỉnh sửa công việc" data-toggle="modal" data-target="#editTaskModal'.$parentTask->getID().'"></span>

										<td><strong><span class="name" style="color: black; font-size: 120%">'.$parentTask->getName().'</span></strong></td>
										<td class="startdate" value="'.$parentTask->getStartDate().'">'.reformatDate($parentTask->getStartDate()).'</td>
										<td class="enddate" value="'.$parentTask->getEndDate().'">'.reformatDate($parentTask->getEndDate()).'</td>
										<td>';
											displayMember($parentTask->getID());
											
										echo '
										</td>';
										
										$isForm = false;
										$isHeading = false;
										
										displayOtherAttributeOfTask($_GET["id"], $isForm, $isHeading);
									
								echo '
									</tr>';

									displayTask($_GET["id"]);
									
								echo '
								</tbody>
							</table>
						</div>';
						include "function/project/memberList.php";
					echo'	
					</form>
					
					<a href="?action=timeline&cat=project&id='.$parentTask->getID().'" class="btn btn-primary">Xem biểu đồ</a>';

					include "function/project/addOrEditModal.php";
				echo'	
				</div>
		</div>

		
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
			</div>';
			
		
			include "function/project/comment.php";
	echo'
	</div>';
?>	
	<script>
		$("#task .remove").click(function(){
			$("#deleteConfirmModal #removeId").attr("value", $(this).parent().parent().attr("id"));
		});
		
		$("#deleteConfirmModal #deleteSubmit").click(function(){
			$.post("http://localhost/tttn/suport-ajax/ajax.php",
			{
			  action: "removeGlobal",
			  id: $("#deleteConfirmModal #removeId").attr("value")
			},
			function(data,status){
				console.log(data);
			});					
			
			$("#" + $("#deleteConfirmModal #removeId").attr("value")).remove();
			$("#task tr").map(function(){
				if($(this).attr("parent") == $("#deleteConfirmModal #removeId").attr("value"))
					$(this).remove();
			});
		});
		
		$("#task .expand").click(function(){
			if($(this).is(".glyphicon-collapse-down")){
				$(this).removeClass("glyphicon-collapse-down").addClass("glyphicon-collapse-up");
				$("#task tr[parent='" + $(this).parent().parent().attr("id") + "']").removeClass("hide");		
			}else{
				$(this).removeClass("glyphicon-collapse-up").addClass("glyphicon-collapse-down");
				$("#task tr[parent='" + $(this).parent().parent().attr("id") + "']").addClass("hide");		
			}
		});
			
		$("#task tr").map(function(){
			if($("#task tr[parent='" + this.id + "']").size() == 0){
				$(this).find(".glyphicon-collapse-down").removeClass("expand").removeClass("glyphicon-collapse-down").addClass("glyphicon-unchecked");			
			}
		});
		
		$(".control #add").click(function(){
			$('.task').remove();
			$("#task").append('<tr class="task"><td><input type="submit" style="display: none" name="createTask" value="<?=$_GET["id"] ?>"/></td><td></td><td><input type="text" name="name" class="form-control" placeholder="Tên"></td><td><input type="date" name="startdate" id="startdate" class="form-control"/> </td><td><input type="date" name="enddate" id="enddate" class="form-control"></td><td><div class="input-group"><input type="hidden" id="hidden_human" name="human" value=""/><input type="text" id="human" class="form-control" placeholder="Nhân sự" style="width: 80%;"><span class="glyphicon glyphicon-chevron-down" style="font-size: 30px" aria-hidden="true" data-toggle="modal" data-target="#memberlist"></span></div></td></tr>');
		});
		

	</script>
	<?php	
		}else{
			echo '<div class="alert alert-danger" style="text-align: center; font-size: 150%">Không tồn tại công việc!</div>';
		}
	}else{
	?>

	<a class="btn btn-warning" href="?action=create&cat=project">Tạo dự án mới</a><br><br>
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <div class="row">
		<div class="col-md-4">
		  <ul class="list-group" >
	<?php 	
			$projects = Task::findproject();
			$count = 0;
			foreach($projects as $project){
				$count++;
				$class = '';
				
				if($count == 1)
					$class = 'active';
					
				echo '<li class="list-group-item '.$class.'" ><a href="#project'.$count.'" aria-controls="project1" role="tab" data-toggle="tab"  style="color: black">'.$project->getName().'</a></li>';
			}
	?>		
		  </ul>
		  
		</div>
	  <!-- Tab panes -->
	  <div class="tab-content col-md-8" >
	<?php 	
			$count = 0;
			foreach($projects as $project){
				$count++;
	?>	  
				<div role="tabpanel" class="tab-pane <?php if($count == 1) echo "active";?>" id="project<?=$count?>">
					<table class="table">
						<tr>
							<th>Tên dự án</th>
							<td><?=$project->getName()?></td>
						</tr>
						<tr>
							<th>Mô tả</th>
							<td><?=$project->getDescription()?></td>
						</tr>
						<tr>
							<th>Ngày bắt đầu</th>
							<td><?=reformatDate($project->getStartDate())?></td>
						</tr>
						<tr>
							<th>Ngày kết thúc</th>
							<td><?=reformatDate($project->getEndDate())?></td>
						</tr>
					</table>
					
					<a type="button" class="btn btn-primary" href="?action=project&id=<?=$project->getID()?>">
					  Truy cập vào dự án
					</a>

				</div>
	<?php 	}?>		
	  </div>
	</div>
	</div>

	<?php
}
?>