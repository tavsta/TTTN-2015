            <?php
				echo '
					<div class="row">
						<div class="col-md-8"></div>';
				if($authenticated){				
					echo '
						<div class="col-md-2">Hello, '.getAccountDetailFromCookie()["USER"].'</div>
					';
				}else{
					echo '
							<div class="col-md-2">
								<a href="./?p=signin" class="btn btn-default">Đăng nhập</a>
							</div>
							<div class="col-md-2">
								<a href="./?p=signup" class="btn btn-default">Đăng ký</a>
							</div>';
				}
				echo '
					</div>';
			?>
			
			<div class="bar nav">
                <div class="nav-outer">
                    <ul class="hmenu">
            		    <li>
            		  	    <a href="http://localhost:81/tttnphp/" class="active">Trang Chủ</a>
            		    </li>	
            		    <li>
            		  	    <a href="#">Quản lý</a>
                			<ul>
                				<li>
                                    <a href="#">Quản lý Nhân sự</a>
                                </li>
                				<li>
                                    <a href="#">Quản lý Trang thiết bị</a>

                                </li>
                				<li>
                                    <a href="#">Quản lý các dự án</a>
                                    <ul>
                                        <li>
                                            <a href="#">Phân chia các phân hệ</a>
                                        </li>
                                        <li>
                                            <a href="#">Phân công công việc</a>
                                        </li>
                                        <li>
                                            <a href="#">Tiến độ thực hiện</a>
                                        </li>
                                        <li>
                                            <a href="#">Đánh giá kết quả</a>
                                        </li>
                                    </ul>
                                </li>
                			</ul>
            	        </li>	
                		<li>
                			<a href="#">Giới thiệu</a>
                		</li>
                        <li>
                            <a href="#">Thành viên</a>
                            <ul>
                                <li>
                                    <a href="http://localhost:81/tttnphp/?p=signup">Đăng ký</a>
                                </li>
                                <li>
                                    <a href="http://localhost:81/tttnphp/?p=signin">Đăng nhập</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="header">
                <div class="logo">
                    <h1 class="logo-name"><a href="#">WebSite Quản lý dự án phần mềm</a></h1>
                    <h2 class="logo-text">Khoa Khoa học &amp; Kỹ thuật Máy tính</h2>
                    <h2 class="logo-text">Trường Đại học Bách khoa Tp.Hồ Chí Minh</h2>
                </div>
            </div>