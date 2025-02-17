<?php
session_start();
session_destroy();
echo 'Đăng xuất thành công!';
header('location:../login/index.php');
?>