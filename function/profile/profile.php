<br><h2><span class="label label-danger">Thông tin cá nhân</span></h2><br><br>

<?php
if(checkAuthenticated()){
	$profile = "";
	if(isset($_GET["id"])){
		$profile = getMember($_GET["id"]);
	}else{
		$profile = getAccountDetailFromCookie();
	}
	
	$sex = array(
		0 => "Nam",
		1 => "Nữ"
	);
		if(!$profile){			
			echo '
			<center>
				<h1><span class="alert alert-warning">Không tồn tại tài khoản này!</span></h1><br><br><br>
				<span  class="alert alert-info">Bạn có thể xem danh sách thành viên tại <a href="?action=staff">đây</a></span>
			</center><br><br><br>';
		}else{
?>		

			<div class="user-profile" style="width:70%; margin:0 auto;">
				<div class="panel panel-default">

				  <!-- Table -->
				  <table class="table">
					<tr>
						<th>Họ tên</th>
						<td>	    			    			
							<div class="form-control" ><?=$profile["name"]?></div>	    			    			
							<div></div>
						</td>
					</tr>
					<tr>
						<th>Tên đăng nhập</th>
						<td>
							<div class="form-control"><?=$profile["username"]?></div>
						</td>
					</tr>
					<tr>
						<th>Giới tính</th>
						<td>
							<div class="form-control"><?=$sex[$profile["sex"]]?></div>
						</td>
					</tr>
					<tr>
						<th>Ngày sinh</th>
						<td>
							<div class="form-control"><?=reformatDate($profile["birthdate"])?></div>
						</td>
					</tr>
					<tr>
						<th>Email</th>
						<td>
							<div class="form-control"><?=$profile["email"]?></div>
						</td>
					</tr>
					<tr>
						<th>Số điện thoại</th>
						<td>
							<div class="form-control"><?=$profile["telephone"]?></div>
						</td>
					</tr>
					<tr>
						<th>Địa chỉ liên lạc</th>
						<td>
							<div class="form-control"><?=$profile["address"]?></div>
						</td>
					</tr>
					<tr>
						<th>Kỹ năng
						<th>
					</tr>
					<tr>
						<td colspan="2">
						<?php generateCodeForSkill($profile["id"]); ?>
					</tr>
				  </table>
			<?php
					if(!isset($_GET["id"]) || ($_GET["id"] == checkAuthenticated()["id"])){
			?>	  
						<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Thay đổi thông tin</button>

						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
								<h4 class="modal-title" id="myModalLabel">Thông tin cá nhân</h4>
							  </div>
								<form method="post">
									<div class="modal-body">
									  <table class="table">
										<tr>
											<th style="width: 5cm;">Họ tên</th>
											<td>
												
													
												<input type="text"  class="form-control" name="name" value="<?=$profile["name"]?>">
												
												<div></div>
											</td>
										</tr>
										<tr>
											<th style="width: 5cm;">Mật khẩu</th>
											<td>
												<input type="hidden" name="cpsw" id="cpsw" value="0" />
												<input type="password"  class="form-control" name="password" value="<?=$profile["password"]?>" onfocus="$('input:password').attr('value', '');" onchange="checkMatchPassword(this, this.value); $('#cpsw').attr('value', 1)" >
												<div></div>
											</td>
										</tr>
										<tr>
											<th style="width: 5cm;">Nhập lại mật khẩu</th>
											<td>
												<input type="password"  class="form-control" name="repassword" value="<?=$profile["password"]?>" onchange="checkMatchPassword(this)" >
												<div></div>
											</td>
										</tr>
										<tr>
											<th style="width: 5cm;">Giới tính</th>
											<td>
												
													<input type="radio" name="sex" value="0" <?php if($profile["sex"] == 0) echo "checked";?>>Nam<br>
													<input type="radio" name="sex" value="1" <?php if($profile["sex"] == 1) echo "checked";?>>Nữ
										
											</td>
										</tr>
										<tr>
											<th style="width: 5cm;">Ngày sinh<font style="font-style:italic;">(ngày/tháng/năm)</font></th>
											<td>
												<input type="date"  class="form-control" name="birthdate" value="<?=$profile["birthdate"]?>" style="width:60%;">
											</td>
										</tr>
										<tr>
											<th style="width: 5cm;">Email</th>
											<td>
												<input type="email"  class="form-control" name="email" value="<?=$profile["email"]?>">
											</td>
										</tr>
										<tr>
											<th style="width: 5cm;">Số điện thoại</th>
											<td>
												<input type="tel"  class="form-control" name="telephone" value="<?=$profile["telephone"]?>">
											</td>
										</tr>
										<tr>
											<th style="width: 5cm;">Địa chỉ liên lạc</th>
											<td>
												<input type="text"  class="form-control" name="address" value="<?=$profile["address"]?>">
											</td>
										</tr>
										<tr>
											<th>Kỹ năng
											<th>
										</tr>
										<tr>
											<td colspan="2">
											<?php generateCodeForSkill($profile["id"]); ?>
										</tr>
									
									  </table>
									  
									  <input type="hidden" name="action" value="changeprofile"/>
									</div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
									<button type="submit" class="btn btn-primary">Thay đổi</button>
								  </div>
								</form>
							</div>
						  </div>
						</div>
			<?php
						}
			?>			
				</div>
			</div>

<?php
	}
}else{
	echo '<div class="alert alert-warning">Bạn chưa đăng nhập!<br>Mời bạn đăng nhập</div>';
}
?>