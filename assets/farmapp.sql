-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2020 at 08:00 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `label`, `value`, `created`, `last_updated`) VALUES
(1, 'Yes', 'yes', '2020-05-21 03:05:23', '2020-05-21 03:05:23'),
(2, 'Vacation', 'vacation', '2020-05-21 03:05:36', '2020-05-21 03:05:36'),
(3, 'Reported', 'reported', '2020-05-21 03:05:50', '2020-05-21 03:05:50'),
(4, 'Suspended', 'suspended', '2020-05-21 03:06:02', '2020-05-21 03:06:02'),
(5, 'Blocked', 'blocked', '2020-05-21 03:06:18', '2020-05-21 03:06:18'),
(6, 'Removed', 'removed', '2020-05-21 03:06:32', '2020-05-21 03:06:32');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT 0 COMMENT '0 = text\r\n1 = checkbox\r\n2 = radio',
  `label` tinytext DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `name`, `type`, `label`, `value`, `created`, `last_updated`) VALUES
(1, 'notify_email', 1, 'Notify via Email', NULL, '2020-05-21 03:22:54', '2020-05-24 03:24:29'),
(2, 'notify_inapp', 1, 'InApp Notification', 'checked', '2020-05-21 03:23:31', '2020-05-24 03:24:33'),
(3, 'notify_text', 1, 'Notify via SMS', NULL, '2020-05-21 03:24:18', '2020-05-21 04:29:07'),
(4, 'notify_policy', 1, 'Policy Notification', 'checked', '2020-05-21 03:25:28', '2020-05-24 03:24:40'),
(5, 'password_change', 0, 'Password change', NULL, '2020-05-21 03:25:45', '2020-05-24 03:25:22'),
(6, 'facebook_account', 0, 'Facebook', NULL, '2020-05-21 03:26:06', '2020-05-21 03:26:39'),
(7, 'youtube_account', 0, 'YouTube', NULL, '2020-05-21 03:26:11', '2020-05-21 03:26:59'),
(8, 'instagram_account', 0, 'Instagram', NULL, '2020-05-21 03:26:17', '2020-05-21 03:27:06'),
(9, 'twitter_account', 0, 'Twitter', NULL, '2020-05-21 03:26:25', '2020-05-21 03:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `help`
--

CREATE TABLE `help` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `title` tinytext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status_id` int(11) NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `last_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `label`, `value`, `created`, `last_updated`) VALUES
(1, 'Waiting for Seller', 'waiting_for_seller', '2020-05-21 03:02:39', '2020-05-21 03:04:07'),
(2, 'In Transit', 'in_transit', '2020-05-21 03:02:50', '2020-05-21 03:04:19'),
(3, 'Cancelled', 'cancelled', '2020-05-21 03:03:00', '2020-05-21 03:04:26'),
(4, 'Completed', 'completed', '2020-05-21 03:03:10', '2020-05-21 03:04:30'),
(5, 'Order Placed', 'order_placed', '2020-05-21 03:03:34', '2020-05-21 03:04:40'),
(6, 'Rejected by Seller', 'rejected_by_seller', '2020-05-21 03:03:42', '2020-05-21 03:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name` tinytext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stocks` int(11) NOT NULL DEFAULT 0,
  `measurement` varchar(10) DEFAULT 'kg',
  `current_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `old_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_option_id` smallint(6) NOT NULL DEFAULT 0,
  `activity_id` smallint(6) NOT NULL DEFAULT 1,
  `category_id` smallint(6) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `label`, `value`, `created`, `last_updated`) VALUES
(1, 'Lettuce', 'lettuce', '2020-05-24 20:29:40', '2020-05-24 20:29:46'),
(2, 'Tomatoes', 'tomatoes', '2020-05-24 20:30:17', '2020-05-24 20:30:17'),
(3, 'Mustard', 'mustard', '2020-05-24 20:30:25', '2020-05-24 20:30:25'),
(4, 'Others', 'others', '2020-05-24 20:30:38', '2020-05-24 20:30:38');

-- --------------------------------------------------------

--
-- Table structure for table `product_delivery_option`
--

CREATE TABLE `product_delivery_option` (
  `id` int(11) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_delivery_option`
--

INSERT INTO `product_delivery_option` (`id`, `label`, `value`, `created`, `last_updated`) VALUES
(1, 'C.O.D', 'cod', '2020-05-21 03:07:12', '2020-05-21 03:07:12'),
(2, 'Credit card', 'cc', '2020-05-21 03:07:32', '2020-05-21 03:07:32'),
(3, 'Paypal account', 'paypal', '2020-05-21 03:07:51', '2020-05-21 03:07:51'),
(4, 'G Cash', 'gcash', '2020-05-21 03:08:14', '2020-05-21 03:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `product_measurement`
--

CREATE TABLE `product_measurement` (
  `id` int(11) NOT NULL,
  `label` tinytext DEFAULT NULL,
  `value` tinytext DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_measurement`
--

INSERT INTO `product_measurement` (`id`, `label`, `value`, `created`, `last_updated`) VALUES
(1, 'Kilo', 'kg', '2020-05-24 20:03:53', '2020-05-24 20:03:53'),
(2, 'Bundle', 'bundle', '2020-05-24 20:04:14', '2020-05-24 20:04:14'),
(3, 'Box', 'box', '2020-05-24 20:04:26', '2020-05-24 20:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `product_photo`
--

CREATE TABLE `product_photo` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `name` tinytext DEFAULT NULL,
  `description` text DEFAULT NULL,
  `path` longtext DEFAULT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `farmer` tinyint(1) NOT NULL DEFAULT 0,
  `about` text DEFAULT NULL,
  `banner` text DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `activity_id` tinyint(4) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email_address`, `farmer`, `about`, `banner`, `photo`, `activity_id`, `created`, `last_updated`) VALUES
(1, 'Eddie', 'Garcia', 'eddie+test@gmail.com', 1, 'Gace Farm', NULL, NULL, 2, '2020-05-22 05:14:56', '2020-05-23 12:18:43'),
(2, 'Eddie', 'Garcia', 'eddie+test23@ypdigital.com.au', 0, NULL, NULL, NULL, 1, '2020-05-23 06:42:20', '2020-05-26 02:00:07'),
(3, 'Poi', 'Garcia', 'poi@gmail.com', 1, NULL, NULL, NULL, 1, '2020-05-24 02:18:51', '2020-05-24 02:18:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_app_settings`
--

CREATE TABLE `user_app_settings` (
  `user_id` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `type` int(11) DEFAULT 0 COMMENT '0 = text\r\n1 = checkbox\r\n2 = radio',
  `label` text DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_app_settings`
--

INSERT INTO `user_app_settings` (`user_id`, `id`, `name`, `type`, `label`, `value`, `created`, `last_updated`) VALUES
(1, 1, 'notify_email', 1, 'Notify via Email', 'checked', '2020-05-22 05:14:56', '2020-05-23 12:59:36'),
(1, 2, 'notify_inapp', 1, 'InApp Notification', 'checked', '2020-05-22 05:14:56', '2020-05-23 12:12:45'),
(1, 3, 'notify_text', 1, 'Notify via SMS', 'checked', '2020-05-22 05:14:56', '2020-05-23 12:59:36'),
(1, 4, 'notify_policy', 1, 'Policy Notification', 'checked', '2020-05-22 05:14:56', '2020-05-23 12:12:42'),
(1, 5, 'password', 0, 'Password', '1', '2020-05-22 05:14:56', '2020-05-22 05:14:56'),
(1, 6, 'facebook_account', 0, 'Facebook', 'dsadasdas', '2020-05-22 05:14:56', '2020-05-23 12:59:36'),
(1, 7, 'youtube_account', 0, 'YouTube', 'dsadasdas', '2020-05-22 05:14:56', '2020-05-23 12:59:36'),
(1, 8, 'instagram_account', 0, 'Instagram', 'dsadasdas', '2020-05-22 05:14:56', '2020-05-23 12:59:36'),
(1, 9, 'twitter_account', 0, 'Twitter', 'dasdasdasda', '2020-05-22 05:14:56', '2020-05-23 12:59:36'),
(2, 1, 'notify_email', 1, 'Notify via Email', NULL, '2020-05-23 06:42:20', '2020-05-23 12:12:53'),
(2, 2, 'notify_inapp', 1, 'InApp Notification', 'checked', '2020-05-23 06:42:20', '2020-05-23 12:12:55'),
(2, 3, 'notify_text', 1, 'Notify via SMS', NULL, '2020-05-23 06:42:20', '2020-05-23 12:12:59'),
(2, 4, 'notify_policy', 1, 'Policy Notification', 'checked', '2020-05-23 06:42:20', '2020-05-23 12:12:58'),
(2, 5, 'password', 0, 'Password', '1', '2020-05-23 06:42:20', '2020-05-23 06:42:20'),
(2, 6, 'facebook_account', 0, 'Facebook', NULL, '2020-05-23 06:42:20', '2020-05-23 06:42:20'),
(2, 7, 'youtube_account', 0, 'YouTube', NULL, '2020-05-23 06:42:20', '2020-05-23 06:42:20'),
(2, 8, 'instagram_account', 0, 'Instagram', NULL, '2020-05-23 06:42:20', '2020-05-23 06:42:20'),
(2, 9, 'twitter_account', 0, 'Twitter', NULL, '2020-05-23 06:42:20', '2020-05-23 06:42:20'),
(3, 1, 'notify_email', 0, 'Notify via Email', NULL, '2020-05-24 02:18:51', '2020-05-24 02:18:51'),
(3, 2, 'notify_inapp', 0, 'InApp Notification', 'checked', '2020-05-24 02:18:51', '2020-05-24 02:18:51'),
(3, 3, 'notify_text', 0, 'Notify via SMS', NULL, '2020-05-24 02:18:51', '2020-05-24 02:18:51'),
(3, 4, 'notify_policy', 0, 'Policy Notification', 'checked', '2020-05-24 02:18:51', '2020-05-24 02:18:51'),
(3, 5, 'password', 0, 'Password', '1', '2020-05-24 02:18:51', '2020-05-24 02:18:51'),
(3, 6, 'facebook_account', 0, 'Facebook', NULL, '2020-05-24 02:18:52', '2020-05-24 02:18:52'),
(3, 7, 'youtube_account', 0, 'YouTube', NULL, '2020-05-24 02:18:52', '2020-05-24 02:18:52'),
(3, 8, 'instagram_account', 0, 'Instagram', NULL, '2020-05-24 02:18:52', '2020-05-24 02:18:52'),
(3, 9, 'twitter_account', 0, 'Twitter', NULL, '2020-05-24 02:18:52', '2020-05-24 02:18:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

CREATE TABLE `user_location` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `farm_name` tinytext DEFAULT NULL,
  `address` tinytext DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `last_updated` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_location`
--

INSERT INTO `user_location` (`id`, `user_id`, `lat`, `lng`, `farm_name`, `address`, `created`, `last_updated`) VALUES
(1, 1, 14.8579, 120.814, NULL, 'Bulacan State University, Malolos, Bulacan, Philippines', '2020-05-22 05:14:56', '2020-05-23 14:08:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help`
--
ALTER TABLE `help`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_option` (`delivery_option_id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_delivery_option`
--
ALTER TABLE `product_delivery_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_measurement`
--
ALTER TABLE `product_measurement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_photo`
--
ALTER TABLE `product_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `is_main` (`is_main`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_address` (`email_address`),
  ADD KEY `activity` (`activity_id`);

--
-- Indexes for table `user_app_settings`
--
ALTER TABLE `user_app_settings`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `settings_id` (`id`);

--
-- Indexes for table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `help`
--
ALTER TABLE `help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_delivery_option`
--
ALTER TABLE `product_delivery_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_measurement`
--
ALTER TABLE `product_measurement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_photo`
--
ALTER TABLE `product_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
