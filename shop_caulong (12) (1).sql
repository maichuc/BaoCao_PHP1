-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 11:23 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_caulong`
--

-- --------------------------------------------------------

--
-- Table structure for table `congty`
--

CREATE TABLE `congty` (
  `idcty` int(11) NOT NULL,
  `tencty` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `diachi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dienthoai` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `congty`
--

INSERT INTO `congty` (`idcty`, `tencty`, `diachi`, `dienthoai`, `fax`) VALUES
(1, 'Li-Ning', 'Trung Quốc', '123456789', '987654321'),
(2, 'Yonex', 'Nhật Bản', '987654321', '123456789'),
(3, 'Victor', 'Đài Loan', '555555555', '666666666'),
(4, 'Mizuno', 'Nhật Bản', '012345678', '987654321'),
(5, 'Kumpoo', 'Trung Quốc', '098765432', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `dondathang`
--

CREATE TABLE `dondathang` (
  `dh_ma` int(11) NOT NULL,
  `idkhachhang` int(11) DEFAULT NULL,
  `dh_ngaylap` datetime DEFAULT NULL,
  `dh_ngaygiao` datetime DEFAULT NULL,
  `dh_noigiao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dh_trangthaithanhtoan` int(11) DEFAULT NULL,
  `httt_ma` int(11) DEFAULT NULL,
  `ten_nguoi_nhan` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sdt_nguoinhan` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_nguoinhan` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trangthai_don` enum('Chấp nhận đơn','Chờ xử lý','Đang giao hàng','Hoàn thành','Từ chối đơn','Hoàn trả') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Chờ xử lý'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dondathang`
--

INSERT INTO `dondathang` (`dh_ma`, `idkhachhang`, `dh_ngaylap`, `dh_ngaygiao`, `dh_noigiao`, `dh_trangthaithanhtoan`, `httt_ma`, `ten_nguoi_nhan`, `sdt_nguoinhan`, `email_nguoinhan`, `trangthai_don`) VALUES
(38, 1, '2024-10-19 21:34:36', NULL, '', NULL, 0, '', '', '', 'Hoàn thành'),
(39, 1, '2024-10-19 21:34:48', NULL, '', NULL, 0, '', '', '', 'Hoàn thành'),
(40, 1, '2024-10-19 23:48:54', NULL, '', 0, NULL, '', '000123456', NULL, 'Hoàn thành'),
(41, 1, '2024-10-19 23:51:08', NULL, '', 0, NULL, '', '12355', NULL, 'Hoàn thành'),
(42, 1, '2024-10-20 00:33:47', NULL, '12', NULL, 1, 'mai chuc12', '12', '', 'Đang giao hàng'),
(43, 1, '2024-10-20 00:52:38', NULL, '12', NULL, 1, 'chucnhu', '12', '', 'Chờ xử lý'),
(44, 1, '2024-10-20 00:54:27', NULL, '23', NULL, 1, 'chucbao', '1234', '', 'Chờ xử lý'),
(45, 1, '2024-10-20 00:59:55', NULL, 'd', NULL, 2, 'mai chuc', '14', '', 'Chờ xử lý'),
(46, 1, '2024-10-20 01:03:16', NULL, 'ưefrg', NULL, 1, 'mai chuc12345', '035555555678', '', 'Chờ xử lý'),
(47, 1, '2024-10-20 01:09:38', NULL, 'sdzv', NULL, 1, 'sdf', 'vdxf', '', 'Chờ xử lý'),
(48, 1, '2024-10-20 01:32:28', NULL, 'sx', NULL, 1, 'mai chuc21', 'qư', '', 'Chờ xử lý'),
(49, 1, '2024-10-20 01:44:36', NULL, '12,hcm', NULL, 1, 'mai chuc', '14', 'chuct2747@gmail.com', 'Hoàn thành'),
(50, 1, '2024-10-20 01:45:42', NULL, 'tt', NULL, 1, 'd', '000', '', 'Chờ xử lý'),
(51, 1, '2024-10-20 01:48:16', NULL, 'fdgb', NULL, 1, 'mai chucqwerfgth', '2345', 'chuct2747@gmail.com', 'Chờ xử lý'),
(52, 1, '2024-10-20 01:49:49', NULL, 'tt', NULL, 1, 'sd', '14', '', 'Chờ xử lý'),
(53, 1, '2024-10-20 01:51:41', NULL, 's', NULL, 2, 'mai chuc', '000123456', 'chuct2747@gmail.com', 'Chờ xử lý'),
(54, 1, '2024-10-20 01:53:02', NULL, 'tx25', NULL, 1, 'sd', '000', '', 'Chờ xử lý'),
(55, 1, '2024-10-20 01:54:20', NULL, 's', NULL, 1, 'sd', '14', '', 'Chờ xử lý'),
(56, 1, '2024-10-20 01:55:06', NULL, '12,hcm', NULL, 2, 'ad', '000', '', 'Chờ xử lý'),
(57, 1, '2024-10-20 18:18:30', NULL, '123', NULL, 1, 'mai chuc1234555', '12345', '', 'Chờ xử lý'),
(58, 1, '2024-10-20 18:49:24', NULL, 'ư', NULL, 1, 'mua', 'q', '', 'Chờ xử lý'),
(59, 1, '2024-10-20 18:50:45', NULL, '12,hcm', NULL, 1, 'mai chuc', '0355555556', '', 'Chờ xử lý'),
(60, 1, '2024-10-20 19:03:40', NULL, 'sf', NULL, 1, 'sd', 'sf', '', 'Chờ xử lý'),
(61, 1, '2024-10-20 20:00:47', NULL, '22', NULL, 1, 'abc', '123123', '', 'Chờ xử lý');

