<?php
session_start(); // Khởi động session
include("myclass/clskhachhang.php");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nut'])) {
        if ($_POST['nut'] == 'Thêm vào giỏ hàng') {
            if ($idkh !== null) {
                $idsp = intval($_POST['idsp']);
                $soluong = intval($_POST['soluong']);
                $gia = floatval($_POST['gia']);
                $result = $p->themGioHang($idkh, $idsp, $soluong, $gia);
                
                // Cập nhật số lượng trong giỏ hàng
                $cart_count = $p->Laycot("SELECT SUM(soluong) FROM giohang WHERE idkhachhang = '$idkh' LIMIT 1");
                if ($cart_count === NULL) {
                    $cart_count = 0; // Gán về 0 nếu không có sản phẩm
                }

                echo '<script>
                        alert("Thêm thành công");
                        document.getElementById("cart-count").innerText = ' . $cart_count . ';
                      </script>';
            }
			else {
            echo '<script>
                    alert("Vui lòng đăng nhập để thêm vào giỏ hàng."); 
					header("Location: index.php?status=login");
            exit;
                  </script>';
        }
        }
			
    }
	
}



// Xử lý GET - Hành động: Xóa, tăng, giảm số lượng sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'], $_GET['idsp']) && in_array($_GET['action'], ['remove', 'increase', 'decrease'])) {
    $idsp = intval($_GET['idsp']);
    $action = $_GET['action'];

    if ($idkh !== null) {
        if ($action == 'remove') {
            // Xóa sản phẩm khỏi giỏ hàng
            $sqlRemove = "DELETE FROM giohang WHERE idkhachhang='$idkh' AND idsp='$idsp'";
            $p->themxoasua($sqlRemove);
        } elseif ($action == 'increase') {
            // Tăng số lượng sản phẩm
            $sqlIncrease = "UPDATE giohang SET soluong = soluong + 1, tongtien = soluong * gia WHERE idkhachhang='$idkh' AND idsp='$idsp'";
            $p->themxoasua($sqlIncrease);
        } elseif ($action == 'decrease') {
            // Giảm số lượng sản phẩm nhưng không giảm dưới 1
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
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa Hàng Cầu Lông</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/chinhsach.css">
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
                        <a class="nav-link text-white " href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sản phẩm</a>
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
    <div style="margin-top: 30px;" id="shopCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#shopCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#shopCarousel" data-slide-to="1"></li>
                <li data-target="#shopCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="./anhgioithieu/1.png"  alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./anhgioithieu/2.png"" alt=" Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./anhgioithieu/3.png"" alt=" Third slide">

                </div>
            </div>
            <a class="carousel-control-prev" href="#shopCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#shopCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    <!--Tính năng-->
    <nav id="feature" class="section-p1">
        <div class="fe-box">
            <div>
                <i class="bi bi-book"></i>
            </div>
            <a href="html/ChinhSachKH.php">Chính sách khách hàng</a>
        </div>
        <div class="fe-box">
            <div>
                <i class="bi bi-envelope-paper-fill"></i>
            </div>
            <a href="html/LienHe.php">Liên hệ</a>
        </div>
        <div class="fe-box">
            <div>
                <i class="bi bi-file-lock2-fill"></i>
            </div>
            <a href="html/baomat.php">Chính sách bảo mật</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="hero-image"></div> <!-- Hero image section -->

        <section class="mt-4">
            <h2 class="mb-4 text-center">Sản phẩm nổi bật</h2>
            <div class="row">
                <?php 
                    $p->xuatsanpham("SELECT * FROM sanpham ORDER BY RAND() LIMIT 4");
                ?>
            </div>
        </section>

        <section class="mt-4">
            <h2 class="mb-4 text-center">Danh sách sản phẩm</h2>
            <div class="row">
                <?php 
                    $idcty = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0; // Lấy id công ty từ URL
                    if ($idcty > 0) {
                        $p->xuatsanpham("SELECT * FROM sanpham WHERE idcty='$idcty' ORDER BY gia ASC");
                    } else {
                        $p->xuatsanpham("SELECT * FROM sanpham ORDER BY gia ASC");
                    }
                ?>
            </div>
        </section>
    </div>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Thông tin liên hệ</h5>
                    <p>Địa chỉ: 123 Đường Cầu Lông, TP. HCM</p>
                    <p>Email: contact@cuhangcaulong.vn</p>
                    <p>Điện thoại: 0123-456-789</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a class="text-white" href="#">Trang chủ</a></li>
                        <li><a class="text-white" href="#">Sản phẩm</a></li>
                        <li><a class="text-white" href="#">Tin tức</a></li>
                        <li><a class="text-white" href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Mạng xã hội</h5>
                    <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <p class="mt-4">&copy; 2024 Cửa Hàng Cầu Lông. All rights reserved.</p>
        </div>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="bootstrap-4.0.0-dist (1)/js/bootstrap.bundle.min.js"></script>

</body>
</html>
