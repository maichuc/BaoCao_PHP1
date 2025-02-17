<?php
session_start();

// Khởi tạo các biến với giá trị mặc định
$hoten = '';
$sdt = '';
$diachi = '';
$phuongthuc = '';

// Kiểm tra xem form đã được gửi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra và lấy thông tin từ $_POST
    $hoten = isset($_POST['hoten']) ? $_POST['hoten'] : '';
    $sdt = isset($_POST['sdt']) ? $_POST['sdt'] : '';
    $diachi = isset($_POST['diachi']) ? $_POST['diachi'] : '';
    $phuongthuc = isset($_POST['phuongthuc']) ? $_POST['phuongthuc'] : '';

    // Tiếp tục xử lý đơn hàng...
} else {
    // Xử lý trường hợp không gửi form
    echo "Vui lòng điền thông tin đặt hàng.";
}
?>

<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <title>Xác Nhận Đơn Hàng</title>
</head>
<body>
    <h1>Xác Nhận Đơn Hàng</h1>
    <h2>Thông tin địa chỉ nhận hàng:</h2>
    <p>Họ tên: <?php echo htmlspecialchars($hoten); ?></p>
    <p>Số điện thoại: <?php echo htmlspecialchars($sdt); ?></p>
    <p>Địa chỉ: <?php echo htmlspecialchars($diachi); ?></p>
    <p>Phương thức thanh toán: <?php echo htmlspecialchars($phuongthuc); ?></p>
</body>
</html>
