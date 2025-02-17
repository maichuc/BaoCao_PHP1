<?php 
error_reporting(0);
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['phanquyen'])) {
    include ("../myclass/clslogin.php");
    $q = new login();
    $q->confirmlogin($_SESSION['id'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['phanquyen']);
} else {
    header('location:../login/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/sidebar.css">

    <title>Xử Lý Đơn Hàng</title>
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

    <div class="main-content" id="main">
        <div class="container">
            <h2 class="text-center mb-4">Quản Lý Đơn Hàng</h2>

            <div class="filter-section mb-4">
                <form method="GET" action="" class="row g-3">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Trạng Thái:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Tất cả</option>
                            <option value="Chờ xử lý">Chờ xử lý</option>
                            <option value="Chấp nhận đơn">Chấp nhận đơn</option>
                            <option value="Đang giao hàng">Đang giao hàng</option>
                            <option value="Hoàn thành">Hoàn thành</option>
                            <option value="Từ chối đơn">Từ chối đơn</option>
                            <option value="Hoàn trả">Hoàn trả</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="search" class="form-label">Tìm kiếm:</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Tìm kiếm theo tên...">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </div>
                </form>
            </div>

            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Tên Người Nhận</th>
                        <th>SDT Người Nhận</th>
                        <th>Địa Chỉ Giao</th>
                        <th>Trạng Thái Đơn</th>
                        <th>Ngày Lập</th> <!-- Thêm cột cho Ngày Lập -->
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Phân trang
                    $limit = 10; // Số lượng đơn hàng trên một trang
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Lấy trang hiện tại
                    $offset = ($page - 1) * $limit; // Tính chỉ số bắt đầu của đơn hàng

                    // Lấy danh sách đơn hàng từ cơ sở dữ liệu với bộ lọc
                    $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
                    $search_filter = isset($_GET['search']) ? $_GET['search'] : '';

                    // Cập nhật truy vấn để lấy thêm trường ngày lập
                    $sql = "SELECT * FROM dondathang WHERE 1=1";

                    if ($status_filter) {
                        $sql .= " AND trangthai_don='$status_filter'";
                    }

                    if ($search_filter) {
                        $sql .= " AND ten_nguoi_nhan LIKE '%$search_filter%'";
                    }

                    // Đếm số lượng đơn hàng
                    $total_sql = "SELECT COUNT(*) as total FROM dondathang WHERE 1=1";
                    if ($status_filter) {
                        $total_sql .= " AND trangthai_don='$status_filter'";
                    }
                    if ($search_filter) {
                        $total_sql .= " AND ten_nguoi_nhan LIKE '%$search_filter%'";
                    }

                    $total_result = mysql_query($total_sql);
                    $total_row = mysql_fetch_assoc($total_result);
                    $total_orders = $total_row['total']; // Tổng số đơn hàng
                    $total_pages = ceil($total_orders / $limit); // Tổng số trang

                    // Thực hiện truy vấn để lấy đơn hàng với phân trang
                    $sql .= " LIMIT $offset, $limit";
                    $result = mysql_query($sql);

                    while ($row = mysql_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['dh_ma'] . "</td>";
                        echo "<td>" . $row['ten_nguoi_nhan'] . "</td>";
                        echo "<td>" . $row['sdt_nguoinhan'] . "</td>";
                        echo "<td>" . $row['dh_noigiao'] . "</td>";
                        echo "<td>" . $row['trangthai_don'] . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($row['dh_ngaylap'])) . "</td>"; // Hiển thị ngày lập
                        echo "<td>
                                <form method='POST' action=''>
                                    <select name='new_status' class='form-select'>
                                        <option value='Chờ xử lý' " . ($row['trangthai_don'] == 'Chờ xử lý' ? 'selected' : '') . ">Chờ xử lý</option>
                                        <option value='Chấp nhận đơn' " . ($row['trangthai_don'] == 'Chấp nhận đơn' ? 'selected' : '') . ">Chấp nhận đơn</option>
                                        <option value='Đang giao hàng' " . ($row['trangthai_don'] == 'Đang giao hàng' ? 'selected' : '') . ">Đang giao hàng</option>
                                        <option value='Hoàn thành' " . ($row['trangthai_don'] == 'Hoàn thành' ? 'selected' : '') . ">Hoàn thành</option>
                                        <option value='Từ chối đơn' " . ($row['trangthai_don'] == 'Từ chối đơn' ? 'selected' : '') . ">Từ chối đơn</option>
                                        <option value='Hoàn trả' " . ($row['trangthai_don'] == 'Hoàn trả' ? 'selected' : '') . ">Hoàn trả</option>
                                    </select>
                                    <input type='hidden' name='order_id' value='" . $row['dh_ma'] . "' />
                                    <button type='submit' class='btn btn-warning mt-2'>Cập nhật</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>

            </table>
<?php
    // Xử lý cập nhật trạng thái đơn hàng
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_status = $_POST['new_status'];
        $order_id = $_POST['order_id'];

        // Cập nhật trạng thái đơn hàng
        $update_sql = "UPDATE dondathang SET trangthai_don='$new_status' WHERE dh_ma='$order_id'";
        if (mysql_query($update_sql)) {
            echo "<script>alert('Cập nhật trạng thái đơn hàng thành công!'); </script>";
        } else {
            echo "<script>alert('Cập nhật trạng thái đơn hàng thất bại!');</script>";
        }
    }
    ?>
            <?php
            // Xây dựng thanh điều hướng phân trang
            echo '<nav aria-label="Page navigation">';
            echo '<ul class="pagination justify-content-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<li class="page-item' . ($i == $page ? ' active' : '') . '">';
                echo '<a class="page-link" href="?page=' . $i . '&status=' . urlencode($status_filter) . '&search=' . urlencode($search_filter) . '">' . $i . '</a>';
                echo '</li>';
            }
            echo '</ul>';
            echo '</nav>';
            ?>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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

      document.getElementById('closeSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('main').classList.remove('with-sidebar');
        document.getElementById('menuToggle').classList.remove('fa-times');
        document.getElementById('menuToggle').classList.add('fa-bars');
      });
</script>
</body>
</html>

