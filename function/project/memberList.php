		<div class="modal fade" id="memberlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Nhân sự</h4>
			  </div>
			  <div class="modal-body">
								<div class='list-group-item'>
									<div class='row' id='searchResult'>
<?php
										$memberList = getMemberList();
										while($member = mysql_fetch_array($memberList)){
?>
											<div class='col-lg-6' id='<?=$member['id']?>' name='<?=$member['name']?>'>
												<div class='input-group'>
													<span class='input-group-addon'>
														<input type='checkbox' mid='<?=$member['id']?>' value='<?=$member['name']?>' > <?=$member['name']?>
													</span>
													<input type='text' class='form-control'>
												</div>
											</div>
<?php										
										}
?>									
									</div>
								</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-primary" id="addHuman" data-dismiss="modal">OK</button>
			  </div>
			</div>
		  </div>
		</div>
		
<script>
	$("#addHuman").click(function(){
		var member = $("#memberlist input:checked");
		var i = 0;
		$("#hidden_human").attr("value", "");
		$("#human").attr("value", "");
				
		for(i = 0; i< member.size(); i++){
			if(i == 0){
				$("#human").attr("value", member[i].getAttribute("value"));
				$("#hidden_human").attr("value", member[i].getAttribute("mid"));
			}else{
				$("#human").attr("value", $("#human").attr("value") + ", " + member[i].getAttribute("value"));
				$("#hidden_human").attr("value", $("#hidden_human").attr("value") + "," + member[i].getAttribute("mid"));
			}
		}
	});

</script>
