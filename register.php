<?php include 'header.php' ?>
<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumbs-menu">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#" class="active">register</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumbs-area-end -->
<!-- user-login-area-start -->
<?php
$Check = '';
if (isset($_GET['check'])) {
	$Check = "check";
} else if (isset($_GET['checked'])) {
	$Check = "checked";
} else {
	$Check = 'none';
}
?>
<div class="user-login-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="login-title text-center mb-30">
					<h2>Đăng kí</h2>
				</div>
			</div>
			<?php if ($Check == 'none') { ?>
				<?php
				if (!empty($_POST)) {
					$error = [];
					if (!empty($_POST['cus_name'])) {
						$name = $_POST['cus_name'];
					} else {
						$error['name'] = "không được để trên trống";
					}
					if (!empty($_POST['cus_birthday'])) {
						$birthday = $_POST['cus_birthday'];
					} else {
						$error['birthday'] = "không được để trên trống";
					}
					if (!empty($_POST['cus_phone'])) {
						$phone = $_POST['cus_phone'];
					} else {
						$error['phone'] = "không được để trên trống";
					}
					if (!empty($_POST['cus_email'])) {
						$email = $_POST['cus_email'];
					} else {
						$error['email'] = "không được để trên trống";
					}
					if (!empty($_POST['cus_pass'])) {
						$pass = md5($_POST['cus_pass']);
					} else {
						$error['pass'] = "không được để trên trống";
					}
					if (!empty($_POST['cus_repass'])) {
						$repass = md5($_POST['cus_repass']);
					} else {
						$error['repass'] = "không được để trên trống";
					}
					if (!empty($_POST['cus_address'])) {
						$address = $_POST['cus_address'];
					} else {
						$error['address'] = "không được để trên trống";
					}
					if (isset($pass) && isset($repass)) {
						if ($pass != $repass) {
							$error['repass'] = "Mật khẩu nhập lại không đúng";
						}
					}
					$sex = $_POST['cus_sex'];
					if (empty($error)) {
						$result = execute("SELECT id FROM account WHERE email = '$email'")->fetch_assoc();
						if ($result) {
							$error['mk_name'] = "Email đã được đăng kí";
						} else {
							// Gửi mail
							$very_code = time();
							require "config/mail_login.php";
							$title = "Đăng kí";
							$mail = send_mail($email, $body, $title);
							if ($mail == true) {
								$_SESSION['cus_registe'] = [
									'name' => $name,
									'phone' => $phone,
									'pass' => $repass,
									'address' => $address,
									'sex' => $sex,
									'birthday' => $birthday,
									'email' => $email,
									'code' => $very_code,
								];
								header('location: register.php?check');
							} else {
								$error['mk_name'] = "Email này không đúng";
							}
						}
					}
				}
				?>
				<div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-6 col-sm-12 col-xs-12">
					<div class="login-form">
						<form action="" method="POST" role="form" id="form-register">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<div class="checkout-form-list">
										<label>Họ Tên <span class="required">*</span></label>
										<input type="text" placeholder="" name="cus_name">
										<label style="padding-top: 5px"><span class="required"><?php echo isset($error['name']) ? $error['name'] : '' ?></span></label>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="checkout-form-list">
										<label>Ngày sinh <span class="required">*</span></label>
										<input type="date" placeholder="" name="cus_birthday">
										<label style="padding-top: 5px"><span class="required"><?php echo isset($error['birthday']) ? $error['birthday'] : '' ?></span></label>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="checkout-form-list">
										<label>Giới tính <span class="required">*</span></label>
										<div class="form-group">
											<label for=""></label>
											<select class="form-control" name="cus_sex">
												<option value="0">Nam</option>
												<option value="1">Nữ</option>
												<option value="2">Khác</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="checkout-form-list">
										<label>Số điện thoại <span class="required">*</span></label>
										<input type="" placeholder="" name="cus_phone">
										<label style="padding-top: 5px"><span class="required"><?php echo isset($error['phone']) ? $error['phone'] : '' ?></span></label>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="checkout-form-list">
										<label>Email Address <span class="required">*</span></label>
										<input type="email" placeholder="" name="cus_email">
										<label style="padding-top: 5px"><span class="required"><?php echo isset($error['email']) ? $error['email'] : '' ?></span></label>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="checkout-form-list">
										<label>Mật khẩu <span class="required">*</span></label>
										<input type="password" placeholder="" name="cus_pass">
										<label style="padding-top: 5px"><span class="required"><?php echo isset($error['pass']) ? $error['pass'] : '' ?></span></label>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="checkout-form-list">
										<label>Nhập lại mật khẩu <span class="required">*</span></label>
										<input type="password" placeholder="" name="cus_repass">
										<label style="padding-top: 5px"><span class="required"><?php echo isset($error['repass']) ? $error['repass'] : '' ?></span></label>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="checkout-form-list">
										<label>Địa chỉ <span class="required">*</span></label>
										<input type="text" placeholder="" name="cus_address">
										<label style="padding-top: 5px"><span class="required"><?php echo isset($error['address']) ? $error['address'] : '' ?></span></label>
										<label class="text-center" style="padding-top: 5px"><span class="required"><?php echo isset($error['mk_name']) ? $error['mk_name'] : '' ?></span></label>
									</div>
								</div>
							</div>
							<div class="single-register single-register-3">
								<input id="rememberme" type="checkbox" name="rememberme" value="forever">
								<label class="inline">Tôi đồng ý với các điều khoản <a href="#">Terms & Condition</a></label>
							</div>
							<div class="single-login single-login-2">
								<a style="background: #f07c29;" href="javascript:{}" onclick="document.getElementById('form-register').submit();">Đăng kí</button></a>
							</div>
						</form>
					</div>
				</div>
			<?php } else if ($Check == "check") { ?>
				<div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
					<div class="login-form text-center">
						<p>Một mã xác nhận đã được gửi đến Email của bạn!</p>
						<p>Vui lòng truy cập <a href="https://mail.google.com"><?php echo isset($_SESSION['cus_registe']['email']) ? $_SESSION['cus_registe']['email'] : "" ?></a> để nhận mã xác nhận</p>
						<form action="xuli-account.php" id="form-checkcode">
							<div class="text-center" style="padding-bottom: 15px; font-size: 20px;">
								<p class="text-success">Nhập mã xác nhận</p>
								<input type="hidden" name="action" value="register">
								<input type="text" name="code_very">
								<label style="padding-top: 5px"><span class="required text-danger"><?php echo isset($_SESSION['error']['code_uncorect']) ? $_SESSION['error']['code_uncorect'] : '' ?></span></label>
							</div>
							<div class="single-login single-login-2">
							<a style="background: #f07c29;" href="javascript:{}" onclick="document.getElementById('form-checkcode').submit();">Xác nhận</button></a>
							</div>
						</form>
					</div>
				</div>
			<?php } else { ?>
				<div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
					<div class="login-form">
						<div class="text-success text-center" style="padding-bottom: 15px; font-size: 20px;">
							<p>Đăng kí thành công!</p>
							<p>Quay lại trang đăng nhập <a href="login.php">Đăng nhập</a></p>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>
	</div>
</div>
<!-- user-login-area-end -->
<?php include 'footer.php' ?>