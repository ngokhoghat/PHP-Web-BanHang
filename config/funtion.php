<?php
session_start();
include 'connect.php';


// Hàm thực thi
function execute($sql)
{
    global $conn;
    $result = $conn->query($sql);
    if ($result) {
        return $result;
    } else {
        return $conn->error;
    }
}

// Hàm phân trang
function pagination($sql, $vitri, $limit)
{
    if ($vitri > -1 && $limit > 1) {
        $sql .= " LIMIT $vitri,$limit";
    }
    $result = execute($sql);
    return $result;
}

// Hàm menu đa cắp
function menu($menulist, $paren_id)
{
    $menutree = [];
    foreach ($menulist as $key => $menu) {
        if ($menu['parent_id'] == $paren_id) {
            $children = menu($menulist, $menu['id']);
            if ($children) {
                $menu['children'] = $children;
            }
            $menutree[] = $menu;
            unset($menulist[$key]);
        }
    }
    return $menutree;
}
function showmenu($list, $num)
{
    $num++;
    foreach ($list as $item) {
        echo "<option value=" . $item['id'] . ">" . str_repeat("---", $num - 1) . $item['name'] . "</option>";
        if (!empty($item['children'])) {
            showmenu($item['children'], $num);
        }
    }
}

// Hàm lọc
function loc($min, $max)
{
    $contant = [];
    for ($i = $min; $i <= $max; $i++) {
        $contant[$i] = $i;
    }
    return $contant;
}
// Hàm lấy sản phẩm ngẫu nhiên > 3
function show_pro($random)
{

    $random_loc = array_rand($random, 1);
    $random_pro1 = execute("SELECT p.id FROM product p,category c WHERE p.cate_id = c.id and c.id = $random_loc")->fetch_all(MYSQLI_ASSOC);
    $dem = count($random_pro1);
    if ($dem < 3) {
        return show_pro($random);
    } else {
        return $random_loc;
    }
}

// Hàm gủi mail
function send_mail($cus_email, $message, $title)
{
    require 'mail/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->CharSet = "UTF-8";
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'ngokhoghat@gmail.com';                 // SMTP username
    $mail->Password = 'ngoc1997';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->From = 'ngokhoghat@gmail.com';
    $mail->FromName = 'Shopping Mail';
    $mail->addAddress($cus_email, 'Tên người nhận');     // Add a recipient
    // $mail->addAddress('ngokhoghat@gmail.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $title;
    $mail->Body    =  $message;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}


// Hàm rút gọn str
function get_str($str, $cont)
{
    if (strlen($str) > $cont) {
        $sub_str = substr($str, 0, $cont);
        $sub_str .= '...';
    } else {
        $sub_str = $str;
    }
    return $sub_str;
}

// Hàm lấy dữ liệu biểu đồ
function getdata()
{
    $data = [];
    for ($i = 1; $i <= 12; $i++) {
        $firstDayUTS = mktime(0, 0, 0, $i, 1, date("Y"));
        $lastDayUTS = mktime(0, 0, 0, $i, date('t'), date("Y"));
        $firstDay = date("Y-m-d", $firstDayUTS);
        $lastDay = date("Y-m-d", $lastDayUTS);

        $total_month = execute("SELECT SUM(dt.price*dt.quantity) total_month FROM orders o
                                JOIN orders_detail dt ON dt.orders_id = o.id
                                WHERE o.created > '$firstDay' AND o.created < '$lastDay' AND o.status = 3")->fetch_assoc();
        $data[] = $total_month['total_month'];
    }
   return $data;
}

