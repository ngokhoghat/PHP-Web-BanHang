<footer>
	<!-- footer-top-start -->
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="footer-top-menu bb-2">
						<nav>
							<ul>
								<li><a href="#">home</a></li>
								<li><a href="#">Enable Cookies</a></li>
								<li><a href="#">Privacy and Cookie Policy</a></li>
								<li><a href="#">contact us</a></li>
								<li><a href="#">blog</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer-top-start -->
	<!-- footer-mid-start -->
	<div class="footer-mid ptb-50">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-12">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="single-footer br-2 xs-mb">
								<div class="footer-title mb-20">
									<h3>Products</h3>
								</div>
								<div class="footer-mid-menu">
									<ul>
										<li><a href="about.html">About us</a></li>
										<li><a href="#">Prices drop </a></li>
										<li><a href="#">New products</a></li>
										<li><a href="#">Best sales</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="single-footer br-2 xs-mb">
								<div class="footer-title mb-20">
									<h3>Our company</h3>
								</div>
								<div class="footer-mid-menu">
									<ul>
										<li><a href="contact.html">Contact us</a></li>
										<li><a href="#">Sitemap</a></li>
										<li><a href="#">Stores</a></li>
										<li><a href="register.html">My account </a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<div class="single-footer br-2 xs-mb">
								<div class="footer-title mb-20">
									<h3>Your account</h3>
								</div>
								<div class="footer-mid-menu">
									<ul>
										<li><a href="contact.html">Addresses</a></li>
										<li><a href="#">Credit slips </a></li>
										<li><a href="#"> Orders</a></li>
										<li><a href="#">Personal info</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12">
					<div class="single-footer mrg-sm">
						<div class="footer-title mb-20">
							<h3>STORE INFORMATION</h3>
						</div>
						<div class="footer-contact">
							<p class="adress">
								<span>My Company</span>
								42 avenue des Champs Elysées 75000 Paris France
							</p>
							<p><span>Call us now:</span> (+1)866-540-3229</p>
							<p><span>Email:</span> support@hastech.com</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer-mid-end -->
	<!-- footer-bottom-start -->
	<div class="footer-bottom">
		<div class="container">
			<div class="row bt-2">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="copy-right-area">
						<p>Copyright ©<a href="#">Koparion</a>. All Right Reserved.</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="payment-img text-right">
						<a href="#"><img src="public/img/1.png" alt="payment" /></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- footer-bottom-end -->
</footer>
<!-- footer-area-end -->
<div id="view">

</div>
<!-- modal signin start -->

<!-- modal signin end -->
<!-- Nút Gooey Menu -->
<div class="gooney-menu" style="display: none;">
	<nav class="menu-bb">

		<input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open" />
		<label class="menu-open-button" for="menu-open">
			<span class="lines line-1"></span>
			<span class="lines line-2"> </span>
		</label>

		<a href="#top" class="menu-item item-1"><i class="fa fa-angle-double-up"></i></a>
		<a href="cart.php" class="menu-item item-2"><i class="fa fa-shopping-cart"><span><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span></i></a>
		<a href="index.php" class="menu-item item-3"><i class="fa fa-home"></i></a>
	</nav>
</div>
<!-- Gooey Menu end -->

<!-- all js here -->
<!-- jquery latest version -->
<script src="admin/public/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="admin/public/autoNumeric/autoNumeric-2.0-BETA.js"></script>
<script>
	$('#product .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#list .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#bot .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#cart .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#cart-top .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#trending .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#detail_pro .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#shop-left .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#order .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$('#cart-account .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
</script>
<script>
	$(document).ready(function() {
		$(".quickviews").click(function() {
			var proid = $(this).attr('id');
			$.ajax({
					method: "GET",
					url: "ajax.php",
					data: {
						id: proid,
						// location: "Boston"
					}
				})
				.done(function(data) {
					$("#view").html(data);
					$("#productModal" + proid).modal();
				});
		});
	});
</script>
<script src="public/js/vendor/jquery-1.12.0.min.js"></script>
<!-- bootstrap js -->
<script src="public/js/bootstrap.min.js"></script>
<!-- owl.carousel js -->
<script src="public/js/owl.carousel.min.js"></script>
<!-- meanmenu js -->
<script src="public/js/jquery.meanmenu.js"></script>
<!-- wow js -->
<script src="public/js/wow.min.js"></script>
<!-- jquery.parallax-1.1.3.js -->
<script src="public/js/jquery.parallax-1.1.3.js"></script>
<!-- jquery.countdown.min.js -->
<script src="public/js/jquery.countdown.min.js"></script>
<!-- jquery.flexslider.js -->
<script src="public/js/jquery.flexslider.js"></script>
<!-- chosen.jquery.min.js -->
<script src="public/js/chosen.jquery.min.js"></script>
<!-- jquery.counterup.min.js -->
<script src="public/js/jquery.counterup.min.js"></script>
<!-- waypoints.min.js -->
<script src="public/js/waypoints.min.js"></script>
<!-- plugins js -->
<script src="public/js/plugins.js"></script>
<!-- main js -->
<script src="public/js/main.js"></script>
</body>

<!-- Mirrored from demo.devitems.com/koparion-v2/koparion/index-4.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 22 May 2019 08:10:33 GMT -->

</html>