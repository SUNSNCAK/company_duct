-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2023 at 12:54 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company_duct`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `sub_district` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `name`, `number`, `sub_district`, `district`, `province`, `postcode`, `details`, `user_id`) VALUES
(5, 'WEROCKER chanel', '0648329034', 'กกกุง', 'เมืองสรวง', 'ร้อยเอ็ด', '45220', 'asd', 5),
(22, 'test1', '0648329036', 'กกกุง', 'เมืองสรวง', 'ร้อยเอ็ด', '45220', '299/264 ม.12', 9),
(23, 'PON SRISAMER', '0648329035', 'ในคลองบางปลากด', 'พระสมุทรเจดีย์', 'สมุทรปราการ', '10290', '299/264 ม.12', 17),
(24, 'company user1', '1234567891', 'อนุสาวรีย์', 'บางเขน', 'กรุงเทพมหานคร', '10220', 'user1', 18),
(25, 'test', '0648329033', 'หงาว', 'เทิง', 'เชียงราย', '57160', 'ะำหะ', 19),
(26, 'test3', '0648329032', 'ฟากห้วย', 'อรัญประเทศ', 'สระแก้ว', '27120', 'ฟไกหฟก', 20),
(31, 'vk.air', '1234567891', 'คลองหก', 'คลองหลวง', 'ปทุมธานี', '12120', '151/06', 23),
(32, 'test2', '0648329035', 'อนุสาวรีย์', 'บางเขน', 'กรุงเทพมหานคร', '10220', 'test', 9);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `product_id` mediumint(8) UNSIGNED NOT NULL,
  `quantity` smallint(5) UNSIGNED NOT NULL,
  `width` float UNSIGNED DEFAULT NULL,
  `length` float UNSIGNED DEFAULT NULL,
  `height` float UNSIGNED DEFAULT NULL,
  `other_item` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `installment`
--

CREATE TABLE `installment` (
  `id` int(11) NOT NULL,
  `order_id` int(10) NOT NULL,
  `file_user` varchar(255) DEFAULT NULL,
  `pay_qty` varchar(50) NOT NULL,
  `pay_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `installment`
--

