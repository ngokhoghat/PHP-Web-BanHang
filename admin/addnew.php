<?php include "header.php" ?>
<?php
// Lấy hành động

if (isset($_GET['name'])) {
	$action = $_GET['name'];
} else {
	$action = "product";
}

?>
<?php if ($action == "product") { ?>
	<?php

	$danhmuc = execute("SELECT * FROM category")->fetch_all(MYSQLI_ASSOC);
	$menu = menu($danhmuc, 0);
	$tacgia = execute("SELECT * FROM tacgia");
	$nxb = execute("SELECT * FROM nxb");

	if (!empty($_FILES['anh_bia']['name'])) {
		$image = time() . '_' . $_FILES['anh_bia']['name'];
		move_uploaded_file($_FILES['anh_bia']['tmp_name'], 'public/image/product/' . $image);

		//Xử lý ảnh
		if (file_exists('public/image/product/' . $image)) {
			// *** 1) Initialize / load image
			$resizeObj = new resize('public/image/product/' . $image);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj->resizeImage(350, 449, 'exact');

			// *** 3) Save image
			$resizeObj->saveImage('public/image/product/' . $image, 100);
		}
	} else {
		$image = '';
	}

	$img_list = '';

	if (!empty($_FILES['anh_phu']['name'][0])) {

		$fs = $_FILES['anh_phu'];
		$img = [];
		for ($i = 0; $i < count($fs['name']); $i++) {
			$fsname =  time() . '-' . $_FILES['anh_phu']['name'][$i];
			move_uploaded_file($fs['tmp_name'][$i], 'public/image/product/' . $fsname);
			array_push($img, $fsname);
		}

		$img_list = json_encode($img);
	}
	// echo $img_list;
	$name = '';
	$price = 0;
	$sale_price = 0;
	$lang = '';
	$quantity = 0;
	$mota = '';
	$status = 0;


	if (!empty($_POST['name'])) {
		$name = $_POST['name'];
	}
	if (!empty($_POST['price'])) {
		$price = $_POST['price'];
	}
	if (!empty($_POST['sale-price'])) {
		$sale_price = $_POST['sale-price'];
	}
	if (!empty($_POST['lang'])) {
		$lang = $_POST['lang'];
	}
	if (!empty($_POST['quantity'])) {
		$quantity = $_POST['quantity'];
	}
	if (!empty($_POST['mota'])) {
		$mota = $_POST['mota'];
	}
	if (!empty($_POST['status'])) {
		$status = $_POST['status'];
	}
	if (!empty($_POST)) {
		$cat_id = $_POST['cat_id'];
		$tacgia_id = $_POST['tacgia_id'];
		$nxb_id = $_POST['nxb_id'];

		$sql = "INSERT INTO product(name,price,sale_price,mota, status,anh_bia,anh_phu,lang,quantity,cate_id, tacgia_id, nxb_id)
						VALUES('$name', $price, $sale_price, '$mota', $status,'$image','$img_list', '$lang', $quantity, $cat_id, $tacgia_id, $nxb_id)";
		$result = execute($sql);
		$mess = [];
		if ($result) {
			$mess['thanhcong'] = "thành công";
		} else {
			$mess['thatbai'] = "thất bại";
		}
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
				<h6 class="m-0 font-weight-bold text-primary">Thêm mới sản phẩm</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row mt-2">
								<div class="col-md-8">
									<div class="row" id="price-pro">
										<div class="col-md-6">
											<div class="form-group">
												<label for="pro_name">Tên sản phẩm</label>
												<input type="text" class="form-control" id="pro_name" name="name">
											</div>
											<div class="form-group">
												<label for="pro_price">Giá</label>
												<input type="text" class="form-control price" id="pro_price" name="price">
											</div>
											<div class="form-group">
												<label for="pro_saleprice">Giá Khuyến mãi</label>
												<input type="text" class="form-control price" id="pro_saleprice" name="sale-price">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<legend class="col-form-label col-sm-3 pt-0">Trạng thái</legend>
													<div class="col-sm-9">
														<div class="form-check">
															<input class="form-check-input" type="radio" name="status" id="status1" value="0" checked>
															<label class="form-check-label" for="status1">
																Hiện
															</label>
														</div>
														<div class="form-check">
															<input class="form-check-input" type="radio" name="status" id="status2" value="1">
															<label class="form-check-label" for="status2">
																Ẩn
															</label>
														</div>
														<div class="form-check disabled">
															<input class="form-check-input" type="radio" name="status" id="status3" value="2">
															<label class="form-check-label" for="status3">
																Sản phẩm mới
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="lang">Ngôn ngữ</label>
												<input type="text" class="form-control" id="lang" name="lang">
											</div>
											<div class="form-group">
												<label for="pro_quantity">Số lượng</label>
												<input type="text" class="form-control" id="pro_quantity" name="quantity">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Mô tả</label>
												<textarea class="form-control" id="content" rows="3" name="mota"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="formGroupExampleInput2">Danh mục</label>
										<select class="c-select form-control" name="cat_id">
											<?php if (!empty($menu)) {
												showmenu($menu, 0);
											} ?>
										</select>
									</div>
									<div class="form-group">
										<label for="formGroupExampleInput2">Tác giả</label>
										<select class="c-select form-control" name="tacgia_id">
											<?php foreach ($tacgia as $value) { ?>
												<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="formGroupExampleInput2">Nhà xuất bản</label>
										<select class="c-select form-control" name="nxb_id">
											<?php foreach ($nxb as $value) { ?>
												<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="anh_bia" class="w-100">Ảnh Bìa
											<input type="file" name="anh_bia" value="" class="d-none" id="anh_bia" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
											<div class="text-center">
												<img id="blah" src="" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
											</div>
										</label>
									</div>
									<div class="form-group">
										<label for="anh_phu" class="w-100">Ảnh phụ
											<input type="file" name="anh_phu[]" value="" class="d-none" id="anh_phu" multiple>
											<div id="img_list" class="border p-1 overflow-auto" style="height: 135px;">

											</div>
											<div>
												<button type="button" class="btn btn-danger mt-2" onclick="img_list.innerHTML = '';">Xóa</button>
											</div>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2" onclick="getprice()">Thêm Mới Sản Phẩm</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
<?php } else if ($action == "author") { ?>
	<?php

	if (isset($_FILES['hinh_anh']['name'])) {
		$image = time() . '_' . $_FILES['hinh_anh']['name'];
		move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/author/' . $image);
	}

	$name = '';
	$email = '';
	$phone = '';
	$address = '';
	$tieu_su = '';

	if (!empty($_POST['name'])) {
		$name = $_POST['name'];
	}
	if (!empty($_POST['email'])) {
		$email = $_POST['email'];
	}
	if (!empty($_POST['phone'])) {
		$phone = $_POST['phone'];
	}
	if (!empty($_POST['address'])) {
		$address = $_POST['address'];
	}
	if (!empty($_POST['tieu_su'])) {
		$tieu_su = $_POST['tieu_su'];
	}
	if (!empty($_POST)) {
		$sql = "INSERT INTO tacgia(name,email, phone, tieu_su, hinh_anh, address)
					VALUES('$name', '$email', '$phone', '$tieu_su','$image', '$address')";
		execute($sql);
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
				<h6 class="m-0 font-weight-bold text-primary">Thêm mới sản phẩm</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row mt-2">
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group price">
												<label for="pro_price">Tên tác giả</label>
												<input type="text" class="form-control" id="pro_price" name="name">
											</div>
											<div class="form-group price">
												<label for="pro_saleprice">Email</label>
												<input type="email" class="form-control" id="pro_saleprice" name="email">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="lang">Phone</label>
												<input type="text" class="form-control" id="lang" name="phone">
											</div>
											<div class="form-group">
												<label for="pro_quantity">Địa chỉ</label>
												<input type="text" class="form-control" id="pro_quantity" name="address">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Tiểu sử</label>
												<textarea class="form-control" id="content" rows="3" name="tieu_su"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="hinh_anh" class="w-100">Hình ảnh
											<input type="file" name="hinh_anh" value="" class="d-none" id="hinh_anh" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
											<div class="text-center">
												<img id="blah" src="" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
											</div>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2" onclick="getprice()">Thêm Mới tác giả</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
<?php } else if ($action == "nxb") { ?>
	<?php

	$name = '';
	$email = '';
	$phone = '';
	$address = '';

	if (!empty($_POST['name'])) {
		$name = $_POST['name'];
	}
	if (!empty($_POST['email'])) {
		$email = $_POST['email'];
	}
	if (!empty($_POST['phone'])) {
		$phone = $_POST['phone'];
	}
	if (!empty($_POST['address'])) {
		$address = $_POST['address'];
	}
	if (!empty($_POST)) {
		$sql = "INSERT INTO nxb(name,email, phone, address)
					VALUES('$name', '$email', '$phone', '$address')";
		echo $sql;
		execute($sql);
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
				<h6 class="m-0 font-weight-bold text-primary">Thêm mới sản phẩm</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row mt-2">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group price">
												<label for="pro_price">Tên Nhà Xuất bản</label>
												<input type="text" class="form-control" id="pro_price" name="name">
											</div>
											<div class="form-group price">
												<label for="pro_saleprice">Email</label>
												<input type="email" class="form-control" id="pro_saleprice" name="email">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="lang">Phone</label>
												<input type="text" class="form-control" id="lang" name="phone">
											</div>
											<div class="form-group">
												<label for="pro_quantity">Địa chỉ</label>
												<input type="text" class="form-control" id="pro_quantity" name="address">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2" onclick="getprice()">Thêm Mới Nhà Xuất Bản</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
<?php } else if ($action == "category") { ?>
	<?php


	if (!empty($_POST['name'])) {
		$name = $_POST['name'];
	}
	if (!empty($_POST['status'])) {
		$status = $_POST['status'];
	}
	if (!empty($_POST['cat_id'])) {
		$cat_id = $_POST['cat_id'];
	}
	if (!empty($_POST['ordering'])) {
		$ordering = $_POST['ordering'];
	}
	if (!empty($_POST)) {
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		$sql = "INSERT INTO category (name, status, parent_id, ordering) VALUES ('$name', '$status', '$cat_id', '$ordering');";
		$result = execute($sql);
		if ($result == 1) {
			header("Location: category.php?name=category");
		} else {
			echo $result;
		}
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
				<h6 class="m-0 font-weight-bold text-primary">Sửa danh mục</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row justify-content-md-center ">
								<div class="col-md-6 border mt-3 p-3">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="formGroupExampleInput">Tên Danh mục</label>
												<input type="text" class="form-control" id="formGroupExampleInput" name="name">
											</div>
											<div class="form-group">
												<div class="row">
													<legend class="col-form-label col-sm-4 pt-0">Trạng thái</legend>
													<div class="col-sm-8">
														<div class="form-check">
															<input class="form-check-input" type="radio" name="status" id="status1" value="0" checked>
															<label class="form-check-label" for="status1">
																Hiện
															</label>
														</div>
														<div class="form-check">
															<input class="form-check-input" type="radio" name="status" id="status2" value="1">
															<label class="form-check-label" for="status2">
																Ẩn
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="formGroupExampleInput2">Danh mục</label>
												<select class="c-select form-control" name="cat_id">
													<?php
													$danhmuc = execute("SELECT * FROM category")->fetch_all(MYSQLI_ASSOC);
													$menu = menu($danhmuc, 0);
													if (!empty($menu)) {
														echo "<option value='0'>None</option>";
														showmenu($menu, 0);
													} ?>
												</select>
											</div>
											<div class="form-group ">
												<label for="formGroupExampleInput">Thứ tự</label>
												<input type="text" class="form-control" id="formGroupExampleInput2" name="ordering">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2" onclick="getprice()">Sửa Nhà Xuất Bản</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->

<?php } else if ($action == "image") { ?>
	<?php
	if (!empty($_POST)) {
		$title = $_POST['title'];
		$ordering = $_POST['ordering'];
		$type = $_POST['type'];
		$status = $_POST['status'];
		$content = $_POST['content'];
		if ($type == 0) {
			if (!empty($_FILES['hinh_anh']['name'])) {
				$image = time() . '_' . $_FILES['hinh_anh']['name'];
				move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/slider/' . $image);
			} else {
				$image = '';
			}
		} elseif ($type == 1) {
			if (!empty($_FILES['hinh_anh']['name'])) {
				$image = time() . '_' . $_FILES['hinh_anh']['name'];
				move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/banner/' . $image);
			} else {
				$image = '';
			}
		} else {
			if (!empty($_FILES['hinh_anh']['name'])) {
				$image = time() . '_' . $_FILES['hinh_anh']['name'];
				move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/post/' . $image);
			} else {
				$image = '';
			}
		}
		$sql = "INSERT INTO image (title, content, img_link, ordering, type, status) VALUES ('$title', '$content', '$image', '$ordering', '$type', '$status');";
		// echo $sql;
		execute($sql);
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
				<h6 class="m-0 font-weight-bold text-primary">Thêm mới sản phẩm</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row mt-2">
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group price">
												<label for="pro_price">Tiêu đề</label>
												<input type="text" class="form-control" id="pro_price" name="title">
											</div>
											<div class="form-group price">
												<label for="pro_saleprice">Thứ tự</label>
												<input type="text" class="form-control" id="pro_saleprice" name="ordering">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Loại ảnh</label>
												<select class="form-control" name="type">
													<option value="0">Slide</option>
													<option value="2">Post</option>
												</select>
											</div>
											<div class="form-group">
												<label for="">Trạng thái</label>
												<select class="form-control" name="status">
													<option value="0">Hiện</option>
													<option value="1">Ẩn</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Nội dung</label>
												<textarea class="form-control" id="desc" rows="3" name="content"></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="hinh_anh" class="w-100">Hình ảnh
											<input type="file" name="hinh_anh" value="" class="d-none" id="hinh_anh" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
											<div class="text-center">
												<img id="blah" src="" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
											</div>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2">Thêm Mới Hình ảnh</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
<?php } else if ($action == "news") { ?>
	<?php
	if (isset($_SESSION['admin'])) {
		$id = $_SESSION['admin']['id'];
		$name = $_SESSION['admin']['name'];
		if (!empty($_POST)) {
			$title = $_POST['name'];
			$content = $_POST['content'];
			$status = $_POST['status'];
			$ordering = $_POST['ordering'];
			$sql = "INSERT INTO news(author, title, content, ordering, status)
				VALUES($id, '$title', '$content', $ordering, $status)";
			$result = execute($sql);
			if ($result == 1) {
				echo "Thêm mới không thành công";
			}else{
				echo $result;
			}
		}
	} else {
		echo "Bạn chưa đăng nhập";
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
				<h6 class="m-0 font-weight-bold text-primary">Thêm mới tin tức</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row mt-2">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group price">
												<label for="pro_price">Tiêu đề</label>
												<input type="text" class="form-control" id="pro_price" name="name">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Thứ tự</label>
												<input type="text" class="form-control" id="pro_price" name="ordering">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Trạng thái</label>
												<select class="form-control" name="status">
													<option value="0">Hiện</option>
													<option value="1">Ẩn</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Nội dung</label>
												<textarea class="form-control" id="content" rows="3" name="content"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2" onclick="getprice()">Thêm Tin</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
<?php } ?>

<?php include "footer.php" ?>
<script>
	$('#price-pro .price').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});

	function getprice() {
		$('#pro_price').val($('#pro_price').autoNumeric('get'));
		$('#pro_saleprice').val($('#pro_saleprice').autoNumeric('get'));
	}
</script>