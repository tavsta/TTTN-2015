<br><h2><span class="label label-danger">Đăng ký tài khoản mới</span></h2><br><br>
	<?php	
//-----------------------//	
if(!checkAuthenticated()){
?>
	<div class="centered-form" id="abc">
   		<form role="form" method="post">
				<div style="width: 60%; margin: 0px auto;">
					<div style="color: red">
						<strong>(*) Thông tin bắt buộc</strong><br>
						<strong><?=$registerResult?></strong>
					</div>
					<table class="table">
						<tr>
							<th style="width: 5cm;">Tên đăng nhập:</th>
							<td><input type="text" name="username" id="username" class="form-control input-sm" placeholder="Nhập tên đăng nhập" required></td>
							<td><font color="red">*</font></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Mật khẩu:</th>
							<td><input type="password" name="password" id="password" class="form-control input-sm" placeholder="Nhập mật khẩu" required></td>
							<td><font color="red">*</font></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Nhập lại mật khẩu:</th>
							<td><input type="password" name="repassword" id="repassword" class="form-control input-sm" placeholder="Nhập lại mật khẩu" required></td>
							<td><font color="red">*</font></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Họ và tên:</th>
							<td><input type="text" name="name" id="name" class="form-control input-sm" placeholder="Nhập họ và tên" required></td>
							<td><font color="red">*</font></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Giới tính:</th>
							<td>
								<input name="sex" id="sex" type="radio" name="sex" value="0" checked>Nam
								<br>
								<input name="sex" id="sex" type="radio" name="sex" value="1">Nữ		
							</td>

							<td></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Ngày sinh: <font style="font-style:italic;">(ngày/tháng/năm)</font></th>
							<td><input type="date" name="birthdate" id="birthdate" class="form-control input-sm" value="01/01/2014" style="width:70%;"></td>
							<td></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Email:</th>
							<td><input type="email" name="email" id="email" class="form-control input-sm" placeholder="Nhập Email"></td>
							<td></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Số điện thoại:</th>
							<td><input type="tel" name="telephone" id="telephone" class="form-control input-sm" placeholder="Nhập số điện thoại"></td>
							<td></td>
						</tr>
						<tr>
							<th style="width: 5cm;">Địa chỉ liên lạc:</th>
							<td><input type="text" name="address" id="address" class="form-control input-sm" placeholder="Nhập địa chỉ liên lạc"></td>
							<td></td>
						</tr>
						<tr>
							<th style="width: 5cm;" colspan="2">Kỹ năng</th>
						<tr>
							<td colspan="2">
<?php
								generateCodeForSkill();
?>
							</td>
						</tr>
					</table>
					<input type="hidden" name="action" value="register"/>
				</div>
			<input type="submit" value="Đăng ký" class="btn btn-info btn-block" style="width:20%; margin:0 auto;">						
		</form>
    </div>
<?php						
}else{
	echo '<div class="alert alert-warning"><h3>Bạn đã đăng nhập!</h3><br>Để tạo tài khoản mới bạn cần đăng xuất khỏi tài khoản hiện tại</div>';
}
?>