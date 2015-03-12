<?php	
	function login($username, $password){
		$account = mysql_query("SELECT * FROM account WHERE md5(username) = '".md5($username)."' AND password = '".md5($password)."'");
		
		if($account =  mysql_fetch_array($account)){
			setcookie(ACCOUNT, md5($account["id"]));
			return true;
		}else{
			return false;
		}
	}
	
##########################################################################################################	
	$loginResult = NONE;
	
	if(isset($_POST["logout"]) && !$handledPost){
		removeAccountCookie();
	}
	
	if(!checkAccountCookieExists()){
		if(isset($_POST['login']) && !$handledPost){
			if(login($_POST['username'], $_POST['password'])){
				if(isset($_POST["remember"])) rememberPassword();
				if(isset($_GET[ACTION]) && ($_GET[ACTION] == "register"))
					header(reload(""));
				else
					header(reload());
			}else{
				$loginResult = ERROR;
			}
		}
	}

?>