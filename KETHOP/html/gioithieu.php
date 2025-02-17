<?php
session_start(); // Khởi động session
include("../myclass/clskhachhang.php");
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
                        document.getElementById("cart-count").innerText = ' . $cart_count . ';
                      </script>';
            }
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/chinhsach.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist (1)/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400&family=Ephesis&family=Roboto:wght@300&family=Smooch+Sans:wght@100;200;400&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
    }

    .navbar {
        background-color: #0d6efd;
    }

    .navbar-brand,
    .nav-link {
        color: white !important;
    }

    .carousel-item img {
        filter: brightness(70%);
    }

    .carousel-caption h5 {
        font-size: 2rem;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
    }

    .carousel-caption p {
        font-size: 1.2rem;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .about-section {
        background-color: white;
        padding: 50px 0;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        margin-top: -50px;
    }

    .about-section h2 {
        font-weight: bold;
        color: #0d6efd;
    }

    .about-section p {
        font-size: 1.1rem;
        color: #555;
    }

    .about-features {
        margin-top: 30px;
    }

    .feature-box {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        text-align: center;
        transition: transform 0.3s;
    }

    .feature-box:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
    }

    .feature-box i {
        font-size: 3rem;
        color: #0d6efd;
        margin-bottom: 10px;
    }

    footer {
        background-color: #0d6efd;
        color: white;
        padding: 20px 0;
    }
</style>

<body>
    <div class="container-lg">
        <header id="header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="index.php" class="logo h3">Cửa Hàng Cầu Lông</a>
            <nav>

                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="../index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../index.php">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Tin tức</a></li>
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
                    <a style="text-decoration: none;" href="../giohang.php" class="text-white mx-2">
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

        <!-- Giới thiệu -->
        <div style="margin-bottom: 20px;" class="container about-section mt-5">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 style="font-weight: bold;">Giới thiệu về cửa hàng cầu lông của chúng tôi</h1>
                    <p style="font-size: 20px;">Tại Badminton Shop, chúng tôi đam mê mang đến những thiết bị, trang phục và phụ kiện tốt nhất cho người chơi ở mọi cấp độ.
                        Cho dù bạn mới bắt đầu hay là một người chơi chuyên nghiệp dày dạn kinh nghiệm, bộ sưu tập được tuyển chọn của chúng tôi được thiết kế để đáp ứng các tiêu chuẩn cao nhất về hiệu suất và phong cách.
                        Hãy tham gia cùng chúng tôi và đưa trò chơi của bạn lên một tầm cao mới!</p>
                </div>
            </div>
            <div class="row about-features">
                <div class="col-md-4">
                    <div class="feature-box">
                        <i style="color: #000000;" class="fas fa-shopping-basket"></i>
                        <h5 style="font-weight: bold;">Thiết bị chất lượng hàng đầu</h5>
                        <p>Từ vợt đến giày, sản phẩm của chúng tôi đều có nguồn gốc từ các thương hiệu đáng tin cậy.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i style="color: #000000;" class="fas fa-tshirt"></i>
                        <h5 style="font-weight: bold;">Trang phục thoải mái</h5>
                        <p>Quần áo thể thao hiệu suất cao và công nghệ tiên tiến dành cho tất cả lông thủ.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <i style="color: #000000;" class="fas fa-dumbbell"></i>
                        <h5 style="font-weight: bold;">Thiết bị hỗ trợ</h5>
                        <p>Cải thiện kỹ năng của bạn với các công cụ và thiết bị hỗ trợ tiên tiến của chúng tôi.</p>
                    </div>
                </div>
            </div>
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap-4.0.0-dist (1)/js/bootstrap.bundle.min.js"></script>



</body>

</html>