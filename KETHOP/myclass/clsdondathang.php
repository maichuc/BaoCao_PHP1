<?php
include("clstmdt.php");

class dondathang extends tmdt {

    // Phương thức lấy mã đơn hàng mới nhất của khách hàng
    public function LayMaDonHangCuoi($idkhachhang) {
        $sql = "SELECT dathang_ma FROM dathang WHERE idkhachhang='$idkhachhang' ORDER BY dathang_ma DESC LIMIT 1";
        return $this->Laycot($sql);
    }

    // Phương thức lấy chi tiết đơn hàng
    public function LayChiTietDonHang($dathang_ma, $idkhachhang) {
        $sql = "SELECT * FROM dathang WHERE dathang_ma='$dathang_ma' AND idkhachhang='$idkhachhang' LIMIT 1";
        return $this->Laydong($sql);
    }








    // Phương thức lấy thông tin phương thức thanh toán
    public function LayPhuongThucThanhToan($dathang_ma) {
        $sql = "SELECT httt_ma FROM dathang WHERE dathang_ma='$dathang_ma'";
        return $this->Laycot($sql);
    }

    // Phương thức lấy cột cụ thể
    public function Laycot($sql) {
        $link = $this->connect();
        $ketqua = mysql_query($sql, $link);
        if ($ketqua) {
            $row = mysql_fetch_array($ketqua);
            return $row[0]; // Trả về giá trị của cột đầu tiên
        } else {
            return false; // Nếu không có dữ liệu
        }
    }

    // Phương thức lấy dòng cụ thể
    public function Laydong($sql) {
        $link = $this->connect();
        $ketqua = mysql_query($sql, $link);
        if ($ketqua) {
            return mysql_fetch_array($ketqua); // Trả về một dòng
        } else {
            return false; // Nếu không có dữ liệu
        }
    }
}
?>
