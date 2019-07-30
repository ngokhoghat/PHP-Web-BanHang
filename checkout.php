<?php include 'header.php' ?>

<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumbs-menu">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#" class="active">checkout</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumbs-area-end -->
<!-- entry-header-area-start -->
<div class="entry-header-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="entry-header-title">
					<h2>Thanh toán</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- entry-header-area-end -->
<!-- coupon-area-area-start -->
<div class="coupon-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="coupon-accordion">
					<?php if (!isset($_SESSION['customer'])) { ?>
						<h3>Đã có tài khoản? <span id="showlogin">Click here to login</span></h3>
						<div class="coupon-content" id="checkout-login">
							<div class="coupon-info">
								<p class="coupon-text">Sử dụng tài khoản để nhận được nhiều ưu đãi nhất!</p>
								<form action="xuli-account.php">
									<p class="form-row-first">
										<label>Tên đăng nhập hoặc email <span class="required">*</span></label>
										<input type="text">
									</p>
									<p class="form-row-last">
										<label>Mật khẩu <span class="required">*</span></label>
										<input type="text">
									</p>
									<p class="form-row">
										<input type="submit" value="Login">
										<label>
											<input type="checkbox">
											Remember me
										</label>
									</p>
									<p class="lost-password">
										<a href="#">quên mật khẩu ?</a>
									</p>
								</form>
							</div>
						</div>
					<?php } ?>
					<h3>Có mã giảm giá? <span id="showcoupon">Click here to enter your code</span></h3>
					<div class="coupon-checkout-content" id="checkout_coupon">
						<div class="coupon-info">
							<form action="#">
								<p class="checkout-coupon">
									<input type="text" placeholder="Coupon code">
									<input type="submit" value="Apply Coupon">
								</p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- coupon-area-area-end -->
