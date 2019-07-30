<?php include 'header.php' ?>

<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumbs-menu">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#" class="active">cart</a></li>
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
					<h2>Giỏ hàng</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- entry-header-area-end -->
<!-- cart-main-area-start -->
<div class="cart-main-area mb-70" id="cart">
	<div class="container">
		<form action="xuli-cart.php" id="update">
			<input name="action" class="btn btn-primary" type="hidden" value="update">
			<div class="row">
				<div class="col-lg-12">
					<div class="table-content table-responsive">
						<table>
							<thead>
								<tr>
									<th class="product-thumbnail">Hình ảnh</th>
									<th class="product-name">Tên sản phẩm</th>
									<th class="product-price">Giá</th>
									<th class="product-quantity">Số lượng</th>
									<th class="product-subtotal">Tổng giá</th>
									<th class="product-remove">Xóa</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (isset($_SESSION['cart'])) { ?>
									<?php foreach ($_SESSION['cart'] as $key => $value) { ?>
										<tr>
											<input name="id_up[]" type="hidden" value="<?php echo $key; ?>">
											<td class="product-thumbnail"><a href="#"><img src="admin/public/image/product/<?php echo $value['image']; ?>" alt="man" /></a></td>
											<td class="product-name"><a href="#"><?php echo $value['name']; ?></a></td>
											<td class="product-price"><span class="amount price"><?php echo $value['price']; ?></span></td>
											<td class="product-quantity"><input type="number" name="qtt_up[]" value="<?php echo $value['quantity']; ?>"></td>
											<td class="product-subtotal price"><?php echo $value['total_price']; ?></td>
											<td class="product-remove"><a href="xuli-cart.php?action=remove&id=<?php echo $key; ?>"><i class="fa fa-times"></i></a></td>
										</tr>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
					<div class="buttons-cart mb-30">
						<ul>
							<li><a href="javascript:{}" onclick="document.getElementById('update').submit();">Cập nhật giỏ hàng</a></li>
							<li><a href="category.php">Tiếp tục mua sắm</a></li>
						</ul>
					</div>
		</form>
		<!-- <div class="coupon">
			<h3>Mã phiếu giảm giá</h3>
			<p>Nhập mã phiếu giảm giá nếu có.</p>
			<form action="cart.php" method="GET">
				<input type="text" placeholder="Coupon code" name="coupon">
				<a href="">Nhập</a>
			</form>
		</div> -->
	</div>
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="cart_totals">
			<h2>Tạm tính</h2>
			<table>
				<tbody>
					<!-- <tr class="cart-subtotal">
						<th>Tổng cộng</th>
						<td>
							<span class="amount price"><?php echo isset($_SESSION['total_cart']) ? $_SESSION['total_cart'] : 0; ?></span>
						</td>
					</tr> -->
					<tr class="cart-subtotal">
						<?php
						$payment = 0;
						$code = 0;
						(isset($_GET['payment'])) ? $payment = $_GET['payment'] : $payment;
						(isset($_GET['code'])) ? $code = $_GET['code'] : $code;
						?>
						<!-- <th>Phiếu giảm giá</th> -->
						<!-- <td>
							<?php if ($code > 0) { ?>
								<span class="amount price"><?php echo $code; ?></span>
							<?php } else { ?>
								<span class="amount "><?php echo "Không"; ?></span>
							<?php } ?>
						</td> -->
					</tr>
					<!-- <tr class="shipping">
						<th>Phí giao hàng</th>
						<td>
							<ul id="shipping_method">
								<li>
									<input type="radio">
									<label>
										Flat Rate:
										<span class="amount">£7.00</span>
									</label>
								</li>
								<li>
									<input type="radio">
									<label> Free Shipping </label>
								</li>
							</ul>
							<a href="#">Calculate Shipping</a>
						</td>
					</tr> -->
					<tr class="order-total">
						<th>Tổng đơn hàng</th>
						<td>
							<strong>
								<span class="amount price"><?php echo isset($_SESSION['total_cart']) ? $_SESSION['total_cart'] + $code : 0; ?></span>
							</strong>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="wc-proceed-to-checkout">
				<a href="checkout.php">Thanh toán</a>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!-- cart-main-area-end -->
<?php include 'footer.php' ?>