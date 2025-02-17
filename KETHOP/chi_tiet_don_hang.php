<?php
session_start();

include("myclass/clslogin.php");
include("myclass/clsdondathang.php");

if (!isset($_SESSION['id'])) {
    header('Location: ../login/'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$idkhachhang = $_SESSION['id'];
$tmdt = new login();
$link = $tmdt->connect();
$dondathang = new dondathang();

if (isset($_GET['dh_ma'])) {
    $dh_ma = intval($_GET['dh_ma']);
} else {
    echo "Mã đơn hàng không hợp lệ.";
    exit();
}

// Lấy thông tin chi tiết đơn hàng
$sql = "SELECT * FROM sanpham_dondathang WHERE dh_ma='$dh_ma'";
$result = mysql_query($sql, $link);

if (!$result) {
    echo "Lỗi truy vấn: " . mysql_error($link);
    exit();
}

$order_details = [];
while ($row = mysql_fetch_assoc($result)) {
    $order_details[] = $row;
}

// Lấy thông tin đơn hàng
$sql_order = "SELECT dh_ngaylap, dh_ngaygiao, dh_noigiao, trangthai_don FROM dondathang WHERE dh_ma='$dh_ma' AND idkhachhang='$idkhachhang' LIMIT 1";
$order_result = mysql_query($sql_order, $link);
$order_info = mysql_fetch_assoc($order_result);

if (!$order_info) {
    echo "Không tìm thấy thông tin đơn hàng.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <<link rel="preconnect" href="https://fonts.googleapis.com">
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
            color: #11A579; 
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        h5 {
            color: #333;
            margin-top: 20px;
        }
        .order-details {
            margin-top: 20px;
        }
        .order-details th, 
        .order-details td {
            text-align: left;
            vertical-align: middle;
        }
        .table {
            margin-top: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            overflow: hidden;
        }
        .table thead {
            background-color: #11A579;
            color: white;
        }
        .table th, 
        .table td {
            padding: 12px 15px;
        }
        .table tbody tr {
            border-bottom: 1px solid #eaeaea;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .table tbody tr:last-child {
            border-bottom: none;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
            margin-top: 20px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #11A579; /* Màu tổng tiền */
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chi tiết đơn hàng #<?php echo htmlspecialchars($dh_ma); ?></h2>
        
        <h5>Thông tin đơn hàng:</h5>
        <p><strong>Ngày lập:</strong> <?php echo htmlspecialchars(date("d/m/Y H:i:s", strtotime($order_info['dh_ngaylap']))); ?></p>
        <p><strong>Ngày giao:</strong> <?php echo htmlspecialchars(date("d/m/Y", strtotime($order_info['dh_ngaygiao']))); ?></p>
        <p><strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($order_info['dh_noigiao']); ?></p>
        <p><strong>Tình trạng:</strong> <?php echo htmlspecialchars($order_info['trangthai_don']); ?></p>
        
        <h5 class="order-details">Danh sách sản phẩm:</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_amount = 0;
                foreach ($order_details as $detail) {
                    // Lấy thông tin sản phẩm
                    $sql_product = "SELECT tensp, gia FROM sanpham WHERE id='{$detail['idsp']}'";
                    $product_result = mysql_query($sql_product, $link);
                    $product_info = mysql_fetch_assoc($product_result);

                    // Tính tổng tiền cho sản phẩm
                    $subtotal = $detail['sp_dh_soluong'] * $product_info['gia'];
                    $total_amount += $subtotal;

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($product_info['tensp']) . '</td>';
                    echo '<td>' . htmlspecialchars(number_format($product_info['gia'], 0, ',', '.') . ' VNĐ') . '</td>';
                    echo '<td>' . htmlspecialchars($detail['sp_dh_soluong']) . '</td>';
                    echo '<td>' . htmlspecialchars(number_format($subtotal, 0, ',', '.') . ' VNĐ') . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <h5 class="total-amount">Tổng tiền: <?php echo htmlspecialchars(number_format($total_amount, 0, ',', '.') . ' VNĐ'); ?></h5>
        
        <a href="trang_thai_don_hang.php" class="btn btn-secondary">Quay lại trang trạng thái đơn hàng</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
