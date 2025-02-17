<?php
session_start();
include("myclass/clskhachhang.php");
$p = new khachhang();
error_reporting(0);

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['id']) && isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['phanquyen'])) {
    $idkh = $_SESSION['id'];
    $tenkh = $p->Laycot("SELECT ten FROM khachhang WHERE id='$idkh' LIMIT 1");
    $cart_count = $p->Laycot("SELECT SUM(soluong) FROM giohang WHERE idkhachhang = '$idkh' LIMIT 1");
} else {
    $idkh = null;
    $tenkh = null;
    $cart_count = 0; // Khởi tạo cart_count
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nut']) && $_POST['nut'] === 'XÁC NHẬN') {
        if ($idkh !== null) {
            $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
            $sdt_nguoinhan = $_POST['sdt'];
            $email_nguoinhan = $_POST['email'];
            $diaChiGiaoHang = $_POST['diachi_giao'];
            $httt_ma = intval($_POST['hinhthuc_thanh_toan']);
            $tongtien = $p->Laycot("SELECT SUM(soluong * gia) FROM giohang WHERE idkhachhang='$idkh'");
            
            if ($tongtien > 0) {
                $data = [
                    'idkh' => $idkh,
                    'ten_nguoi_nhan' => $ten_nguoi_nhan,
                    'sdt' => $sdt_nguoinhan,
                    'email' => $email_nguoinhan,
                    'diachi_giao' => $diaChiGiaoHang,
                    'hinhthuc_thanh_toan' => $httt_ma,
                    'tongtien' => $tongtien,
                ];
                
                if ($p->xuLyDatHang($data)) {
                    $dh_ma = $p->Laycot("SELECT dh_ma FROM dondathang WHERE idkhachhang='$idkh' ORDER BY dh_ma DESC LIMIT 1");
                    echo '<script>alert("Đặt hàng thành công."); window.location.href = "xacnhan_thanhtoan.php?dh_ma=' . $dh_ma . '";</script>';
                } else {
                    echo '<script>alert("Đặt hàng không thành công.");</script>';
                }
            } else {
                echo '<script>alert("Giỏ hàng trống. Không thể đặt hàng.");</script>';
            }
        } else {
            echo '<script>alert("Vui lòng đăng nhập để đặt hàng.");</script>';
        }
    }
}


// Xử lý GET - Hành động: Xóa, tăng, giảm số lượng sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'], $_GET['idsp']) && in_array($_GET['action'], ['remove', 'increase', 'decrease'])) {
    $idsp = intval($_GET['idsp']);
    $action = $_GET['action'];

    if ($idkh !== null) {
        if ($action == 'remove') {
            $sqlRemove = "DELETE FROM giohang WHERE idkhachhang='$idkh' AND idsp='$idsp'";
            $p->themxoasua($sqlRemove);
        } elseif ($action == 'increase') {
            $sqlIncrease = "UPDATE giohang SET soluong = soluong + 1, tongtien = soluong * gia WHERE idkhachhang='$idkh' AND idsp='$idsp'";
            $p->themxoasua($sqlIncrease);
        } elseif ($action == 'decrease') {
            $soluong = $p->Laycot("SELECT soluong FROM giohang WHERE idkhachhang='$idkh' AND idsp='$idsp' LIMIT 1");
            if ($soluong > 1) {
                $sqlDecrease = "UPDATE giohang SET soluong = soluong - 1, tongtien = soluong * gia WHERE idkhachhang='$idkh' AND idsp='$idsp'";
                $p->themxoasua($sqlDecrease);
            }
        }
        header("Location: giohang.php");
        exit;
    }
}
// Xử lý khi nhấn nút Đặt hàng
if (isset($_GET['order'])) {
    $showOrderForm = true;
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng Cầu Lông</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/giohang.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="bootstrap-4.0.0-dist (1)/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400&family=Ephesis&family=Roboto:wght@300&family=Smooch+Sans:wght@100;200;400&display=swap" rel="stylesheet">
</head>
<body>
<div class="container-lg">
    <header id="header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="logo h3">Cửa Hàng Cầu Lông</a>
            <nav>

                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="index.php">Trang chủ</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sản phẩm</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php $p->xuatdanhsachcongty("SELECT * FROM congty ORDER BY tencty ASC"); ?>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Tin tức</a></li>
                   <li class="nav-item"><a class="nav-link text-white" href="html/gioithieu.php">Giới thiệu</a></li>
                </ul>
            </nav>

           <div class="user-icons">
                    <?php if ($idkh !== null): ?>
                        <a style="text-decoration: none;" href="logout/logout.php" class="text-white mx-2">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    <?php else: ?>
                        <a style="text-decoration: none;" href="login/index.php" class="text-white mx-2">
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
    <main id="main">
        <h2>Giỏ Hàng của bạn</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($idkh !== null) {
                   $p->giohang();
                    }
                 else {
                    echo '<tr><td colspan="5">Giỏ hàng trống.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- Nút Đặt Hàng -->
        <div class="text-center" style="margin-top: 20px;">
        	<a href="index.php" class="btn btn-dark btn-lg" style="margin-right: 10px; padding: 10px 20px;">Trở về</a>
            <a href="?order=true" class="btn btn-primary btn-lg" style="margin-right: 10px; padding: 10px 20px;">Đặt Hàng</a>
        </div>

        <!-- Hiển thị form đặt hàng nếu showOrderForm là true -->
        <?php if ($showOrderForm): ?>
            <form method="POST">
                <h3>Thông tin người nhận</h3>
                <div class="form-group">
                    <label for="ten_nguoi_nhan">Tên người nhận</label>
                    <input type="text" class="form-control" name="ten_nguoi_nhan" required>
                </div>
                <div class="form-group">
                    <label for="sdt">Số điện thoại</label>
                    <input type="text" class="form-control" name="sdt" required>
                </div>
                <div class="form-group">
                    <label for="email">Email (tùy chọn)</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label for="diachi_giao">Địa chỉ giao hàng</label>
                    <input type="text" class="form-control" name="diachi_giao" required>
                </div>
                <div class="form-group">
                    <label for="hinhthuc_thanh_toan">Hình thức thanh toán</label>
                    <select name="hinhthuc_thanh_toan" class="form-control">
                        <option value="1">Chuyển khoản</option>
                        <option value="2">Tiền mặt</option>
                    </select>
                </div>
                <form action="xacnhan_dathang.php">
                <button type="submit" name="nut" value="XÁC NHẬN" class="btn btn-primary">XÁC NHẬN</button>
                </form>
            </form>
        <?php endif; ?>
    </main>
    <footer id="footer">
        <div class="container">
            <p>&copy; 2024 Cửa Hàng Cầu Lông. Bảo lưu quyền.</p>
        </div>
    </footer>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="bootstrap-4.0.0-dist (1)/js/bootstrap.bundle.min.js"></script>
</body>
</html>  
