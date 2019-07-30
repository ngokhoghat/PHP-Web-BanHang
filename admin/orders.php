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
$sql = "SELECT o.*, a.email u_email, a.name u_name, a.phone u_phone FROM orders o
        JOIN account a ON a.id = o.acc_id
        WHERE o.name like '%$search%'
        ORDER BY o.id DESC";

$orders = pagination($sql, $from, $sotinmottrang)->fetch_all(MYSQLI_ASSOC);


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
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="dataTables_length" id="dataTable_length">
                                <label>Show
                                    <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm" onchange="(window.location.assign('orders.php?name=<?php echo $name ?>&search_value=<?php echo $search ?>&page=<?php echo $trang ?>&sotinmottrang='+this.value))">
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
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover dataTable" id="dataTable">
                                <thead>
                                    <tr class="text-center text-nowrap">
                                        <th>STT</th>
                                        <th>Thông tin người mua</th>
                                        <th>Thông tin người nhận</th>
                                        <th>Chi tiết đơn hàng</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-nowrap" id="order-price">
                                    <?php foreach ($orders as $key => $value) : ?>
                                        <tr>
                                            <td class="text-center"><?php echo $key + 1; ?></td>
                                            <td>
                                                <p>Tên người mua: <?php echo $value['u_name']; ?></p>
                                                <p>Email: <?php echo $value['u_email']; ?></p>
                                                <p>phone: <?php echo $value['u_phone']; ?></p>
                                            </td>
                                            <td>
                                                <p>Tên người nhận: <?php echo $value['name']; ?></p>
                                                <p>phone: <?php echo $value['phone']; ?></p>
                                                <p>Địa chỉ: <?php echo $value['address']; ?></p>
                                            </td>
                                            <?php
                                            $id = $value['id'];
                                            $orders_dt = execute("SELECT dt.*, p.name FROM orders_detail dt JOIN product p ON p.id = dt.prod_id WHERE orders_id = $id")->fetch_all(MYSQLI_ASSOC);
                                            ?>
                                            <td>
                                                <p>Ngày đặt: <?php echo ($value['created']); ?></p>
                                                <?php $total_order = execute("SELECT SUM(dt.quantity*dt.price) total FROM orders_detail dt WHERE dt.orders_id = $id")->fetch_assoc(); ?>
                                                <p>Tổng giá đơn hàng: <span class="price bg-success text-light"><?php echo $total_order['total']; ?></span></p>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($value['status'] == 0) { ?>
                                                    <h6><span class="badge badge-danger"><i class="fa fa-times"></i> Chờ duyệt</span></h6>
                                                <?php } else if ($value['status'] == 1) { ?>
                                                    <h6><span class="badge badge-success"><i class="fa fa-check"></i> Đang giao hàng</span></h6>
                                                <?php } else if ($value['status'] == 2) { ?>
                                                    <h6><span class="badge badge-secondary"><i class="fa fa-times"></i> Đã hủy</span></h6>
                                                <?php } else { ?>
                                                    <h6><span class="badge badge-info"><i class="fa fa-thumbs-up"></i> Đã giao hàng</span></h6>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php if ($value['status'] == 0) { ?>
                                                    <p><a style="width: 100%" href="xuli-order.php?action=check&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-primary" title="Sửa"><i style="width: 20%; float: left" class="pt-1 fa fa-check"></i>Duyệt</a></p>
                                                    <p><a style="width: 100%" href="xuli-order.php?action=cancer&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-danger" title="Xóa"><i style="width: 20%; float: left" class="pt-1 fa fa-times"></i>Hủy</a></p>
                                                    <p><a style="width: 100%" href="view.php?name=order&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-success" title="Chi tiết"><i style="width: 20%; float: left" class=" pt-1 far fa-eye"></i>Xem</a></p>
                                                <?php } elseif ($value['status'] == 1) { ?>
                                                    <p><a style="width: 100%" href="xuli-order.php?action=checked&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-primary" title="Sửa"><i style="width: 20%; float: left" class="pt-1 fa fa-check"></i>Đã giao hàng</a></p>
                                                    <p><a style="width: 100%" href="view.php?name=order&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-success" title="Chi tiết"><i style="width: 20%; float: left" class=" pt-1 far fa-eye"></i>Xem</a></p>
                                                <?php } else { ?>
                                                    <p><a style="width: 100%" href="view.php?name=order&id=<?php echo $value['id'] ?>" class="btn btn-sm btn-success" title="Chi tiết"><i style="width: 20%; float: left" class=" pt-1 far fa-eye"></i>Xem</a></p>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $orders = execute("SELECT id FROM orders WHERE name like '%$search%'");

                        $sotrang = ceil(($orders->num_rows) / $sotinmottrang);
                        ?>
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTable_info">Hiển thị <?php echo $sotinmottrang ?> trong <?php echo $orders->num_rows; ?> kết quả</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous <?php if ($_GET['page'] <= 1) echo 'disabled' ?>" id="dataTable_previous">
                                        <a href="orders.php?name=orders&page=<?php echo $_GET['page'] - 1 ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
                                    </li>
                                    <?php for ($i = 1; $i < $sotrang + 1; $i++) { ?>
                                        <li class="paginate_button page-item <?php if ($trang == $i) echo 'active'; ?>">
                                            <a href="orders.php?name=orders&page=<?php echo $i ?>&sotinmottrang=<?php echo $sotinmottrang; ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link"><?php echo $i; ?></a>
                                        </li>


                                    <?php } ?>
                                    <li class="paginate_button page-item next <?php if ($_GET['page'] == $sotrang) echo 'disabled' ?>" id="dataTable_next">
                                        <a href="orders.php?name=orders&page=<?php echo $_GET['page'] + 1; ?>&sotinmottrang=<?php echo $sotinmottrang; ?>&search_value=<?php echo $search ?>" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
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
    $("#search_btn").click(function() {
        $("#search_btn").attr({
            'href': "orders.php?name=orders&search_value=" + search.value
        })
    });
</script>