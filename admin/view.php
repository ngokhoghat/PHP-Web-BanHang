<?php include "header.php" ?>
<!-- all css here -->
<link rel="stylesheet" href="../public/css/font-awesome.min.css">
<!-- flexslider.css-->
<link rel="stylesheet" href="../public/css/flexslider.css">
<!-- style css -->
<link rel="stylesheet" href="../public/style.css">
<!-- responsive css -->
<link rel="stylesheet" href="../public/css/responsive.css">
<!-- modernizr css -->
<?php
// Lấy hành động

if (isset($_GET['name'])) {
	$action = $_GET['name'];
} else {
	$action = "product";
}

?>
<?php if ($action == "order") { ?>
	<?php

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$sql = "SELECT dt.*, p.name,p.anh_bia FROM orders_detail dt
					JOIN product p ON p.id = dt.prod_id
					WHERE orders_id = $id";

		$orders = execute($sql)->fetch_all(MYSQLI_ASSOC);


		$sql1 = "SELECT o.*, a.email u_email, a.name u_name, a.phone u_phone FROM orders o
					JOIN account a ON a.id = o.acc_id
					WHERE o.id = $id";

		$total_order = execute("SELECT SUM(dt.quantity*dt.price) total FROM orders_detail dt WHERE dt.orders_id = $id")->fetch_assoc();
		// print_r($_POST);
		$orders_detail = execute($sql1)->fetch_assoc();

		if (isset($_POST['status'])) {
			$status = $_POST['status'];
			if ($status == "accept") {
				$result = execute("UPDATE orders SET status = 1 WHERE id = $id");
				if ($result == 1) {
					header("Location: " . $_SERVER["HTTP_REFERER"]);
				} else {
					echo $result;
				}
			}else if($status == "cancer") {
				$result = execute("UPDATE orders SET status = 2 WHERE id = $id");
				if ($result == 1) {
					header("Location: " . $_SERVER["HTTP_REFERER"]);
				} else {
					echo $result;
				}
			}else {
				$result = execute("UPDATE orders SET status = 3 WHERE id = $id");
				if ($result == 1) {
					header("Location: " . $_SERVER["HTTP_REFERER"]);
				} else {
					echo $result;
				}
			}
		}
	} else {
		echo 'Không tồn tại';
	}
	?>
	<!-- Begin Page Content -->
	<div class="container-fluid">
		<!-- Page Heading -->
		<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
			<a target="_blank" href="https://datatables.net/">official DataTables documentation</a>.
		</p>

		<!-- DataTales Example -->
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Thông tin đơn hàng</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
						<div class="row justify-content-md-center" id="view-order">
							<div class="col-sm-12 col-md-8">
								<h3>Hóa đơn</h3>
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<tr class="text-center">
												<th>Thông tin người mua</th>
												<th>Thông tin người nhận</th>
											</tr>
										</thead>
										<tbody id="price">
											<tr>
												<td>
													<p>Khách hàng: <?php echo $orders_detail['u_name'] ?></p>
													<p>Email: <?php echo $orders_detail['u_email'] ?></p>
													<p>Số điện thoại: <?php echo $orders_detail['u_phone'] ?></p>
												</td>
												<td>
													<p>Họ tên: <?php echo $orders_detail['name'] ?></p>
													<p>Số điện thoại: <?php echo $orders_detail['phone'] ?></p>
													<p>Địa chỉ: <?php echo $orders_detail['address'] ?></p>
												</td>
											</tr>
											<td>
												<p>Ngày đặt hàng: <?php echo $orders_detail['created'] ?></p>
											</td>
											<td>
												<p>Trạng thái:
													<?php if ($orders_detail['status'] == 0) { ?>
														<span class="badge badge-danger"><i class="fa fa-times"></i> Chờ duyệt</span>
														<form action="" method="POST">
															<div class="form-group">
																<button type="submit" name="status" value="accept" class="btn btn-sm btn-success"><i class="pr-1 fa fa-check"></i>Duyệt</button>
																<button type="submit" name="status" value="cancer" class="btn btn-sm btn-danger"><i class="pr-1 fa fa-times"></i>Hủy</button>
															</div>
														</form>
													<?php } else if ($orders_detail['status'] == 1) { ?>
														<span class="badge badge-success"><i class="fa fa-check"></i>  Đang giao hàng</span>
														<form action="" method="POST">
															<div class="form-group">
																<button type="submit" name="status" value="checked" class="btn btn-sm btn-info"><i class="pr-1 fa fa-check"></i>Đã giao hàng</button>
															</div>
														</form>
													<?php } else if ($orders_detail['status'] == 2) { ?>
														<span class="badge badge-secondary"><i class="fa fa-times"></i> Đã Hủy</span>
													<?php } else { ?>
														<span class="badge badge-info"><i class="fa fa-thumbs-up"></i> Đã giao hàng</span>
													<?php } ?>
												</p>
											</td>
										</tbody>
									</table>
								</div>
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<tr class="text-center">
												<th>STT</th>
												<th>Hình ảnh</th>
												<th>Tên sản phẩm</th>
												<th>Giá</th>
												<th>Số lượng</th>
												<th>Tổng tiền</th>
											</tr>
										</thead>
										<tbody id="price">
											<?php foreach ($orders as $key => $value) : ?>
												<tr class="text-center">
													<td><?php echo $key + 1; ?></td>
													<td><img src="public/image/product/<?php echo $value['anh_bia']; ?>" alt="" class="img-fluid" width="60"></td>
													<td><?php echo $value['name']; ?></td>
													<td class="price"><?php echo $value['price']; ?></td>
													<td><?php echo $value['quantity']; ?></td>
													<td class="price"><?php echo $value['quantity'] * $value['price']; ?></td>
												</tr>
											<?php endforeach ?>
											<tr>
												<td colspan="6">
													<h5>Tổng cộng: <span class="price font-weight-bold text-danger"><?php echo $total_order['total'] ?></span></h5>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
