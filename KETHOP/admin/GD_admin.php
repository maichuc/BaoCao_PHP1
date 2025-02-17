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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="http://www.peter-eigenschink.at/blog/favicon.ico"
      type="image/x-icon"
      rel="shortcut icon"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      body {
        font-family: 'Roboto', sans-serif;
        background-color: #f9f9f9;
        color: #333;
      }

      /* Sidebar styling */
      .sidebar {
        width: 250px;
        height: 100%;
        background-color: #fff;
        position: fixed;
        top: 0;
        left: -250px;
        transition: 0.3s;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
      }

      .sidebar.active {
        left: 0;
      }

      .sidebar a {
        padding: 15px;
        text-decoration: none;
        font-size: 18px;
        color: #333;
        display: block;
        transition: 0.3s;
      }

      .sidebar a:hover {
        background-color: #ddd;
        color: #000;
      }

      /* Menu icon */
      .menu-icon {
        font-size: 24px;
        cursor: pointer;
        padding: 15px;
        position: fixed;
        left: 10px;
        top: 10px;
        color: #333;
        background-color: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      }

      /* Close button inside sidebar */
      .close-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        cursor: pointer;
      }

      /* Main content */
      .main-content {
        margin-left: 50px;
        padding: 20px;
        transition: margin-left 0.3s ease;
      }

      .main-content.with-sidebar {
        margin-left: 250px;
      }

      /* Footer styling */
      .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: #666;
      }

      /* User info section in sidebar */
      .user-info {
        padding: 20px;
        text-align: center;
        background-color: #f1f1f1;
      }

      .user-info img {
        border-radius: 50%;
      }

      .user-info h3 {
        margin-top: 10px;
        color: #333;
      }

      /* Dropdown Menu */
      .dropdown-menu {
        position: absolute;
        top: 50px;
        right: 10px;
        display: none;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
      }

      .dropdown-menu a {
        padding: 10px;
        display: block;
        color: #333;
        text-decoration: none;
      }

      .dropdown-menu a:hover {
        background-color: #ddd;
      }
    </style>
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
      <a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
      <i class="fas fa-times close-btn" id="closeSidebar"></i>
    </div>

    <!-- Main Content -->
    <div id="main" class="main-content">
      <div class="dropdown-menu" id="dropdownMenu">
        <a href="#" class="logout-icon" id="logoutLink">
          <i class="fas fa-sign-out-alt" id="logoutIcon" title="Logout"></i> Đăng xuất
        </a>
      </div>

<div class="main-content" id="main">
	<h1>XIN CHÀO:<?php echo $_SESSION['user']; ?> </h1>
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
