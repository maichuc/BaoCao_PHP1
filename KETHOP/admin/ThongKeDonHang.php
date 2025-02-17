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
<?php include ("../myclass/clsdondathang.php");
$donHang= new dondathang();
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Thư viện Chart.js -->

    <title>Thống Kê Đơn Hàng</title>
</head>
<body>
    <!-- Sidebar and other elements -->
    <i class="fas fa-bars menu-icon" id="menuToggle"></i>
    <div class="sidebar" id="sidebar">
        <!-- Sidebar content -->
        <div class="user-info">
            <img src="https://via.placeholder.com/60" alt="User Avatar" />
            <h3 id="username"><?php echo $_SESSION['user']; ?></h3>
        </div>
        <a href="GD_admin.php"><i class="fas fa-home"></i> Trang chủ</a>
        <a href="XuLyDonHang.php"><i class="fas fa-shopping-cart"></i> Xử lý đơn hàng</a>
        <a href="ThongKeDonHang.php"><i class="fas fa-chart-bar"></i> Thống kê đơn hàng</a>
        <a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        <i class="fas fa-times close-btn" id="closeSidebar"></i>
    </div>

    <div class="main-content" id="main">
        <div class="container">
            <h2 class="text-center mb-4">Thống Kê Đơn Hàng</h2>

            <!-- Các thống kê khác -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Tổng Đơn Hàng</h5>
                            <?php
                            $sql = "SELECT COUNT(*) as total_orders FROM dondathang";
                            $result = mysql_query($sql);
                            $row = mysql_fetch_assoc($result);
                            echo "<p class='card-text'>" . $row['total_orders'] . "</p>";
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Đơn Hàng Hoàn Thành</h5>
                            <?php
                            $sql = "SELECT COUNT(*) as completed_orders FROM dondathang WHERE trangthai_don = 'Hoàn thành'";
                            $result = mysql_query($sql);
                            $row = mysql_fetch_assoc($result);
                            echo "<p class='card-text'>" . $row['completed_orders'] . "</p>";
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Thêm khối thống kê doanh thu -->
                <div class="col-md-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Tổng Doanh Thu</h5>
                            <?php
                            $sql = "SELECT SUM(spddh.sp_dh_soluong * spddh.sp_dh_dongia) AS total_revenue
                                    FROM sanpham_dondathang spddh
                                    JOIN dondathang ddh ON spddh.dh_ma = ddh.dh_ma
                                    WHERE ddh.trangthai_don = 'Hoàn thành'";
                            $result = mysql_query($sql);
                            if (!$result) {
                                die('Lỗi truy vấn SQL: ' . mysql_error());
                            }
                            $row = mysql_fetch_assoc($result);

                            if ($row['total_revenue'] === null) {
                                echo "Không tính được doanh thu.";
                            } else {
                                echo "<p class='card-text'>" . number_format($row['total_revenue'], 0, ',', '.') . " VND</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
 <div class="row">
    <div class="col-md-4">
        <canvas id="orderStatusChart" width="300" height="150"></canvas> <!-- Biểu đồ thanh -->
    </div>
    <div class="col-md-4">
        <canvas id="orderStatusPieChart" width="300" height="150"></canvas> <!-- Biểu đồ tròn -->
    </div>
    <div class="col-md-4">
        <canvas id="orderLineChart" width="300" height="150"></canvas> <!-- Biểu đồ đường -->
    </div>
</div>
            <!-- Thống kê theo trạng thái đơn hàng -->
            <h4 class="mb-3">Thống Kê Theo Trạng Thái Đơn Hàng</h4>
            <table class="table table-bordered table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Trạng Thái</th>
                        <th>Số Lượng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $statuses = ['Chờ xử lý', 'Chấp nhận đơn', 'Đang giao hàng', 'Hoàn thành', 'Từ chối đơn', 'Hoàn trả'];
                    foreach ($statuses as $status) {
                        $sql = "SELECT COUNT(*) as count FROM dondathang WHERE trangthai_don = '$status'";
                        $result = mysql_query($sql);
                        $row = mysql_fetch_assoc($result);
                        echo "<tr>
                                <td>$status</td>
                                <td>" . $row['count'] . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>

          
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      // Toggle sidebar
      document.getElementById('menuToggle').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
        document.getElementById('main').classList.toggle('with-sidebar');
      });

      document.getElementById('closeSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('active');
        document.getElementById('main').classList.remove('with-sidebar');
      });

      // Lấy dữ liệu trạng thái đơn hàng từ PHP
      var orderCounts = <?php
        echo json_encode(array_map(function($status) {
            $sql = "SELECT COUNT(*) as count FROM dondathang WHERE trangthai_don = '$status'";
            $result = mysql_query($sql);
            $row = mysql_fetch_assoc($result);
            return $row['count'];
        }, $statuses));
      ?>;
      var statuses = <?php echo json_encode($statuses); ?>;

      // Biểu đồ thanh
      var ctxBar = document.getElementById('orderStatusChart').getContext('2d');
      var orderStatusChart = new Chart(ctxBar, {
          type: 'bar',
          data: {
              labels: statuses,
              datasets: [{
                  label: 'Số lượng đơn hàng',
                  data: orderCounts,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });

      // Biểu đồ tròn
      var ctxPie = document.getElementById('orderStatusPieChart').getContext('2d');
      var orderStatusPieChart = new Chart(ctxPie, {
          type: 'pie',
          data: {
              labels: statuses,
              datasets: [{
                  label: 'Tỷ lệ đơn hàng theo trạng thái',
                  data: orderCounts,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true
          }
      });

      // Biểu đồ đường (Line Chart)
      var ctxLine = document.getElementById('orderLineChart').getContext('2d');
      var orderLineChart = new Chart(ctxLine, {
          type: 'line',
          data: {
              labels: statuses, // Giả sử mỗi trạng thái là 1 điểm dữ liệu trên trục X
              datasets: [{
                  label: 'Số lượng đơn hàng theo thời gian',
                  data: orderCounts, // Dữ liệu tương tự biểu đồ thanh, bạn có thể thay thế bằng dữ liệu thực tế theo thời gian
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
    </script>
</body>
</html>
