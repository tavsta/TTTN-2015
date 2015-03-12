<?php
	function generateEquipmentForm($equipment = null, $isModal = true){
		$title = "Sửa trang thiết bị";
		$action = "editequipment";
		if(!$equipment){
			$equipment = new Equipment();
			
			$title = "Thêm trang thiết bị";
			$action = "createequipment";
		}
		
		$groupNames = Equipment::getGroupName();
		$thisEquipmentGroupName = $equipment->getGroup();
		
		echo '
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#'.$action.'Modal'.$equipment->getID().'">
			'.$title.'
		</button>';
		
		echo'
		<div class="modal fade" id="'.$action.'Modal'.$equipment->getID().'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Thêm/Sửa trang thiết bị</h4>
			  </div>
			  <div class="modal-body">					
					<center><br><h2><span class="label label-danger">'.$title.'</span></h2><br><br></center>

					<form class="form-horizontal" role="form" method="post">
					  <div class="form-group">
						<label for="name" class="col-sm-4 control-label">Tên trang thiết bị</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="name" name="name" value="'.$equipment->getName().'" placeholder="Tên trang thiết bị">
						</div>
					  </div>
					  <div class="form-group">
						<label for="model" class="col-sm-4 control-label">Số hiệu trang thiết bị</label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="model" name="model" value="'.$equipment->getModel().'"placeholder="Số hiệu trang thiết bị">
						</div>
					  </div>
					  <div class="form-group">
						<label for="description" class="col-sm-4 control-label">Mô tả</label>
						<div class="col-sm-8">
							<textarea class="form-control" id="description" name="description" value="'.$equipment->getDescription().'"placeholder="Mô tả" rows="3"></textarea>
						</div>
					  </div>
					  <div class="form-group">
						<label for="group" class="col-sm-4 control-label">Loại trang thiết bị</label>
						<div class="col-sm-4">
						  <select class="form-control" id="group" name="group">';
						  
						foreach($groupNames as $groupName){
							$selected = '';
							if($thisEquipmentGroupName =  $groupName)
								$selected = 'selected';
								
							echo '
							<option value="'.$groupName.'" '.$selected.'>'.$groupName.'</option>';
						}
						
						echo'				
						  </select>
						</div>
						<div class="col-sm-4">
						  <input type="text" class="form-control" id="newgroup" name="newgroup" value="" placeholder="Nhập loại mới">
						</div>
					  </div>
					  
					  <input type="hidden" name="id" value="'.$equipment->getID().'" />
					  <input type="hidden" name="action" value="'.$action.'"/>
					  
					  <div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
							<button type="submit" class="btn btn-primary">Đồng ý</button>
						</div>
					  </div>
					</form>
				</div>
			</div>
		  </div>
		</div>';
	}

	function equipmentTable($equipmentList = null, $groupTab = "all"){
		if(!$equipmentList){
			equipmentTable(Equipment::findEquipment());
			
			$equipmentGroup = Equipment::getEquipmentInGroup();
			$count = 0;
			
			foreach($equipmentGroup as $groupName => $equipmentList){
				$count++;
				equipmentTable($equipmentList, "g".$count);
			}			
		}else{
			$isActive = "active";
			if($groupTab != "all")
				$isActive = "";
			
			echo'
			<div role="tabpanel" class="tab-pane '.$isActive.'" id="'.$groupTab.'">
				<table class="table" style="width: 100%">
					<tr style="width: 100%">
						<th style="width: 2cm">STT</th>
						<th style="width: 30%">Tên thiết bị</th>
						<th style="width: 20%">Mẫu mã</th>
						<th>Thông tin</th>
						<th style="width: 10%">Tình trạng</th>
					</tr>';
				
				$count = 0;
				foreach($equipmentList as $equipment){	
					$count++;
					$status = "";
					
					echo'
					<tr>
						<td>'.$count.'</td>
						<td>'.$equipment->getName().'</td>
						<td>'.$equipment->getModel().'</td>
						<td>'.$equipment->getDescription().'</td>
						<td>'.$status.'</td>
					</tr>';
				}
				
				echo '
				</table>
			</div>';
				
				destroy($equipmentList);
		}
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

<br><h2><span class="label label-danger">Quản lý trang thiết bị</span></h2><br><br>

<?php generateEquipmentForm();

echo'
<div role="tabpanel">

  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">Tất cả</a></li>';
	
	$groupNames = Equipment::getGroupName();
	$count = 0;
	
	foreach($groupNames as $group){
	$count++;
	echo '
		<li role="presentation"><a href="#g'.$count.'" aria-controls="g'.$count.'" role="tab" data-toggle="tab">'.$group.'</a></li>';
		
	}
echo'
  </ul>

	<div class="tab-content">';
		equipmentTable();
echo '			
	</div>
</div>';
?>
