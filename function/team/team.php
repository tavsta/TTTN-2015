<?php
		if(checkAuthenticated()){			
?>
							<?php if(isUser() == NEW_USER){ ?>
								<div><a class="btn btn-warning" href="/?action=create&cat=team">Tạo nhóm mới</a></div>
							<?php } ?>	
							
                            <div class="box post">
                                <div class="box-body post-body">
                                    <div class="post-inner article">
                                        <h2><span class="label label-success">Danh sách nhóm</span></h2>
                                    </div>		
                                </div>
                            </div>
<?php
					$notJoinedTeamList = getGlobalWithType(TEAM);
					while($row = mysql_fetch_array($notJoinedTeamList)){
						$leader = getLeaderInfo($row["id"]);
?>
                            <div class="box post">
                                <div class="box-body post-body">                                   
                                    <div class="panel panel-primary">
                                        <div class="panel-body">
                                            <?php echo $row["name"];?>
                                        </div>
                                        <div class="panel-footer">
                                            <?php echo $row["description"];?>
                                        </div>

										<!-- Button trigger modal -->
										<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal<?=$row["id"]?>">
										  Xem thông tin
										</button>

										<!-- Modal -->
										<form method="post" class="modal fade" id="myModal<?=$row["id"]?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										  <input type="hidden" name="team" value="<?=$row["id"]?>" />
										  <div class="modal-dialog">
											<div class="modal-content">
											  <div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h4 class="modal-title" id="myModalLabel"><?=$row["name"]?></h4>

											  </div>
											  <div class="modal-body">
												<div class="panel panel-danger">
													<div class="panel-heading">Thông tin chi tiết</div>
														<div class="panel-body">
														    <p></p>
														</div>

														  <!-- Table -->
														<table class="table">
														    <tr>
														    	<th>Trưởng nhóm:</th>
														    	<td><input class="form-control" name="firstname" value="<?=$leader["firstname"]." ".$leader["lastname"]?>" readonly="readonly">
														    </tr>
														    <tr>
														    	<th>Ngày thành lập:</th>
														    	<td><input class="form-control" name="createddate" value="<?=$row["createddate"]?>" readonly="readonly"></td>
														    </tr>
														    <tr>
														    	<th>Giới thiệu:</th>
														    	<td><input class="form-control" name="description" value="<?=$row["description"]?>" readonly="readonly"></td>
														    </tr>
														</table>												
												</div>
											  </div>
											  <div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
												<?php if(isUser() == NEW_USER) {?>
													<button type="submit" name="sendJoinRequest" class="btn btn-primary">Yêu cầu tham gia</button>
												<?php }	?>
											  </div>
											</div>
										  </div>
										</form>																				
									</div>                                    
                                </div>
                            </div>
<?php				
					}
		}else{
			echo '<div class="alert alert-warning">B?n chua dang nh?p</div>';
		}
?>