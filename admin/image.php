<?php
include 'header.php';

$name = $_GET['name'];

if (isset($_GET["sotinmottrang"])) {
	$sotinmottrang = $_GET['sotinmottrang'];
} else {
	$sotinmottrang = 10;
}

if (isset($_GET['page'])) {
	$trang = $_GET["page"];
} else {
	$trang = 1;
}

$from = ($trang - 1) * $sotinmottrang;

$search = '';
if (isset($_GET['search_value'])) {
	$search = $_GET['search_value'];
}
$sql = "SELECT * FROM image
		WHERE title like '%$search%' ORDER BY id DESC";



$image = pagination($sql, $from, $sotinmottrang);

$category = execute("SELECT * FROM category");



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
			<h6 class="m-0 font-weight-bold text-primary">Danh sách hình ảnh</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
					<div class="row">
						<div class="col-sm-12 col-md-4">
							<div class="dataTables_length" id="dataTable_length">
								<label>Show
									<select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm" onchange="(window.location.assign('image.php?name=<?php echo $name ?>&search_value=<?php echo $search ?>&page=<?php echo $trang ?>&sotinmottrang='+this.value))">
										<?php for ($i = 10; $i <= 20; $i += 10) { ?>
											<option value="<?php echo $i; ?>" <?php if ($sotinmottrang == $i) echo 'selected'; ?>><?php echo $i; ?></option>
										<?php } ?>
									</select> entries
								</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div class="input-group mb-3">
								<input id="search" type="text" class="form-control" name="search_value" placeholder="Tìm kiếm ..." aria-label="Recipient's username" aria-describedby="button-addon2">
								<div class="input-group-append">
									<a id="search_btn" class="btn btn-primary" href=""><i class="fas fa-search"></i></a>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-4 mb-2">
							<div id="dataTable_filter" class="dataTables_filter">
								<a href="addnew.php?name=image" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Thêm Mới</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr class="text-center text-nowrap">
											<th>STT</th>
											<th class="">Tiêu đề</th>
											<th>Hình ảnh</th>
											<th>Nội dung</th>
											<th>Kiểu</th>
											<th>Trạng thái</th>
											<th></th>
										</tr>
									</thead>
									<tbody id="price">
										<?php foreach ($image as $key => $value) : ?>
											<tr class="text-center">
												<td><?php echo $key + 1; ?></td>
												<td><?php echo $value['title']; ?></td>
												<td>
													<?php if ($value['type'] == 0) { ?>
														<img src="<?php echo 'public/image/slider/' . $value['img_link']; ?>" alt="" width="250px;">
													<?php } else if ($value['type'] == 1) { ?>
														<img src="<?php echo 'public/image/banner/' . $value['img_link']; ?>" alt="" width="250px;">
													<?php } else if ($value['type'] == 2) { ?>
														<img src="<?php echo 'public/image/post/' . $value['img_link']; ?>" alt="" width="250px;">
													<?php } else if ($value['type'] == 3) { ?>
														<img src="<?php echo 'public/image/icon-img/' . $value['img_link']; ?>" alt="" width="50px;">
													<?php } ?>
												</td>
												<td><?php echo $value['content']; ?></td>
												<td>
													<?php if ($value['type'] == 0) {
														echo "slider";
													} else {
														echo "banner";
													} ?>
												</td>
												<td>
													<?php if ($value['status'] == 0) {
														echo "Hiện";
													} else {
														echo "Ẩn";
													} ?>
												</td>
												<td style="text-align: center;">
													<?php if ($value['type'] != 3) { ?>
														<a href="edit.php?name=image&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-primary mt-1 mb-1" title="Sửa"><i class="far fa-edit"></i></a>
														<a href="delete.php?&id_image=<?php echo $value['id'] ?>" class="btn btn-sm btn-danger" title="Xóa"><i class="far fa-trash-alt"></i></a>
													<?php } else { ?>
														<a href="edit.php?name=image&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-primary mt-1 mb-1" title="Sửa"><i class="far fa-edit"></i></a>
													<?php } ?>
												</td>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<?php
						$image = execute("SELECT id FROM image WHERE title like '%$search%'");

						$sotrang = ceil(($image->num_rows) / $sotinmottrang);
						?>
						<div class="col-sm-12 col-md-5">
							<div class="dataTables_info" id="dataTable_info">Hiển thị <?php echo $sotinmottrang ?> trong <?php echo $image->num_rows; ?> kết quả</div>
						</div>
						<div class="col-sm-12 col-md-7">
							<div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
								<ul class="pagination">
									<li class="paginate_button page-item previous <?php if ($_GET['page'] <= 1) echo 'disabled' ?>" id="dataTable_previous">
										<a href="image.php?name=image&page=<?php echo $_GET['page'] - 1 ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
									</li>
									<?php for ($i = 1; $i < $sotrang + 1; $i++) { ?>
										<li class="paginate_button page-item <?php if ($trang == $i) echo 'active'; ?>">
											<a href="image.php?name=image&page=<?php echo $i ?>&sotinmottrang=<?php echo $sotinmottrang; ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $i; ?></a>
										</li>
									<?php } ?>
									<li class="paginate_button page-item next <?php if ($_GET['page'] == $sotrang) echo 'disabled' ?>" id="dataTable_next">
										<a href="image.php?name=image&page=<?php echo $_GET['page'] + 1; ?>&sotinmottrang=<?php echo $sotinmottrang; ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.container-fluid -->

<?php include 'footer.php'; ?>
<script>
	$('#price span').autoNumeric("init", {
		aSign: ' đ',
		pSign: 's',
		mDec: '0'
	});
	$("#search_btn").click(function() {
		$("#search_btn").attr({
			'href': "image.php?name=image&search_value=" + search.value
		})
	});
</script>