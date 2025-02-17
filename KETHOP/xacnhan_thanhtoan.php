<?php
session_start();
include("myclass/clsdondathang.php");
$p = new dondathang();

if (isset($_SESSION['id'])) {
    $idkh = $_SESSION['id'];

    // Lấy thông tin đơn hàng cuối cùng của khách hàng
    $dh_ma = $p->Laycot("SELECT dh_ma FROM dondathang WHERE idkhachhang='$idkh' ORDER BY dh_ma DESC LIMIT 1");

    if ($dh_ma) {
        // Lấy chi tiết đơn hàng
        $donhang = $p->Laydong("SELECT * FROM dondathang WHERE dh_ma='$dh_ma' AND idkhachhang='$idkh' LIMIT 1");

        if ($donhang) {
            $ten_nguoi_nhan = htmlspecialchars($donhang['ten_nguoi_nhan']);
            $sdt_nguoinhan = htmlspecialchars($donhang['sdt_nguoinhan']);
            $email_nguoinhan = htmlspecialchars($donhang['email_nguoinhan']);
            $diachi_giao = htmlspecialchars($donhang['dh_noigiao']);
            $tongtien = $p->Laycot("SELECT SUM(sp_dh_soluong * sp_dh_dongia) FROM sanpham_dondathang WHERE dh_ma='$dh_ma'");
            $httt_ma = $donhang['httt_ma'];
            $trangthai_don = htmlspecialchars($donhang['trangthai_don']); // Lấy trạng thái đơn hàng

            // Phần thiết kế giao diện
            echo '<!DOCTYPE html>
            <html lang="vi">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Xác nhận thanh toán</title>
                <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <style>
                    body {
                        margin: 0;
                        box-sizing: border-box;
                        font-family: "Roboto", sans-serif;
                        background: linear-gradient(135deg, #f8f9fa, #dfe9f3);
                        color: #333;
                        padding: 40px 0;
                    }
                    .container {
                        max-width: 600px;
                        margin: auto;
                        background: #fff;
                        padding: 30px;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                        border-radius: 12px;
                    }
                    h2 {
                        font-weight: 700;
                        margin-bottom: 30px;
                        text-align: center;
                    }
                    .btn {
                        display: inline-block;
                        width: 100%;
                        padding: 15px;
                        font-size: 16px;
                        border-radius: 50px;
                        background: linear-gradient(135deg, #56ccf2, #2f80ed);
                        color: #fff;
                        text-align: center;
                        transition: all 0.3s ease;
                        text-decoration: none;
                    }
                    .btn:hover {
                        background: linear-gradient(135deg, #2f80ed, #56ccf2);
                    }
                </style>
            </head>
            <body>';

            echo '<div class="container">';
            echo "<h2>Xác nhận thanh toán</h2>";
            echo "<p><strong>Tên người nhận:</strong> $ten_nguoi_nhan</p>";
            echo "<p><strong>Số điện thoại:</strong> $sdt_nguoinhan</p>";
            echo "<p><strong>Email:</strong> $email_nguoinhan</p>";
            echo "<p><strong>Địa chỉ giao hàng:</strong> $diachi_giao</p>";
            echo "<p><strong>Tổng tiền:</strong> " . number_format($tongtien) . " VNĐ</p>";
            echo "<p><strong>Trạng thái đơn hàng:</strong> $trangthai_don</p>";

            // Thêm phần chọn phương thức thanh toán
            echo '<h3 class="text-center">Chọn phương thức thanh toán</h3>';
            echo '<form method="post" id="payment-form">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="paypal" checked>
                    <label class="form-check-label" for="paypal">Thanh toán qua PayPal</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod">
                    <label class="form-check-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                </div>
                <button type="submit" class="btn mt-3">Tiếp tục</button>
            </form>';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $payment_method = $_POST['payment_method'];

                if ($payment_method == 'paypal') {
                    echo '<div id="paypal-button-container"></div>';
                } else {
                    // Xử lý thanh toán COD
                    echo "<p class='text-center'>Đặt hàng thành công! Vui lòng thanh toán khi nhận hàng.</p>";
                    echo '<a href="trang_thai_don_hang.php" class="btn">Trạng thái đơn hàng</a>';
                    echo '<a href="index.php" class="btn">Trang chủ</a>';
                }
            }

            echo '</div>'; // End container
            echo '</body></html>';
        } else {
            echo "<p>Không tìm thấy thông tin đơn hàng.</p>";
        }
    } else {
        echo "<p>Không có đơn hàng nào để xác nhận.</p>";
    }
} else {
    echo "<script>alert('Vui lòng đăng nhập để xác nhận thanh toán.'); window.location.href = 'login/index.php';</script>";
}
?>

<!-- Tích hợp PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo number_format($tongtien, 0, '', ''); ?>' // Tổng tiền từ PHP, cần định dạng đúng
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                alert('Thanh toán thành công, ' + details.payer.name.given_name + '!');
                // Cập nhật trạng thái đơn hàng trong cơ sở dữ liệu
                window.location.href = 'complete_payment.php?order_id=<?php echo $dh_ma; ?>'; // Điều hướng sau khi thanh toán thành công
            });
        },
        onError: function(err) {
            console.error(err);
            alert('Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại.');
        }
    }).render('#paypal-button-container');
</script>
