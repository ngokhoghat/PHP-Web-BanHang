<?php
include "config/connect.php";
include "config/funtion.php";

session_start();

$action = isset($_POST['action']) ? $_POST['action'] : 'login';


if ($action == 'login') {
    $name = $_POST['u_name'];
    $pass = md5($_POST['u_pass']);
    $result = execute("SELECT * FROM account WHERE (email = '$name' or phone = '$name') and password = '$pass'")->fetch_assoc();
    if ($result) {
        $_SESSION['customer'] = $result;
        if (isset($_SESSION['error'])) {
            unset($_SESSION['error']);
        }
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
        $_SESSION['error'] = 'Đăng nhập thất bại!';
        header("Location: login.php");
    }
}
if (isset($_GET['action']) == 'logout') {
    if (isset($_SESSION['customer'])) {
        unset($_SESSION['customer']);
    }
    if (isset($_SESSION['error'])) {
        unset($_SESSION['error']);
    }
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

if (isset($_GET['action']) == 'register') {
    if (isset($_SESSION['cus_registe'])) {
        $very_code = $_GET['code_very'];
        $code = $_SESSION['cus_registe']['code'];
        if ($code == $very_code) {
            $name = $_SESSION['cus_registe']['name'];
            $email = $_SESSION['cus_registe']['email'];
            $phone = $_SESSION['cus_registe']['phone'];
            $pass = $_SESSION['cus_registe']['pass'];
            $address = $_SESSION['cus_registe']['address'];
            $sex = $_SESSION['cus_registe']['sex'];
            $birthday = $_SESSION['cus_registe']['birthday'];

            $result = execute("INSERT INTO account ( name, email, phone, password, address, sex, birthday, type)
                                VALUES ( '$name', '$email', '$phone', '$pass', '$address', $sex, '$birthday', '0')");
            if ($result == 1) {
                unset($_SESSION['cus_registe']);
                if (isset($_SESSION['error']['code_uncorect'])) {
                    unset($_SESSION['error']['code_uncorect']);
                }
                header("Location: register.php?checked");
            }
        } else {
            $_SESSION['error']['code_uncorect'] = "Mã xác nhận sai";
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }
}
