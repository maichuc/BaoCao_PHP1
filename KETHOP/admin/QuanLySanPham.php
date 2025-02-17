<?php 
error_reporting(0);
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['phanquyen']))
{
	include ("../myclass/clslogin.php");
	$q=new login();
	$q->confirmlogin($_SESSION['id'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['phanquyen']);
}
else
{
	header('location:../login/');
}

?>

<?php 
include ("../myclass/clsquantri.php");
$p = new quantri();
//error_reporting(0);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- <link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist (1)/css/bootstrap.css"> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
<link
      href="http://www.peter-eigenschink.at/blog/favicon.ico"
      type="image/x-icon"
      rel="shortcut icon"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
<title>Quản lý sản phẩm</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 <link rel="stylesheet" type="text/css" href="../css/sidebar.css">
</head>

<body>
<!-- Menu Icon to toggle the sidebar -->
    <i class="fas fa-bars menu-icon" id="menuToggle"></i>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <!-- User Info Section in Sidebar -->
      <div class="user-info">
        <img src="https://via.placeholder.com/60" alt="User Avatar" />
        <h3 id="username"><?php echo $_SESSION['user']; ?></h3> <!-- Hiển thị tên người dùng -->
      </div>

      <a href="GD_admin.php" id="homeLink"><i class="fas fa-home"></i> Trang chủ</a>
      <a href="QuanLySanPham.php"><i class="fas fa-box"></i> Quản lý sản phẩm</a>
      <a href="XuLyDonHang.php"><i class="fas fa-shopping-cart"></i> Xử lý đơn hàng</a>
      <a href="ThongKeDonHang.php"><i class="fas fa-chart-bar"></i> Thống kê đơn hàng</a>
      <a href="../logout/logout.php" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
      <i class="fas fa-times close-btn" id="closeSidebar"></i>
    </div>

<?php
$myid = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$laytensp = $p->laycot("select tensp from sanpham where id='$myid' limit 1");
$laygia = $p->laycot("select gia from sanpham where id='$myid' limit 1");
$laymota = $p->laycot("select mota from sanpham where id='$myid' limit 1");
$laygiamgia = $p->laycot("select giamgia from sanpham where id='$myid' limit 1");
?>
<div class="main-content" id="main">
<div class="container mt-5">
    <h2 class="text-center">QUẢN LÝ SẢN PHẨM</h2>
    <form method="post" enctype="multipart/form-data" name="form1" id="form1">
        <div class="form-group">
            <label for="congty">Chọn nhà sản xuất</label>
            <?php
                $layidcty = $p->laycot("select idcty from sanpham where id = '$myid' limit 1");
                $p->choncongty("select * from congty order by tencty asc", $layidcty);
            ?>
            <input type="hidden" name="txtmyid" id="txtmyid" value="<?php echo $myid; ?>">
        </div>
        
        <div class="form-group">
            <label for="txtTen">Tên sản phẩm</label>
            <input type="text" class="form-control" name="txtTen" id="txtTen" value="<?php echo $laytensp; ?>">
        </div>
        
        <div class="form-group">
            <label for="txtGia">Giá</label>
            <input type="text" class="form-control" name="txtGia" id="txtGia" value="<?php echo $laygia; ?>">
        </div>
        
        <div class="form-group">
            <label for="txtMota">Mô tả</label>
            <textarea class="form-control" name="txtMota" cols="50" rows="5" id="txtMota"><?php echo $laymota; ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="txtGiamGia">Giảm giá</label>
            <input type="text" class="form-control" name="txtGiamGia" id="txtGiamGia" value="<?php echo $laygiamgia; ?>">
        </div>
        
        <div class="form-group">
            <label for="myfile">Hình sản phẩm</label>
            <input type="file" class="form-control-file" name="myfile" id="myfile">
        </div>

        <div class="text-center">
            <button type="submit" name="submit" value="Thêm sản phẩm" class="btn btn-primary">Thêm sản phẩm</button>
            <button type="submit" name="submit" value="Sửa" class="btn btn-warning">Sửa</button>
            <button type="submit" name="submit" value="Xoá sản phẩm" class="btn btn-danger">Xoá sản phẩm</button>
        </div>
    </form>

    <div class="mt-4">
        <?php
        if (isset($_POST['submit'])) {
            switch($_POST['submit']) {
                case 'Thêm sản phẩm': {
                    $name = $_FILES['myfile']['name'];
                    $tmp_name = $_FILES['myfile']['tmp_name'];
                    $id_cty = $_REQUEST['congty'];
                    $ten = $_REQUEST['txtTen'];
                    $gia = $_REQUEST['txtGia'];
                    $mota = $_REQUEST['txtMota'];
                    $giamgia = $_REQUEST['txtGiamGia'];
                    if ($name != '') {
                        if ($p->uploadfile($name, $tmp_name, "../hinh") == 1) {
                            if ($p->themxoasua("INSERT INTO sanpham(tensp,gia,mota,hinh,giamgia,idcty) VALUES ('$ten', '$gia', '$mota', '$name', '$giamgia', '$id_cty')") == 1) {
                                echo '<div class="alert alert-success" role="alert">Thêm sản phẩm thành công</div>';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">Thêm sản phẩm không thành công</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Upload hình không thành công</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning" role="alert">Vui lòng chọn hình đại diện cho sản phẩm</div>';
                    }
                    break;
                }
                case 'Xoá sản phẩm': {
                    $idsp = $_REQUEST['txtmyid'];
                    if ($idsp > 0) {
                        if ($p->themxoasua("DELETE FROM sanpham WHERE id ='$idsp' LIMIT 1") == 1) {
                            echo '<div class="alert alert-success" role="alert">Xoá thành công</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Xoá không thành công</div>';
                        }
                    }
                    break;
                }
                case 'Sửa': {
                    $idsp = $_REQUEST['txtmyid'];
                    $id_cty = $_REQUEST['congty'];
                    $ten = $_REQUEST['txtTen'];
                    $gia = $_REQUEST['txtGia'];
                    $mota = $_REQUEST['txtMota'];
                    $giamgia = $_REQUEST['txtGiamGia'];
                    if ($idsp > 0) {
                        if ($p->themxoasua("UPDATE sanpham SET tensp='$ten', gia='$gia', mota='$mota', giamgia='$giamgia', idcty='$id_cty' WHERE id='$idsp' LIMIT 1") == 1) {
                            echo '<div class="alert alert-success" role="alert">Sửa sản phẩm thành công</div>';
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Sửa sản phẩm không thành công</div>';
                        }
                    } else {
                        echo '<div class="alert alert-warning" role="alert">Vui lòng chọn sản phẩm cần sửa</div>';
                    }
                    break;
                }
            }
        }
        ?>
    </div>

    <hr>
    <h3 class="text-center">Danh sách sản phẩm</h3>
    <?php
    $p->danhsachsanpham("select * from sanpham order by tensp desc");
    ?>
</div>
</div>
 <script>
      // Toggle sidebar and change icon
      document.getElementById('menuToggle').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        var menuIcon = document.getElementById('menuToggle');
        
        sidebar.classList.toggle('active');
        document.getElementById('main').classList.toggle('with-sidebar');
        
        // Toggle between menu (bars) and close (times) icons
        if (sidebar.classList.contains('active')) {
          menuIcon.classList.remove('fa-bars');
          menuIcon.classList.add('fa-times');
        } else {
          menuIcon.classList.remove('fa-times');
          menuIcon.classList.add('fa-bars');
        }
      });

      // Close sidebar when close icon is clicked
      document.getElementById('closeSidebar').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        var menuIcon = document.getElementById('menuToggle');

        sidebar.classList.remove('active');
        document.getElementById('main').classList.remove('with-sidebar');
        
        // Revert icon to menu (bars)
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
      });

      // Logout action
      document.getElementById('logoutLink').addEventListener('click', function() {
        window.location.href = "/login.html";
      });
    </script>
</body>
</html>
