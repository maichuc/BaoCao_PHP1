<?php
session_start();

include("myclass/clslogin.php");
include ("myclass/clsdondathang.php");

if (!isset($_SESSION['id'])) {
    header('Location: ../login/'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$idkhachhang = $_SESSION['id'];
$tmdt = new login();
$link = $tmdt->connect();
$dondathang = new dondathang();

// Lấy danh sách đơn hàng của khách hàng
$sql = "SELECT dh_ma, dh_ngaylap, dh_ngaygiao, dh_noigiao, dh_trangthaithanhtoan, trangthai_don 
        FROM dondathang 
        WHERE idkhachhang='$idkhachhang' 
        ORDER BY dh_ma DESC";
$result = mysql_query($sql, $link);

if (!$result) {
    echo "Lỗi truy vấn: " . mysql_error($link);
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trạng thái đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400&family=Ephesis&family=Roboto:wght@300&family=Smooch+Sans:wght@100;200;400&display=swap" rel="stylesheet">
    <style>
        body {
           
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Smooch Sans', sans-serif;
	font-size:20px;
}
       
        .container {
            margin-top: 50px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            color: #16BFAD; 
            margin-bottom: 40px;
            text-align: center;
			font-size:50px;
			font-weight:bold;
			
        }
        .order-card {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .order-card h5 {
            margin: 0 0 10px;
            color: #333;
			
        }
        .order-status {
            font-weight: bold;
            color: #16BFAD;
			font-size:20px;
        }
        .btn-track {
            background-color: #ea001e;
            color: white;
            border: none;
        }
        .btn-track:hover {
            background-color: #c65100;
        }
        .order-icon {
            margin-right: 8px;
            color: #ea001e; /* Màu cho biểu tượng */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Trạng thái đơn hàng của bạn</h2>
        
        <?php
        if (mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                echo '<div class="order-card">';
                echo '<h5><i class="fas fa-box order-icon"></i>Mã đơn hàng: ' . htmlspecialchars($row['dh_ma']) . '</h5>';
                echo '<p><i class="fas fa-calendar-alt order-icon"></i>Ngày lập: ' . htmlspecialchars(date("d/m/Y H:i:s", strtotime($row['dh_ngaylap']))) . '</p>';
                echo '<p><i class="fas fa-calendar-check order-icon"></i>Ngày giao: ' . htmlspecialchars(date("d/m/Y", strtotime($row['dh_ngaygiao']))) . '</p>';
                echo '<p><i class="fas fa-map-marker-alt order-icon"></i>Địa chỉ giao hàng: ' . htmlspecialchars($row['dh_noigiao']) . '</p>';
                echo '<p class="order-status"><i class="fas fa-info-circle order-icon"></i>Tình trạng: ' . htmlspecialchars($row['trangthai_don']) . '</p>';
                echo '<a href="chi_tiet_don_hang.php?dh_ma=' . htmlspecialchars($row['dh_ma']) . '" class="btn btn-track">Xem chi tiết</a>';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-warning text-center">Không có đơn hàng nào.</div>';
        }
        ?>
        
        <a href="index.php" class="btn btn-secondary">Quay lại trang chủ</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
