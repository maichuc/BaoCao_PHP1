<?php
// Bao gồm tệp chứa class
include("../myclass/clsregister.php");
?>

<!-- Form đăng ký -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist (1)/css/bootstrap.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400&family=Ephesis&family=Roboto:wght@300&family=Smooch+Sans:wght@100;200;400&display=swap" rel="stylesheet">
    <title>Đăng ký</title>
</head>
<style>
    /* Phần tử chính chứa ảnh nền */
	*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Smooch Sans', sans-serif;
	font-size:25px;
}
    #form_dangky {
        position: relative;
        min-height: 100vh;
        background-image: url(../img/badminton-1428046_1920.jpg);
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Lớp phủ màu đen trong suốt */
    #form_dangky::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        /* Lớp phủ đen trong suốt */
        z-index: 1;
        /* Đặt lớp phủ phía trên ảnh nền */
    }

    /* Đảm bảo nội dung hiển thị trên lớp phủ */
    .container-fluid {
        position: relative;
        z-index: 2;
        /* Nội dung hiển thị trên lớp phủ */
        display: flex;
        justify-content: center;
        align-items: center;

    }

    table {
        background-color: rgba(255, 255, 255, 0.8);
        /* Đặt nền trắng cho form với độ trong suốt */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        text-align: center;
    }

    .canchinh {
        text-align: left;
        padding: 20px;
    }
</style>

<body id="form_dangky">
    <div class="container-fluid">
        <form id="form1" name="form1" method="POST" action="index.php">
            <div class="my-auto ">
                <table width="600" height="400" border="1" align="center" class="">
                    <tbody>
                        <tr>
                            <td height="50px" colspan="2" style="text-align: center"><strong>ĐĂNG KÝ</strong></td>
                        </tr>
                        <tr>
                            <td class="canchinh" width="175"><strong>Tên đăng nhập:</strong></td>
                            <td width="335"><input name="username" type="text" id="username" size="40" required></td>
                        </tr>

                        <tr>
                            <td class="canchinh" width="175"><strong>Mật khẩu:</strong></td>
                            <td width="335"><input type="password" id="password" name="password" size="40" required><br></td>
                        </tr>

                        <tr>
                            <td class="canchinh" width="175"><strong>Họ đệm:</strong></td>
                            <td width="335"><input type="text" id="hodem" name="hodem" size="40" required></td>
                        </tr>

                        <tr>
                            <td class="canchinh" width="175"><strong>Tên:</strong></td>
                            <td width="335"><input type="text" id="ten" name="ten" size="40" required></td>
                        </tr>

                        <tr>
                            <td class="canchinh" width="175"><strong>Địa chỉ:</strong></td>
                            <td width="335"><input type="text" id="diachi" name="diachi" size="40" required></td>
                        </tr>

                        <tr>
                            <td class="canchinh" width="175"><strong>Địa chỉ Nhận Hàng:</strong></td>
                            <td width="335"><input type="text" id="diachinhanhang" name="diachinhanhang" size="40" required></td>
                        </tr>

                        <tr>
                            <td class="canchinh" width="175"><strong>Số điện thoại:</strong></td>
                            <td width="335"><input type="text" id="dienthoai" name="dienthoai" size="40" required></td>
                        </tr>

                        <tr>
                            <td height="50px" colspan="2"><input class="btn btn-primary" type="submit" value="Đăng ký">
                            <input class="btn btn-light" type="reset" name="reset" id="reset" value="Reset">
                            <?php
                                // Xử lý yêu cầu đăng ký
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    // Tạo đối tượng Database
                                    $db = new Database();

                                    // Tạo đối tượng Register
                                    $register = new Register($db);

                                    // Nhận dữ liệu từ form
                                    $username = $_POST["username"];
                                    $password = $_POST["password"];
                                    $hodem = $_POST["hodem"];
                                    $ten = $_POST["ten"];
                                    $diachi = $_POST["diachi"];
                                    $diachinhanhang = $_POST["diachinhanhang"];
                                    $dienthoai = $_POST["dienthoai"];

                                    // Kiểm tra tên đăng nhập có tồn tại chưa
                                    if ($register->kiemtraTonTai($username)) {
                                        echo "Tên đăng nhập đã tồn tại!";
                                    } else {

                                        // Thêm thông tin khách hàng vào bảng khachhang
                                        if ($register->themKhachHang($username, $password, $hodem, $ten, $diachi, $diachinhanhang, $dienthoai)) {
                                            echo "Đăng ký thành công! Bạn có thể <a href='/KETHOP/login/'>đăng nhập</a>.";
                                        } else {
                                            echo "Lỗi khi thêm vào bảng khách hàng.";
                                        }
                                    }

                                    // Đóng kết nối CSDL
                                    $db->close();
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

</body>

</html>