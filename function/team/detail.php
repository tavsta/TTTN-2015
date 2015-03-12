<div class="list-user-team">
	<h2><span class="label label-success">Quản lý thành viên nhóm</span></h2>
	<div class="panel panel-warning">
		<div class="panel-heading">Danh sách thành viên nhóm:</div>
	</div>
	<table class="table">
		<tr>
			<th>STT</th>
			<th>Họ và tên</th>
			<th>Ngày tham gia</th>
			<th>Đang làm tại Project</th>
			<th>Hành động</th>
		</tr>
		<tr>
			<td>1</td>
			<td><input type="text" class="form-control" name="firstname" value="firstname" readonly="readonly">
				<input type="text"class="form-control" name="lastname" value="lastname" readonly="readonly"></td>
			<td><input type="date" class="form-control" name="joineddate" readonly="readonly"></td>
			<td><input type="text" class="form-control" name="name" value="name-project" readonly="readonly"></td>
			<td><button type="button" class="btn btn-warning">Xem</button>
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">
				  Sửa
				</button>

				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title" id="myModalLabel">Thành viên nhóm:</h4>
				      </div>
				      <div class="modal-body">
				        <table class="table">
							<tr>
								<th>STT</th>
								<th>Họ và tên</th>
								<th>Ngày tham gia</th>
								<th>Đang làm tại Project</th>
								
							</tr>
							<tr>
								<td>1</td>
								<td><input type="text" class="form-control" name="firstname" value="firstname" readonly="readonly">
									<input type="text"class="form-control" name="lastname" value="lastname" readonly="readonly"></td>
								<td><input type="date" class="form-control" name="joineddate" readonly="readonly"></td>
								<td><input type="text" class="form-control" name="name" placeholder="Chỉnh sửa project"></td>
							</tr>
						</table>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				        <button type="button" class="btn btn-primary">Thay đổi</button>
				      </div>
				    </div>
				  </div>
				</div>
				<button type="button" class="btn btn-warning">Xóa</button></td>
		</tr>

	</table>
	<a href="?action=create&cat=team"><button type="button" class="btn btn-danger">Thêm thành viên mới</button></a>
	<button type="button" class="btn btn-danger">Xác nhận</button>
</div>