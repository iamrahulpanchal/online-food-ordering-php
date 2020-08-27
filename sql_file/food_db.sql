-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2020 at 11:13 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `a_name` varchar(50) NOT NULL,
  `a_username` varchar(50) NOT NULL,
  `a_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `a_name`, `a_username`, `a_password`) VALUES
(1, 'Admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `b_id` int(11) NOT NULL,
  `b_heading` varchar(255) NOT NULL,
  `b_sub_heading` varchar(255) NOT NULL,
  `b_link` varchar(20) NOT NULL,
  `b_link_text` varchar(50) NOT NULL,
  `b_image` varchar(255) NOT NULL,
  `b_added_on` datetime NOT NULL,
  `b_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`b_id`, `b_heading`, `b_sub_heading`, `b_link`, `b_link_text`, `b_image`, `b_added_on`, `b_status`) VALUES
(1, 'Fresh & Healthy', 'Eat Good Stuff & Be Healthy', 'shop', 'Order Now', '160132410_200603432_173771450_slider-2.jpg.jpg', '2020-08-27 12:28:02', 1),
(2, 'Fresh & Healthy', 'Eat Good Stuff & Be Healthy', 'shop', 'Order Now', '563626046_486401685_660101446_slider-1.jpg.jpg', '2020-08-27 12:28:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(100) NOT NULL,
  `c_order` int(11) NOT NULL,
  `c_status` int(11) NOT NULL,
  `c_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `c_name`, `c_order`, `c_status`, `c_added_on`) VALUES
(1, 'Drinks', 1, 1, '2020-08-27 12:40:17'),
(2, 'Burgers', 2, 1, '2020-08-27 12:40:24'),
(3, 'Fries', 3, 1, '2020-08-27 12:40:29'),
(4, 'Rice', 4, 1, '2020-08-27 12:40:35'),
(5, 'Nuggets', 5, 1, '2020-08-27 12:40:43'),
(6, 'Cookies', 6, 1, '2020-08-27 12:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `cu_id` int(11) NOT NULL,
  `cu_name` varchar(50) NOT NULL,
  `cu_email` varchar(50) NOT NULL,
  `cu_subject` text NOT NULL,
  `cu_message` text NOT NULL,
  `cu_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`cu_id`, `cu_name`, `cu_email`, `cu_subject`, `cu_message`, `cu_added_on`) VALUES
