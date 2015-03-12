<?php
	if(checkAuthenticated()){
?>	
		<div class="panel">
			<fieldset class="row">
				<form role="form" method="get">
					<div class="col-md-9">
						<label for="key" class="sr-only">Từ khóa</label>
						<input type="text" id="key" name="key" class="form-control input-sm" placeholder="Nhập từ khóa" required="">
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button><br>
					</div>
				</form>			
			</fieldset>	  
		</div>
<?php
	}
?>