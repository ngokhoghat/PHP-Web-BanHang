<?php include 'header.php'; ?>
<!-- header-area-end -->
<!-- slider-group-start -->
<div class="slider-group  mt-30">
	<div class="container">
		<div class="row">

			<?php if (empty($payment)) { ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php } else { ?>
					<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
					<?php } ?>
					<!-- slider-area-start -->
					<div class="slider-area">
						<div class="slider-active owl-carousel">
							<?php foreach ($slider as $key => $value) { ?>
								<div class="single-slider slider-hm4-1 pt-154 pb-154 bg-img" style="background-image:url(admin/public/image/slider/<?php echo $value['img_link'] ?>);">
									<div class="slider-content-4 slider-animated-1 pl-40">
										<h1><?php echo $value['title'] ?></h1>
										<h2><?php echo $value['content'] ?></h2>
										<a href="category.php">Shopping now!</a>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<!-- slider-area-end -->
				</div>
				<div class="col-lg-3 col-md-3 hidden-sm col-xs-12">
					<!-- banner-static-2-start -->
					<div class="banner-static-2">
						<div class="banner-img-2">
							<a href="#"><img src="admin/public/image/icon-img/<?php echo $payment[0]['img_link'] ?>" alt="banner" /></a>
							<?php unset($payment[0]); ?>
						</div>
						<!-- banner-area-3-start -->
						<div class="banner-area-3">
							<?php foreach ($payment as $key => $value) { ?>
								<div class="single-banner-2 mt-16">
									<div class="single-icon-2">
										<a href="#">
											<img class="service-blue-img" src="admin/public/image/icon-img/<?php echo $value['img_link']; ?>" alt="banner" />
											<img class="service-white-img" src="admin/public/image/icon-img/white-<?php echo $value['img_link']; ?>" alt="banner" />
										</a>
									</div>
									<div class="single-text-2">
										<h2><?php echo $value['title'] ?></h2>
										<p><?php echo $value['content'] ?></p>
									</div>
								</div>
							<?php } ?>
						</div>
						<!-- banner-area-3-end -->
					</div>
					<!-- banner-static-2-end -->
				</div>
			</div>
		</div>
	</div>
	<!-- slider-group-end -->
	<!-- home-main-area-start -->
	<div class="home-main-area mt-30">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" id="trending">
					<!-- banner-area-start -->
					<div class="banner-area mb-30">
						<div class="banner-img-2">
							<a href="#"><img src="admin/public/image/banner/<?php echo $banner[0]['img_link'] ?>" alt="banner" /></a>
							<?php unset($banner[0]); ?>
						</div>
					</div>
					<!-- banner-area-end -->
					<!-- most-product-area-start -->
					<div class="most-product-area mb-30">
						<div class="section-title-2 mb-30">
							<h3>Sản phẩm thịnh hành </h3>
						</div>
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
					<!-- most-product-area-end -->
				</div>
				<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
					<!-- new-book-area-start -->
					<div class="new-book-area">
						<div class="section-title-2 mb-30">
							<h3>Sản phẩm mới</h3>
						</div>
						<div class="tab-active-3 owl-carousel" id="product">
							<?php
							$limit = 2;
							for ($i = 0; $i < 5; $i++) {

								$start =  $i * $limit;
								$new_pro = execute("SELECT * FROM product WHERE status = 2 ORDER BY id DESC LIMIT $start,$limit");
								?>
								<div class="tab-total">
									<!-- single-product-start -->
									<?php foreach ($new_pro as $key => $value) {
										$sale = ceil(100 - $value['sale_price'] / $value['price'] * 100);
										?>
										<div class="col-lg-12 col-md-8 col-sm-8 col-xs-6">
											<div class="product-wrapper">
												<div class="product-img mt-40">
													<a href="product-detail.php?id=<?php echo $value['id']; ?>">
														<img src="admin/public/image/product/<?php echo $value['anh_bia']; ?>" alt="book" class="primary" />
													</a>
													<div class="quick-view">
														<a class="action-view quickviews" data-target="#productModal" data-toggle="modal" title="Quick View" id="<?php echo $value['id']; ?>">
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
										</div>
										<!-- single-product-end -->
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
					<!-- new-book-area-start -->
					<!-- hot-sell-area-2-start -->
					<div class="hot-sell-area-2 pb-50">
						<div class="section-title-2 title-big bt pt-50 mb-30">
							<h3>hot sale</h3>
						</div>
						<div class="hot-sell-active owl-carousel">
							<?php
							$sale_pro = execute("SELECT * FROM product WHERE sale_price > 0 ORDER BY id DESC");

							foreach ($sale_pro as $key => $value) {
								$sale = 100 - $value['sale_price'] / $value['price'] * 100;
								?>
								<!-- single-product-start -->
								<div class="product-wrapper" id="list">
									<div class="product-img">
										<a href="product-detail.php?id=<?php echo $value['id']; ?>">
											<img src="admin/public/image/product/<?php echo $value['anh_bia']; ?>" alt="book" class="primary" />
										</a>
										<div class="quick-view">
											<a class="action-view" id="data-product" data-target="#productModal" data-toggle="modal" title="Quick View">
												<i class="fa fa-search-plus"></i>
											</a>
										</div>
										<div id="noidung">

										</div>
										<div class="product-flag">
											<ul>
												<?php if ($value['status'] == 2) { ?>
													<li><span class="sale">new</span></li>
												<?php } ?>
												<li><span class="discount-percentage">-<?php echo $sale; ?>%</span></li>
											</ul>
										</div>
									</div>
									<div class="product-details text-center">
										<div class="product-rating mt-20">
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
												<li class="price"><?php echo $value['sale_price']; ?></li>
												<li class="old-price price"><?php echo $value['price']; ?></li>
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
							<?php } ?>
						</div>
					</div>
					<!-- hot-sell-area-2-end -->
					<!-- product-area-start -->
					<div class="product-area" id="bot">
						<div class="row">
							<div class="col-md-4 col-sm-12 xs-mb">
								<?php
								$cate_id = execute("SELECT id FROM category ORDER BY id")->fetch_all(MYSQLI_ASSOC);
								$min = (reset($cate_id)['id']);
								$max = (end($cate_id))['id'];
								$cate_id = loc($min, $max);

								$random1 = show_pro($cate_id);
								$cate_id1 = array_diff($cate_id, array($random1));

								$random2 = show_pro($cate_id1);
								$cate_id2 = array_diff($cate_id1, array($random2));

								$random3 = show_pro($cate_id2);
								?>
								<div class="section-title-2 mb-30">
									<h4><?php echo execute("SELECT name FROM category WHERE id = $random1")->fetch_all(MYSQLI_ASSOC)[0]['name']; ?></h4>
								</div>
								<div class="product-active-3 owl-carousel">
									<?php
									$limit = 3;
									for ($i = 0; $i < $limit; $i++) {

										$start =  $i * $limit;
										$show_pro = execute("SELECT p.*,c.name as 'cate_name' FROM product p,category c WHERE p.cate_id = c.id and c.id = $random1 LIMIT $start,$limit")->fetch_all(MYSQLI_ASSOC);
										?>
										<div class="product-total-2">
											<?php if ($show_pro) { ?>
												<?php foreach ($show_pro as $value) { ?>
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
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 xs-mb">

								<div class="section-title-2 mb-30">
									<h4><?php echo execute("SELECT name FROM category WHERE id = $random2")->fetch_all(MYSQLI_ASSOC)[0]['name']; ?></h4>
								</div>
								<div class="product-active-3 owl-carousel">
									<?php
									$limit = 3;
									for ($i = 0; $i < $limit; $i++) {

										$start =  $i * $limit;
										$show_pro = execute("SELECT p.*,c.name as 'cate_name' FROM product p,category c WHERE p.cate_id = c.id and c.id = $random2 LIMIT $start,$limit")->fetch_all(MYSQLI_ASSOC);
										?>
										<div class="product-total-2">
											<?php if ($show_pro) { ?>
												<?php foreach ($show_pro as $value) { ?>
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
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 xs-mb">

								<div class="section-title-2 mb-30">
									<h4><?php echo execute("SELECT name FROM category WHERE id = $random3")->fetch_all(MYSQLI_ASSOC)[0]['name']; ?></h4>
								</div>
								<div class="product-active-3 owl-carousel">
									<?php
									$limit = 3;
									for ($i = 0; $i < $limit; $i++) {

										$start =  $i * $limit;
										$show_pro = execute("SELECT p.*,c.name as 'cate_name' FROM product p,category c WHERE p.cate_id = c.id and c.id = $random3 LIMIT $start,$limit")->fetch_all(MYSQLI_ASSOC);
										?>
										<div class="product-total-2">
											<?php if ($show_pro) { ?>
												<?php foreach ($show_pro as $value) { ?>
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
											<?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<!-- product-area-end -->
				</div>
			</div>
		</div>
	</div>
	<!-- home-main-area-end -->
	<!-- banner-area-start -->
	<div class="banner-area-5 mtb-70">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="banner-img-2 for-height">
						<a href="#"><img src="admin/public/image/banner/<?php echo $banner[1]['img_link'] ?>" alt="banner" /></a>
						<div class="banner-text">
							<h3><?php echo $banner[1]['title'] ?></h3>
							<h2><?php echo $banner[1]['content'] ?></h2>
							<?php unset($banner[1]); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- banner-area-end -->
	<!-- social-group-area-start -->
	<div class="social-group-area ptb-60">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="section-title-3">
						<h3>Latest Tweets</h3>
					</div>
					<div class="twitter-content">
						<div class="twitter-icon">
							<a href="#"><i class="fa fa-twitter"></i></a>
						</div>
						<div class="twitter-text">
							<p>
								Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum.
								Mirum notare quam
							</p>
							<a href="#">posthemes</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="section-title-3">
						<h3>Stay Connected</h3>
					</div>
					<div class="link-follow">
						<ul>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-youtube"></i></a></li>
							<li><a href="#"><i class="fa fa-flickr"></i></a></li>
							<li class="hidden-sm"><a href="#"><i class="fa fa-vimeo"></i></a></li>
							<li class="hidden-sm"><a href="#"><i class="fa fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- social-group-area-end -->
	<!-- footer-area-start -->
	<?php include 'footer.php'; ?>