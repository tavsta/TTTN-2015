	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			<li class=""><a href="">TRANG CHỦ</a></li>
			<li class=""><a href="?action=about">GIỚI THIỆU</a></li>
<?php
		if(checkAuthenticated()){
?>					
				<li class=""><a href="?action=project">DỰ ÁN</a></li>
				<li class=""><a href="?action=staff">NHÂN SỰ</a></li>
				<li class=""><a href="?action=equipment">TRANG THIẾT BỊ</a></li>
<?php
		}
?>
			<li class=""><a href="?action=contact">LIÊN HỆ</a></li>
		  </ul>
<?php
		if(checkAuthenticated()){
?>		
			<form class="navbar-form navbar-right" role="form" method="post">
				<?php 
					$getJoinOrInviteRequest = getJoinOrInviteRequest();
					if($getJoinOrInviteRequest != null){//some join or invitation request
						if(!is_array($getJoinOrInviteRequest)){//is not invitation
							if(mysql_num_rows($getJoinOrInviteRequest) > 0)
?>
							<!-- Button trigger modal -->
							
							<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
							  <span id="message" class="badge"><?=mysql_num_rows($getJoinOrInviteRequest)?></span>
							</button>

							<!-- Modal -->
							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">(Những) Yêu cầu tham gia nhóm</h4>
								  </div>
								  <div class="modal-body" id="joinrequest">
<?php
									while($joinRequest = mysql_fetch_array($getJoinOrInviteRequest)){
											echo '
												<div class="row" value="'.$joinRequest["relationid"].'"  value="'.$joinRequest["relationid"].'">
													<div class="col-md-8">
														<code>'.$joinRequest["firstname"].' '.$joinRequest["lastname"].'</code> xin yêu cầu được tham gia nhóm của bạn 
													</div>
													<div class="col-md-2"><span class="accept-eject accept-join btn btn-warning">Chấp nhận</span></div>
													<div class="col-md-2"><span class="accept-eject eject-join btn btn-danger">Từ chối</span></div>
												</div>';
									}
?>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								  </div>
								</div>
							  </div>
							</div>
<?php								
						}
					}
				?>
			</form>
			<form class="navbar-form navbar-right" role="form" method="post" action="<?php echo SITE;?>">
				<a href="?action=profile"><span class="glyphicon glyphicon-user" style="font-size: 30px"></span></a>
				<button type="submit" name="logout" class="btn btn-default navbar-right">Log out</button>
			</form>
<!---
			<form class="navbar-form navbar-right" role="search">
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>
-->
<?php
		}
?>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
