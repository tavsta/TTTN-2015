<?php
include "function/profile/profile-core.php";

$changeProfileResult = NONE;
$registerResult = "";

if(isset($_POST["action"])){
	switch($_POST["action"]){
		case "changeprofile":
			if($_POST["password"] == $_POST["repassword"]){
				if($_POST["cpsw"] == 1){
					updateAccount($_POST["name"], $_POST["sex"], $_POST["birthdate"], $_POST["email"], $_POST["telephone"], $_POST["address"], $_POST["password"]);
					removeAccountCookie();
				}else{
					updateAccount($_POST["name"], $_POST["sex"], $_POST["birthdate"], $_POST["email"], $_POST["telephone"], $_POST["address"]);
				}
				
				mysql_query("DELETE FROM member_skill WHERE md5(member_skill.memberid) = '$_COOKIE[account]'");
				if(isset($_POST["skill"]))
					foreach($_POST["skill"] as $skill){
						mysql_query("INSERT INTO member_skill(memberid, skillid) VALUES('".getUserIDFromCookie()."', '$skill')");								
					}
					
//				header(reload());
			}else{
				$changeProfileResult = "Mật khẩu không trùng nhau";
			}
			break;
		case "register":
			if($_POST["username"] == "" || $_POST["password"] == "" || $_POST["repassword"] == "" || $_POST["name"] == "")
				$registerResult = "Phải nhập các thông tin bắt buộc!";
			else{
				if($_POST["password"] != $_POST["repassword"]){
					$registerResult = "Mật khẩu không đúng!";
				}else{
					if(mysql_num_rows(mysql_query("SELECT * FROM account WHERE md5(username) = md5('$_POST[username]') ")) > 0){
						$registerResult = "Tài khoản đã tồn tại!";
					}else{
						if(mysql_query("INSERT INTO account(name, email, password, username, address, telephone, lastvisit, createddate, sex) 
							VALUES('$_POST[name]', '$_POST[email]', md5('$_POST[password]'), '$_POST[username]', '$_POST[address]', '$_POST[telephone]', 'time()', 'time()', '$_POST[sex]')")){
							$ids = mysql_query("SELECT id FROM account WHERE username = '$_POST[username]'");
							$id = mysql_fetch_array($ids)["id"];
							if(isset($_POST["skill"]))
								foreach($_POST["skill"] as $skill){
									mysql_query("INSERT INTO member_skill(memberid, skillid) VALUES('$id', '$skill')");								
								}
								
							setCookie(ACCOUNT, md5($id));							
							header(reload("?action=profile"));
							
						}else{
							$registerResult = "Đăng ký bị lỗi";
						}
					}
				}
			}		
			break;
	}
}
?>