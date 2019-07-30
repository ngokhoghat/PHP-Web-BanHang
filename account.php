<?php include 'header.php' ?>

<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#" class="active">profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumbs-area-end -->
<!-- entry-header-area-start -->
<div class="entry-header-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="entry-header-title">
                    <h2><?php echo ($_GET['rl'] == "info") ? "Thông tin khách hàng" : "Lịch sử mua hàng" ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- entry-header-area-end -->
<?php $user = isset($_SESSION['customer']) ? $_SESSION['customer'] : ''; ?>
<?php
if (($_GET['rl'] == "info") && isset($_SESSION['customer'])) { ?>
    <!-- cart-main-area-start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="login-form">
                    <div class="row">
                        <div class="col-md-5" style="border-right: 1px solid rgba(0, 0, 0, 0.12)">
                            <div class="row">
                                <div class="col-md-5">
                                    <div>
                                        <img class="img-responsive thumbnail" src="admin/public/image/1.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div>
                                        <br>
                                        <h6>Họ tên: <?= $user['name'] ?></h6>
                                        <h6>ngày sinh: <?= $user['birthday'] ?></h6>
                                        <h6>email: <?= $user['email'] ?></h6>
                                        <h6>Số điện thoai: <?= $user['phone'] ?></h6>
                                        <h6>Member: <span class="label label-success">New</span></h6>
                                        <h6>
                                            <span class="label label-danger"><i class="fa fa-heart"></i> : 10</span>
                                            <span class="label label-info"><i class="fa fa-thumbs-up"></i> : 4</span>
                                            <span class="label label-primary"><i class="fa fa-shopping-cart"></i> : 4</span>
                                        </h6>
                                    </div>
                                </div>
                                <div class="col-md-12" style="border-top: 1px solid rgba(0, 0, 0, 0.12)">
                                    <br>
                                    <div class="list-group">
                                        <a href="account.php?rl=info&fix=user" class="list-group-item list-group-item-action"><i class="fa fa-info-circle" style="padding: 5px; font-size: 20px; width: 10%"></i>Chỉnh sửa thông tin</a>
                                        <a href="account.php?rl=info&fix=image" class="list-group-item list-group-item-action"><i class="fa fa-image" style="padding: 5px; font-size: 20px; width: 10%"></i>Chỉnh ảnh đại diện</a>
                                        <a href="account.php?rl=info&fix=email" class="list-group-item list-group-item-action"><i class="fa fa-envelope" style="padding: 5px; font-size: 20px;width: 10%"></i>Đổi Email</a>
                                        <a href="account.php?rl=info&fix=pass" class="list-group-item list-group-item-action"><i class="fa fa-unlock-alt" style="padding: 5px; font-size: 20px;width: 10%"></i>Đổi mật khẩu</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <?php
                                $fix = isset($_GET['fix']) ? $_GET['fix'] : '';
                                if ($fix == 'user') { ?>
                                    <div class="col-lg-offset-1 col-lg-10 col-md-offset-1 col-md-6 col-sm-12 col-xs-12">
                                        <div class="login-form">
                                            <?php
                                            $id = $_SESSION['customer']['id'];
                                            if (!empty($_POST)) {
                                                $error = [];
                                                if (!empty($_POST['cus_name'])) {
                                                    $name = $_POST['cus_name'];
                                                } else {
                                                    $error['name'] = "không được để trên trống";
                                                }
                                                if (!empty($_POST['cus_birthday'])) {
                                                    $birthday = $_POST['cus_birthday'];
                                                } else {
                                                    $error['birthday'] = "không được để trên trống";
                                                }
                                                if (!empty($_POST['cus_phone'])) {
                                                    $phone = $_POST['cus_phone'];
                                                } else {
                                                    $error['phone'] = "không được để trên trống";
                                                }
                                                if (!empty($_POST['cus_address'])) {
                                                    $address = $_POST['cus_address'];
                                                } else {
                                                    $error['address'] = "không được để trên trống";
                                                }
                                                $sex = $_POST['cus_sex'];
                                                if (empty($error)) {
                                                    $result = execute("UPDATE account SET name= '$name', phone= '$phone', address= '$address', sex = $sex, birthday = '$birthday' WHERE id = $id");
                                                    if ($result == 1) {
                                                        if (isset($_SESSION['customer'])) {
                                                            unset($_SESSION['customer']);
                                                        }
                                                        if (isset($_SESSION['error'])) {
                                                            unset($_SESSION['error']);
                                                        }
                                                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                                                    }
                                                }
                                            }
                                            ?>
                                            <form action="" method="POST" role="form">
                                                <div class="row">
                                                    <input type="hidden" name="action" value="fix">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                                        <div class="checkout-form-list">
                                                            <label>Họ Tên <span class="required">*</span></label>
                                                            <input type="text" placeholder="" name="cus_name">
                                                            <label style="padding-top: 5px"><span class="required"><?php echo isset($error['name']) ? $error['name'] : '' ?></span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="checkout-form-list">
                                                            <label>Ngày sinh <span class="required">*</span></label>
                                                            <input type="date" placeholder="" name="cus_birthday">
                                                            <label style="padding-top: 5px"><span class="required"><?php echo isset($error['birthday']) ? $error['birthday'] : '' ?></span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="checkout-form-list">
                                                            <label>Giới tính <span class="required">*</span></label>
                                                            <div class="form-group">
                                                                <label for=""></label>
                                                                <select class="form-control" name="cus_sex">
                                                                    <option value="0">Nam</option>
                                                                    <option value="1">Nữ</option>
                                                                    <option value="2">Khác</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="checkout-form-list">
                                                            <label>Số điện thoại <span class="required">*</span></label>
                                                            <input type="" placeholder="" name="cus_phone">
                                                            <label style="padding-top: 5px"><span class="required"><?php echo isset($error['phone']) ? $error['phone'] : '' ?></span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="checkout-form-list">
                                                            <label>Địa chỉ <span class="required">*</span></label>
                                                            <input type="text" placeholder="" name="cus_address">
                                                            <label style="padding-top: 5px"><span class="required"><?php echo isset($error['address']) ? $error['address'] : '' ?></span></label>
                                                            <label class="text-center" style="padding-top: 5px"><span class="required"><?php echo isset($error['mk_name']) ? $error['mk_name'] : '' ?></span></label>
                                                            <h6>Sau khi sửa thông tin hệ thống sẽ tự thoát để cập nhật lại</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-login single-login-2">
                                                    <button type="submit" name="" id="" class="btn btn-primary">Sửa thông tin</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php } else if ($fix == 'image') { ?>
                                    <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-6 col-sm-12 col-xs-12">
                                        <img class="img-responsive" src="admin/public/image/333.jpg" alt="">
                                    </div>
                                <?php } else if ($fix == 'email') { ?>
                                    <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="login-form">
                                            <?php
                                            $get = isset($_GET['check']) ? $_GET['check'] : '';
                                            ?>
                                            <?php if ($get == '') { ?>
                                                <?php
                                                if (!empty($_POST)) {
                                                    $id = $_SESSION['customer']['id'];
                                                    $error = [];
                                                    if (!empty($_POST['u_email'])) {
                                                        $email = $_POST['u_email'];
                                                    } else {
                                                        $error['mail'] = 'Email không được rỗng';
                                                    }
                                                    if (empty($error)) {
                                                        $result = execute("UPDATE account SET email = '$email' WHERE id = $id");
                                                        if ($result == 1) {
                                                            // Gửi mail
                                                            $very_code = time();
                                                            require "config/mail_login.php";
                                                            $title = "Đổi email";
                                                            $mail = send_mail($email, $body, $title);
                                                            if ($mail == true) {
                                                                $_SESSION['cus_change'] = [
                                                                    'email' => $email,
                                                                    'code' => $very_code,
                                                                ];
                                                                header('location: account.php?rl=info&fix=email&check=kiemtra');
                                                            } else {
                                                                $emaill = $_SESSION['customer']['email'];
                                                                execute("UPDATE account SET email = '$emaill' WHERE id = $id");
                                                            }
                                                        } else {
                                                            $error['mail'] = 'Email này đã tồn tại';
                                                        }
                                                    }
                                                } ?>
                                                <form action="" method="POST" role="form">
                                                    <div class="single-login">
                                                        <label>Nhập email mới<span style="color: red; font-size:20px; padding-left: 5px;">*</span></label>
                                                        <input type="email" class="" placeholder="Nhập Email" name="u_email">
                                                        <?php echo isset($error['mail']) ? $error['mail'] : ""; ?>
                                                        <?php echo isset($error['mk_name']) ? $error['mk_name'] : ""; ?>
                                                    </div>
                                                    <button type="submit" name="" id="" class="btn btn-primary">Đổi email</button>
                                                </form>
                                            <?php } else if ($get == 'kiemtra') { ?>
                                                <?php
                                                if (!empty($_POST['u_code'])) {
                                                    $code = $_POST['u_code'];
                                                    if ($_SESSION['cus_change']['code'] == $code) {
                                                        unset($_SESSION['cus_change']);
                                                        header("Location: account.php?rl=info&fix=email&check=checked");
                                                    } else {
                                                        $error = 'code không đúng';
                                                    }
                                                }
                                                ?>
                                                <form action="" method="POST" role="form">
                                                    <div class="single-login">
                                                        <label>Nhập mã xác nhận<span style="color: red; font-size:20px; padding-left: 5px;">*</span></label>
                                                        <input type="text" class="" placeholder="Nhập Email" name="u_code">
                                                    </div>
                                                    <?php echo isset($error) ? $error : ""; ?>
                                                    <button type="submit" name="" id="" class="btn btn-primary">Xác nhận</button>
                                                </form>
                                            <?php } else { ?>
                                                <div class="text-success text-center" style="padding-bottom: 15px; font-size: 20px;">
                                                    <p>Đổi thành công!</p>
                                                    <a href="xuli-account.php?action=logout">Đăng nhập lại để thay đổi</a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } else if ($fix == 'pass') { ?>
                                    <?php if (!empty($_POST)) {
                                        $id = $_SESSION['customer']['id'];
                                        $error = [];
                                        if (!empty($_POST['u_pass'])) {
                                            $pass = md5($_POST['u_pass']);
                                        } else {
                                            $error['pass'] = "Không được để trống";
                                        }
                                        if (!empty($_POST['u_repass'])) {
                                            $repass = md5($_POST['u_repass']);
                                        } else {
                                            $error['u_repass'] = "Không được để trống";
                                        }
                                        if (isset($pass) && isset($repass)) {
                                            if ($pass != $repass) {
                                                $error['u_repass'] = "Mật khẩu nhập lại không đúng";
                                            } else {
                                                execute("UPDATE account SET password = '$repass' WHERE id = $id");
                                                $sucsees = 0;
                                            }
                                        }
                                    } ?>
                                    <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-6 col-sm-12 col-xs-12">
                                        <div class="login-form">
                                            <?php if (!isset($sucsees)) { ?>
                                                <form action="" method="POST" role="form">
                                                    <input type="hidden" name="action" value="fix">
                                                    <div class="single-login">
                                                        <label>Nhập mật khẩu mới<span style="color: red; font-size:20px; padding-left: 5px;">*</span></label>
                                                        <input type="password" class="" placeholder="Nhập Email hoặc Số điện thoại..." name="u_pass">
                                                        <?php echo isset($error['pass']) ? $error['pass'] : "" ?>
                                                    </div>
                                                    <div class="single-login">
                                                        <label>Nhập lại mật khẩu mới<span style="color: red; font-size:20px; padding-left: 5px;">*</span></label>
                                                        <input type="password" class="" placeholder="Nhập Email hoặc Số điện thoại..." name="u_repass">
                                                        <?php echo isset($error['u_repass']) ? $error['u_repass'] : "" ?>
                                                    </div>
                                                    <button type="submit" name="" id="" class="btn btn-primary">Đổi mật khẩu</button>
                                                </form>
                                            <?php }else { ?>
                                                <div class="text-success text-center" style="padding-bottom: 15px; font-size: 20px;">
                                                    <p>Đổi Mật khẩu thành công!</p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-6 col-sm-12 col-xs-12">
                                        <img class="img-responsive" src="admin/public/image/1234.png" alt="">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-main-area-end -->
<?php } else if (($_GET['rl'] == "ckeckouthistory") && isset($_SESSION['customer'])) { ?>
    <!-- cart-main-area-start -->
    <?php
    if (isset($_SESSION['customer'])) {
        $id = $_SESSION['customer']['id'];
        $sql = "SELECT o.*, SUM(dt.price*dt.quantity) total 
                FROM orders o 
                JOIN orders_detail dt ON o.id = dt.orders_id 
                WHERE o.id = dt.orders_id AND o.acc_id = $id
                GROUP BY o.id
                ORDER BY o.id DESC";

        $result = execute($sql)->fetch_all(MYSQLI_ASSOC);
    }
    ?>
    <div class="cart-main-area mb-70" id="cart-account">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-content table-responsive">
                        <table class="table table-hover table-inverse table-responsive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày đặt</th>
                                    <th>Người nhận</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $key => $value) { ?>
                                    <tr class="clickable" data-toggle="collapse" data-target="#group-of-rows-<?php echo $key + 1 ?>" aria-expanded="false" aria-controls="group-of-rows-1">
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo $value['created'] ?></td>
                                        <td><?php echo $value['name'] ?></td>
                                        <td><?php echo $value['phone'] ?></td>
                                        <td><?php echo $value['address'] ?></td>
                                        <td class="price"><?php echo $value['total'] ?></td>
                                        <td>
                                            <?php if ($value['status'] == 0) { ?>
                                                <h4><span class="label label-danger"><i class="fa fa-times"></i> Chờ duyệt</span></h4>
                                            <?php } else if ($value['status'] == 1) { ?>
                                                <h4><span class="label label-success"><i class="fa fa-check"></i> Đang giao hàng</span></h4>
                                            <?php } else if ($value['status'] == 2) { ?>
                                                <h4><span class="label label-info"><i class="fa fa-check"></i> Đã giao hàng</span></h4>
                                            <?php } else { ?>
                                                <h4><span class="label label-default"><i class="fa fa-times"></i> Đã Hủy</span></h4>
                                            <?php } ?>
                                        </td>
                                        <td><a>Xem chi tiết</a></td>
                                    </tr>
                                <tbody id="group-of-rows-<?php echo $key + 1 ?>" class="collapse">
                                    <tr>
                                        <th></th>
                                        <th class="text-center">STT</th>
                                        <th class="text-center">Hình ảnh</th>
                                        <th class="text-center">Tên sản phẩm</th>
                                        <th class="text-center">Giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Tổng tiền</th>
                                        <th></th>
                                    </tr>
                                    <?php
                                    $order_id = $value['id'];
                                    $product = execute("SELECT dt.*, p.name,p.anh_bia FROM orders_detail dt
                                JOIN product p ON p.id = dt.prod_id
                                WHERE orders_id = $order_id");
                                    foreach ($product as $key => $value) { ?>
                                        <tr class="text-center">
                                            <td></td>
                                            <td><?php echo $key + 1 ?></td>
                                            <td><img src="admin/public/image/product/<?php echo $value['anh_bia'] ?>" alt="" width="60"></td>
                                            <td><?php echo $value['name'] ?></td>
                                            <td class="price"><?php echo $value['price'] ?></td>
                                            <td><?php echo $value['quantity'] ?></td>
                                            <td class="price"><?php echo $value['quantity'] * $value['price'] ?></td>
                                            <td></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-main-area-end -->
<?php } else {
    header('location: index.php');
} ?>
?>


<?php include 'footer.php' ?>