<?php } else if ($action == "product") { ?>
	<?php

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		// $sql = "SELECT * FROM product WHERE id = $id";
		$sql = "SELECT p.id, p.name, p.price, p.sale_price, p.mota, p.anh_bia, p.anh_phu, p.created, p.updated, p.quantity, p.lang, c.name AS 'cate_name', p.tacgia_id, p.nxb_id  
		FROM product p
		INNER JOIN category c ON p.cate_id = c.id
		WHERE p.id =  $id";
		$product = execute($sql)->fetch_assoc();

		if ($product["anh_phu"] != "") {
			$anhphu = json_decode($product['anh_phu']);
		}
	} else {
		echo 'Không tồn tại';
	}

	?>

	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-12">
			<!-- product-main-area-start -->
			<div class="product-main-area">
				<div class="row" id="view-product">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="flexslider">
							<ul class="slides">
								<li data-thumb="public/image/product/<?php echo $product['anh_bia']; ?>">
									<img src="public/image/product/<?php echo $product['anh_bia']; ?>" />
								</li>
								<?php if (isset($anhphu)) {
									foreach ($anhphu as $key => $value) : ?>
										<li data-thumb="public/image/product/<?php echo $value; ?>">
											<img src="public/image/product/<?php echo $value; ?>" />
										</li>
									<?php endforeach ?>
								<?php } ?>
							</ul>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" id="detail">
						<div class="product-info-main">
							<div class="page-title">
								<h1><?php echo $product["name"]; ?></h1>
							</div>
							<div class="product-info-stock-sku">
								<p>Danh mục: <?php echo $product["cate_name"] ?></p>
								<p>Số lượng: <?php echo $product["quantity"] ?></p>
								<p>Lượi xem: <span class="view"><?php echo $product["quantity"] ?></span></p>
							</div>
							<div class="product-info-price">
								<div class="price-final">
									<?php if ($product['sale_price'] > 0) { ?>
										<span class="price"><?php echo $product["sale_price"]; ?></span>
										<span class="price old-price"><?php echo $product["price"]; ?></span>
									<?php } else { ?>
										<span class="price"><?php echo $product["price"]; ?></span>
									<?php } ?>
								</div>
							</div>
							<div class="product-social-links">
								<div class="product-reviews-summary">
									<div class="page-title">
										<h1 style="font-size: 20px; margin: 0; padding: 0;">Đánh giá</h1>
										<div class="rating-summary">
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
											<a href="#"><i class="fa fa-star"></i></a>
										</div>
									</div>
								</div>
								<div class="page-title">
									<h1 style="font-size: 25px;">Giới thiệu</h1>
								</div>
								<div class="product-info-stock-sku">
									<p><?php echo $product["mota"] ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- product-main-area-end -->
		</div>
	</div>
