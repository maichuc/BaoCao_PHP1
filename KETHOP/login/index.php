<?php
session_start();
include("../myclass/clslogin.php");
$p = new login();
error_reporting(0);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.0.0-dist (1)/css/bootstrap.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400&family=Ephesis&family=Roboto:wght@300&family=Smooch+Sans:wght@100;200;400&display=swap" rel="stylesheet">
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
    #form_dangnhap {
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
    #form_dangnhap::before {
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
</style>

<body id="form_dangnhap">
    <div class="container-fluid ">
        <form id="form1" name="form1" method="post">
            <div class="my-auto ">
                <table width="526" height="234" border="1" align="center" class="">
                    <tbody>
                        <tr>
                            <td colspan="2" style="text-align: center"><strong>ĐĂNG NHẬP</strong></td>
                        </tr>
                        <tr>
                            <td width="175"><strong>Nhập username</strong></td>
                            <td width="335"><input name="txtuser" type="text" id="txtuser" size="40"></td>
                        </tr>
                        <tr>
                            <td><strong>Nhập password</strong></td>
                            <td><input name="txtpass" type="password" required="required" id="txtpass" size="40"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="btn btn-danger" type="submit" name="nut" id="nut" value="Đăng nhập">
                                <a href="../register/index.php" class="btn btn-primary">Đăng Ký</a>
                                <input class="btn btn-light" type="reset" name="reset" id="reset" value="Reset"><br>
                                <?php
                                /*echo md5('123456');*/
                                switch ($_POST['nut']) {
                                    case 'Đăng nhập': {
                                            $user = $_REQUEST['txtuser'];
                                            $pass = $_REQUEST['txtpass'];
                                            if ($user != '' && $pass != '') {
                                                if ($p->mylogin($user, $pass, "taikhoan", "../admin/GD_admin.php") == 0) {
                                                    echo 'Sai username hoặc password';
                                                }if ($p->mylogin($user, $pass, "khachhang", "../index.php") == 0) {
                                                    echo 'Sai email hoặc mật khẩu';
                                                }
                                            } else {
                                                echo 'Vui lòng nhập đủ username và password';
                                            }
                                            break;
                                        }
                                }

                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
        <div align="center">
        </div>
    </div>
</body>

</html>