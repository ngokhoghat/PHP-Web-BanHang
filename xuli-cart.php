<?php 
    include 'config/connect.php';
    include 'config/funtion.php';
    // session_start();
    $id = isset($_GET['id'])? $_GET['id'] : 0;
    $action = isset($_GET['action'])? $_GET['action'] : 'add';
    $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
    $result = execute("SELECT * FROM product WHERE id = $id")->fetch_assoc();
    $price = ($result['sale_price'] > 0) ? $result['sale_price'] : $result['price'];
    $total_cart = 0;

    if ($action == 'add') {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
            $_SESSION['cart'][$id]['total_price'] = $price * $_SESSION['cart'][$id]['quantity'];
        }else {
            $cart = [
                'id' => $result['id'],
                'name' => $result['name'],
                'image' => $result['anh_bia'],
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $price * $quantity,
            ];
            $_SESSION['cart'][$id] = $cart;
        }
        echo '<pre>';
        print_r($_SESSION['cart']);
        echo '</pre>';
        foreach ($_SESSION['cart'] as $key => $value) {
            $total_cart += $value['total_price'];
        }
        $_SESSION['total_cart'] = $total_cart;
    }
    if ($action == 'remove') {
        if (isset($_SESSION['cart'][$id])) {
           unset($_SESSION['cart'][$id]);
        }
        echo '<pre>';
        print_r($_SESSION['cart']);
        echo '</pre>';
        foreach ($_SESSION['cart'] as $key => $value) {
            $total_cart += $value['total_price'];
        }
        $_SESSION['total_cart'] = $total_cart;
    }
    if ($action == 'clear') {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
         }
         $_SESSION['total_cart'] = $total_cart;
    }
    if ($action == 'update') {
        print_r($_GET['id_up']);
        print_r($_GET['qtt_up']);
       $qtt_up = isset($_GET['qtt_up'])? $_GET['qtt_up']: 1;
       $id_up = isset($_GET['id_up'])? $_GET['id_up'] : 1;

       for ($i=0; $i < count($qtt_up); $i++) { 
            if (isset($_SESSION['cart'][$id_up[$i]])) {
                $_SESSION['cart'][$id_up[$i]]['quantity'] = $qtt_up[$i];
                $_SESSION['cart'][$id_up[$i]]['total_price'] = $_SESSION['cart'][$id_up[$i]]['price'] * $_SESSION['cart'][$id_up[$i]]['quantity'];
            }
       }
       foreach ($_SESSION['cart'] as $key => $value) {
        $total_cart += $value['total_price'];
        }
        $_SESSION['total_cart'] = $total_cart;
    }
    echo '<pre>';
    print_r($_SESSION['cart']);
    echo '</pre>';
    header('location: cart.php');
?>