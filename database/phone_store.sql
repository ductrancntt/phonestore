-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 30, 2019 at 12:46 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phone_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enable` tinyint(1) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image`, `enable`, `link`) VALUES
(1, './image/1.png', 1, '#'),
(2, './image/2.png', 1, '#'),
(3, './image/3.png', 1, '#'),
(4, './image/4.png', 1, '#');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `ship_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_date` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `ship_address`, `created_date`, `user_id`, `status`, `total`) VALUES
(7, 'Hanoi', 20190426194459, 1, 0, 0),
(8, '', 20190427111514, 1, 0, 0),
(9, '', 20190427124240, 1, 3, 264389000);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `invoice_id`, `product_id`, `quantity`, `order_price`) VALUES
(12, 7, 1, 1, 10000000),
(13, 7, 2, 1, 5000000),
(14, 8, 8, 1, 29000000),
(15, 8, 9, 1, 24500000),
(16, 8, 10, 1, 17000000),
(17, 9, 8, 3, 29000000),
(18, 9, 10, 5, 17000000),
(19, 9, 9, 3, 24500000),
(20, 9, 49, 1, 3890000),
(21, 9, 48, 1, 7990000),
(22, 9, 47, 1, 759000),
(23, 9, 46, 5, 1250000);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `address`, `image`, `deleted`) VALUES
(1, 'Apple', 'localhost', './image/apple.png', 0),
(2, 'ASUS', 'localhost', './image/asus.png', 0),
(3, 'Huawei', 'localhost', './image/huawei.png', 0),
(4, 'LG', 'localhost', './image/lg.png', 0),
(5, 'Nokia', 'localhost', './image/nokia.jpg', 0),
(6, 'OPPO', 'localhost', './image/oppo.png', 0),
(7, 'Samsung', 'localhost', './image/samsung.png', 0),
(8, 'Sony', 'localhost', './image/sony.png', 0),
(9, 'XiaoMi', 'localhost', './image/xiaomi.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `screen_size` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `memory` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `chipset` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `screen_size`, `memory`, `chipset`, `image`, `manufacturer_id`, `quantity`, `deleted`) VALUES
(1, 'iPhone 6', 6000000, 'This is Smart Phone from Apple', '4.7', '1GB', 'Apple A6', './images/image_3115869093300.jpg', 1, 300, 0),
(2, 'iPhone 6S', 7000000, 'This is Smart Phone from Apple', '4.7', '2GB', 'Apple A7', './images/image_2938494664800.jpg', 1, 300, 0),
(3, 'iPhone 6S Plus', 8000000, 'This is Smart Phone from Apple', '5.5', '2GB', 'Apple A8', './images/image_14128142911000.jpg', 1, 300, 0),
(4, 'iPhone 7 Plus', 9000000, 'This is Smart Phone from Apple', '5.5', '3GB', 'Apple A9', './images/image_14149076102100.png', 1, 300, 0),
(5, 'iPhone 8 Plus', 15000000, 'This is Smart Phone from Apple', '5.5', '3GB', 'Apple A10', './images/image_14180900996500.png', 1, 300, 0),
(6, 'iPhone X', 20000000, 'This is Smart Phone from Apple', '5.8', '4GB', 'Apple A11', './images/image_14215525160700.jpg', 1, 300, 0),
(7, 'iPhone XS', 25000000, 'This is Smart Phone from Apple', '5.8', '4GB', 'Apple A12', './images/image_14250139405000.jpg', 1, 300, 0),
(8, 'Samsung Galaxy S10+', 29000000, 'This is Smart Phone from Samsung', '6.4', '6GB', 'Samsung Exynos 6969', './images/image_14276770885800.png', 7, 296, 0),
(9, 'Samsung Galaxy Note 9', 24500000, 'This is Smart Phone from Samsung', '6.4', '6GB', 'Samsung Exynos 6969', './images/image_14314067414900.jpg', 7, 296, 0),
(10, 'Samsung Galaxy S9+', 17000000, 'This is Smart Phone from Samsung', '6.2', '4GB', 'Samsung Exynos 6969', './images/image_14335595346200.png', 7, 294, 0),
(11, 'Samsung Galaxy Note 8', 15000000, 'This is Smart Phone from Samsung', '6.3', '4GB', 'Samsung Exynos 6969', './images/image_14367767265200.png', 7, 300, 0),
(12, 'Samsung Galaxy A9', 10500000, 'This is Smart Phone from Samsung', '6.3', '4GB', 'Samsung Exynos 6969', './images/image_14396940047500.png', 7, 300, 0),
(13, 'Samsung Galaxy A7', 7000000, 'This is Smart Phone from Samsung', '6', '4GB', 'Samsung Exynos 6969', './images/image_14419118646500.png', 7, 300, 0),
(14, 'Samsung Galaxy A6+', 4200000, 'This is Smart Phone from Samsung', '5.6', '4GB', 'Samsung Exynos 6969', './images/image_14447750004200.png', 7, 300, 0),
(15, 'LG K40', 15000000, 'This is Smart Phone from LG', '5.7', '6GB', 'Snapdragon 690', './images/image_14492082999700.png', 4, 300, 0),
(16, 'LG Q60', 16000000, 'This is Smart Phone from LG', '6.26', '6GB', 'Snapdragon 690', './images/image_14524457081000.png', 4, 300, 0),
(17, 'LG K50', 15500000, 'This is Smart Phone from LG', '6.26', '6GB', 'Snapdragon 690', './images/image_14549409206600.png', 4, 300, 0),
(18, 'LG G8 ThinQ', 15700000, 'This is Smart Phone from LG', '6.1', '6GB', 'Snapdragon 690', './images/image_14576035977900.png', 4, 300, 0),
(19, 'LG V50 ThinQ', 16200000, 'This is Smart Phone from LG', '6.4', '4GB', 'Snapdragon 690', './images/image_14620151710600.png', 4, 300, 0),
(20, 'LG G8s ThinQ', 17000000, 'This is Smart Phone from LG', '6.2', '4GB', 'Snapdragon 690', './images/image_14597765746200.png', 4, 300, 0),
(21, 'Sony Xperia XA1 Plus', 3990000, 'This is Smart Phone from Sony', '5.5', '3GB', 'MediaTek Helio P70', './images/image_10371469947400.jpg', 8, 300, 0),
(22, 'Sony Xperia XZ1', 6990000, 'This is Smart Phone from Sony', '5.2', '6GB', 'MediaTek Helio P70', './images/image_10450758804700.jpg', 8, 300, 0),
(23, 'Sony Xperia XZ Premium', 17990000, 'This is Smart Phone from Sony', '5.5', '6GB', 'MediaTek Helio P70', './images/image_10549339889600.jpg', 8, 300, 0),
(24, 'Sony Xperia XZs', 9990000, 'This is Smart Phone from Sony', '5.2', '4GB', 'MediaTek Helio P70', './images/image_10619394754100.jpg', 8, 300, 0),
(25, 'Sony Xperia XA1 Ultra', 3490000, 'This is Smart Phone from Sony', '6', '4GB', 'MediaTek Helio P70', './images/image_10656115828300.jpg', 8, 300, 0),
(26, 'Sony Xperia Z5 Premium', 15990000, 'This is Smart Phone from Sony', '5.5', '4GB', 'MediaTek Helio P70', './images/image_10710729849100.png', 8, 300, 0),
(27, 'Xiaomi Mi 8 Lite 64GB', 6690000, 'This is Smart Phone from XiaoMi', '6.22', '4GB', 'Snapdragon 696', './images/image_10866436286800.png', 9, 300, 0),
(28, 'Xiaomi Mi 8 Pro 8GB-128GB', 14990000, 'This is Smart Phone from XiaoMi', '6.2', '8GB', 'Snapdragon 696', './images/image_10901137542700.jpg', 9, 300, 0),
(29, 'Xiaomi Mi 8 Lite 128GB', 7290000, 'This is Smart Phone from XiaoMi', '6.22', '4GB', 'Snapdragon 696', './images/image_10935139948700.jpg', 9, 300, 0),
(30, 'Xiaomi Mi A2 4GB-32GB', 4999000, 'This is Smart Phone from XiaoMi', '6', '4GB', 'Snapdragon 696', './images/image_10978778808100.png', 9, 300, 0),
(31, 'Xiaomi Mi 8 64GB', 12990000, 'This is Smart Phone from XiaoMi', '6.21', '4GB', 'Snapdragon 696', './images/image_11010290522200.jpg', 9, 300, 0),
(32, 'Xiaomi Mi A2 Lite 4GB-64GB', 4699000, 'This is Smart Phone from XiaoMi', '5.84', '4GB', 'Snapdragon 696', './images/image_11044704494700.png', 9, 300, 0),
(33, 'Xiaomi Mi 6', 10990000, 'This is Smart Phone from XiaoMi', '5.5', '4GB', 'Snapdragon 696', './images/image_11083786818200.jpg', 9, 300, 0),
(34, 'Huawei Y7 Pro', 3990000, 'This is Smart Phone from Huawei', '6.23', '4GB', 'Kirin 980', './images/image_11178401813500.png', 3, 300, 0),
(35, 'Huawei Nova 3i', 5990000, 'This is Smart Phone from Huawei', '6.3', '4GB', 'Kirin 980', './images/image_11211227357300.jpg', 3, 300, 0),
(36, 'Huawei Y9', 5490000, 'This is Smart Phone from Huawei', '6.5', '4GB', 'Kirin 980', './images/image_11247205079300.png', 3, 300, 0),
(37, 'Huawei Mate 20 Pro', 21990000, 'This is Smart Phone from Huawei', '6.4', '4GB', 'Kirin 980', './images/image_11289561441900.jpg', 3, 300, 0),
(38, 'Huawei P30', 16990000, 'This is Smart Phone from Huawei', '6.1', '4GB', 'Kirin 980', './images/image_11343435195100.png', 3, 300, 0),
(39, 'Huawei P30 Lite', 7490000, 'This is Smart Phone from Huawei', '6.15', '4GB', 'Kirin 980', './images/image_13175710928400.png', 3, 300, 0),
(40, 'Oppo A3s', 3290000, 'This is Smart Phone from OPPO', '6.2', '2GB', 'Snapdragon 750', './images/image_13257958484300.jpg', 6, 300, 0),
(41, 'OPPO F9', 6990000, 'This is Smart Phone from OPPO', '6.3', '4GB', 'Snapdragon 750', './images/image_13292390446900.jpg', 6, 300, 0),
(42, 'OPPO A7', 5490000, 'This is Smart Phone from OPPO', '6.2', '4GB', 'Snapdragon 750', './images/image_13331680947800.png', 6, 300, 0),
(43, 'OPPO F11', 8490000, 'This is Smart Phone from OPPO', '6.5', '4GB', 'Snapdragon 750', './images/image_13592477647400.png', 6, 300, 0),
(44, 'OPPO R17 Pro', 100000, 'This is Smart Phone from OPPO', '6.4', '6GB', 'Snapdragon 750', './images/image_13646047945500.png', 6, 300, 0),
(45, 'Nokia 6.1 Plus', 5490000, 'This is Smart Phone from Nokia', '5.8', '3GB', 'Snapdragon 625', './images/image_13893359343900.jpg', 5, 300, 0),
(46, 'Nokia 230', 1250000, 'This is Smart Phone from Nokia', '2.8', '256MB', 'No Chipset', './images/image_13930052247600.jpg', 5, 295, 0),
(47, 'Nokia N216 RM - 1187', 759000, 'This is Smart Phone from Nokia', '2.4', '256MB', 'No Chipset', './images/image_13959364281900.jpg', 5, 299, 0),
(48, 'Nokia 8.1', 7990000, 'This is Smart Phone from Nokia', '6.18', '4GB', 'Snapdragon 625', './images/image_13995908367000.png', 5, 299, 0),
(49, 'Nokia 3.1 Plus', 3890000, 'This is Smart Phone from Nokia', '6', '3GB', 'Snapdragon 625', './images/image_14028849960700.png', 5, 299, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name`, `value`) VALUES
(1, 'BANNER_TIME', '1000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `enable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `name`, `address`, `phone`, `is_admin`, `enable`) VALUES
(1, 'user', 'user', 'user@gmail.com', 'User', 'localhost', '0888888888', 0, 1),
(2, 'admin', 'admin', 'admin@gmail.com', 'Admin', 'localhost', '0969696969', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wish_list`
--

CREATE TABLE `wish_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