-- --------------------------------------------------------

--
-- Table structure for table `giohang`
--

CREATE TABLE `giohang` (
  `id` int(11) NOT NULL,
  `idkhachhang` int(11) NOT NULL,
  `idsp` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `tongtien` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `giohang`
--

INSERT INTO `giohang` (`id`, `idkhachhang`, `idsp`, `soluong`, `gia`, `tongtien`) VALUES
(1, 1, 36, 1, '900000.00', '900000.00');

-- --------------------------------------------------------

--
-- Table structure for table `hinhthucthanhtoan`
--

CREATE TABLE `hinhthucthanhtoan` (
  `httt_ma` int(11) NOT NULL,
  `httt_ten` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hinhthucthanhtoan`
--

INSERT INTO `hinhthucthanhtoan` (`httt_ma`, `httt_ten`) VALUES
(1, 'Tiền mặt'),
(2, 'Chuyển khoản'),
(3, 'Thẻ tín dụng');

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phanquyen` int(11) NOT NULL,
  `hodem` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `diachi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diachinhanhang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dienthoai` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `landangnhapgannhat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`id`, `username`, `password`, `phanquyen`, `hodem`, `ten`, `diachi`, `diachinhanhang`, `dienthoai`, `landangnhapgannhat`) VALUES
(1, 'khachhang1@gmail.com', '123456', 0, 'Nguyễn', 'An', 'Hà Nội', 'Hà Nội', '0123456789', NULL),
(2, 'khachhang2@gmail.com', '123456', 0, 'Trần', 'Bình', 'Đà Nẵng', 'Đà Nẵng', '0987654321', NULL),
(3, 'khachhang3@gmail.com', '123456', 0, 'Lê', 'Hùng', 'TP.HCM', 'TP.HCM', '0912345678', NULL),
(4, 'khachhang4@gmail.com', '123456', 0, 'Phạm', 'Minh', 'Hải Phòng', 'Hải Phòng', '0934567890', NULL),
(5, 'khachhang5@gmail.com', '123456', 0, 'Ngô', 'Thành', 'Cần Thơ', 'Cần Thơ', '0945678901', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lichsu_dangnhap`
--

CREATE TABLE `lichsu_dangnhap` (
  `id` int(11) NOT NULL,
  `idkhachhang` int(11) NOT NULL,
  `thoigian` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lichsu_dangnhap`
--

INSERT INTO `lichsu_dangnhap` (`id`, `idkhachhang`, `thoigian`) VALUES
(16, 1, '2024-10-05 10:10:18'),
(17, 1, '2024-10-05 12:16:24'),
(18, 1, '2024-10-05 13:04:38'),
(19, 1, '2024-10-05 14:32:50'),
(20, 1, '2024-10-05 17:52:38'),
(21, 1, '2024-10-07 03:02:53'),
(22, 1, '2024-10-18 17:11:25'),
(23, 1, '2024-10-19 11:36:22'),
(24, 1, '2024-10-19 18:21:49'),
(25, 1, '2024-10-20 23:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `id` int(11) NOT NULL,
  `tenloai` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loaisanpham`
--

INSERT INTO `loaisanpham` (`id`, `tenloai`) VALUES
(1, 'Cầu lông'),
(2, 'Vợt cầu lông'),
(3, 'Giày cầu lông'),
(4, 'Phụ kiện cầu lông'),
(5, 'Đồ thể thao khác');

-- --------------------------------------------------------

--
-- Table structure for table `sanpham`
--

CREATE TABLE `sanpham` (
  `id` int(11) NOT NULL,
  `tensp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gia` decimal(10,2) NOT NULL,
  `mota` text COLLATE utf8_unicode_ci NOT NULL,
  `hinh` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `giamgia` decimal(10,2) DEFAULT NULL,
  `idcty` int(11) DEFAULT NULL,
  `idloai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sanpham`
--

INSERT INTO `sanpham` (`id`, `tensp`, `gia`, `mota`, `hinh`, `giamgia`, `idcty`, `idloai`) VALUES
(1, 'Áo Cầu Lông Yonex Việt Nam Open TRM2920VNO24 - White', '450000.00', 'Áo cầu lông chính hãng Yonex, màu trắng.', 'ao-cau-long-yonex-viet-nam-open-trm2920vno24-white-chinh-hang_1727314517.png', '0.00', 2, 5),
(2, 'Áo Cầu Lông Yonex Việt Nam Open TRM2920VNO24 - Fiery Red', '450000.00', 'Áo cầu lông chính hãng Yonex, màu đỏ.', 'ao-cau-long-yonex-viet-nam-open-trm2920vno24-fiery-red-chinh-hang_1727314112.png', '0.00', 2, 5),
(3, 'Áo Cầu Lông Yonex VM1075 - Nữ, Xanh Tím', '420000.00', 'Áo cầu lông chính hãng Yonex, dành cho nữ.', 'ao-cau-long-yonex-vm1075-nu-xanh-tim_1726794158.png', '0.00', 2, 5),
(4, 'Áo Cầu Lông Yonex Việt Nam Open TRM2920VNO24 - Creamic', '450000.00', 'Áo cầu lông chính hãng Yonex, màu kem.', 'ao-cau-long-yonex-viet-nam-open-trm2920vno24-creamic-chinh-hang_1727314252.png', '0.00', 2, 5),
(5, 'Áo Cầu Lông Yonex Việt Nam Open TRM2920VNO24 - Surf The Web', '450000.00', 'Áo cầu lông chính hãng Yonex, màu xanh.', 'ao-cau-long-yonex-viet-nam-open-trm2920vno24-surf-the-web-chinh-hang_1727314390.png', '0.00', 2, 5),
(6, 'Giày Cầu Lông Yonex Aerus Z2 - Women, Tím Đen', '2100000.00', 'Giày cầu lông chính hãng Yonex dành cho nữ, màu tím đen.', 'giay-cau-long-yonex-aerus-z2-women-tim-den-chinh-hang-2.png', '200000.00', 2, 3),
(7, 'Giày Cầu Lông Yonex Comfort Z3 - Trắng Ma KR', '2500000.00', 'Giày cầu lông chính hãng Yonex, màu trắng.', 'giay-cau-long-yonex-comfort-z3-trang-ma-kr_1726003177.png', '300000.00', 2, 3),
(8, 'Giày Cầu Lông Yonex Comfort Z3 Wide - Trắng Ma JP', '2600000.00', 'Giày cầu lông chính hãng Yonex, bản rộng.', 'giay-cau-long-yonex-comfort-z3-wide-trang-ma-jp_1725310958.png', '250000.00', 2, 3),
(9, 'Giày Cầu Lông Yonex Power Cushion Comfort Z3 Women - Black Min Ma JP', '2200000.00', 'Giày cầu lông Yonex cho nữ, màu đen.', 'giay-cau-long-yonex-power-cushion-comfort-z3-women-blkmin-ma-jp_1725311408.png', '200000.00', 2, 3),
(10, 'Giày Cầu Lông Yonex Aerus Z2 - Men, Cam Hồng', '2150000.00', 'Giày cầu lông chính hãng Yonex cho nam, màu cam hồng.', 'giay-cau-long-yonex-aerus-z2-men-cam-hong-chinh-hang-2.png', '150000.00', 2, 3),
(11, 'Balo Cầu Lông Yonex BA12PAEX - Xanh Thẫm', '850000.00', 'Balo cầu lông chính hãng Yonex, màu xanh thẫm.', 'balo-cau-long-yonex-ba12paex-xanh-than-gc_1725494284.png', '100000.00', 2, 4),
(12, 'Balo Cầu Lông Yonex BA82412 - Đen', '780000.00', 'Balo cầu lông chính hãng Yonex, màu đen.', 'balo-cau-long-yonex-ba82412-den-gc_1725411765.png', '90000.00', 2, 4),
(13, 'Vợt Cầu Lông Victor Brave Sword LTD Pro', '3200000.00', 'Vợt cầu lông chuyên nghiệp, nội địa Đài Loan.', 'vot-cau-long-victor-brave-sword-ltd-pro-noi-dia-taiwan-jpg-4_1711143954.png', '0.00', 3, 2),
(14, 'Vợt Cầu Lông Victor Auraspeed 100X AC Limited', '3500000.00', 'Vợt cầu lông cao cấp, chính hãng.', 'vot-cau-long-victor-auraspeed-100x-tuc-ac-limited_1712605721.png', '0.00', 3, 2),
(15, 'Vợt Cầu Lông Victor Jetspeed S10 Nội Địa Trung', '3800000.00', 'Vợt cầu lông nội địa Trung Quốc, chuyên dụng.', 'vot-cau-long-victor-jetspeed-s10-noi-dia-trung_1724891537.png', '0.00', 3, 2),
(16, 'Vợt Cầu Lông Victor Ryuga Metallic China Open 2024', '4200000.00', 'Vợt cầu lông chính hãng Trung Quốc, phiên bản China Open 2024.', 'vot-cau-long-victor-ryuga-metallic-china-open-2024-noi-dia-trung_1726449913.png', '0.00', 3, 2),
(17, 'Vợt Cầu Lông Victor Artery Tec Ti-99 Nội Địa Đài Loan', '2800000.00', 'Vợt cầu lông nội địa Đài Loan, dòng Artery Tec.', 'vot-cau-long-victor-artery-tec-ti-99-noi-dia-taiwan_1714963544.png', '0.00', 3, 2),
(18, 'Giày Cầu Lông Victor A170 II AC Trắng Chính Hãng', '1400000.00', 'Giày cầu lông màu trắng, chính hãng.', 'giay-cau-long-victor-a170-ii-ac-trang-chinh-hang_1726177458.png', '100000.00', 3, 3),
(19, 'Giày Cầu Lông Victor A170 II B Xanh Chính Hãng', '1450000.00', 'Giày cầu lông màu xanh, chính hãng.', 'giay-cau-long-victor-a170-ii-b-xanh-chinh-hang_1726177225.png', '120000.00', 3, 3),
(20, 'Giày Cầu Lông Victor A362 AF Trắng Chính Hãng', '1500000.00', 'Giày cầu lông màu trắng, thiết kế mới.', 'giay-cau-long-victor-a362-af-trang-chinh-hang_1726176781.png', '150000.00', 3, 3),
(21, 'Giày Cầu Lông Victor A362 B Xanh Chính Hãng', '1500000.00', 'Giày cầu lông màu xanh, thiết kế đẹp.', 'giay-cau-long-victor-a362-b-xanh-chinh-hang-2_1726177589.png', '150000.00', 3, 3),
(22, 'Giày Cầu Lông Victor Crayon Shinchan A39CS-A Nội Địa Trung', '1600000.00', 'Giày cầu lông nội địa Trung Quốc, phiên bản Crayon Shinchan.', 'giay-cau-long-victor-crayon-shinchan-a39cs-a-noi-dia-trung_1719453287.png', '200000.00', 3, 3),
(23, 'Balo Cầu Lông Victor BR5024LJZ Xám Chính Hãng', '900000.00', 'Balo cầu lông màu xám, chính hãng.', 'balo-cau-long-victor-br5024ljz-xam-chinh-hang_1725064132.png', '50000.00', 3, 4),
(24, 'Balo Cầu Lông Victor BR5021 Đỏ Nội Địa Trung', '850000.00', 'Balo cầu lông màu đỏ, nội địa Trung.', 'balo-cau-long-victor-br5021-do-noi-dia-trung_1719954655.png', '40000.00', 3, 4),
(25, 'Balo Cầu Lông Victor BR5017C Đen Chính Hãng', '1000000.00', 'Balo cầu lông màu đen, chính hãng.', 'balo-cau-long-victor-br5017c-den-chinh-hang_1719954655.png', '60000.00', 3, 4),
(26, 'Vợt Cầu Lông Victor Brave Sword LTD Pro', '3200000.00', 'Vợt cầu lông chuyên nghiệp, nội địa Đài Loan.', 'vot-cau-long-victor-brave-sword-ltd-pro-noi-dia-taiwan-jpg-4_1711143954.png', '0.00', 3, 2),
(27, 'Vợt Cầu Lông Victor Auraspeed 100X AC Limited', '3500000.00', 'Vợt cầu lông cao cấp, chính hãng.', 'vot-cau-long-victor-auraspeed-100x-tuc-ac-limited_1712605721.png', '0.00', 3, 2),
(28, 'Vợt Cầu Lông Victor Jetspeed S10 Nội Địa Trung', '3800000.00', 'Vợt cầu lông nội địa Trung Quốc, chuyên dụng.', 'vot-cau-long-victor-jetspeed-s10-noi-dia-trung_1724891537.png', '0.00', 3, 2),
(29, 'Vợt Cầu Lông Victor Ryuga Metallic China Open 2024', '4200000.00', 'Vợt cầu lông chính hãng Trung Quốc, phiên bản China Open 2024.', 'vot-cau-long-victor-ryuga-metallic-china-open-2024-noi-dia-trung_1726449913.png', '0.00', 3, 2),
(30, 'Vợt Cầu Lông Victor Artery Tec Ti-99 Nội Địa Đài Loan', '2800000.00', 'Vợt cầu lông nội địa Đài Loan, dòng Artery Tec.', 'vot-cau-long-victor-artery-tec-ti-99-noi-dia-taiwan_1714963544.png', '0.00', 3, 2),
(31, 'Giày Cầu Lông Victor A170 II AC Trắng Chính Hãng', '1400000.00', 'Giày cầu lông màu trắng, chính hãng.', 'giay-cau-long-victor-a170-ii-ac-trang-chinh-hang_1726177458.png', '100000.00', 3, 3),
(32, 'Giày Cầu Lông Victor A170 II B Xanh Chính Hãng', '1450000.00', 'Giày cầu lông màu xanh, chính hãng.', 'giay-cau-long-victor-a170-ii-b-xanh-chinh-hang_1726177225.png', '120000.00', 3, 3),
(33, 'Giày Cầu Lông Victor A362 AF Trắng Chính Hãng', '1500000.00', 'Giày cầu lông màu trắng, thiết kế mới.', 'giay-cau-long-victor-a362-af-trang-chinh-hang_1726176781.png', '150000.00', 3, 3),
(34, 'Giày Cầu Lông Victor A362 B Xanh Chính Hãng', '1500000.00', 'Giày cầu lông màu xanh, thiết kế đẹp.', 'giay-cau-long-victor-a362-b-xanh-chinh-hang-2_1726177589.png', '150000.00', 3, 3),
(35, 'Giày Cầu Lông Victor Crayon Shinchan A39CS-A Nội Địa Trung', '1600000.00', 'Giày cầu lông nội địa Trung Quốc, phiên bản Crayon Shinchan.', 'giay-cau-long-victor-crayon-shinchan-a39cs-a-noi-dia-trung_1719453287.png', '200000.00', 3, 3),
(36, 'Balo Cầu Lông Victor BR5024LJZ Xám Chính Hãng', '900000.00', 'Balo cầu lông màu xám, chính hãng.', 'balo-cau-long-victor-br5024ljz-xam-chinh-hang_1725064132.png', '50000.00', 3, 4),
(37, 'Balo Cầu Lông Victor BR5021 Đỏ Nội Địa Trung', '850000.00', 'Balo cầu lông màu đỏ, nội địa Trung.', 'balo-cau-long-victor-br5021-do-noi-dia-trung_1719954655.png', '40000.00', 3, 4),
(38, 'Balo Cầu Lông Victor BR5017C Đen Chính Hãng', '1000000.00', 'Balo cầu lông màu đen, chính hãng.', 'balo-cau-long-victor-br5017c-den-chinh-hang_1719954655.png', '60000.00', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sanpham_dondathang`
--

CREATE TABLE `sanpham_dondathang` (
  `id` int(11) NOT NULL,
  `dh_ma` int(11) DEFAULT NULL,
  `idsp` int(11) DEFAULT NULL,
  `sp_dh_soluong` int(11) DEFAULT NULL,
  `sp_dh_dongia` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sanpham_dondathang`
--

INSERT INTO `sanpham_dondathang` (`id`, `dh_ma`, `idsp`, `sp_dh_soluong`, `sp_dh_dongia`) VALUES
(1, 49, 8, 1, 2600000),
(2, 50, 10, 1, 2150000),
(3, 51, 35, 1, 1600000),
(4, 52, 37, 1, 850000),
(5, 53, 11, 1, 850000),
(6, 54, 3, 1, 420000),
(7, 55, 21, 1, 1500000),
(8, 56, 23, 1, 900000),
(9, 56, 35, 1, 1600000),
(10, 57, 35, 2, 1600000),
(11, 57, 8, 1, 2600000),
(12, 58, 17, 1, 2800000),
(13, 59, 31, 1, 1400000),
(14, 60, 24, 1, 850000),
(15, 61, 1, 1, 450000);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phanquyen` int(11) NOT NULL,
  `lichsu_dangnhap` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `username`, `password`, `phanquyen`, `lichsu_dangnhap`) VALUES
(1, 'admin', '123', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `congty`
--
ALTER TABLE `congty`
  ADD PRIMARY KEY (`idcty`);

--
-- Indexes for table `dondathang`
--
ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`dh_ma`),
  ADD KEY `idkhachhang` (`idkhachhang`),
  ADD KEY `httt_ma` (`httt_ma`);

--
-- Indexes for table `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idkhachhang` (`idkhachhang`),
  ADD KEY `idsp` (`idsp`);

--
-- Indexes for table `hinhthucthanhtoan`
--
ALTER TABLE `hinhthucthanhtoan`
  ADD PRIMARY KEY (`httt_ma`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `username_2` (`username`);

--
-- Indexes for table `lichsu_dangnhap`
--
ALTER TABLE `lichsu_dangnhap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idkhachhang` (`idkhachhang`);

--
-- Indexes for table `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcty` (`idcty`),
  ADD KEY `idloai` (`idloai`);

--
-- Indexes for table `sanpham_dondathang`
--
ALTER TABLE `sanpham_dondathang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dh_ma` (`dh_ma`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `congty`
--
ALTER TABLE `congty`
  MODIFY `idcty` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `dondathang`
--
ALTER TABLE `dondathang`
  MODIFY `dh_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `giohang`
--
ALTER TABLE `giohang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `hinhthucthanhtoan`
--
ALTER TABLE `hinhthucthanhtoan`
  MODIFY `httt_ma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `lichsu_dangnhap`
--
ALTER TABLE `lichsu_dangnhap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `sanpham_dondathang`
--
ALTER TABLE `sanpham_dondathang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `dondathang`
--
ALTER TABLE `dondathang`
  ADD CONSTRAINT `dondathang_ibfk_1` FOREIGN KEY (`idkhachhang`) REFERENCES `khachhang` (`id`);

--
-- Constraints for table `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`idkhachhang`) REFERENCES `khachhang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `giohang_ibfk_2` FOREIGN KEY (`idsp`) REFERENCES `sanpham` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lichsu_dangnhap`
--
ALTER TABLE `lichsu_dangnhap`
  ADD CONSTRAINT `lichsu_dangnhap_ibfk_1` FOREIGN KEY (`idkhachhang`) REFERENCES `khachhang` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`idcty`) REFERENCES `congty` (`idcty`),
  ADD CONSTRAINT `sanpham_ibfk_2` FOREIGN KEY (`idloai`) REFERENCES `loaisanpham` (`id`);

--
-- Constraints for table `sanpham_dondathang`
--
ALTER TABLE `sanpham_dondathang`
  ADD CONSTRAINT `sanpham_dondathang_ibfk_1` FOREIGN KEY (`dh_ma`) REFERENCES `dondathang` (`dh_ma`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
