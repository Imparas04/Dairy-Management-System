-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 04:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dairy_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_id`, `customer_name`, `phone`, `address`) VALUES
(3, 35, 'aditya mohite', '7415254874', 'ishwarpur'),
(4, 36, 'om jadhav', '9852145685', 'bahe'),
(5, 37, 'harshad patil', '8541452541', 'kapuskhed'),
(6, 38, 'pavan jadhav', '9525414525', 'pundi'),
(7, 39, 'shree patil', '9852145685', 'bahe'),
(8, 40, 'rushikesh rathod', '8565254515', 'ishwarpur'),
(9, 41, 'rohan patil', '8541452569', 'nagthane'),
(10, 42, 'nayan pol', '8541452547', 'rajapur'),
(11, 43, 'sagar potdar', '8446462278', 'shirala'),
(12, 44, 'siddhu mahadik', '8541452541', 'ishwarpur'),
(13, 45, 'omkar devangale', '9317539652', 'shirala'),
(14, 46, 'paras chaudhari', '8541452547', 'shirala'),
(15, 47, 'sujit patil', '9852145632', 'yedenipani'),
(16, 48, 'sumit patil', '8525145625', 'aitawade');

-- --------------------------------------------------------

--
-- Table structure for table `farmers`
--

CREATE TABLE `farmers` (
  `farmer_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `farmer_name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `join_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`farmer_id`, `user_id`, `farmer_name`, `phone`, `address`, `join_date`) VALUES
