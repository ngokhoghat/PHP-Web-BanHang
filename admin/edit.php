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

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$sql = "SELECT * FROM product WHERE id = $id";

		$product = execute($sql)->fetch_assoc();
		$danhmuc = execute("SELECT * FROM category");
		$tacgia = execute("SELECT * FROM tacgia");
		$nxb = execute("SELECT * FROM nxb");

		if ($product["anh_phu"] != "") {
			$anhphu = json_decode($product['anh_phu']);
		} else {
			$anhphu = [];
		}
	} else {
		echo 'Không tồn tại';
	}

	if (!empty($_FILES['anh_bia']['name'])) {
		$image = time() . '-' . $_FILES['anh_bia']['name'];
		if ($image != $product['anh_bia']) {
			unlink('public/image/product/' . $product['anh_bia']);
		}
		move_uploaded_file($_FILES['anh_bia']['tmp_name'], 'public/image/product/' . $image);
		if (file_exists('public/image/product/' . $image)) {
			// *** 1) Initialize / load image
			$resizeObj = new resize('public/image/product/' . $image);

			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj->resizeImage(350, 449, 'exact');

			// *** 3) Save image
			$resizeObj->saveImage('public/image/product/' . $image, 100);
		}
	} else {
		$image = $product['anh_bia'];
	}


	if (!empty($_FILES['anh_phu']['name'][0])) {
		$img = [];
		$fs = $_FILES['anh_phu'];
		for ($i = 0; $i < count($fs['name']); $i++) {
			$fsname =  time() . '-' . $_FILES['anh_phu']['name'][$i];
			move_uploaded_file($fs['tmp_name'][$i], 'public/image/product/' . $fsname);
			array_push($img, $fsname);
		}

		$img_list = json_encode($img);
	} else {
		$img_list = $product['anh_phu'];
	}


	if (!empty($_POST['name'])) {
		$name = $_POST['name'];
	} else {
		$name = $product['name'];
	}
	if (!empty($_POST['price'])) {
		$price = $_POST['price'];
	} else {
		$price = $product['price'];
	}
	if (!empty($_POST['sale-price'])) {
		$sale_price = $_POST['sale-price'];
	} else {
		$sale_price = $product['sale_price'];
	}
	if (!empty($_POST['lang'])) {
		$lang = $_POST['lang'];
	} else {
		$lang = $product['lang'];
	}
	if (!empty($_POST['quantity'])) {
		$quantity = $_POST['quantity'];
	} else {
		$quantity = $product['quantity'];
	}
	if (!empty($_POST['mota'])) {
		$mota = $_POST['mota'];
	} else {
		$mota = $product['mota'];
	}
	if (isset($_POST['status'])) {
		$status = $_POST['status'];
	} else {
		$status = $product['status'];
	}
	if (!empty($_POST)) {
		$cat_id = $_POST['cat_id'];
		$tacgia_id = $_POST['tacgia_id'];
		$nxb_id = $_POST['nxb_id'];

		$sql1 = "UPDATE product SET name = '$name',price = $price ,sale_price = $sale_price, mota = '$mota',status = $status, anh_bia = '$image',anh_phu = '$img_list', lang = '$lang',quantity = $quantity, cate_id = $cat_id, tacgia_id = $tacgia_id, nxb_id = $nxb_id, updated =  CURRENT_TIMESTAMP() WHERE id = $id";

		$go = execute($sql1);

		header("Location: product.php?name=product");
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
				<h6 class="m-0 font-weight-bold text-primary">Sửa sản phẩm</h6>
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
												<label for="">Tên sản phẩm</label>
												<input type="text" class="form-control" value="<?php echo $product['name'] ?>" name="name">
											</div>
											<div class="form-group">
												<label for="">Giá</label>
												<input type="text" class="form-control price" id="pro_price" value="<?php echo $product['price'] ?>" name="price">
											</div>
											<div class="form-group">
												<label for="">Giá Khuyến mãi</label>
												<input type="text" class="form-control price" id="pro_saleprice" value="<?php echo $product['sale_price'] ?>" name="sale-price">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<div class="row">
													<legend class="col-form-label col-sm-3 pt-0">Trạng thái</legend>
													<div class="col-sm-9">
														<div class="form-check">
															<input class="form-check-input" type="radio" name="status" id="status1" value="0" <?php echo  $product['status'] == 0 ? 'checked' : ""; ?>>
															<label class="form-check-label" for="status1">
																Hiện
															</label>
														</div>
														<div class="form-check">
															<input class="form-check-input" type="radio" name="status" id="status2" value="1" <?php echo  $product['status'] == 1 ? 'checked' : ""; ?>>
															<label class="form-check-label" for="status2">
																Ẩn
															</label>
														</div>
														<div class="form-check disabled">
															<input class="form-check-input" type="radio" name="status" id="status3" value="2" <?php echo  $product['status'] == 2 ? 'checked' : ""; ?>>
															<label class="form-check-label" for="status3">
																Sản phẩm mới
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label for="">Ngôn ngữ</label>
												<input type="text" class="form-control" value="<?php echo $product['lang'] ?>" name="lang">
											</div>
											<div class="form-group">
												<label for="">Số lượng</label>
												<input type="text" class="form-control" value="<?php echo $product['quantity'] ?>" name="quantity">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Mô tả</label>
												<textarea class="form-control" id="content" rows="6" name="mota"><?php echo $product['mota']; ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Danh mục</label>
										<select class="c-select form-control" name="cat_id">
											<?php foreach ($danhmuc as $value) { ?>
												<option <?php if ($value['id'] == $product['cate_id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="">Another label</label>
										<select class="c-select form-control" name="tacgia_id">
											<?php foreach ($tacgia as $value) { ?>
												<option <?php if ($value['id'] == $product['cate_id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="">Another label</label>
										<select class="c-select form-control" name="nxb_id">
											<?php foreach ($nxb as $value) { ?>
												<option <?php if ($value['id'] == $product['cate_id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="anh_bia" class="w-100">Ảnh Bìa
											<input type="file" name="anh_bia" value="" class="d-none" id="anh_bia" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
											<div class="text-center">
												<img id="blah" src="<?php echo 'public/image/product/';
																	echo $product["anh_bia"]; ?>" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
											</div>
										</label>
									</div>
									<div class="form-group">
										<label for="anh_phu" class="w-100">Ảnh phụ
											<input type="file" name="anh_phu[]" value="" class="d-none" id="anh_phu" multiple>
											<div id="img_list" class="border p-1 overflow-auto row" style="height: 135px;">
												<?php foreach ($anhphu as $key => $value) : ?>
													<img src="<?php echo 'public/image/product/';
																echo $value; ?>" class="col-4 img-fluid h-100 mb-2" alt="Responsive image">
												<?php endforeach ?>
											</div>
											<div>
												<a name="" class="btn btn-danger mt-2" href="delete-pro.php?data=<?php echo $id; ?>" role="button">Xóa</a>
											</div>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2" onclick="getprice()">Sửa Sản Phẩm</button>
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

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$sql = "SELECT * FROM tacgia WHERE id = $id";

		$author = execute($sql)->fetch_assoc();
	} else {
		echo 'Không tồn tại';
	}

	if (!empty($_FILES['hinh_anh']['name'])) {
		$image = time() . '-' . $_FILES['hinh_anh']['name'];
		if ($image != $author['hinh_anh']) {
			unlink('public/image/author/' . $author['hinh_anh']);
		}
		move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/author/' . $image);
	} else {
		$image = $author['hinh_anh'];
	}



	$name = '';
	$phone = '';
	$email = '';
	$address = '';
	$tieu_su = '';

	if (!empty($_POST['name'])) {
		$name = $_POST['name'];
	}
	if (!empty($_POST['phone'])) {
		$phone = $_POST['phone'];
	}
	if (!empty($_POST['email'])) {
		$email = $_POST['email'];
	}
	if (!empty($_POST['address'])) {
		$address = $_POST['address'];
	}
	if (!empty($_POST['tieu_su'])) {
		$tieu_su = $_POST['tieu_su'];
	}
	if (!empty($_POST)) {

		$sql = "UPDATE tacgia SET name = '$name', tieu_su = '$tieu_su', hinh_anh = '$image', email = '$email', phone = '$phone', address = '$address' WHERE id = $id";
		execute($sql);

		header("Location: tacgia.php?name=tacgia");
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
				<h6 class="m-0 font-weight-bold text-primary">Sửa tác giả</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row mt-2">
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="formGroupExampleInput">Tên tác giả</label>
												<input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $author['name'] ?>" name="name">
											</div>
											<div class="form-group">
												<label for="formGroupExampleInput">Phone</label>
												<input type="text" class="form-control" id="formGroupExampleInput" value="<?php echo $author['phone'] ?>" name="phone">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group ">
												<label for="formGroupExampleInput">Email</label>
												<input type="text" class="form-control" value="<?php echo $author['email'] ?>" name="email">
											</div>
											<div class="form-group ">
												<label for="formGroupExampleInput">Địa chỉ</label>
												<input type="text" class="form-control" value="<?php echo $author['address'] ?>" name="address">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Tiểu sử</label>
												<textarea class="form-control" id="content" rows="3" name="tieu_su"><?php echo $author['tieu_su']; ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="hinh_anh" class="w-100">Hình ảnh
											<input type="file" name="hinh_anh" value="" class="d-none" id="hinh_anh" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
											<div class="text-center">
												<img id="blah" src="public/image/author/<?php echo $author["hinh_anh"]; ?>" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
											</div>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2" onclick="getprice()">Sửa tác giả</button>
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

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$sql = "SELECT * FROM nxb WHERE id = $id";

		$author = execute($sql)->fetch_assoc();
	} else {
		echo 'Không tồn tại';
	}




	$name = '';
	$phone = '';
	$email = '';
	$address = '';

	if (!empty($_POST['name'])) {
		$name = $_POST['name'];
	}
	if (!empty($_POST['phone'])) {
		$phone = $_POST['phone'];
	}
	if (!empty($_POST['email'])) {
		$email = $_POST['email'];
	}
	if (!empty($_POST['address'])) {
		$address = $_POST['address'];
	}
	if (!empty($_POST)) {

		$sql = "UPDATE nxb SET name = '$name', email = '$email', phone = '$phone', address = '$address' WHERE id = $id";
		execute($sql);

		header("Location: nxb.php?name=nxb");
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
				<h6 class="m-0 font-weight-bold text-primary">Sửa tác giả</h6>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-sm-12 col-md-12 border">
						<form action="" method="POST" enctype="multipart/form-data" id="formthemmoi">
							<div class="row mt-2">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Tên Nhà Xuất Bản</label>
												<input type="text" class="form-control" value="<?php echo $author['name'] ?>" name="name">
											</div>
											<div class="form-group">
												<label for="">Phone</label>
												<input type="text" class="form-control" value="<?php echo $author['phone'] ?>" name="phone">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group ">
												<label for="">Email</label>
												<input type="text" class="form-control" value="<?php echo $author['email'] ?>" name="email">
											</div>
											<div class="form-group ">
												<label for="">Địa chỉ</label>
												<input type="text" class="form-control" value="<?php echo $author['address'] ?>" name="address">
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
<?php } else if ($action == "category") { ?>
	<?php

	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$sql = "SELECT * FROM category WHERE id = $id";

		$category = execute($sql)->fetch_assoc();
	} else {
		echo 'Không tồn tại';
	}



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
		$sql = "UPDATE category SET name = '$name', status = '$status', parent_id = '$cat_id', ordering = '$ordering' WHERE id = $id";
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
												<label for="">Tên Danh mục</label>
												<input type="text" class="form-control" value="<?php echo $category['name'] ?>" name="name">
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
												<label for="">Danh mục</label>
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
												<input type="text" class="form-control" value="<?php echo $category['ordering'] ?>" name="ordering">
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

<?php } elseif ($action == "image") { ?>
	<?php
	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$sql = "SELECT * FROM image WHERE id = $id";

		$images = execute($sql)->fetch_assoc();
	} else {
		echo 'Không tồn tại';
	}



	if (!empty($_POST)) {
		$title = $_POST['title'];
		$ordering = $_POST['ordering'];
		$type = $_POST['type'];
		$status = $_POST['status'];
		$content = $_POST['content'];
		if (!empty($_FILES['hinh_anh']['name'])) {
			$image = time() . '_' . $_FILES['hinh_anh']['name'];
			if ($image != $images['img_link']) {
				if ($images['type'] == 0) {
					unlink('public/image/slider/' . $images['img_link']);
					move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/slider/' . $image);
				} elseif ($images['type'] == 1) {
					unlink('public/image/banner/' . $images['img_link']);
					move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/banner/' . $image);
				} elseif ($images['type'] == 2) {
					unlink('public/image/post/' . $images['img_link']);
					move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/post/' . $image);
				} elseif ($images['type'] == 3) {
					unlink('public/image/icon-img/' . $images['img_link']);
				}
			}
			if ($type == 0) {
				move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/slider/' . $image);
			} elseif ($type == 1) {
				move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/banner/' . $image);
			} else {
				move_uploaded_file($_FILES['hinh_anh']['tmp_name'], 'public/image/post/' . $image);
			}
		} else {
			$image = $images['img_link'];
		}

		$sql = "UPDATE image SET title = '$title', content='$content', img_link ='$image', ordering ='$ordering', type ='$type', status='$status' WHERE id =$id";
		// echo $sql;
		execute($sql);
		header("Location: image.php?name=image");
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
				<h6 class="m-0 font-weight-bold text-primary">Sửa hình ảnh</h6>
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
												<input type="text" class="form-control" id="pro_price" name="title" value="<?php echo $images['title'] ?>">
											</div>
											<div class="form-group price">
												<label for="pro_saleprice">Thứ tự</label>
												<input type="text" class="form-control" id="pro_saleprice" name="ordering" value="<?php echo $images['ordering'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Loại ảnh</label>
												<select class="form-control" name="type">
													<option value="0" <?php echo $images['type'] == 0 ? 'selected' : "" ?>>Slide</option>
													<?php if ($images['type'] == 1) { ?>
														<option value="1" selected>Banner</option>
													<?php } ?>
													<option value="2" <?php echo $images['type'] == 2 ? 'selected' : "" ?>>Post</option>
												</select>
											</div>
											<div class="form-group">
												<label for="">Trạng thái</label>
												<select class="form-control" name="status">
													<option value="0" <?php echo $images['status'] == 0 ? 'selected' : "" ?>>Hiện</option>
													<option value="1" <?php echo $images['status'] == 1 ? 'selected' : "" ?>>Ẩn</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Nội dung</label>
												<textarea class="form-control" id="desc" rows="3" name="content"><?php echo $images['content']; ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="hinh_anh" class="w-100">Hình ảnh
											<input type="file" name="hinh_anh" value="" class="d-none" id="hinh_anh" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
											<div class="text-center">
												<?php if ($images['type'] == 0) { ?>
													<img id="blah" src="public/image/slider/<?php echo $images['img_link']; ?>" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
												<?php } elseif ($images['type'] == 1) { ?>
													<img id="blah" src="public/image/banner/<?php echo $images['img_link']; ?>" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
												<?php } elseif ($images['type'] == 2) { ?>
													<img id="blah" src="public/image/post/<?php echo $images['img_link']; ?>" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
												<?php } elseif ($images['type'] == 3) { ?>
													<img id="blah" src="public/image/icon-img/<?php echo $images['img_link']; ?>" alt="" class="img-fluid m-auto" style="display: block; height: 250px; background: url(http://www.iconhot.com/icon/png/devine/256/picture-2.png) no-repeat center;">
												<?php } ?>
											</div>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-12 text-center">
								<button type="submit" class="btn btn-success m-2">Sửa Hình ảnh</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
<?php } elseif ($action == "new") { ?>
	<?php
	if (isset($_GET['id'])) {

		$id = $_GET['id'];

		$news = execute("SELECT * FROM news WHERE id = $id")->fetch_assoc();
	} else {
		echo 'Không tồn tại';
	}

	if (!empty($_POST)) {
		$title = $_POST['name'];
		$content = $_POST['content'];
		$status = $_POST['status'];
		$ordering = $_POST['ordering'];
		$sql = "UPDATE news SET title = '$title', content = '$content', ordering = '$ordering', status = '$status' WHERE id = $id";
		$result = execute($sql);
		if ($result) {
			header('location: news.php?name=news');
		} else {
			echo "Thêm mới không thành công";
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
				<h6 class="m-0 font-weight-bold text-primary">Sửa tin</h6>
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
												<input type="text" class="form-control" id="pro_price" name="name" value="<?php echo $news['title']; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Thứ tự</label>
												<input type="text" class="form-control" id="pro_price" name="ordering" value="<?php echo $news['ordering']; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="">Trạng thái</label>
												<select class="form-control" name="status">
													<option value="0" <?php echo $news['ordering'] == 0 ? "selected" : ''; ?>>Hiện</option>
													<option value="1" <?php echo $news['ordering'] == 1 ? "selected" : ''; ?>>Ẩn</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="content">Tiểu sử</label>
												<textarea class="form-control" id="content" rows="3" name="content"><?php echo $news['content']; ?></textarea>
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