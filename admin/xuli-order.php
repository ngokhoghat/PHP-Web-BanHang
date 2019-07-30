<?php
include '../config/funtion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == "check") {
        $result = execute("UPDATE orders SET status = 1 WHERE id = $id");
        if ($result == 1) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            echo $result;
        }
    } else if ($action == "cancer") {
        $result = execute("UPDATE orders SET status = 2 WHERE id = $id");
        if ($result == 1) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            echo $result;
        }
    } else {
        $result = execute("UPDATE orders SET status = 3 WHERE id = $id");
        if ($result == 1) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            echo $result;
        }
    }
}
