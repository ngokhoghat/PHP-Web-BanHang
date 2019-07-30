<?php
include'header.php'; 

$name = $_GET['name'];

if (isset($_GET["sotinmottrang"])) {
	$sotinmottrang = $_GET['sotinmottrang'];
}else {
	$sotinmottrang = 10;
}

if (isset($_GET['page'])) {
	$trang = $_GET["page"];
}else {
	$trang = 1;
}

$from = ($trang - 1)*$sotinmottrang;

$search = '';
if (isset($_GET['search_value'])) {
	$search = $_GET['search_value'];
}
$sql = "SELECT c.*, d.name as paren_name FROM category c 
        LEFT JOIN category d ON d.id = c.parent_id
        WHERE c.name like '%$search%'";



$category = pagination($sql, $from, $sotinmottrang)->fetch_all(MYSQLI_ASSOC);


// echo "<pre>";
// print_r($category);
// echo "</pre>";
// $category = execute("SELECT * FROM category");



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
			<h6 class="m-0 font-weight-bold text-primary">Danh sách Nhà Xuất Bản</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
					<div class="row">
						<div class="col-sm-12 col-md-4">
							<div class="dataTables_length" id="dataTable_length">
								<label>Show 
									<select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm" onchange="(window.location.assign('<?php echo $name;?>.php?name=<?php echo $name?>&search_value=<?php echo $search?>&page=<?php echo $trang?>&sotinmottrang='+this.value))">
										<?php for ($i = 10; $i <= 20; $i+= 10) {?>
											<option value="<?php echo $i;?>" <?php if($sotinmottrang == $i) echo 'selected'; ?>><?php echo $i;?></option>
										<?php } ?>
									</select> entries
								</label>
							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div class="input-group mb-3">
								<input id="search" type="text" class="form-control" name="search_value" placeholder="Tìm kiếm ..." aria-label="Recipient's username" aria-describedby="button-addon2">
								<div class="input-group-append">
									<a id="search_btn" class="btn btn-primary" href="" ><i class="fas fa-search"></i></a>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-md-4">
							<div id="dataTable_filter" class="dataTables_filter">
								<a href="addnew.php?name=category" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i> Thêm Mới</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-bordered table-hover dataTable" id="dataTable">
								<thead>
									<tr class="text-center">
										<th>STT</th>
										<th>Tên danh mục</th>
										<th>Thuộc danh mục</th>
										<th></th>
									</tr>
								</thead>
								<tbody id="price">
									<?php foreach ($category as $key => $value): ?>
										<tr>
											<td class="text-center"><?php echo $key + 1; ?></td>
											<td><?php echo $value['name']; ?></td>
											<td><?php echo $value['paren_name']; ?></td>
											<td style="text-align: center;">
												<a href="edit.php?name=category&id=<?php echo $value['id']?>" class="btn btn-sm btn-primary" title="Sửa"><i class="far fa-edit"></i></a>
												<a href="delete-pro.php?id_category=<?php echo $value['id']?>" class="btn btn-sm btn-danger" title="Xóa"><i class="far fa-trash-alt"></i></a>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<?php 
							$category = execute("SELECT id FROM $name WHERE $name.name like '%$search%'");
							$sotrang = ceil(($category->num_rows)/ $sotinmottrang);
						?>
						<div class="col-sm-12 col-md-5">
							<div class="dataTables_info" id="dataTable_info">Hiển thị <?php echo $sotinmottrang ?> trong <?php echo $category->num_rows; ?> kết quả</div>
						</div>
						<div class="col-sm-12 col-md-7">
							<div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
								<ul class="pagination">
									<li class="paginate_button page-item previous <?php if($_GET['page'] <= 1)echo 'disabled' ?>" id="dataTable_previous">
										<a href="category.php?name=category&page=<?php echo $_GET['page'] - 1?>&search_value=<?php echo $search?>" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
									</li>
									<?php	for ($i = 1; $i < $sotrang + 1; $i++) { ?>
											<li class="paginate_button page-item <?php if($trang == $i)echo 'active'; ?>">
												<a href="category.php?name=category&page=<?php echo $i?>&sotinmottrang=<?php echo $sotinmottrang;?>&search_value=<?php echo $search?>" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $i; ?></a>
											</li>
											
										
									<?php } ?>
									<li class="paginate_button page-item next <?php if($_GET['page'] == $sotrang)echo 'disabled' ?>" id="dataTable_next">
										<a href="category.php?name=category&page=<?php echo $_GET['page'] + 1;?>&sotinmottrang=<?php echo $sotinmottrang;?>&search_value=<?php echo $search?>" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
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

<?php include'footer.php'; ?>
<script>
	$('#price span').autoNumeric("init",{
		aSign:' đ',
		pSign:'s',
		mDec: '0'
	});
	$("#search_btn").click(function() {
		$("#search_btn").attr({'href': "<?php echo $name;?>.php?name=<?php echo $name;?>&search_value="+search.value})
	});
</script>