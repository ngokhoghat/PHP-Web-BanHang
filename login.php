<?php include 'header.php' ?>

<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="breadcrumbs-menu">
							<ul>
								<li><a href="#">Home</a></li>
								<li><a href="#" class="active">login</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- breadcrumbs-area-end -->
		<!-- user-login-area-start -->
		<div class="user-login-area mb-70">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="login-title text-center mb-30">
							<h2>Đăng Nhập</h2>
						</div>
					</div>
					<div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
						<div class="login-form">
							<?php if (isset($_SESSION['customer'])) { ?>
								<div class="text-success text-center" style="padding-bottom: 15px; font-size: 20px;">
									<p>Đăng nhập thành công!</p>
									<a href="index.php">Bắt đầu mua sắm thôi ^^!</a>
								</div>
							<?php }else{ ?>
								<form action="xuli-account.php" method="POST" role="form">
									<input type="hidden" name="action" value="login">
									<div class="single-login">
										<label>Email/ Số điện thoại<span style="color: red; font-size:20px; padding-left: 5px;">*</span></label>
										<input type="text" class="" placeholder="Nhập Email hoặc Số điện thoại..." name="u_name">
									</div>
									<div class="single-login">
										<label>Mật khẩu <span style="color: red; font-size:20px; padding-left: 5px;">*</span></label>
										<input type="password" class="" placeholder="Nhập mật khẩu từ 6 đến 32 ký tự..." name="u_pass">
									</div>
									<div class="text-danger text-center" style="padding-bottom: 15px;"><?php echo isset($_SESSION['error'])? $_SESSION['error'] : ''?></div>
									<div class="single-login single-login-2">
										<a style="background: #f07c29;" onclick=(k.click())><button id="k"  type="submit" class="btn" style="background: none;">Đăng nhập</button></a>
										<input id="rememberme" type="checkbox" name="rememberme" value="forever">
										<span>Remember me</span>
									</div>
									<a href="#">quên mật khẩu ?</a>
								</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- user-login-area-end -->
<?php include 'footer.php' ?>