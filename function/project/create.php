<h2><span class="label label-danger">Tạo dự án mới</span></h2><br><br>
<form method="post">
	<div class="create-project">
		<div class="alert alert-warning" role="alert"><h3><span class="label label-success">Tên dự án:</span></h3>
			<input type="text" name="name" class="form-control" placeholder="Nhập tên dự án">
		</div>
		<div class="alert alert-warning" role="alert"><h3><span class="label label-success">Yêu cầu của dự án:</span></h3>
			<textarea type="text" name="description" class="form-control" rows="5" placeholder="Nhập yêu cầu của dự án"></textarea>
		</div>
		<div class="alert alert-warning" role="alert"><h3><span class="label label-success">Thời gian: <font size="2px" style="font-style:italic;">(ngày/tháng/năm)</font><br></span></h3>
			<br><div class="row">
				<div class="col-xs-8 col-sm-6">
					<h4><span class="label label-info">Thời gian bắt đầu:</span></h4>
					<input id="startdate" name="startdate" type="date" class="form-control" style="width:40%"> 
				</div>
				<div class="col-xs-8 col-sm-6">
					<h4><span class="label label-info">Thời gian kết thúc:</span></h4>
					<input id="enddate" name="enddate" type="date" class="form-control" style="width:40%"> 
				</div>
			</div>
		</div>
		<button type="submit" name="createProject" class="btn btn-danger">Xác nhận</button>
	</div>
</form>