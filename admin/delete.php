<?php include "header.php" ?>

<?php

if (isset($_GET['id'])) {

	// Xóa sản phẩm
	$id = $_GET['id'];

	$res = execute("SELECT anh_phu,anh_bia FROM product WHERE id = $id")->fetch_assoc();

	unlink('public/image/product/' . $res['anh_bia']);

	if ($res['anh_phu'] != '') {
		$img = json_decode($res['anh_phu']);
		foreach ($img as $key => $value) {
			unlink('public/image/product/' . $value);
		}
	} else {
		echo 'False';
	}
	$sql = "DELETE FROM product WHERE id = $id";

	execute($sql);

	header("Location: product.php?name=product");
} else if (isset($_GET['data'])) {
	// Xóa ảnh sản phẩm
	$id = $_GET['data'];

	$res = execute("SELECT anh_phu FROM product WHERE id = $id")->fetch_assoc();
	if (is_array($res)) {
		$img = json_decode($res['anh_phu']);
		foreach ($img as $key => $value) {
			unlink('public/image/product/' . $value);
		}
	} else {
		echo 'a';
	}

	$sql = "UPDATE product SET anh_phu = '' WHERE id = $id";
	execute($sql);

	header("Location: edit-pro.php?id=$id");
} else if (isset($_GET['id_tacgia'])) {
	// Xóa tác giả
	$id = $_GET['id_tacgia'];

	$res = execute("SELECT hinh_anh FROM tacgia WHERE id = $id")->fetch_assoc();

	unlink('public/image/author/' . $res['hinh_anh']);

	$sql = "DELETE FROM tacgia WHERE id = $id";

	execute($sql);

	header("Location: tacgia.php?name=tacgia");
} else if (isset($_GET['id_nxb'])) {
	// Xóa NXB
	$id = $_GET['id_nxb'];

	$sql = "DELETE FROM nxb WHERE id = $id";

	execute($sql);

	header("Location: nxb.php?name=nxb");
} else if (isset($_GET['id_category'])) {
	// Xóa category
	$id = $_GET['id_category'];

	$sql = "DELETE FROM category WHERE id = $id";

	$result =  execute($sql);
	if ($result == 1) {
		header("Location: category.php?name=category");
	} else {
		echo "Không thể xóa danh mục này";
		echo "(Phải xóa danh mục con trước khi xóa danh mục cha)";
	}
} else if (isset($_GET['id_image'])) {
	// Xóa category
	$id = $_GET['id_image'];

	$sql = "DELETE FROM image WHERE id = $id";

	$result =  execute($sql);
	if ($result == 1) {
		header("Location: image.php?name=image");
	} else {
		echo "Không thể xóa danh mục này";
	}
} else if (isset($_GET['id_news'])) {
	// Xóa category
	$id = $_GET['id_news'];

	$sql = "DELETE FROM news WHERE id = $id";

	$result =  execute($sql);
	if ($result == 1) {
		header("Location: news.php?name=news");
	} else {
		echo "Không thể xóa danh mục này";
	}
} else {
	echo 'Không tồn tại';
}

?>

<?php include "footer.php" ?>