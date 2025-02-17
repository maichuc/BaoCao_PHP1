<?php
// Lớp xử lý kết nối CSDL
class Database {
    private $servername = "localhost";
    private $username = "caulong";
    private $password = "123";
    private $dbname = "shop_caulong";
    public $conn;

    // Hàm khởi tạo để kết nối CSDL
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error); 
        }

        // Thiết lập mã hóa UTF-8
        $this->conn->set_charset("utf8mb4");
    }

    // Hàm đóng kết nối
    public function close() {
        $this->conn->close();
    }
}

// Lớp xử lý đăng ký người dùng
class Register {
    private $db;

    // Hàm khởi tạo nhận đối tượng database
    public function __construct($db) {
        $this->db = $db;
    }

    // Hàm kiểm tra tên đăng nhập đã tồn tại chưa
    public function kiemtraTonTai($username) {
        $stmt = $this->db->conn->prepare("SELECT * FROM khachhang WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Hàm thêm khách hàng vào bảng khachhang
    public function themKhachHang($username, $password, $hodem, $ten, $diachi, $diachinhanhang , $dienthoai) {
        $stmt = $this->db->conn->prepare("INSERT INTO khachhang (username, password, hodem, ten, diachi, diachinhanhang, dienthoai) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $username, $password, $hodem, $ten, $diachi, $diachinhanhang, $dienthoai);
        return $stmt->execute();
    }
}
?>
