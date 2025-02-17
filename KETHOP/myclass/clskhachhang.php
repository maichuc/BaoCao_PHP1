<?php
include("clstmdt.php");

class khachhang extends tmdt
{
    // Phương thức xuất sản phẩm
    public function xuatsanpham($sql) {
        $link = $this->connect();
        $ketqua = mysql_query($sql, $link);
        if (!$ketqua) {
            echo "Lỗi SQL: " . mysql_error();
            return;
        }
        $i = mysql_num_rows($ketqua);
        
        echo '<div class="product-container">';
        echo '<div class="product-grid">';

        if ($i > 0) {
            $count = 0;
            while ($row = mysql_fetch_array($ketqua)) {
                $idsp = $row['id'];
                $tensp = htmlspecialchars($row['tensp']);
                $hinh = $row['hinh'];
                $gia = $row['gia'];

                echo '<div class="pro">
                        <div class="product-image">
                            <a href="chitietsanpham.php?id=' . $idsp . '">
                                <img src="hinh/' . $hinh . '" alt="' . $tensp . '" style="width: 230px; height: 200px;"/>
                            </a>
                        </div>
                        <div class="des">
                            <h5>' . $tensp . '</h5>
                            <div class="star">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <h4>' . number_format($gia) . ' VNĐ</h4>
                        </div>
                        <form method="post" action="#">
                            <input type="hidden" name="nut" value="Thêm vào giỏ hàng">
                            <input type="hidden" name="idsp" value="' . $idsp . '">
                            <input type="hidden" name="soluong" value="1"> 
                            <input type="hidden" name="gia" value="' . $gia . '">
                            <button type="submit" class="btn " name="nut" value="Thêm vào giỏ hàng">
                                <i class="bi bi-cart-fill cart"></i> Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>';

                $count++;

                if ($count % 4 == 0) {
                    echo '</div><div class="product-grid">';
                }
            }
        } else {
            echo '<p>Đang cập nhật sản phẩm.</p>';
        }
        
        echo '</div></div>';
    }

    // Phương thức xuất danh sách công ty
    public function xuatdanhsachcongty($sql) {
        $link = $this->connect();
        $ketqua = mysql_query($sql, $link);
        if (!$ketqua) {
            echo "Lỗi SQL: " . mysql_error();
            return;
        }
        $i = mysql_num_rows($ketqua);
        if ($i > 0) {
            echo '<a href="index.php">Tất cả sản phẩm</a>';
            echo '<br>';
            while ($row = mysql_fetch_array($ketqua)) {
                $idcty = $row['idcty'];
                $tencty = $row['tencty'];
                echo '<a href="index.php?id=' . $idcty . '">' . $tencty . '</a>';
                echo '<br>';
            }
        } else {
            echo 'Đang cập nhật công ty.';    
        }
    }

public function xemchitietsanpham($sql) {
    $link = $this->connect();
    $ketqua = mysql_query($sql, $link);
    if (!$ketqua) {
        echo "Lỗi SQL: " . mysql_error();
        return;
    }
    $i = mysql_num_rows($ketqua);
    if ($i > 0) {
        // Thêm một div bao quanh product-detail
       echo '<div class="product-container">';
while ($row = mysql_fetch_array($ketqua)) {
    $idsp = $row['id'];
    $tensp = htmlspecialchars($row['tensp']);
    $gia = $row['gia'];
    $mota = htmlspecialchars($row['mota']);
    $hinh = $row['hinh'];
    $idcty = $row['idcty'];
    $tencty = $this->Laycot("SELECT tencty FROM congty WHERE idcty='$idcty' LIMIT 1");

    echo '<div class="product-detail">
            <div class="product-detail-image">
                <img src="hinh/' . $hinh . '" alt="' . $tensp . '" class="img-responsive"/>
            </div>
            <div class="product-detail-info">
                <h3 class="product-name">' . $tensp . '</h3>
                <h4 class="product-price">' . number_format($gia) . ' VNĐ</h4>
                <p class="product-description">' . $mota . '</p>
                
                <div class="size-color-options">
                    <div class="sizes">
                        <p><strong>Kích thước:</strong></p>
                        <form>
                            <label><input type="radio" name="size" value="XS"> XS</label>
                            <label><input type="radio" name="size" value="S"> S</label>
                            <label><input type="radio" name="size" value="M"> M</label>
                            <label><input type="radio" name="size" value="L"> L</label>
                            <label><input type="radio" name="size" value="XL"> XL</label>
                        </form>
                    </div>
                    <div class="colors">
                        <p><strong>Màu sắc:</strong></p>
                        <form>
                            <label><input type="radio" name="color" value="Black"> Đen</label>
                            <label><input type="radio" name="color" value="White"> Trắng</label>
                            <label><input type="radio" name="color" value="Red"> Đỏ</label>
                            <label><input type="radio" name="color" value="Blue"> Xanh dương</label>
                            <label><input type="radio" name="color" value="Green"> Xanh lá</label>
                        </form>
                    </div>
                </div>

                <div class="quantity-section">
                    <form method="post" action="#">
                        <input type="hidden" name="nut" value="Thêm vào giỏ hàng">
                        <input type="hidden" name="idsp" value="' . $idsp . '">
                        <label for="soluong">Số lượng:</label>
                        <input type="number" name="soluong" value="1" min="1" style="width: 50px;">
                        <input type="hidden" name="gia" value="' . $gia . '">
                        <button type="submit" class="btn btn-add-to-cart">
                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </button>
                    </form>';
                    
                    if (!isset($_SESSION['id']) || !isset($_SESSION['user']) || !isset($_SESSION['pass']) || !isset($_SESSION['phanquyen'])) {
                        echo '<div class="alert alert-warning" role="alert" style="margin-top: 10px;">
                                <strong>Thông báo:</strong> Vui lòng <a href="./login/" class="alert-link">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.
                              </div>';
                    }

                echo '</div>
            </div>
          </div>'; // Kết thúc product-detail
}
echo '</div>'; // Kết thúc product-container

    } else {
        echo 'Không có dữ liệu!';    
    }
}


