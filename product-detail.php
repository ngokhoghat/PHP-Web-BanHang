<?php include 'header.php' ?>
<?php

if (isset($_GET['id'])) {

	$id = $_GET['id'];

	// $sql = "SELECT * FROM product WHERE id = $id";
	$sql = "SELECT p.id, p.name, p.price, p.sale_price, p.mota, p.anh_bia, p.anh_phu, p.created,p.cate_id, p.updated,p.view, p.quantity, p.lang, c.name AS 'cate_name', p.tacgia_id, p.nxb_id  
	FROM product p
	INNER JOIN category c ON p.cate_id = c.id
	WHERE p.id =  $id";
	$product = execute($sql)->fetch_assoc();

	if ($product["anh_phu"] != "") {
		$anhphu = json_decode($product['anh_phu']);
	} else {
		$anhphu = [];
	}
} else {
	echo 'Không tồn tại';
}

?>
<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumbs-menu">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#" class="active">product-details</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumbs-area-end -->
<!-- product-main-area-start -->
<div class="product-main-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				<!-- product-main-area-start -->
				<div class="product-main-area" id="detail_pro">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
							<div class="flexslider">
								<ul class="slides">
									<li data-thumb="<?php echo 'admin/public/image/product/';
													echo $product['anh_bia']; ?>">
										<img src="<?php echo 'admin/public/image/product/';
													echo $product['anh_bia']; ?>" />
									</li>
									<?php foreach ($anhphu as $key => $value) : ?>
										<li data-thumb="<?php echo 'admin/public/image/product/';
														echo $value; ?>">
											<img src="<?php echo 'admin/public/image/product/';
														echo $value; ?>" />
										</li>
									<?php endforeach ?>
								</ul>
							</div>
						</div>
						<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
							<div class="product-info-main">
								<div class="page-title">
									<h1><?php echo $product["name"]; ?></h1>
								</div>
								<div class="product-info-stock-sku">
									<p>Danh mục: <?php echo $product["cate_name"] ?></p>
									<p>Số lượng: <?php echo $product["quantity"] ?></p>
									<p>Lượi xem: <span class="view"><?php echo $product["view"] ?></span></p>
								</div>
								<div class="product-info-price">
									<div class="price-final">
										<?php if ($product['sale_price'] > 0) { ?>
											<span class="price"><?php echo $product["sale_price"]; ?></span>
											<span class="old-price price"><?php echo $product["price"]; ?></span>
										<?php } else { ?>
											<span class="price"><?php echo $product["price"]; ?></span>
										<?php } ?>
									</div>
								</div>
								<div class="product-reviews-summary">
									<div class="rating-summary">
										<a href="#"><i class="fa fa-star"></i></a>
										<a href="#"><i class="fa fa-star"></i></a>
										<a href="#"><i class="fa fa-star"></i></a>
										<a href="#"><i class="fa fa-star"></i></a>
										<a href="#"><i class="fa fa-star"></i></a>
									</div>
									<div class="reviews-actions">
										<a href="#">3 Reviews</a>
										<a href="#" class="view">Add Your Review</a>
									</div>
								</div>
								<div class="product-add-form">
									<form action="xuli-cart.php">
										<div class="quality-button">
											<input class="qty" type="hidden" value="<?php echo $product["id"]; ?>" name="id">
											<input class="qty" type="hidden" value="add" name="action">
											<input class="qty" type="number" value="1" name="quantity">
										</div>
										<a style="cursor: pointer;" onclick="btn.click()">Add to cart</a>
										<button type="submit" name="" id="btn" style="display:none"></button>

									</form>
								</div>
								<div class="product-social-links">
									<div class="product-addto-links">
										<a href="#"><i class="fa fa-heart"></i></a>
										<a href="#"><i class="fa fa-pie-chart"></i></a>
										<a href="#"><i class="fa fa-envelope-o"></i></a>
									</div>
									<div class="product-addto-links-text">
										<p><?php echo $product["mota"]; ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- product-main-area-end -->
				<!-- new-book-area-start -->
				<div class="new-book-area mt-60">
					<div class="section-title text-center mb-30">
						<h3>Sản phẩm mới</h3>
					</div>
					<div class="tab-active-2 owl-carousel">
						<?php
						$new_pro = execute("SELECT * FROM product WHERE status = 2");

						foreach ($new_pro as $key => $value) {
							$sale = 100 - $value['sale_price'] / $value['price'] * 100;
							?>
							<div class="tab-total">
								<!-- single-product-start -->
								<div class="product-wrapper">
									<div class="product-img">
										<a href="product-detail.php?id=<?php echo $value['id']; ?>">
											<img src="admin/public/image/product/<?php echo $value['anh_bia']; ?>" alt="book" class="primary" />
										</a>
										<div class="quick-view">
											<a class="action-view" href="#" data-target="#productModal" data-toggle="modal" title="Quick View">
												<i class="fa fa-search-plus"></i>
											</a>
										</div>
										<div class="product-flag">
											<ul>
												<li><span class="sale">new</span></li>
												<?php if ($value['sale_price'] > 0) { ?>
													<li><span class="discount-percentage">-<?php echo $sale; ?>%</span></li>
												<?php } ?>
											</ul>
										</div>
									</div>
									<div class="product-details text-center">
										<div class="product-rating">
											<ul>
												<li><a href="#"><i class="fa fa-star"></i></a></li>
												<li><a href="#"><i class="fa fa-star"></i></a></li>
												<li><a href="#"><i class="fa fa-star"></i></a></li>
												<li><a href="#"><i class="fa fa-star"></i></a></li>
												<li><a href="#"><i class="fa fa-star"></i></a></li>
											</ul>
										</div>
										<h4><a href="#"><?php echo $value['name']; ?></a></h4>
										<div class="product-price">
											<ul>
												<?php if ($value['sale_price'] > 0) { ?>
													<li class="price"><?php echo $value['sale_price']; ?></li>
													<li class="price old-price"><?php echo $value['price']; ?></li>
												<?php } else { ?>
													<li class="price"><?php echo $value['price']; ?></li>
												<?php } ?>
											</ul>
										</div>
									</div>
									<div class="product-link">
										<div class="product-button">
											<a href="xuli-cart.php?action=add&id=<?php echo $value['id']; ?>" title="Add to cart"><i class="fa fa-shopping-cart"></i>Add to
												cart</a>
										</div>
										<div class="add-to-link">
											<ul>
												<li><a href="product-detail.php?id=<?php echo $value['id']; ?>" title="Details"><i class="fa fa-external-link"></i></a></li>
											</ul>
										</div>
									</div>
								</div>
								<!-- single-product-end -->

							</div>
						<?php } ?>
					</div>
				</div>
				<!-- new-book-area-start -->
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<div class="shop-left" id="shop-left">
					<div class="left-title mb-20">
						<h4>Sản phẩm liên quan</h4>
					</div>
					<div class="random-area mb-30">
						<div class="product-active-2 owl-carousel">
							<?php
							$limit = 3;
							for ($i = 0; $i < $limit; $i++) {
								$cate = $product['cate_id'];
								$start =  $i * $limit;
								$random_pro3 = execute("SELECT p.*,c.name as 'cate_name' FROM product p,category c WHERE p.cate_id = c.id and c.id = $cate LIMIT $start,$limit")->fetch_all(MYSQLI_ASSOC);

								?>
								<div class="product-total-2">
									<?php foreach ($random_pro3 as $value) { ?>
										<div class="single-most-product bd mb-18">
											<div class="most-product-img">
												<a href="product-detail.php?id=<?php echo $value['id'] ?>"><img src="admin/public/image/product/<?php echo $value['anh_bia'] ?>" alt="book" /></a>
											</div>
											<div class="most-product-content">
												<h4><a href="product-detail.php?id=<?php echo $value['id'] ?>"><?php echo $value['name'] ?></a></h4>
												<div class="product-price">
													<ul>
														<?php if ($value['sale_price'] > 0) { ?>
															<li class="price"><?php echo $value['sale_price']; ?></li>
															<li class="price old-price"><?php echo $value['price']; ?></li>
														<?php } else { ?>
															<li class="price"><?php echo $value['price']; ?></li>
														<?php } ?>
													</ul>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="banner-area mb-30">
						<div class="banner-img-2">
							<a href="#"><img src="admin/public/image/banner/<?php echo $banner[5]['img_link'] ?>" alt="banner" /></a>
							<?php unset($banner[5]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- product-main-area-end -->


<?php include 'footer.php' ?>