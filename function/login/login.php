<?php
	if(!checkAuthenticated()){
?>	
		<div class="panel panel-default">
			<fieldset  style="width: 90%; margin: 0 auto;">
				   <form class="form-signin" role="form" method="post">
					<h2 class="form-signin-heading">Đăng nhập</h2>
					<?php
						if(isset($loginResult) && $loginResult == ERROR){
							echo '<div class="alert alert-failed" role="alert">Mời đăng nhập lại</div>';
						}
					?>
					<label for="username" class="sr-only">Tài khoản</label>
					<input type="text" id="username" name="username" class="form-control" placeholder="Tài khoản" required="" autofocus="">
					<label for="password" class="sr-only">Mật khẩu</label>
					<input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" required="">
					<div class="checkbox">
					  <label>
						<input type="checkbox" name="remember" value="remember-me"> Lưu đăng nhập
					  </label>
					</div>
					<div><a href="?action=register&cat=profile#abc">Đăng ký tài khoản mới</a></div>
					<div><a href="#">Quên mật khẩu?</a></div><br>
					<button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Đăng nhập</button><br>
				  </form>			
				 
			</fieldset>	  
		</div>
<?php
	}
?>