    // Phương thức thêm sản phẩm vào giỏ hàng trong cơ sở dữ liệu
    public function themGioHang($idkh, $idsp, $soluong, $gia) {
        $sqlCheck = "SELECT * FROM giohang WHERE idkhachhang='$idkh' AND idsp='$idsp' LIMIT 1";
        $result = mysql_query($sqlCheck);
        if (!$result) {
            return 0;
        }
        if (mysql_num_rows($result) > 0) {
            $sqlUpdate = "UPDATE giohang SET soluong = soluong + '$soluong', tongtien = (soluong + '$soluong') * gia WHERE idkhachhang='$idkh' AND idsp='$idsp'";
            return $this->themxoasua($sqlUpdate);
        } else {
            $tongtien = $soluong * $gia;
            $sqlInsert = "INSERT INTO giohang (idkhachhang, idsp, soluong, gia, tongtien) VALUES ('$idkh', '$idsp', '$soluong', '$gia', '$tongtien')";
            return $this->themxoasua($sqlInsert);
        }
    }

  public function layGioHang($idkh) {
    $sql = "SELECT * FROM giohang WHERE idkhachhang = '$idkh'";
	$link = $this->connect();
    $result = mysql_query($sql, $link); // Giả sử query là phương thức thực hiện truy vấn và trả về kết quả

    return $result; // Đảm bảo phương thức này trả về một mảng đúng
}

    // Phương thức xóa sản phẩm khỏi giỏ hàng trong cơ sở dữ liệu
    public function xoaSanPhamGioHang($idkh, $idsp) {
        $sql = "DELETE FROM giohang WHERE idkhachhang='$idkh' AND idsp='$idsp'";
        return $this->themxoasua($sql);
    }

    // Phương thức cập nhật số lượng sản phẩm trong giỏ hàng
    public function capNhatSoLuong($idkh, $idsp, $soluong) {
        $sql = "UPDATE giohang SET soluong='$soluong', tongtien=gia*soluong WHERE idkhachhang='$idkh' AND idsp='$idsp'";
        return $this->themxoasua($sql);
    }

    // Phương thức thực hiện thanh toán
    public function thucHienThanhToan($idkh, $diachi, $sdt) {
        $sql = "INSERT INTO donhang (idkhachhang, ngaymua, diachi, sdt, trangthai) VALUES ('$idkh', NOW(), '$diachi', '$sdt', '0')";
        if ($this->themxoasua($sql)) {
            $iddh = mysql_insert_id();
            $sqlLayGioHang = "SELECT * FROM giohang WHERE idkhachhang='$idkh'";
            $giohang = $this->query($sqlLayGioHang);
            if ($giohang) {
                foreach ($giohang as $item) {
                    $idsp = $item['idsp'];
                    $soluong = $item['soluong'];
                    $gia = $item['gia'];
                    $tongtien = $item['tongtien'];
                    $sqlChitiet = "INSERT INTO chitietdonhang (iddh, idsp, soluong, gia, tongtien) VALUES ('$iddh', '$idsp', '$soluong', '$gia', '$tongtien')";
                    $this->themxoasua($sqlChitiet);
                }
            }
            $this->xoaGioHang($idkh);
            return 1;
        }
        return 0;
    }

    // Phương thức xóa giỏ hàng
    public function xoaGioHang($idkh) {
        $sql = "DELETE FROM giohang WHERE idkhachhang='$idkh'";
        return $this->themxoasua($sql);
    }

