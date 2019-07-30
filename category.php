<?php include 'header.php' ?>
<?php
// Get data category, tacgia, sanpham
$category = execute("SELECT * FROM  category WHERE parent_id = 0");
$tacgia = execute("SELECT * FROM  tacgia limit 0,4");

$search = '';
if (isset($_GET['search'])) {
	$search = $_GET['search'];
}
if (isset($_GET['cate_id'])) {
	$cate_id = $_GET['cate_id'];

	$sql = "SELECT p.*,c.name AS 'cate_name' FROM product p, category c 
			WHERE p.cate_id = c.id and p.cate_id IN (SELECT id FROM category WHERE parent_id = $cate_id OR id = $cate_id) and p.name like '%$search%'";
} elseif (isset($_GET['author_id'])) {
	$author_id = $_GET['author_id'];

	$sql = "SELECT * FROM product p
			WHERE p.tacgia_id = $author_id";
} else {
	$sql = "SELECT p.*,c.name AS 'cate_name', p.tacgia_id, p.nxb_id  
			FROM product p, category c 
			WHERE p.cate_id = c.id and p.name like '%$search%' ORDER BY id desc";
}


if (isset($_GET['name'])) {
	$name = $_GET['name'];
} else {
	$name = '';
}


if (isset($_GET["sotinmottrang"])) {
	$sotinmottrang = $_GET['sotinmottrang'];
} else {
	$sotinmottrang = 12;
}

if (isset($_GET['page'])) {
	$trang = $_GET["page"];
} else {
	$trang = 1;
}

$from = ($trang - 1) * $sotinmottrang;





$product = pagination($sql, $from, $sotinmottrang);