INSERT INTO `installment` (`id`, `order_id`, `file_user`, `pay_qty`, `pay_status`) VALUES
(1, 1, '', '1', 'ยังไม่ได้ชำระ'),
(2, 1, '', '2', 'ยังไม่ได้ชำระ'),
(3, 1, '', '3', 'ยังไม่ได้ชำระ'),
(4, 2, '', '1', 'ยังไม่ได้ชำระ'),
(5, 2, '', '2', 'ยังไม่ได้ชำระ'),
(17, 8, '202210291439336899.jpg', '1', 'ชำระเรียบร้อย'),
(18, 8, '20221029528999717.jpg', '2', 'ชำระเรียบร้อย'),
(19, 8, '202210291653164715.jpg', '3', 'ชำระเรียบร้อย'),
(20, 8, '20221029128863461.jpg', '4', 'ชำระเรียบร้อย'),
(21, 8, '202210292067646724.jpg', '5', 'ชำระเรียบร้อย'),
(31, 13, '', '1', 'ยังไม่ได้ชำระ'),
(32, 13, '', '2', 'ยังไม่ได้ชำระ'),
(33, 14, '20230218778967675.jpg', '1', 'ชำระเรียบร้อย'),
(34, 14, '20230218571309638.jpg', '2', 'ชำระเรียบร้อย'),
(58, 38, '', '1', 'ยังไม่ได้ชำระ'),
(60, 40, '202303071116685402.jpg', '1', 'ชำระเรียบร้อย'),
(61, 40, '20230307230968279.jpg', '2', 'ชำระเรียบร้อย'),
(62, 41, '20230307486993312.jpg', '1', 'ชำระเรียบร้อย'),
(63, 42, '202303071408609149.jpg', '1', 'ชำระเรียบร้อย'),
(64, 42, '20230307862049657.jpg', '2', 'ชำระเรียบร้อย');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`) VALUES
(7, 1458668101, 120125218, 'สาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเ'),
(8, 120125218, 1458668101, 'สาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเหดหเดกเ'),
(9, 1458668101, 120125218, 'สาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเ สาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเ สาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเ สาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเ สาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืสาฟวเ่หกดาสเ่าสหด่เาส่ิดห่เืหดหเดกเหดหเดกเ'),
(10, 1458668101, 120125218, 'jsdhrg;ois'),
(11, 1597126413, 1458668101, 'สวัสดีครับ'),
(12, 120125218, 1458668101, 'สวัสดีวันจันทร์'),
(13, 1458668101, 1597126413, 'ขอสอบถามหน่อยครับ'),
(14, 1458668101, 1597126413, 'สินค้ายังมีอยู่ไหมครับ'),
(15, 1597126413, 1458668101, 'ไม่ทราบว่าสนใจเป็นสินค้าตัวไหนครับ'),
(16, 1458668101, 1278958382, 'สวัสดีครับ'),
(17, 120125218, 1458668101, 'สวัสดีวันอังคาร'),
(18, 1458668101, 120125218, 'สวัสดีวันพุธ'),
(19, 120125218, 1458668101, 'สวัสดีวันพฤหัส');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `sub_district` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `setup_date` varchar(255) NOT NULL,
  `pay_qty` varchar(50) NOT NULL,
  `order_date` date NOT NULL,
  `pay_status` varchar(255) NOT NULL,
  `paytotal` varchar(255) DEFAULT NULL,
  `file_admin` varchar(255) DEFAULT NULL,
  `file_user` varchar(255) DEFAULT NULL,
  `tax_invoice` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `name`, `number`, `sub_district`, `district`, `province`, `postcode`, `details`, `setup_date`, `pay_qty`, `order_date`, `pay_status`, `paytotal`, `file_admin`, `file_user`, `tax_invoice`) VALUES
(1, 9, 'PON SRISAMER', '0648329035', 'ในคลองบางปลากด', 'พระสมุทรเจดีย์', 'สมุทรปราการ', '10290', '299/264 ม.12', '2022-10-16', '3', '2022-10-15', 'ยืนยันมัดจำ', '30000', '202210201405682884.pdf', '20221023384917536.jpg', NULL),
(2, 17, 'PON SRISAMER', '0648329035', 'ในคลองบางปลากด', 'พระสมุทรเจดีย์', 'สมุทรปราการ', '10290', '299/264 ม.12', '2022-10-18', '2', '2022-10-15', 'ยืนยันคำสั่งซื้อ', '30000', '202210311362914411.pdf', '', NULL),
(8, 18, 'company user1', '1234567891', 'อนุสาวรีย์', 'บางเขน', 'กรุงเทพมหานคร', '10220', 'user1', '2022-11-02', '5', '2022-10-29', 'ชำระเรียบร้อย', '7500', '20221029963384134.pdf', '202303071524620024.jpg', '20221031791582441.pdf'),
(10, 20, 'test3', '0648329032', 'ฟากห้วย', 'อรัญประเทศ', 'สระแก้ว', '27120', 'ฟไกหฟก', '2022-11-05', '2', '2022-10-31', 'ยกเลิกคำสั่งซื้อ', '', '', '', ''),
(12, 19, 'test', '0648329033', 'หงาว', 'เทิง', 'เชียงราย', '57160', 'ะำหะ', '2022-11-17', '3', '2022-11-14', 'ยกเลิกคำสั่งซื้อ', '', '', '', ''),
(13, 20, 'test3', '0648329032', 'ฟากห้วย', 'อรัญประเทศ', 'สระแก้ว', '27120', 'ฟไกหฟก', '2022-11-25', '2', '2022-11-22', 'อยู่ระหว่างการชำระ', '', '', '', ''),
(14, 23, 'vk.air', '1234567891', 'คลองหก', 'คลองหลวง', 'ปทุมธานี', '12120', '151/06', '2023-02-21', '2', '2023-02-18', 'ชำระเรียบร้อย', '3800', '202302181279620448.pdf', '20230218613913735.jpg', '202302181827152926.pdf'),
(15, 23, 'vk.air', '1234567891', 'คลองหก', 'คลองหลวง', 'ปทุมธานี', '12120', '151/06', '2023-02-28', '1', '2023-02-26', 'ยกเลิกคำสั่งซื้อ', '', '', '', ''),
(36, 23, 'vk.air', '1234567891', 'คลองหก', 'คลองหลวง', 'ปทุมธานี', '12120', '151/06', '2023-03-08', '1', '2023-03-07', 'ยกเลิกคำสั่งซื้อ', '', '', '', ''),
(38, 18, 'company user1', '1234567891', 'อนุสาวรีย์', 'บางเขน', 'กรุงเทพมหานคร', '10220', 'user1', '2023-03-09', '1', '2023-03-07', 'ยืนยันมัดจำ', '3800', '202303071260297526.pdf', '202303071860101842.jpg', ''),
(40, 19, 'test', '0648329033', 'หงาว', 'เทิง', 'เชียงราย', '57160', 'ะำหะ', '2023-03-09', '2', '2023-03-07', 'ชำระเรียบร้อย', '7500', '202303071940557929.pdf', '20230307925759445.jpg', ''),
(41, 19, 'test', '0648329033', 'หงาว', 'เทิง', 'เชียงราย', '57160', 'ะำหะ', '2023-03-09', '1', '2023-03-07', 'ชำระเรียบร้อย', '8300', '20230307616137616.pdf', '2023030731420651.jpg', ''),
(42, 19, 'test', '0648329033', 'หงาว', 'เทิง', 'เชียงราย', '57160', 'ะำหะ', '2023-03-09', '2', '2023-03-07', 'ชำระเรียบร้อย', '3000', '20230307857957447.pdf', '20230307301809058.jpg', '202303071229802966.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE `orders_item` (
  `order_id` int(11) NOT NULL,
  `product_id` int(10) NOT NULL,
  `quantity` smallint(5) NOT NULL,
  `width` varchar(255) NOT NULL,
  `length` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `other` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders_item`
