-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 31, 2025 lúc 02:59 PM
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
('B152310', '2025-12-22 21:23:10', 50000, 'TB_02', 'NV001', 1),
('B20251226162632', '2025-12-26 22:26:32', 25000, 'TB_01', 'NV001', 1),
('B20251226162942', '2025-12-26 22:29:42', 120000, 'TB_03', 'NV001', 1),
('B20251226163150', '2025-12-26 22:31:50', 100000, 'TB_02', 'NV001', 1),
('B20251226163656', '2025-12-26 22:36:56', 270000, 'TB_02', 'NV001', 1),
('B20251226164015', '2025-12-26 22:40:15', 800000, 'TB_03', 'NV001', 1),
('B20251226164428', '2025-12-26 22:44:28', 50000, 'Mang đi', 'NV001', 1),
('B20251226165128', '2025-12-26 22:51:28', 65000, 'Mang đi', 'NV001', 1),
('B20251230090302', '2025-12-30 15:03:02', 280000, 'Mang đi', 'NV001', 2),
('B20251230090812', '2025-12-30 15:08:12', 55000, 'TB_01', 'NV001', 1);

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

--
-- Đang đổ dữ liệu cho bảng `details_order`
--

INSERT INTO `details_order` (`food_name`, `id_food`, `qty`, `price`, `ID_bill`, `name_KH`, `phonenumber`, `ID_TB`, `item_status`) VALUES
('Bánh SandWich', 'BA_02', 1, 25000, 'B20251226162632', 'Nguyễn Huy', '5546545566', 'TB_01', 1),
('Bánh Sừng Bò', 'BA_01', 4, 30000, 'B20251226162942', 'Nguyễn Huy', '5546545566', 'TB_03', 1),
('Bạc Xỉu', 'BS_01', 1, 20000, 'B20251226163150', 'Nguyễn Huy', '5546545566', 'TB_02', 1),
('Bánh Sừng Bò', 'BA_01', 1, 30000, 'B20251226163150', 'Nguyễn Huy', '5546545566', 'TB_02', 1),
('Bánh SandWich', 'BA_02', 1, 25000, 'B20251226163150', 'Nguyễn Huy', '5546545566', 'TB_02', 1),
('Cafe Sữa Đá', 'CF_02', 1, 25000, 'B20251226163150', 'Nguyễn Huy', '5546545566', 'TB_02', 1),
('Cocacola', 'NG_02', 18, 15000, 'B20251226163656', 'Hua Gia Kien', '5546545566', 'TB_02', 1),
('Cafe Đen Đá', 'CF_01', 40, 20000, 'B20251226164015', 'Nguyễn Trọng Nguyễn', '0937318936', 'TB_03', 1),
('Nước Ép Cam', 'NE_01', 2, 25000, 'B20251226164428', 'nn', '5546545566', 'Mang đi', 1),
('Matcha Latte', 'TS_01', 1, 25000, 'B20251226165128', 'Nguyễn Huy', '5546545566', 'Mang đi', 1),
('Trà Sữa Truyền Thống', 'TS_02', 1, 25000, 'B20251226165128', 'Nguyễn Huy', '5546545566', 'Mang đi', 1),
('Sinh Tố Dâu', 'ST_01', 1, 15000, 'B20251226165128', 'Nguyễn Huy', '5546545566', 'Mang đi', 1),
('Wakeup 247', 'NG_06', 14, 20000, 'B20251230090302', 'Nguyễn Huy', '5546545566', 'Mang đi', 0),
('Bạc Xỉu', 'BS_01', 1, 20000, 'B20251230090812', 'Nguyễn Trọng Nguyễn', '0937318936', 'TB_01', 0),
('Bánh Tiramisu', 'BA_03', 1, 35000, 'B20251230090812', 'Nguyễn Trọng Nguyễn', '0937318936', 'TB_01', 0);

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
  `Quantity_MT` float NOT NULL,
  `Unit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `recipe`
--

INSERT INTO `recipe` (`ID_MT`, `id_food`, `Name_MT`, `Quantity_MT`, `Unit`) VALUES
('CF', 'CF_01', 'Cafe', 25, 'gram'),
('CF', 'CF_02', 'Cafe', 25, 'gram'),
('SU01', 'CF_02', 'Sữa đặc ', 30, 'ml'),
('CF', 'BS_01', 'Cafe', 20, 'gram'),
('SU01', 'BS_01', 'Sữa đặc ', 40, 'ml'),
('SU02', 'BS_01', 'Sữa Tươi Không Đường', 60, 'ml'),
('CF', 'CF_03', 'Cafe', 15, 'gram'),
('BSB', 'BA_01', 'Bánh Sừng Bò', 1, 'cai'),
('BSW', 'BA_02', 'Bánh Sandwich', 1, 'cai'),
('TRMS', 'BA_03', 'Bánh Tiramisu', 1, 'cai'),
('ST', 'NG_01', 'Sting', 1, 'lon'),
('COC', 'NG_02', 'Cocacola', 1, 'lon'),
('PEP', 'NG_04', 'Pepsi', 1, 'lon'),
('Red', 'NG_05', 'RedBull', 1, 'lon'),
('W247', 'NG_06', 'Wakeup - 247', 1, 'lon'),
('MST', 'NG_07', 'Monster', 1, 'lon'),
('CA', 'NE_01', 'Cam Tươi', 2, 'trai'),
('DC', 'NE_01', 'Đường Cát', 20, 'gram'),
('CD', 'NE_02', 'Chanh Dây', 2, 'trai'),
('DC', 'NE_02', 'Đường Cát', 20, 'gram'),
('DA', 'ST_01', 'Dâu Tươi', 150, 'gram'),
('SU01', 'ST_01', 'Sữa đặc ', 20, 'ml'),
('SU02', 'ST_01', 'Sữa Tươi Không Đường', 30, 'ml'),
('SD', 'SD_01', 'Soda', 200, 'ml'),
('CAT', 'SD_01', 'Chanh Tươi', 1, 'trai'),
('DC', 'SD_01', 'Đường Cát', 20, 'gram'),
('TRA', 'TR_01', 'Trà ', 2, 'gram'),
('DAO', 'TR_01', 'Đào Tươi', 5, 'gram'),
('CA', 'TR_01', 'Cam Tươi', 1, 'trai'),
('XA', 'TR_01', 'Xã tươi', 5, 'gram'),
('DC', 'TR_01', 'Đường Cát', 15, 'gram'),
('VAI', 'TR_02', 'Vãi Tươi', 30, 'gram'),
('TRA', 'TR_02', 'Trà ', 2, 'gram'),
('DC', 'TR_02', 'Đường Cát', 15, 'gram'),
('CAT', 'TR_03', 'Chanh Tươi', 1, 'trai'),
('TRA', 'TR_03', 'Trà ', 2, 'gram'),
('DC', 'TR_03', 'Đường Cát', 20, 'gram'),
('MCH', 'TS_01', 'Bột Matcha', 5, 'gram'),
('SU02', 'TS_01', 'Sữa Tươi Không Đường', 150, 'ml'),
('DC', 'TS_01', 'Đường Cát', 10, 'gram'),
('TRA', 'TS_02', 'Trà ', 5, 'gram'),
('SU02', 'TS_02', 'Sữa Tươi Không Đường', 150, 'ml'),
('DC', 'TS_02', 'Đường Cát', 10, 'gram');

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

--
-- Đang đổ dữ liệu cho bảng `revenue`
--

INSERT INTO `revenue` (`Report_month`, `Total_monthly_revenue`, `Total_shift_cost`, `Total_monthly_cost`, `Monthly_profit`) VALUES
('2025-12-01', 1610000, 0, 4265000, -2655000);

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
  `Unit` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `stock_receipt`
--

INSERT INTO `stock_receipt` (`ID_MT`, `Name_MT`, `Import_date`, `Price`, `Quantity`, `Unit`) VALUES
('CF', 'Cafe', '2025-12-26', 150000, 2, 'kg'),
('SU01', 'Sữa đặc ', '2025-12-26', 200000, 2, 'lít'),
('BSB', 'Bánh Sừng Bò', '2025-12-26', 20000, 10, 'cái'),
('BSW', 'Bánh Sandwich', '2025-12-26', 15000, 10, 'cái'),
('SU02', 'Sữa Tươi Không Đường', '2025-12-26', 10000, 2, 'lít'),
('CA', 'Cam Tươi', '2025-12-26', 1500, 20, 'Trái'),
('CD', 'Chanh Dây', '2025-12-26', 3000, 20, 'Trái'),
('ST', 'Sting', '2025-12-26', 7000, 30, 'Lon'),
('COC', 'Cocacola', '2025-12-26', 7000, 30, 'Lon'),
('NS', 'Nước Suối', '2025-12-26', 2500, 30, 'Chai'),
('PEP', 'Pepsi', '2025-12-26', 7000, 30, 'Lon'),
('Red', 'RedBull', '2025-12-26', 10000, 30, 'Lon'),
('W247', 'Wakeup - 247', '2025-12-26', 10000, 30, 'Chai'),
('MST', 'Monster', '2025-12-26', 12000, 30, 'Lon'),
('DA', 'Dâu Tươi', '2025-12-26', 70000, 5, 'kg'),
('DAO', 'Đào Tươi', '2025-12-26', 50000, 2, 'kg'),
('VAI', 'Vãi Tươi', '2025-12-26', 20000, 2, 'kg'),
('CAT', 'Chanh Tươi', '2025-12-26', 1500, 30, 'Trái'),
('MCH', 'Bột Matcha', '2025-12-26', 100000, 5, 'kg'),
('TRMS', 'Bánh Tiramisu', '2025-12-26', 20000, 10, 'cái'),
('TRA', 'Trà ', '2025-12-26', 15000, 3, 'kg'),
('XA', 'Xã tươi', '2025-12-26', 5000, 2, 'kg'),
('DC', 'Đường Cát', '2025-12-26', 20000, 5, 'kg'),
('SD', 'Soda', '2025-12-26', 10000, 5, 'lít');

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
('TB_01', 'Có khách'),
('TB_02', 'Trống'),
('TB_03', 'Trống'),
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
(7345000);

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
('BSB', 'Bánh Sừng Bò', 5, 'cái'),
('BSW', 'Bánh Sandwich', 8, 'cái'),
('CA', 'Cam Tươi', 16, 'Trái'),
('CAT', 'Chanh Tươi', 30, 'Trái'),
('CD', 'Chanh Dây', 20, 'Trái'),
('CF', 'Cafe', 1, 'kg'),
('COC', 'Cocacola', 12, 'Lon'),
('DA', 'Dâu Tươi', 5, 'kg'),
('DAO', 'Đào Tươi', 2, 'kg'),
('DC', 'Đường Cát', 5, 'kg'),
('MCH', 'Bột Matcha', 5, 'kg'),
('MST', 'Monster', 30, 'Lon'),
('NS', 'Nước Suối', 30, 'Chai'),
('PEP', 'Pepsi', 30, 'Lon'),
('Red', 'RedBull', 30, 'Lon'),
('SD', 'Soda', 5, 'lít'),
('ST', 'Sting', 30, 'Lon'),
('SU01', 'Sữa đặc ', 2, 'lít'),
('SU02', 'Sữa Tươi Không Đường', 2, 'lít'),
('TEST', 'TES1', 21, 'kí'),
('TRA', 'Trà ', 3, 'kg'),
('TRMS', 'Bánh Tiramisu', 9, 'cái'),
('VAI', 'Vãi Tươi', 2, 'kg'),
('W247', 'Wakeup - 247', 16, 'Chai'),
('XA', 'Xã tươi', 2, 'kg');

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
-- Chỉ mục cho bảng `revenue`
--
ALTER TABLE `revenue`
  ADD UNIQUE KEY `Report_month` (`Report_month`);

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
  MODIFY `ID_salary` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
