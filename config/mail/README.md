![PHPMailer](https://raw.github.com/PHPMailer/PHPMailer/master/examples/images/phpmailer.png)

# PHPMailer - A full-featured email creation and transfer class for PHP

Build status: [![Build Status](https://travis-ci.org/PHPMailer/PHPMailer.svg)](https://travis-ci.org/PHPMailer/PHPMailer)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/PHPMailer/PHPMailer/badges/quality-score.png?s=3758e21d279becdf847a557a56a3ed16dfec9d5d)](https://scrutinizer-ci.com/g/PHPMailer/PHPMailer/)
[![Code Coverage](https://scrutinizer-ci.com/g/PHPMailer/PHPMailer/badges/coverage.png?s=3fe6ca5fe8cd2cdf96285756e42932f7ca256962)](https://scrutinizer-ci.com/g/PHPMailer/PHPMailer/)

## Tính năng của class

- Coi là thư viện phổ biến nhất trên thế giới để gửi email từ PHP!
- Được sử dụng bởi nhiều dự án mã nguồn mở: Drupal, SugarCRM, Yii, Joomla! và nhiều cái khác
- Hỗ trợ SMTP tích hợp - gửi mà không cần máy chủ thư cục bộ
- Gửi email với nhiều TO, CC, BCC và REPLY-TO
- Multipart / email thay thế cho ứng dụng thư khách không đọc email HTML
- Hỗ trợ nội dung UTF-8 và mã hóa 8 bit, base64, nhị phân và có thể in được
- Xác thực SMTP với các cơ chế LOGIN, PLAIN, NTLM và CRAM-MD5 qua giao thức SSL và TLS
- Hỗ trợ ngôn ngữ bản địa
- Hỗ trợ ký DKIM và S / MIME
- Tương thích với PHP 5.0 trở lên
- Nhiều hơn nữa!

## Tại sao nên sử dụng nó

Nhiều nhà phát triển PHP sử dụng email trong mã của họ. Hàm PHP duy nhất hỗ trợ điều này là hàm mail (). Tuy nhiên, nó không cung cấp bất kỳ hỗ trợ nào cho việc sử dụng các tính năng phổ biến như email và tệp đính kèm dựa trên HTML.

Định dạng email chính xác là khó khăn. Có vô số RFC chồng chéo, yêu cầu tuân thủ chặt chẽ các quy tắc và định dạng mã hóa phức tạp khủng khiếp - phần lớn mã mà bạn sẽ tìm thấy trực tuyến sử dụng hàm mail () trực tiếp thường là false!
Nếu bạn không sử dụng PHPMailer, có rất nhiều thư viện tuyệt vời khác mà bạn nên xem xét trước khi tự mình cuộn - hãy thử SwiftMailer, Zend_Mail, eZcomponents, v.v.

Hàm PHP mail () thường gửi qua một máy chủ thư cục bộ, thường được đặt trước bởi một phân tử `sendmail` trên các nền tảng Linux, BSD và OS X, tuy nhiên, Windows thường không bao gồm một máy chủ thư cục bộ; Việc triển khai SMTP tích hợp của PHPMailer cho phép gửi email trên nền tảng Windows mà không cần máy chủ thư cục bộ.

## Giấy phép
Phần mềm này được cấp phép theo [LGPL 2.1] (http://www.gnu.org/licenses/lgpl-2.1.html). Vui lòng đọc LICENSE để biết thông tin về
khả năng và phân phối phần mềm.

## Cài đặt và tải

PHPMailer có sẵn thông qua [Composer / Packagist] (https://packagist.org/packages/phpmailer/phpmailer). Ngoài ra, chỉ cần sao chép nội dung của thư mục PHPMailer vào một nơi nào đó trong cài đặt PHP `include_path` của bạn. Nếu bạn không nói git hoặc chỉ muốn tarball, hãy nhấp vào nút 'zip' ở đầu trang trong GitHub.

PHPMailer cung cấp một trình nạp tự động tương thích với SPL, và đó là cách ưa thích để tải thư viện - chỉ cần `require '/path/to/PHPMailerAutoload.php';` và mọi thứ sẽ hoạt động. Trình nạp tự động không ném lỗi nếu nó không thể tìm thấy các lớp để nó tự thêm vào danh sách SPL, cho phép trình nạp tự động của chính bạn (hoặc khung công tác của bạn) bắt lỗi. Tự động tải SPL được giới thiệu trong PHP 5.1.0, vì vậy nếu bạn đang sử dụng một phiên bản cũ hơn bạn sẽ cần phải yêu cầu / bao gồm mỗi lớp theo cách thủ công.
PHPMailer không * không * khai báo một vùng tên vì các không gian tên chỉ được giới thiệu trong PHP 5.3.
### Cài đặt và sử dụng
- Tải thư viện về và giả nén vào thư mục gốc của dự án
- VD: giửi nén vào thư mục mail trong dự án và cách sử dụng như veis dụ sau

## Ví dụ

```php
<?php
require 'mail/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'di_chi_email_cua_ban@gmail.com';                 // SMTP username
$mail->Password = 'mat_khau_dang_nhap_email';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'dia_chi_gui_mail@gmail.com';
$mail->FromName = 'Tiêu đề mail';
$mail->addAddress('dia_chi_nhan_mail@example.net', 'Tên người nhận');     // Add a recipient
$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
```