(5, 6, 'santosh mahadik', '8000521580', 'ISHWARPUR', '2026-03-06'),
(7, 9, 'Sampat Patil', '9852635478', 'Ishwarpur', '2026-03-07'),
(8, 10, 'Uttam patil', '8965231456', 'bahe', '2026-03-07'),
(9, 11, 'satish patil', '9625458952', 'kapuskhed', '2026-03-07'),
(10, 12, 'pandurang kadam', '7852145698', 'ishwarpur', '2026-03-07'),
(11, 13, 'pradip sawant', '9552254515', 'bahe', '2026-03-07'),
(12, 14, 'dhananjay patil', '9865321456', 'ishwarpur', '2026-03-07'),
(13, 15, 'ramesh kambale', '8569412565', 'kapuskhed', '2026-03-07'),
(14, 16, 'tanaji desai', '9854125898', 'kapuskhed', '2026-03-07'),
(15, 17, 'sakharam patil', '8547125698', 'ishwarpur', '2026-03-07'),
(16, 18, 'anil yadav', '9845125698', 'sakharale', '2026-03-07'),
(17, 19, 'rajaram patil', '8745126359', 'ishwarpur', '2026-03-07'),
(18, 20, 'mahadev pawar', '9852147852', 'bahe', '2026-03-07'),
(20, 22, 'ananda patil', '8745125985', 'kapuskhed\r\n', '2026-03-07'),
(21, 23, 'sahebrao kadam', '8541256987', 'ishwarpur', '2026-03-07'),
(22, 24, 'santosh pawar', '7852145698', 'bahe', '2026-03-07'),
(23, 25, 'anil gaikwad', '8574120369', 'sakharale', '2026-03-07'),
(24, 26, 'bhagvan sawant', '9852145621', 'ishwarpur', '2026-03-07'),
(25, 27, 'mukund mohite', '9852145630', 'bahe', '2026-03-07'),
(26, 28, 'jaywant pawar', '7854123698', 'sakharale', '2026-03-07'),
(27, 29, 'hanmant mahite', '8574985415', 'ishwarpur', '2026-03-07'),
(28, 30, 'sunil kymbhar', '8547125984', 'kapuskhed', '2026-03-07'),
(29, 31, 'ramchandra mohite', '7485963214', 'ishwarpur', '2026-03-07'),
(30, 32, 'vijay deshmukh', '8541259652', 'ishwarpur', '2026-03-07'),
(31, 33, 'vinod kadam', '8562547852', 'bahe', '2026-03-07'),
(32, 49, 'pranav chaugule', '9852145626', 'yedenipani', '2026-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `milk_collection`
--

CREATE TABLE `milk_collection` (
  `collection_id` int(11) NOT NULL,
  `farmer_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `milk_type` enum('cow','buffalo') DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `fat_percent` decimal(4,2) DEFAULT NULL,
  `rate_per_liter` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `milk_collection`
--

INSERT INTO `milk_collection` (`collection_id`, `farmer_id`, `date`, `milk_type`, `quantity`, `fat_percent`, `rate_per_liter`, `total_amount`) VALUES
(3, 7, '2026-03-07', 'buffalo', 7.00, 5.50, 40.00, 280.00),
(4, 8, '2026-03-07', 'cow', 10.00, 4.00, 40.00, 400.00),
(5, 5, '2026-03-07', 'cow', 7.00, 3.50, 40.00, 280.00),
(6, 22, '2026-03-07', 'buffalo', 10.00, 5.60, 40.00, 400.00),
(7, 32, '2026-03-07', 'buffalo', 10.00, 5.60, 40.00, 400.00),
(8, 14, '2026-03-08', 'cow', 5.00, 5.00, 40.00, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `order_date`, `total_amount`) VALUES
(6, 3, '2026-03-07 10:51:13', 500.00),
(7, 4, '2026-03-07 10:51:29', 320.00),
(8, 15, '2026-03-07 11:13:16', 640.00),
(9, 15, '2026-03-07 11:14:09', 130.00),
(10, 15, '2026-03-07 11:14:56', 100.00),
(12, 16, '2026-03-07 12:08:02', 120.00),
(13, 15, '2026-03-07 22:03:55', 250.00),
(14, 15, '2026-03-07 22:04:28', 130.00),
(15, 15, '2026-03-07 22:04:46', 120.00),
(16, 6, '2026-03-07 22:08:26', 500.00),
(17, 13, '2026-03-08 14:11:20', 100.00),
(18, 15, '2026-03-08 19:08:49', 500.00),
(20, 15, '2026-03-08 19:09:27', 500.00),
(21, 15, '2026-03-08 19:10:27', 500.00),
(22, 15, '2026-03-08 19:10:39', 650.00),
(23, 15, '2026-03-11 11:00:59', 120.00),
(24, 15, '2026-03-11 11:03:23', 250.00),
(25, 15, '2026-03-11 20:04:14', 250.00),
(26, 13, '2026-03-11 20:04:50', 250.00),
(27, 13, '2026-03-11 20:06:41', 250.00),
(28, 13, '2026-03-11 20:06:44', 250.00),
(29, 13, '2026-03-11 20:06:53', 250.00),
(35, 13, '2026-03-11 20:11:46', 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(6, 6, 1, 2, 250.00),
(7, 7, 2, 1, 320.00),
(8, 8, 2, 2, 320.00),
(12, 12, 6, 1, 120.00),
(13, 13, 1, 1, 250.00),
(15, 15, 4, 2, 60.00),
(16, 16, 1, 2, 250.00),
(20, 20, 9, 10, 50.00),
(21, 21, 9, 10, 50.00),
(22, 22, 10, 10, 65.00),
(23, 23, 4, 2, 60.00),
(24, 24, 1, 1, 250.00),
(25, 25, 1, 1, 250.00),
(26, 26, 1, 1, 250.00),
(27, 27, 1, 1, 250.00),
(28, 28, 1, 1, 250.00),
(29, 29, 1, 1, 250.00),
(35, 35, 1, 1, 250.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `farmer_id` int(11) DEFAULT NULL,
  `month` varchar(20) DEFAULT NULL,
  `total_liters` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  `payment_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `farmer_id`, `month`, `total_liters`, `total_amount`, `payment_status`, `payment_date`) VALUES
(2, 7, '2026-03', 7.00, 280.00, 'Paid', '2026-03-07'),
(3, 8, '2026-03', 10.00, 400.00, 'Pending', NULL),
(4, 5, '2026-03', 7.00, 280.00, 'Pending', NULL),
(5, 32, '2026-03', 10.00, 400.00, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `stock`, `image`) VALUES
(1, 'Butter', 250.00, 30, 'butter.jpg'),
(2, 'Paneer', 320.00, 73, 'paneer.png'),
(3, 'Ghee', 650.00, 59, 'ghee.png'),
(4, 'Curd', 60.00, 196, 'curd.png'),
(5, 'Cheese', 420.00, 90, 'cheese.webp'),
(6, 'Ice Cream', 120.00, 138, 'ice_cream.webp'),
(7, 'Khoya', 500.00, 40, 'khoya.webp'),
(8, 'Flavoured Milk', 50.00, 300, 'flavoured_milk.webp'),
(9, 'Cow Milk', 50.00, 79, 'cow_milk.png'),
(10, 'Buffalo Milk', 65.00, 90, 'buffelo_milk.webp');

-- --------------------------------------------------------

--
-- Table structure for table `rate_chart`
--

CREATE TABLE `rate_chart` (
  `rate_id` int(11) NOT NULL,
  `milk_type` enum('cow','buffalo') DEFAULT NULL,
  `fat_percent` decimal(4,2) DEFAULT NULL,
  `rate_per_liter` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','farmer','customer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@dairy.com', '0192023a7bbd73250516f069df18b500', 'admin', '2026-03-05 17:22:21'),
(2, 'santosh mahadik', 'santosh@m.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-06 14:20:16'),
(6, 'santosh mahadik', 'santosh@mk.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-06 14:22:27'),
(9, 'Sampat Patil', 'sampatpatil@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 02:40:42'),
(10, 'Uttam patil', 'uttam@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:54:22'),
(11, 'satish patil', 'satish@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:55:06'),
(12, 'pandurang kadam', 'pandurang@k.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:55:45'),
(13, 'pradip sawant', 'pradip@s.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:56:26'),
(14, 'dhananjay patil', 'dhananjay@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:56:58'),
(15, 'ramesh kambale', 'ramesh@k.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:57:52'),
(16, 'tanaji desai', 'tanaji@d.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:58:39'),
(17, 'sakharam patil', 'sakharam@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:59:17'),
(18, 'anil yadav', 'anil@y.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 04:59:54'),
(19, 'rajaram patil', 'rajaram@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:00:39'),
(20, 'mahadev pawar', 'mahadev@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:01:12'),
(22, 'ananda patil', 'ananda@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:02:53'),
(23, 'sahebrao kadam', 'sahebrao@k.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:03:28'),
(24, 'santosh pawar', 'santosh@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:04:02'),
(25, 'anil gaikwad', 'anil@g.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:04:49'),
(26, 'bhagvan sawant', 'bhagvan@s.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:05:54'),
(27, 'mukund mohite', 'mukund@m.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:06:20'),
(28, 'jaywant pawar', 'jaywant@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:06:47'),
(29, 'hanmant mahite', 'hanmant@m.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:07:19'),
(30, 'sunil kymbhar', 'sunil@k.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:08:09'),
(31, 'ramchandra mohite', 'ramchandra@m.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:08:48'),
(32, 'vijay deshmukh', 'vijay@d.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:09:27'),
(33, 'vinod kadam', 'vinod@k.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 05:10:14'),
(35, 'aditya mohite', 'aditya@m.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:12:12'),
(36, 'om jadhav', 'om@j.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:12:43'),
(37, 'harshad patil', 'harshad@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:13:35'),
(38, 'pavan jadhav', 'pavan@j.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:14:12'),
(39, 'shree patil', 'shree@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:15:06'),
(40, 'rushikesh rathod', 'rushi@r.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:16:15'),
(41, 'rohan patil', 'rohan@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:17:01'),
(42, 'nayan pol', 'nayan@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:17:49'),
(43, 'sagar potdar', 'sagae@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:18:20'),
(44, 'siddhu mahadik', 'siddhu@m.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:19:06'),
(45, 'omkar devangale', 'omkar@d.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:20:13'),
(46, 'paras chaudhari', 'paras@c.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:20:52'),
(47, 'sujit patil', 'sujit@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 05:42:54'),
(48, 'sumit patil', 'sumit@p.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer', '2026-03-07 06:34:48'),
(49, 'pranav chaugule', 'pranav@c.com', 'e10adc3949ba59abbe56e057f20f883e', 'farmer', '2026-03-07 07:16:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`farmer_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `milk_collection`
--
ALTER TABLE `milk_collection`
  ADD PRIMARY KEY (`collection_id`),
  ADD KEY `farmer_id` (`farmer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `farmer_id` (`farmer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `rate_chart`
--
ALTER TABLE `rate_chart`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `farmer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `milk_collection`
--
ALTER TABLE `milk_collection`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rate_chart`
--
ALTER TABLE `rate_chart`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `farmers`
--
ALTER TABLE `farmers`
  ADD CONSTRAINT `farmers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `milk_collection`
--
ALTER TABLE `milk_collection`
  ADD CONSTRAINT `milk_collection_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`farmer_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`farmer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
