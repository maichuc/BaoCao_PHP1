<?php
session_start(); // Khởi động session
include ("../myclass/clskhachhang.php");
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

// Xử lý POST - Thêm vào giỏ hàng 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nut'])) {
    if ($_POST['nut'] == 'Thêm vào giỏ hàng') {
        if ($idkh !== null) {
            $idsp = intval($_POST['idsp']);
            $soluong = intval($_POST['soluong']);
            $gia = floatval($_POST['gia']);

            $result = $p->themGioHang($idkh, $idsp, $soluong, $gia);
             echo '<script>
                    alert("Thêm thành công"); 
                  </script>';
        } else {
            echo '<script>
                    alert("Vui lòng đăng nhập để thêm vào giỏ hàng."); 
                  </script>';
        }
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
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <link rel="stylesheet" type="text/css" href="../css/chinhsach.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist (1)/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400&family=Ephesis&family=Roboto:wght@300&family=Smooch+Sans:wght@100;200;400&display=swap" rel="stylesheet">
</head>
<body>
<div class="container-lg">
    <header id="header">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="../index.php" class="logo h3">Cửa Hàng Cầu Lông</a>
            <nav>

                <ul class="nav">
                    <li class="nav-item"><a class="nav-link text-white" href="../index.php">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../index.php">Sản phẩm</a></li>
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

        <div class="GTbst container">
            <h5><a href="../index.php>">Trang chủ</a> | Chính sách bảo mật</h5>
            <h2 style=" width: 300px; ">Chính sách bảo mật</h2>
            <div>
                YM cam kết sẽ bảo mật những thông tin mang tính riêng tư của khách hàng. Quý khách vui lòng đọc bản
                “Chính sách bảo mật” dưới đây để hiểu hơn những cam kết mà chúng tôi thực hiện, nhằm tôn trọng và bảo vệ
                quyền lợi của người truy cập:
                <h4>Mục đích thu thập thông tin cá nhân</h4>

                Các thông tin thu thập thông qua website sẽ giúp chúng tôi: <br>

                – Hỗ trợ khách hàng khi mua sản phẩm<br>

                – Giải đáp thắc mắc khách hàng<br>

                – Cung cấp cho bạn thông tin mới nhất trên Website của chúng tôi<br>

                – Xem xét và nâng cấp nội dung và giao diện của Website<br>

                – Thực hiện các hoạt động quảng bá liên quan đến các sản phẩm và dịch vụ của YM<br>

                Để được hỗ trợ trực tuyến tại youandme.com.vn, quý khách có thể sẽ được yêu cầu đăng nhập/đăng ký tài khoản.<br>

                Chúng tôi cũng có thể thu thập thông tin về số lần viếng thăm, bao gồm số trang quý khách xem, số links
                (liên kết) bạn click và những thông tin khác liên quan đến việc kết nối . Chúng
                tôi cũng thu thập các thông tin mà trình duyệt Web (Browser) quý khách sử dụng mỗi khi truy cập vào
                website, bao gồm: địa chỉ IP, loại Browser, ngôn ngữ sử dụng, thời gian và những
                địa chỉ mà Browser truy xuất đến.




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

</body>

</html>