?>
<div class="breadcrumbs-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumbs-menu">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#" class="active">shop</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumbs-area-end -->
<!-- shop-main-area-start -->
<div class="shop-main-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<div class="shop-left">
					<div class="section-title-5 mb-30">
						<h2>Phụ lục</h2>
					</div>
					<div class="left-title mb-20">
						<h4>Danh mục</h4>
					</div>
					<div class="left-menu mb-30">
						<ul>
							<?php foreach ($category as $key => $value) { ?>
								<?php
								$cate_idd = $value['id'];
								$count = count(execute("SELECT p.id FROM product p, category c 
										WHERE p.cate_id = c.id and p.cate_id IN (SELECT id FROM category WHERE parent_id = $cate_idd OR id = $cate_idd)")->fetch_all(MYSQLI_ASSOC));
								?>
								<li><a href="category.php?cate_id=<?php echo $value['id']; ?>"><?php echo $value['name']; ?><span>(<?php echo $count; ?>)</span></a></li>
							<?php } ?>
						</ul>
					</div>
					<div class="left-title mb-20">
						<h4>Tác giả</h4>
					</div>
					<div class="left-menu mb-30">
						<ul>
							<?php foreach ($tacgia as $key => $value) { ?>
								<?php
								$author_id = $value['id'];
								$count = count(execute("SELECT p.id FROM product p, tacgia t
										WHERE p.tacgia_id = t.id and p.tacgia_id = $author_id")->fetch_all(MYSQLI_ASSOC));
								?>
								<li><a href="category.php?author_id=<?php echo $value['id']; ?>"><?php echo $value['name']; ?><span>(<?php echo $count; ?>)</span></a></li>
							<?php } ?>
						</ul>
					</div>
					<div class="left-title mb-20">
						<h4>Mua nhiều</h4>
					</div>
					<div class="random-area mb-30">
						<div class="product-active-2 owl-carousel">
							<?php
							$limit = 3;
							for ($i = 0; $i < $limit; $i++) {

								$start =  $i * $limit;
								$trending_pro = execute("SELECT * FROM product ORDER BY view DESC LIMIT $start,$limit")->fetch_all(MYSQLI_ASSOC);
								?>
								<div class="product-total-2">
									<?php foreach ($trending_pro as $value) { ?>
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
							<a href="#"><img src="admin/public/image/banner/<?php echo $banner[3]['img_link'] ?>" alt="banner" /></a>
							<?php unset($banner[3]); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				<div class="category-image mb-30">
					<a href="#"><img src="admin/public/image/banner/<?php echo $banner[4]['img_link'] ?>" alt="banner" /></a>
					<?php unset($banner[4]); ?>
				</div>
				<div class="section-title-5 mb-30">
					<h2><?php if (isset($cate_id)) {
							echo $product->fetch_assoc()['cate_name'];
						} else {
							echo 'Tất cả';
						} ?></h2>
				</div>
				<div class="toolbar mb-30">
					<div class="shop-tab">
						<div class="tab-3">
							<ul>
								<li class="active"><a href="#th" data-toggle="tab"><i class="fa fa-th-large"></i>Grid</a></li>
								<li><a href="#list" data-toggle="tab"><i class="fa fa-bars"></i>List</a></li>
							</ul>
						</div>
						<div class="list-page">
						</div>
					</div>
					<div class="field-limiter">
						<div class="control">
							<span>Show</span>
							<!-- chosen-start -->
							<select data-placeholder="Default Sorting" style="width:50px;" class="chosen-select" tabindex="1" onchange="(window.location.assign('category.php?name=<?php echo $name ?>&search_value=<?php echo $search ?>&page=<?php echo $trang ?>&sotinmottrang='+this.value))">
								<?php for ($i = 12; $i <= 20; $i += 4) { ?>
									<option value="<?php echo $i; ?>" <?php if ($sotinmottrang == $i) echo 'selected'; ?>><?php echo $i; ?></option>
								<?php } ?>
							</select>
							<!-- chosen-end -->
						</div>
					</div>
					<div class="toolbar-sorter">
						<span>Sort By</span>
						<select id="sorter" class="sorter-options" data-role="sorter">
							<option selected="selected" value="position"> Position </option>
							<option value="name"> Product Name </option>
							<option value="price"> Price </option>
						</select>
						<a href="#"><i class="fa fa-arrow-up"></i></a>
					</div>
				</div>
				<!-- tab-area-start -->
				<div class="tab-content">
					<div class="tab-pane active" id="th">
						<div class="row">
							<?php foreach ($product as $key => $value) {
								$sale = ceil(100 - $value['sale_price'] / $value['price'] * 100); ?>
								<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
									<!-- single-product-start -->
									<div class="product-wrapper mb-40" id="product">
										<div class="product-img">
											<a href="product-detail.php?id=<?php echo $value['id']; ?>">
												<img src="admin/public/image/product/<?php echo $value['anh_bia'] ?>" alt="book" class="primary" />
											</a>
											<div class="quick-view">
												<a class="action-view quickviews" href="#" data-target="#productModal" data-toggle="modal" title="Quick View" id="<?php echo $value['id']; ?>">
													<i class="fa fa-search-plus"></i>
												</a>
											</div>
											<div class="product-flag">
												<ul>
													<?php if ($value['status'] == 2) { ?>
														<li><span class="sale">new</span></li>
													<?php } ?>
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
											<h4><a href="product-detail.php?id=<?php echo $value['id']; ?>"><?php echo $value['name'] ?></a></h4>
											<div class="product-price">
												<ul>
													<li class="price"><?php if ($value['sale_price'] > 0) {
																			echo $value["sale_price"];
																		} ?></li>
													<li class="price <?php if ($value['sale_price'] > 0) {
																			echo 'old-price nb';
																		} ?>"><?php echo $value["price"] ?></li>
												</ul>
											</div>
										</div>
										<div class="product-link">
											<div class="product-button">
												<a href="xuli-cart.php?action=add&id=<?php echo $value['id']; ?>" title="Add to cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
											<div class="add-to-link">
												<ul>
													<li class='price'><a href="product-detail.php?id=<?php echo $value['id']; ?>" title="Details"><i class="fa fa-external-link"></i></a></li>
												</ul>
											</div>
										</div>
									</div>
									<!-- single-product-end -->
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade" id="list">
						<!-- single-shop-start -->
						<?php foreach ($product as $key => $value) { ?>
							<div class="single-shop mb-30">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										<div class="product-wrapper-2">
											<div class="product-img">
												<a href="product-detail.php?id=<?php echo $value['id']; ?>">
													<img src="admin/public/image/product/<?php echo $value['anh_bia'] ?>" alt="book" class="primary" />
												</a>
											</div>
										</div>
									</div>
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
										<div class="product-wrapper-content">
											<div class="product-details">
												<h4><a href="product-detail.php?id=<?php echo $value['id']; ?>"><?php echo $value['name'] ?></a></h4>
												<div class="product-rating">
													<ul>
														<li><a href="#"><i class="fa fa-star"></i></a></li>
														<li><a href="#"><i class="fa fa-star"></i></a></li>
														<li><a href="#"><i class="fa fa-star"></i></a></li>
														<li><a href="#"><i class="fa fa-star"></i></a></li>
														<li><a href="#"><i class="fa fa-star"></i></a></li>
													</ul>
												</div>
												<div class="product-price">
													<ul>
														<li class="price"><?php if ($value['sale_price'] > 0) {
																				echo $value["sale_price"];
																			} ?></li>
														<li class="price <?php if ($value['sale_price'] > 0) {
																				echo 'old-price nb';
																			} ?>"><?php echo $value["price"] ?></li>
													</ul>
												</div>
												<p><?php echo $value['mota'] ?></p>
											</div>
											<div class="product-link">
												<div class="product-button">
													<a href="xuli-cart.php?action=add&id=<?php echo $value['id']; ?>" title="Add to cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
												</div>
												<div class="add-to-link">
													<ul>
														<li><a href="product-detail.php?id=<?php echo $value['id']; ?>" title="Details"><i class="fa fa-external-link"></i></a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- single-shop-end -->
						<?php } ?>
					</div>
				</div>
				<!-- tab-area-end -->
				<!-- pagination-area-start -->
				<div class="pagination-area mt-50">
					<?php
					if (isset($_GET['cate_id'])) {
						$cate_id = $_GET['cate_id'];

						$sql = "SELECT p.*,c.name AS 'cate_name' FROM product p, category c 
									WHERE p.cate_id = c.id and p.cate_id IN (SELECT id FROM category WHERE parent_id = $cate_id OR id = $cate_id) and p.name like '%$search%'";
					} else {
						$sql = "SELECT p.id, p.name, p.price, p.sale_price, p.mota, p.anh_bia, p.anh_phu, p.created, p.updated, p.quantity, p.lang, c.name AS 'cate_name', p.tacgia_id, p.nxb_id  
									FROM product p, category c 
									WHERE p.cate_id = c.id and p.name like '%$search%'";
					}
					$product = execute($sql);

					$sotrang = ceil(($product->num_rows) / $sotinmottrang);
					?>
					<div class="list-page-2">
						<p>Hiển thị <?php echo $sotinmottrang ?> trong <?php echo $product->num_rows; ?> kết quả</p>
					</div>
					<div class="page-number">
						<ul>
							<?php for ($i = 1; $i < $sotrang + 1; $i++) { ?>
								<li>
									<a class="<?php if ($trang == $i) echo 'active'; ?>" href="category.php?<?php if (isset($cate_id)) {
																												echo 'cate_id=' . $cate_id;
																											} else {
																												echo '';
																											} ?>&name=product&page=<?php echo $i ?>&sotinmottrang=<?php echo $sotinmottrang; ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $i; ?></a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
				<!-- pagination-area-end -->
			</div>
		</div>
	</div>
</div>


<?php include 'footer.php' ?>