<?php
	if(!checkAuthenticated()){
		echo '
			<div class="home row">
				<div class="left col-md-3">';
				
					include "function/login/login.php";
			
		echo '			
				</div>
				<div class="right col-md-9">
					<div class="panel">';
	
	}
	
		if(!isset($_GET[ACTION])){
			include "function/home/home.php";
		}else{
			$filename = "";
			$core = "";
			
			if(isset($_GET[CAT])){
				$filename = "function/".$_GET[CAT]."/".$_GET[ACTION].".php";
			}else{
				$filename = "function/".$_GET[ACTION]."/".$_GET[ACTION].".php";
			}
			
			if(file_exists($filename)){
				include $filename;
			}else{
				header("Location: /tttn");
			}						
		}
	if(!checkAuthenticated()){	
		echo '
					</div>
				</div>
			</div>';	
	}
?>