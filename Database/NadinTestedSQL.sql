-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 15, 2026 at 11:31 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `v`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `userid` int NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`userid`) VALUES
(2);

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
CREATE TABLE IF NOT EXISTS `announcement` (
  `announcement_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `event_id` int DEFAULT NULL,
  `announcement_date` date DEFAULT (curdate()),
  `announcement_time` time DEFAULT (curtime()),
  `is_urgent` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`announcement_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `annual_event_approvals`
--

DROP TABLE IF EXISTS `annual_event_approvals`;
CREATE TABLE IF NOT EXISTS `annual_event_approvals` (
  `approval_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `approver_id` int NOT NULL,
  `approval_status` enum('approved','rejected') NOT NULL,
  `approval_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`approval_id`),
  UNIQUE KEY `unique_approval` (`event_id`,`approver_id`),
  KEY `approver_id` (`approver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `annual_event_approvals`
--

INSERT INTO `annual_event_approvals` (`approval_id`, `event_id`, `approver_id`, `approval_status`, `approval_date`) VALUES
(1, 8, 7, 'approved', '2026-04-09 18:30:54'),
(2, 2, 7, 'approved', '2026-04-09 18:31:19'),
(3, 6, 7, 'approved', '2026-04-09 18:32:46'),
(4, 7, 7, 'rejected', '2026-04-09 18:32:51'),
(5, 2, 6, 'approved', '2026-04-09 18:33:07'),
(6, 6, 6, 'approved', '2026-04-09 18:33:44'),
(7, 14, 6, 'approved', '2026-04-12 12:51:20'),
(8, 14, 7, 'approved', '2026-04-12 12:52:21'),
(9, 15, 7, 'approved', '2026-04-12 13:00:43'),
(10, 22, 7, 'approved', '2026-04-15 21:35:06'),
(11, 22, 6, 'approved', '2026-04-15 21:35:22'),
(12, 23, 6, 'approved', '2026-04-15 21:39:13'),
(13, 23, 7, 'approved', '2026-04-15 21:40:02'),
(14, 24, 7, 'approved', '2026-04-15 22:01:45'),
(15, 24, 6, 'approved', '2026-04-15 22:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_rating`
--

DROP TABLE IF EXISTS `attendance_rating`;
CREATE TABLE IF NOT EXISTS `attendance_rating` (
  `attendance_rating_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `volunteer_id` int NOT NULL,
  `rater_id` int NOT NULL,
  `attendance_score` decimal(5,2) NOT NULL,
  `rating_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`attendance_rating_id`),
  UNIQUE KEY `event_id` (`event_id`,`volunteer_id`,`rater_id`),
  UNIQUE KEY `unique_event_volunteer` (`event_id`,`volunteer_id`),
  KEY `volunteer_id` (`volunteer_id`),
  KEY `rater_id` (`rater_id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance_rating`
--

INSERT INTO `attendance_rating` (`attendance_rating_id`, `event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
(1, 4, 1, 3, 5.00, '2026-04-10 00:45:45'),
(2, 4, 5, 3, 5.00, '2026-04-10 00:45:48'),
(3, 4, 6, 3, 5.00, '2026-04-10 00:45:50'),
(4, 4, 7, 3, 5.00, '2026-04-10 00:45:51'),
(5, 4, 8, 3, 5.00, '2026-04-10 00:45:53'),
(6, 4, 9, 3, 5.00, '2026-04-10 00:45:54'),
(7, 4, 10, 3, 5.00, '2026-04-10 00:45:55'),
(8, 4, 13, 3, 5.00, '2026-04-10 00:45:58'),
(9, 4, 15, 3, 5.00, '2026-04-10 00:46:03'),
(10, 4, 16, 3, 5.00, '2026-04-10 00:46:05'),
(11, 4, 17, 3, 5.00, '2026-04-10 00:46:07'),
(12, 4, 18, 3, 5.00, '2026-04-10 00:46:09'),
(13, 4, 20, 3, 5.00, '2026-04-10 00:46:11'),
(14, 4, 21, 3, 5.00, '2026-04-10 00:46:13'),
(15, 4, 22, 3, 5.00, '2026-04-10 00:46:15'),
(16, 4, 30, 3, 5.00, '2026-04-10 00:46:21'),
(17, 4, 31, 3, 5.00, '2026-04-10 00:46:23'),
(18, 4, 32, 3, 5.00, '2026-04-10 00:46:25'),
(19, 4, 33, 3, 5.00, '2026-04-10 00:46:26'),
(20, 4, 34, 3, 5.00, '2026-04-10 00:46:28'),
(21, 4, 38, 3, 5.00, '2026-04-10 00:46:34'),
(22, 4, 40, 3, 5.00, '2026-04-10 00:46:36'),
(23, 4, 41, 3, 5.00, '2026-04-10 00:46:37'),
(24, 4, 42, 3, 5.00, '2026-04-10 00:46:40'),
(25, 4, 49, 3, 5.00, '2026-04-10 00:46:41'),
(26, 4, 50, 3, 5.00, '2026-04-10 00:46:43'),
(27, 4, 51, 3, 5.00, '2026-04-10 00:46:45'),
(28, 4, 52, 3, 5.00, '2026-04-10 00:46:47'),
(29, 4, 53, 3, 5.00, '2026-04-10 00:46:49'),
(30, 4, 54, 3, 5.00, '2026-04-10 00:46:50'),
(31, 4, 55, 3, 5.00, '2026-04-10 00:46:52'),
(32, 4, 56, 3, 5.00, '2026-04-10 00:46:54'),
(33, 4, 57, 3, 5.00, '2026-04-10 00:46:55'),
(34, 4, 58, 3, 5.00, '2026-04-10 00:46:57'),
(35, 4, 59, 3, 5.00, '2026-04-10 00:47:00'),
(36, 5, 17, 5, 5.00, '2026-04-10 01:28:38'),
(37, 5, 8, 5, 5.00, '2026-04-10 01:28:40'),
(38, 5, 9, 5, 5.00, '2026-04-10 01:28:42'),
(39, 5, 11, 5, 5.00, '2026-04-10 01:28:44'),
(40, 5, 12, 5, 5.00, '2026-04-10 01:28:47'),
(41, 5, 14, 5, 5.00, '2026-04-10 01:28:48'),
(42, 5, 15, 5, 5.00, '2026-04-10 01:28:50'),
(43, 5, 16, 5, 5.00, '2026-04-10 01:28:52'),
(44, 5, 18, 5, 5.00, '2026-04-10 01:28:53'),
(45, 5, 20, 5, 5.00, '2026-04-10 01:28:55'),
(46, 5, 22, 5, 5.00, '2026-04-10 01:28:57'),
(47, 5, 23, 5, 5.00, '2026-04-10 01:29:00'),
(48, 5, 24, 5, 5.00, '2026-04-10 01:29:02'),
(49, 5, 26, 5, 5.00, '2026-04-10 01:29:03'),
(50, 5, 27, 5, 5.00, '2026-04-10 01:29:05'),
(51, 11, 1, 3, 5.00, '2026-04-12 23:39:11'),
(52, 11, 8, 3, 5.00, '2026-04-12 23:39:13'),
(53, 11, 9, 3, 5.00, '2026-04-12 23:39:14'),
(54, 11, 10, 3, 5.00, '2026-04-12 23:39:16'),
(55, 11, 11, 3, 5.00, '2026-04-12 23:39:17'),
(56, 11, 35, 3, 5.00, '2026-04-12 23:39:18'),
(57, 11, 12, 3, 5.00, '2026-04-12 23:39:22'),
(58, 11, 13, 3, 5.00, '2026-04-12 23:39:24'),
(59, 11, 14, 3, 5.00, '2026-04-12 23:39:26'),
(60, 11, 15, 3, 5.00, '2026-04-12 23:39:28'),
(61, 11, 16, 3, 5.00, '2026-04-12 23:39:30'),
(62, 11, 17, 3, 5.00, '2026-04-12 23:39:32'),
(63, 3, 9, 3, 5.00, '2026-04-13 00:31:33'),
(64, 3, 10, 3, 5.00, '2026-04-13 00:31:48'),
(65, 3, 11, 3, 5.00, '2026-04-13 00:31:50'),
(66, 3, 12, 3, 5.00, '2026-04-13 00:31:52'),
(67, 3, 13, 3, 5.00, '2026-04-13 00:31:54'),
(68, 3, 16, 3, 5.00, '2026-04-13 00:31:57'),
(69, 3, 17, 3, 5.00, '2026-04-13 00:31:59'),
(70, 3, 14, 3, 5.00, '2026-04-13 00:33:54'),
(71, 3, 18, 3, 5.00, '2026-04-13 00:33:56'),
(72, 3, 19, 3, 5.00, '2026-04-13 00:33:58'),
(73, 3, 20, 3, 5.00, '2026-04-13 00:33:59'),
(74, 3, 21, 3, 5.00, '2026-04-13 00:34:01'),
(75, 3, 22, 3, 5.00, '2026-04-13 00:34:05'),
(76, 3, 23, 3, 5.00, '2026-04-13 00:34:06'),
(77, 16, 9, 3, 5.00, '2026-04-13 00:59:45'),
(78, 12, 9, 3, 5.00, '2026-04-13 01:18:52'),
(79, 17, 8, 3, 5.00, '2026-04-13 02:01:28'),
(80, 20, 45, 3, 5.00, '2026-04-14 09:14:48'),
(81, 20, 8, 3, 5.00, '2026-04-14 18:56:08'),
(82, 20, 15, 3, 5.00, '2026-04-14 18:57:19'),
(83, 20, 9, 3, 5.00, '2026-04-14 20:34:32');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

DROP TABLE IF EXISTS `donation`;
CREATE TABLE IF NOT EXISTS `donation` (
  `donationid` int NOT NULL AUTO_INCREMENT,
  `receivedamount` decimal(12,2) NOT NULL,
  `sponsorid` int DEFAULT NULL,
  `volunteer_id` int DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`donationid`),
  UNIQUE KEY `order_id` (`order_id`),
  KEY `sponsorid` (`sponsorid`),
  KEY `volunteer_id` (`volunteer_id`),
  KEY `event_id` (`event_id`)
) ;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donationid`, `receivedamount`, `sponsorid`, `volunteer_id`, `order_id`, `transaction_date`, `transaction_id`, `event_id`, `status`) VALUES
(1, 5000.00, 4, NULL, 'DON-1775791240-5525', '2026-04-10 08:50:52', NULL, NULL, 'pending'),
(2, 10000.00, 4, NULL, 'DON-1775990215-4328', '2026-04-12 16:07:01', NULL, NULL, 'pending'),
(3, 10000.00, 4, NULL, 'DON-1775990838-1919', '2026-04-12 16:17:29', NULL, NULL, 'pending'),
(4, 500.00, 4, NULL, 'DON-1775990914-2283', '2026-04-12 16:19:01', NULL, NULL, 'pending'),
(5, 100.00, 4, NULL, 'DON-1775991766-2851', '2026-04-12 16:34:13', NULL, NULL, 'pending'),
(6, 100.00, NULL, 1, 'DON-1776243843-3678', '2026-04-15 14:34:03', NULL, NULL, 'pending'),
(7, 15000.00, NULL, 1, 'DON-1776244731-8619', '2026-04-15 14:48:51', NULL, NULL, 'pending'),
(23, 10000.00, 63, NULL, 'SPONSOR-1776288136-9615', '2026-04-16 02:52:16', '320032592025', 2, 'complete'),
(8, 45000.02, 4, NULL, 'SPONSOR-1776271274-3689', '2026-04-15 22:11:14', NULL, 14, 'pending'),
(9, 49999.99, 4, NULL, 'SPONSOR-1776273027-7310', '2026-04-15 22:40:27', NULL, 14, 'pending'),
(10, 10000.00, 4, NULL, 'SPONSOR-1776273140-1667', '2026-04-15 22:42:20', NULL, 14, 'pending'),
(11, 19999.98, 4, NULL, 'DON-1776273652-2670', '2026-04-15 22:50:52', NULL, NULL, 'pending'),
(12, 11999.98, 4, NULL, 'SPONSOR-1776274101-9869', '2026-04-15 22:58:21', NULL, 2, 'pending'),
(13, 15000.00, 4, NULL, 'DON-1776274363-9952', '2026-04-15 23:02:43', '320032591975', NULL, 'complete'),
(14, 15000.00, 4, NULL, 'SPONSOR-1776274428-2318', '2026-04-15 23:03:48', NULL, 14, 'pending'),
(15, 17555.00, 4, NULL, 'SPONSOR-1776274656-4964', '2026-04-15 23:07:36', NULL, 14, 'pending'),
(16, 19999.00, 4, NULL, 'SPONSOR-1776275672-1390', '2026-04-15 23:24:32', NULL, 14, 'pending'),
(17, 24999.99, 4, NULL, 'SPONSOR-1776276389-5002', '2026-04-15 23:36:29', NULL, 14, 'pending'),
(18, 10000.00, 4, NULL, 'SPONSOR-1776276759-6406', '2026-04-15 23:42:39', NULL, 14, 'pending'),
(19, 11000.00, 4, NULL, 'SPONSOR-1776277052-9267', '2026-04-15 23:47:32', '320032591989', 14, 'complete'),
(20, 10499.99, 4, NULL, 'SPONSOR-1776280948-6605', '2026-04-16 00:52:28', '320032592004', 14, 'complete'),
(21, 10000.00, 4, NULL, 'SPONSOR-1776285853-6526', '2026-04-16 02:14:13', '320032592023', 2, 'complete'),
(24, 75000.00, 60, NULL, 'SPONSOR-1776289867-4763', '2026-04-16 03:21:07', NULL, 23, 'pending'),
(25, 55000.00, 60, NULL, 'SPONSOR-1776289888-4668', '2026-04-16 03:21:28', NULL, 23, 'pending'),
(26, 45000.00, 60, NULL, 'SPONSOR-1776289895-6931', '2026-04-16 03:21:35', '320032592026', 23, 'complete'),
(27, 10000.00, 61, NULL, 'SPONSOR-1776290027-2755', '2026-04-16 03:23:47', '320032592027', 23, 'complete'),
(28, 35000.00, 63, NULL, 'SPONSOR-1776290136-9532', '2026-04-16 03:25:36', '320032592028', 23, 'complete'),
(29, 34000.00, 63, NULL, 'SPONSOR-1776290266-5959', '2026-04-16 03:27:46', '320032592029', 2, 'complete'),
(30, 45000.00, 62, NULL, 'SPONSOR-1776290554-1632', '2026-04-16 03:32:34', '320032592030', 24, 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `donation_usage`
--

DROP TABLE IF EXISTS `donation_usage`;
CREATE TABLE IF NOT EXISTS `donation_usage` (
  `usage_id` int NOT NULL AUTO_INCREMENT,
  `donationid` int DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `manager_id` int NOT NULL,
  `used_amount` decimal(12,2) NOT NULL,
  `usage_date` date DEFAULT (curdate()),
  `purpose` text,
  PRIMARY KEY (`usage_id`),
  KEY `donationid` (`donationid`),
  KEY `event_id` (`event_id`),
  KEY `manager_id` (`manager_id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `event_budget_item`
--

DROP TABLE IF EXISTS `event_budget_item`;
CREATE TABLE IF NOT EXISTS `event_budget_item` (
  `budget_item_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`budget_item_id`),
  KEY `idx_budget_event` (`event_id`)
) ;

--
-- Dumping data for table `event_budget_item`
--

INSERT INTO `event_budget_item` (`budget_item_id`, `event_id`, `item_name`, `item_price`, `created_date`) VALUES
(1, 1, 'Lunch Packet', 12000.00, '2026-04-09 17:03:36'),
(2, 2, 'Lunch Packet', 60000.00, '2026-04-09 17:11:09'),
(3, 2, 'Heavy-Duty Trash Bag', 3000.00, '2026-04-09 17:11:09'),
(4, 2, 'Hand Sanitizer & Wet Wipes', 7500.00, '2026-04-09 17:11:09'),
(5, 2, 'First-Aid Kit', 3000.00, '2026-04-09 17:11:09'),
(6, 3, 'Diving Gear Rentals', 15000.00, '2026-04-09 17:14:06'),
(7, 3, 'Lunch Packet', 6000.00, '2026-04-09 17:14:06'),
(8, 4, 'Shovel and Gear Rentals', 12600.00, '2026-04-09 17:20:45'),
(9, 5, 'Shovels and Gear Rentals', 7500.00, '2026-04-09 23:39:39'),
(10, 5, 'Lunch Packets', 8000.00, '2026-04-09 23:39:39'),
(11, 6, 'Lunch Packet', 40000.00, '2026-04-09 23:43:17'),
(12, 6, 'Large Garbage Bags and Gloves', 15000.00, '2026-04-09 23:43:17'),
(13, 7, 'Lunch Packet', 40000.00, '2026-04-09 23:56:12'),
(14, 7, 'Garbage Bags and Gloves', 15000.00, '2026-04-09 23:56:12'),
(15, 8, 'Lunch Packet', 36000.00, '2026-04-10 00:00:16'),
(16, 8, 'Shovel and Gear Rentals', 11250.00, '2026-04-10 00:00:16'),
(17, 9, 'Gloves and Equipment', 4000.00, '2026-04-10 00:19:50'),
(18, 10, 'Shovels and Gear Rentals', 9000.00, '2026-04-10 01:10:26'),
(19, 10, 'Lunch Packets', 8000.00, '2026-04-10 01:10:26'),
(20, 11, 'Lunch Packet', 4800.00, '2026-04-10 08:21:55'),
(21, 12, 'Lunch Packet', 16000.00, '2026-04-12 15:49:46'),
(22, 13, 'Gloves and Equipment', 8000.00, '2026-04-12 17:41:51'),
(23, 14, 'Lunch Packet', 40000.00, '2026-04-12 18:20:41'),
(24, 14, 'Shovel and Garbage Bags', 40000.00, '2026-04-12 18:20:41'),
(25, 15, 'Shovel and Gear Rentals', 20000.00, '2026-04-12 18:29:55'),
(26, 15, 'Lunch Packet', 40000.00, '2026-04-12 18:29:55'),
(27, 16, 'Diving Gear Rentals', 3000.00, '2026-04-13 00:55:39'),
(28, 17, 'Shovel and Gear Rentals', 300.00, '2026-04-13 01:59:51'),
(29, 18, 'Lunch Packet', 6000.00, '2026-04-13 13:26:02'),
(30, 18, 'Shovel and Gear Rentals', 1400.00, '2026-04-13 13:26:02'),
(31, 19, 'Polythene Bags and Gloves', 1000.00, '2026-04-13 17:30:32'),
(32, 20, 'Shovel and Gear Rentals', 1000.00, '2026-04-14 09:08:52'),
(33, 21, 'Shovels and Gear Rentals', 6000.00, '2026-04-14 12:14:30'),
(34, 21, 'Gloves and Equipment', 4000.00, '2026-04-14 12:14:30'),
(35, 21, 'Lunch Packet', 6000.00, '2026-04-14 12:14:30'),
(36, 22, 'Shovel and Gear Rentals', 13200.00, '2026-04-16 03:04:40'),
(37, 22, 'Lunch Packet', 31600.00, '2026-04-16 03:04:40'),
(38, 23, 'Diving Gear Rentals', 30000.00, '2026-04-16 03:09:00'),
(39, 23, 'Lunch Packet', 12000.00, '2026-04-16 03:09:00'),
(40, 24, 'Shovel and Gear Rentals', 4000.00, '2026-04-16 03:31:21'),
(41, 24, 'Gloves', 3000.00, '2026-04-16 03:31:21');

-- --------------------------------------------------------

--
-- Table structure for table `event_participation`
--

DROP TABLE IF EXISTS `event_participation`;
CREATE TABLE IF NOT EXISTS `event_participation` (
  `event_id` int NOT NULL,
  `volunteer_id` int NOT NULL,
  `participation_status` varchar(20) DEFAULT 'registered',
  `registration_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`event_id`,`volunteer_id`),
  KEY `volunteer_id` (`volunteer_id`)
) ;

--
-- Dumping data for table `event_participation`
--

INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(4, 1, 'completed', '2026-04-10 00:45:45'),
(1, 1, 'registered', '2026-04-09 23:16:23'),
(2, 1, 'registered', '2026-04-09 23:16:28'),
(4, 8, 'completed', '2026-04-10 00:45:53'),
(1, 8, 'registered', '2026-04-09 23:17:10'),
(2, 8, 'registered', '2026-04-09 23:17:14'),
(3, 8, 'registered', '2026-04-09 23:17:17'),
(4, 9, 'completed', '2026-04-10 00:45:54'),
(1, 9, 'registered', '2026-04-09 23:18:51'),
(3, 9, 'completed', '2026-04-13 00:31:33'),
(2, 10, 'registered', '2026-04-09 23:19:12'),
(3, 10, 'completed', '2026-04-13 00:31:48'),
(4, 10, 'completed', '2026-04-10 00:45:55'),
(1, 10, 'registered', '2026-04-09 23:19:21'),
(3, 11, 'completed', '2026-04-13 00:31:50'),
(3, 12, 'completed', '2026-04-13 00:31:52'),
(2, 12, 'registered', '2026-04-09 23:19:55'),
(1, 12, 'registered', '2026-04-09 23:19:58'),
(3, 13, 'completed', '2026-04-13 00:31:54'),
(4, 13, 'completed', '2026-04-10 00:45:58'),
(2, 13, 'registered', '2026-04-09 23:20:38'),
(1, 13, 'registered', '2026-04-09 23:20:41'),
(1, 14, 'registered', '2026-04-09 23:21:08'),
(3, 14, 'completed', '2026-04-13 00:33:54'),
(4, 14, 'registered', '2026-04-09 23:21:19'),
(2, 14, 'registered', '2026-04-09 23:21:22'),
(1, 15, 'registered', '2026-04-09 23:21:57'),
(2, 15, 'registered', '2026-04-09 23:22:03'),
(4, 15, 'completed', '2026-04-10 00:46:03'),
(1, 16, 'registered', '2026-04-09 23:22:24'),
(3, 16, 'completed', '2026-04-13 00:31:57'),
(2, 16, 'registered', '2026-04-09 23:22:30'),
(4, 16, 'completed', '2026-04-10 00:46:05'),
(1, 17, 'registered', '2026-04-09 23:22:53'),
(4, 17, 'completed', '2026-04-10 00:46:07'),
(3, 17, 'completed', '2026-04-13 00:31:59'),
(2, 17, 'registered', '2026-04-09 23:23:03'),
(4, 18, 'completed', '2026-04-10 00:46:09'),
(1, 18, 'registered', '2026-04-09 23:23:21'),
(3, 18, 'completed', '2026-04-13 00:33:56'),
(3, 19, 'completed', '2026-04-13 00:33:58'),
(2, 19, 'registered', '2026-04-09 23:23:58'),
(1, 19, 'registered', '2026-04-09 23:24:03'),
(2, 20, 'registered', '2026-04-09 23:29:27'),
(3, 20, 'completed', '2026-04-13 00:33:59'),
(4, 20, 'completed', '2026-04-10 00:46:11'),
(1, 20, 'registered', '2026-04-09 23:29:42'),
(2, 21, 'registered', '2026-04-09 23:30:09'),
(1, 21, 'registered', '2026-04-09 23:30:13'),
(4, 21, 'completed', '2026-04-10 00:46:13'),
(3, 21, 'completed', '2026-04-13 00:34:01'),
(4, 22, 'completed', '2026-04-10 00:46:15'),
(1, 22, 'registered', '2026-04-09 23:30:41'),
(2, 22, 'registered', '2026-04-09 23:30:46'),
(3, 22, 'completed', '2026-04-13 00:34:05'),
(2, 23, 'registered', '2026-04-09 23:31:05'),
(3, 23, 'completed', '2026-04-13 00:34:06'),
(4, 23, 'registered', '2026-04-09 23:31:12'),
(1, 23, 'registered', '2026-04-09 23:31:16'),
(4, 54, 'completed', '2026-04-10 00:46:50'),
(1, 54, 'registered', '2026-04-09 23:32:30'),
(2, 54, 'registered', '2026-04-09 23:32:33'),
(4, 6, 'completed', '2026-04-10 00:45:50'),
(1, 6, 'registered', '2026-04-09 23:33:55'),
(2, 6, 'registered', '2026-04-09 23:33:59'),
(4, 7, 'completed', '2026-04-10 00:45:51'),
(1, 7, 'registered', '2026-04-09 23:34:13'),
(2, 7, 'registered', '2026-04-09 23:34:16'),
(4, 5, 'completed', '2026-04-10 00:45:48'),
(1, 5, 'cancelled', '2026-04-09 23:35:09'),
(2, 5, 'registered', '2026-04-09 23:35:12'),
(2, 24, 'registered', '2026-04-10 00:13:06'),
(1, 24, 'registered', '2026-04-10 00:13:10'),
(6, 24, 'registered', '2026-04-10 00:13:13'),
(6, 23, 'registered', '2026-04-10 00:13:44'),
(2, 25, 'registered', '2026-04-10 00:14:14'),
(1, 25, 'registered', '2026-04-10 00:14:17'),
(6, 25, 'registered', '2026-04-10 00:14:22'),
(2, 26, 'registered', '2026-04-10 00:14:50'),
(1, 26, 'registered', '2026-04-10 00:14:53'),
(6, 26, 'registered', '2026-04-10 00:14:56'),
(6, 27, 'registered', '2026-04-10 00:15:10'),
(1, 27, 'registered', '2026-04-10 00:15:13'),
(2, 27, 'registered', '2026-04-10 00:15:16'),
(1, 28, 'registered', '2026-04-10 00:15:44'),
(2, 28, 'registered', '2026-04-10 00:15:46'),
(6, 28, 'registered', '2026-04-10 00:15:49'),
(1, 29, 'registered', '2026-04-10 00:16:02'),
(2, 29, 'registered', '2026-04-10 00:16:05'),
(6, 29, 'registered', '2026-04-10 00:16:08'),
(4, 30, 'completed', '2026-04-10 00:46:21'),
(2, 30, 'registered', '2026-04-10 00:23:42'),
(1, 30, 'registered', '2026-04-10 00:23:45'),
(6, 30, 'registered', '2026-04-10 00:23:47'),
(4, 31, 'completed', '2026-04-10 00:46:23'),
(1, 31, 'registered', '2026-04-10 00:24:24'),
(2, 31, 'registered', '2026-04-10 00:24:27'),
(6, 31, 'registered', '2026-04-10 00:24:29'),
(1, 32, 'registered', '2026-04-10 00:24:59'),
(6, 32, 'registered', '2026-04-10 00:25:02'),
(4, 32, 'completed', '2026-04-10 00:46:25'),
(2, 32, 'registered', '2026-04-10 00:25:08'),
(4, 33, 'completed', '2026-04-10 00:46:26'),
(1, 33, 'registered', '2026-04-10 00:25:31'),
(2, 33, 'registered', '2026-04-10 00:25:34'),
(6, 33, 'registered', '2026-04-10 00:25:37'),
(2, 34, 'registered', '2026-04-10 00:25:49'),
(4, 34, 'completed', '2026-04-10 00:46:28'),
(6, 34, 'registered', '2026-04-10 00:25:54'),
(4, 35, 'registered', '2026-04-10 00:26:09'),
(2, 35, 'registered', '2026-04-10 00:26:13'),
(6, 35, 'registered', '2026-04-10 00:26:17'),
(4, 36, 'registered', '2026-04-10 00:26:50'),
(2, 36, 'registered', '2026-04-10 00:26:53'),
(6, 36, 'registered', '2026-04-10 00:26:56'),
(4, 37, 'registered', '2026-04-10 00:27:17'),
(2, 37, 'registered', '2026-04-10 00:27:19'),
(6, 37, 'registered', '2026-04-10 00:27:21'),
(4, 38, 'completed', '2026-04-10 00:46:34'),
(2, 38, 'registered', '2026-04-10 00:27:37'),
(6, 38, 'registered', '2026-04-10 00:27:39'),
(4, 40, 'completed', '2026-04-10 00:46:36'),
(2, 40, 'registered', '2026-04-10 00:27:58'),
(6, 40, 'registered', '2026-04-10 00:28:00'),
(2, 41, 'registered', '2026-04-10 00:28:14'),
(6, 41, 'registered', '2026-04-10 00:28:16'),
(4, 41, 'completed', '2026-04-10 00:46:37'),
(2, 39, 'registered', '2026-04-10 00:28:58'),
(4, 39, 'registered', '2026-04-10 00:29:01'),
(6, 39, 'registered', '2026-04-10 00:29:04'),
(4, 42, 'completed', '2026-04-10 00:46:40'),
(2, 42, 'registered', '2026-04-10 00:29:56'),
(6, 42, 'registered', '2026-04-10 00:29:58'),
(2, 49, 'registered', '2026-04-10 00:30:13'),
(4, 49, 'completed', '2026-04-10 00:46:41'),
(6, 49, 'registered', '2026-04-10 00:30:18'),
(6, 50, 'registered', '2026-04-10 00:30:32'),
(4, 50, 'completed', '2026-04-10 00:46:43'),
(2, 50, 'registered', '2026-04-10 00:30:37'),
(6, 51, 'registered', '2026-04-10 00:30:52'),
(4, 51, 'completed', '2026-04-10 00:46:45'),
(2, 51, 'registered', '2026-04-10 00:30:58'),
(4, 52, 'completed', '2026-04-10 00:46:47'),
(6, 52, 'registered', '2026-04-10 00:31:20'),
(4, 53, 'completed', '2026-04-10 00:46:49'),
(6, 53, 'registered', '2026-04-10 00:32:14'),
(2, 53, 'registered', '2026-04-10 00:32:18'),
(6, 54, 'registered', '2026-04-10 00:34:01'),
(2, 55, 'registered', '2026-04-10 00:34:14'),
(6, 55, 'registered', '2026-04-10 00:34:17'),
(4, 55, 'completed', '2026-04-10 00:46:52'),
(4, 56, 'completed', '2026-04-10 00:46:54'),
(6, 56, 'registered', '2026-04-10 00:34:41'),
(2, 57, 'registered', '2026-04-10 00:34:57'),
(4, 57, 'completed', '2026-04-10 00:46:55'),
(6, 57, 'registered', '2026-04-10 00:35:02'),
(4, 58, 'completed', '2026-04-10 00:46:57'),
(2, 58, 'registered', '2026-04-10 00:35:19'),
(6, 58, 'registered', '2026-04-10 00:35:22'),
(4, 59, 'completed', '2026-04-10 00:47:00'),
(6, 59, 'registered', '2026-04-10 00:35:51'),
(2, 59, 'registered', '2026-04-10 00:35:54'),
(2, 9, 'registered', '2026-04-10 01:00:57'),
(5, 8, 'completed', '2026-04-10 01:28:40'),
(9, 8, 'registered', '2026-04-10 01:14:27'),
(5, 9, 'completed', '2026-04-10 01:28:42'),
(9, 9, 'registered', '2026-04-10 01:15:12'),
(5, 11, 'completed', '2026-04-10 01:28:44'),
(9, 11, 'registered', '2026-04-10 01:15:32'),
(4, 12, 'registered', '2026-04-10 01:15:46'),
(5, 12, 'completed', '2026-04-10 01:28:47'),
(5, 13, 'registered', '2026-04-10 01:16:04'),
(9, 13, 'registered', '2026-04-10 01:16:07'),
(9, 12, 'registered', '2026-04-10 01:16:39'),
(5, 14, 'completed', '2026-04-10 01:28:48'),
(9, 14, 'registered', '2026-04-10 01:17:12'),
(9, 15, 'registered', '2026-04-10 01:17:29'),
(5, 15, 'completed', '2026-04-10 01:28:50'),
(5, 16, 'completed', '2026-04-10 01:28:52'),
(9, 16, 'registered', '2026-04-10 01:17:52'),
(5, 17, 'completed', '2026-04-10 01:28:38'),
(9, 17, 'registered', '2026-04-10 01:18:08'),
(5, 18, 'completed', '2026-04-10 01:28:53'),
(9, 18, 'registered', '2026-04-10 01:18:23'),
(5, 19, 'registered', '2026-04-10 01:18:42'),
(5, 20, 'completed', '2026-04-10 01:28:55'),
(5, 21, 'registered', '2026-04-10 01:19:14'),
(5, 22, 'completed', '2026-04-10 01:28:57'),
(5, 23, 'completed', '2026-04-10 01:29:00'),
(5, 24, 'completed', '2026-04-10 01:29:02'),
(5, 26, 'completed', '2026-04-10 01:29:03'),
(5, 27, 'completed', '2026-04-10 01:29:05'),
(5, 28, 'registered', '2026-04-10 01:21:58'),
(9, 5, 'registered', '2026-04-10 01:38:11'),
(9, 1, 'registered', '2026-04-10 01:38:30'),
(11, 1, 'attended', '2026-04-12 23:39:11'),
(11, 8, 'attended', '2026-04-12 23:39:13'),
(11, 9, 'attended', '2026-04-12 23:39:14'),
(11, 10, 'attended', '2026-04-12 23:39:16'),
(11, 11, 'attended', '2026-04-12 23:39:17'),
(11, 12, 'attended', '2026-04-12 23:39:22'),
(11, 13, 'attended', '2026-04-12 23:39:24'),
(11, 14, 'attended', '2026-04-12 23:39:26'),
(11, 15, 'attended', '2026-04-12 23:39:28'),
(11, 16, 'attended', '2026-04-12 23:39:30'),
(11, 17, 'attended', '2026-04-12 23:39:32'),
(11, 35, 'attended', '2026-04-12 23:39:18'),
(13, 1, 'cancelled', '2026-04-12 18:46:40'),
(16, 1, 'registered', '2026-04-13 00:56:02'),
(16, 8, 'registered', '2026-04-13 00:56:23'),
(16, 9, 'completed', '2026-04-13 00:59:45'),
(12, 9, 'completed', '2026-04-13 01:18:52'),
(12, 8, 'registered', '2026-04-13 01:17:59'),
(17, 8, 'completed', '2026-04-13 02:01:28'),
(17, 9, 'registered', '2026-04-13 02:00:35'),
(17, 10, 'registered', '2026-04-13 02:01:13'),
(18, 8, 'registered', '2026-04-13 13:26:38'),
(18, 9, 'registered', '2026-04-13 13:26:52'),
(18, 10, 'registered', '2026-04-13 13:27:06'),
(18, 11, 'registered', '2026-04-13 13:27:29'),
(18, 12, 'registered', '2026-04-13 13:27:43'),
(18, 13, 'registered', '2026-04-13 13:28:11'),
(18, 14, 'registered', '2026-04-13 13:29:13'),
(18, 15, 'registered', '2026-04-13 13:29:28'),
(18, 18, 'registered', '2026-04-13 13:29:42'),
(18, 20, 'registered', '2026-04-13 13:29:54'),
(18, 16, 'registered', '2026-04-13 13:30:16'),
(18, 17, 'registered', '2026-04-13 13:30:51'),
(14, 5, 'cancelled', '2026-04-13 18:56:54'),
(20, 45, 'attended', '2026-04-14 09:14:48'),
(20, 8, 'attended', '2026-04-14 18:56:08'),
(20, 9, 'attended', '2026-04-14 20:34:32'),
(20, 15, 'attended', '2026-04-14 18:57:19');

-- --------------------------------------------------------

--
-- Table structure for table `highlights`
--

DROP TABLE IF EXISTS `highlights`;
CREATE TABLE IF NOT EXISTS `highlights` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `media_url` varchar(500) NOT NULL,
  `display_order` int DEFAULT '1',
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `highlights`
--

INSERT INTO `highlights` (`id`, `title`, `description`, `media_url`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Coral Restoration Projects', 'Restored damaged coral reefs by transplanting and nurturing coral fragments, helping revive marine ecosystems and underwater biodiversity.', '/V/uploads/highlights/highlight_69d837d2529aa4.15002475.jpg', 1, 'active', '2026-04-09 23:35:46', '2026-04-09 23:35:46'),
(2, 'Mangrove Restoration Projects', 'Rehabilitated coastal mangrove forests to strengthen shorelines and support marine habitats.', '/V/uploads/highlights/highlight_69d8390c9bec60.55180395.jpg', 2, 'active', '2026-04-09 23:36:33', '2026-04-09 23:41:00'),
(3, 'Beach Cleanup Initiatives', 'Organized beach cleanup drives removing tons of plastic and waste, helping protect marine life and restore natural coastal beauty.', '/V/uploads/highlights/highlight_69d8382fab4f64.28386726.jpg', 3, 'active', '2026-04-09 23:37:19', '2026-04-09 23:37:19'),
(4, 'Mountain Cleanup Programs', 'Conducted mountain cleanup activities to clear litter from hiking trails and preserve the natural environment and wildlife habitats.', '/V/uploads/highlights/highlight_69d8385c637294.43395307.jpg', 4, 'active', '2026-04-09 23:38:04', '2026-04-09 23:38:04'),
(5, 'City Cleanup Programs', 'Led urban cleanup campaigns to collect waste, improve city hygiene, and promote cleaner, healthier communities.', '/V/uploads/highlights/highlight_69d8388d896876.53054061.jpg', 5, 'active', '2026-04-09 23:38:53', '2026-04-09 23:38:53'),
(6, 'Tree Planting Drives', 'Planted trees across multiple locations to increase green cover, improve air quality, and support long-term environmental sustainability.', '/V/uploads/highlights/highlight_69d838c9eb7ac1.00035215.jpg', 6, 'active', '2026-04-09 23:39:53', '2026-04-09 23:39:53');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `itemid` int NOT NULL AUTO_INCREMENT,
  `itemtype` varchar(50) NOT NULL,
  `managinguserid` int DEFAULT NULL,
  `description` text,
  `price` decimal(12,2) DEFAULT '0.00',
  `stock_XS` int DEFAULT '0',
  `stock_S` int DEFAULT '0',
  `stock_M` int DEFAULT '0',
  `stock_L` int DEFAULT '0',
  `stock_XL` int DEFAULT '0',
  `stock_XXL` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`itemid`),
  KEY `managinguserid` (`managinguserid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `itemtype`, `managinguserid`, `description`, `price`, `stock_XS`, `stock_S`, `stock_M`, `stock_L`, `stock_XL`, `stock_XXL`, `is_active`, `image_path`) VALUES
(1, 'T-shirt-2026', 3, 'Knady Cleanup Programme', 2000.00, 9, 10, 10, 10, 10, 10, 1, '/V/View/uploads/items/item_1776295297_69e01d818ba8f.jpg'),
(2, 'Hoodie', 3, 'Sri Padha Cleanup Programme', 3000.00, 15, 15, 13, 15, 15, 15, 1, '/V/View/uploads/items/item_1776295325_69e01d9d743d9.jpg'),
(3, 'T-shirt 2025', 3, 'Hikkaduwa Beach Cleanup', 1500.00, 20, 20, 20, 20, 20, 20, 1, '/V/View/uploads/items/item_1776295344_69e01db0b4876.jpg'),
(4, 'Jersey 2026', 3, 'Nuwara Eliya Cleanup Programme', 3500.00, 14, 14, 14, 14, 14, 14, 1, '/V/View/uploads/items/item_1776295358_69e01dbef12ec.jpg'),
(5, 'Hoodie-2025', 3, 'Anuradhapura Cleanup Programme', 2000.00, 25, 25, 25, 25, 25, 25, 1, '/V/View/uploads/items/item_1776295370_69e01dca76291.jpg'),
(6, 'Jersey 2025', 3, 'Labukale Volunteering Programme', 4500.00, 5, 5, 5, 5, 5, 5, 1, '/V/View/uploads/items/item_1776295396_69e01de46d0e5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item_purchase_log`
--

DROP TABLE IF EXISTS `item_purchase_log`;
CREATE TABLE IF NOT EXISTS `item_purchase_log` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(100) DEFAULT NULL,
  `order_id` varchar(100) DEFAULT NULL,
  `volunteer_id` int DEFAULT NULL,
  `sponsorid` int DEFAULT NULL,
  `itemid` int NOT NULL,
  `quantity_taken` int NOT NULL,
  `size` varchar(10) DEFAULT NULL,
  `points_used` int DEFAULT '0',
  `discount` decimal(12,2) DEFAULT '0.00',
  `paid_amount` decimal(12,2) DEFAULT NULL,
  `purchase_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `volunteer_id` (`volunteer_id`),
  KEY `itemid` (`itemid`),
  KEY `sponsorid` (`sponsorid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item_purchase_log`
--

INSERT INTO `item_purchase_log` (`log_id`, `payment_id`, `order_id`, `volunteer_id`, `sponsorid`, `itemid`, `quantity_taken`, `size`, `points_used`, `discount`, `paid_amount`, `purchase_date`) VALUES
(1, '320032592022', 'MERCH-1776285302-5350', 1, NULL, 1, 1, 'XS', 0, 0.00, 2000.00, '2026-04-16 02:05:02'),
(2, '320032592038', 'MERCH-1776295443-1428', 1, NULL, 2, 2, 'M', 0, 0.00, 6000.00, '2026-04-16 04:54:03');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
CREATE TABLE IF NOT EXISTS `manager` (
  `userid` int NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`userid`) VALUES
(3);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `receiver_id` int NOT NULL,
  `type` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `db_object_id` int DEFAULT NULL,
  `db_object_type` varchar(50) DEFAULT NULL,
  `priority` varchar(20) DEFAULT 'normal',
  `is_sent` tinyint(1) DEFAULT '0',
  `is_read` tinyint(1) DEFAULT '0',
  `is_closed` tinyint(1) DEFAULT '0',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `read_date` datetime DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  PRIMARY KEY (`notification_id`),
  KEY `receiver_id` (`receiver_id`)
) ;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `receiver_id`, `type`, `category`, `title`, `message`, `link`, `db_object_id`, `db_object_type`, `priority`, `is_sent`, `is_read`, `is_closed`, `created_date`, `read_date`, `scheduled_date`, `expiry_date`) VALUES
(1, 20, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 5.', '/V/router.php?module=page&action=calendar', 5, 'event', 'normal', 1, 1, 1, '2026-04-10 01:20:12', NULL, '2026-04-10 01:22:12', NULL),
(2, 8, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 9.', '/V/router.php?module=page&action=calendar', 9, 'event', 'normal', 1, 1, 1, '2026-04-10 01:44:22', NULL, '2026-04-10 01:46:22', NULL),
(3, 8, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 9.', '/V/router.php?module=page&action=calendar', 9, 'event', 'normal', 1, 1, 1, '2026-04-10 01:46:51', NULL, '2026-04-10 01:48:51', NULL),
(4, 1, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 13.', '/V/router.php?module=page&action=calendar', 13, 'event', 'normal', 1, 1, 1, '2026-04-12 18:47:29', NULL, '2026-04-12 18:49:29', NULL),
(5, 1, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 13.', '/V/router.php?module=page&action=calendar', 13, 'event', 'normal', 1, 1, 1, '2026-04-12 18:47:55', NULL, '2026-04-12 18:49:55', NULL),
(6, 1, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 13.', '/V/router.php?module=page&action=calendar', 13, 'event', 'normal', 1, 1, 1, '2026-04-12 18:49:28', NULL, '2026-04-12 18:51:28', NULL),
(7, 5, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 14.', '/V/router.php?module=page&action=calendar', 14, 'event', 'normal', 1, 0, 0, '2026-04-13 18:57:06', NULL, '2026-04-13 18:59:06', NULL),
(8, 5, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 14.', '/V/router.php?module=page&action=calendar', 14, 'event', 'normal', 1, 0, 0, '2026-04-13 18:57:47', NULL, '2026-04-13 18:59:47', NULL),
(9, 5, 'event_withdrawal', 'calendar', 'Withdrew from Event', 'You withdrew from event ID: 1.', '/V/router.php?module=page&action=calendar', 1, 'event', 'normal', 1, 0, 0, '2026-04-13 19:01:50', NULL, '2026-04-13 19:03:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `org_representative`
--

DROP TABLE IF EXISTS `org_representative`;
CREATE TABLE IF NOT EXISTS `org_representative` (
  `userid` int NOT NULL,
  `duration` int DEFAULT NULL,
  `appointeddate` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`)
) ;

--
-- Dumping data for table `org_representative`
--

INSERT INTO `org_representative` (`userid`, `duration`, `appointeddate`, `is_active`) VALUES
(6, 12, '2026-04-09', 1),
(7, 12, '2026-04-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `peer_rating`
--

DROP TABLE IF EXISTS `peer_rating`;
CREATE TABLE IF NOT EXISTS `peer_rating` (
  `peer_ratingid` int NOT NULL AUTO_INCREMENT,
  `peer_rating_score` decimal(5,2) NOT NULL,
  `comment` text,
  `rater_id` int NOT NULL,
  `ratee_id` int NOT NULL,
  `event_id` int DEFAULT NULL,
  `time_stamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`peer_ratingid`),
  UNIQUE KEY `rater_id` (`rater_id`,`ratee_id`,`event_id`),
  KEY `ratee_id` (`ratee_id`),
  KEY `event_id` (`event_id`)
) ;

--
-- Dumping data for table `peer_rating`
--

INSERT INTO `peer_rating` (`peer_ratingid`, `peer_rating_score`, `comment`, `rater_id`, `ratee_id`, `event_id`, `time_stamp`) VALUES
(1, 4.00, '', 1, 8, 4, '2026-04-10 02:49:06'),
(2, 2.00, '', 1, 7, 4, '2026-04-10 02:49:07'),
(3, 4.00, '', 1, 5, 4, '2026-04-10 02:49:08'),
(4, 4.00, '', 5, 8, 4, '2026-04-10 02:53:59'),
(5, 5.00, '', 5, 9, 4, '2026-04-10 02:54:00'),
(6, 4.00, '', 5, 10, 4, '2026-04-10 02:54:02'),
(7, 3.00, '', 6, 15, 4, '2026-04-10 02:55:10'),
(8, 3.00, '', 6, 14, 4, '2026-04-10 02:55:11'),
(9, 2.00, '', 6, 13, 4, '2026-04-10 02:55:11'),
(10, 3.00, '', 7, 8, 4, '2026-04-10 02:56:02'),
(11, 2.00, '', 7, 9, 4, '2026-04-10 02:56:03'),
(12, 4.00, '', 7, 5, 4, '2026-04-10 02:56:06'),
(13, 3.00, '', 8, 6, 4, '2026-04-10 02:56:47'),
(14, 5.00, '', 8, 10, 4, '2026-04-10 02:56:48'),
(15, 5.00, '', 8, 9, 4, '2026-04-10 02:56:48'),
(16, 2.00, '', 8, 12, 5, '2026-04-10 02:57:00'),
(17, 3.00, '', 8, 11, 5, '2026-04-10 02:57:00'),
(18, 2.00, '', 8, 9, 5, '2026-04-10 02:57:01'),
(19, 2.00, '', 9, 10, 4, '2026-04-10 02:57:21'),
(20, 5.00, '', 9, 6, 4, '2026-04-10 02:57:23'),
(21, 3.00, '', 9, 13, 4, '2026-04-10 02:57:25'),
(22, 5.00, '', 9, 11, 5, '2026-04-10 02:57:37'),
(23, 3.00, '', 9, 12, 5, '2026-04-10 02:57:38'),
(24, 5.00, '', 9, 13, 5, '2026-04-10 02:57:40'),
(25, 4.00, '', 10, 6, 4, '2026-04-10 02:58:49'),
(26, 5.00, '', 10, 13, 4, '2026-04-10 02:58:51'),
(27, 1.00, '', 10, 14, 4, '2026-04-10 02:58:53'),
(28, 1.00, '', 13, 14, 4, '2026-04-10 02:59:23'),
(29, 4.00, '', 13, 15, 4, '2026-04-10 02:59:25'),
(30, 4.00, '', 13, 1, 4, '2026-04-10 02:59:27'),
(31, 4.00, '', 13, 14, 5, '2026-04-10 02:59:35'),
(32, 5.00, '', 13, 15, 5, '2026-04-10 02:59:37'),
(33, 4.00, '', 13, 16, 5, '2026-04-10 02:59:39'),
(34, 4.00, '', 15, 1, 4, '2026-04-10 02:59:59'),
(35, 5.00, '', 15, 7, 4, '2026-04-10 03:00:01'),
(36, 4.00, '', 15, 5, 4, '2026-04-10 03:00:05'),
(37, 4.00, '', 15, 16, 5, '2026-04-10 03:00:21'),
(38, 5.00, '', 15, 17, 5, '2026-04-10 03:00:24'),
(39, 2.00, '', 15, 18, 5, '2026-04-10 03:00:26'),
(40, 1.00, '', 16, 17, 4, '2026-04-10 03:00:48'),
(41, 2.00, '', 16, 18, 4, '2026-04-10 03:00:50'),
(42, 5.00, '', 16, 20, 4, '2026-04-10 03:00:52'),
(43, 3.00, '', 16, 8, 5, '2026-04-10 03:01:01'),
(44, 1.00, '', 16, 17, 5, '2026-04-10 03:01:02'),
(45, 4.00, '', 16, 18, 5, '2026-04-10 03:01:04'),
(46, 1.00, '', 17, 18, 4, '2026-04-10 03:02:07'),
(47, 3.00, '', 17, 20, 4, '2026-04-10 03:02:09'),
(48, 4.00, '', 17, 21, 4, '2026-04-10 03:02:10'),
(49, 3.00, '', 17, 8, 5, '2026-04-10 03:02:18'),
(50, 1.00, '', 17, 9, 5, '2026-04-10 03:02:20'),
(51, 5.00, '', 17, 18, 5, '2026-04-10 03:02:22'),
(52, 2.00, '', 18, 20, 4, '2026-04-10 03:02:46'),
(53, 5.00, '', 18, 21, 4, '2026-04-10 03:02:47'),
(54, 1.00, '', 18, 22, 4, '2026-04-10 03:02:49'),
(55, 2.00, '', 18, 8, 5, '2026-04-10 03:03:12'),
(56, 2.00, '', 18, 9, 5, '2026-04-10 03:03:13'),
(57, 4.00, '', 18, 11, 5, '2026-04-10 03:03:15'),
(58, 4.00, '', 19, 22, 5, '2026-04-10 03:03:50'),
(59, 2.00, '', 19, 21, 5, '2026-04-10 03:03:50'),
(60, 4.00, '', 19, 20, 5, '2026-04-10 03:03:51'),
(61, 3.00, '', 20, 23, 4, '2026-04-10 03:04:14'),
(62, 2.00, '', 20, 22, 4, '2026-04-10 03:04:15'),
(63, 4.00, '', 20, 21, 4, '2026-04-10 03:04:15'),
(64, 3.00, '', 20, 22, 5, '2026-04-10 03:04:25'),
(65, 2.00, '', 20, 21, 5, '2026-04-10 03:04:26'),
(66, 2.00, '', 20, 23, 5, '2026-04-10 03:04:27'),
(67, 1.00, '', 21, 30, 4, '2026-04-10 03:04:56'),
(68, 1.00, '', 21, 23, 4, '2026-04-10 03:04:57'),
(69, 3.00, '', 21, 22, 4, '2026-04-10 03:04:57'),
(70, 3.00, '', 21, 22, 5, '2026-04-10 03:05:11'),
(71, 3.00, '', 21, 23, 5, '2026-04-10 03:05:13'),
(72, 1.00, '', 21, 24, 5, '2026-04-10 03:05:15'),
(73, 3.00, '', 22, 23, 4, '2026-04-10 03:05:42'),
(74, 5.00, '', 22, 30, 4, '2026-04-10 03:05:43'),
(75, 1.00, '', 22, 31, 4, '2026-04-10 03:05:45'),
(76, 1.00, '', 22, 24, 5, '2026-04-10 03:05:55'),
(77, 1.00, '', 22, 26, 5, '2026-04-10 03:05:56'),
(78, 3.00, '', 22, 23, 5, '2026-04-10 03:05:56'),
(79, 1.00, '', 30, 32, 4, '2026-04-10 03:06:25'),
(80, 4.00, '', 30, 31, 4, '2026-04-10 03:06:26'),
(81, 1.00, '', 30, 33, 4, '2026-04-10 03:06:27'),
(82, 5.00, '', 31, 32, 4, '2026-04-10 03:06:51'),
(83, 1.00, '', 31, 34, 4, '2026-04-10 03:06:52'),
(84, 3.00, '', 31, 33, 4, '2026-04-10 03:06:53'),
(85, 2.00, '', 32, 34, 4, '2026-04-10 03:07:28'),
(86, 3.00, '', 32, 33, 4, '2026-04-10 03:07:29'),
(87, 1.00, '', 32, 35, 4, '2026-04-10 03:07:30'),
(88, 1.00, '', 33, 36, 4, '2026-04-10 03:07:58'),
(89, 5.00, '', 33, 35, 4, '2026-04-10 03:07:58'),
(90, 2.00, '', 33, 34, 4, '2026-04-10 03:07:59'),
(91, 1.00, '', 34, 37, 4, '2026-04-10 03:08:21'),
(92, 2.00, '', 34, 36, 4, '2026-04-10 03:08:22'),
(93, 1.00, '', 34, 35, 4, '2026-04-10 03:08:23'),
(94, 1.00, '', 38, 41, 4, '2026-04-10 03:08:53'),
(95, 3.00, '', 38, 40, 4, '2026-04-10 03:08:53'),
(96, 2.00, '', 38, 39, 4, '2026-04-10 03:08:54'),
(97, 1.00, '', 39, 55, 4, '2026-04-10 03:09:31'),
(98, 3.00, '', 39, 41, 4, '2026-04-10 03:09:32'),
(99, 3.00, '', 39, 40, 4, '2026-04-10 03:09:33'),
(100, 3.00, '', 40, 42, 4, '2026-04-10 03:09:58'),
(101, 1.00, '', 40, 55, 4, '2026-04-10 03:09:59'),
(102, 2.00, '', 40, 41, 4, '2026-04-10 03:09:59'),
(103, 1.00, '', 41, 56, 4, '2026-04-10 03:10:21'),
(104, 3.00, '', 41, 42, 4, '2026-04-10 03:10:22'),
(105, 2.00, '', 41, 55, 4, '2026-04-10 03:10:22'),
(106, 2.00, '', 42, 50, 4, '2026-04-10 03:10:46'),
(107, 4.00, '', 42, 49, 4, '2026-04-10 03:10:46'),
(108, 1.00, '', 42, 56, 4, '2026-04-10 03:10:47'),
(109, 2.00, '', 49, 52, 4, '2026-04-10 03:11:09'),
(110, 3.00, '', 49, 51, 4, '2026-04-10 03:11:09'),
(111, 5.00, '', 49, 50, 4, '2026-04-10 03:11:10'),
(112, 5.00, '', 50, 53, 4, '2026-04-10 03:11:30'),
(113, 5.00, '', 50, 52, 4, '2026-04-10 03:11:33'),
(114, 5.00, '', 50, 51, 4, '2026-04-10 03:11:33'),
(115, 5.00, '', 51, 52, 4, '2026-04-10 03:11:57'),
(116, 4.00, '', 51, 54, 4, '2026-04-10 03:11:57'),
(117, 3.00, '', 51, 53, 4, '2026-04-10 03:11:58'),
(118, 4.00, '', 52, 38, 4, '2026-04-10 03:12:20'),
(119, 5.00, '', 52, 54, 4, '2026-04-10 03:12:20'),
(120, 3.00, '', 52, 53, 4, '2026-04-10 03:12:21'),
(121, 2.00, '', 53, 39, 4, '2026-04-10 03:13:34'),
(122, 5.00, '', 53, 38, 4, '2026-04-10 03:13:34'),
(123, 5.00, '', 53, 54, 4, '2026-04-10 03:13:35'),
(124, 5.00, '', 54, 40, 4, '2026-04-10 03:13:57'),
(125, 5.00, '', 54, 39, 4, '2026-04-10 03:13:58'),
(126, 5.00, '', 54, 38, 4, '2026-04-10 03:13:58'),
(127, 3.00, '', 55, 49, 4, '2026-04-10 03:14:47'),
(128, 2.00, '', 55, 56, 4, '2026-04-10 03:14:47'),
(129, 4.00, '', 55, 42, 4, '2026-04-10 03:14:50'),
(130, 3.00, '', 56, 51, 4, '2026-04-10 03:15:29'),
(131, 5.00, '', 56, 50, 4, '2026-04-10 03:15:29'),
(132, 3.00, '', 56, 49, 4, '2026-04-10 03:15:30'),
(133, 5.00, '', 11, 14, 5, '2026-04-10 03:35:34'),
(134, 1.00, '', 11, 13, 5, '2026-04-10 03:35:34'),
(135, 2.00, '', 11, 12, 5, '2026-04-10 03:35:35'),
(136, 5.00, '', 12, 15, 5, '2026-04-10 03:36:29'),
(137, 5.00, '', 12, 14, 5, '2026-04-10 03:36:30'),
(138, 3.00, '', 12, 13, 5, '2026-04-10 03:36:31'),
(139, 2.00, '', 14, 7, 4, '2026-04-10 03:37:05'),
(140, 4.00, '', 14, 1, 4, '2026-04-10 03:37:05'),
(141, 5.00, '', 14, 15, 4, '2026-04-10 03:37:06'),
(142, 3.00, '', 14, 17, 5, '2026-04-10 03:37:19'),
(143, 4.00, '', 14, 16, 5, '2026-04-10 03:37:20'),
(144, 5.00, '', 14, 15, 5, '2026-04-10 03:37:21'),
(145, 4.00, '', 23, 32, 4, '2026-04-10 03:38:23'),
(146, 5.00, '', 23, 31, 4, '2026-04-10 03:38:23'),
(147, 4.00, '', 23, 30, 4, '2026-04-10 03:38:24'),
(148, 4.00, '', 23, 27, 5, '2026-04-10 03:38:34'),
(149, 2.00, '', 23, 26, 5, '2026-04-10 03:38:35'),
(150, 4.00, '', 23, 24, 5, '2026-04-10 03:38:35'),
(151, 4.00, '', 24, 28, 5, '2026-04-10 03:39:23'),
(152, 3.00, '', 24, 27, 5, '2026-04-10 03:39:24'),
(153, 5.00, '', 24, 26, 5, '2026-04-10 03:39:24'),
(154, 3.00, '', 26, 28, 5, '2026-04-10 03:39:58'),
(155, 2.00, '', 26, 27, 5, '2026-04-10 03:39:58'),
(156, 4.00, '', 26, 19, 5, '2026-04-10 03:39:59'),
(157, 4.00, '', 27, 28, 5, '2026-04-10 03:40:55'),
(158, 1.00, '', 27, 20, 5, '2026-04-10 03:40:55'),
(159, 4.00, '', 27, 19, 5, '2026-04-10 03:40:56'),
(160, 3.00, '', 35, 36, 4, '2026-04-10 08:45:35'),
(161, 4.00, '', 35, 37, 4, '2026-04-12 19:27:01'),
(162, 5.00, '', 35, 16, 4, '2026-04-12 19:27:03'),
(163, 5.00, '', 8, 9, 3, '2026-04-13 00:36:01'),
(164, 5.00, '', 8, 10, 3, '2026-04-13 00:36:03'),
(165, 5.00, '', 8, 11, 3, '2026-04-13 00:36:05'),
(166, 5.00, '', 9, 10, 3, '2026-04-13 00:36:32'),
(167, 5.00, '', 9, 11, 3, '2026-04-13 00:36:34'),
(168, 5.00, '', 9, 12, 3, '2026-04-13 00:36:36'),
(169, 5.00, '', 10, 11, 3, '2026-04-13 00:36:59'),
(170, 5.00, '', 10, 12, 3, '2026-04-13 00:37:01'),
(171, 5.00, '', 10, 16, 3, '2026-04-13 00:37:02'),
(172, 4.00, '', 11, 17, 3, '2026-04-13 00:37:43'),
(173, 5.00, '', 11, 16, 3, '2026-04-13 00:37:44'),
(174, 5.00, '', 11, 12, 3, '2026-04-13 00:37:44'),
(175, 5.00, '', 12, 8, 3, '2026-04-13 00:38:03'),
(176, 3.00, '', 12, 16, 3, '2026-04-13 00:38:07'),
(177, 4.00, '', 12, 17, 3, '2026-04-13 00:38:09'),
(178, 2.00, '', 13, 19, 3, '2026-04-13 00:38:31'),
(179, 1.00, '', 13, 18, 3, '2026-04-13 00:38:32'),
(180, 5.00, '', 13, 14, 3, '2026-04-13 00:38:33'),
(181, 1.00, '', 14, 20, 3, '2026-04-13 00:39:01'),
(182, 3.00, '', 14, 19, 3, '2026-04-13 00:39:02'),
(183, 3.00, '', 14, 18, 3, '2026-04-13 00:39:03'),
(184, 3.00, '', 16, 17, 3, '2026-04-13 00:40:08'),
(185, 1.00, '', 16, 9, 3, '2026-04-13 00:40:09'),
(186, 2.00, '', 16, 8, 3, '2026-04-13 00:40:10'),
(187, 1.00, '', 17, 10, 3, '2026-04-13 00:40:48'),
(188, 2.00, '', 17, 9, 3, '2026-04-13 00:40:48'),
(189, 3.00, '', 17, 8, 3, '2026-04-13 00:40:48'),
(190, 2.00, '', 18, 21, 3, '2026-04-13 00:41:10'),
(191, 4.00, '', 18, 20, 3, '2026-04-13 00:41:10'),
(192, 5.00, '', 18, 19, 3, '2026-04-13 00:41:11'),
(193, 5.00, '', 19, 20, 3, '2026-04-13 00:41:28'),
(194, 4.00, '', 19, 21, 3, '2026-04-13 00:41:30'),
(195, 1.00, '', 19, 22, 3, '2026-04-13 00:41:31'),
(196, 4.00, '', 20, 23, 3, '2026-04-13 00:41:52'),
(197, 2.00, '', 20, 22, 3, '2026-04-13 00:41:53'),
(198, 3.00, '', 20, 21, 3, '2026-04-13 00:41:53'),
(199, 4.00, '', 21, 23, 3, '2026-04-13 00:42:10'),
(200, 4.00, '', 21, 22, 3, '2026-04-13 00:42:10'),
(201, 3.00, '', 21, 13, 3, '2026-04-13 00:42:12'),
(202, 5.00, '', 22, 23, 3, '2026-04-13 00:42:35'),
(203, 1.00, '', 22, 14, 3, '2026-04-13 00:42:35'),
(204, 3.00, '', 22, 13, 3, '2026-04-13 00:42:37'),
(205, 2.00, '', 23, 18, 3, '2026-04-13 00:42:57'),
(206, 5.00, '', 23, 14, 3, '2026-04-13 00:42:57'),
(207, 4.00, '', 23, 13, 3, '2026-04-13 00:42:58'),
(208, 4.00, '', 8, 9, 9, '2026-04-13 16:05:25'),
(209, 5.00, '', 8, 11, 9, '2026-04-13 16:05:27'),
(210, 3.00, '', 8, 12, 9, '2026-04-13 16:05:30'),
(211, 1.00, '', 8, 35, 11, '2026-04-13 17:33:55'),
(212, 3.00, '', 8, 10, 11, '2026-04-13 17:33:56'),
(213, 5.00, '', 8, 9, 11, '2026-04-13 17:33:59'),
(214, 2.00, '', 8, 11, 18, '2026-04-14 11:17:00'),
(215, 4.00, '', 8, 10, 18, '2026-04-14 11:17:01'),
(216, 5.00, '', 8, 9, 18, '2026-04-14 11:17:01'),
(217, 3.00, '', 5, 16, 9, '2026-04-14 12:46:06'),
(218, 5.00, '', 5, 15, 9, '2026-04-14 12:46:07'),
(219, 4.00, '', 5, 14, 9, '2026-04-14 12:46:08'),
(220, 2.00, '', 1, 11, 9, '2026-04-14 21:16:17'),
(221, 5.00, '', 1, 9, 9, '2026-04-14 21:16:17'),
(222, 4.00, '', 1, 8, 9, '2026-04-14 21:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `peer_rating_assignment`
--

DROP TABLE IF EXISTS `peer_rating_assignment`;
CREATE TABLE IF NOT EXISTS `peer_rating_assignment` (
  `assignment_id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `rater_id` int NOT NULL,
  `ratee_id` int NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assignment_id`),
  UNIQUE KEY `event_id` (`event_id`,`rater_id`,`ratee_id`),
  KEY `rater_id` (`rater_id`),
  KEY `ratee_id` (`ratee_id`)
) ;

--
-- Dumping data for table `peer_rating_assignment`
--

INSERT INTO `peer_rating_assignment` (`assignment_id`, `event_id`, `rater_id`, `ratee_id`, `status`, `created_date`) VALUES
(1, 4, 8, 9, 'completed', '2026-04-10 01:43:23'),
(2, 4, 8, 10, 'completed', '2026-04-10 01:43:23'),
(3, 4, 8, 6, 'completed', '2026-04-10 01:43:23'),
(4, 4, 9, 10, 'completed', '2026-04-10 01:43:23'),
(5, 4, 9, 6, 'completed', '2026-04-10 01:43:23'),
(6, 4, 9, 13, 'completed', '2026-04-10 01:43:23'),
(7, 4, 10, 6, 'completed', '2026-04-10 01:43:23'),
(8, 4, 10, 13, 'completed', '2026-04-10 01:43:23'),
(9, 4, 10, 14, 'completed', '2026-04-10 01:43:23'),
(10, 4, 6, 13, 'completed', '2026-04-10 01:43:23'),
(11, 4, 6, 14, 'completed', '2026-04-10 01:43:23'),
(12, 4, 6, 15, 'completed', '2026-04-10 01:43:23'),
(13, 4, 13, 14, 'completed', '2026-04-10 01:43:23'),
(14, 4, 13, 15, 'completed', '2026-04-10 01:43:23'),
(15, 4, 13, 1, 'completed', '2026-04-10 01:43:23'),
(16, 4, 14, 15, 'completed', '2026-04-10 01:43:23'),
(17, 4, 14, 1, 'completed', '2026-04-10 01:43:23'),
(18, 4, 14, 7, 'completed', '2026-04-10 01:43:23'),
(19, 4, 15, 1, 'completed', '2026-04-10 01:43:23'),
(20, 4, 15, 7, 'completed', '2026-04-10 01:43:23'),
(21, 4, 15, 5, 'completed', '2026-04-10 01:43:23'),
(22, 4, 1, 7, 'completed', '2026-04-10 01:43:23'),
(23, 4, 1, 5, 'completed', '2026-04-10 01:43:23'),
(24, 4, 1, 8, 'completed', '2026-04-10 01:43:23'),
(25, 4, 7, 5, 'completed', '2026-04-10 01:43:23'),
(26, 4, 7, 8, 'completed', '2026-04-10 01:43:23'),
(27, 4, 7, 9, 'completed', '2026-04-10 01:43:23'),
(28, 4, 5, 8, 'completed', '2026-04-10 01:43:23'),
(29, 4, 5, 9, 'completed', '2026-04-10 01:43:23'),
(30, 4, 5, 10, 'completed', '2026-04-10 01:43:23'),
(31, 4, 53, 54, 'completed', '2026-04-10 01:43:23'),
(32, 4, 53, 38, 'completed', '2026-04-10 01:43:23'),
(33, 4, 53, 39, 'completed', '2026-04-10 01:43:23'),
(34, 4, 54, 38, 'completed', '2026-04-10 01:43:23'),
(35, 4, 54, 39, 'completed', '2026-04-10 01:43:23'),
(36, 4, 54, 40, 'completed', '2026-04-10 01:43:23'),
(37, 4, 38, 39, 'completed', '2026-04-10 01:43:23'),
(38, 4, 38, 40, 'completed', '2026-04-10 01:43:23'),
(39, 4, 38, 41, 'completed', '2026-04-10 01:43:23'),
(40, 4, 39, 40, 'completed', '2026-04-10 01:43:23'),
(41, 4, 39, 41, 'completed', '2026-04-10 01:43:23'),
(42, 4, 39, 55, 'completed', '2026-04-10 01:43:23'),
(43, 4, 40, 41, 'completed', '2026-04-10 01:43:23'),
(44, 4, 40, 55, 'completed', '2026-04-10 01:43:23'),
(45, 4, 40, 42, 'completed', '2026-04-10 01:43:23'),
(46, 4, 41, 55, 'completed', '2026-04-10 01:43:23'),
(47, 4, 41, 42, 'completed', '2026-04-10 01:43:23'),
(48, 4, 41, 56, 'completed', '2026-04-10 01:43:23'),
(49, 4, 55, 42, 'completed', '2026-04-10 01:43:23'),
(50, 4, 55, 56, 'completed', '2026-04-10 01:43:23'),
(51, 4, 55, 49, 'completed', '2026-04-10 01:43:23'),
(52, 4, 42, 56, 'completed', '2026-04-10 01:43:23'),
(53, 4, 42, 49, 'completed', '2026-04-10 01:43:23'),
(54, 4, 42, 50, 'completed', '2026-04-10 01:43:23'),
(55, 4, 56, 49, 'completed', '2026-04-10 01:43:23'),
(56, 4, 56, 50, 'completed', '2026-04-10 01:43:23'),
(57, 4, 56, 51, 'completed', '2026-04-10 01:43:23'),
(58, 4, 49, 50, 'completed', '2026-04-10 01:43:23'),
(59, 4, 49, 51, 'completed', '2026-04-10 01:43:23'),
(60, 4, 49, 52, 'completed', '2026-04-10 01:43:23'),
(61, 4, 50, 51, 'completed', '2026-04-10 01:43:23'),
(62, 4, 50, 52, 'completed', '2026-04-10 01:43:23'),
(63, 4, 50, 53, 'completed', '2026-04-10 01:43:23'),
(64, 4, 51, 52, 'completed', '2026-04-10 01:43:23'),
(65, 4, 51, 53, 'completed', '2026-04-10 01:43:23'),
(66, 4, 51, 54, 'completed', '2026-04-10 01:43:23'),
(67, 4, 52, 53, 'completed', '2026-04-10 01:43:23'),
(68, 4, 52, 54, 'completed', '2026-04-10 01:43:23'),
(69, 4, 52, 38, 'completed', '2026-04-10 01:43:23'),
(70, 4, 33, 34, 'completed', '2026-04-10 01:43:23'),
(71, 4, 33, 35, 'completed', '2026-04-10 01:43:23'),
(72, 4, 33, 36, 'completed', '2026-04-10 01:43:23'),
(73, 4, 34, 35, 'completed', '2026-04-10 01:43:23'),
(74, 4, 34, 36, 'completed', '2026-04-10 01:43:23'),
(75, 4, 34, 37, 'completed', '2026-04-10 01:43:23'),
(76, 4, 35, 36, 'completed', '2026-04-10 01:43:23'),
(77, 4, 35, 37, 'completed', '2026-04-10 01:43:23'),
(78, 4, 35, 16, 'completed', '2026-04-10 01:43:23'),
(79, 4, 36, 37, 'pending', '2026-04-10 01:43:23'),
(80, 4, 36, 16, 'pending', '2026-04-10 01:43:23'),
(81, 4, 36, 17, 'pending', '2026-04-10 01:43:23'),
(82, 4, 37, 16, 'pending', '2026-04-10 01:43:23'),
(83, 4, 37, 17, 'pending', '2026-04-10 01:43:23'),
(84, 4, 37, 18, 'pending', '2026-04-10 01:43:23'),
(85, 4, 16, 17, 'completed', '2026-04-10 01:43:23'),
(86, 4, 16, 18, 'completed', '2026-04-10 01:43:23'),
(87, 4, 16, 20, 'completed', '2026-04-10 01:43:23'),
(88, 4, 17, 18, 'completed', '2026-04-10 01:43:23'),
(89, 4, 17, 20, 'completed', '2026-04-10 01:43:23'),
(90, 4, 17, 21, 'completed', '2026-04-10 01:43:23'),
(91, 4, 18, 20, 'completed', '2026-04-10 01:43:23'),
(92, 4, 18, 21, 'completed', '2026-04-10 01:43:23'),
(93, 4, 18, 22, 'completed', '2026-04-10 01:43:23'),
(94, 4, 20, 21, 'completed', '2026-04-10 01:43:23'),
(95, 4, 20, 22, 'completed', '2026-04-10 01:43:23'),
(96, 4, 20, 23, 'completed', '2026-04-10 01:43:23'),
(97, 4, 21, 22, 'completed', '2026-04-10 01:43:23'),
(98, 4, 21, 23, 'completed', '2026-04-10 01:43:23'),
(99, 4, 21, 30, 'completed', '2026-04-10 01:43:23'),
(100, 4, 22, 23, 'completed', '2026-04-10 01:43:23'),
(101, 4, 22, 30, 'completed', '2026-04-10 01:43:23'),
(102, 4, 22, 31, 'completed', '2026-04-10 01:43:23'),
(103, 4, 23, 30, 'completed', '2026-04-10 01:43:23'),
(104, 4, 23, 31, 'completed', '2026-04-10 01:43:23'),
(105, 4, 23, 32, 'completed', '2026-04-10 01:43:23'),
(106, 4, 30, 31, 'completed', '2026-04-10 01:43:23'),
(107, 4, 30, 32, 'completed', '2026-04-10 01:43:23'),
(108, 4, 30, 33, 'completed', '2026-04-10 01:43:23'),
(109, 4, 31, 32, 'completed', '2026-04-10 01:43:23'),
(110, 4, 31, 33, 'completed', '2026-04-10 01:43:23'),
(111, 4, 31, 34, 'completed', '2026-04-10 01:43:23'),
(112, 4, 32, 33, 'completed', '2026-04-10 01:43:23'),
(113, 4, 32, 34, 'completed', '2026-04-10 01:43:23'),
(114, 4, 32, 35, 'completed', '2026-04-10 01:43:23'),
(115, 5, 8, 9, 'completed', '2026-04-10 01:43:23'),
(116, 5, 8, 11, 'completed', '2026-04-10 01:43:23'),
(117, 5, 8, 12, 'completed', '2026-04-10 01:43:23'),
(118, 5, 9, 11, 'completed', '2026-04-10 01:43:23'),
(119, 5, 9, 12, 'completed', '2026-04-10 01:43:23'),
(120, 5, 9, 13, 'completed', '2026-04-10 01:43:23'),
(121, 5, 11, 12, 'completed', '2026-04-10 01:43:23'),
(122, 5, 11, 13, 'completed', '2026-04-10 01:43:23'),
(123, 5, 11, 14, 'completed', '2026-04-10 01:43:23'),
(124, 5, 12, 13, 'completed', '2026-04-10 01:43:23'),
(125, 5, 12, 14, 'completed', '2026-04-10 01:43:23'),
(126, 5, 12, 15, 'completed', '2026-04-10 01:43:23'),
(127, 5, 13, 14, 'completed', '2026-04-10 01:43:23'),
(128, 5, 13, 15, 'completed', '2026-04-10 01:43:23'),
(129, 5, 13, 16, 'completed', '2026-04-10 01:43:23'),
(130, 5, 14, 15, 'completed', '2026-04-10 01:43:23'),
(131, 5, 14, 16, 'completed', '2026-04-10 01:43:23'),
(132, 5, 14, 17, 'completed', '2026-04-10 01:43:23'),
(133, 5, 15, 16, 'completed', '2026-04-10 01:43:23'),
(134, 5, 15, 17, 'completed', '2026-04-10 01:43:23'),
(135, 5, 15, 18, 'completed', '2026-04-10 01:43:23'),
(136, 5, 16, 17, 'completed', '2026-04-10 01:43:23'),
(137, 5, 16, 18, 'completed', '2026-04-10 01:43:23'),
(138, 5, 16, 8, 'completed', '2026-04-10 01:43:23'),
(139, 5, 17, 18, 'completed', '2026-04-10 01:43:23'),
(140, 5, 17, 8, 'completed', '2026-04-10 01:43:23'),
(141, 5, 17, 9, 'completed', '2026-04-10 01:43:23'),
(142, 5, 18, 8, 'completed', '2026-04-10 01:43:23'),
(143, 5, 18, 9, 'completed', '2026-04-10 01:43:23'),
(144, 5, 18, 11, 'completed', '2026-04-10 01:43:23'),
(145, 5, 19, 20, 'completed', '2026-04-10 01:43:23'),
(146, 5, 19, 21, 'completed', '2026-04-10 01:43:23'),
(147, 5, 19, 22, 'completed', '2026-04-10 01:43:23'),
(148, 5, 20, 21, 'completed', '2026-04-10 01:43:23'),
(149, 5, 20, 22, 'completed', '2026-04-10 01:43:23'),
(150, 5, 20, 23, 'completed', '2026-04-10 01:43:23'),
(151, 5, 21, 22, 'completed', '2026-04-10 01:43:23'),
(152, 5, 21, 23, 'completed', '2026-04-10 01:43:23'),
(153, 5, 21, 24, 'completed', '2026-04-10 01:43:23'),
(154, 5, 22, 23, 'completed', '2026-04-10 01:43:23'),
(155, 5, 22, 24, 'completed', '2026-04-10 01:43:23'),
(156, 5, 22, 26, 'completed', '2026-04-10 01:43:23'),
(157, 5, 23, 24, 'completed', '2026-04-10 01:43:23'),
(158, 5, 23, 26, 'completed', '2026-04-10 01:43:23'),
(159, 5, 23, 27, 'completed', '2026-04-10 01:43:23'),
(160, 5, 24, 26, 'completed', '2026-04-10 01:43:23'),
(161, 5, 24, 27, 'completed', '2026-04-10 01:43:23'),
(162, 5, 24, 28, 'completed', '2026-04-10 01:43:23'),
(163, 5, 26, 27, 'completed', '2026-04-10 01:43:23'),
(164, 5, 26, 28, 'completed', '2026-04-10 01:43:23'),
(165, 5, 26, 19, 'completed', '2026-04-10 01:43:23'),
(166, 5, 27, 28, 'completed', '2026-04-10 01:43:23'),
(167, 5, 27, 19, 'completed', '2026-04-10 01:43:23'),
(168, 5, 27, 20, 'completed', '2026-04-10 01:43:23'),
(169, 5, 28, 19, 'pending', '2026-04-10 01:43:23'),
(170, 5, 28, 20, 'pending', '2026-04-10 01:43:23'),
(171, 5, 28, 21, 'pending', '2026-04-10 01:43:23'),
(172, 9, 8, 9, 'completed', '2026-04-12 17:17:53'),
(173, 9, 8, 11, 'completed', '2026-04-12 17:17:53'),
(174, 9, 8, 12, 'completed', '2026-04-12 17:17:53'),
(175, 9, 9, 11, 'pending', '2026-04-12 17:17:53'),
(176, 9, 9, 12, 'pending', '2026-04-12 17:17:53'),
(177, 9, 9, 13, 'pending', '2026-04-12 17:17:53'),
(178, 9, 11, 12, 'pending', '2026-04-12 17:17:53'),
(179, 9, 11, 13, 'pending', '2026-04-12 17:17:53'),
(180, 9, 11, 1, 'pending', '2026-04-12 17:17:53'),
(181, 9, 12, 13, 'pending', '2026-04-12 17:17:53'),
(182, 9, 12, 1, 'pending', '2026-04-12 17:17:53'),
(183, 9, 12, 8, 'pending', '2026-04-12 17:17:53'),
(184, 9, 13, 1, 'pending', '2026-04-12 17:17:53'),
(185, 9, 13, 8, 'pending', '2026-04-12 17:17:53'),
(186, 9, 13, 9, 'pending', '2026-04-12 17:17:53'),
(187, 9, 1, 8, 'completed', '2026-04-12 17:17:53'),
(188, 9, 1, 9, 'completed', '2026-04-12 17:17:53'),
(189, 9, 1, 11, 'completed', '2026-04-12 17:17:53'),
(190, 9, 14, 15, 'pending', '2026-04-12 17:17:53'),
(191, 9, 14, 16, 'pending', '2026-04-12 17:17:53'),
(192, 9, 14, 17, 'pending', '2026-04-12 17:17:53'),
(193, 9, 15, 16, 'pending', '2026-04-12 17:17:53'),
(194, 9, 15, 17, 'pending', '2026-04-12 17:17:53'),
(195, 9, 15, 18, 'pending', '2026-04-12 17:17:53'),
(196, 9, 16, 17, 'pending', '2026-04-12 17:17:53'),
(197, 9, 16, 18, 'pending', '2026-04-12 17:17:53'),
(198, 9, 16, 5, 'pending', '2026-04-12 17:17:53'),
(199, 9, 17, 18, 'pending', '2026-04-12 17:17:53'),
(200, 9, 17, 5, 'pending', '2026-04-12 17:17:53'),
(201, 9, 17, 14, 'pending', '2026-04-12 17:17:53'),
(202, 9, 18, 5, 'pending', '2026-04-12 17:17:53'),
(203, 9, 18, 14, 'pending', '2026-04-12 17:17:53'),
(204, 9, 18, 15, 'pending', '2026-04-12 17:17:53'),
(205, 9, 5, 14, 'completed', '2026-04-12 17:17:53'),
(206, 9, 5, 15, 'completed', '2026-04-12 17:17:53'),
(207, 9, 5, 16, 'completed', '2026-04-12 17:17:53'),
(208, 11, 8, 9, 'completed', '2026-04-12 23:40:46'),
(209, 11, 8, 10, 'completed', '2026-04-12 23:40:46'),
(210, 11, 8, 35, 'completed', '2026-04-12 23:40:46'),
(211, 11, 9, 10, 'pending', '2026-04-12 23:40:46'),
(212, 11, 9, 35, 'pending', '2026-04-12 23:40:46'),
(213, 11, 9, 11, 'pending', '2026-04-12 23:40:46'),
(214, 11, 10, 35, 'pending', '2026-04-12 23:40:46'),
(215, 11, 10, 11, 'pending', '2026-04-12 23:40:46'),
(216, 11, 10, 1, 'pending', '2026-04-12 23:40:46'),
(217, 11, 35, 11, 'pending', '2026-04-12 23:40:46'),
(218, 11, 35, 1, 'pending', '2026-04-12 23:40:46'),
(219, 11, 35, 8, 'pending', '2026-04-12 23:40:46'),
(220, 11, 11, 1, 'pending', '2026-04-12 23:40:46'),
(221, 11, 11, 8, 'pending', '2026-04-12 23:40:46'),
(222, 11, 11, 9, 'pending', '2026-04-12 23:40:46'),
(223, 11, 1, 8, 'pending', '2026-04-12 23:40:46'),
(224, 11, 1, 9, 'pending', '2026-04-12 23:40:46'),
(225, 11, 1, 10, 'pending', '2026-04-12 23:40:46'),
(226, 11, 12, 13, 'pending', '2026-04-12 23:40:46'),
(227, 11, 12, 14, 'pending', '2026-04-12 23:40:46'),
(228, 11, 12, 15, 'pending', '2026-04-12 23:40:46'),
(229, 11, 13, 14, 'pending', '2026-04-12 23:40:46'),
(230, 11, 13, 15, 'pending', '2026-04-12 23:40:46'),
(231, 11, 13, 16, 'pending', '2026-04-12 23:40:46'),
(232, 11, 14, 15, 'pending', '2026-04-12 23:40:46'),
(233, 11, 14, 16, 'pending', '2026-04-12 23:40:46'),
(234, 11, 14, 17, 'pending', '2026-04-12 23:40:46'),
(235, 11, 15, 16, 'pending', '2026-04-12 23:40:46'),
(236, 11, 15, 17, 'pending', '2026-04-12 23:40:46'),
(237, 11, 15, 12, 'pending', '2026-04-12 23:40:46'),
(238, 11, 16, 17, 'pending', '2026-04-12 23:40:46'),
(239, 11, 16, 12, 'pending', '2026-04-12 23:40:46'),
(240, 11, 16, 13, 'pending', '2026-04-12 23:40:46'),
(241, 11, 17, 12, 'pending', '2026-04-12 23:40:46'),
(242, 11, 17, 13, 'pending', '2026-04-12 23:40:46'),
(243, 11, 17, 14, 'pending', '2026-04-12 23:40:46'),
(244, 3, 8, 9, 'completed', '2026-04-13 00:10:22'),
(245, 3, 8, 10, 'completed', '2026-04-13 00:10:22'),
(246, 3, 8, 11, 'completed', '2026-04-13 00:10:22'),
(247, 3, 9, 10, 'completed', '2026-04-13 00:10:22'),
(248, 3, 9, 11, 'completed', '2026-04-13 00:10:22'),
(249, 3, 9, 12, 'completed', '2026-04-13 00:10:22'),
(250, 3, 10, 11, 'completed', '2026-04-13 00:10:22'),
(251, 3, 10, 12, 'completed', '2026-04-13 00:10:22'),
(252, 3, 10, 16, 'completed', '2026-04-13 00:10:22'),
(253, 3, 11, 12, 'completed', '2026-04-13 00:10:22'),
(254, 3, 11, 16, 'completed', '2026-04-13 00:10:22'),
(255, 3, 11, 17, 'completed', '2026-04-13 00:10:22'),
(256, 3, 12, 16, 'completed', '2026-04-13 00:10:22'),
(257, 3, 12, 17, 'completed', '2026-04-13 00:10:22'),
(258, 3, 12, 8, 'completed', '2026-04-13 00:10:22'),
(259, 3, 16, 17, 'completed', '2026-04-13 00:10:22'),
(260, 3, 16, 8, 'completed', '2026-04-13 00:10:22'),
(261, 3, 16, 9, 'completed', '2026-04-13 00:10:22'),
(262, 3, 17, 8, 'completed', '2026-04-13 00:10:22'),
(263, 3, 17, 9, 'completed', '2026-04-13 00:10:22'),
(264, 3, 17, 10, 'completed', '2026-04-13 00:10:22'),
(265, 3, 13, 14, 'completed', '2026-04-13 00:10:22'),
(266, 3, 13, 18, 'completed', '2026-04-13 00:10:22'),
(267, 3, 13, 19, 'completed', '2026-04-13 00:10:22'),
(268, 3, 14, 18, 'completed', '2026-04-13 00:10:22'),
(269, 3, 14, 19, 'completed', '2026-04-13 00:10:22'),
(270, 3, 14, 20, 'completed', '2026-04-13 00:10:22'),
(271, 3, 18, 19, 'completed', '2026-04-13 00:10:22'),
(272, 3, 18, 20, 'completed', '2026-04-13 00:10:22'),
(273, 3, 18, 21, 'completed', '2026-04-13 00:10:22'),
(274, 3, 19, 20, 'completed', '2026-04-13 00:10:22'),
(275, 3, 19, 21, 'completed', '2026-04-13 00:10:22'),
(276, 3, 19, 22, 'completed', '2026-04-13 00:10:22'),
(277, 3, 20, 21, 'completed', '2026-04-13 00:10:22'),
(278, 3, 20, 22, 'completed', '2026-04-13 00:10:22'),
(279, 3, 20, 23, 'completed', '2026-04-13 00:10:22'),
(280, 3, 21, 22, 'completed', '2026-04-13 00:10:22'),
(281, 3, 21, 23, 'completed', '2026-04-13 00:10:22'),
(282, 3, 21, 13, 'completed', '2026-04-13 00:10:22'),
(283, 3, 22, 23, 'completed', '2026-04-13 00:10:22'),
(284, 3, 22, 13, 'completed', '2026-04-13 00:10:22'),
(285, 3, 22, 14, 'completed', '2026-04-13 00:10:22'),
(286, 3, 23, 13, 'completed', '2026-04-13 00:10:22'),
(287, 3, 23, 14, 'completed', '2026-04-13 00:10:22'),
(288, 3, 23, 18, 'completed', '2026-04-13 00:10:22'),
(289, 18, 8, 9, 'completed', '2026-04-14 00:19:47'),
(290, 18, 8, 10, 'completed', '2026-04-14 00:19:47'),
(291, 18, 8, 11, 'completed', '2026-04-14 00:19:47'),
(292, 18, 9, 10, 'pending', '2026-04-14 00:19:47'),
(293, 18, 9, 11, 'pending', '2026-04-14 00:19:47'),
(294, 18, 9, 12, 'pending', '2026-04-14 00:19:47'),
(295, 18, 10, 11, 'pending', '2026-04-14 00:19:47'),
(296, 18, 10, 12, 'pending', '2026-04-14 00:19:47'),
(297, 18, 10, 13, 'pending', '2026-04-14 00:19:47'),
(298, 18, 11, 12, 'pending', '2026-04-14 00:19:47'),
(299, 18, 11, 13, 'pending', '2026-04-14 00:19:47'),
(300, 18, 11, 14, 'pending', '2026-04-14 00:19:47'),
(301, 18, 12, 13, 'pending', '2026-04-14 00:19:47'),
(302, 18, 12, 14, 'pending', '2026-04-14 00:19:47'),
(303, 18, 12, 15, 'pending', '2026-04-14 00:19:47'),
(304, 18, 13, 14, 'pending', '2026-04-14 00:19:47'),
(305, 18, 13, 15, 'pending', '2026-04-14 00:19:47'),
(306, 18, 13, 16, 'pending', '2026-04-14 00:19:47'),
(307, 18, 14, 15, 'pending', '2026-04-14 00:19:47'),
(308, 18, 14, 16, 'pending', '2026-04-14 00:19:47'),
(309, 18, 14, 17, 'pending', '2026-04-14 00:19:47'),
(310, 18, 15, 16, 'pending', '2026-04-14 00:19:47'),
(311, 18, 15, 17, 'pending', '2026-04-14 00:19:47'),
(312, 18, 15, 18, 'pending', '2026-04-14 00:19:47'),
(313, 18, 16, 17, 'pending', '2026-04-14 00:19:47'),
(314, 18, 16, 18, 'pending', '2026-04-14 00:19:47'),
(315, 18, 16, 20, 'pending', '2026-04-14 00:19:47'),
(316, 18, 17, 18, 'pending', '2026-04-14 00:19:47'),
(317, 18, 17, 20, 'pending', '2026-04-14 00:19:47'),
(318, 18, 17, 8, 'pending', '2026-04-14 00:19:47'),
(319, 18, 18, 20, 'pending', '2026-04-14 00:19:47'),
(320, 18, 18, 8, 'pending', '2026-04-14 00:19:47'),
(321, 18, 18, 9, 'pending', '2026-04-14 00:19:47'),
(322, 18, 20, 8, 'pending', '2026-04-14 00:19:47'),
(323, 18, 20, 9, 'pending', '2026-04-14 00:19:47'),
(324, 18, 20, 10, 'pending', '2026-04-14 00:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `representative`
--

DROP TABLE IF EXISTS `representative`;
CREATE TABLE IF NOT EXISTS `representative` (
  `userid` int NOT NULL,
  `duration` int DEFAULT NULL,
  `appointeddate` date DEFAULT NULL,
  `isorgrep` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`)
) ;

--
-- Dumping data for table `representative`
--

INSERT INTO `representative` (`userid`, `duration`, `appointeddate`, `isorgrep`, `is_active`) VALUES
(6, 12, '2026-04-09', 1, 1),
(7, 12, '2026-04-09', 1, 1),
(5, 12, '2026-04-09', 0, 1),
(54, 12, '2026-04-09', 0, 1),
(55, 12, '2026-04-09', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

DROP TABLE IF EXISTS `request`;
CREATE TABLE IF NOT EXISTS `request` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT (curdate()),
  `description` text NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `requester_volunteer_id` int DEFAULT NULL,
  `handler_representative_id` int DEFAULT NULL,
  `approver_manager_id` int DEFAULT NULL,
  `type` varchar(50) DEFAULT '0',
  `linkedin` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`request_id`),
  KEY `requester_volunteer_id` (`requester_volunteer_id`),
  KEY `handler_representative_id` (`handler_representative_id`),
  KEY `approver_manager_id` (`approver_manager_id`)
) ;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `date`, `description`, `status`, `requester_volunteer_id`, `handler_representative_id`, `approver_manager_id`, `type`, `linkedin`) VALUES
(1, '2026-04-09', 'I also want to take more responsibility, help things run smoothly, and make a real impact while growing as a leader.', 'approved', 6, NULL, 3, 'applytoberep', 'https://www.linkedin.com/in/chamith-nimsara?utm_source=share_via&utm_content=profile&utm_medium=memb'),
(2, '2026-04-09', 'I want to become a representative to contribute more actively by supporting volunteers, improving event coordination, and ensuring a positive community experience.', 'approved', 7, NULL, 3, 'applytoberep', 'https://www.linkedin.com/in/sachindra-senevirathne?utm_source=share_via&utm_content=profile&utm_medi'),
(3, '2026-04-09', 'I want to develop leadership, communication, and teamwork skills through active involvement with these volunteering programs.', 'approved', 5, NULL, 3, 'applytoberep', 'https://https//www.linkedin.com/in/thivinya-abeyrathna?utm_source=share_via&utm_content=profile'),
(4, '2026-04-09', 'I want to contribute to a positive change and improve the volunteering system.', 'rejected', 53, NULL, 3, 'applytoberep', 'https://https//www.linkedin.com/in/andrew-desilva?utm_source=share_via&utm_content=profile'),
(5, '2026-04-09', 'I want to gain experience in organizing and coordinating volunteer activities.', 'approved', 54, NULL, 3, 'applytoberep', 'https://https//www.linkedin.com/in/carlos-mendis?utm_source=share_via&utm_content=profile'),
(6, '2026-04-09', 'I want to build stronger connections between volunteers and organizers and help better organize the volunteering platform', 'rejected', 59, NULL, 3, 'applytoberep', 'https://https//www.linkedin.com/in/sumudu-amarasinghe?utm_source=share_via&utm_content=profile'),
(7, '2026-04-09', 'I want to take on more responsibility and grow both personally and professionally.', 'approved', 55, NULL, 3, 'applytoberep', 'https://https//www.linkedin.com/in/kevin-gunasekara?utm_source=share_via&utm_content=profile');

-- --------------------------------------------------------

--
-- Table structure for table `route_permissions`
--

DROP TABLE IF EXISTS `route_permissions`;
CREATE TABLE IF NOT EXISTS `route_permissions` (
  `permission_id` int NOT NULL AUTO_INCREMENT,
  `module` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `allowed_roles` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `module` (`module`,`action`)
) ENGINE=MyISAM AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `route_permissions`
--

INSERT INTO `route_permissions` (`permission_id`, `module`, `action`, `allowed_roles`, `description`, `created_at`) VALUES
(1, 'page', 'homepage', 'public', NULL, '2026-04-09 08:40:40'),
(2, 'page', 'calendar', 'public', NULL, '2026-04-09 08:40:40'),
(3, 'page', 'aboutus', 'public', NULL, '2026-04-09 08:40:40'),
(4, 'page', 'vmap', 'public', NULL, '2026-04-09 08:40:40'),
(5, 'calendar', 'getevents', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(6, 'calendar', 'geteventdetails', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(7, 'calendar', 'leaveevent', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(8, 'calendar', 'filterevents', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(9, 'attendance', 'mark', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(10, 'user', 'login', 'public', NULL, '2026-04-09 08:40:40'),
(11, 'user', 'logout', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(12, 'user', 'profile', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(13, 'user', 'profileEdit', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(14, 'user', 'profileUpdate', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(15, 'user', 'forgotpw', 'public', NULL, '2026-04-09 08:40:40'),
(16, 'user', 'resetpw', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(17, 'user', 'updatepassword', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(18, 'user', 'deleteaccount', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(19, 'contact', 'send', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(20, 'feedback', 'sendemail', 'volunteer,manager,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(21, 'pwreset', 'show', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(22, 'pwreset', 'sendcode', 'public', NULL, '2026-04-09 08:40:40'),
(23, 'pwreset', 'verifycode', 'public', NULL, '2026-04-09 08:40:40'),
(24, 'pwreset', 'updatepassword', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(25, 'pwreset', 'showchange', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(26, 'registration', 'register', 'public', NULL, '2026-04-09 08:40:40'),
(27, 'registration', 'registration_role', 'public', NULL, '2026-04-09 08:40:40'),
(28, 'registration', 'registration_step1', 'public', NULL, '2026-04-09 08:40:40'),
(29, 'registration', 'registration_step2', 'public', NULL, '2026-04-09 08:40:40'),
(30, 'registration', 'registration_step3', 'public', NULL, '2026-04-09 08:40:40'),
(31, 'registration', 'registration_step4', 'public', NULL, '2026-04-09 08:40:40'),
(32, 'registration', 'registration_complete', 'public', NULL, '2026-04-09 08:40:40'),
(33, 'registration', 'registration_success', 'public', NULL, '2026-04-09 08:40:40'),
(34, 'projects', 'projects', 'public', NULL, '2026-04-09 08:40:40'),
(35, 'projects', 'projectapprovals', 'manager', NULL, '2026-04-09 08:40:40'),
(36, 'projects', 'approveEvent', 'manager', NULL, '2026-04-09 08:40:40'),
(37, 'projects', 'rejectEvent', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(38, 'projects', 'createevent', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(39, 'projects', 'events', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(40, 'projects', 'deleteevent', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(41, 'projects', 'updateevent', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(42, 'projects', 'createeventsuccess', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(43, 'projects', 'joinevent', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(44, 'projects', 'withdrawevent', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(45, 'activity', 'activity', 'volunteer,manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(46, 'activity', 'openpeer', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(47, 'task', 'managetasks', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(48, 'task', 'createtask', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(49, 'task', 'edittask', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(50, 'task', 'deletetask', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(51, 'task', 'assignvolunteer', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(52, 'task', 'removevolunteer', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(53, 'task', 'assignmultiplevolunteers', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(54, 'inventory', 'inventorymanagement', 'manager', NULL, '2026-04-09 08:40:40'),
(55, 'inventory', 'createitem', 'manager', NULL, '2026-04-09 08:40:40'),
(56, 'inventory', 'updateitem', 'manager', NULL, '2026-04-09 08:40:40'),
(57, 'inventory', 'deleteitem', 'manager', NULL, '2026-04-09 08:40:40'),
(58, 'volunteer', 'berepresentative', 'volunteer', NULL, '2026-04-09 08:40:40'),
(59, 'volunteer', 'submitApplication', 'volunteer', NULL, '2026-04-09 08:40:40'),
(60, 'volunteer', 'updateApplication', 'volunteer', NULL, '2026-04-09 08:40:40'),
(61, 'volunteer', 'deleteApplication', 'volunteer', NULL, '2026-04-09 08:40:40'),
(62, 'volunteer', 'submittedapplication', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(63, 'representative', 'repapproveeventbudgets', 'representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(64, 'sponsor', 'requesttosponsor', 'sponsor', NULL, '2026-04-09 08:40:40'),
(65, 'sponsor', 'sponsorshipactivity', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(66, 'manager', 'managerapproveeventbudgets', 'manager', NULL, '2026-04-09 08:40:40'),
(67, 'manager', 'requestsponsorships', 'manager', NULL, '2026-04-09 08:40:40'),
(68, 'manager', 'approvesponsorships', 'manager', NULL, '2026-04-09 08:40:40'),
(69, 'manager', 'incomingsponreq', 'manager', NULL, '2026-04-09 08:40:40'),
(70, 'manager', 'approvereppost', 'manager', NULL, '2026-04-09 08:40:40'),
(71, 'manager', 'approveApplication', 'manager', NULL, '2026-04-09 08:40:40'),
(72, 'manager', 'rejectApplication', 'manager', NULL, '2026-04-09 08:40:40'),
(73, 'manager', 'selectorgrep', 'manager', NULL, '2026-04-09 08:40:40'),
(74, 'manager', 'appointorgreps', 'manager', NULL, '2026-04-09 08:40:40'),
(75, 'manager', 'managereps', 'manager', NULL, '2026-04-09 08:40:40'),
(76, 'projects', 'annualeventapproval', 'organisationrep', NULL, '2026-04-09 08:40:40'),
(77, 'projects', 'annualeventstatus', 'manager', NULL, '2026-04-09 08:40:40'),
(78, 'projects', 'handleAnnualEventApproval', 'organisationrep', NULL, '2026-04-09 08:40:40'),
(79, 'admin', 'systemoverview', 'admin,manager', NULL, '2026-04-09 08:40:40'),
(80, 'admin', 'systemsettings', 'admin', NULL, '2026-04-09 08:40:40'),
(81, 'admin', 'manageusers', 'admin', NULL, '2026-04-09 08:40:40'),
(82, 'admin', 'getusersdata', 'admin', NULL, '2026-04-09 08:40:40'),
(83, 'admin', 'getuserdetails', 'admin', NULL, '2026-04-09 08:40:40'),
(84, 'admin', 'getstats', 'admin', NULL, '2026-04-09 08:40:40'),
(85, 'admin', 'updateuser', 'admin', NULL, '2026-04-09 08:40:40'),
(86, 'admin', 'toggleuserstatus', 'admin', NULL, '2026-04-09 08:40:40'),
(87, 'admin', 'deleteuser', 'admin', NULL, '2026-04-09 08:40:40'),
(88, 'admin', 'generatereport', 'admin,manager', NULL, '2026-04-09 08:40:40'),
(89, 'admin', 'getallhighlights', 'admin', NULL, '2026-04-09 08:40:40'),
(90, 'admin', 'gethighlightdetails', 'admin', NULL, '2026-04-09 08:40:40'),
(91, 'admin', 'updatehighlight', 'admin', NULL, '2026-04-09 08:40:40'),
(92, 'admin', 'createhighlight', 'admin', NULL, '2026-04-09 08:40:40'),
(93, 'admin', 'deactivatehighlight', 'admin', NULL, '2026-04-09 08:40:40'),
(94, 'admin', 'activatehighlight', 'admin', NULL, '2026-04-09 08:40:40'),
(95, 'donation', 'senddonation', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(96, 'donation', 'processdonation', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(97, 'donation', 'successfuldonation', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(98, 'donation', 'payherenotify', 'public', NULL, '2026-04-09 08:40:40'),
(99, 'merch', 'buymerch', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(100, 'merch', 'getitems', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(101, 'merch', 'getpoints', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(102, 'merch', 'purchase', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(103, 'merch', 'history', 'volunteer,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(104, 'rating', 'peer', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(105, 'rating', 'ratetasks', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(106, 'rating', 'submitpeerrating', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(107, 'rating', 'submittaskrating', 'manager,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(108, 'achievement', 'getdata', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(109, 'achievement', 'processevent', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(110, 'achievement', 'leaveevent', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(111, 'achievement', 'canreceivepoints', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(112, 'achievement', 'getstats', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(113, 'achievement', 'getleaderboard', 'volunteer,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(114, 'user', 'uploadLogo', 'public', NULL, '2026-04-09 08:40:40'),
(115, 'registration', 's_registration_step1', 'public', NULL, '2026-04-09 08:40:40'),
(116, 'registration', 's_registration_step2', 'public', NULL, '2026-04-09 08:40:40'),
(117, 'registration', 's_registration_step3', 'public', NULL, '2026-04-09 08:40:40'),
(118, 'registration', 's_registration_step4', 'public', NULL, '2026-04-09 08:40:40'),
(119, 'registration', 's_registration_complete', 'public', NULL, '2026-04-09 08:40:40'),
(120, 'notification', 'getunreadcount', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(121, 'notification', 'getnotifications', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(122, 'notification', 'markasread', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(123, 'notification', 'markallasread', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(124, 'notification', 'closenotification', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(125, 'merch', 'processmerchpayment', 'volunteer,sponsor', NULL, '2026-04-09 08:40:40'),
(126, 'merch', 'successfulpurchase', 'volunteer,sponsor', NULL, '2026-04-09 08:40:40'),
(127, 'merch', 'payherenotify', 'public', NULL, '2026-04-09 08:40:40'),
(128, 'merch', 'initiatepayment', 'volunteer,sponsor', NULL, '2026-04-09 08:40:40'),
(129, 'user', 'uploadProfileImage', 'volunteer,manager,admin,sponsor,representative,organisationrep', NULL, '2026-04-09 08:40:40'),
(130, 'sponsor', 'processsponsorship', 'sponsor', NULL, '2026-04-12 10:35:27'),
(131, 'sponsorship', 'processsponsorship', 'sponsor', NULL, '2026-04-12 10:36:47'),
(132, 'donation', 'initiatepayment', 'volunteer,sponsor', NULL, '2026-04-15 08:53:56'),
(133, 'sponsorship', 'sendsponsorship', 'sponsor', NULL, '2026-04-15 08:54:17'),
(134, 'sponsorship', 'initiatepayment', 'sponsor', NULL, '2026-04-15 08:54:17'),
(135, 'sponsorship', 'sponsorsuccess', 'sponsor', NULL, '2026-04-15 08:54:17'),
(136, 'sponsorship', 'payherenotify', 'public', NULL, '2026-04-15 08:54:17');

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

DROP TABLE IF EXISTS `sponsor`;
CREATE TABLE IF NOT EXISTS `sponsor` (
  `userid` int NOT NULL,
  `business_registration_number` varchar(50) DEFAULT NULL,
  `year_established` year DEFAULT NULL,
  `official_website_link` varchar(255) DEFAULT NULL,
  `about_company` text,
  `organization_type` varchar(50) NOT NULL,
  `contact_person_name` varchar(100) DEFAULT NULL,
  `contact_person_role` varchar(100) DEFAULT NULL,
  `contact_person_email` varchar(150) DEFAULT NULL,
  `contact_person_contact_number` varchar(20) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT '/V/View/userdash/settings/img/profile1.png',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`userid`, `business_registration_number`, `year_established`, `official_website_link`, `about_company`, `organization_type`, `contact_person_name`, `contact_person_role`, `contact_person_email`, `contact_person_contact_number`, `logo_path`) VALUES
(4, '00285800', '2026', 'https://www.keellssuper.com/', 'Keeps Supermarket is a retail store that provides a wide range of everyday goods such as groceries, household items, and fresh produce.', 'company', 'Videesha Navodi', 'Manager', 'videeshanavodi1234@gmail.com', '0711062292', '/V/uploads/sponsor_logos/sponsor_4_1775726009.png'),
(60, NULL, NULL, 'https://www.boc.lk/', 'Bank of Ceylon is a state-owned, major commercial bank in Sri Lanka.', 'company', NULL, NULL, NULL, NULL, '/V/uploads/sponsor_logos/sponsor_60_1776287334.jpg'),
(61, NULL, NULL, 'https://www.slt.lk/home', 'Sri Lanka Telecom PLC, doing business as SLTMobitel, is the national telecommunications services provider in Sri Lanka.', 'company', NULL, NULL, NULL, NULL, '/V/uploads/sponsor_logos/sponsor_61_1776287505.png'),
(62, NULL, NULL, 'https://kfc.lk/home', 'KFC (Kentucky Fried Chicken) is a global fast-food restaurant chain specializing in fried chicken.', 'company', NULL, NULL, NULL, NULL, '/V/uploads/sponsor_logos/sponsor_62_1776287753.png'),
(63, NULL, NULL, 'https://www.dailymirror.lk/', 'The Daily Mirror (based on dailymirror.lk) is a leading English-language daily newspaper in Sri Lanka.', 'company', NULL, NULL, NULL, NULL, '/V/uploads/sponsor_logos/sponsor_63_1776288073.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sponsorship_request`
--

DROP TABLE IF EXISTS `sponsorship_request`;
CREATE TABLE IF NOT EXISTS `sponsorship_request` (
  `request_id` int NOT NULL,
  `event_id` int NOT NULL,
  `sponsorid` int NOT NULL,
  PRIMARY KEY (`request_id`),
  KEY `event_id` (`event_id`),
  KEY `sponsorid` (`sponsorid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_event_commitment`
--

DROP TABLE IF EXISTS `sponsor_event_commitment`;
CREATE TABLE IF NOT EXISTS `sponsor_event_commitment` (
  `commitment_id` int NOT NULL AUTO_INCREMENT,
  `sponsor_id` int NOT NULL,
  `event_id` int NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `commitment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `commitment_amount` decimal(12,2) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'not accepted',
  PRIMARY KEY (`commitment_id`),
  KEY `event_id` (`event_id`)
) ;

--
-- Dumping data for table `sponsor_event_commitment`
--

INSERT INTO `sponsor_event_commitment` (`commitment_id`, `sponsor_id`, `event_id`, `order_id`, `commitment_date`, `commitment_amount`, `transaction_id`, `status`) VALUES
(1, 4, 14, 'SPONSOR-1776277052-9267', '2026-04-15 23:47:32', 11000.00, '320032591989', 'accepted'),
(2, 4, 2, 'SPONSOR-1776274101-9869', '2026-04-15 22:58:21', 11999.98, NULL, 'not accepted'),
(3, 4, 14, 'SPONSOR-1776280948-6605', '2026-04-16 00:52:28', 10499.99, '320032592004', 'accepted'),
(4, 4, 2, 'SPONSOR-1776285853-6526', '2026-04-16 02:14:13', 10000.00, '320032592023', 'accepted'),
(5, 63, 2, 'SPONSOR-1776288136-9615', '2026-04-16 02:52:16', 10000.00, '320032592025', 'accepted'),
(6, 60, 23, 'SPONSOR-1776289867-4763', '2026-04-16 03:21:07', 75000.00, NULL, 'not accepted'),
(7, 60, 23, 'SPONSOR-1776289888-4668', '2026-04-16 03:21:28', 55000.00, NULL, 'not accepted'),
(8, 60, 23, 'SPONSOR-1776289895-6931', '2026-04-16 03:21:35', 45000.00, '320032592026', 'accepted'),
(9, 61, 23, 'SPONSOR-1776290027-2755', '2026-04-16 03:23:47', 10000.00, '320032592027', 'accepted'),
(10, 63, 23, 'SPONSOR-1776290136-9532', '2026-04-16 03:25:36', 35000.00, '320032592028', 'accepted'),
(11, 63, 2, 'SPONSOR-1776290266-5959', '2026-04-16 03:27:46', 34000.00, '320032592029', 'accepted'),
(12, 62, 24, 'SPONSOR-1776290554-1632', '2026-04-16 03:32:34', 45000.00, '320032592030', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `task_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `status` varchar(50) DEFAULT 'pending',
  `event_id` int DEFAULT NULL,
  `max_participants` int DEFAULT NULL,
  `current_participants` int DEFAULT '0',
  `organizer_id` int NOT NULL,
  `createddate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`task_id`),
  KEY `organizer_id` (`organizer_id`),
  KEY `event_id` (`event_id`)
) ;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `name`, `description`, `status`, `event_id`, `max_participants`, `current_participants`, `organizer_id`, `createddate`) VALUES
(1, 'planting mangrove saplings', 'plant mangrove saplings in designated blocks', 'inprogress', 4, 10, 0, 3, '2026-04-10 00:37:30'),
(2, 'debris removal', 'clear plastic, waste, and invasive plants', 'inprogress', 4, 15, 0, 3, '2026-04-10 00:38:22'),
(3, 'protective fencing setup', 'install barriers to protect young mangroves from damage', 'inprogress', 4, 14, 0, 3, '2026-04-10 00:40:03'),
(4, 'volunteer coordination', 'guide participants, assign zones, and manage workflow', 'inprogress', 4, 3, 0, 3, '2026-04-10 00:40:52'),
(5, 'Trail Waste Collection', 'Pick up plastic, bottles, and litter along the trail.', 'pending', 2, 50, 0, 3, '2026-04-10 00:51:04'),
(6, 'Waste Segregation', 'Separate collected waste into recyclable and non-recyclable categories.', 'pending', 2, 50, 0, 3, '2026-04-10 00:51:46'),
(7, 'Waste Transport Assistance', 'Help carry collected garbage down to proper disposal points.', 'pending', 2, 50, 0, 3, '2026-04-10 00:52:13'),
(8, 'Drain & Gutter Cleaning', 'Clear blocked drains to prevent flooding.', 'pending', 6, 25, 0, 3, '2026-04-10 00:53:19'),
(9, 'Waste Segregation', 'Sort collected waste into recyclable and non-recyclable items.', 'pending', 6, 25, 0, 3, '2026-04-10 00:53:48'),
(10, 'Install Disposal Bins', 'repair damaged garbage bins and install new ones where necessary', 'inprogress', 6, 25, 0, 3, '2026-04-10 00:54:57'),
(11, 'Shoreline Waste Collection', 'Collect plastic, glass, and debris along Unawatuna Beach.', 'pending', 1, 15, 0, 3, '2026-04-10 00:56:27'),
(12, 'Waste Sorting & Recycling', 'Separate collected waste into recyclable and non-recyclable categories.', 'pending', 1, 15, 0, 3, '2026-04-10 00:56:50'),
(13, 'Coral Fragment Planting', 'Attach and plant coral fragments onto reef structures at Nilaveli Beach.', 'inprogress', 3, 7, 0, 3, '2026-04-10 00:58:16'),
(14, 'Reef Cleaning & Maintenance', 'Remove algae, debris, and harmful waste from the coral restoration site.', 'inprogress', 3, 8, 0, 3, '2026-04-10 00:58:42'),
(15, 'Sapling Planting', 'Dig holes and plant native trees.', 'inprogress', 5, 10, 0, 5, '2026-04-10 01:24:04'),
(16, 'Watering & Maintenance', 'Water newly planted saplings and ensure they are stable and protected.', 'inprogress', 5, 9, 0, 5, '2026-04-10 01:25:03'),
(17, 'Soil Preparation & Pit Digging', 'Prepare planting pits and enrich soil with compost.', 'pending', 9, 6, 0, 5, '2026-04-10 01:26:28'),
(18, 'Plant Care & Watering', 'Water saplings and ensure proper support', 'pending', 9, 6, 0, 5, '2026-04-10 01:26:57'),
(19, 'Collect Polythene Waste', 'Pick up litter from roads, sidewalks, and public areas.', 'inprogress', 11, 6, 0, 3, '2026-04-10 08:32:51'),
(20, 'Waste Transport Coordination', 'Assist in moving collected waste to municipal disposal points.', 'inprogress', 11, 6, 0, 3, '2026-04-10 08:33:16'),
(21, 'Re-green the ocean floor', 'Plant the coral in the designates spots', 'inprogress', 16, 3, 0, 3, '2026-04-13 00:57:49'),
(22, 'Task 01', 'Collect polythene and plastic from the shoreline', 'inprogress', 12, 2, 0, 3, '2026-04-13 01:17:05'),
(23, 'Plant and Water the Saplings', 'Plant the plants using compost and later water them/', 'inprogress', 17, 3, 0, 3, '2026-04-13 02:02:28'),
(28, 'T1', '1', 'inprogress', 19, 1, 0, 3, '2026-04-13 20:18:29'),
(26, 'Task 01: Plant and Water Saplings', 'Plant and Water Saplings', 'inprogress', 18, 12, 0, 3, '2026-04-13 16:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `task_assignment`
--

DROP TABLE IF EXISTS `task_assignment`;
CREATE TABLE IF NOT EXISTS `task_assignment` (
  `task_id` int NOT NULL,
  `volunteer_id` int NOT NULL,
  `assignment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`task_id`,`volunteer_id`),
  KEY `volunteer_id` (`volunteer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_assignment`
--

INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(1, 1, '2026-04-10 00:37:48'),
(1, 5, '2026-04-10 00:37:48'),
(1, 6, '2026-04-10 00:37:48'),
(1, 7, '2026-04-10 00:37:48'),
(1, 8, '2026-04-10 00:37:48'),
(1, 9, '2026-04-10 00:37:48'),
(1, 10, '2026-04-10 00:37:48'),
(1, 13, '2026-04-10 00:37:48'),
(1, 14, '2026-04-10 00:37:48'),
(1, 15, '2026-04-10 00:37:48'),
(2, 16, '2026-04-10 00:38:45'),
(2, 17, '2026-04-10 00:38:45'),
(2, 18, '2026-04-10 00:38:45'),
(2, 20, '2026-04-10 00:38:45'),
(2, 21, '2026-04-10 00:38:45'),
(2, 22, '2026-04-10 00:38:45'),
(2, 23, '2026-04-10 00:38:45'),
(2, 30, '2026-04-10 00:38:45'),
(2, 31, '2026-04-10 00:38:45'),
(2, 32, '2026-04-10 00:38:45'),
(2, 33, '2026-04-10 00:38:45'),
(2, 34, '2026-04-10 00:38:45'),
(2, 35, '2026-04-10 00:38:45'),
(2, 36, '2026-04-10 00:38:45'),
(2, 37, '2026-04-10 00:38:45'),
(3, 38, '2026-04-10 00:40:18'),
(3, 39, '2026-04-10 00:40:18'),
(3, 40, '2026-04-10 00:40:18'),
(3, 41, '2026-04-10 00:40:18'),
(3, 42, '2026-04-10 00:40:18'),
(3, 49, '2026-04-10 00:40:18'),
(3, 50, '2026-04-10 00:40:18'),
(3, 51, '2026-04-10 00:40:18'),
(3, 52, '2026-04-10 00:40:18'),
(3, 53, '2026-04-10 00:40:18'),
(3, 54, '2026-04-10 00:40:18'),
(3, 55, '2026-04-10 00:40:18'),
(3, 56, '2026-04-10 00:40:18'),
(4, 57, '2026-04-10 00:41:02'),
(4, 58, '2026-04-10 00:41:02'),
(4, 59, '2026-04-10 00:41:02'),
(15, 17, '2026-04-10 01:24:16'),
(15, 8, '2026-04-10 01:24:33'),
(15, 9, '2026-04-10 01:24:33'),
(15, 11, '2026-04-10 01:24:33'),
(15, 12, '2026-04-10 01:24:33'),
(15, 13, '2026-04-10 01:24:33'),
(15, 14, '2026-04-10 01:24:33'),
(15, 15, '2026-04-10 01:24:33'),
(15, 16, '2026-04-10 01:24:33'),
(15, 18, '2026-04-10 01:24:33'),
(16, 19, '2026-04-10 01:25:13'),
(16, 20, '2026-04-10 01:25:13'),
(16, 22, '2026-04-10 01:25:13'),
(16, 21, '2026-04-10 01:25:13'),
(16, 23, '2026-04-10 01:25:13'),
(16, 24, '2026-04-10 01:25:13'),
(16, 26, '2026-04-10 01:25:13'),
(16, 27, '2026-04-10 01:25:13'),
(16, 28, '2026-04-10 01:25:13'),
(17, 8, '2026-04-10 01:27:04'),
(17, 9, '2026-04-10 01:27:04'),
(17, 11, '2026-04-10 01:27:04'),
(17, 12, '2026-04-10 01:27:04'),
(17, 13, '2026-04-10 01:27:04'),
(18, 14, '2026-04-10 01:27:14'),
(18, 15, '2026-04-10 01:27:14'),
(18, 16, '2026-04-10 01:27:14'),
(18, 17, '2026-04-10 01:27:14'),
(18, 18, '2026-04-10 01:27:14'),
(17, 1, '2026-04-10 01:39:15'),
(18, 5, '2026-04-10 01:39:23'),
(19, 1, '2026-04-10 08:33:30'),
(19, 8, '2026-04-10 08:33:30'),
(19, 9, '2026-04-10 08:33:30'),
(19, 10, '2026-04-10 08:33:30'),
(19, 11, '2026-04-10 08:33:30'),
(13, 8, '2026-04-12 23:34:07'),
(13, 9, '2026-04-12 23:34:07'),
(13, 10, '2026-04-12 23:34:07'),
(13, 11, '2026-04-12 23:34:07'),
(13, 12, '2026-04-12 23:34:07'),
(13, 16, '2026-04-12 23:34:07'),
(13, 17, '2026-04-12 23:34:07'),
(14, 18, '2026-04-12 23:34:18'),
(14, 14, '2026-04-12 23:34:18'),
(14, 13, '2026-04-12 23:34:18'),
(14, 19, '2026-04-12 23:34:18'),
(14, 20, '2026-04-12 23:34:18'),
(14, 21, '2026-04-12 23:34:18'),
(14, 22, '2026-04-12 23:34:18'),
(14, 23, '2026-04-12 23:34:18'),
(20, 12, '2026-04-12 23:38:17'),
(20, 13, '2026-04-12 23:38:17'),
(20, 14, '2026-04-12 23:38:17'),
(20, 15, '2026-04-12 23:38:17'),
(20, 16, '2026-04-12 23:38:17'),
(20, 17, '2026-04-12 23:38:17'),
(19, 35, '2026-04-12 23:38:33'),
(21, 1, '2026-04-13 00:57:54'),
(21, 8, '2026-04-13 00:57:54'),
(21, 9, '2026-04-13 00:57:54'),
(22, 8, '2026-04-13 01:18:12'),
(22, 9, '2026-04-13 01:18:12'),
(23, 8, '2026-04-13 02:02:33'),
(23, 9, '2026-04-13 02:02:33'),
(23, 10, '2026-04-13 02:02:33'),
(26, 20, '2026-04-13 16:35:36'),
(26, 18, '2026-04-13 16:35:36'),
(26, 17, '2026-04-13 16:35:36'),
(26, 16, '2026-04-13 16:35:36'),
(26, 15, '2026-04-13 16:35:36'),
(26, 14, '2026-04-13 16:35:36'),
(26, 13, '2026-04-13 16:35:36'),
(26, 12, '2026-04-13 16:35:36'),
(26, 11, '2026-04-13 16:35:36'),
(26, 10, '2026-04-13 16:35:36'),
(26, 9, '2026-04-13 16:35:36'),
(26, 8, '2026-04-13 16:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `task_performance_rating`
--

DROP TABLE IF EXISTS `task_performance_rating`;
CREATE TABLE IF NOT EXISTS `task_performance_rating` (
  `taskratingid` int NOT NULL AUTO_INCREMENT,
  `task_id` int NOT NULL,
  `volunteer_id` int NOT NULL,
  `rater_id` int NOT NULL,
  `performance_score` decimal(5,2) NOT NULL,
  `comment` text,
  `time_stamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`taskratingid`),
  UNIQUE KEY `task_id` (`task_id`,`volunteer_id`,`rater_id`),
  KEY `volunteer_id` (`volunteer_id`),
  KEY `rater_id` (`rater_id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_performance_rating`
--

INSERT INTO `task_performance_rating` (`taskratingid`, `task_id`, `volunteer_id`, `rater_id`, `performance_score`, `comment`, `time_stamp`) VALUES
(1, 1, 1, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(2, 1, 5, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(3, 1, 6, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(4, 1, 7, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(5, 1, 8, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(6, 1, 9, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(7, 1, 10, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(8, 1, 13, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(9, 1, 14, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(10, 1, 15, 3, 4.00, 'good team work and communication', '2026-04-10 00:49:10'),
(11, 2, 16, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(12, 2, 17, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(13, 2, 18, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(14, 2, 20, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(15, 2, 21, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(16, 2, 22, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(17, 2, 23, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(18, 2, 30, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(19, 2, 31, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(20, 2, 32, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(21, 2, 33, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(22, 2, 34, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(23, 2, 35, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(24, 2, 36, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(25, 2, 37, 3, 3.00, 'some plastic remained but overall solid work', '2026-04-10 00:49:12'),
(26, 3, 38, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(27, 3, 39, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(28, 3, 40, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(29, 3, 41, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(30, 3, 42, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(31, 3, 49, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(32, 3, 50, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(33, 3, 51, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(34, 3, 52, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(35, 3, 53, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(36, 3, 54, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(37, 3, 55, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(38, 3, 56, 3, 5.00, 'had installed some neat nice barriers around the saplings', '2026-04-10 00:49:13'),
(39, 4, 57, 3, 5.00, 'excellent coordination was maintained between volunteer parties', '2026-04-10 00:49:15'),
(40, 4, 58, 3, 5.00, 'excellent coordination was maintained between volunteer parties', '2026-04-10 00:49:15'),
(41, 4, 59, 3, 5.00, 'excellent coordination was maintained between volunteer parties', '2026-04-10 00:49:15'),
(42, 15, 8, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(43, 15, 9, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(44, 15, 11, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(45, 15, 12, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(46, 15, 13, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(47, 15, 14, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(48, 15, 15, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(49, 15, 16, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(50, 15, 17, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(51, 15, 18, 5, 5.00, 'Neatly completed the planting process', '2026-04-10 01:29:35'),
(52, 16, 19, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(53, 16, 20, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(54, 16, 21, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(55, 16, 22, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(56, 16, 23, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(57, 16, 24, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(58, 16, 26, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(59, 16, 27, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(60, 16, 28, 5, 4.00, 'water wastage was noticed but overall good performance', '2026-04-10 01:30:21'),
(61, 19, 1, 3, 4.00, '', '2026-04-12 19:24:17'),
(62, 19, 8, 3, 4.00, '', '2026-04-12 19:24:17'),
(63, 19, 9, 3, 4.00, '', '2026-04-12 19:24:17'),
(64, 19, 10, 3, 4.00, '', '2026-04-12 19:24:17'),
(65, 19, 11, 3, 4.00, '', '2026-04-12 19:24:17'),
(66, 13, 8, 3, 5.00, 'Good', '2026-04-12 23:34:32'),
(67, 13, 9, 3, 5.00, 'Good', '2026-04-12 23:34:32'),
(68, 13, 10, 3, 5.00, 'Good', '2026-04-12 23:34:32'),
(69, 13, 11, 3, 5.00, 'Good', '2026-04-12 23:34:32'),
(70, 13, 12, 3, 5.00, 'Good', '2026-04-12 23:34:32'),
(71, 13, 16, 3, 5.00, 'Good', '2026-04-12 23:34:32'),
(72, 13, 17, 3, 5.00, 'Good', '2026-04-12 23:34:32'),
(73, 14, 13, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(74, 14, 14, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(75, 14, 18, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(76, 14, 19, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(77, 14, 20, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(78, 14, 21, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(79, 14, 22, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(80, 14, 23, 3, 4.00, 'Room exists for improvement\r\n', '2026-04-12 23:34:46'),
(81, 20, 12, 3, 5.00, '', '2026-04-12 23:39:42'),
(82, 20, 13, 3, 5.00, '', '2026-04-12 23:39:42'),
(83, 20, 14, 3, 5.00, '', '2026-04-12 23:39:42'),
(84, 20, 15, 3, 5.00, '', '2026-04-12 23:39:42'),
(85, 20, 16, 3, 5.00, '', '2026-04-12 23:39:42'),
(86, 20, 17, 3, 5.00, '', '2026-04-12 23:39:42'),
(87, 21, 1, 3, 4.00, '', '2026-04-13 00:59:29'),
(88, 21, 8, 3, 4.00, '', '2026-04-13 00:59:29'),
(89, 21, 9, 3, 4.00, '', '2026-04-13 00:59:29'),
(90, 22, 8, 3, 5.00, '', '2026-04-13 01:18:29'),
(91, 22, 9, 3, 5.00, '', '2026-04-13 01:18:29'),
(92, 23, 8, 3, 4.00, 'good', '2026-04-13 02:03:06'),
(93, 23, 9, 3, 4.00, 'good', '2026-04-13 02:03:06'),
(94, 23, 10, 3, 4.00, 'good', '2026-04-13 02:03:06'),
(95, 26, 8, 3, 5.00, '', '2026-04-13 16:35:49'),
(96, 26, 9, 3, 5.00, '', '2026-04-13 16:35:49'),
(97, 26, 10, 3, 5.00, '', '2026-04-13 16:35:49'),
(98, 26, 11, 3, 5.00, '', '2026-04-13 16:35:49'),
(99, 26, 12, 3, 5.00, '', '2026-04-13 16:35:49'),
(100, 26, 13, 3, 5.00, '', '2026-04-13 16:35:49'),
(101, 26, 14, 3, 5.00, '', '2026-04-13 16:35:49'),
(102, 26, 15, 3, 5.00, '', '2026-04-13 16:35:49'),
(103, 26, 16, 3, 5.00, '', '2026-04-13 16:35:49'),
(104, 26, 17, 3, 5.00, '', '2026-04-13 16:35:49'),
(105, 26, 18, 3, 5.00, '', '2026-04-13 16:35:49'),
(106, 26, 20, 3, 5.00, '', '2026-04-13 16:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactnumber` varchar(10) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `createddate` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'active',
  `profile_path` varchar(255) DEFAULT '/V/uploads/profile_image/profile.jpg',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `email` (`email`)
) ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `name`, `password`, `email`, `contactnumber`, `role`, `createddate`, `status`, `profile_path`) VALUES
(1, 'Nadin Bandara', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'nadinwbandara@gmail.com', '0740616440', 'volunteer', '2026-04-09 14:14:27', 'active', '/V/uploads/profile_image/profile_1_1775724295.jpg'),
(2, 'Administrator', '$2y$10$X9vwZy.jD5F2YGAKG9RrXe4Pz8G/IQ4CDF1z9VRo2VrBTvXZw4DkC', 'v4volunteering0000@gmail.com', '0112849859', 'admin', '2026-04-09 14:21:21', 'active', '/V/uploads/profile_image/profile_2_1775725559.png'),
(3, 'Zolo Yu', '$2y$10$j40P9vMG1QErYQHGJl6giuVQI3x8e37rZB3QEMhvFooxE8lR6OFBy', 'zolouu56@gmail.com', '0778545890', 'manager', '2026-04-09 14:22:53', 'active', '/V/uploads/profile_image/profile_3_1775733786.png'),
(4, 'Keels Super Market', '$2y$10$qWSKba3eJgO/WZxVY6.pjegdo0dzkDDtoiqYxf8Z9LZH.iR.FJgAK', 'susunoodles22@gmail.com', '0112303500', 'sponsor', '2026-04-09 14:43:29', 'active', '/V/uploads/profile_image/profile_4_1775726029.png'),
(5, 'Thivinya Abeyratna', '$2y$10$2.5HBPmN0ZBHUTXSDEArX./vZc.mcyDy/z5ZYUq3j9ZC/rniZgsqq', 'mesonfear@gmail.com', '0710663503', 'representative', '2026-04-09 15:07:47', 'active', '/V/uploads/profile_image/profile_5_1775727798.png'),
(6, 'Chamith Nimsara', '$2y$10$kbujvGkQ4EAqoA1PerGime3oobVNrRBc1gInuVPcojZ6AJHGaZ9aO', 'nadinyear2sem2@gmail.com', '0702511336', 'organisationrep', '2026-04-09 15:17:00', 'active', '/V/uploads/profile_image/profile_6_1775728154.png'),
(7, 'Sachindra Senevirathne', '$2y$10$j40P9vMG1QErYQHGJl6giuVQI3x8e37rZB3QEMhvFooxE8lR6OFBy', 'sachindra@gmail.com', '0712712004', 'organisationrep', '2026-04-09 15:50:03', 'active', '/V/uploads/profile_image/profile.jpg'),
(8, 'Amaya Fonseka', '$2y$10$dzN.UV5UvhNV5Eaxpa.jK.wMwDB7xeELbwiX7yjl7jYTfNZdTbZre', 'v8@gmail.com', '0711000045', 'volunteer', '2026-04-09 17:35:37', 'active', '/V/uploads/profile_image/profile.jpg'),
(9, 'Bimal Gunawardena', '$2y$10$WnD2KdAJmQCWwWib/75rUOkvp7wkAFdjEqZzHEhxgKEaNrOFaPflm', 'v9@gmail.com', '0711000046', 'volunteer', '2026-04-09 17:39:21', 'active', '/V/uploads/profile_image/profile.jpg'),
(10, 'Chamari Alwis', '$2y$10$YQIScPMmZ85Xo9K8t7lPmOaqeak3DKdjYb/ZkuJlVktuh48GkMdnW', 'v10@gmail.com', '0711000047', 'volunteer', '2026-04-09 17:44:22', 'active', '/V/uploads/profile_image/profile.jpg'),
(11, 'Dilan Munasinghe', '$2y$10$k.Ks5L592DQu4/ZApfY7B.QAYnVOZ0huzSJLYMJEgQHDexA.1jAVe', 'v11@gmail.com', '0711000048', 'volunteer', '2026-04-09 17:48:29', 'active', '/V/uploads/profile_image/profile.jpg'),
(12, 'Erandi Madushani', '$2y$10$8Ufb6WnJCRg.NAsrOKdKnO2eNSqcJ5a37JmkMfu1SPhp93DGkCKUq', 'v12@gmail.com', '0711000049', 'volunteer', '2026-04-09 17:54:45', 'active', '/V/uploads/profile_image/profile.jpg'),
(13, 'Fathima Nazeer', '$2y$10$2nXomKZV8L9C4YhS48PpPuItBXc57BcxbRBzmQB8BaOWTj288p4su', 'v13@gmail.com', '0711000050', 'volunteer', '2026-04-09 18:15:34', 'active', '/V/uploads/profile_image/profile.jpg'),
(14, 'Gehan Kulatunga', '$2y$10$dE5gJcinVfm.f5pORsMAgu76YhIKu2pn9gCCUbdjOSgSF1V0FTRQi', 'v14@gmail.com', '0711000051', 'volunteer', '2026-04-09 18:19:34', 'active', '/V/uploads/profile_image/profile.jpg'),
(15, 'Hiruni Dahanayake', '$2y$10$gaP4Ltcf35NGoGA/OYl3V.muiWykbAnFKXxRWNx4GkjVCz5TAe1iu', 'v15@gmail.com', '0711000052', 'volunteer', '2026-04-09 18:24:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(16, 'Isuru Pathirana', '$2y$10$M0fBvn7SXBaBtE.ofrxjY.aDIzoKmdgvPQgJ9xz.g4CFUFO1hHhMS', 'v16@gmail.com', '0711000053', 'volunteer', '2026-04-09 18:29:43', 'active', '/V/uploads/profile_image/profile.jpg'),
(17, 'Janani Sivakumar', '$2y$10$rbVRPUkf5pol6MIVCFyVW.0ibbyNqdYHClWNoKdf0izG/4sLptDTC', 'v17@gmail.com', '0711000054', 'volunteer', '2026-04-09 18:33:16', 'active', '/V/uploads/profile_image/profile.jpg'),
(18, 'Kasun Premaratne', '$2y$10$dKeCsLlsK87rJMfKA1r7b.HqSclBPYW1lOOpWWQg4Zc1hWHAfOkt.', 'v18@gmail.com', '0711000055', 'volunteer', '2026-04-09 18:35:55', 'active', '/V/uploads/profile_image/profile.jpg'),
(19, 'Lakmini Rathnayake', '$2y$10$RPZl.Xu6m3BgcOURCmwvMuFUC41thNsULveOU/d/glo3.RhVk.fXm', 'v19@gmail.com', '0711000056', 'volunteer', '2026-04-09 18:39:18', 'active', '/V/uploads/profile_image/profile.jpg'),
(20, 'Mahesh Thisera', '$2y$10$YpO.Ha.e/Sz0/l6RRNijVOl58qLt5yBkgYHJJDOJIy9r9eCE93HIK', 'v20@gmail.com', '0711000057', 'volunteer', '2026-04-09 18:43:50', 'active', '/V/uploads/profile_image/profile.jpg'),
(21, 'Nadeeka Wijetunga', '$2y$10$LyVWzy0XvtnIA2R6wulb7OBQZVEUjKtu5jUs.Xds4V24tP/ZP2qma', 'v21@gmail.com', '0711000058', 'volunteer', '2026-04-09 20:38:03', 'active', '/V/uploads/profile_image/profile.jpg'),
(22, 'Oshadi Jayawardena', '$2y$10$FQqu/VS4L3xMGFZExOCwZeiOeE.e0/4BCgk4WC8ancsZuwl1TYyYe', 'v22@gmail.com', '0711000059', 'volunteer', '2026-04-09 20:39:57', 'active', '/V/uploads/profile_image/profile.jpg'),
(23, 'Prabath Kumara', '$2y$10$.yVNrTut59viK2W6WvKznue8a2b6cfLzuW6sIMgjBmnLH2izMD8OO', 'v23@gmail.com', '0711000060', 'volunteer', '2026-04-09 20:42:17', 'active', '/V/uploads/profile_image/profile.jpg'),
(24, 'Rashmi Liyanage', '$2y$10$VD9lXvbIM2t98xPbFTzO9O1yEtTQdMSP1ajq2364WHAoyRHB.neFq', 'v24@gmail.com', '0711000062', 'volunteer', '2026-04-09 20:44:23', 'active', '/V/uploads/profile_image/profile.jpg'),
(25, 'Sachini Warnasuriya', '$2y$10$YqepUHE9bq/2Hf4qa4iRn.xagdoasxLC167xOjuw8K4kQDDZQuB3a', 'v25@gmail.com', '0711000063', 'volunteer', '2026-04-09 20:48:58', 'active', '/V/uploads/profile_image/profile.jpg'),
(26, 'Tharindu Samarakoon', '$2y$10$H2lA.CyKR6yz1iOIIjtPreCDxOwlRAv2NpU2OnCwrOffusn4PQCkS', 'v26@gmail.com', '0711000064', 'volunteer', '2026-04-09 20:50:57', 'active', '/V/uploads/profile_image/profile.jpg'),
(27, 'Umayangani Peris', '$2y$10$R2KnF.JDeCZ6NqJ3GljxAunzHJmEAi3WzePC0gizIyXCBPLRmOSwS', 'v27@gmail.com', '0711000065', 'volunteer', '2026-04-09 20:52:30', 'active', '/V/uploads/profile_image/profile.jpg'),
(28, 'Vimukthi Gamage', '$2y$10$dxRE.r.H2Fu104Ag3mD7ye7HSHfK4Y.o/DjkvuDVBUnTIGxdhZT9i', 'v28@gmail.com', '0711000066', 'volunteer', '2026-04-09 20:54:15', 'active', '/V/uploads/profile_image/profile.jpg'),
(29, 'Waruni Rodrigo', '$2y$10$JQwfbIqmfHNiCFSqpV4M2uCL21Pb0.7mxirERU/n9.MhaCiyggCX6', 'v29@gmail.com', '0711000067', 'volunteer', '2026-04-09 20:56:09', 'active', '/V/uploads/profile_image/profile.jpg'),
(30, 'Sunil Marasinghe', '$2y$10$WHk3fUvgqYi2sPnnGcqeA.Bb.8HGlai.qF.QNB4tmIKPsLHaLx6Ke', 'v30@gmail.com', '0711000068', 'volunteer', '2026-04-09 20:58:07', 'active', '/V/uploads/profile_image/profile.jpg'),
(31, 'Yashodha Nandasiri', '$2y$10$gqiSJj9pDGDYAX7ca75edeQPYS9cxIQBA4G01IYovGyOLxk7c7tdi', 'v31@gmail.com', '0711000069', 'volunteer', '2026-04-09 20:59:45', 'active', '/V/uploads/profile_image/profile.jpg'),
(32, 'Zinara Muthumala', '$2y$10$WxkqHeOM6xXLjy4cVyBr2ubtpyZFbfCC5dcXjucFZuJkNyhEvOSj6', 'v32@gmail.com', '0711000070', 'volunteer', '2026-04-09 21:01:17', 'active', '/V/uploads/profile_image/profile.jpg'),
(33, 'Anura Senanayake', '$2y$10$Xo8VXlQmzuhVp4JLYrR2OOKv4Z5K/JnpMZMKw4T5xZUYqdXoGLS4e', 'v33@gmail.com', '0711000071', 'volunteer', '2026-04-09 21:02:52', 'active', '/V/uploads/profile_image/profile.jpg'),
(34, 'Buddhini Dharmaratne', '$2y$10$5fDHOqd52dqNXYC0f8AcFOfnKhy2/3/agM5QHp4GKZ5s6DCXA7rIu', 'v34@gmail.com', '0711000072', 'volunteer', '2026-04-09 21:04:24', 'active', '/V/uploads/profile_image/profile.jpg'),
(35, 'Chathura Ekanayake', '$2y$10$4AlveG8189afYod9N9WGMOC7JWA.WKTsTdldu62GcLJTA2M6B4722', 'v35@gmail.com', '0711000073', 'volunteer', '2026-04-09 21:07:32', 'active', '/V/uploads/profile_image/profile.jpg'),
(36, 'Dilani Wickramasinghe', '$2y$10$N29Vw9JQI6dXIHfU0Y5/JeAVt.NROKfoZwOZEKiSI14dY9tKf3LLe', 'v36@gmail.com', '0711000074', 'volunteer', '2026-04-09 21:09:33', 'active', '/V/uploads/profile_image/profile.jpg'),
(37, 'Eshan Kuruppu', '$2y$10$2tZOdcd7lraQoRuubt7tUejqwIITttBJokgjReBYByn9KECWGcds6', 'v37@gmail.com', '0711000075', 'volunteer', '2026-04-09 21:10:53', 'active', '/V/uploads/profile_image/profile.jpg'),
(38, 'Gavesh Ekanayake', '$2y$10$etRSalH8Dc8/hRvMNyv85eWzU1INh.YGYkqQsaAdrI9cypwChUrz6', 'v38@gmail.com', '0711000077', 'volunteer', '2026-04-09 21:13:11', 'active', '/V/uploads/profile_image/profile.jpg'),
(39, 'Hasitha Madanayake', '$2y$10$SEmeLaGPCwBm48nTuR2UU..dy9bIxqsAr0sPrIewdDNlQv1YhnNsu', 'v39@gmail.com', '0711000078', 'volunteer', '2026-04-09 21:15:25', 'active', '/V/uploads/profile_image/profile.jpg'),
(40, 'Imasha Senaratne', '$2y$10$Tl0Gs2MxEdqL38N72bnVFO.HFpwVO4AzIxQsIn9mrsEMdfWUbhj1G', 'v40@gmail.com', '0711000079', 'volunteer', '2026-04-09 21:18:11', 'active', '/V/uploads/profile_image/profile.jpg'),
(41, 'Jayani Koswatte', '$2y$10$ugUrS0PjAYl/7/qT0mqEceeo4OBMMFASQs9687EpJH0UhDl5SeZiy', 'v41@gmail.com', '0711000080', 'volunteer', '2026-04-09 21:19:53', 'active', '/V/uploads/profile_image/profile.jpg'),
(42, 'Krishan Muthukumar', '$2y$10$fSotTv.up4h4CW92meceXOVLEdH.C852ybMmWBUj18a5OyTokzMuW', 'v42@gmail.com', '0711000081', 'volunteer', '2026-04-09 21:22:20', 'active', '/V/uploads/profile_image/profile.jpg'),
(43, 'Lakmali Chandrasekara', '$2y$10$AtflIL4Mgyp9GWrRsJJH7u2gE93OYnwKM7pGFsE33IqmE2BopBopy', 'v43@gmail.com', '0711000082', 'volunteer', '2026-04-09 21:23:53', 'active', '/V/uploads/profile_image/profile.jpg'),
(44, 'Malinga Gallage', '$2y$10$s47RfOQURKeAAMNp6/QMwuPjn4Kn3w3TNRmp4CAXuXgc.voY8IIlC', 'v44@gmail.com', '0711000083', 'volunteer', '2026-04-09 21:25:29', 'active', '/V/uploads/profile_image/profile.jpg'),
(45, 'Nethmi Sooriyaarachchi', '$2y$10$FUfTw6gwuVvXygxrWqWj7.1QSIVLGUkOsjbkV1NfzeEmVdkfyNj3.', 'v45@gmail.com', '0711000084', 'volunteer', '2026-04-09 21:27:18', 'active', '/V/uploads/profile_image/profile.jpg'),
(46, 'Oshan Abeyrathna', '$2y$10$i45jPikCy.s7H9XUFvBvA.nTLb0lzyU4QO5P0HWQbGuIstjZaLXBq', 'v46@gmail.com', '0711000085', 'volunteer', '2026-04-09 21:29:23', 'active', '/V/uploads/profile_image/profile.jpg'),
(47, 'Praveen Navaratnam', '$2y$10$qn8n3ZkqzMMv6nf9dzx1xekQBfQoaUbZ43DAZ5gdfcKNseUc93esS', 'v47@gmail.com', '0711000086', 'volunteer', '2026-04-09 21:30:50', 'active', '/V/uploads/profile_image/profile.jpg'),
(48, 'Ravindu Amarakoon', '$2y$10$tlADquUBYL39sDFYf1zQjuINe8gMZ3cp4EngfeM9NVVaj23ScEyxi', 'v48@gmail.com', '0711000088', 'volunteer', '2026-04-09 21:32:21', 'active', '/V/uploads/profile_image/profile.jpg'),
(49, 'Savini Premachandra', '$2y$10$hznYoImSdc6EZh1g.cVxQ..Zk5onQ.ziQDvtZ204K4rlKVqBtrSwK', 'v49@gmail.com', '0711000089', 'volunteer', '2026-04-09 21:34:02', 'active', '/V/uploads/profile_image/profile.jpg'),
(50, 'Uthpali Gunasekera', '$2y$10$pnTAlmg9tE3ZdiST2xBcnO5QTtqYmwPiyDz/DHMJIQENBcibNmwZC', 'v50@gmail.com', '0711000091', 'volunteer', '2026-04-09 21:37:06', 'active', '/V/uploads/profile_image/profile.jpg'),
(51, 'Vidusha Jayasena', '$2y$10$V3l.8J22jYgOd3BG9846jOWqW8fzRP/n/zkhP5XFa4GPd9tsusJJO', 'v51@gmail.com', '0711000092', 'volunteer', '2026-04-09 21:41:47', 'active', '/V/uploads/profile_image/profile.jpg'),
(52, 'Wathsala Mendis', '$2y$10$F80bkXYXyIqFsogm/Ev4uuPj2f3p/NBfVaitIYOqdKZIennSFzj1O', 'v52@gmail.com', '0711000093', 'volunteer', '2026-04-09 21:43:49', 'active', '/V/uploads/profile_image/profile.jpg'),
(53, 'Andrew Desilva', '$2y$10$US0fq7.R.d4R0VzqXdt7RuVR5/FsrvpvbwWalhhfUId2l8bxjjMh2', 'r53@gmail.com', '0711000023', 'volunteer', '2026-04-09 21:47:22', 'active', '/V/uploads/profile_image/profile.jpg'),
(54, 'Carlos Mendis', '$2y$10$LMG7FZYlQ9wsKyjrROzEDuTo3iJWSq4kIA7wV74MxtDShiTQ2aLYS', 'r54@gmail.com', '0711000025', 'representative', '2026-04-09 21:49:14', 'active', '/V/uploads/profile_image/profile.jpg'),
(55, 'Kevin Gunasekara', '$2y$10$zwaaJ1QW2F9LvKcvkV/DKe/xUFZACD7JtAx0I8ktNntDkbkvTm/HC', 'r55@gmail.com', '0711000026', 'representative', '2026-04-09 21:52:02', 'active', '/V/uploads/profile_image/profile.jpg'),
(56, 'Samadhi Weerasinghe', '$2y$10$.Fm9JFcPLeQmI0i41aEQSOEr1E3XYJTsufF7hYL9m3tJdsQrYRE7a', 'r56@gmail.com', '0711000027', 'volunteer', '2026-04-09 21:53:38', 'active', '/V/uploads/profile_image/profile.jpg'),
(57, 'Sameera Ranasinghe', '$2y$10$hKOLL9PRbCtk8r.gal7gxOoNzTU73bTE6OF9POHif74f8AULrtVCW', 'r57@gmail.com', '0711000029', 'volunteer', '2026-04-09 21:57:53', 'active', '/V/uploads/profile_image/profile.jpg'),
(58, 'Sewmini Dissanayake', '$2y$10$vdATeJP9pMETj3LAs67FJe0.q6.8n1bVUlcdwjtj41tLjvj7Sc9wC', 'r58@gmail.com', '0711000031', 'volunteer', '2026-04-09 22:34:53', 'active', '/V/uploads/profile_image/profile.jpg'),
(59, 'Sumudu Amarasinghe', '$2y$10$iyZB60o79BxSkycyx4ItN.F3Qxbw8BtYGc0aCssn2LfHjhrPUJLTe', 'r59@gmail.com', '0711000039', 'volunteer', '2026-04-09 22:38:04', 'active', '/V/uploads/profile_image/profile.jpg'),
(60, 'Bank of Ceylon', '$2y$10$kLYrRlfvNoU/n2y4UXLzhO9L91VOw.N.6qaN3sjv2ecgO5deEiM2e', 'boc@boc.lk', '011-22049', 'sponsor', '2026-04-16 02:38:54', 'active', '/V/uploads/profile_image/profile_60_1776287346.jpg'),
(61, 'SLT Mobitel', '$2y$10$T9iPQiP16G8h9pUG54j1iumcV0n8wWlSav5j7H7U6RXjRZWIPU78C', '1212@slt.com.lk', '0112 12 12', 'sponsor', '2026-04-16 02:41:45', 'active', '/V/uploads/profile_image/profile_61_1776287564.jpg'),
(62, 'KFC', '$2y$10$0oicSrdcQWak/YBHQ7tsl.zhjHuH8EbiRdI1PbIrp1V5T4x8MeJlG', 'kfc@gmail.com', '0112 427 7', 'sponsor', '2026-04-16 02:45:53', 'active', '/V/uploads/profile_image/profile_62_1776287763.png'),
(63, 'Daily Mirror', '$2y$10$hZd1ggJh.Gbd2bQIzsSrv.EGvZHSzhUw4DLyhzQxsR4hhyHdXS/fK', 'dailymirror@gmail.com', '0112479356', 'sponsor', '2026-04-16 02:51:13', 'active', '/V/uploads/profile_image/profile_63_1776288082.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

DROP TABLE IF EXISTS `volunteer`;
CREATE TABLE IF NOT EXISTS `volunteer` (
  `userid` int NOT NULL,
  `levelpoints` int DEFAULT '0',
  `starpoints` int DEFAULT '0',
  `noofmembers` int DEFAULT '1',
  `dob` date DEFAULT NULL,
  `QR` varchar(255) DEFAULT NULL,
  `volunteer_experience` text,
  `preferred_location_1` varchar(100) DEFAULT NULL,
  `preferred_location_2` varchar(100) DEFAULT NULL,
  `preferred_location_3` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`userid`, `levelpoints`, `starpoints`, `noofmembers`, `dob`, `QR`, `volunteer_experience`, `preferred_location_1`, `preferred_location_2`, `preferred_location_3`) VALUES
(1, 15, 30, 1, '2004-02-16', NULL, 'I volunteered at an animal shelter in middle school.\r\nAlso I have volunteered in numerous beach cleanups organized by the pearl protectors.', 'Colombo', 'Galle', 'Matara'),
(5, 4, 30, 1, '2003-09-20', NULL, 'Managed registrations and guided participants in a tree planting initiative', 'Gampaha', 'Kandy', 'Galle'),
(6, 60, 30, 1, '2003-01-24', NULL, 'Helped distribute supplies and dry rations during 2025 floods', 'Matara', 'Galle', 'Hambantota'),
(7, 55, 28, 1, '2000-03-15', NULL, 'I have had 2 years of beach cleanup experience', 'Colombo', 'Galle', 'Kandy'),
(8, 124, 67, 1, '1998-04-12', NULL, 'Assisted in mangrove planting and coastal restoration programs through local environmental initiatives in Sri Lanka.', 'Batticaloa', 'Trincomalee', 'Vavuniya'),
(9, 197, 130, 1, '2000-07-23', NULL, 'Participated in environmental projects and cleanups coordinated through Volunteers Global initiatives in Sri Lanka.', 'Anuradhapura', 'Polonnaruwa', 'Kurunegala'),
(10, 95, 48, 1, '1995-11-05', NULL, 'Contributed to river and canal cleanup activities along the Kaleni River.', 'Colombo', 'Kalutara', 'Matale'),
(11, 127, 64, 1, '2002-03-18', NULL, 'Volunteered in recycling and waste segregation programs organized by Colombo Municipal Council.', 'Colombo', 'Gampaha', 'Kalutara'),
(12, 106, 53, 1, '1990-09-30', NULL, 'Contributed to mangrove restoration projects in the Negombo Lagoon.', 'Mannar', 'Kalutara', 'Colombo'),
(13, 88, 44, 1, '1997-06-14', NULL, 'Volunteered with Biodiversity Sri Lanka, assisting in environmental sustainability projects.', 'Puttalam', 'Kurunegala', 'Matale'),
(14, 122, 61, 1, '2001-01-28', NULL, 'Participated in community-based environmental programs organized by Sarvodaya Shramadana Movement, including village cleanups and sustainability efforts.', 'Nuwara Eliya', 'Badulla', 'Monaragala'),
(15, 145, 73, 1, '1998-12-10', NULL, 'Volunteered with ZeroPlastic Movement, participating in campaigns to reduce single-use plastics and promote sustainable alternatives.', 'Hambantota', 'Monaragala', 'Ampara'),
(16, 180, 91, 1, '2003-08-02', NULL, 'Participated in climate awareness and youth engagement programs with Sri Lanka Youth Climate Network.', 'Jaffna', 'Mullaitivu', 'Vavuniya'),
(17, 137, 67, 1, '1994-05-19', NULL, 'Contributed to sustainable agriculture and environmental education projects with Gami Seva Sevana.', 'Ratnapura', 'Kegalle', 'Kalutara'),
(18, 133, 67, 1, '1999-10-07', NULL, 'Volunteered with Marine Environment Protection Authority, assisting in coastal conservation efforts.', 'Hambantota', 'Matara', 'Galle'),
(19, 34, 17, 1, '2002-02-14', NULL, 'Participated in ecosystem restoration and sustainability initiatives with Forest Department Sri Lanka.', 'Kegalle', 'Kurunegala', 'Kandy'),
(20, 132, 66, 1, '1991-01-27', NULL, 'Assisted in environmental awareness and sustainability projects with United Nations Development Program.', 'Trincomalee', 'Kurunegala', 'Anuradhapura'),
(21, 85, 43, 1, '1998-09-03', NULL, 'Contributed to grassroots environmental and community development programs with Sevalanka Foundation.', 'Polonnaruwa', 'Anuradhapura', 'Batticaloa'),
(22, 126, 63, 1, '2000-06-10', NULL, 'Volunteered with Earthwatch Institute Sri Lanka, assisting in environmental monitoring and data collection.', 'Colombo', 'Gampaha', 'Kandy'),
(23, 93, 47, 1, '1998-10-25', NULL, 'Participated in environmental education and youth-led conservation with Global Shapers Colombo Hub.', 'Kurunegala', 'Anuradhapura', 'Kandy'),
(24, 47, 24, 1, '2003-02-16', NULL, 'Assisted in reforestation and ecological restoration with Sri Lanka Army Environmental Unit.', 'Kegalle', 'Badulla', 'Ratnapura'),
(25, 0, 0, 1, '2004-12-02', NULL, 'Assisted in community-based environmental initiatives with National Youth Services Council.', 'Anuradhapura', 'Ampara', 'Mannar'),
(26, 54, 27, 1, '2000-02-16', NULL, 'Participated in sustainable tourism and conservation projects with Sri Lanka Tourism Development Authority.', 'Ampara', 'Galle', 'Matara'),
(27, 57, 29, 1, '2000-04-05', NULL, 'Volunteered with Rotaract Clubs of Sri Lanka, organizing environmental cleanups and green initiatives.', 'Kandy', 'Matale', 'Nuwara Eliya'),
(28, 0, 0, 1, '1998-04-11', NULL, 'Assisted in school-level environmental programs with Sri Lanka Scout Association.', 'Ampara', 'Mullaitivu', 'Badulla'),
(29, 0, 0, 1, '2001-04-30', NULL, 'Participated in environmental and community service initiatives with Leo Clubs Sri Lanka.', 'Mannar', 'Galle', 'Nuwara Eliya'),
(30, 44, 22, 1, '1997-04-28', NULL, 'Contributed to conservation awareness and community outreach with Young Biologists Association of Sri Lanka.', 'Ratnapura', 'Nuwara Eliya', 'Hambantota'),
(31, 41, 20, 1, '1995-04-30', NULL, 'Volunteered with Central Environmental Authority, assisting in environmental monitoring and public awareness campaigns.', 'Hambantota', 'Matale', 'Kandy'),
(32, 44, 22, 1, '1994-05-02', NULL, 'Participated in conservation and education initiatives with National Zoological Gardens Sri Lanka, promoting wildlife protection.', 'Ampara', 'Anuradhapura', 'Vavuniya'),
(33, 40, 20, 1, '1990-01-04', NULL, 'Volunteered with Sri Lanka Unites, supporting environmental and community development projects.', 'Hambantota', 'Batticaloa', 'Ampara'),
(34, 35, 18, 1, '2000-02-02', NULL, 'Participated in environmental awareness and cleanup drives with Sri Lanka Navy coastal conservation programs.', 'Batticaloa', 'Galle', 'Matale'),
(35, 0, 0, 1, '1998-04-21', NULL, 'Contributed to ecosystem restoration and community outreach with Community Development Services.', 'Gampaha', 'Kandy', 'Nuwara Eliya'),
(36, 0, 0, 1, '2001-04-09', NULL, 'Participated in school and community environmental initiatives with Green Clubs Sri Lanka.', 'Vavuniya', 'Ampara', 'Badulla'),
(37, 0, 0, 1, '2001-01-01', NULL, 'Contributed to conservation education and outreach with Open University of Sri Lanka Environmental Club.', 'Anuradhapura', 'Mannar', 'Colombo'),
(38, 76, 38, 1, '1997-02-02', NULL, 'Assisted in local conservation and awareness efforts with Wildlife Circle of Sri Lanka.', 'Jaffna', 'Hambantota', 'Matara'),
(39, 0, 0, 1, '1997-04-04', NULL, 'Volunteered with Centre for Sustainability Sri Lanka, assisting in community sustainability and awareness projects.', 'Vavuniya', 'Galle', 'Matale'),
(40, 65, 33, 1, '2004-12-12', NULL, 'Assisted in environmental education and outreach with Eco Schools Sri Lanka.', 'Anuradhapura', 'Mannar', 'Galle'),
(41, 46, 23, 1, '2004-03-01', NULL, 'Volunteered with Hemas Outreach Foundation, supporting environmental and community projects.', 'Trincomalee', 'Kegalle', 'Monaragala'),
(42, 61, 31, 1, '1990-06-06', NULL, 'Volunteered with Sri Lanka Land Reclamation and Development Corporation, assisting in wetland restoration and flood mitigation projects.', 'Kegalle', 'Ratnapura', 'Puttalam'),
(43, 0, 0, 1, '2003-07-08', NULL, 'Participated in agroforestry and sustainable farming initiatives with Department of Agriculture Sri Lanka.', 'Mullaitivu', 'Galle', 'Matale'),
(44, 0, 0, 1, '1999-09-25', NULL, 'Assisted in environmental journalism and awareness campaigns with Groundviews sustainability initiative.', 'Galle', 'Nuwara Eliya', 'Vavuniya'),
(45, 0, 0, 1, '2003-12-15', NULL, 'Contributed to railway-side and public space cleanup drives with Sri Lanka Railways.', 'Anuradhapura', 'Jaffna', 'Trincomalee'),
(46, 0, 0, 1, '2004-11-11', NULL, 'Assisted in community water conservation and sanitation initiatives with National Water Supply and Drainage Board.', 'Matara', 'Trincomalee', 'Badulla'),
(47, 0, 0, 1, '2001-05-05', NULL, 'Contributed to sustainable transport and environmental awareness campaigns with Road Development Authority Sri Lanka.', 'Kegalle', 'Matara', 'Polonnaruwa'),
(48, 0, 0, 1, '2000-10-10', NULL, 'Assisted in environmental outreach and eco-awareness programs with Sri Lanka Broadcasting Corporation.', 'Monaragala', 'Badulla', 'Kegalle'),
(49, 61, 31, 1, '2003-03-03', NULL, 'Participated in community-based environmental and disaster resilience programs with Disaster Management Centre Sri Lanka.', 'Ratnapura', 'Kegalle', 'Monaragala'),
(50, 69, 34, 1, '2000-01-31', NULL, 'Volunteered with Sri Lanka Inventors Commission, supporting eco-innovation and sustainable technology.', 'Ratnapura', 'Puttalam', 'Kurunegala'),
(51, 65, 33, 1, '1990-04-30', NULL, 'Volunteered with Sri Lanka Institute of Nanotechnology, supporting research on sustainable materials and environmental applications.', 'Ratnapura', 'Badulla', 'Puttalam'),
(52, 69, 34, 1, '2000-12-15', NULL, 'Participated in sustainable agriculture awareness with National Institute of Post-Harvest Management.', 'Kegalle', 'Puttalam', 'Kurunegala'),
(53, 65, 33, 1, '2000-06-06', NULL, 'Contributed to eco-conscious public programs with Sri Lanka Telecom.', 'Badulla', 'Ratnapura', 'Kegalle'),
(54, 76, 38, 1, '2003-03-23', NULL, 'Assisted in marine conservation awareness and coastal protection with Sri Lanka Ports Authority.', 'Ratnapura', 'Puttalam', 'Monaragala'),
(55, 39, 19, 1, '2000-10-22', NULL, 'Contributed to environmental data collection and climate research with University of Peradeniya Environmental Unit.', 'Ampara', 'Jaffna', 'Badulla'),
(56, 39, 19, 1, '1990-07-07', NULL, 'Assisted in environmental awareness campaigns with Sri Lanka Insurance Corporation.', 'Kegalle', 'Ratnapura', 'Puttalam'),
(57, 80, 40, 1, '1995-01-27', NULL, 'Contributed to environmental journalism and public awareness with Sri Lanka Press Institute.', 'Badulla', 'Ratnapura', 'Kegalle'),
(58, 80, 40, 1, '2000-06-28', NULL, 'Volunteered with Forest Department Sri Lanka, supporting forest conservation and reforestation initiatives.', 'Ampara', 'Batticaloa', 'Colombo'),
(59, 80, 40, 1, '1990-01-15', NULL, 'Participated in sustainable agriculture and soil conservation programs with the Department of Agriculture.', 'Anuradhapura', 'Polonnaruwa', 'Gampaha');

-- --------------------------------------------------------

--
-- Table structure for table `volunteering_program`
--

DROP TABLE IF EXISTS `volunteering_program`;
CREATE TABLE IF NOT EXISTS `volunteering_program` (
  `event_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `event_type` varchar(50) NOT NULL,
  `isauthorized` tinyint(1) DEFAULT NULL,
  `state_of_event` varchar(50) DEFAULT 'planned',
  `is_annual` tinyint(1) DEFAULT '0',
  `starpoints_reward` int DEFAULT '0',
  `levelpoints_reward` int DEFAULT '0',
  `event_date` date NOT NULL,
  `time` time DEFAULT '07:00:00',
  `location` varchar(200) DEFAULT NULL,
  `gmap_link` varchar(500) DEFAULT NULL,
  `scale` varchar(50) DEFAULT NULL,
  `allocated_budget` int DEFAULT NULL,
  `max_participants` int DEFAULT NULL,
  `current_participants` int DEFAULT '0',
  `organizer_id` int NOT NULL,
  `createddate` datetime DEFAULT CURRENT_TIMESTAMP,
  `duration` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `peer_rating_open_until` datetime DEFAULT NULL,
  `points_processed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`event_id`),
  KEY `organizer_id` (`organizer_id`)
) ;

--
-- Dumping data for table `volunteering_program`
--

INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(1, 'Beach Cleanup - Unawatuna', 'Remove plastic waste along Unawatuna beach stretch.', 'Beach Cleanup', 1, 'planned', 0, 50, 75, '2026-04-30', '07:00:00', 'Unawatuna', 'https://www.google.com/maps?q=6.007601687776796,80.25130565747912', 'small', 12000, 30, 29, 3, '2026-04-09 17:03:36', '5', 0, NULL, 0),
(2, 'Sri Pada Cleanup - 2026', 'Clean the Sri Pada trail from the Kuruwita Entrance.', 'Mountain Cleanup', 1, 'planned', 1, 100, 150, '2026-05-04', '07:00:00', 'Sri Pada - Kuruwita', 'https://www.google.com/maps?q=6.839321732100847,80.42912190292844', 'large', 73500, 150, 46, 3, '2026-04-09 17:11:09', '12', 0, NULL, 0),
(3, 'Coral Restoration', 'Restore the coral reefs along the Nilaveli Beach.', 'Coral Restoration', 1, 'completed', 0, 25, 50, '2026-04-12', '07:00:00', 'Nilaveli', 'https://www.google.com/maps?q=8.69921710287419,81.19247092119605', 'small', 21000, 15, 15, 3, '2026-04-09 17:14:06', '6', 0, '2026-04-19 00:00:00', 1),
(4, 'Seruwawila Mangrove Restoration', 'Help us restore and enhance the mangrove forests in the Seruwawila lagoon.', 'Mangrove Restoration', 1, 'completed', 0, 40, 80, '2026-04-09', '14:30:00', 'Seruwawila', 'https://www.google.com/maps?q=8.386168988007087,81.35024066833087', 'medium', 12600, 45, 42, 3, '2026-04-09 17:20:45', '5', 0, '2026-04-16 00:00:00', 1),
(5, 'Tree Planting Event - Hanthana', 'Help us reforest the hanthana mountain range damaged dure to forest fires.', 'Tree Planting', 1, 'completed', 0, 45, 90, '2026-04-09', '08:00:00', 'Hanthana - Kandy', 'https://www.google.com/maps?q=7.249068550351769,80.62711715698242', 'small', 15500, 20, 19, 5, '2026-04-09 23:39:39', '7', 0, '2026-04-16 00:00:00', 1),
(6, 'Annual City Cleanup', 'Help us take our streets back to cleanliness devoid of polythene pollutants.', 'City Cleanup', 1, 'planned', 1, 60, 120, '2026-05-30', '08:00:00', 'Colombo', '', 'large', 55000, 100, 31, 3, '2026-04-09 23:43:17', '12', 0, NULL, 0),
(7, 'Annual Beach Cleanup 2026', 'Help us clean the costal regions of Mannar to remove plastic pollutants from these pristine beaches.', 'Beach Cleanup', 0, 'planned', 1, 75, 140, '2026-06-01', '08:00:00', 'Mannar', 'https://www.google.com/maps?q=8.980447839707592,79.98934321546508', 'large', 55000, 100, 0, 3, '2026-04-09 23:56:12', '12', 0, NULL, 0),
(8, 'Annual Tree Planting 2026', 'Help us reclaim our rainforests and preserve these important ecosystems for the future.', 'Tree Planting', NULL, 'planned', 1, 80, 160, '2026-04-28', '10:00:00', 'Sinharaja Forest Reserve', 'https://www.google.com/maps?q=6.390906627702152,80.36198514497032', 'large', 47250, 90, 0, 3, '2026-04-10 00:00:16', '10', 0, NULL, 0),
(10, 'Tree Planting - Wilpattu Forest', 'Help us recover the deforested land due to logging operations.', 'Tree Planting', NULL, 'completed', 0, 50, 80, '2026-04-11', '08:00:00', 'Wilpattu National Park', 'https://www.google.com/maps?q=8.316218284723483,80.23055303844066', 'small', 17000, 20, 0, 5, '2026-04-10 01:10:26', '6', 0, '2026-04-18 00:00:00', 0),
(9, 'Tree Planting - Intercity', 'Help us regreen Maharagama City by incorporating foliage into the sidewalks.', 'Tree Planting', 1, 'completed', 0, 30, 60, '2026-04-10', '08:00:00', 'Maharagama City', 'https://www.google.com/maps?q=6.846446904140235,79.92843848844268', 'small', 4000, 12, 12, 5, '2026-04-10 00:19:50', '5', 0, '2026-04-17 00:00:00', 0),
(11, 'Gampola City Cleanup', 'Help us remove polythene waste from the streets of gampola.', 'City Cleanup', 1, 'completed', 0, 40, 80, '2026-04-10', '08:00:00', 'Gampola', 'https://www.google.com/maps?q=7.159882033571255,80.5661687521241', 'small', 4800, 12, 12, 3, '2026-04-10 08:21:55', '4', 0, '2026-04-17 00:00:00', 0),
(12, 'Coastal Revival: Mount Lavinia', 'Join us in restoring the beauty of Mount Lavinia beach by removing plastic waste and protecting marine life.', 'Beach Cleanup', 1, 'completed', 0, 55, 75, '2026-04-12', '09:00:00', 'Mount Lavinia', 'https://www.google.com/maps?q=7.239795540411543,79.84125435389834', 'medium', 16000, 40, 2, 3, '2026-04-12 15:49:46', '6', 0, '2026-04-19 00:00:00', 1),
(13, 'City Cleanup Kottawa', 'Help us clean the streets of Kottawa.', 'City Cleanup', 1, 'completed', 0, 25, 50, '2026-04-15', '06:00:00', 'Kottawa', 'https://www.google.com/maps?q=6.841558041666281,79.96465705131651', 'small', 8000, 20, 0, 5, '2026-04-12 17:41:51', '5', 0, '2026-04-22 00:00:00', 0),
(14, 'Community Clean - Maharagama', 'Help us clean the streets of Maharagama and make them polythene free.', 'City Cleanup', 1, 'planned', 1, 55, 100, '2026-04-20', '06:00:00', 'Maharagama', 'https://www.google.com/maps?q=6.848881264599564,79.92488394617419', 'large', 80000, 100, 0, 3, '2026-04-12 18:20:41', '8', 0, NULL, 0),
(15, 'Annual Tree Planting', 'Help us regreen the town of Ella and surrounding areas.', 'Tree Planting', NULL, 'completed', 1, 35, 70, '2026-04-13', '06:00:00', 'Ella', 'https://www.google.com/maps?q=6.888664950390668,81.04153660526644', 'large', 60000, 100, 0, 3, '2026-04-12 18:29:55', '8', 0, '2026-04-20 00:00:00', 0),
(16, 'Coral Restoration- Weligama', 'Help us regreen the ocean floor', 'Coral Restoration', 1, 'completed', 0, 5, 10, '2026-04-12', '14:00:00', 'Weligama', 'https://www.google.com/maps?q=5.973156201975434,80.4357660731263', 'small', 3000, 3, 3, 3, '2026-04-13 00:55:39', '12', 0, '2026-04-19 00:00:00', 1),
(17, 'Kottawa Tree Planting', 'Help us plant some saplings along the sidewalk of the kottawa bus stand', 'Tree Planting', 1, 'completed', 0, 10, 10, '2026-04-12', '08:00:00', 'Kottawa', 'https://www.google.com/maps?q=6.841718556092818,79.96509014511614', 'small', 300, 3, 3, 3, '2026-04-13 01:59:51', '2', 0, '2026-04-19 00:00:00', 1),
(18, 'Restore Mangroves Mannar', 'Help us recultivate the mangrove populations across the Mannar Coastline', 'Mangrove Restoration', 1, 'completed', 0, 30, 60, '2026-04-13', '08:00:00', 'Mannar', 'https://www.google.com/maps?q=8.97077106620987,79.90058237516463', 'small', 7400, 15, 12, 3, '2026-04-13 13:26:02', '3', 0, '2026-04-20 00:00:00', 0),
(19, 'Cleaner City - Kottawa', 'A small scale initiative to leisurely help clean the town of Kottawa.', 'City Cleanup', 1, 'completed', 0, 10, 20, '2026-04-13', '15:00:00', 'Kottawa', 'https://www.google.com/maps?q=6.841668886875638,79.96473553159555', 'small', 1000, 5, 0, 3, '2026-04-13 17:30:32', '3', 0, '2026-04-20 00:00:00', 0),
(20, 'Mangrove Restoration- Puttalam', 'A small Mangrove Restoration Event', 'Mangrove Restoration', 1, 'completed', 0, 12, 24, '2026-04-14', '10:00:00', 'Puttalam', 'https://www.google.com/maps?q=8.00859855845978,79.82839108751472', 'small', 1000, 10, 3, 3, '2026-04-14 09:08:52', '3', 0, '2026-04-21 00:00:00', 0),
(21, 'Horton Plains Cleanup', 'Help us clean up the plains and make them devoid of polythene.', 'Mountain Cleanup', 1, 'completed', 0, 25, 50, '2026-04-14', '12:00:00', 'Horton Plains', 'https://www.google.com/maps?q=6.817089810752076,80.80629633576116', 'small', 16000, 15, 0, 5, '2026-04-14 12:14:30', '6', 0, '2026-04-21 00:00:00', 0),
(22, 'National Tree Planting Day', 'Help us Regrow our burnt forests in the areas surrounding the Army Camp', 'Tree Planting', 1, 'planned', 1, 60, 100, '2026-04-20', '08:00:00', 'Diyathalawa Army Camp', 'https://www.google.com/maps/search/?api=1&query=6.80648666230706,80.94520568847656', 'large', 44800, 80, 0, 3, '2026-04-16 03:04:40', '6', 0, NULL, 0),
(23, 'World Coral Day Project', 'Help us regrow our sea-forests for the world coral day', 'Coral Restoration', 1, 'planned', 1, 45, 80, '2026-04-22', '11:00:00', 'Yala ', 'https://www.google.com/maps/search/?api=1&query=6.351726564342437,81.5087155488289', 'medium', 42000, 30, 0, 3, '2026-04-16 03:09:00', '5', 0, NULL, 0),
(24, 'World Mangrove Day', 'Help us plant mangroves along the kalu ganga.', 'Mangrove Restoration', 1, 'planned', 1, 45, 90, '2026-05-09', '16:00:00', 'Kalutara', 'https://www.google.com/maps/search/?api=1&query=6.607976017006803,79.97721904359071', 'small', 7000, 20, 0, 3, '2026-04-16 03:31:21', '5', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_availability`
--

DROP TABLE IF EXISTS `volunteer_availability`;
CREATE TABLE IF NOT EXISTS `volunteer_availability` (
  `userid` int NOT NULL,
  `availability` varchar(100) NOT NULL,
  PRIMARY KEY (`userid`,`availability`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `volunteer_availability`
--

INSERT INTO `volunteer_availability` (`userid`, `availability`) VALUES
(1, 'Fri-Afternoon'),
(1, 'Sat-Afternoon'),
(1, 'Sat-Evening'),
(1, 'Sat-Morning'),
(1, 'Sun-Afternoon'),
(1, 'Sun-Evening'),
(1, 'Sun-Morning'),
(1, 'Thu-Evening'),
(1, 'Tue-Evening'),
(5, 'Mon-Evening'),
(5, 'Sat-Afternoon'),
(5, 'Sat-Evening'),
(5, 'Sun-Evening'),
(5, 'Thu-Afternoon'),
(5, 'Tue-Afternoon'),
(6, 'Fri-Evening'),
(6, 'Mon-Evening'),
(6, 'Sun-Afternoon'),
(6, 'Sun-Evening'),
(6, 'Thu-Evening'),
(6, 'Tue-Afternoon'),
(8, 'Fri-Evening'),
(8, 'Mon-Evening'),
(8, 'Sat-Evening'),
(8, 'Sun-Evening'),
(8, 'Tue-Evening'),
(9, 'Sat-Evening'),
(9, 'Sun-Evening'),
(10, 'Mon-Afternoon'),
(10, 'Mon-Evening'),
(10, 'Mon-Morning'),
(10, 'Tue-Afternoon'),
(10, 'Tue-Evening'),
(10, 'Tue-Morning'),
(11, 'Fri-Evening'),
(11, 'Sat-Evening'),
(11, 'Sun-Evening'),
(11, 'Thu-Evening'),
(12, 'Sat-Evening'),
(12, 'Sat-Morning'),
(12, 'Sun-Evening'),
(12, 'Sun-Morning'),
(13, 'Fri-Evening'),
(13, 'Sat-Afternoon'),
(13, 'Sat-Evening'),
(13, 'Sat-Morning'),
(13, 'Thu-Evening'),
(14, 'Mon-Afternoon'),
(14, 'Mon-Evening'),
(14, 'Mon-Morning'),
(15, 'Mon-Afternoon'),
(15, 'Mon-Evening'),
(15, 'Mon-Morning'),
(15, 'Tue-Afternoon'),
(15, 'Wed-Afternoon'),
(15, 'Wed-Evening'),
(15, 'Wed-Morning'),
(16, 'Fri-Evening'),
(16, 'Thu-Evening'),
(16, 'Wed-Evening'),
(17, 'Mon-Evening'),
(17, 'Tue-Afternoon'),
(17, 'Tue-Evening'),
(17, 'Tue-Morning'),
(17, 'Wed-Evening'),
(18, 'Fri-Morning'),
(18, 'Sat-Morning'),
(18, 'Sun-Morning'),
(19, 'Fri-Afternoon'),
(19, 'Fri-Evening'),
(19, 'Fri-Morning'),
(19, 'Sat-Afternoon'),
(19, 'Tue-Afternoon'),
(19, 'Tue-Evening'),
(19, 'Tue-Morning'),
(20, 'Fri-Morning'),
(20, 'Mon-Afternoon'),
(20, 'Mon-Morning'),
(20, 'Thu-Morning'),
(21, 'Mon-Afternoon'),
(21, 'Mon-Evening'),
(21, 'Tue-Evening'),
(22, 'Sat-Afternoon'),
(22, 'Sat-Evening'),
(22, 'Sat-Morning'),
(22, 'Sun-Afternoon'),
(22, 'Sun-Evening'),
(22, 'Sun-Morning'),
(23, 'Mon-Afternoon'),
(23, 'Mon-Morning'),
(23, 'Tue-Afternoon'),
(23, 'Tue-Morning'),
(23, 'Wed-Afternoon'),
(23, 'Wed-Morning'),
(24, 'Fri-Afternoon'),
(24, 'Fri-Evening'),
(24, 'Fri-Morning'),
(24, 'Thu-Afternoon'),
(24, 'Thu-Evening'),
(24, 'Thu-Morning'),
(25, 'Mon-Afternoon'),
(25, 'Mon-Evening'),
(25, 'Mon-Morning'),
(26, 'Mon-Afternoon'),
(26, 'Mon-Morning'),
(26, 'Thu-Afternoon'),
(26, 'Thu-Evening'),
(26, 'Thu-Morning'),
(27, 'Sat-Afternoon'),
(27, 'Sat-Morning'),
(27, 'Sun-Afternoon'),
(27, 'Wed-Afternoon'),
(27, 'Wed-Evening'),
(27, 'Wed-Morning'),
(28, 'Sun-Afternoon'),
(28, 'Sun-Evening'),
(29, 'Fri-Afternoon'),
(29, 'Fri-Evening'),
(29, 'Sun-Afternoon'),
(29, 'Sun-Evening'),
(30, 'Mon-Afternoon'),
(30, 'Mon-Morning'),
(30, 'Sat-Afternoon'),
(30, 'Sun-Evening'),
(30, 'Wed-Afternoon'),
(30, 'Wed-Evening'),
(31, 'Sun-Afternoon'),
(31, 'Sun-Evening'),
(31, 'Sun-Morning'),
(32, 'Fri-Morning'),
(32, 'Sat-Morning'),
(32, 'Sun-Morning'),
(32, 'Thu-Morning'),
(33, 'Fri-Evening'),
(33, 'Sat-Afternoon'),
(33, 'Sat-Evening'),
(33, 'Sun-Evening'),
(34, 'Mon-Morning'),
(34, 'Thu-Evening'),
(34, 'Tue-Afternoon'),
(34, 'Tue-Evening'),
(34, 'Tue-Morning'),
(34, 'Wed-Evening'),
(35, 'Fri-Afternoon'),
(35, 'Fri-Evening'),
(35, 'Sat-Afternoon'),
(35, 'Sat-Evening'),
(35, 'Sun-Afternoon'),
(35, 'Sun-Evening'),
(36, 'Thu-Afternoon'),
(36, 'Thu-Evening'),
(36, 'Thu-Morning'),
(36, 'Wed-Afternoon'),
(36, 'Wed-Evening'),
(36, 'Wed-Morning'),
(37, 'Sat-Evening'),
(37, 'Tue-Morning'),
(38, 'Fri-Afternoon'),
(38, 'Sat-Afternoon'),
(38, 'Sat-Evening'),
(38, 'Thu-Afternoon'),
(38, 'Thu-Evening'),
(39, 'Sat-Evening'),
(39, 'Sun-Evening'),
(39, 'Wed-Evening'),
(40, 'Sun-Afternoon'),
(40, 'Sun-Evening'),
(40, 'Sun-Morning'),
(41, 'Mon-Afternoon'),
(41, 'Mon-Evening'),
(41, 'Mon-Morning'),
(41, 'Tue-Afternoon'),
(41, 'Tue-Evening'),
(41, 'Tue-Morning'),
(41, 'Wed-Afternoon'),
(41, 'Wed-Evening'),
(41, 'Wed-Morning'),
(42, 'Sat-Afternoon'),
(42, 'Sat-Evening'),
(42, 'Sun-Afternoon'),
(42, 'Sun-Evening'),
(42, 'Sun-Morning'),
(43, 'Sat-Afternoon'),
(43, 'Sat-Morning'),
(43, 'Sun-Afternoon'),
(43, 'Sun-Morning'),
(44, 'Mon-Afternoon'),
(44, 'Tue-Afternoon'),
(44, 'Tue-Evening'),
(45, 'Fri-Morning'),
(45, 'Sat-Morning'),
(45, 'Sun-Morning'),
(45, 'Tue-Morning'),
(46, 'Sat-Afternoon'),
(46, 'Sat-Morning'),
(46, 'Sun-Afternoon'),
(46, 'Sun-Evening'),
(46, 'Sun-Morning'),
(47, 'Fri-Morning'),
(47, 'Sat-Afternoon'),
(47, 'Sun-Afternoon'),
(47, 'Sun-Evening'),
(48, 'Fri-Evening'),
(48, 'Thu-Evening'),
(48, 'Tue-Afternoon'),
(48, 'Tue-Evening'),
(48, 'Wed-Evening'),
(49, 'Mon-Afternoon'),
(49, 'Mon-Evening'),
(49, 'Mon-Morning'),
(50, 'Fri-Afternoon'),
(50, 'Fri-Morning'),
(50, 'Sat-Afternoon'),
(50, 'Sat-Morning'),
(50, 'Sun-Afternoon'),
(50, 'Sun-Morning'),
(51, 'Sat-Afternoon'),
(51, 'Sat-Morning'),
(51, 'Sun-Afternoon'),
(51, 'Sun-Evening'),
(51, 'Sun-Morning'),
(52, 'Sun-Afternoon'),
(52, 'Sun-Evening'),
(52, 'Sun-Morning'),
(52, 'Thu-Afternoon'),
(52, 'Thu-Morning'),
(52, 'Wed-Afternoon'),
(52, 'Wed-Morning'),
(53, 'Mon-Afternoon'),
(53, 'Mon-Evening'),
(53, 'Thu-Evening'),
(53, 'Tue-Evening'),
(53, 'Wed-Evening'),
(54, 'Sat-Evening'),
(54, 'Thu-Afternoon'),
(54, 'Thu-Morning'),
(54, 'Wed-Afternoon'),
(54, 'Wed-Morning'),
(55, 'Mon-Afternoon'),
(55, 'Mon-Evening'),
(55, 'Mon-Morning'),
(55, 'Tue-Afternoon'),
(55, 'Tue-Morning'),
(56, 'Fri-Afternoon'),
(56, 'Sat-Afternoon'),
(56, 'Sun-Evening'),
(56, 'Thu-Afternoon'),
(56, 'Thu-Evening'),
(57, 'Fri-Afternoon'),
(57, 'Fri-Evening'),
(57, 'Fri-Morning'),
(57, 'Thu-Afternoon'),
(57, 'Thu-Evening'),
(57, 'Thu-Morning'),
(57, 'Tue-Afternoon'),
(58, 'Mon-Afternoon'),
(58, 'Mon-Evening'),
(58, 'Mon-Morning'),
(58, 'Tue-Afternoon'),
(59, 'Mon-Afternoon'),
(59, 'Mon-Evening'),
(59, 'Sat-Afternoon'),
(59, 'Sat-Evening'),
(59, 'Sat-Morning'),
(59, 'Sun-Evening'),
(59, 'Tue-Evening');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_badge`
--

DROP TABLE IF EXISTS `volunteer_badge`;
CREATE TABLE IF NOT EXISTS `volunteer_badge` (
  `badge_id` int NOT NULL AUTO_INCREMENT,
  `userid` int NOT NULL,
  `badgeearned` varchar(100) NOT NULL,
  `earneddate` date DEFAULT (curdate()),
  PRIMARY KEY (`badge_id`),
  KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_disability`
--

DROP TABLE IF EXISTS `volunteer_disability`;
CREATE TABLE IF NOT EXISTS `volunteer_disability` (
  `userid` int NOT NULL,
  `disability` varchar(100) NOT NULL,
  PRIMARY KEY (`userid`,`disability`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_leave_history`
--

DROP TABLE IF EXISTS `volunteer_leave_history`;
CREATE TABLE IF NOT EXISTS `volunteer_leave_history` (
  `leave_id` int NOT NULL AUTO_INCREMENT,
  `volunteer_id` int NOT NULL,
  `event_id` int NOT NULL,
  `leave_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `days_before_event` int NOT NULL,
  `level_points_lost` int DEFAULT '0',
  `star_points_lost` int DEFAULT '0',
  `reason` text,
  PRIMARY KEY (`leave_id`),
  KEY `volunteer_id` (`volunteer_id`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `volunteer_leave_history`
--

INSERT INTO `volunteer_leave_history` (`leave_id`, `volunteer_id`, `event_id`, `leave_date`, `days_before_event`, `level_points_lost`, `star_points_lost`, `reason`) VALUES
(1, 1, 13, '2026-04-12 18:47:29', 3, 14, 0, 'Voluntary withdrawal'),
(2, 1, 13, '2026-04-12 18:47:55', 3, 14, 0, 'Voluntary withdrawal'),
(3, 1, 13, '2026-04-12 18:49:28', 3, 14, 0, 'Voluntary withdrawal'),
(4, 5, 14, '2026-04-13 18:57:06', 7, 23, 0, 'Voluntary withdrawal'),
(5, 5, 14, '2026-04-13 18:57:47', 7, 23, 0, 'Voluntary withdrawal'),
(6, 5, 1, '2026-04-13 19:01:50', 17, 10, 0, 'Voluntary withdrawal');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_skill`
--

DROP TABLE IF EXISTS `volunteer_skill`;
CREATE TABLE IF NOT EXISTS `volunteer_skill` (
  `userid` int NOT NULL,
  `skill` varchar(100) NOT NULL,
  PRIMARY KEY (`userid`,`skill`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
