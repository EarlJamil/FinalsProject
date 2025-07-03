-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 03, 2025 at 03:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eduassist`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','NOT ACTIVE','TRANSACT','') DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `product_id`, `quantity`, `total_price`, `session_id`, `status`, `transaction_id`) VALUES
(76, 2, 13, 2, 178, 'iqte15g8l0tfqr9cc8ul7m8v85', 'TRANSACT', 2),
(77, 2, 15, 1, 49, 'iqte15g8l0tfqr9cc8ul7m8v85', 'TRANSACT', 2),
(78, 2, 13, 1, 89, 'iqte15g8l0tfqr9cc8ul7m8v85', 'TRANSACT', 2),
(79, 2, 2, 1, 199, 'iqte15g8l0tfqr9cc8ul7m8v85', 'TRANSACT', 13),
(80, 2, 5, 2, 498, 'iqte15g8l0tfqr9cc8ul7m8v85', 'TRANSACT', 13),
(81, 2, 10, 1, 249, 'iqte15g8l0tfqr9cc8ul7m8v85', 'TRANSACT', 13),
(82, 2, 15, 1, 49, 'ki2q6p7193pq75fv91qv1clo8n', 'TRANSACT', 14),
(83, 2, 13, 3, 267, 'ki2q6p7193pq75fv91qv1clo8n', 'TRANSACT', 14),
(84, 2, 18, 0, 0, 'ki2q6p7193pq75fv91qv1clo8n', 'NOT ACTIVE', NULL),
(85, 2, 15, 1, 49, 'ki2q6p7193pq75fv91qv1clo8n', 'TRANSACT', 15),
(86, 2, 20, 0, 0, 'ki2q6p7193pq75fv91qv1clo8n', 'NOT ACTIVE', NULL),
(87, 2, 13, 1, 89, 'ki2q6p7193pq75fv91qv1clo8n', 'TRANSACT', 15),
(88, 2, 2, 1, 199, 'ki2q6p7193pq75fv91qv1clo8n', 'TRANSACT', 16),
(89, 2, 2, 1, 199, 'ki2q6p7193pq75fv91qv1clo8n', 'TRANSACT', 17),
(90, 2, 2, 1, 199, 'ki2q6p7193pq75fv91qv1clo8n', 'TRANSACT', 18);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Memberships'),
(2, 'Digital Products'),
(3, 'Stationary');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `gender` enum('MALE','FEMALE','PREFER NOT TO SAY') NOT NULL,
  `birthday` date NOT NULL,
  `phone_num` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `gender`, `birthday`, `phone_num`, `customer_address`, `username`, `user_password`, `email`) VALUES
(2, 'Precious  Lansigan', 'FEMALE', '2004-08-25', '09121231234', '1173 Jorenz Valenzuela City, NCR 1442 Philippines', 'Booo1l', '92acf790247a1dd68d2c087c95de24b7', 'lansigan@gmai.com'),
(3, 'Earl G Jamil', 'MALE', '2000-10-05', '2147483647', 'Blk 3 Rizal City, Rizal 1900 Philippines', 'Earl123', 'd647875966837f107895a5252ecc52aa', 'earlheyits@gmail.com'),
(4, 'Kim G Ejon', '', '2004-04-20', '09164900029', '413 Bibi Makati City, Seoul 1234 Korea', 'kimbibi', '42327230296848be6ba716272f03ab73', 'kim@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_details` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `status` enum('AVAILABLE','NOT AVAILABLE') NOT NULL,
  `stock` int(11) NOT NULL,
  `date_added` date DEFAULT NULL,
  `rate` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_details`, `category_id`, `price`, `status`, `stock`, `date_added`, `rate`, `image`) VALUES
(1, 'Bronze', 'Basic access to study resources and updates', 1, 99, 'AVAILABLE', 10, '2017-08-28', 5, 'Services/bronze.png'),
(2, 'Silver', 'Includes refresher courses and basic test kits', 1, 199, 'AVAILABLE', 11, '2017-08-28', 4, 'Services/silver.png'),
(3, 'Gold', 'All-access membership with premium kits and exams', 1, 299, 'AVAILABLE', 12, '2017-08-28', 3, 'Services/gold.png'),
(4, 'Ebook', 'Digital learning resources for students.', 2, 149, 'AVAILABLE', 12, '2017-08-28', 5, 'Services/Digital Products/ebooks.jpg'),
(5, 'Test Preparation Kit', 'Test Preparation Kit', 2, 249, 'AVAILABLE', 12, '2017-08-28', 5, 'Services/Digital Products/test.jpg'),
(6, 'College Preparation Prep', 'College Preparation Prep', 2, 299, 'AVAILABLE', 12, '2017-08-28', 5, 'Services/Digital Products/college.jpg'),
(7, 'Journal Kits', 'Journal Kits for aesthetic resources.', 2, 149, 'AVAILABLE', 12, '2017-08-28', 5, 'Services/Digital Products/journal.jpg'),
(8, 'Refresher Kits', 'Aesthetic purposes for colorful pieces.', 2, 259, 'AVAILABLE', 12, '2017-08-28', 5, 'Services/Digital Products/refresher.jpg'),
(9, 'Digital Products', 'Several Digital Products for online', 2, 289, 'AVAILABLE', 12, '2017-08-28', 5, 'Services/Digital Products/digital.webp'),
(10, 'Worksheets', 'Worksheets for school assignments.', 2, 249, 'AVAILABLE', 12, '2017-08-28', 5, 'Services/Digital Products/worksheets.jpg'),
(11, 'Stickers', 'Assorted Stickers', 3, 30, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/sticker.jpg'),
(12, 'Stationaries', 'Assorted Stationaries Items', 3, 30, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/set.jpg'),
(13, 'Color Pens', 'Bright and smooth ink pens, perfect for note-taking and designs.', 3, 89, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/colorpens.webp'),
(14, 'Markers', 'Set of colorful markers for school projects.', 3, 99, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/markers.webp'),
(15, 'Pad Papers', 'Pack of Grade School and Intermediate pad papers.', 3, 49, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/pad.webp'),
(16, 'Sketchbook', 'Thick, high-quality paper ideal for sketches and mixed media.', 3, 149, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/sketch.webp'),
(17, 'Notebooks set', '3-piece college ruled notebooks.', 3, 129, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/notebook.webp'),
(18, 'Ballpen set', 'Smooth-flowing ballpens in black, blue, and red colors.', 3, 39, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/ballpen.webp'),
(19, 'Brush Pens', 'Perfect for calligraphy and creative writing.', 3, 199, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/brush.webp'),
(20, 'Pencil Set', 'Includes HB pencils, erasers, and a sharpener — all in one set.', 3, 59, 'AVAILABLE', 5, '2025-04-25', 5, 'Services/Materials/pencil_set.webp');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `shipping_date` date NOT NULL,
  `STATUS` enum('Delivered','Delayed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment` enum('Credit Card','Cash on Delivery','Online Banking') DEFAULT NULL,
  `total_price` decimal(11,0) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `customer_id`, `payment`, `total_price`, `address`) VALUES
(14, 2, 'Online Banking', 354, '1173 Jorenz Valenzuela City, NCR 1442 Philippines'),
(15, 2, 'Credit Card', 155, '1173 Jorenz Valenzuela City, NCR 1442 Philippines'),
(16, 2, 'Online Banking', 223, '1173 Jorenz Valenzuela City, NCR 1442 Philippines'),
(17, 2, 'Online Banking', 223, 'Caloocan'),
(18, 2, 'Online Banking', 223, '1173 Jorenz Valenzuela City, NCR 1442 Philippines');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`),
  ADD CONSTRAINT `shipping_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