<?php } else if ($action == "author") { ?>
	<?php

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		// $sql = "SELECT * FROM product WHERE id = $id";
		$sql = "SELECT * FROM tacgia WHERE id =  $id";
		$tacgia = execute($sql)->fetch_assoc();
	} else {
		echo 'Không tồn tại';
	}

	?>

	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-8 col-xs-12">
			<!-- product-main-area-start -->
			<div class="product-main-area">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
						<div class="flexslider">
							<ul class="slides">
								<li data-thumb="<?php echo 'public/image/author/';
												echo $tacgia['hinh_anh']; ?>">
									<img src="<?php echo 'public/image/author/';
												echo $tacgia['hinh_anh']; ?>" />
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12" id="detail">
						<div class="product-info-main">
							<div class="page-title">
								<h1><?php echo $tacgia["name"]; ?></h1>
							</div>
							<div class="product-info-stock-sku">
								<p>Phone: <?php echo $tacgia["phone"] ?></p>
								<p>Email: <?php echo $tacgia["email"] ?></p>
								<p>Address: <span class="view"><?php echo $tacgia["address"] ?></span></p>
							</div>
							<div class="product-social-links">
								<div class="page-title">
									<h1 style="font-size: 25px;">Tiểu sử</h1>
								</div>
								<div class="product-info-stock-sku">
									<p><?php echo $tacgia["tieu_su"] ?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- product-main-area-end -->

		</div>
	</div>




<?php } ?>



<?php include "footer.php" ?>
<script>
	$('#view-product .price').autoNumeric("init", {
		aSign: 'đ',
		pSign: 's',
		mDec: '0'
	});
</script>

<script src="../public/js/vendor/jquery-1.12.0.min.js"></script>
<!-- bootstrap js -->
<script src="../public/js/bootstrap.min.js"></script>
<!-- owl.carousel js -->
<script src="../public/js/owl.carousel.min.js"></script>
<!-- meanmenu js -->
<script src="../public/js/jquery.meanmenu.js"></script>
<!-- wow js -->
<script src="../public/js/wow.min.js"></script>
<!-- jquery.parallax-1.1.3.js -->
<script src="../public/js/jquery.parallax-1.1.3.js"></script>
<!-- jquery.countdown.min.js -->
<script src="../public/js/jquery.countdown.min.js"></script>
<!-- jquery.flexslider.js -->
<script src="../public/js/jquery.flexslider.js"></script>
<!-- chosen.jquery.min.js -->
<script src="../public/js/chosen.jquery.min.js"></script>
<!-- jquery.counterup.min.js -->
<script src="../public/js/jquery.counterup.min.js"></script>
<!-- waypoints.min.js -->
<script src="../public/js/waypoints.min.js"></script>
<!-- plugins js -->
<script src="../public/js/plugins.js"></script>
<!-- main js -->
<script src="../public/js/main.js"></script>