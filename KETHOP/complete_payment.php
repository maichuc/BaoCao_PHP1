<?php
session_start();
include ("myclass/clsdondathang.php");

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Truy vấn cập nhật trạng thái thanh toán của đơn hàng trong cơ sở dữ liệu
    $query = "UPDATE dondathang SET dh_trangthaithanhtoan = 'paid' WHERE dh_ma = '$order_id'";
    
    // Thực thi câu truy vấn
    if (mysqli_query($conn, $query)) {
        echo "Thanh toán thành công và trạng thái đơn hàng đã được cập nhật!";
    } else {
        echo "Lỗi khi cập nhật bản ghi: " . mysqli_error($conn);
    }

    // Tùy chọn chuyển hướng người dùng đến trang tóm tắt đơn hàng
    header("Location: order_summary.php?order_id=" . $order_id);
} else {
    echo "Yêu cầu thanh toán không hợp lệ!";
}
?>
