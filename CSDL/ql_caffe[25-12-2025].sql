-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 25, 2025 lúc 09:12 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ql_caffe`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `ID_bill` varchar(20) NOT NULL,
  `Day` datetime NOT NULL,
  `Total` float NOT NULL,
  `ID_TB` varchar(20) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `bill_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`ID_bill`, `Day`, `Total`, `ID_TB`, `ID`, `bill_status`) VALUES
('B051131', '2025-12-22 11:11:31', 25000, 'TB_02', 'NV001', 1),
('B095923', '2025-12-23 15:59:23', 45000, 'TB_04', 'NV001', 1),
('B100417', '2025-12-23 16:04:17', 60000, 'TB_03', 'NV001', 1),
('B152310', '2025-12-22 21:23:10', 50000, 'TB_02', 'NV001', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `details_order`
--

CREATE TABLE `details_order` (
  `food_name` varchar(30) NOT NULL,
  `id_food` varchar(20) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL,
  `ID_bill` varchar(20) NOT NULL,
  `name_KH` varchar(30) NOT NULL,
  `phonenumber` varchar(10) NOT NULL,
  `ID_TB` varchar(20) NOT NULL,
  `item_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id_food` varchar(20) NOT NULL,
  `food_name` varchar(50) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(30) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id_food`, `food_name`, `price`, `image`, `type`) VALUES
('BA_01', 'Bánh Sừng Bò', 30000, 'banh_croissant.png', 'Khác'),
('BA_02', 'Bánh SandWich', 25000, 'banh_sandwich.png', 'Khác'),
('BA_03', 'Bánh Tiramisu', 35000, 'banh_tiramisu.png', 'Khác'),
('BS_01', 'Bạc Xỉu', 20000, 'bac_xiu.png', 'Coffee'),
('CF_01', 'Cafe Đen Đá', 20000, 'capheden.jpg', 'Coffee'),
('CF_02', 'Cafe Sữa Đá', 25000, 'cafe_sua_da.png', 'Coffee'),
('CF_03', 'Cafe Espresso Nóng', 35000, 'espresso_nong.png', 'Coffee'),
('NE_01', 'Nước Ép Cam', 25000, 'nuoc_cam_ep.png', 'Nước ép'),
('NE_02', 'Nước Chanh Dây	', 25000, 'nuoc_chanh_day.png', 'Nước ép'),
('NG_01', 'Sting', 15000, 'sting.jpg', 'Nước ngọt'),
('NG_02', 'Cocacola', 15000, 'coca.jpg', 'Nước ngọt'),
('NG_03', 'Nước Suối', 10000, 'nuoc_suoi.jpg', 'Nước ngọt'),
('NG_04', 'Pepsi', 15000, 'pepsi.jpg', 'Nước ngọt'),
('NG_05', 'Red Bull', 20000, 'redbull.jpg', 'Nước ngọt'),
('NG_06', 'Wakeup 247', 20000, '247.jpg', 'Nước ngọt'),
('NG_07', 'Monter', 30000, 'monter.jpg', 'Nước ngọt'),
('SD_01', 'Soda Chanh', 25000, 'nuoc_chanh_day.png', 'Khác'),
('ST_01', 'Sinh Tố Dâu', 15000, 'sinhtodau.jpg', 'Sinh tố'),
('TR_01', 'Trà Đào Cam Xả', 20000, 'tra_dao_cam_sa.png', 'Trà'),
('TR_02', 'Trà Vải', 25000, 'tra_vai.png', 'Trà'),
('TR_03', 'Trà Chanh', 25000, 'trachanh.jpg', 'Trà'),
('TS_01', 'Matcha Latte', 25000, 'tra_sua_matcha.png', 'Trà sữa'),
('TS_02', 'Trà Sữa Truyền Thống', 25000, 'tra_sua_tran_chau.png', 'Trà sữa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recipe`
--

CREATE TABLE `recipe` (
  `ID_MT` varchar(20) NOT NULL,
  `id_food` varchar(20) NOT NULL,
  `Name_MT` varchar(30) NOT NULL,
  `Quantity_MT` int(11) NOT NULL,
  `Unit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `revenue`
--

CREATE TABLE `revenue` (
  `Report_month` date NOT NULL,
  `Total_monthly_revenue` float NOT NULL,
  `Total_shift_cost` float NOT NULL,
  `Total_monthly_cost` float NOT NULL,
  `Monthly_profit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `salary`
--

CREATE TABLE `salary` (
  `ID_salary` int(11) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `Salary_month` int(11) NOT NULL,
  `Year` year(4) NOT NULL,
  `Salary` float NOT NULL,
  `Total_shift` int(11) NOT NULL,
  `Total_salary` float NOT NULL,
  `Salary_status` varchar(30) NOT NULL DEFAULT 'chưa thanh toán',
  `Payment_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `salary`
--

INSERT INTO `salary` (`ID_salary`, `ID`, `Salary_month`, `Year`, `Salary`, `Total_shift`, `Total_salary`, `Salary_status`, `Payment_date`) VALUES
(12, 'NV001', 12, '2025', 100000, 4, 400000, 'Đã Thanh Toán', '2025-12-25 14:58:15'),
(13, 'NV002', 12, '2025', 100000, 2, 200000, 'chưa thanh toán', NULL),
(29, 'NV001', 11, '2025', 100000, 1, 100000, 'Đã Thanh Toán', '2025-12-25 15:11:41'),
(35, 'NV002', 12, '2006', 100000, 1, 100000, 'Đã Thanh Toán', '2025-12-25 15:11:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shift`
--

CREATE TABLE `shift` (
  `ID_shift` varchar(20) NOT NULL,
  `ID` varchar(20) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Working_date` date NOT NULL,
  `shift` varchar(20) NOT NULL,
  `Shift_status` varchar(20) NOT NULL DEFAULT 'chưa làm'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shift`
--

INSERT INTO `shift` (`ID_shift`, `ID`, `Name`, `Working_date`, `shift`, `Shift_status`) VALUES
('SH001', 'NV001', ' Nguyễn Trọng Nguyễn', '2025-12-23', 'Ca Sáng', 'Đã Vào Làm'),
('SH002', 'NV001', ' Nguyễn Trọng Nguyễn', '2025-12-23', 'Ca Tối', 'Đã Vào Làm'),
('SH003', 'NV002', ' Hứa Gia Kiên', '2025-12-23', 'Ca Tối', 'Đã Vào Làm'),
('SH004', 'NV002', ' Hứa Gia Kiên', '2025-12-23', 'Ca Trưa', 'Đã Vào Làm'),
('SH005', 'NV001', ' Nguyễn Trọng Nguyễn', '2025-12-24', 'Ca Trưa', 'Đã Vào Làm'),
('SH006', 'NV001', ' Nguyễn Trọng Nguyễn', '2025-12-30', 'Ca Chiều', 'chưa làm'),
('SH007', 'NV001', ' Nguyễn Trọng Nguyễn', '2025-12-30', 'Ca Sáng', 'Đã Vào Làm'),
('SH008', 'NV002', ' Hứa Gia Kiên', '2025-12-31', 'Ca Chiều', 'chưa làm'),
('SH009', 'NV001', ' Nguyễn Trọng Nguyễn', '2025-11-25', 'Ca Sáng', 'Đã Vào Làm'),
('SH010', 'NV002', ' Hứa Gia Kiên', '2006-12-24', 'Ca Sáng', 'Đã Vào Làm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shift_request`
--

CREATE TABLE `shift_request` (
  `ID_request` int(11) NOT NULL,
  `ID_shift` varchar(20) DEFAULT NULL,
  `ID` varchar(20) DEFAULT NULL,
  `request_time` datetime DEFAULT current_timestamp(),
  `status` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `shift_request`
--

INSERT INTO `shift_request` (`ID_request`, `ID_shift`, `ID`, `request_time`, `status`) VALUES
(5, 'SH001', 'NV001', '2025-12-23 12:03:14', 'Đã Xác Nhận'),
(6, 'SH002', 'NV001', '2025-12-23 12:03:16', 'Đã Xác Nhận'),
(7, 'SH003', 'NV002', '2025-12-23 14:36:26', 'Đã Xác Nhận'),
(8, 'SH004', 'NV002', '2025-12-23 14:36:27', 'Đã Xác Nhận'),
(9, 'SH005', 'NV001', '2025-12-23 14:52:00', 'Đã Xác Nhận'),
(10, 'SH007', 'NV001', '2025-12-25 14:51:48', 'Đã Xác Nhận'),
(11, 'SH009', 'NV001', '2025-12-25 15:10:05', 'Đã Xác Nhận'),
(12, 'SH010', 'NV002', '2025-12-25 15:11:13', 'Đã Xác Nhận');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stock_receipt`
--

CREATE TABLE `stock_receipt` (
  `ID_MT` varchar(20) NOT NULL,
  `Name_MT` varchar(30) NOT NULL,
  `Import_date` date NOT NULL,
  `Price` float NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `stock_receipt`
--

INSERT INTO `stock_receipt` (`ID_MT`, `Name_MT`, `Import_date`, `Price`, `Quantity`, `Unit`) VALUES
('CF', 'Caffe', '2025-12-22', 1200000, 12, 0),
('SU', 'Sữa Tươi Không Đường', '2025-12-22', 10000, 12, 0),
('SU02', 'Sữa Tươi Có Đường', '2025-12-22', 15000, 12, 0),
('SU', 'Sữa Tươi Không Đường', '2025-12-22', 10000, 2, 0),
('SU02', 'Sữa Tươi Có Đường', '2025-12-23', 10000, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tables`
--

CREATE TABLE `tables` (
  `ID_TB` varchar(20) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Trống'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tables`
--

INSERT INTO `tables` (`ID_TB`, `Status`) VALUES
('Mang đi', 'Trống'),
('TB_01', 'Trống'),
('TB_02', 'Trống'),
('TB_03', 'Có khách'),
('TB_04', 'Trống'),
('TB_05', 'Trống'),
('TB_06', 'Trống'),
('TB_07', 'Trống'),
('TB_08', 'Trống'),
('TB_09', 'Trống'),
('TB_10', 'Trống');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `ID` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `Sex` varchar(3) NOT NULL,
  `Date_of_birth` date NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Position` varchar(20) NOT NULL,
  `Phone_number` varchar(10) NOT NULL,
  `Role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`ID`, `password`, `email`, `name`, `Sex`, `Date_of_birth`, `Address`, `Position`, `Phone_number`, `Role`) VALUES
('NV001', '123456', '', 'Nguyễn Trọng Nguyễn', 'Nam', '0000-00-00', 'Tp.HCM', 'Nhân Viên', '', 0),
('NV002', '$2y$10$r5hItuw1leZtoPBysiaCg.5WSSMOv53D1pfMBHc/fNKyVB.TiylyW', 'kienhua@gmail.com', 'Hứa Gia Kiên', 'Nam', '2005-11-02', 'Phú Nhuận, Tp Hồ Chí Minh', 'Thu Ngân', '', 0),
('QL001', '123456', '', 'Nguyễn Nhật Long', 'Nam', '2005-04-03', 'TP.HCM', 'Quản Lý', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wallet`
--

CREATE TABLE `wallet` (
  `fund` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `wallet`
--

INSERT INTO `wallet` (`fund`) VALUES
(10000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `warehouse`
--

CREATE TABLE `warehouse` (
  `ID_MT` varchar(20) NOT NULL,
  `Name_MT` varchar(30) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Unit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `warehouse`
--

INSERT INTO `warehouse` (`ID_MT`, `Name_MT`, `Quantity`, `Unit`) VALUES
('CF', 'Caffe', 12, 'kg'),
('SU', 'Sữa Tươi Không Đường', 14, 'lít'),
('SU02', 'Sữa Tươi Có Đường', 13, 'lít');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`ID_bill`),
  ADD KEY `fk_idTB` (`ID_TB`),
  ADD KEY `fk_ID_NV` (`ID`);

--
-- Chỉ mục cho bảng `details_order`
--
ALTER TABLE `details_order`
  ADD KEY `fk_detailorder_bill` (`ID_bill`),
  ADD KEY `fk_TB` (`ID_TB`),
  ADD KEY `fk_IDF` (`id_food`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_food`);

--
-- Chỉ mục cho bảng `recipe`
--
ALTER TABLE `recipe`
  ADD KEY `fk_EP` (`ID_MT`),
  ADD KEY `fk_FF` (`id_food`);

--
-- Chỉ mục cho bảng `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`ID_salary`),
  ADD UNIQUE KEY `uk_salary` (`ID`,`Salary_month`,`Year`);

--
-- Chỉ mục cho bảng `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`ID_shift`),
  ADD KEY `fk_shift` (`ID`);

--
-- Chỉ mục cho bảng `shift_request`
--
ALTER TABLE `shift_request`
  ADD PRIMARY KEY (`ID_request`),
  ADD KEY `fk_request_shift` (`ID_shift`),
  ADD KEY `fk_IDNVSH` (`ID`);

--
-- Chỉ mục cho bảng `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`ID_TB`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`ID_MT`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `salary`
--
ALTER TABLE `salary`
  MODIFY `ID_salary` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `shift_request`
--
ALTER TABLE `shift_request`
  MODIFY `ID_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `fk_ID_NV` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idTB` FOREIGN KEY (`ID_TB`) REFERENCES `tables` (`ID_TB`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `details_order`
--
ALTER TABLE `details_order`
  ADD CONSTRAINT `fk_IDF` FOREIGN KEY (`id_food`) REFERENCES `menu` (`id_food`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_TB` FOREIGN KEY (`ID_TB`) REFERENCES `tables` (`ID_TB`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detailorder_bill` FOREIGN KEY (`ID_bill`) REFERENCES `bill` (`ID_bill`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `fk_EP` FOREIGN KEY (`ID_MT`) REFERENCES `warehouse` (`ID_MT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_FF` FOREIGN KEY (`id_food`) REFERENCES `menu` (`id_food`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `fk_SL` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `fk_shift` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `shift_request`
--
ALTER TABLE `shift_request`
  ADD CONSTRAINT `fk_IDNVSH` FOREIGN KEY (`ID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `fk_request_shift` FOREIGN KEY (`ID_shift`) REFERENCES `shift` (`ID_shift`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
