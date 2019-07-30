<?php include 'header.php' ?>

<?php

$search = '';
if (isset($_GET['search'])) {
	$search = $_GET['search'];
}
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sql = "SELECT  n.* , a.name , a.image FROM news n, account a
	WHERE n.author =  a.id and n.id = $id";
} else {
	$sql = "SELECT n.*,a.name,a.image FROM news n, account a 
	WHERE n.author = a.id and status = 0 and n.title like '%$search%' ORDER BY ordering";
}

if (isset($_GET['name'])) {
	$name = $_GET['name'];
} else {
	$name = '';
}


if (isset($_GET["sotinmottrang"])) {
	$sotinmottrang = $_GET['sotinmottrang'];
} else {
	$sotinmottrang = 5;
}

if (isset($_GET['page'])) {
	$trang = $_GET["page"];
} else {
	$trang = 1;
}

$from = ($trang - 1) * $sotinmottrang;


$news = pagination($sql, $from, $sotinmottrang);

?>

<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumbs-menu">
					<ul>
						<li><a href="#">Home</a></li>
						<li><a href="#" class="active">news</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- breadcrumbs-area-end -->
<!-- blog-main-area-start -->
<div class="blog-main-area mb-70">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
				<div class="single-blog mb-50">
					<div class="blog-left-title">
						<h3>Tìm kiếm</h3>
					</div>
					<div class="side-form" >
						<form action="news.php" id="search-new">
							<input type="text" placeholder="Search...." name="search" />
							<a href="javascript:{}" onclick="document.getElementById('search-new').submit();"><i class="fa fa-search"></i></a>
						</form>
					</div>
				</div>
				<div class="single-blog mb-50">
					<?php
					$hotnews = execute("SELECT n.title, n.id FROM news n
					WHERE status = 0 ORDER BY id DESC limit 0,5");
					?>
					<div class="blog-left-title">
						<h3>Tin mới</h3>
					</div>
					<div class="blog-side-menu">
						<ul>
							<?php foreach ($hotnews as $key => $value) { ?>
								<li><a href="news.php?id=<?php echo $value['id'] ?>"><?php echo get_str($value['title'], 30) ?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
				<div class="blog-main-wrapper">
					<?php foreach ($news as $key => $value) { ?>
						<div class="single-blog-post">
							<div class="author-destils mb-30">
								<div class="author-left">
									<div class="author-img rounded">
										<a href="#"><img src="admin/public/image/account/<?php echo $value['image'] ?>" alt="man" class="img-circle" /></a>
									</div>
									<div class="author-description">
										<p>Đăng bởi:
											<a href="#"><span><?php echo $value['name'] ?></span></a>
										</p>
										<span><?php echo $value['created'] ?></span>
									</div>
								</div>
								<div class="author-right">
									<span>Chia sẻ:</span>
									<ul>
										<li><a href="#"><i class="fa fa-facebook"></i></a></li>
										<li><a href="#"><i class="fa fa-twitter"></i></a></li>
										<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
										<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
										<li><a href="#"><i class="fa fa-instagram"></i></a></li>
									</ul>
								</div>
							</div>
							<div class="single-blog-content">
								<div class="single-blog-title">
									<h3><a href="news.php?id=<?php echo $value['id'] ?>" style="font-size: 20px;"><?php echo $value['title'] ?></a></h3>
								</div>
								<div class="blog-single-content">
									<div><?php echo isset($id) ? $value['content'] : get_str($value['content'], 300); ?></div>
								</div>
							</div>
							<div class="blog-comment-readmore">
								<div class="blog-readmore">
									<?php if (!isset($id)) { ?>
										<a href="news.php?id=<?php echo $value['id'] ?>">Đọc tiếp<i class="fa fa-long-arrow-right"></i></a>
									<?php } ?>
								</div>
								<div class="blog-com">
									<a href="#">3 comments</a>
								</div>
							</div>
						</div>
					<?php } ?>
					<!-- pagination-area-start -->
					<div class="blog-pagination text-center">
						<?php
						if (isset($_GET['id'])) {
							$id = $_GET['id'];
							$sql = "SELECT  n.* , a.name , a.image FROM news n, account a
							WHERE n.author =  a.id and n.id = $id";
						} else {
							$sql = "SELECT n.*,a.name,a.image FROM news n, account a 
							WHERE n.author = a.id and status = 0 and n.title like '%$search%' ORDER BY ordering";
						}
						$news = execute($sql);

						$sotrang = ceil(($news->num_rows) / $sotinmottrang);
						?>
						<div class="page-number">
							<ul>
								<li><a href="#"><i class="fa fa-angle-left"></i></a></li>
								<?php for ($i = 1; $i < $sotrang + 1; $i++) { ?>
									<li class="<?php if ($trang == $i) echo 'active'; ?>">
										<a href="news.php?<?php echo isset($id) ? 'id=' . $id : ''; ?>&name=news&page=<?php echo $i ?>&sotinmottrang=<?php echo $sotinmottrang; ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $i; ?></a>
									</li>
								<?php } ?>
								<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- blog-main-area-end -->

<?php include 'footer.php' ?>