<?php
$body = "<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'> 
	<meta content='width=device-width, initial-scale=1' name='viewport'> 
	<meta name='x-apple-disable-message-reformatting'> 
	<meta http-equiv='X-UA-Compatible' content='IE=edge'> 
	<meta content='telephone=no' name='format-detection'> 
	<title>New email template 2019-07-19</title> 
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i' rel='stylesheet'> 
</head>
<body style='margin: 0;padding: 0;'>
	<div style='width: 100%;font-family: arial, sans-serif;background: #EEEEEE; display: flex;'>
		<div class='content' style='width: 600px;margin: 0 auto;'>
			<div class='top' style='padding: 35px;background: #044767;'>
				<h3 style='margin: 0;padding: 0; color: #ffffff;font-size: 30px;'>Book Stores</h3>
			</div>
			<div class='main' style='text-align: center;background: #ffffff;padding-left: 35px;padding-right: 35px;'>
				<div class='title'>
					<img src='https://dnrmq.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/67611522142640957.png' alt=''>
					<p style='font-weight: bold;font-size: 20px;'>Cảm ơn bạn đã mua hàng!</p>
				</div>
				<div class='main-content' style='margin-top: 25px;'>
					<div style='border-bottom: 3px solid #EEEEEE ;width: 100%;margin-bottom: 15px;' align='left'>
						<p style='font-size: 15px; font-weight: bold;'>Trạng thái:</p>
						<p style='font-size: 15px; font-weight: bold;'>Chi tiết đơn hàng:</p>
					</div>
					<table cellpadding='0' cellspacing='0' class='product' style='width: 100%;margin-bottom: 15px;border-bottom: 3px solid #EEEEEE '>
						<thead>
							<tr>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'>STT</th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'>Sản phẩm</th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'>Giá</th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'>Số lượng</th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'>Thành tiền</th>
							</tr>
						</thead>
            <tbody>";
$n = 0;
$total = 0;
foreach ($_SESSION['cart'] as $key => $value) {
  $n++;
  $body .= "<tr>
              <td style='font-size: 14px;border-bottom: 1px solid #d3cbcb;padding: 10px;'>" . $n . "</td>
              <td style='font-size: 14px;border-bottom: 1px solid #d3cbcb;padding: 10px;'>" . $value['name'] . "</td>
              <td style='font-size: 14px;border-bottom: 1px solid #d3cbcb;padding: 10px;'>" . number_format($value['price']) . 'VNĐ' . "</td>
              <td style='font-size: 14px;border-bottom: 1px solid #d3cbcb;padding: 10px;'>" . $value['quantity'] . "</td>
              <td style='font-size: 14px;border-bottom: 1px solid #d3cbcb;padding: 10px;'>" . number_format($value['price'] * $value['quantity']) . 'VNĐ' . "</td>
            </tr>";
  $total += $value['price'] * $value['quantity'];
}
$body .= "		<tr>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'>Tổng tiền:</th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'></th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'></th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'></th>
								<th style='font-size: 14px;border-bottom: 1px solid #d3cbcb;font-size: 14px;padding: 10px;'>" . number_format($total) . 'VNĐ' . "</th>
							</tr>
						</tbody>
					</table>
				</div>
				<div class='info' style='width: 100%;display: flex;text-align: left;padding-bottom: 30px; flex-wrap: wrap;'>
          <div class='left' style='width: 400px;'>";
$body .= "	<h3 style='font-size: 15px;padding: 5px 0 5px 0;'>Thông tin người mua</h3>
						<p style='font-size: 15px;padding: 5px 0 5px 0;'>Khách hàng: " . $name . "</p>
						<p style='font-size: 15px;padding: 5px 0 5px 0;'>Email: " . $email . "</p>
						<p style='font-size: 15px;padding: 5px 0 5px 0;'>Số điện thoại: " . $phone . "</p>
					</div>
					<div class='right'>
						<h3 style='font-size: 15px;padding: 5px 0 5px 0;'>Thông tin người nhận</h3>
						<p style='font-size: 15px;padding: 5px 0 5px 0;'>Họ tên: " . $bname . "</p>
						<p style='font-size: 15px;padding: 5px 0 5px 0;'>Số điện thoại: " . $bphone . "</p>
						<p style='font-size: 15px;padding: 5px 0 5px 0;'>Địa chỉ: " . $baddress . "</p>
					</div>
				</div>
			</div>
			<div class='bottom' style='padding: 35px;background: #1B9BA3;text-align: center;'>
				<h3 style='color: #ffffff;font-size: 25px;'>Get 25% off your next order.</h3>
			</div>
		</div>
	</div>
</body>
</html>";
