<?php
session_start();

include ("myclass/clslogin.php");
if (!isset($_SESSION['id'])) {
    header('Location: ../login/'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$idkhachhang = $_SESSION['id']; // Lấy ID khách hàng từ session
$tmdt = new login();
$link = $tmdt->connect();

// Truy vấn thông tin khách hàng
$sql = "SELECT username, hodem, ten, diachi, diachinhanhang, dienthoai FROM khachhang WHERE id='$idkhachhang'";
$result = mysql_query($sql, $link);

if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
} else {
    echo "Không tìm thấy thông tin khách hàng.";
    exit();
}
?>
<?php
include ("myclass/clskhachhang.php");
$p = new khachhang();
error_reporting(0);

/* Kiểm tra xem người dùng đã đăng nhập chưa */
if (isset($_SESSION['id']) && isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['phanquyen'])) {
    $idkh = $_SESSION['id'];
    $tenkh = $p->Laycot("SELECT ten FROM khachhang WHERE id='$idkh' LIMIT 1");
    $cart_count = $p->Laycot("SELECT SUM(soluong) FROM giohang WHERE idkhachhang = '$idkh' LIMIT 1");
} else {
    $idkh = null;
    $tenkh = null;
    $cart_count = 0; // Khởi tạo cart_count 
}

?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng Cầu Lông</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./css/home.css">
    <link rel="stylesheet" type="text/css" href="./css/chinhsach.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap-4.0.0-dist (1)/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400&family=Ephesis&family=Roboto:wght@300&family=Smooch+Sans:wght@100;200;400&display=swap" rel="stylesheet">
</head>
<style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        
        h2 {
            color: #131313;
            margin-bottom: 30px;
        }
        .table {
            background-color: #f9f9f9;
        }
        th {
            background-color: #033E41;
            color: white;
            text-align: center;
        }
        td {
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
<body>
<div class="container-lg">
    <header id="header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="../index.php" class="logo h3">Cửa Hàng Cầu Lông</a>
            <nav>

                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="./index.php">Trang chủ</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white " href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sản phẩm</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php $p->xuatdanhsachcongty("SELECT * FROM congty ORDER BY tencty ASC"); ?>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="TinTuc.php">Tin tức</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="gioithieu.php">Giới thiệu</a></li>
                </ul>
            </nav>

              <div class="user-icons">
                    <?php if ($idkh !== null): ?>
                        <a style="text-decoration: none;" href="../logout/logout.php" class="text-white mx-2">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    <?php else: ?>
                        <a style="text-decoration: none;" href="../login/index.php" class="text-white mx-2">
                            <i class="fas fa-user"></i> Đăng nhập
                        </a>
                    <?php endif; ?>
                    <a style="text-decoration: none;" href="giohang.php" class="text-white mx-2">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng (<span id="cart-count"><?php echo $cart_count; ?></span>)
                    </a>
                </div>

               <!-- Phần menu khi đăng nhập thành công -->
                <div class="menu-hover-container" style="margin-left: 20px;">
                
                    <?php
                    if (isset($tenkh)) {
                        echo '
                        <div class="menu-hover">
  				<i class="bi bi-person-circle  "> <span class="user-info">' . htmlspecialchars($tenkh) . '</span></i>
                            <div class="menu-content">
                                <a href="thong_tin_ca_nhan.php">Thông tin cá nhân</a>
                                <a href="trang_thai_don_hang.php">Trạng thái đơn hàng</a>
                                <a href="lich_su_dang_nhap.php">Lịch sử đăng nhập</a>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
        </div>
    </header>
    <div class="container mt-5">
        <h2 style="margin-bottom:50px; text-align:center; font-weight:bold;">Thông tin cá nhân</h2>
        <table class="table table-bordered">
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
            </tr>
            <tr>
                <th>Họ và tên</th>
                <td><?php echo htmlspecialchars($row['hodem'] . ' ' . $row['ten']); ?></td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td><?php echo htmlspecialchars($row['diachi']); ?></td>
            </tr>
            <tr>
                <th>Địa chỉ nhận hàng</th>
                <td><?php echo htmlspecialchars($row['diachinhanhang']); ?></td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td><?php echo htmlspecialchars($row['dienthoai']); ?></td>
            </tr>
        </table>
        <a href="sua_thong_tin.php" class="btn btn-primary">Sửa thông tin</a>
    </div>
    <!--Đây là footer-->
        <footer id="footer" class="section-p1">
            <div class="col">
                <h4>Liên hệ</h4>
                <p><strong>Địa chỉ:</strong> 12 Nguyễn Văn Bảo, Phường 4, Gò Vấp, Thành phố Hồ Chí Minh.</p>
                <p><strong>Số điện thoại:</strong> 0337462385</p>
                <p><strong>Thời gian hoạt động:</strong> 10:00 - 21:00. <br>Thứ 2 - Thứ 7</p>
            </div>
            <div class="col">
                <h4>Thông tin</h4>
                <a href="gioithieu.php">Giới thiệu</a>
                <a href="ChinhSachKH.php">Thông tin giao hàng</a>
                <a href="baomat.php">Chính sách bảo mật</a>
                <a href="LienHe.php">Liên hệ</a>
            </div>
            <div class="col">
                <h4>Tài khoản của tôi</h4>
                <a href="./login.html">Đăng nhập</a>
                <a href="../giohang.php">Xem giỏ hàng</a>
                <a href="#">Theo dõi đơn hàng</a>
                <a href="#">Giúp đỡ</a>
            </div>
            <div class="col install">
                <div class="follow">
                    <h4>Theo dõi chúng tôi</h4>
                    <div class="icon">
                        <i class="bi bi-facebook"></i>
                        <i class="bi bi-twitter"></i>
                        <i class="bi bi-instagram"></i>
                        <i class="bi bi-pinterest"></i>
                        <i class="bi bi-youtube"></i>
                    </div>
                </div>
                <p>Cổng thanh toán an toàn</p>
                <img src="../IMG/pay.png" alt="">
            </div>
            <div class="copyright">
                 <p>© 2024. Cửa hàng cầu lông.</p>
            </div>
        </footer>
</body>
</html>
