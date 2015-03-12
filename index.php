<?php include "core.php";?>

<?php
	##############Xu ly dang nhap###################
	$authenticated = NOT_LOGGED;
	$handledPost = false;
	
	include "function/profile/profile-process.php";
	include "function/login/login-process.php";
	include "function/project/project-process.php";
	include "function/team/create-process.php";
	include "function/equipment/equipment-process.php";
	include "function/team/team-process.php";
?>


<head>
    <link rel="icon" href="images/favicon.gif" type="image/gif">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Quản lý dự án phần mềm - Trang chủ</title>

	<script type="text/javascript" src="<?=SITE ?>bootstrap/js/jquery.js"></script>		
	<script type="text/javascript" src="<?=SITE ?>bootstrap/js/script.js"></script>
	<link rel="stylesheet" href="<?=SITE ?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?=SITE ?>bootstrap/css/bootstrap-theme.min.css">
	<script src="<?=SITE ?>bootstrap/js/bootstrap.min.js"></script>	
	<script src="<?=SITE ?>bootstrap/js/angular.min.js"></script>	
    <link rel="stylesheet" href="<?=SITE ?>bootstrap/css/style.css" type="text/css" media="screen" />
    <script type="text/javascript" src="<?=SITE ?>scripts/jquery-1.11.1.min.js"></script>
</head>
</body ng-controller="">
	<div class="container">
		<div class="panel panel-default wrap">
			<!--Menu bar -->
			<div id="menu-bar">
				<?php include "function/menubar/menubar.php"; ?>
			</div>
			
			<!-- Banner --->
			<div id="banner">
				<?php include "function/banner/banner.php"; ?>
			</div>
			
			<!-- Body -->
			<div id="body">
				<?php include "body.php"; ?>
			</div>
			
			<!-- footer -->
			<div  class="footer" style="background-image: url('images/footer.png'); ">
				<?php include "function/footer/footer.php"; ?>
			</div>
			
		</div>
	</div>
</body>
<?php ob_end_flush(); ?>