<?php
class login
{
    public function connect()
    {
        $con = mysql_connect("localhost", "caulong", "123");
        if (!$con) {
            echo 'Không kết nối được cơ sở dữ liệu';
            exit();
        } else {
            mysql_select_db("shop_caulong");
            mysql_query("SET NAMES UTF8");
            return $con;
        }
    }
    
    public function mylogin($user, $pass, $table, $header)
    {
        $sql = "SELECT id, username, password, phanquyen FROM $table WHERE username='$user' AND password='$pass' LIMIT 1";
        $link = $this->connect();
        $ketqua = mysql_query($sql, $link);
        $i = mysql_num_rows($ketqua);
        if ($i == 1) {
            while ($row = mysql_fetch_array($ketqua)) {
                $id = $row['id'];    
                $myuser = $row['username'];    
                $mypass = $row['password'];    
                $phanquyen = $row['phanquyen'];    
                session_start();
                $_SESSION['id'] = $id;
                $_SESSION['user'] = $myuser;
                $_SESSION['pass'] = $mypass;
                $_SESSION['phanquyen'] = $phanquyen;
                
                // Gọi hàm lưu lịch sử đăng nhập
                $this->luuLichSuDangNhap($id, $table);
                
                header('location:' . $header);
                exit();
            }
        } else {
            return 0;
        }
    }
    
    public function luuLichSuDangNhap($id, $table)
    {
        $link = $this->connect();
        $thoigian = date("Y-m-d H:i:s");
        
        // Xác định loại người dùng để lưu lịch sử
        if ($table == "khachhang") {
            $idkhachhang = $id;
        } elseif ($table == "taikhoan") {
            // Nếu bạn muốn lưu lịch sử đăng nhập cho admin, cần tạo bảng lịch sử riêng hoặc xử lý tương tự
            // Ví dụ: Sử dụng bảng 'lichsu_dangnhap_admin'
            $idkhachhang = null; // Hoặc xử lý phù hợp
            return; // Nếu không muốn lưu cho admin, thoát hàm
        }
        
        if ($idkhachhang !== null) {
            // Thêm bản ghi mới vào bảng lịch sử đăng nhập
            $sql_insert = "INSERT INTO lichsu_dangnhap (idkhachhang, thoigian) VALUES ('$idkhachhang', '$thoigian')";
            mysql_query($sql_insert, $link);
            
            // Đếm số lượng lịch sử đăng nhập hiện tại
            $sql_count = "SELECT COUNT(*) as total FROM lichsu_dangnhap WHERE idkhachhang='$idkhachhang'";
            $result = mysql_query($sql_count, $link);
            $row = mysql_fetch_assoc($result);
            $total = $row['total'];
            
            // Nếu số lượng > 10, xóa các bản ghi cũ nhất
            if ($total > 10) {
                $limit = $total - 10;
                $sql_delete = "DELETE FROM lichsu_dangnhap WHERE idkhachhang='$idkhachhang' ORDER BY thoigian ASC LIMIT $limit";
                mysql_query($sql_delete, $link);
            }
        }
    }
    
    public function confirmlogin($id, $user, $pass, $phanquyen)
    {
        $sql = "SELECT id FROM taikhoan WHERE id='$id' AND username='$user' AND password='$pass' AND phanquyen='$phanquyen' LIMIT 1";
        $link = $this->connect();
        $ketqua = mysql_query($sql, $link);
        $i = mysql_num_rows($ketqua);
        if ($i != 1) {
            header('location:../login/');
            exit();
        }
    }
	
}
?>
