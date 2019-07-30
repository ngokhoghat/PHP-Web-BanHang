<?php include '../config/funtion.php'; ?>

<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="public/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>
<?php
if (isset($_GET['action'])) {
    // session_destroy();
    unset($_SESSION['admin']);
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
}

if (!empty($_POST)) {
    $error = [];
    if (!empty($_POST['u_name'])) {
        $u_name = $_POST['u_name'];
    }else{
        $error['name'] = "Không được để rỗng !";
    }
    if (!empty($_POST['u_pass'])) {
        $u_pass = md5($_POST['u_pass']);
    }else{
        $error['pass'] = "Không được để rỗng !";
    }
    if (empty($error)) {
        $result = execute("SELECT * FROM account WHERE (email = '$u_name' or phone = '$u_name') and password = '$u_pass'")->fetch_assoc();
        if ($result) {
            $_SESSION['admin'] = $result;
            header("Location: index.php");
        }else {
            $error['pass'] = "Sai thông tin tài khoản";
        }
    }
}
?>

<body class="">
    <!-- bg-gradient-primary -->
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Trang đăng nhập</h1>
                                    </div>
                                    <form action="" method="POST" class="user" id="login">
                                        <div class="form-group">
                                            <input type="email" name="u_name" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nhập email hoặc số điện thoại...">
                                            <?php if (isset($error['name'])) { ?>
                                                <p class="text-danger text-center"><?php echo $error['name']; ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="u_pass" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mật khẩu">
                                            <?php if (isset($error['pass'])) { ?>
                                                <p class="text-danger text-center"><?php echo $error['pass']; ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Nhớ mật khẩu</label>
                                            </div>
                                        </div>
                                        <a href="javascript:{}" onclick="document.getElementById('login').submit();" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="public/vendor/jquery/jquery.min.js"></script>

    <script src="public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="public/tinymce/tinymce.min.js"></script>
    <script src="public/tinymce/config.js"></script>
    <script type="text/javascript" src="public/autoNumeric/autoNumeric-2.0-BETA.js"></script>

</body>

</html>