    // Phương thức lấy lịch sử đăng nhập
    public function layLichSuDangNhap($idkh) {
        $sql = "SELECT * FROM lichsu_dangnhap WHERE idkhachhang='$idkh' ORDER BY ngay DESC LIMIT 10";
        return $this->query($sql);
    }
	
	public function giohang()
{
    $idkh = $_SESSION['id'];
    $sql = "SELECT giohang.idsp, sanpham.tensp, giohang.soluong, giohang.gia, giohang.tongtien 
            FROM giohang 
            JOIN sanpham ON giohang.idsp = sanpham.id 
            WHERE giohang.idkhachhang = '$idkh'";
    $result = mysql_query($sql);
    
    if (mysql_num_rows($result) > 0) {
        echo '<table class="table table-striped table-bordered">';
        echo '<thead class="thead-light"><tr><th>STT</th><th>Tên sản phẩm</th><th>Số lượng</th><th>Giá</th><th>Tổng tiền</th><th>Thao tác</th></tr></thead>';
        echo '<tbody>';

        $stt = 1; // Số thứ tự bắt đầu từ 1
        while ($row = mysql_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $stt++ . '</td>'; // Tăng STT tự động
            echo '<td>' . htmlspecialchars($row['tensp']) . '</td>';
            echo '<td class="text-center">'; // Căn giữa số lượng
            // Điều chỉnh vị trí nút tăng giảm số lượng
            echo '<a href="giohang.php?action=increase&idsp=' . $row['idsp'] . '" class="btn btn-sm btn-success">+</a>';
            echo ' ' . htmlspecialchars($row['soluong']) . ' '; // Hiển thị số lượng
            echo '<a href="giohang.php?action=decrease&idsp=' . $row['idsp'] . '" class="btn btn-sm btn-warning">-</a>';
            echo '</td>';
            echo '<td>' . number_format($row['gia'], 0, ',', '.') . ' VND</td>';
            echo '<td>' . number_format($row['tongtien'], 0, ',', '.') . ' VND</td>';
            echo '<td>';
            echo '<a href="giohang.php?action=remove&idsp=' . $row['idsp'] . '" class="btn btn-sm btn-danger">Xóa</a>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

    
    } else {
        echo '<div class="alert alert-info text-center" style="margin-top: 20px;">Giỏ hàng của bạn đang trống.</div>';
    }
}

// Phương thức xử lý đơn hàng
public function xuLyDatHang($data) {
    $idkh = $data['idkh'];
    $tenNguoiNhan = mysql_real_escape_string($data['ten_nguoi_nhan']);
    $sdtNguoiNhan = mysql_real_escape_string($data['sdt']);
    $emailNguoiNhan = mysql_real_escape_string($data['email']);
    $diaChiGiao = mysql_real_escape_string($data['diachi_giao']);
    $hinhThucThanhToan = (int)$data['hinhthuc_thanh_toan'];
    $trangThaiDon = 'Chờ xử lý'; // Đặt mặc định trạng thái đơn hàng là "Chờ xử lý"

    // Lưu đơn đặt hàng vào bảng `dondathang`
    $sqlInsertDonDatHang = "INSERT INTO dondathang (idkhachhang, dh_ngaylap, dh_noigiao, httt_ma, ten_nguoi_nhan, sdt_nguoinhan, email_nguoinhan, trangthai_don) 
                            VALUES ('$idkh', NOW(), '$diaChiGiao', '$hinhThucThanhToan', '$tenNguoiNhan', '$sdtNguoiNhan', '$emailNguoiNhan', '$trangThaiDon')";
    
    if (mysql_query($sqlInsertDonDatHang)) {
        $dh_ma = mysql_insert_id(); // Lấy mã đơn hàng vừa tạo

        // Lấy các sản phẩm từ giỏ hàng của khách hàng
        $sqlGioHang = "SELECT * FROM giohang WHERE idkhachhang='$idkh'";
        $resultGioHang = mysql_query($sqlGioHang);
        
        while ($row = mysql_fetch_assoc($resultGioHang)) {
            // Chèn sản phẩm vào bảng `sanpham_dondathang`
            $sqlInsertSPDonDatHang = "INSERT INTO sanpham_dondathang (dh_ma, idsp, sp_dh_soluong, sp_dh_dongia) 
                                       VALUES ('$dh_ma', '{$row['idsp']}', '{$row['soluong']}', '{$row['gia']}')";
            mysql_query($sqlInsertSPDonDatHang);
        }
        
        // Xóa giỏ hàng sau khi đặt hàng thành công
        $sqlXoaGioHang = "DELETE FROM giohang WHERE idkhachhang='$idkh'";
        mysql_query($sqlXoaGioHang);
        
        return true; // Đặt hàng thành công
    }
    return false; // Đặt hàng không thành công
}


}

?>
