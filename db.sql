-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2026 at 10:35 PM
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `payfast_transactions`
--

CREATE TABLE `payfast_transactions` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_id` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `raw_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `username` varchar(5) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_condition` varchar(20) DEFAULT 'New',
  `product_category` varchar(50) DEFAULT 'General',
  `product_image` varchar(255) DEFAULT NULL,
  `sold` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `username`, `product_name`, `product_description`, `product_price`, `product_condition`, `product_category`, `product_image`, `sold`) VALUES
(1, 'JOHN5', 'PlayStation 5 Console', 'Latest Sony gaming console with ultra-fast SSD and 4K gaming', 11999.99, 'New', 'Console', 'ps5.jpg', 0),
(2, 'JACK2', 'Xbox Series X', 'Microsoft flagship console with powerful GPU and Game Pass support', 10999.99, 'New', 'Console', 'xboxseriesx.jpg', 0),
(3, 'NOAH4', 'Nintendo Switch OLED', 'Portable console with vibrant OLED screen and handheld mode', 7999.99, 'New', 'Console', 'nintendoswitch.jpg', 0),
(5, 'JOHN5', 'Razer BlackShark V2 Headset', 'Professional esports headset with surround sound', 1610.99, 'Used', 'Accessory', 'RazerBlackSharkV2Headset.jpg', 0),
(6, 'JACK2', 'Logitech G502 Mouse', 'High precision gaming mouse with customizable DPI', 999.99, 'Used', 'Accessory', 'logitechg502.png', 0),
(8, 'NOAH4', 'SteelSeries Mousepad XL', 'Extra large smooth surface gaming mousepad', 499.99, 'Used', 'Accessory', 'steelseriesmousepadxl.png', 0),
(9, 'JOHN5', 'Elden Ring (PS4)', 'Open-world fantasy RPG with deep combat system', 499.99, 'New', 'Game', 'EldenRing.jpg', 0),
(10, 'JACK2', 'Call of Duty MWIII (PS4)', 'Fast-paced military FPS with multiplayer modes', 599.99, 'Used', 'Game', 'codMWIII.jpg', 0),
(11, 'NOAH4', 'EAFC 26 (PS5)', 'Latest football simulation game with updated teams and graphics', 1399.99, 'Used', 'Game', 'eafc26.jpg', 0),
(12, 'NOAH4', 'Cyberpunk 2077 Phantom Liberty (PS5)', 'Story expansion with improved gameplay and visuals', 899.99, 'Used', 'Game', 'Cyberpunk2077PhantomLiberty.jpg', 1),
(14, 'JACK2', 'PlayStation DualSense Controller (WHITE)', 'Advanced haptic feedback controller for PS5', 800.99, 'Refurbished', 'Accessory', 'PS5Controllerwhite.png', 1),
(15, 'NOAH4', 'Xbox Elite Controller Series 2', 'Premium customizable controller for competitive gaming', 2499.99, 'New', 'Accessory', 'XboxEliteControllerSeries2.png', 1),
(16, 'JOHN5', 'Sony PSP', 'Sony\'s first handheld portable device created for gaming on the move ', 800.00, 'Used', 'Console', 'sonypsp.jpg', 0),
(17, 'NOAH4', 'PlayStation DualSense Pro Controller', 'Built with high performance and personalisation in mind, this new PS5 controller invites you to craft your own unique gaming experience so you can play your way.', 3200.00, 'Used', 'Accessory', 'ps5procontroller.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `seller_username` varchar(100) NOT NULL,
  `buyer_username` varchar(100) NOT NULL,
  `sale_status` varchar(50) DEFAULT 'Pending',
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_status` varchar(50) DEFAULT 'Paid',
  `seller_paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `product_id`, `seller_username`, `buyer_username`, `sale_status`, `sale_date`, `amount`, `order_status`, `seller_paid`) VALUES
(9, 15, 'NOAH4', 'JOHN5', 'Pending', '2026-05-29 21:42:19', 2499.99, 'Completed', 0),
(10, 14, 'JACK2', 'NOAH4', 'Pending', '2026-05-29 23:03:16', 800.99, 'Completed', 0),
(11, 12, 'NOAH4', 'JACK2', 'Pending', '2026-06-01 08:04:00', 899.99, 'Completed', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 0,
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `name`, `surname`, `password`, `phone_number`, `email`, `admin`, `street_address`, `city`, `province`, `postal_code`) VALUES
('JACK2', 'Jack', 'Smith', 'pass456', '0823456787', 'jack.smith@example.com', 0, '9 Hill Street', 'Cape Town', 'Western Cape', '8001'),
('JOHN5', 'John', 'Smith', 'pass111', '0834569852', 'johnsmith@exa.com', 0, '55 Main Road', 'Pretoria', 'Gauteng', '0002'),
('LUSH1', 'Lushen', 'Govender', 'pass123', '0640086235', 'lushengovender@example.com', 1, '123 road', 'far far', 'close close', '1020'),
('NOAH4', 'Noah', 'William', 'pass321', '0845678900', 'noah.williams@example.com', 0, '12 Oak Street', 'Johannesburg', 'Gauteng', '2000'),
('STAC0', 'Stacey', 'Byrne', 'bestLecturer4always!', '0987231233', 'sByrne@gmail.com', 0, '9 Hill Street', 'Cape Town', 'close close', '2000'),
('STACY', 'Stacey', 'Byrne', 'bestLecturer4eva!', '0834569854', 'sByrneAdmin@gmail.com', 1, '12 Oak Street', 'Johannesburg', 'Western Cape', '1020');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `wallet_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`wallet_id`, `username`, `balance`) VALUES
(3, 'NOAH4', 15109.97),
(4, 'JOHN5', 1300.01),
(5, 'JACK2', 1501.01),
(7, 'STAC0', 300.00),
(8, 'STACY', 0.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payfast_transactions`
--
ALTER TABLE `payfast_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`wallet_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payfast_transactions`
--
ALTER TABLE `payfast_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
