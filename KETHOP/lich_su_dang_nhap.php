<?php
session_start();
include("myclass/clskhachhang.php");
$p = new khachhang();
error_reporting(0);

// Kiểm tra đăng nhập
if(!isset($_SESSION['id'])) {
    header('Location: login/index.php');
    exit();
}

$idkhachhang = $_SESSION['id'];
$sql = "SELECT thoigian FROM lichsu_dangnhap WHERE idkhachhang='$idkhachhang' ORDER BY thoigian DESC LIMIT 10";
$result = mysql_query($sql, $p->connect());
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Lịch Sử Đăng Nhập</title>
    <link rel="stylesheet" href="bootstrap-4.0.0-dist (1)/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Lịch Sử Đăng Nhập</h2>
        <?php if(mysql_num_rows($result) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thời Gian Đăng Nhập</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stt = 1;
                    while($lichsu = mysql_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo htmlspecialchars($lichsu['thoigian']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Không có lịch sử đăng nhập.</p>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">Quay Lại</a>
    </div>
</body>
</html>
