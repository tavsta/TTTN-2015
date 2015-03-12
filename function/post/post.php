<br><h2><span class="label label-danger">Bài đăng:</span></h2><br><br>
<div class="post-new" style="width:95%; margin:0 auto;">
<div class="row">
	<div class="col-xs-12 col-md-1">
		<h3><span class="label label-success">Tiêu đề</span></h3>
	</div>
	<div class="col-xs-12 col-md-6">
		<input type="text" class="form-control" placeholder="Tiêu đề bài đăng">
	</div>
  	<div class="col-xs-6 col-md-5">
  		<h4><button type="button" class="label label-warning" style= "width:90px;" title="Đăng bài viết mới">Đăng bài</button>
  		<button type="button" class="label label-warning" style="width:90px;" title="Lưu bài đăng">Lưu</button>
  		<button type="button" class="label label-warning" style="width:90px;" title="Xem trước bài đăng">Xem trước</button>
  		<button type="button" class="label label-warning" style="width:90px;" title="Đóng">Đóng</button></h4>
  	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-1">
		<h3><span class="label label-success">Nội dung</span></h3>
	</div>
  	<div class="col-xs-6 col-md-8">
  		<textarea rows="30" id="content" cols="132"></textarea>
  	</div>
	<script src="/tttn/ckeditor/ckeditor.js"></script>
	<script>
		CKEDITOR.replace( 'content' );
	</script>
  	<div class="col-xs-12 col-md-3">
		<div class="alert alert-info" role="alert">Cài đặt bài đăng</div>
	</div>
</div>
</div>
<br>
