
<?php
	if(isUser() == NEW_USER){
?>
<div class="box post">
    <div class="box-body post-body">                                 
        <form class="panel" role="form" method="post">
			<div class="form-group">
				<input type="text" name="name" id="name" class="form-control input-sm" placeholder="Tên nhóm">
			</div>
			<div class="form-group">
				<input type="text" name="description" id="description" class="form-control input-sm" placeholder="Giới thiệu về nhóm">
			</div>
						
			<div id="member" class="panel panel-default ">
				<div class="panel-heading">					
					<h2><span class="label label-success">Nhân sự</span></h2>
				</div>
				<div class="panel-body">
					<div class="panel panel-default not-margin-top">
						<div class="panel-heading">
							<h3><span class="label label-info">Danh sách thành viên hiện tại</span></h3>
						</div>
						<div class="panel-body">
							<ul class="list-group">
								<li class="list-group-item">
									<div class="row" id="joinedMemberList">
<?php
										
/*
										$memberList = getMemberList();
										while($member = mysql_fetch_array($memberList)){
?>
											<div class="col-lg-6" id="<?=$member["id"]?>" firstname="<?=$member["firstname"]?>" lastname="<?=$member["lastname"]?>">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox"> <?=$member["firstname"]." ".$member["lastname"]?>
													</span>
													<input type="text" class="form-control">
												</div><!-- /input-group -->
											</div>
<?php										
										}
*/										
?>																			
									</div>
								</li>
							</ul>
							<input type="button" id="removeMember" class="btn btn-warning" value="Xóa" /><br>
						</div>
					</div>	
					<div id="member" class="panel panel-default">
						<div class="panel-heading">
							<h3><span class="label label-info">Thêm thành viên</span></h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="form-group">
									<div class="col-md-10"><input type="text" id="key" class="form-control input-sm" placeholder="Nhập tên thành viên để tìm kiếm" value=""></div>
								</div>
							</div> <br>
							
							<div class="list-group">
								<div class="list-group-item">
									<div class="row" id="searchResult">
<?php
										$memberList = getMemberList();
										while($member = mysql_fetch_array($memberList)){
?>
											<div class="col-lg-3" id="<?=$member["id"]?>" name="<?=$member["name"]?>">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox"> <?=$member["name"]?>
													</span>
													<input type="text" class="form-control">
												</div><!-- /input-group -->
											</div>
<?php										
										}
?>									
									</div>
								</div>
								<br><input type="button" id="addMember" class="btn btn-warning" value="Thêm" /><br>								
							</div>
						</div>
					</div>					
				</div>
			</div>			
			<br><input type="submit" name="createTeam" class="btn btn-danger" value="Xác nhận" /><br>
		</form>
	</div> 
</div>
<?php
	}else{
		echo '<div class="alert alert-warning">Bạn đang là thành viên của một nhóm nào đó<br>
				Hoặc bạn đang nhận lời mời từ một nhóm nào đó, hãy hủy lời mời<br>
				Hoặc bạn đang gửi yêu cầu tham gia một nhóm nào đó</div>';
		if($createTeamResult != NONE){
			switch($createTeamResult){
				case EMPTY_NAME:
					echo '<div class="alert alert-warning">Tên nhóm không được để trống</div>';
					break;
				case CREATE_GLOBAL_SUCCESS:
					echo '<div class="alert alert-success">Nhóm đã được tạo thành công</div>';
					break;
				case CREATE_GLOBAL_FAILED:
					echo '<div class="alert alert-error">Nhóm đã được tạo bị lỗi</div>';
					break;
			}
		}
	}
?>