<!-- checkout-area-start -->
<div class="checkout-area mb-70">
	<div class="container">
		<div class="row">
			<?php
			if (isset($_SESSION['cart'])) {
				if (!empty($_POST)) {
					$error = [];
					if (!empty($_POST['cus_name'])) {
						$name = $_POST['cus_name'];
					} else {
						$error['name'] = "Không được để rỗng";
					}
					if (!empty($_POST['cus_email'])) {
						$email = $_POST['cus_email'];
					} else {
						$error['email'] = "Không được để rỗng";
					}
					if (!empty($_POST['cus_birthday'])) {
						$birthday = $_POST['cus_birthday'];
					} else {
						$error['birthday'] = "Không được để rỗng";
					}
					if (!empty($_POST['cus_phone'])) {
						$phone = $_POST['cus_phone'];
					} else {
						$error['phone'] = "Không được để rỗng";
					}
					if (!empty($_POST['cus_address'])) {
						$address = $_POST['cus_address'];
					} else {
						$error['address'] = "Không được để rỗng";
					}

					$re_name = $_POST['cuss_name'];
					$re_phone = $_POST['cuss_phone'];
					$re_address = $_POST['cuss_address'];
					$re_city = $_POST['cuss_city'];

					if (empty($error)) {
						if (!isset($_SESSION['customer'])) {
							if (!empty($_POST['cus_pass'])) {
								$pass = md5($_POST['cus_pass']);
								$sql = " INSERT INTO account (name, email, phone, password, address, birthday, type)
											VALUES ('$name', '$email', '$phone', '$pass', '$address', '$birthday', 0)";
							} else {
								$sql = " INSERT INTO account (name, email, phone, address, birthday, type)
										VALUES ('$name', '$email', '$phone', '$address', '$birthday', 0)";
							}
							$account = execute($sql);
							if ($account == 1) {
								$cus_id = execute("SELECT id FROM account WHERE email = '$email'")->fetch_assoc()['id'];
							} else {
								$error['email'] = "Email đã tồn tại";
							}
						} else {
							$cus_id = $_SESSION['customer']['id'];
						}

						if (!empty($re_name)) {
							$bname = $re_name;
						} else {
							$bname = $name;
						}
						if (!empty($re_phone)) {
							$bphone = $re_phone;
						} else {
							$bphone = $phone;
						}
						if (!empty($re_address)) {
							$baddress = $re_address;
						} else {
							$baddress = $address;
						}
						$result = execute("INSERT INTO orders (acc_id, name, phone, address, status)
											VALUES ($cus_id, '$bname', '$bphone', '$baddress','0')");
						if ($result == 1) {
							// Thêm giỏ hàng vảo order detail
							$order_id = $conn->insert_id;
							foreach ($_SESSION['cart'] as $key => $value) {
								$pro_id = $value['id'];
								$pro_quantity = $value['quantity'];
								$pro_price = $value['price'];
								execute("INSERT INTO orders_detail (orders_id, prod_id, quantity, price) VALUES ($order_id, $pro_id, $pro_quantity, $pro_price)");
							}
							// Gửi mail
							require "config/mail_checkout.php";
							$title = "Đặt hàng thành công";
							send_mail($email, $body, $title);

							//Xóa giỏ hàng
							unset($_SESSION['cart']);
							unset($_SESSION['total_cart']);
							header("Location: checkout.php?checked");
						}
					}
				}
				?>
				<form action="" method="POST">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="checkbox-form">
							<h3>Thông tin khách hàng</h3>
							<?php if (isset($_SESSION['customer'])) { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
										<div class="checkout-form-list">
											<label>Họ Tên <span class="required">*</span></label>
											<input type="text" placeholder="" name="cus_name" value="<?php echo $_SESSION['customer']['name'] ?>">
											<label><span class="required"><?php echo isset($error['name']) ? $error['name'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="checkout-form-list">
											<label>Ngày sinh <span class="required">*</span></label>
											<input type="date" placeholder="" name="cus_birthday" value="<?php echo $_SESSION['customer']['birthday'] ?>">
											<label><span class="required"><?php echo isset($error['birthday']) ? $error['birthday'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="checkout-form-list">
											<label>Số điện thoại <span class="required">*</span></label>
											<input type="" placeholder="" name="cus_phone" value="<?php echo $_SESSION['customer']['phone'] ?>">
											<label><span class="required"><?php echo isset($error['phone']) ? $error['phone'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="checkout-form-list">
											<label>Email Address <span class="required">*</span></label>
											<input type="email" placeholder="" name="cus_email" value="<?php echo $_SESSION['customer']['email'] ?>">
											<label><span class="required"><?php echo isset($error['email']) ? $error['email'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="checkout-form-list">
											<label>Địa chỉ <span class="required">*</span></label>
											<input type="text" placeholder="" name="cus_address" value="<?php echo $_SESSION['customer']['address'] ?>">
											<label><span class="required"><?php echo isset($error['address']) ? $error['address'] : "" ?></span></label>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
										<div class="checkout-form-list">
											<label>Họ Tên <span class="required">*</span></label>
											<input type="text" placeholder="" name="cus_name">
											<label><span class="required"><?php echo isset($error['name']) ? $error['name'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="checkout-form-list">
											<label>Ngày sinh <span class="required">*</span></label>
											<input type="date" placeholder="" name="cus_birthday">
											<label><span class="required"><?php echo isset($error['birthday']) ? $error['birthday'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="checkout-form-list">
											<label>Số điện thoại <span class="required">*</span></label>
											<input type="" placeholder="" name="cus_phone">
											<label><span class="required"><?php echo isset($error['phone']) ? $error['phone'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="checkout-form-list">
											<label>Email Address <span class="required">*</span></label>
											<input type="email" placeholder="" name="cus_email">
											<label><span class="required"><?php echo isset($error['email']) ? $error['email'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="checkout-form-list">
											<label>Địa chỉ <span class="required">*</span></label>
											<input type="text" placeholder="" name="cus_address">
											<label><span class="required"><?php echo isset($error['address']) ? $error['address'] : "" ?></span></label>
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="ship-different-title">
											<label for="cbox">Bạn có muốn tạo tài khoản không?</label>
											<input type="checkbox" id="cbox">
										</div>
										<div class="checkout-form-list create-account" id="cbox_info" style="display: none;">
											<p>Tạo tài khoản bằng cách nhập thông tin bên trên. Nếu bạn đã có tài khoản vùi lòng đăng nhập ở đầu trang.</p>
											<label>Nhập mật khẩu <span class="required">*</span></label>
											<input type="password" placeholder="password" name="cus_pass">
										</div>
									</div>
								</div>
							<?php } ?>
							<div class="different-address">
								<div class="ship-different-title">
									<h3>
										<label for="ship-box">Ship đến địa chỉ khác ?</label>
										<input type="checkbox" id="ship-box">
									</h3>
								</div>
								<div class="row" id="ship-box-info" style="display: none;">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
										<div class="checkout-form-list">
											<label>Họ Tên Người Nhận <span class="required">*</span></label>
											<input type="text" placeholder="" name="cuss_name">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="checkout-form-list">
											<label>Số điện thoại <span class="required">*</span></label>
											<input type="" placeholder="" name="cuss_phone">
										</div>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="checkout-form-list">
											<label>Địa chỉ người nhận <span class="required">*</span></label>
											<input type="text" placeholder="" name="cuss_address">
										</div>
									</div>
								</div>
								<div class="order-notes">
									<div class="checkout-form-list">
										<label>Yêu cầu khách hàng</label>
										<textarea placeholder="" name="cus_repuire" rows="10" cols="30" id="checkout-mess"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="your-order" id="order">
							<h3>Hóa đơn của bạn</h3>
							<div class="your-order-table table-responsive">
								<table>
									<thead>
										<tr>
											<th class="product-name">Sản phẩm</th>
											<th class="product-total">Tổng tiền</th>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($_SESSION['cart'])) { ?>
											<?php foreach ($_SESSION['cart'] as $key => $value) { ?>
												<tr class="cart_item">
													<td class="product-name">
														<?php echo $value['name']; ?> <strong class="product-quantity"> × <?php echo $value['quantity']; ?></strong>
													</td>
													<td class="product-total">
														<span class="amount price"><?php echo $value['quantity'] * $value['price'] ?></span>
													</td>
												</tr>
											<?php } ?>
										<?php } ?>
									</tbody>
									<tfoot>
										<!-- <tr class="cart-subtotal">
											<th>Tổng tiền giỏ hàng</th>
											<td><span class="amount price"><?php echo $_SESSION['total_cart'] ?></span></td>
										</tr> -->
										<!-- <tr class="shipping">
											<th>Phí giao hàng</th>
											<td>
												<ul>
													<li>
														<input type="radio">
														<label>
															Flat Rate: <span class="amount price">3000</span>
														</label>
													</li>
													<li>
														<input type="radio">
														<label>Free Shipping:</label>
													</li>
													<li></li>
												</ul>
											</td>
										</tr> -->
										<tr class="order-total">
											<th>Tổng tiền hóa đơn</th>
											<td><strong><span class="amount price"><?php echo $_SESSION['total_cart'] ?></span></strong>
											</td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="payment-method">
								<!-- <div class="payment-accordion">
									<div class="collapses-group">
										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
											<div class="panel panel-default">
												<div class="panel-heading" role="tab" id="headingOne">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
															Direct Bank Transfer
														</a>
													</h4>
												</div>
												<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
													<div class="panel-body">
														<p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading" role="tab" id="headingTwo">
													<h4 class="panel-title">
														<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
															Cheque Payment
														</a>
													</h4>
												</div>
												<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
													<div class="panel-body">
														<p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading" role="tab" id="headingThree">
													<h4 class="panel-title">
														<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
															PayPal <img src="img/2.png" alt="payment" />
														</a>
													</h4>
												</div>
												<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
													<div class="panel-body">
														<p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div> -->
								<div class="order-button-payment">
									<input type="submit" value="Đặt hàng">
								</div>
							</div>
						</div>
					</div>
				</form>
			<?php } else { ?>
				<div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
					<div class="login-form">
						<?php if (isset($_GET['checked'])) { ?>
							<div class="text-success text-center" style="padding-bottom: 15px; font-size: 20px;">
								<p>Đặt hàng thành công !</p>
								<p>Vui lòng kiểm tra đơn hàng trong email.</p>
								<p><a href="account.php?rl=ckeckouthistory">--> Kiểm tra đơn hàng</a>.</p>
							</div>
						<?php } else { ?>
							<div class="text-success text-center" style="padding-bottom: 15px; font-size: 20px;">
								<p>Giỏ hàng rỗng, vui lòng đặt hàng !</p>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<!-- checkout-area-end -->
<?php include 'footer.php' ?>