(1, 'Rahul Panchal', 'rahulnpanchal50@gmail.com', 'Contact Us Test Subject', 'Contact Us Test Message', '2020-08-27 12:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_code`
--

CREATE TABLE `coupon_code` (
  `cc_id` int(11) NOT NULL,
  `cc_code` varchar(50) NOT NULL,
  `cc_type` enum('P','F') NOT NULL,
  `cc_value` int(11) NOT NULL,
  `cc_cart_min_value` int(11) NOT NULL,
  `cc_expired_on` date NOT NULL,
  `cc_status` int(11) NOT NULL,
  `cc_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coupon_code`
--

INSERT INTO `coupon_code` (`cc_id`, `cc_code`, `cc_type`, `cc_value`, `cc_cart_min_value`, `cc_expired_on`, `cc_status`, `cc_added_on`) VALUES
(1, 'FIRST50', 'F', 50, 100, '2020-09-27', 1, '2027-08-20 12:46:29'),
(2, 'FRIDAY', 'P', 10, 100, '2020-10-27', 1, '2027-08-20 12:46:43');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

CREATE TABLE `delivery_boy` (
  `db_id` int(11) NOT NULL,
  `db_name` varchar(50) NOT NULL,
  `db_mobile` varchar(20) NOT NULL,
  `db_password` varchar(50) NOT NULL,
  `db_status` int(11) NOT NULL,
  `db_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_boy`
--

INSERT INTO `delivery_boy` (`db_id`, `db_name`, `db_mobile`, `db_password`, `db_status`, `db_added_on`) VALUES
(1, 'Ramesh Thakur', '8432496214', 'ramesh', 1, '2027-08-20 12:51:14'),
(2, 'Suraj Singh', '9583906235', 'suraj', 1, '2027-08-20 12:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `d_id` int(11) NOT NULL,
  `d_c_id` int(11) NOT NULL,
  `d_dish` varchar(100) NOT NULL,
  `d_dish_detail` text NOT NULL,
  `d_status` int(11) NOT NULL,
  `d_added_on` datetime NOT NULL,
  `d_image` varchar(100) NOT NULL,
  `d_type` enum('veg','non-veg') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`d_id`, `d_c_id`, `d_dish`, `d_dish_detail`, `d_status`, `d_added_on`, `d_image`, `d_type`) VALUES
(1, 1, 'Chia Seeds Juice', 'Chia Seeds Juice', 1, '2020-08-27 12:56:50', '344367932_product-1.jpg', 'veg'),
(2, 2, 'Ch. Mexican Burger', 'Ch. Mexican Burger', 1, '2020-08-27 12:59:38', '480311601_product-3.jpg', 'non-veg'),
(3, 1, 'Strawberry Juice', 'Strawberry Juice', 1, '2020-08-27 01:16:51', '676337186_product-2.jpg', 'veg'),
(4, 1, 'Coca-Cola', 'Coca-Cola', 1, '2020-08-27 01:18:23', '790111611_product-4.jpg', 'veg'),
(5, 3, 'Regular Fries', 'Regular Fries', 1, '2020-08-27 01:20:19', '567590281_product-5.jpg', 'veg'),
(6, 3, 'Deep Fries', 'Deep Fries', 1, '2020-08-27 01:21:27', '343997161_product-7.jpg', 'veg'),
(7, 5, 'Chicken Popcorn', 'Chicken Popcorn', 1, '2020-08-27 01:22:38', '866391017_product-10.jpg', 'non-veg'),
(8, 4, 'Fried Rice', 'Fried Rice', 1, '2020-08-27 01:23:26', '480500580_product-9.jpg', 'veg'),
(9, 5, 'Chicken Nuggets', 'Chicken Nuggets', 1, '2020-08-27 01:24:09', '573116925_product-6.jpg', 'non-veg'),
(10, 6, 'Choco Cookies', 'Choco Cookies', 1, '2020-08-27 01:24:55', '983567205_product-8.jpg', 'veg');

-- --------------------------------------------------------

--
-- Table structure for table `dish_cart`
--

CREATE TABLE `dish_cart` (
  `dc_id` int(11) NOT NULL,
  `dc_u_id` int(11) NOT NULL,
  `dc_dd_id` int(11) NOT NULL,
  `dc_qty` int(11) NOT NULL,
  `dc_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dish_details`
--

CREATE TABLE `dish_details` (
  `dd_id` int(11) NOT NULL,
  `dd_d_id` int(11) NOT NULL,
  `dd_attribute` varchar(100) NOT NULL,
  `dd_price` int(11) NOT NULL,
  `dd_status` int(11) NOT NULL,
  `dd_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dish_details`
--

INSERT INTO `dish_details` (`dd_id`, `dd_d_id`, `dd_attribute`, `dd_price`, `dd_status`, `dd_added_on`) VALUES
(1, 1, 'Half Glass', 30, 1, '2020-08-27 12:58:29'),
(2, 1, 'Full Glass', 50, 1, '2020-08-27 12:58:29'),
(3, 2, '1 Pc', 65, 1, '2020-08-27 12:59:39'),
(4, 2, '2 Pc', 95, 1, '2020-08-27 12:59:51'),
(5, 3, 'Half Glass', 20, 1, '2020-08-27 01:16:51'),
(6, 3, 'Full Glass', 35, 1, '2020-08-27 01:16:51'),
(7, 4, 'Half Glass', 45, 1, '2020-08-27 01:18:23'),
(8, 4, 'Full Glass', 80, 1, '2020-08-27 01:18:23'),
(9, 5, 'Small', 60, 1, '2020-08-27 01:20:19'),
(10, 5, 'Large', 105, 1, '2020-08-27 01:20:19'),
(11, 6, 'Small', 70, 1, '2020-08-27 01:21:27'),
(12, 6, 'Large', 110, 1, '2020-08-27 01:21:27'),
(13, 7, 'Small', 80, 1, '2020-08-27 01:22:38'),
(14, 7, 'Large', 135, 1, '2020-08-27 01:22:38'),
(15, 8, 'Half Bowl', 45, 1, '2020-08-27 01:23:26'),
(16, 8, 'Full Bowl', 85, 1, '2020-08-27 01:23:26'),
(17, 9, 'Small', 65, 1, '2020-08-27 01:24:09'),
(18, 9, 'Large', 105, 1, '2020-08-27 01:24:09'),
(19, 10, '5 Pc', 15, 1, '2020-08-27 01:24:55'),
(20, 10, '10 Pc', 25, 1, '2020-08-27 01:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `od_id` int(11) NOT NULL,
  `od_o_id` int(11) NOT NULL,
  `od_dd_id` int(11) NOT NULL,
  `od_price` float NOT NULL,
  `od_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`od_id`, `od_o_id`, `od_dd_id`, `od_price`, `od_qty`) VALUES
(1, 1, 2, 50, 3),
(2, 1, 3, 65, 4),
(3, 1, 5, 20, 5),
(4, 1, 7, 45, 2),
(5, 2, 4, 95, 2),
(6, 2, 5, 20, 5),
(7, 2, 8, 80, 2),
(8, 2, 10, 105, 2),
(9, 3, 11, 70, 4),
(10, 3, 9, 60, 5),
(11, 3, 17, 65, 3),
(12, 4, 1, 30, 1),
(13, 4, 17, 65, 3),
(14, 4, 13, 80, 3),
(15, 5, 18, 105, 2),
(16, 5, 3, 65, 5);

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

CREATE TABLE `order_master` (
  `om_id` int(11) NOT NULL,
  `om_u_id` int(11) NOT NULL,
  `om_u_name` varchar(100) NOT NULL,
  `om_u_email` varchar(100) NOT NULL,
  `om_u_mobile` varchar(20) NOT NULL,
  `om_u_address` text NOT NULL,
  `om_total_price` float NOT NULL,
  `om_coupon_code` varchar(100) NOT NULL,
  `om_final_price` float NOT NULL,
  `om_zip` varchar(10) NOT NULL,
  `om_db_id` int(11) NOT NULL,
  `om_payment_status` varchar(50) NOT NULL,
  `om_order_status` int(11) NOT NULL,
  `om_payment_type` varchar(50) NOT NULL,
  `om_cancel_by` enum('','user','admin') NOT NULL,
  `om_cancel_at` datetime NOT NULL,
  `om_added_on` datetime NOT NULL,
  `om_delivered_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`om_id`, `om_u_id`, `om_u_name`, `om_u_email`, `om_u_mobile`, `om_u_address`, `om_total_price`, `om_coupon_code`, `om_final_price`, `om_zip`, `om_db_id`, `om_payment_status`, `om_order_status`, `om_payment_type`, `om_cancel_by`, `om_cancel_at`, `om_added_on`, `om_delivered_on`) VALUES
(1, 1, 'Rahul Panchal', 'rahulnpanchal50@gmail.com', '8879096228', 'Bhayandar', 600, '', 600, '401105', 1, 'success', 4, 'cod', '', '0000-00-00 00:00:00', '2020-08-27 01:33:36', '2020-08-27 01:38:16'),
(2, 1, 'Rahul Naresh Panchal', 'rahulnpanchal50@gmail.com', '8879096228', 'Bhayandar', 660, 'FRIDAY', 594, '401105', 0, 'pending', 5, 'cod', 'admin', '2020-08-27 01:38:47', '2020-08-27 01:35:56', '0000-00-00 00:00:00'),
(3, 1, 'Rahul Naresh Panchal', 'rahulnpanchal50@gmail.com', '8879096228', 'Bhayandar', 775, 'FIRST50', 725, '401105', 0, 'pending', 5, 'cod', 'user', '2020-08-27 01:41:02', '2020-08-27 01:40:22', '0000-00-00 00:00:00'),
(4, 1, 'Rahul Naresh Panchal', 'rahulnpanchal50@gmail.com', '8879096228', 'Bhayandar', 465, '', 465, '401105', 0, 'pending', 2, 'cod', '', '0000-00-00 00:00:00', '2020-08-27 01:43:58', '0000-00-00 00:00:00'),
(5, 1, 'Rahul Naresh Panchal', 'rahulnpanchal50@gmail.com', '8879096228', 'Bhayandar', 535, 'FRIDAY', 481.5, '401105', 0, 'pending', 1, 'cod', '', '0000-00-00 00:00:00', '2020-08-27 02:24:16', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `os_id` int(11) NOT NULL,
  `os_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`os_id`, `os_status`) VALUES
(1, 'Pending'),
(2, 'Cooking'),
(3, 'On The Way'),
(4, 'Delivered'),
(5, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `r_id` int(11) NOT NULL,
  `r_u_id` int(11) NOT NULL,
  `r_dd_id` int(11) NOT NULL,
  `r_rating` int(11) NOT NULL,
  `r_o_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`r_id`, `r_u_id`, `r_dd_id`, `r_rating`, `r_o_id`) VALUES
(1, 1, 2, 3, 1),
(2, 1, 3, 4, 1),
(3, 1, 5, 5, 1),
(4, 1, 7, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `s_id` int(11) NOT NULL,
  `s_cart_min_price` int(11) NOT NULL,
  `s_cart_min_price_msg` text NOT NULL,
  `s_website_close` int(11) NOT NULL,
  `s_website_close_msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`s_id`, `s_cart_min_price`, `s_cart_min_price_msg`, `s_website_close`, `s_website_close_msg`) VALUES
(1, 50, 'Cart Min Price should be Rs.50', 0, 'Website Closed for Today!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_email_verify` int(11) NOT NULL,
  `u_mobile` varchar(20) NOT NULL,
  `u_password` varchar(200) NOT NULL,
  `u_rand_str` varchar(50) NOT NULL,
  `u_status` int(11) NOT NULL,
  `u_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_email_verify`, `u_mobile`, `u_password`, `u_rand_str`, `u_status`, `u_added_on`) VALUES
(1, 'Rahul Naresh Panchal', 'rahulnpanchal50@gmail.com', 1, '8879096228', '$2y$10$6hqGoR9MCPtI0ufZpGT.AebRcYrHCG5hewn4vXmsypBzThn4o9K1C', 'xzfjuynolrmlwpb', 1, '2020-08-27 01:25:48'),
(2, 'Bhavin Panchal', 'techworld887@gmail.com', 0, '7021275658', '$2y$10$pjagz39wpJXdrwyK3uP.oe5EP6xduK9nbfDpeRNEyMzXfuOZ0W9uO', 'mfhleiufqujcytr', 1, '2020-08-27 02:05:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`cu_id`);

--
-- Indexes for table `coupon_code`
--
ALTER TABLE `coupon_code`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  ADD PRIMARY KEY (`db_id`);

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`d_id`);

--
-- Indexes for table `dish_cart`
--
ALTER TABLE `dish_cart`
  ADD PRIMARY KEY (`dc_id`);

--
-- Indexes for table `dish_details`
--
ALTER TABLE `dish_details`
  ADD PRIMARY KEY (`dd_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`od_id`);

--
-- Indexes for table `order_master`
--
ALTER TABLE `order_master`
  ADD PRIMARY KEY (`om_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`os_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `cu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_code`
--
ALTER TABLE `coupon_code`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  MODIFY `db_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dish_cart`
--
ALTER TABLE `dish_cart`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dish_details`
--
ALTER TABLE `dish_details`
  MODIFY `dd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `od_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_master`
--
ALTER TABLE `order_master`
  MODIFY `om_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `os_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
