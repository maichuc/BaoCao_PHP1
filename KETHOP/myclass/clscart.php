<?php
class GioHang {
    // Hàm thêm sản phẩm vào giỏ hàng
    public function themSanPham($idsp, $soluong) {
        if (isset($_SESSION['gio_hang'][$idsp])) {
            $_SESSION['gio_hang'][$idsp] += $soluong; // Tăng số lượng nếu sản phẩm đã tồn tại
        } else {
            $_SESSION['gio_hang'][$idsp] = $soluong; // Thêm sản phẩm mới vào giỏ hàng
        }
    }

    // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    public function capNhatSoLuong($idsp, $hanhDong) {
        if (isset($_SESSION['gio_hang'][$idsp])) {
            if ($hanhDong == 'tang') {
                $_SESSION['gio_hang'][$idsp]++; // Tăng số lượng
            } elseif ($hanhDong == 'giam' && $_SESSION['gio_hang'][$idsp] > 1) {
                $_SESSION['gio_hang'][$idsp]--; // Giảm số lượng nếu lớn hơn 1
            }
        }
    }

    // Hàm xử lý yêu cầu từ form
    public function xuLyYeuCau() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $idsp = $_POST['idsp']; // ID sản phẩm
            $hanhDong = $_POST['hanh_dong']; // Hành động

            if ($hanhDong == 'them') {
                $soluong = $_POST['soluong']; // Mặc định số lượng là 1 nếu không có
                $this->themSanPham($idsp, $soluong); // Thêm sản phẩm vào giỏ hàng
            } else if ($hanhDong == 'tang' || $hanhDong == 'giam') {
                $this->capNhatSoLuong($idsp, $hanhDong); // Cập nhật số lượng sản phẩm
            }
        }
    }

    // Hàm hiển thị giỏ hàng
    public function hienThiGioHang() {
        if (empty($_SESSION['gio_hang'])) {
            echo "<p>Giỏ hàng trống.</p>";
            return;
        }

        echo "<table border='1'>";
        echo "<tr><th>ID Sản phẩm</th><th>Số lượng</th><th>Hành động</th></tr>";
        foreach ($_SESSION['gio_hang'] as $idsp => $soluong) {
            echo "<tr>";
            echo "<td>$idsp</td>";
            echo "<td>$soluong</td>";
            echo "<td>
                    <form method='POST' action=''>
                        <input type='hidden' name='idsp' value='$idsp'>
                        <input type='hidden' name='hanh_dong' value='tang'>
                        <button type='submit'>+</button>
                    </form>
                    <form method='POST' action=''>
                        <input type='hidden' name='idsp' value='$idsp'>
                        <input type='hidden' name='hanh_dong' value='giam'>
                        <button type='submit'>-</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    }
	// Hàm đặt hàng
    public function datHang($idkh, $diaChiGiaoHang) {
        if (empty($_SESSION['gio_hang'])) {
            return false; // Giỏ hàng rỗng
        }

        // Tạo mã đơn hàng
        $maDonHang = uniqid('DH'); // Hoặc bạn có thể tạo mã theo cách khác

        // Thêm đơn hàng vào bảng dondathang
        $sqlInsertDonDatHang = "INSERT INTO dondathang (dh_ma, idkhachhang, dh_ngaylap, dh_noigiao) 
                                 VALUES ('$maDonHang', '$idkh', NOW(), '$diaChiGiaoHang')";
        $this->themxoasua($sqlInsertDonDatHang);

        // Tính tổng tiền
        $tongTien = 0;
        foreach ($_SESSION['gio_hang'] as $idsp => $soluong) {
            $gia = $this->Laycot("SELECT gia FROM sanpham WHERE id='$idsp'");
            $tongTien += $soluong * $gia;

            // Thêm sản phẩm vào bảng giohang
            $sqlInsertGioHang = "INSERT INTO giohang (idkhachhang, idsp, soluong, gia, tongtien) 
                                 VALUES ('$idkh', '$idsp', '$soluong', '$gia', '$tongTien')";
            $this->themxoasua($sqlInsertGioHang);
        }

        // Lưu thông tin đơn hàng vào session để sử dụng sau này
        $_SESSION['order_info'] = [
            'dh_ma' => $maDonHang,
            'diachi_giao' => $diaChiGiaoHang,
            'tongTien' => $tongTien
        ];

        // Xóa giỏ hàng sau khi đặt hàng thành công
        unset($_SESSION['gio_hang']);

        return true;
    }
}
?>