--

INSERT INTO `orders_item` (`order_id`, `product_id`, `quantity`, `width`, `length`, `height`, `other`) VALUES
(1, 1, 3, '0', '0', '0', NULL),
(1, 2, 1, '0', '0', '0', NULL),
(1, 3, 2, '0', '0', '0', NULL),
(2, 2, 2, '0', '0', '0', NULL),
(8, 3, 2, '0', '0', '0', NULL),
(13, 3, 1, '5.5', '4.3', '7', NULL),
(14, 2, 1, '0', '0', '0', NULL),
(38, 6, 1, '15.1', '23', '72.1', 'ความโค้ง 90 องศา'),
(40, 6, 1, '0', '0', '0', ''),
(41, 6, 1, '0', '0', '0', 'test'),
(42, 6, 1, '0', '0', '0', 'awdsa');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(10) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_desc` text NOT NULL,
  `product_qty` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_code`, `product_name`, `product_img`, `product_desc`, `product_qty`) VALUES
(1, 'HQFE-7391', 'ข้องอ 90 องศา', '1.jpg', 'ข้องอ 90 องศา ทำจากสังกะสี สำหรับติดตั้งท่อดักท์ หรือท่อส่งลมเพื่อเปลี่ยนทิศทางของท่อในมุม 90 องศา มีบ่าสำหรับปลายท่อชนได้พอดี', '10'),
(2, 'ZYMI-5142', 'ตะแกรงเหล็กรูกลม', '2.jpg', 'ตะแกรงเหล็กรูกลม หนา 0.5 มิล รู 6.5 มิลลิเมตร ขนาด 120 X 120 CM', '9'),
(3, 'EDSY-0256', 'ท่อดักท์ตรง ระบายอากาศ', '3.jpg', 'ท่อดักท์ระบายอากาศ ขนาด 1.7 เมตร', '9'),
(5, 'YNLS-0592', 'Rain Hood (คลอบกันฝน) แบบกลม', 'Screenshot 2023-02-17 215227.png', 'ขึ้นรูปหน้าแปลนในตัวท่อลม ทำให้ลดการรั่วของลมได้น้อยลง วัสดุมีทั้งแบบสังกะสีและสแตนเลส ความกว้าง 6-44 นิ้ว ความสูง 6-48 นิ้ว', '9'),
(6, 'BGRU-3857', 'ฮูดดูดควัน ฝาชี เครื่องดูดควัน', 'Screenshot 2023-02-17 223540.png', 'ขนาด 75x100x45 เซนติเมตร เหมาะสำหรับใช้ในโรงงาน', '10'),
(8, 'EPCJ-7314', 'ท่อเหลี่ยม 90 องศา', 'Screenshot 2023-02-17 232006.png', 'ขึ้นรูปหน้าแปลนในตัวท่อลม จึงทำให้ลดการรั่วของลมได้น้อยลง ขนาด 15x15 เซนติเมตร - 90x90 เซนติเมตร', '11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `urole` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `name`, `email`, `password`, `number`, `urole`) VALUES
(5, 1458668101, 'Admin', 'admin@gmail.com', '$2y$10$4dzLxCwI0Xfzje2V7Zt0OOjXMyHb4417Ky27ohVZ8CdZIjS3IsPP2', '1234567890', 'admin'),
(9, 120125218, 'PON SRISAMER', 'sunzapon619@gmail.com', '$2y$10$cUN3sqHbsN0iRuZBLKN1c.TyB8Xdq/VGVqwpstfwDZ5L5MEg5Huou', '0648329035', 'user'),
(17, 1597126413, 'annabell', 'sunzapon618@gmail.com', '$2y$10$LqiGAlg6jev.O5cbI9zQFuLm8Hcz7x9pYg4KIjITyjiVGMb7cGsge', '0648329034', 'user'),
(18, 1278958382, 'user1', 'user1@gmail.com', '$2y$10$AWs1Viw8MWrfnxutaO10ze2mYewv6KwJNtuxUH5XEoHGD6EsM5vqS', '1234567891', 'user'),
(19, 635461809, 'user2', 'user2@gmail.com', '$2y$10$DanLjGEc7r4g7N26mQHiBe5Pf79Dl.PxBO4/FS9p0dnSpgshnC.vO', '0648329033', 'user'),
(20, 1445412933, 'user3', 'user3@gmail.com', '$2y$10$i8XBROrOpyfdCxjzYIDMJ./hjO7LnalCZfI25brOsyfrZ73iXE1ey', '0648329032', 'user'),
(21, 842330668, 'Admin1', 'admin1@gmail.com', '$2y$10$jBEZP1N6y5hL7/ywfwbLle6X76Pi2mf10/gIstf.AWFmPxFEiPUla', '0123456789', 'admin'),
(23, 282357620, 'user4', 'user4@gmail.com', '$2y$10$4w8i/mmpmEMWv8gPlQKEn.e0ySt64rwdLIOBcVNOEOi8nEg948I56', '0648329032', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `FK_user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user_id`,`product_id`);

--
-- Indexes for table `installment`
--
ALTER TABLE `installment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_order_id` (`order_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `OrderId_Fk_idx` (`order_id`),
  ADD KEY `Productid_Fk_idx` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `installment`
--
ALTER TABLE `installment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `installment`
--
ALTER TABLE `installment`
  ADD CONSTRAINT `FK_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD CONSTRAINT `OrderId_Fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Productid_Fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
