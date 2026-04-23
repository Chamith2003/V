-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 16, 2026 at 05:00 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

CREATE DATABASE IF NOT EXISTS demo;
USE demo;



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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `announcement`
-- Nothing
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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `annual_event_approvals`
--

INSERT INTO `annual_event_approvals` (`approval_id`, `event_id`, `approver_id`, `approval_status`, `approval_date`) VALUES
-- Event 2: Sri Pada Cleanup - 2026 (is_annual=1)
(1, 2, 6, 'approved', '2026-04-09 18:33:07'),
(2, 2, 7, 'approved', '2026-04-09 18:31:19'),

-- Event 6: Annual City Cleanup (is_annual=1)
(3, 6, 6, 'approved', '2026-04-09 18:33:44'),
(4, 6, 7, 'approved', '2026-04-09 18:32:46'),

-- Event 7: Annual Beach Cleanup 2026 (is_annual=1) - REJECTED
(5, 7, 7, 'rejected', '2026-04-09 18:32:51'),

-- Event 8: Annual Tree Planting 2026 (is_annual=1)
(6, 8, 7, 'approved', '2026-04-09 18:30:54'),

-- Event 14: Community Clean - Maharagama (is_annual=1)
(7, 14, 6, 'approved', '2026-04-12 12:51:20'),
(8, 14, 7, 'approved', '2026-04-12 12:52:21'),

-- Event 15: Annual Tree Planting - Ella (is_annual=1)
(9, 15, 7, 'approved', '2026-04-12 13:00:43'),

-- Event 22: National Tree Planting Day (is_annual=1)
(10, 22, 6, 'approved', '2026-04-15 21:35:22'),
(11, 22, 7, 'approved', '2026-04-15 21:35:06'),

-- Event 23: World Coral Day Project (is_annual=1)
(12, 23, 6, 'approved', '2026-04-15 21:39:13'),
(13, 23, 7, 'approved', '2026-04-15 21:40:02'),

-- Event 24: World Mangrove Day (is_annual=1)
(14, 24, 6, 'approved', '2026-04-15 22:01:55'),
(15, 24, 7, 'approved', '2026-04-15 22:01:45');
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
) ENGINE=MyISAM AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance_rating`
--
--
-- Dumping data for table `attendance_rating`
--

INSERT INTO `attendance_rating` (`attendance_rating_id`, `event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
-- Event 3 (Coral Restoration - Nilaveli) - 15 volunteers
(1, 3, 8, 3, 5.00, '2026-04-12 18:00:00'),
(2, 3, 9, 3, 5.00, '2026-04-12 18:00:00'),
(3, 3, 10, 3, 5.00, '2026-04-12 18:00:00'),
(4, 3, 11, 3, 5.00, '2026-04-12 18:00:00'),
(5, 3, 12, 3, 5.00, '2026-04-12 18:00:00'),
(6, 3, 13, 3, 5.00, '2026-04-12 18:00:00'),
(7, 3, 14, 3, 5.00, '2026-04-12 18:00:00'),
(8, 3, 16, 3, 5.00, '2026-04-12 18:00:00'),
(9, 3, 17, 3, 5.00, '2026-04-12 18:00:00'),
(10, 3, 18, 3, 5.00, '2026-04-12 18:00:00'),
(11, 3, 19, 3, 5.00, '2026-04-12 18:00:00'),
(12, 3, 20, 3, 5.00, '2026-04-12 18:00:00'),
(13, 3, 21, 3, 5.00, '2026-04-12 18:00:00'),
(14, 3, 22, 3, 5.00, '2026-04-12 18:00:00'),
(15, 3, 23, 3, 5.00, '2026-04-12 18:00:00'),

-- Event 4 (Seruwawila Mangrove Restoration) - 42 volunteers
(16, 4, 1, 3, 5.00, '2026-04-09 18:00:00'),
(17, 4, 5, 3, 5.00, '2026-04-09 18:00:00'),
(18, 4, 6, 3, 5.00, '2026-04-09 18:00:00'),
(19, 4, 7, 3, 5.00, '2026-04-09 18:00:00'),
(20, 4, 8, 3, 5.00, '2026-04-09 18:00:00'),
(21, 4, 9, 3, 5.00, '2026-04-09 18:00:00'),
(22, 4, 10, 3, 5.00, '2026-04-09 18:00:00'),
(23, 4, 13, 3, 5.00, '2026-04-09 18:00:00'),
(24, 4, 15, 3, 5.00, '2026-04-09 18:00:00'),
(25, 4, 16, 3, 5.00, '2026-04-09 18:00:00'),
(26, 4, 17, 3, 5.00, '2026-04-09 18:00:00'),
(27, 4, 18, 3, 5.00, '2026-04-09 18:00:00'),
(28, 4, 20, 3, 5.00, '2026-04-09 18:00:00'),
(29, 4, 21, 3, 5.00, '2026-04-09 18:00:00'),
(30, 4, 22, 3, 5.00, '2026-04-09 18:00:00'),
(31, 4, 30, 3, 5.00, '2026-04-09 18:00:00'),
(32, 4, 31, 3, 5.00, '2026-04-09 18:00:00'),
(33, 4, 32, 3, 5.00, '2026-04-09 18:00:00'),
(34, 4, 33, 3, 5.00, '2026-04-09 18:00:00'),
(35, 4, 34, 3, 5.00, '2026-04-09 18:00:00'),
(36, 4, 38, 3, 5.00, '2026-04-09 18:00:00'),
(37, 4, 40, 3, 5.00, '2026-04-09 18:00:00'),
(38, 4, 41, 3, 5.00, '2026-04-09 18:00:00'),
(39, 4, 42, 3, 5.00, '2026-04-09 18:00:00'),
(40, 4, 49, 3, 5.00, '2026-04-09 18:00:00'),
(41, 4, 50, 3, 5.00, '2026-04-09 18:00:00'),
(42, 4, 51, 3, 5.00, '2026-04-09 18:00:00'),
(43, 4, 52, 3, 5.00, '2026-04-09 18:00:00'),
(44, 4, 53, 3, 5.00, '2026-04-09 18:00:00'),
(45, 4, 54, 3, 5.00, '2026-04-09 18:00:00'),
(46, 4, 55, 3, 5.00, '2026-04-09 18:00:00'),
(47, 4, 56, 3, 5.00, '2026-04-09 18:00:00'),
(48, 4, 57, 3, 5.00, '2026-04-09 18:00:00'),
(49, 4, 58, 3, 5.00, '2026-04-09 18:00:00'),
(50, 4, 59, 3, 5.00, '2026-04-09 18:00:00'),

-- Event 5 (Tree Planting - Hanthana) - 19 volunteers
(51, 5, 8, 5, 5.00, '2026-04-09 18:00:00'),
(52, 5, 9, 5, 5.00, '2026-04-09 18:00:00'),
(53, 5, 11, 5, 5.00, '2026-04-09 18:00:00'),
(54, 5, 12, 5, 5.00, '2026-04-09 18:00:00'),
(55, 5, 14, 5, 5.00, '2026-04-09 18:00:00'),
(56, 5, 15, 5, 5.00, '2026-04-09 18:00:00'),
(57, 5, 16, 5, 5.00, '2026-04-09 18:00:00'),
(58, 5, 17, 5, 5.00, '2026-04-09 18:00:00'),
(59, 5, 18, 5, 5.00, '2026-04-09 18:00:00'),
(60, 5, 20, 5, 5.00, '2026-04-09 18:00:00'),
(61, 5, 22, 5, 5.00, '2026-04-09 18:00:00'),
(62, 5, 23, 5, 5.00, '2026-04-09 18:00:00'),
(63, 5, 24, 5, 5.00, '2026-04-09 18:00:00'),
(64, 5, 26, 5, 5.00, '2026-04-09 18:00:00'),
(65, 5, 27, 5, 5.00, '2026-04-09 18:00:00'),

-- Event 9 (Tree Planting - Intercity) - 12 volunteers
(66, 9, 1, 5, 5.00, '2026-04-10 18:00:00'),
(67, 9, 5, 5, 5.00, '2026-04-10 18:00:00'),
(68, 9, 8, 5, 5.00, '2026-04-10 18:00:00'),
(69, 9, 9, 5, 5.00, '2026-04-10 18:00:00'),
(70, 9, 11, 5, 5.00, '2026-04-10 18:00:00'),
(71, 9, 12, 5, 5.00, '2026-04-10 18:00:00'),
(72, 9, 13, 5, 5.00, '2026-04-10 18:00:00'),
(73, 9, 14, 5, 5.00, '2026-04-10 18:00:00'),
(74, 9, 15, 5, 5.00, '2026-04-10 18:00:00'),
(75, 9, 16, 5, 5.00, '2026-04-10 18:00:00'),
(76, 9, 17, 5, 5.00, '2026-04-10 18:00:00'),
(77, 9, 18, 5, 5.00, '2026-04-10 18:00:00'),

-- Event 10 (Tree Planting - Wilpattu) - 10 volunteers
(78, 10, 8, 5, 5.00, '2026-04-11 18:00:00'),
(79, 10, 9, 5, 5.00, '2026-04-11 18:00:00'),
(80, 10, 11, 5, 5.00, '2026-04-11 18:00:00'),
(81, 10, 12, 5, 5.00, '2026-04-11 18:00:00'),
(82, 10, 13, 5, 5.00, '2026-04-11 18:00:00'),
(83, 10, 14, 5, 5.00, '2026-04-11 18:00:00'),
(84, 10, 15, 5, 5.00, '2026-04-11 18:00:00'),
(85, 10, 16, 5, 5.00, '2026-04-11 18:00:00'),
(86, 10, 17, 5, 5.00, '2026-04-11 18:00:00'),
(87, 10, 18, 5, 5.00, '2026-04-11 18:00:00'),

-- Event 11 (Gampola City Cleanup) - 12 volunteers
(88, 11, 1, 3, 5.00, '2026-04-10 18:00:00'),
(89, 11, 8, 3, 5.00, '2026-04-10 18:00:00'),
(90, 11, 9, 3, 5.00, '2026-04-10 18:00:00'),
(91, 11, 10, 3, 5.00, '2026-04-10 18:00:00'),
(92, 11, 11, 3, 5.00, '2026-04-10 18:00:00'),
(93, 11, 12, 3, 5.00, '2026-04-10 18:00:00'),
(94, 11, 13, 3, 5.00, '2026-04-10 18:00:00'),
(95, 11, 14, 3, 5.00, '2026-04-10 18:00:00'),
(96, 11, 15, 3, 5.00, '2026-04-10 18:00:00'),
(97, 11, 16, 3, 5.00, '2026-04-10 18:00:00'),
(98, 11, 17, 3, 5.00, '2026-04-10 18:00:00'),
(99, 11, 35, 3, 5.00, '2026-04-10 18:00:00'),

-- Event 12 (Mount Lavinia Beach Cleanup) - 2 volunteers
(100, 12, 8, 3, 5.00, '2026-04-12 18:00:00'),
(101, 12, 9, 3, 5.00, '2026-04-12 18:00:00'),

-- Event 13 (City Cleanup Kottawa) - 9 volunteers
(102, 13, 5, 5, 5.00, '2026-04-15 18:00:00'),
(103, 13, 8, 5, 5.00, '2026-04-15 18:00:00'),
(104, 13, 9, 5, 5.00, '2026-04-15 18:00:00'),
(105, 13, 10, 5, 5.00, '2026-04-15 18:00:00'),
(106, 13, 11, 5, 5.00, '2026-04-15 18:00:00'),
(107, 13, 12, 5, 5.00, '2026-04-15 18:00:00'),
(108, 13, 13, 5, 5.00, '2026-04-15 18:00:00'),
(109, 13, 14, 5, 5.00, '2026-04-15 18:00:00'),
(110, 13, 15, 5, 5.00, '2026-04-15 18:00:00'),

-- Event 15 (Annual Tree Planting - Ella) - 8 volunteers
(111, 15, 8, 3, 5.00, '2026-04-13 18:00:00'),
(112, 15, 9, 3, 5.00, '2026-04-13 18:00:00'),
(113, 15, 10, 3, 5.00, '2026-04-13 18:00:00'),
(114, 15, 11, 3, 5.00, '2026-04-13 18:00:00'),
(115, 15, 12, 3, 5.00, '2026-04-13 18:00:00'),
(116, 15, 13, 3, 5.00, '2026-04-13 18:00:00'),
(117, 15, 14, 3, 5.00, '2026-04-13 18:00:00'),
(118, 15, 15, 3, 5.00, '2026-04-13 18:00:00'),

-- Event 16 (Coral Restoration - Weligama) - 3 volunteers
(119, 16, 1, 3, 5.00, '2026-04-12 18:00:00'),
(120, 16, 8, 3, 5.00, '2026-04-12 18:00:00'),
(121, 16, 9, 3, 5.00, '2026-04-12 18:00:00'),

-- Event 17 (Kottawa Tree Planting) - 3 volunteers
(122, 17, 8, 3, 5.00, '2026-04-12 18:00:00'),
(123, 17, 9, 3, 5.00, '2026-04-12 18:00:00'),
(124, 17, 10, 3, 5.00, '2026-04-12 18:00:00'),

-- Event 18 (Restore Mangroves Mannar) - 12 volunteers
(125, 18, 8, 3, 5.00, '2026-04-13 18:00:00'),
(126, 18, 9, 3, 5.00, '2026-04-13 18:00:00'),
(127, 18, 10, 3, 5.00, '2026-04-13 18:00:00'),
(128, 18, 11, 3, 5.00, '2026-04-13 18:00:00'),
(129, 18, 12, 3, 5.00, '2026-04-13 18:00:00'),
(130, 18, 13, 3, 5.00, '2026-04-13 18:00:00'),
(131, 18, 14, 3, 5.00, '2026-04-13 18:00:00'),
(132, 18, 15, 3, 5.00, '2026-04-13 18:00:00'),
(133, 18, 16, 3, 5.00, '2026-04-13 18:00:00'),
(134, 18, 17, 3, 5.00, '2026-04-13 18:00:00'),
(135, 18, 18, 3, 5.00, '2026-04-13 18:00:00'),
(136, 18, 20, 3, 5.00, '2026-04-13 18:00:00'),

-- Event 19 (Cleaner City - Kottawa) - 3 volunteers
(137, 19, 8, 3, 5.00, '2026-04-13 18:00:00'),
(138, 19, 9, 3, 5.00, '2026-04-13 18:00:00'),
(139, 19, 10, 3, 5.00, '2026-04-13 18:00:00'),

-- Event 20 (Mangrove Restoration - Puttalam) - 4 volunteers
(140, 20, 8, 3, 5.00, '2026-04-14 18:00:00'),
(141, 20, 9, 3, 5.00, '2026-04-14 18:00:00'),
(142, 20, 15, 3, 5.00, '2026-04-14 18:00:00'),
(143, 20, 45, 3, 5.00, '2026-04-14 18:00:00'),

-- Event 21 (Horton Plains Cleanup) - 8 volunteers
(144, 21, 8, 5, 5.00, '2026-04-14 18:00:00'),
(145, 21, 9, 5, 5.00, '2026-04-14 18:00:00'),
(146, 21, 10, 5, 5.00, '2026-04-14 18:00:00'),
(147, 21, 11, 5, 5.00, '2026-04-14 18:00:00'),
(148, 21, 12, 5, 5.00, '2026-04-14 18:00:00'),
(149, 21, 13, 5, 5.00, '2026-04-14 18:00:00'),
(150, 21, 14, 5, 5.00, '2026-04-14 18:00:00'),
(151, 21, 15, 5, 5.00, '2026-04-14 18:00:00'),

-- Event 25 (Negombo Beach Cleanup - Sep 2025) - 4 volunteers
(152, 25, 8, 3, 5.00, '2025-09-15 18:00:00'),
(153, 25, 9, 3, 5.00, '2025-09-15 18:00:00'),
(154, 25, 10, 3, 5.00, '2025-09-15 18:00:00'),
(155, 25, 11, 3, 5.00, '2025-09-15 18:00:00'),

-- Event 26 (Kandy City Cleanup - Oct 2025) - 4 volunteers
(156, 26, 8, 3, 5.00, '2025-10-20 18:00:00'),
(157, 26, 9, 3, 5.00, '2025-10-20 18:00:00'),
(158, 26, 11, 3, 5.00, '2025-10-20 18:00:00'),
(159, 26, 12, 3, 5.00, '2025-10-20 18:00:00'),

-- Event 27 (Trincomalee Coral Restoration - Nov 2025) - 4 volunteers
(160, 27, 8, 3, 5.00, '2025-11-10 18:00:00'),
(161, 27, 9, 3, 5.00, '2025-11-10 18:00:00'),
(162, 27, 12, 3, 5.00, '2025-11-10 18:00:00'),
(163, 27, 13, 3, 5.00, '2025-11-10 18:00:00'),

-- Event 28 (Batticaloa Mangrove Planting - Dec 2025) - 4 volunteers
(164, 28, 8, 3, 5.00, '2025-12-05 18:00:00'),
(165, 28, 9, 3, 5.00, '2025-12-05 18:00:00'),
(166, 28, 13, 3, 5.00, '2025-12-05 18:00:00'),
(167, 28, 14, 3, 5.00, '2025-12-05 18:00:00'),

-- Event 29 (Galle City Cleanup - Jan 2026) - 4 volunteers
(168, 29, 8, 3, 5.00, '2026-01-15 18:00:00'),
(169, 29, 9, 3, 5.00, '2026-01-15 18:00:00'),
(170, 29, 14, 3, 5.00, '2026-01-15 18:00:00'),
(171, 29, 15, 3, 5.00, '2026-01-15 18:00:00'),

-- Event 30 (Nuwara Eliya Mountain Cleanup - Feb 2026) - 4 volunteers
(172, 30, 8, 3, 5.00, '2026-02-20 18:00:00'),
(173, 30, 9, 3, 5.00, '2026-02-20 18:00:00'),
(174, 30, 15, 3, 5.00, '2026-02-20 18:00:00'),
(175, 30, 16, 3, 5.00, '2026-02-20 18:00:00'),

-- Event 31 (Jaffna Beach Cleanup - Mar 2026) - 4 volunteers
(176, 31, 8, 3, 5.00, '2026-03-10 18:00:00'),
(177, 31, 9, 3, 5.00, '2026-03-10 18:00:00'),
(178, 31, 16, 3, 5.00, '2026-03-10 18:00:00'),
(179, 31, 17, 3, 5.00, '2026-03-10 18:00:00'),

-- Event 32 (Anuradhapura Tree Planting - Mar 2026) - 4 volunteers
(180, 32, 8, 3, 5.00, '2026-03-25 18:00:00'),
(181, 32, 9, 3, 5.00, '2026-03-25 18:00:00'),
(182, 32, 17, 3, 5.00, '2026-03-25 18:00:00'),
(183, 32, 18, 3, 5.00, '2026-03-25 18:00:00'),

-- Event 33 (Polonnaruwa City Cleanup - Apr 2026) - 4 volunteers
(184, 33, 8, 3, 5.00, '2026-04-05 18:00:00'),
(185, 33, 9, 3, 5.00, '2026-04-05 18:00:00'),
(186, 33, 18, 3, 5.00, '2026-04-05 18:00:00'),
(187, 33, 19, 3, 5.00, '2026-04-05 18:00:00'),

-- Event 34 (Negombo Beach Cleanup - Apr 2026) - 6 volunteers (planned, not yet completed)
(188, 34, 8, 3, 5.00, '2026-04-20 18:00:00'),
(189, 34, 9, 3, 5.00, '2026-04-20 18:00:00'),
(190, 34, 19, 3, 5.00, '2026-04-20 18:00:00'),
(191, 34, 20, 3, 5.00, '2026-04-20 18:00:00'),
(192, 34, 21, 3, 5.00, '2026-04-20 18:00:00'),
(193, 34, 22, 3, 5.00, '2026-04-20 18:00:00'),

-- Event 35 (Galle Face Beach Cleanup - NEW - Apr 15, 2026) - 12 volunteers (points NOT processed)
(194, 35, 8, 3, 5.00, '2026-04-15 18:00:00'),
(195, 35, 9, 3, 5.00, '2026-04-15 18:00:00'),
(196, 35, 10, 3, 4.50, '2026-04-15 18:00:00'),
(197, 35, 11, 3, 5.00, '2026-04-15 18:00:00'),
(198, 35, 12, 3, 4.00, '2026-04-15 18:00:00'),
(199, 35, 13, 3, 5.00, '2026-04-15 18:00:00'),
(200, 35, 14, 3, 4.50, '2026-04-15 18:00:00'),
(201, 35, 15, 3, 5.00, '2026-04-15 18:00:00'),
(202, 35, 16, 3, 4.00, '2026-04-15 18:00:00'),
(203, 35, 17, 3, 5.00, '2026-04-15 18:00:00'),
(204, 35, 18, 3, 4.50, '2026-04-15 18:00:00'),
(205, 35, 20, 3, 5.00, '2026-04-15 18:00:00');
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
(30, 45000.00, 62, NULL, 'SPONSOR-1776290554-1632', '2026-04-16 03:32:34', '320032592030', 24, 'complete'),
(31, 25000.00, 60, NULL, 'SPONSOR-1776291000-1000', '2026-04-16 04:00:00', '320032592031', 22, 'complete'),
(32, 15000.00, 61, NULL, 'SPONSOR-1776291100-1100', '2026-04-16 04:10:00', '320032592032', 22, 'complete');

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

--
-- Dumping data for table `donation_usage`
--

INSERT INTO `donation_usage` (`usage_id`, `donationid`, `event_id`, `manager_id`, `used_amount`, `usage_date`, `purpose`) VALUES
(1, 13, 2, 3, 15000.00, '2026-04-16', 'Event supplies and equipment'),
(2, 23, 2, 3, 10000.00, '2026-04-16', 'Food and refreshments for volunteers'),
(3, 19, 14, 3, 11000.00, '2026-04-16', 'Cleanup tools and garbage bags'),
(4, 20, 14, 3, 10499.99, '2026-04-16', 'Transportation for volunteers'),
(5, 21, 2, 3, 10000.00, '2026-04-16', 'First aid supplies and water bottles'),
(6, 26, 23, 3, 45000.00, '2026-04-16', 'Coral planting materials and diving gear'),
(7, 27, 23, 3, 10000.00, '2026-04-16', 'Lunch packets for volunteers'),
(8, 28, 23, 3, 35000.00, '2026-04-16', 'Equipment rentals and safety gear'),
(9, 29, 2, 3, 34000.00, '2026-04-16', 'Trail maintenance and cleanup supplies'),
(10, 30, 24, 3, 45000.00, '2026-04-16', 'Mangrove saplings and planting tools');

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
(41, 24, 'Gloves', 3000.00, '2026-04-16 03:31:21'),
(42, 25, 'Lunch Packet', 8000.00, '2025-09-15 08:00:00'),
(43, 25, 'Shovel and Gear Rentals', 5000.00, '2025-09-15 08:00:00'),
(44, 26, 'Lunch Packet', 10000.00, '2025-10-20 08:00:00'),
(45, 26, 'Garbage Bags and Gloves', 3000.00, '2025-10-20 08:00:00'),
(46, 27, 'Lunch Packet', 12000.00, '2025-11-10 08:00:00'),
(47, 27, 'Shovel and Gear Rentals', 4000.00, '2025-11-10 08:00:00'),
(48, 28, 'Lunch Packet', 15000.00, '2025-12-05 08:00:00'),
(49, 28, 'Diving Gear Rentals', 8000.00, '2025-12-05 08:00:00'),
(50, 29, 'Lunch Packet', 10000.00, '2026-01-15 08:00:00'),
(51, 29, 'Garbage Bags and Gloves', 5000.00, '2026-01-15 08:00:00'),
(52, 30, 'Lunch Packet', 12000.00, '2026-02-20 08:00:00'),
(53, 30, 'Shovel and Gear Rentals', 6000.00, '2026-02-20 08:00:00'),
(54, 31, 'Lunch Packet', 10000.00, '2026-03-10 08:00:00'),
(55, 31, 'Garbage Bags and Gloves', 4000.00, '2026-03-10 08:00:00'),
(56, 32, 'Lunch Packet', 15000.00, '2026-03-25 08:00:00'),
(57, 32, 'Shovel and Gear Rentals', 5000.00, '2026-03-25 08:00:00'),
(58, 33, 'Lunch Packet', 8000.00, '2026-04-05 08:00:00'),
(59, 33, 'Garbage Bags and Gloves', 3000.00, '2026-04-05 08:00:00'),
(60, 34, 'Lunch Packet', 12000.00, '2026-04-18 08:00:00'),
(61, 34, 'Shovel and Gear Rentals', 6000.00, '2026-04-18 08:00:00');

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
-- Event 3 (Coral Restoration) - 15 volunteers - ALL 'attended'
(3, 8, 'attended', '2026-04-09 23:17:17'),
(3, 9, 'attended', '2026-04-13 00:31:33'),
(3, 10, 'attended', '2026-04-13 00:31:48'),
(3, 11, 'attended', '2026-04-13 00:31:50'),
(3, 12, 'attended', '2026-04-13 00:31:52'),
(3, 13, 'attended', '2026-04-13 00:31:54'),
(3, 14, 'attended', '2026-04-13 00:33:54'),
(3, 16, 'attended', '2026-04-13 00:31:57'),
(3, 17, 'attended', '2026-04-13 00:31:59'),
(3, 18, 'attended', '2026-04-13 00:33:56'),
(3, 19, 'attended', '2026-04-13 00:33:58'),
(3, 20, 'attended', '2026-04-13 00:33:59'),
(3, 21, 'attended', '2026-04-13 00:34:01'),
(3, 22, 'attended', '2026-04-13 00:34:05'),
(3, 23, 'attended', '2026-04-13 00:34:06'),

-- Event 4 (Seruwawila Mangrove Restoration) - 42 volunteers - ALL 'attended'
(4, 1, 'attended', '2026-04-10 00:45:45'),
(4, 5, 'attended', '2026-04-10 00:45:48'),
(4, 6, 'attended', '2026-04-10 00:45:50'),
(4, 7, 'attended', '2026-04-10 00:45:51'),
(4, 8, 'attended', '2026-04-10 00:45:53'),
(4, 9, 'attended', '2026-04-10 00:45:54'),
(4, 10, 'attended', '2026-04-10 00:45:55'),
(4, 13, 'attended', '2026-04-10 00:45:58'),
(4, 15, 'attended', '2026-04-10 00:46:03'),
(4, 16, 'attended', '2026-04-10 00:46:05'),
(4, 17, 'attended', '2026-04-10 00:46:07'),
(4, 18, 'attended', '2026-04-10 00:46:09'),
(4, 20, 'attended', '2026-04-10 00:46:11'),
(4, 21, 'attended', '2026-04-10 00:46:13'),
(4, 22, 'attended', '2026-04-10 00:46:15'),
(4, 30, 'attended', '2026-04-10 00:46:21'),
(4, 31, 'attended', '2026-04-10 00:46:23'),
(4, 32, 'attended', '2026-04-10 00:46:25'),
(4, 33, 'attended', '2026-04-10 00:46:26'),
(4, 34, 'attended', '2026-04-10 00:46:28'),
(4, 38, 'attended', '2026-04-10 00:46:34'),
(4, 40, 'attended', '2026-04-10 00:46:36'),
(4, 41, 'attended', '2026-04-10 00:46:37'),
(4, 42, 'attended', '2026-04-10 00:46:40'),
(4, 49, 'attended', '2026-04-10 00:46:41'),
(4, 50, 'attended', '2026-04-10 00:46:43'),
(4, 51, 'attended', '2026-04-10 00:46:45'),
(4, 52, 'attended', '2026-04-10 00:46:47'),
(4, 53, 'attended', '2026-04-10 00:46:49'),
(4, 54, 'attended', '2026-04-10 00:46:50'),
(4, 55, 'attended', '2026-04-10 00:46:52'),
(4, 56, 'attended', '2026-04-10 00:46:54'),
(4, 57, 'attended', '2026-04-10 00:46:55'),
(4, 58, 'attended', '2026-04-10 00:46:57'),
(4, 59, 'attended', '2026-04-10 00:47:00'),

-- Event 5 (Tree Planting - Hanthana) - 19 volunteers - ALL 'attended'
(5, 8, 'attended', '2026-04-10 01:28:40'),
(5, 9, 'attended', '2026-04-10 01:28:42'),
(5, 11, 'attended', '2026-04-10 01:28:44'),
(5, 12, 'attended', '2026-04-10 01:28:47'),
(5, 14, 'attended', '2026-04-10 01:28:48'),
(5, 15, 'attended', '2026-04-10 01:28:50'),
(5, 16, 'attended', '2026-04-10 01:28:52'),
(5, 17, 'attended', '2026-04-10 01:28:38'),
(5, 18, 'attended', '2026-04-10 01:28:53'),
(5, 20, 'attended', '2026-04-10 01:28:55'),
(5, 22, 'attended', '2026-04-10 01:28:57'),
(5, 23, 'attended', '2026-04-10 01:29:00'),
(5, 24, 'attended', '2026-04-10 01:29:02'),
(5, 26, 'attended', '2026-04-10 01:29:03'),
(5, 27, 'attended', '2026-04-10 01:29:05'),

-- Event 9 (Tree Planting - Intercity) - 12 volunteers - ALL 'attended'
(9, 1, 'attended', '2026-04-10 01:38:30'),
(9, 5, 'attended', '2026-04-10 01:38:11'),
(9, 8, 'attended', '2026-04-10 01:14:27'),
(9, 9, 'attended', '2026-04-10 01:15:12'),
(9, 11, 'attended', '2026-04-10 01:15:32'),
(9, 12, 'attended', '2026-04-10 01:16:39'),
(9, 13, 'attended', '2026-04-10 01:16:07'),
(9, 14, 'attended', '2026-04-10 01:17:12'),
(9, 15, 'attended', '2026-04-10 01:17:29'),
(9, 16, 'attended', '2026-04-10 01:17:52'),
(9, 17, 'attended', '2026-04-10 01:18:08'),
(9, 18, 'attended', '2026-04-10 01:18:23'),

-- Event 10 (Tree Planting - Wilpattu) - 10 volunteers - ALL 'attended'
(10, 8, 'attended', '2026-04-11 08:00:00'),
(10, 9, 'attended', '2026-04-11 08:00:00'),
(10, 11, 'attended', '2026-04-11 08:00:00'),
(10, 12, 'attended', '2026-04-11 08:00:00'),
(10, 13, 'attended', '2026-04-11 08:00:00'),
(10, 14, 'attended', '2026-04-11 08:00:00'),
(10, 15, 'attended', '2026-04-11 08:00:00'),
(10, 16, 'attended', '2026-04-11 08:00:00'),
(10, 17, 'attended', '2026-04-11 08:00:00'),
(10, 18, 'attended', '2026-04-11 08:00:00'),

-- Event 11 (Gampola City Cleanup) - 12 volunteers - ALL 'attended'
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

-- Event 12 (Mount Lavinia Beach Cleanup) - 2 volunteers - NO peer ratings (less than 5)
(12, 8, 'attended', '2026-04-13 01:17:59'),
(12, 9, 'attended', '2026-04-13 01:18:52'),

-- Event 13 (City Cleanup Kottawa) - 9 volunteers - ALL 'attended'
(13, 5, 'attended', '2026-04-15 06:00:00'),
(13, 8, 'attended', '2026-04-15 06:00:00'),
(13, 9, 'attended', '2026-04-15 06:00:00'),
(13, 10, 'attended', '2026-04-15 06:00:00'),
(13, 11, 'attended', '2026-04-15 06:00:00'),
(13, 12, 'attended', '2026-04-15 06:00:00'),
(13, 13, 'attended', '2026-04-15 06:00:00'),
(13, 14, 'attended', '2026-04-15 06:00:00'),
(13, 15, 'attended', '2026-04-15 06:00:00'),

-- Event 15 (Annual Tree Planting - Ella) - 8 volunteers - ALL 'attended'
(15, 8, 'attended', '2026-04-13 06:00:00'),
(15, 9, 'attended', '2026-04-13 06:00:00'),
(15, 10, 'attended', '2026-04-13 06:00:00'),
(15, 11, 'attended', '2026-04-13 06:00:00'),
(15, 12, 'attended', '2026-04-13 06:00:00'),
(15, 13, 'attended', '2026-04-13 06:00:00'),
(15, 14, 'attended', '2026-04-13 06:00:00'),
(15, 15, 'attended', '2026-04-13 06:00:00'),

-- Event 16 (Coral Restoration - Weligama) - 3 volunteers - NO peer ratings (less than 5)
(16, 1, 'attended', '2026-04-13 00:56:02'),
(16, 8, 'attended', '2026-04-13 00:56:23'),
(16, 9, 'attended', '2026-04-13 00:59:45'),

-- Event 17 (Kottawa Tree Planting) - 3 volunteers - NO peer ratings (less than 5)
(17, 8, 'attended', '2026-04-13 02:01:28'),
(17, 9, 'attended', '2026-04-13 02:00:35'),
(17, 10, 'attended', '2026-04-13 02:01:13'),

-- Event 18 (Restore Mangroves Mannar) - 12 volunteers - ALL 'attended'
(18, 8, 'attended', '2026-04-13 13:26:38'),
(18, 9, 'attended', '2026-04-13 13:26:52'),
(18, 10, 'attended', '2026-04-13 13:27:06'),
(18, 11, 'attended', '2026-04-13 13:27:29'),
(18, 12, 'attended', '2026-04-13 13:27:43'),
(18, 13, 'attended', '2026-04-13 13:28:11'),
(18, 14, 'attended', '2026-04-13 13:29:13'),
(18, 15, 'attended', '2026-04-13 13:29:28'),
(18, 16, 'attended', '2026-04-13 13:30:16'),
(18, 17, 'attended', '2026-04-13 13:30:51'),
(18, 18, 'attended', '2026-04-13 13:29:42'),
(18, 20, 'attended', '2026-04-13 13:29:54'),

-- Event 19 (Cleaner City - Kottawa) - 3 volunteers - NO peer ratings (less than 5)
(19, 8, 'attended', '2026-04-13 15:00:00'),
(19, 9, 'attended', '2026-04-13 15:00:00'),
(19, 10, 'attended', '2026-04-13 15:00:00'),

-- Event 20 (Mangrove Restoration - Puttalam) - 4 volunteers - NO peer ratings (less than 5)
(20, 8, 'attended', '2026-04-14 18:56:08'),
(20, 9, 'attended', '2026-04-14 20:34:32'),
(20, 15, 'attended', '2026-04-14 18:57:19'),
(20, 45, 'attended', '2026-04-14 09:14:48'),

-- Event 21 (Horton Plains Cleanup) - 8 volunteers - ALL 'attended'
(21, 8, 'attended', '2026-04-14 12:00:00'),
(21, 9, 'attended', '2026-04-14 12:00:00'),
(21, 10, 'attended', '2026-04-14 12:00:00'),
(21, 11, 'attended', '2026-04-14 12:00:00'),
(21, 12, 'attended', '2026-04-14 12:00:00'),
(21, 13, 'attended', '2026-04-14 12:00:00'),
(21, 14, 'attended', '2026-04-14 12:00:00'),
(21, 15, 'attended', '2026-04-14 12:00:00'),

-- Event 25 (Negombo Beach Cleanup - Sep 2025) - 4 volunteers - NO peer ratings (less than 5)
(25, 8, 'attended', '2025-09-15 07:00:00'),
(25, 9, 'attended', '2025-09-15 07:00:00'),
(25, 10, 'attended', '2025-09-15 07:00:00'),
(25, 11, 'attended', '2025-09-15 07:00:00'),

-- Event 26 (Kandy City Cleanup - Oct 2025) - 4 volunteers - NO peer ratings (less than 5)
(26, 8, 'attended', '2025-10-20 08:00:00'),
(26, 9, 'attended', '2025-10-20 08:00:00'),
(26, 11, 'attended', '2025-10-20 08:00:00'),
(26, 12, 'attended', '2025-10-20 08:00:00'),

-- Event 27 (Trincomalee Coral Restoration - Nov 2025) - 4 volunteers - NO peer ratings (less than 5)
(27, 8, 'attended', '2025-11-10 09:00:00'),
(27, 9, 'attended', '2025-11-10 09:00:00'),
(27, 12, 'attended', '2025-11-10 09:00:00'),
(27, 13, 'attended', '2025-11-10 09:00:00'),

-- Event 28 (Batticaloa Mangrove Planting - Dec 2025) - 4 volunteers - NO peer ratings (less than 5)
(28, 8, 'attended', '2025-12-05 07:30:00'),
(28, 9, 'attended', '2025-12-05 07:30:00'),
(28, 13, 'attended', '2025-12-05 07:30:00'),
(28, 14, 'attended', '2025-12-05 07:30:00'),

-- Event 29 (Galle City Cleanup - Jan 2026) - 4 volunteers - NO peer ratings (less than 5)
(29, 8, 'attended', '2026-01-15 08:00:00'),
(29, 9, 'attended', '2026-01-15 08:00:00'),
(29, 14, 'attended', '2026-01-15 08:00:00'),
(29, 15, 'attended', '2026-01-15 08:00:00'),

-- Event 30 (Nuwara Eliya Mountain Cleanup - Feb 2026) - 4 volunteers - NO peer ratings (less than 5)
(30, 8, 'attended', '2026-02-20 07:00:00'),
(30, 9, 'attended', '2026-02-20 07:00:00'),
(30, 15, 'attended', '2026-02-20 07:00:00'),
(30, 16, 'attended', '2026-02-20 07:00:00'),

-- Event 31 (Jaffna Beach Cleanup - Mar 2026) - 4 volunteers - NO peer ratings (less than 5)
(31, 8, 'attended', '2026-03-10 07:30:00'),
(31, 9, 'attended', '2026-03-10 07:30:00'),
(31, 16, 'attended', '2026-03-10 07:30:00'),
(31, 17, 'attended', '2026-03-10 07:30:00'),

-- Event 32 (Anuradhapura Tree Planting - Mar 2026) - 4 volunteers - NO peer ratings (less than 5)
(32, 8, 'attended', '2026-03-25 08:00:00'),
(32, 9, 'attended', '2026-03-25 08:00:00'),
(32, 17, 'attended', '2026-03-25 08:00:00'),
(32, 18, 'attended', '2026-03-25 08:00:00'),

-- Event 33 (Polonnaruwa City Cleanup - Apr 2026) - 4 volunteers - NO peer ratings (less than 5)
(33, 8, 'attended', '2026-04-05 07:00:00'),
(33, 9, 'attended', '2026-04-05 07:00:00'),
(33, 18, 'attended', '2026-04-05 07:00:00'),
(33, 19, 'attended', '2026-04-05 07:00:00'),

-- Event 34 (Negombo Beach Cleanup - Apr 2026) - PLANNED - status 'registered'
(34, 8, 'registered', '2026-04-16 00:00:00'),
(34, 9, 'registered', '2026-04-16 00:00:00'),
(34, 19, 'registered', '2026-04-16 00:00:00'),
(34, 20, 'registered', '2026-04-16 00:00:00'),
(34, 21, 'registered', '2026-04-16 00:00:00'),
(34, 22, 'registered', '2026-04-16 00:00:00'),

-- Event 35 (Galle Face Beach Cleanup - NEW - Apr 15, 2026) - 12 volunteers - ALL 'attended', points NOT processed
(35, 8, 'attended', '2026-04-15 07:00:00'),
(35, 9, 'attended', '2026-04-15 07:00:00'),
(35, 10, 'attended', '2026-04-15 07:00:00'),
(35, 11, 'attended', '2026-04-15 07:00:00'),
(35, 12, 'attended', '2026-04-15 07:00:00'),
(35, 13, 'attended', '2026-04-15 07:00:00'),
(35, 14, 'attended', '2026-04-15 07:00:00'),
(35, 15, 'attended', '2026-04-15 07:00:00'),
(35, 16, 'attended', '2026-04-15 07:00:00'),
(35, 17, 'attended', '2026-04-15 07:00:00'),
(35, 18, 'attended', '2026-04-15 07:00:00'),
(35, 20, 'attended', '2026-04-15 07:00:00');



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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `itemtype`, `managinguserid`, `description`, `price`, `stock_XS`, `stock_S`, `stock_M`, `stock_L`, `stock_XL`, `stock_XXL`, `is_active`, `image_path`) VALUES
(1, 'T-shirt-2026', 3, 'Knady Cleanup Programme', 2000.00, 9, 10, 10, 10, 10, 10, 1, '/V/View/uploads/items/item_1776295297_69e01d818ba8f.jpg'),
(2, 'Hoodie', 3, 'Sri Pada Cleanup Programme', 3000.00, 15, 15, 11, 15, 15, 15, 1, '/V/View/uploads/items/item_1776295325_69e01d9d743d9.jpg'),
(3, 'T-shirt 2025', 3, 'Hikkaduwa Beach Cleanup', 1500.00, 18, 18, 18, 18, 18, 18, 1, '/V/View/uploads/items/item_1776295344_69e01db0b4876.jpg'),
(4, 'Jersey 2026', 3, 'Nuwara Eliya Cleanup Programme', 3500.00, 14, 14, 14, 14, 14, 14, 1, '/V/View/uploads/items/item_1776295358_69e01dbef12ec.jpg'),
(5, 'Hoodie-2025', 3, 'Anuradhapura Cleanup Programme', 2000.00, 23, 23, 23, 23, 23, 23, 1, '/V/View/uploads/items/item_1776295370_69e01dca76291.jpg'),
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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item_purchase_log`
--

INSERT INTO `item_purchase_log` (`log_id`, `payment_id`, `order_id`, `volunteer_id`, `sponsorid`, `itemid`, `quantity_taken`, `size`, `points_used`, `discount`, `paid_amount`, `purchase_date`) VALUES
(1, '320032592022', 'MERCH-1776285302-5350', 1, NULL, 1, 1, 'XS', 0, 0.00, 2000.00, '2026-04-16 02:05:02'),
(2, '320032592038', 'MERCH-1776295443-1428', 1, NULL, 2, 2, 'M', 0, 0.00, 6000.00, '2026-04-16 04:54:03'),
(3, 'PAY-001', 'MERCH-20250915-001', 8, NULL, 1, 1, 'M', 0, 0.00, 2000.00, '2025-09-15 12:00:00'),
(4, 'PAY-002', 'MERCH-20251020-002', 8, NULL, 3, 1, 'L', 0, 0.00, 1500.00, '2025-10-20 14:00:00'),
(5, 'PAY-003', 'MERCH-20251110-003', 9, NULL, 1, 1, 'S', 0, 0.00, 2000.00, '2025-11-10 10:00:00'),
(6, 'PAY-004', 'MERCH-20251205-004', 9, NULL, 2, 1, 'M', 0, 0.00, 3000.00, '2025-12-05 15:00:00'),
(7, 'PAY-005', 'MERCH-20260115-005', 8, NULL, 5, 1, 'XL', 0, 0.00, 2000.00, '2026-01-15 11:00:00'),
(8, 'PAY-006', 'MERCH-20260220-006', 9, NULL, 4, 1, 'L', 0, 0.00, 3500.00, '2026-02-20 13:00:00'),
(9, 'PAY-010', 'MERCH-20260410-010', 9, NULL, 1, 2, 'M', 0, 0.00, 4000.00, '2026-04-10 11:00:00'),
(10, 'PAY-011', 'MERCH-20260415-011', 10, NULL, 3, 1, 'S', 0, 0.00, 1500.00, '2026-04-15 10:00:00'),
(11, 'PAY-012', 'MERCH-20260416-012', 11, NULL, 2, 1, 'L', 0, 0.00, 3000.00, '2026-04-16 08:00:00');

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

INSERT INTO `peer_rating` (`peer_rating_score`, `comment`, `rater_id`, `ratee_id`, `event_id`, `time_stamp`) VALUES
-- Event 3 peer ratings (15 volunteers)
(5.00, 'Great teamwork on coral planting', 8, 9, 3, '2026-04-13 10:00:00'),
(5.00, 'Excellent diving skills', 8, 10, 3, '2026-04-13 10:00:00'),
(5.00, 'Very helpful with equipment', 8, 11, 3, '2026-04-13 10:00:00'),
(5.00, 'Great communication', 9, 10, 3, '2026-04-13 10:05:00'),
(5.00, 'Careful with coral fragments', 9, 11, 3, '2026-04-13 10:05:00'),
(5.00, 'Good team player', 9, 12, 3, '2026-04-13 10:05:00'),
(5.00, 'Efficient worker', 10, 11, 3, '2026-04-13 10:10:00'),
(5.00, 'Great attitude', 10, 12, 3, '2026-04-13 10:10:00'),
(5.00, 'Strong leadership', 10, 16, 3, '2026-04-13 10:10:00'),
(4.00, 'Good but could be faster', 11, 17, 3, '2026-04-13 10:15:00'),
(5.00, 'Excellent work ethic', 11, 16, 3, '2026-04-13 10:15:00'),
(5.00, 'Very organized', 11, 12, 3, '2026-04-13 10:15:00'),
(5.00, 'Great coordination', 12, 8, 3, '2026-04-13 10:20:00'),
(3.00, 'Needs improvement', 12, 16, 3, '2026-04-13 10:20:00'),
(4.00, 'Good effort', 12, 17, 3, '2026-04-13 10:20:00'),
(2.00, 'Arrived late', 13, 19, 3, '2026-04-13 10:25:00'),
(1.00, 'Left early', 13, 18, 3, '2026-04-13 10:25:00'),
(5.00, 'Excellent work', 13, 14, 3, '2026-04-13 10:25:00'),
(1.00, 'Did not participate fully', 14, 20, 3, '2026-04-13 10:30:00'),
(3.00, 'Average performance', 14, 19, 3, '2026-04-13 10:30:00'),
(3.00, 'Okay but distracted', 14, 18, 3, '2026-04-13 10:30:00'),
(3.00, 'Good but inconsistent', 16, 17, 3, '2026-04-13 10:35:00'),
(1.00, 'Poor communication', 16, 9, 3, '2026-04-13 10:35:00'),
(2.00, 'Needs more effort', 16, 8, 3, '2026-04-13 10:35:00'),
(1.00, 'Very slow', 17, 10, 3, '2026-04-13 10:40:00'),
(2.00, 'Average', 17, 9, 3, '2026-04-13 10:40:00'),
(3.00, 'Okay', 17, 8, 3, '2026-04-13 10:40:00'),
(2.00, 'Could do better', 18, 21, 3, '2026-04-13 10:45:00'),
(4.00, 'Good work', 18, 20, 3, '2026-04-13 10:45:00'),
(5.00, 'Excellent', 18, 19, 3, '2026-04-13 10:45:00'),
(5.00, 'Great job', 19, 20, 3, '2026-04-13 10:50:00'),
(4.00, 'Good effort', 19, 21, 3, '2026-04-13 10:50:00'),
(1.00, 'Poor attitude', 19, 22, 3, '2026-04-13 10:50:00'),
(4.00, 'Good work', 20, 23, 3, '2026-04-13 10:55:00'),
(2.00, 'Needs improvement', 20, 22, 3, '2026-04-13 10:55:00'),
(3.00, 'Average', 20, 21, 3, '2026-04-13 10:55:00'),
(4.00, 'Good team player', 21, 23, 3, '2026-04-13 11:00:00'),
(4.00, 'Solid work', 21, 22, 3, '2026-04-13 11:00:00'),
(3.00, 'Okay', 21, 13, 3, '2026-04-13 11:00:00'),
(5.00, 'Excellent', 22, 23, 3, '2026-04-13 11:05:00'),
(1.00, 'Very disappointing', 22, 14, 3, '2026-04-13 11:05:00'),
(3.00, 'Average', 22, 13, 3, '2026-04-13 11:05:00'),
(2.00, 'Needs work', 23, 18, 3, '2026-04-13 11:10:00'),
(5.00, 'Great job', 23, 14, 3, '2026-04-13 11:10:00'),
(4.00, 'Good effort', 23, 13, 3, '2026-04-13 11:10:00'),

-- Event 4 peer ratings (35 volunteers) - Sample entries
(4.00, 'Good teamwork', 1, 5, 4, '2026-04-10 10:00:00'),
(4.00, 'Solid effort', 1, 6, 4, '2026-04-10 10:00:00'),
(4.00, 'Good communication', 1, 7, 4, '2026-04-10 10:00:00'),
(5.00, 'Excellent work', 5, 8, 4, '2026-04-10 10:05:00'),
(5.00, 'Great team player', 5, 9, 4, '2026-04-10 10:05:00'),
(4.00, 'Good effort', 5, 10, 4, '2026-04-10 10:05:00'),
(5.00, 'Outstanding', 8, 9, 4, '2026-04-10 10:20:00'),
(5.00, 'Very helpful', 8, 10, 4, '2026-04-10 10:20:00'),
(5.00, 'Great leadership', 8, 13, 4, '2026-04-10 10:20:00'),
(5.00, 'Excellent', 9, 10, 4, '2026-04-10 10:25:00'),
(5.00, 'Great work', 9, 13, 4, '2026-04-10 10:25:00'),
(5.00, 'Very dedicated', 9, 14, 4, '2026-04-10 10:25:00'),
(5.00, 'Superb effort', 16, 17, 4, '2026-04-10 11:00:00'),
(5.00, 'Great teamwork', 16, 18, 4, '2026-04-10 11:00:00'),
(5.00, 'Excellent', 16, 20, 4, '2026-04-10 11:00:00'),
(5.00, 'Outstanding work', 20, 21, 4, '2026-04-10 11:30:00'),
(5.00, 'Great job', 20, 22, 4, '2026-04-10 11:30:00'),
(5.00, 'Excellent', 20, 23, 4, '2026-04-10 11:30:00'),

-- Event 5 peer ratings (15 volunteers)
(5.00, 'Great tree planting', 8, 9, 5, '2026-04-10 12:00:00'),
(5.00, 'Efficient worker', 8, 11, 5, '2026-04-10 12:00:00'),
(5.00, 'Good teamwork', 8, 12, 5, '2026-04-10 12:00:00'),
(5.00, 'Excellent', 9, 11, 5, '2026-04-10 12:05:00'),
(5.00, 'Great effort', 9, 12, 5, '2026-04-10 12:05:00'),
(5.00, 'Very helpful', 9, 13, 5, '2026-04-10 12:05:00'),
(5.00, 'Outstanding', 15, 16, 5, '2026-04-10 12:30:00'),
(5.00, 'Great work', 15, 17, 5, '2026-04-10 12:30:00'),
(5.00, 'Excellent', 15, 18, 5, '2026-04-10 12:30:00'),

-- Event 9 peer ratings (12 volunteers)
(4.00, 'Good work', 8, 9, 9, '2026-04-13 16:05:25'),
(5.00, 'Excellent', 8, 11, 9, '2026-04-13 16:05:27'),
(3.00, 'Average', 8, 12, 9, '2026-04-13 16:05:30'),
(3.00, 'Good effort', 5, 16, 9, '2026-04-14 12:46:06'),
(5.00, 'Great job', 5, 15, 9, '2026-04-14 12:46:07'),
(4.00, 'Solid work', 5, 14, 9, '2026-04-14 12:46:08'),
(2.00, 'Needs improvement', 1, 11, 9, '2026-04-14 21:16:17'),
(5.00, 'Excellent', 1, 9, 9, '2026-04-14 21:16:17'),
(4.00, 'Good', 1, 8, 9, '2026-04-14 21:16:18'),

-- Event 11 peer ratings (12 volunteers)
(1.00, 'Poor', 8, 35, 11, '2026-04-13 17:33:55'),
(3.00, 'Average', 8, 10, 11, '2026-04-13 17:33:56'),
(5.00, 'Excellent', 8, 9, 11, '2026-04-13 17:33:59'),

-- Event 13 peer ratings (9 volunteers)
(5.00, 'Great cleanup work', 5, 8, 13, '2026-04-15 18:00:00'),
(5.00, 'Excellent', 5, 9, 13, '2026-04-15 18:00:00'),
(4.00, 'Good', 5, 10, 13, '2026-04-15 18:00:00'),
(5.00, 'Outstanding', 8, 9, 13, '2026-04-15 18:00:00'),
(4.00, 'Good effort', 8, 10, 13, '2026-04-15 18:00:00'),
(5.00, 'Great', 8, 11, 13, '2026-04-15 18:00:00'),

-- Event 15 peer ratings (8 volunteers)
(5.00, 'Excellent tree planting', 8, 9, 15, '2026-04-13 18:00:00'),
(5.00, 'Great work', 8, 10, 15, '2026-04-13 18:00:00'),
(5.00, 'Superb', 8, 11, 15, '2026-04-13 18:00:00'),
(5.00, 'Outstanding', 9, 10, 15, '2026-04-13 18:05:00'),
(4.00, 'Good', 9, 11, 15, '2026-04-13 18:05:00'),
(5.00, 'Excellent', 9, 12, 15, '2026-04-13 18:05:00'),

-- Event 18 peer ratings (12 volunteers)
(2.00, 'Needs work', 8, 11, 18, '2026-04-14 11:17:00'),
(4.00, 'Good', 8, 10, 18, '2026-04-14 11:17:01'),
(5.00, 'Excellent', 8, 9, 18, '2026-04-14 11:17:01'),

-- Event 21 peer ratings (8 volunteers)
(5.00, 'Great mountain cleanup', 8, 9, 21, '2026-04-14 18:00:00'),
(5.00, 'Excellent', 8, 10, 21, '2026-04-14 18:00:00'),
(5.00, 'Outstanding', 8, 11, 21, '2026-04-14 18:00:00'),
(4.00, 'Good', 9, 10, 21, '2026-04-14 18:05:00'),
(5.00, 'Great', 9, 11, 21, '2026-04-14 18:05:00'),
(5.00, 'Excellent', 9, 12, 21, '2026-04-14 18:05:00'),

-- Event 35 peer ratings (NEW - 12 volunteers)
(5.00, 'Great teamwork on the beach cleanup!', 8, 9, 35, '2026-04-15 19:00:00'),
(4.50, 'Good effort, kept the energy high', 8, 10, 35, '2026-04-15 19:00:00'),
(5.00, 'Excellent collaboration', 8, 11, 35, '2026-04-15 19:00:00'),
(5.00, 'Very organized and helpful', 9, 10, 35, '2026-04-15 19:05:00'),
(4.50, 'Good communication', 9, 11, 35, '2026-04-15 19:05:00'),
(4.00, 'Solid work overall', 9, 12, 35, '2026-04-15 19:05:00'),
(5.00, 'Really dedicated to the cause', 10, 11, 35, '2026-04-15 19:10:00'),
(4.00, 'Good but could be more proactive', 10, 12, 35, '2026-04-15 19:10:00'),
(5.00, 'Great leadership qualities', 10, 13, 35, '2026-04-15 19:10:00'),
(4.50, 'Worked well with the team', 11, 12, 35, '2026-04-15 19:15:00'),
(5.00, 'Excellent waste sorting skills', 11, 13, 35, '2026-04-15 19:15:00'),
(4.50, 'Good energy throughout', 11, 14, 35, '2026-04-15 19:15:00'),
(4.00, 'Consistent effort', 12, 13, 35, '2026-04-15 19:20:00'),
(4.50, 'Helpful with coordination', 12, 14, 35, '2026-04-15 19:20:00'),
(5.00, 'Went above and beyond', 12, 15, 35, '2026-04-15 19:20:00'),
(5.00, 'Great attitude', 13, 14, 35, '2026-04-15 19:25:00'),
(4.50, 'Good teamwork', 13, 15, 35, '2026-04-15 19:25:00'),
(4.00, 'Solid performer', 13, 16, 35, '2026-04-15 19:25:00'),
(5.00, 'Excellent contribution', 14, 15, 35, '2026-04-15 19:30:00'),
(4.50, 'Good effort in segregation', 14, 16, 35, '2026-04-15 19:30:00'),
(4.00, 'Worked hard', 14, 17, 35, '2026-04-15 19:30:00'),
(5.00, 'Great team player', 15, 16, 35, '2026-04-15 19:35:00'),
(4.50, 'Good communication skills', 15, 17, 35, '2026-04-15 19:35:00'),
(5.00, 'Excellent awareness work', 15, 18, 35, '2026-04-15 19:35:00'),
(4.00, 'Good but arrived late', 16, 17, 35, '2026-04-15 19:40:00'),
(4.50, 'Solid effort overall', 16, 18, 35, '2026-04-15 19:40:00'),
(5.00, 'Great leadership', 16, 8, 35, '2026-04-15 19:40:00'),
(5.00, 'Excellent work with public', 17, 18, 35, '2026-04-15 19:45:00'),
(5.00, 'Great coordination skills', 17, 8, 35, '2026-04-15 19:45:00'),
(4.50, 'Good teamwork', 17, 9, 35, '2026-04-15 19:45:00'),
(5.00, 'Excellent effort', 18, 8, 35, '2026-04-15 19:50:00'),
(5.00, 'Great work ethic', 18, 9, 35, '2026-04-15 19:50:00'),
(4.50, 'Good contribution', 18, 10, 35, '2026-04-15 19:50:00'),
(5.00, 'Outstanding volunteer', 20, 8, 35, '2026-04-15 19:55:00'),
(5.00, 'Great team member', 20, 9, 35, '2026-04-15 19:55:00'),
(4.50, 'Good awareness work', 20, 14, 35, '2026-04-15 19:55:00');

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
-- Event 3: 15 volunteers (8,9,10,11,12,13,14,16,17,18,19,20,21,22,23)
(1, 3, 8, 9, 'completed', '2026-04-13 00:10:22'),
(2, 3, 8, 10, 'completed', '2026-04-13 00:10:22'),
(3, 3, 8, 11, 'completed', '2026-04-13 00:10:22'),
(4, 3, 9, 10, 'completed', '2026-04-13 00:10:22'),
(5, 3, 9, 11, 'completed', '2026-04-13 00:10:22'),
(6, 3, 9, 12, 'completed', '2026-04-13 00:10:22'),
(7, 3, 10, 11, 'completed', '2026-04-13 00:10:22'),
(8, 3, 10, 12, 'completed', '2026-04-13 00:10:22'),
(9, 3, 10, 16, 'completed', '2026-04-13 00:10:22'),
(10, 3, 11, 12, 'completed', '2026-04-13 00:10:22'),
(11, 3, 11, 16, 'completed', '2026-04-13 00:10:22'),
(12, 3, 11, 17, 'completed', '2026-04-13 00:10:22'),
(13, 3, 12, 16, 'completed', '2026-04-13 00:10:22'),
(14, 3, 12, 17, 'completed', '2026-04-13 00:10:22'),
(15, 3, 12, 8, 'completed', '2026-04-13 00:10:22'),
(16, 3, 16, 17, 'completed', '2026-04-13 00:10:22'),
(17, 3, 16, 8, 'completed', '2026-04-13 00:10:22'),
(18, 3, 16, 9, 'completed', '2026-04-13 00:10:22'),
(19, 3, 17, 8, 'completed', '2026-04-13 00:10:22'),
(20, 3, 17, 9, 'completed', '2026-04-13 00:10:22'),
(21, 3, 17, 10, 'completed', '2026-04-13 00:10:22'),
(22, 3, 13, 14, 'completed', '2026-04-13 00:10:22'),
(23, 3, 13, 18, 'completed', '2026-04-13 00:10:22'),
(24, 3, 13, 19, 'completed', '2026-04-13 00:10:22'),
(25, 3, 14, 18, 'completed', '2026-04-13 00:10:22'),
(26, 3, 14, 19, 'completed', '2026-04-13 00:10:22'),
(27, 3, 14, 20, 'completed', '2026-04-13 00:10:22'),
(28, 3, 18, 19, 'completed', '2026-04-13 00:10:22'),
(29, 3, 18, 20, 'completed', '2026-04-13 00:10:22'),
(30, 3, 18, 21, 'completed', '2026-04-13 00:10:22'),
(31, 3, 19, 20, 'completed', '2026-04-13 00:10:22'),
(32, 3, 19, 21, 'completed', '2026-04-13 00:10:22'),
(33, 3, 19, 22, 'completed', '2026-04-13 00:10:22'),
(34, 3, 20, 21, 'completed', '2026-04-13 00:10:22'),
(35, 3, 20, 22, 'completed', '2026-04-13 00:10:22'),
(36, 3, 20, 23, 'completed', '2026-04-13 00:10:22'),
(37, 3, 21, 22, 'completed', '2026-04-13 00:10:22'),
(38, 3, 21, 23, 'completed', '2026-04-13 00:10:22'),
(39, 3, 21, 13, 'completed', '2026-04-13 00:10:22'),
(40, 3, 22, 23, 'completed', '2026-04-13 00:10:22'),
(41, 3, 22, 13, 'completed', '2026-04-13 00:10:22'),
(42, 3, 22, 14, 'completed', '2026-04-13 00:10:22'),
(43, 3, 23, 13, 'completed', '2026-04-13 00:10:22'),
(44, 3, 23, 14, 'completed', '2026-04-13 00:10:22'),
(45, 3, 23, 18, 'completed', '2026-04-13 00:10:22'),

-- Event 4: 35 volunteers - ONLY those assigned to tasks get peer ratings
-- Volunteers in task_assignment for event 4: 1,5,6,7,8,9,10,13,14,15,16,17,18,20,21,22,23,30,31,32,33,34,35,36,37,38,39,40,41,42,49,50,51,52,53,54,55,56,57,58,59
(46, 4, 1, 5, 'completed', '2026-04-10 01:43:23'),
(47, 4, 1, 6, 'completed', '2026-04-10 01:43:23'),
(48, 4, 1, 7, 'completed', '2026-04-10 01:43:23'),
(49, 4, 5, 6, 'completed', '2026-04-10 01:43:23'),
(50, 4, 5, 7, 'completed', '2026-04-10 01:43:23'),
(51, 4, 5, 8, 'completed', '2026-04-10 01:43:23'),
(52, 4, 6, 7, 'completed', '2026-04-10 01:43:23'),
(53, 4, 6, 8, 'completed', '2026-04-10 01:43:23'),
(54, 4, 6, 9, 'completed', '2026-04-10 01:43:23'),
(55, 4, 7, 8, 'completed', '2026-04-10 01:43:23'),
(56, 4, 7, 9, 'completed', '2026-04-10 01:43:23'),
(57, 4, 7, 10, 'completed', '2026-04-10 01:43:23'),
(58, 4, 8, 9, 'completed', '2026-04-10 01:43:23'),
(59, 4, 8, 10, 'completed', '2026-04-10 01:43:23'),
(60, 4, 8, 13, 'completed', '2026-04-10 01:43:23'),
(61, 4, 9, 10, 'completed', '2026-04-10 01:43:23'),
(62, 4, 9, 13, 'completed', '2026-04-10 01:43:23'),
(63, 4, 9, 14, 'completed', '2026-04-10 01:43:23'),
(64, 4, 10, 13, 'completed', '2026-04-10 01:43:23'),
(65, 4, 10, 14, 'completed', '2026-04-10 01:43:23'),
(66, 4, 10, 15, 'completed', '2026-04-10 01:43:23'),
(67, 4, 13, 14, 'completed', '2026-04-10 01:43:23'),
(68, 4, 13, 15, 'completed', '2026-04-10 01:43:23'),
(69, 4, 13, 16, 'completed', '2026-04-10 01:43:23'),
(70, 4, 14, 15, 'completed', '2026-04-10 01:43:23'),
(71, 4, 14, 16, 'completed', '2026-04-10 01:43:23'),
(72, 4, 14, 17, 'completed', '2026-04-10 01:43:23'),
(73, 4, 15, 16, 'completed', '2026-04-10 01:43:23'),
(74, 4, 15, 17, 'completed', '2026-04-10 01:43:23'),
(75, 4, 15, 18, 'completed', '2026-04-10 01:43:23'),
(76, 4, 16, 17, 'completed', '2026-04-10 01:43:23'),
(77, 4, 16, 18, 'completed', '2026-04-10 01:43:23'),
(78, 4, 16, 20, 'completed', '2026-04-10 01:43:23'),
(79, 4, 17, 18, 'completed', '2026-04-10 01:43:23'),
(80, 4, 17, 20, 'completed', '2026-04-10 01:43:23'),
(81, 4, 17, 21, 'completed', '2026-04-10 01:43:23'),
(82, 4, 18, 20, 'completed', '2026-04-10 01:43:23'),
(83, 4, 18, 21, 'completed', '2026-04-10 01:43:23'),
(84, 4, 18, 22, 'completed', '2026-04-10 01:43:23'),
(85, 4, 20, 21, 'completed', '2026-04-10 01:43:23'),
(86, 4, 20, 22, 'completed', '2026-04-10 01:43:23'),
(87, 4, 20, 23, 'completed', '2026-04-10 01:43:23'),
(88, 4, 21, 22, 'completed', '2026-04-10 01:43:23'),
(89, 4, 21, 23, 'completed', '2026-04-10 01:43:23'),
(90, 4, 21, 30, 'completed', '2026-04-10 01:43:23'),
(91, 4, 22, 23, 'completed', '2026-04-10 01:43:23'),
(92, 4, 22, 30, 'completed', '2026-04-10 01:43:23'),
(93, 4, 22, 31, 'completed', '2026-04-10 01:43:23'),
(94, 4, 23, 30, 'completed', '2026-04-10 01:43:23'),
(95, 4, 23, 31, 'completed', '2026-04-10 01:43:23'),
(96, 4, 23, 32, 'completed', '2026-04-10 01:43:23'),
(97, 4, 30, 31, 'completed', '2026-04-10 01:43:23'),
(98, 4, 30, 32, 'completed', '2026-04-10 01:43:23'),
(99, 4, 30, 33, 'completed', '2026-04-10 01:43:23'),
(100, 4, 31, 32, 'completed', '2026-04-10 01:43:23'),
(101, 4, 31, 33, 'completed', '2026-04-10 01:43:23'),
(102, 4, 31, 34, 'completed', '2026-04-10 01:43:23'),
(103, 4, 32, 33, 'completed', '2026-04-10 01:43:23'),
(104, 4, 32, 34, 'completed', '2026-04-10 01:43:23'),
(105, 4, 32, 35, 'completed', '2026-04-10 01:43:23'),
(106, 4, 33, 34, 'completed', '2026-04-10 01:43:23'),
(107, 4, 33, 35, 'completed', '2026-04-10 01:43:23'),
(108, 4, 33, 36, 'completed', '2026-04-10 01:43:23'),
(109, 4, 34, 35, 'completed', '2026-04-10 01:43:23'),
(110, 4, 34, 36, 'completed', '2026-04-10 01:43:23'),
(111, 4, 34, 37, 'completed', '2026-04-10 01:43:23'),
(112, 4, 35, 36, 'completed', '2026-04-10 01:43:23'),
(113, 4, 35, 37, 'completed', '2026-04-10 01:43:23'),
(114, 4, 35, 38, 'completed', '2026-04-10 01:43:23'),
(115, 4, 36, 37, 'pending', '2026-04-10 01:43:23'),
(116, 4, 36, 38, 'pending', '2026-04-10 01:43:23'),
(117, 4, 36, 39, 'pending', '2026-04-10 01:43:23'),
(118, 4, 37, 38, 'pending', '2026-04-10 01:43:23'),
(119, 4, 37, 39, 'pending', '2026-04-10 01:43:23'),
(120, 4, 37, 40, 'pending', '2026-04-10 01:43:23'),
(121, 4, 38, 39, 'completed', '2026-04-10 01:43:23'),
(122, 4, 38, 40, 'completed', '2026-04-10 01:43:23'),
(123, 4, 38, 41, 'completed', '2026-04-10 01:43:23'),
(124, 4, 39, 40, 'completed', '2026-04-10 01:43:23'),
(125, 4, 39, 41, 'completed', '2026-04-10 01:43:23'),
(126, 4, 39, 42, 'completed', '2026-04-10 01:43:23'),
(127, 4, 40, 41, 'completed', '2026-04-10 01:43:23'),
(128, 4, 40, 42, 'completed', '2026-04-10 01:43:23'),
(129, 4, 40, 49, 'completed', '2026-04-10 01:43:23'),
(130, 4, 41, 42, 'completed', '2026-04-10 01:43:23'),
(131, 4, 41, 49, 'completed', '2026-04-10 01:43:23'),
(132, 4, 41, 50, 'completed', '2026-04-10 01:43:23'),
(133, 4, 42, 49, 'completed', '2026-04-10 01:43:23'),
(134, 4, 42, 50, 'completed', '2026-04-10 01:43:23'),
(135, 4, 42, 51, 'completed', '2026-04-10 01:43:23'),
(136, 4, 49, 50, 'completed', '2026-04-10 01:43:23'),
(137, 4, 49, 51, 'completed', '2026-04-10 01:43:23'),
(138, 4, 49, 52, 'completed', '2026-04-10 01:43:23'),
(139, 4, 50, 51, 'completed', '2026-04-10 01:43:23'),
(140, 4, 50, 52, 'completed', '2026-04-10 01:43:23'),
(141, 4, 50, 53, 'completed', '2026-04-10 01:43:23'),
(142, 4, 51, 52, 'completed', '2026-04-10 01:43:23'),
(143, 4, 51, 53, 'completed', '2026-04-10 01:43:23'),
(144, 4, 51, 54, 'completed', '2026-04-10 01:43:23'),
(145, 4, 52, 53, 'completed', '2026-04-10 01:43:23'),
(146, 4, 52, 54, 'completed', '2026-04-10 01:43:23'),
(147, 4, 52, 55, 'completed', '2026-04-10 01:43:23'),
(148, 4, 53, 54, 'completed', '2026-04-10 01:43:23'),
(149, 4, 53, 55, 'completed', '2026-04-10 01:43:23'),
(150, 4, 53, 56, 'completed', '2026-04-10 01:43:23'),
(151, 4, 54, 55, 'completed', '2026-04-10 01:43:23'),
(152, 4, 54, 56, 'completed', '2026-04-10 01:43:23'),
(153, 4, 54, 57, 'completed', '2026-04-10 01:43:23'),
(154, 4, 55, 56, 'completed', '2026-04-10 01:43:23'),
(155, 4, 55, 57, 'completed', '2026-04-10 01:43:23'),
(156, 4, 55, 58, 'completed', '2026-04-10 01:43:23'),
(157, 4, 56, 57, 'completed', '2026-04-10 01:43:23'),
(158, 4, 56, 58, 'completed', '2026-04-10 01:43:23'),
(159, 4, 56, 59, 'completed', '2026-04-10 01:43:23'),
(160, 4, 57, 58, 'completed', '2026-04-10 01:43:23'),
(161, 4, 57, 59, 'completed', '2026-04-10 01:43:23'),
(162, 4, 57, 1, 'completed', '2026-04-10 01:43:23'),
(163, 4, 58, 59, 'completed', '2026-04-10 01:43:23'),
(164, 4, 58, 1, 'completed', '2026-04-10 01:43:23'),
(165, 4, 58, 5, 'completed', '2026-04-10 01:43:23'),
(166, 4, 59, 1, 'completed', '2026-04-10 01:43:23'),
(167, 4, 59, 5, 'completed', '2026-04-10 01:43:23'),
(168, 4, 59, 6, 'completed', '2026-04-10 01:43:23'),

-- Event 5: 15 volunteers - ALL 'attended' and in task_assignment
(169, 5, 8, 9, 'completed', '2026-04-10 01:43:23'),
(170, 5, 8, 11, 'completed', '2026-04-10 01:43:23'),
(171, 5, 8, 12, 'completed', '2026-04-10 01:43:23'),
(172, 5, 9, 11, 'completed', '2026-04-10 01:43:23'),
(173, 5, 9, 12, 'completed', '2026-04-10 01:43:23'),
(174, 5, 9, 13, 'completed', '2026-04-10 01:43:23'),
(175, 5, 11, 12, 'completed', '2026-04-10 01:43:23'),
(176, 5, 11, 13, 'completed', '2026-04-10 01:43:23'),
(177, 5, 11, 14, 'completed', '2026-04-10 01:43:23'),
(178, 5, 12, 13, 'completed', '2026-04-10 01:43:23'),
(179, 5, 12, 14, 'completed', '2026-04-10 01:43:23'),
(180, 5, 12, 15, 'completed', '2026-04-10 01:43:23'),
(181, 5, 13, 14, 'completed', '2026-04-10 01:43:23'),
(182, 5, 13, 15, 'completed', '2026-04-10 01:43:23'),
(183, 5, 13, 16, 'completed', '2026-04-10 01:43:23'),
(184, 5, 14, 15, 'completed', '2026-04-10 01:43:23'),
(185, 5, 14, 16, 'completed', '2026-04-10 01:43:23'),
(186, 5, 14, 17, 'completed', '2026-04-10 01:43:23'),
(187, 5, 15, 16, 'completed', '2026-04-10 01:43:23'),
(188, 5, 15, 17, 'completed', '2026-04-10 01:43:23'),
(189, 5, 15, 18, 'completed', '2026-04-10 01:43:23'),
(190, 5, 16, 17, 'completed', '2026-04-10 01:43:23'),
(191, 5, 16, 18, 'completed', '2026-04-10 01:43:23'),
(192, 5, 16, 8, 'completed', '2026-04-10 01:43:23'),
(193, 5, 17, 18, 'completed', '2026-04-10 01:43:23'),
(194, 5, 17, 8, 'completed', '2026-04-10 01:43:23'),
(195, 5, 17, 9, 'completed', '2026-04-10 01:43:23'),
(196, 5, 18, 8, 'completed', '2026-04-10 01:43:23'),
(197, 5, 18, 9, 'completed', '2026-04-10 01:43:23'),
(198, 5, 18, 11, 'completed', '2026-04-10 01:43:23'),
(199, 5, 20, 21, 'completed', '2026-04-10 01:43:23'),
(200, 5, 20, 22, 'completed', '2026-04-10 01:43:23'),
(201, 5, 20, 23, 'completed', '2026-04-10 01:43:23'),
(202, 5, 22, 23, 'completed', '2026-04-10 01:43:23'),
(203, 5, 22, 24, 'completed', '2026-04-10 01:43:23'),
(204, 5, 22, 26, 'completed', '2026-04-10 01:43:23'),
(205, 5, 23, 24, 'completed', '2026-04-10 01:43:23'),
(206, 5, 23, 26, 'completed', '2026-04-10 01:43:23'),
(207, 5, 23, 27, 'completed', '2026-04-10 01:43:23'),
(208, 5, 24, 26, 'completed', '2026-04-10 01:43:23'),
(209, 5, 24, 27, 'completed', '2026-04-10 01:43:23'),
(210, 5, 24, 20, 'completed', '2026-04-10 01:43:23'),
(211, 5, 26, 27, 'completed', '2026-04-10 01:43:23'),
(212, 5, 26, 20, 'completed', '2026-04-10 01:43:23'),
(213, 5, 26, 22, 'completed', '2026-04-10 01:43:23'),
(214, 5, 27, 20, 'completed', '2026-04-10 01:43:23'),
(215, 5, 27, 22, 'completed', '2026-04-10 01:43:23'),
(216, 5, 27, 23, 'completed', '2026-04-10 01:43:23'),

-- Event 9: 12 volunteers - ALL 'attended'
(217, 9, 8, 9, 'completed', '2026-04-12 17:17:53'),
(218, 9, 8, 11, 'completed', '2026-04-12 17:17:53'),
(219, 9, 8, 12, 'completed', '2026-04-12 17:17:53'),
(220, 9, 9, 11, 'pending', '2026-04-12 17:17:53'),
(221, 9, 9, 12, 'pending', '2026-04-12 17:17:53'),
(222, 9, 9, 13, 'pending', '2026-04-12 17:17:53'),
(223, 9, 11, 12, 'pending', '2026-04-12 17:17:53'),
(224, 9, 11, 13, 'pending', '2026-04-12 17:17:53'),
(225, 9, 11, 1, 'pending', '2026-04-12 17:17:53'),
(226, 9, 12, 13, 'pending', '2026-04-12 17:17:53'),
(227, 9, 12, 1, 'pending', '2026-04-12 17:17:53'),
(228, 9, 12, 8, 'pending', '2026-04-12 17:17:53'),
(229, 9, 13, 1, 'pending', '2026-04-12 17:17:53'),
(230, 9, 13, 8, 'pending', '2026-04-12 17:17:53'),
(231, 9, 13, 9, 'pending', '2026-04-12 17:17:53'),
(232, 9, 1, 8, 'completed', '2026-04-12 17:17:53'),
(233, 9, 1, 9, 'completed', '2026-04-12 17:17:53'),
(234, 9, 1, 11, 'completed', '2026-04-12 17:17:53'),
(235, 9, 14, 15, 'pending', '2026-04-12 17:17:53'),
(236, 9, 14, 16, 'pending', '2026-04-12 17:17:53'),
(237, 9, 14, 17, 'pending', '2026-04-12 17:17:53'),
(238, 9, 15, 16, 'pending', '2026-04-12 17:17:53'),
(239, 9, 15, 17, 'pending', '2026-04-12 17:17:53'),
(240, 9, 15, 18, 'pending', '2026-04-12 17:17:53'),
(241, 9, 16, 17, 'pending', '2026-04-12 17:17:53'),
(242, 9, 16, 18, 'pending', '2026-04-12 17:17:53'),
(243, 9, 16, 5, 'pending', '2026-04-12 17:17:53'),
(244, 9, 17, 18, 'pending', '2026-04-12 17:17:53'),
(245, 9, 17, 5, 'pending', '2026-04-12 17:17:53'),
(246, 9, 17, 14, 'pending', '2026-04-12 17:17:53'),
(247, 9, 18, 5, 'pending', '2026-04-12 17:17:53'),
(248, 9, 18, 14, 'pending', '2026-04-12 17:17:53'),
(249, 9, 18, 15, 'pending', '2026-04-12 17:17:53'),
(250, 9, 5, 14, 'completed', '2026-04-12 17:17:53'),
(251, 9, 5, 15, 'completed', '2026-04-12 17:17:53'),
(252, 9, 5, 16, 'completed', '2026-04-12 17:17:53'),

-- Event 11: 12 volunteers - ALL 'attended'
(253, 11, 8, 9, 'completed', '2026-04-12 23:40:46'),
(254, 11, 8, 10, 'completed', '2026-04-12 23:40:46'),
(255, 11, 8, 35, 'completed', '2026-04-12 23:40:46'),
(256, 11, 9, 10, 'pending', '2026-04-12 23:40:46'),
(257, 11, 9, 35, 'pending', '2026-04-12 23:40:46'),
(258, 11, 9, 11, 'pending', '2026-04-12 23:40:46'),
(259, 11, 10, 35, 'pending', '2026-04-12 23:40:46'),
(260, 11, 10, 11, 'pending', '2026-04-12 23:40:46'),
(261, 11, 10, 1, 'pending', '2026-04-12 23:40:46'),
(262, 11, 35, 11, 'pending', '2026-04-12 23:40:46'),
(263, 11, 35, 1, 'pending', '2026-04-12 23:40:46'),
(264, 11, 35, 8, 'pending', '2026-04-12 23:40:46'),
(265, 11, 11, 1, 'pending', '2026-04-12 23:40:46'),
(266, 11, 11, 8, 'pending', '2026-04-12 23:40:46'),
(267, 11, 11, 9, 'pending', '2026-04-12 23:40:46'),
(268, 11, 1, 8, 'pending', '2026-04-12 23:40:46'),
(269, 11, 1, 9, 'pending', '2026-04-12 23:40:46'),
(270, 11, 1, 10, 'pending', '2026-04-12 23:40:46'),
(271, 11, 12, 13, 'pending', '2026-04-12 23:40:46'),
(272, 11, 12, 14, 'pending', '2026-04-12 23:40:46'),
(273, 11, 12, 15, 'pending', '2026-04-12 23:40:46'),
(274, 11, 13, 14, 'pending', '2026-04-12 23:40:46'),
(275, 11, 13, 15, 'pending', '2026-04-12 23:40:46'),
(276, 11, 13, 16, 'pending', '2026-04-12 23:40:46'),
(277, 11, 14, 15, 'pending', '2026-04-12 23:40:46'),
(278, 11, 14, 16, 'pending', '2026-04-12 23:40:46'),
(279, 11, 14, 17, 'pending', '2026-04-12 23:40:46'),
(280, 11, 15, 16, 'pending', '2026-04-12 23:40:46'),
(281, 11, 15, 17, 'pending', '2026-04-12 23:40:46'),
(282, 11, 15, 12, 'pending', '2026-04-12 23:40:46'),
(283, 11, 16, 17, 'pending', '2026-04-12 23:40:46'),
(284, 11, 16, 12, 'pending', '2026-04-12 23:40:46'),
(285, 11, 16, 13, 'pending', '2026-04-12 23:40:46'),
(286, 11, 17, 12, 'pending', '2026-04-12 23:40:46'),
(287, 11, 17, 13, 'pending', '2026-04-12 23:40:46'),
(288, 11, 17, 14, 'pending', '2026-04-12 23:40:46'),

-- Event 13: 9 volunteers - ALL 'attended'
(289, 13, 5, 8, 'completed', '2026-04-15 17:00:00'),
(290, 13, 5, 9, 'completed', '2026-04-15 17:00:00'),
(291, 13, 5, 10, 'completed', '2026-04-15 17:00:00'),
(292, 13, 8, 9, 'completed', '2026-04-15 17:00:00'),
(293, 13, 8, 10, 'completed', '2026-04-15 17:00:00'),
(294, 13, 8, 11, 'completed', '2026-04-15 17:00:00'),
(295, 13, 9, 10, 'completed', '2026-04-15 17:00:00'),
(296, 13, 9, 11, 'completed', '2026-04-15 17:00:00'),
(297, 13, 9, 12, 'completed', '2026-04-15 17:00:00'),
(298, 13, 10, 11, 'completed', '2026-04-15 17:00:00'),
(299, 13, 10, 12, 'completed', '2026-04-15 17:00:00'),
(300, 13, 10, 13, 'completed', '2026-04-15 17:00:00'),
(301, 13, 11, 12, 'completed', '2026-04-15 17:00:00'),
(302, 13, 11, 13, 'completed', '2026-04-15 17:00:00'),
(303, 13, 11, 14, 'completed', '2026-04-15 17:00:00'),
(304, 13, 12, 13, 'completed', '2026-04-15 17:00:00'),
(305, 13, 12, 14, 'completed', '2026-04-15 17:00:00'),
(306, 13, 12, 15, 'completed', '2026-04-15 17:00:00'),
(307, 13, 13, 14, 'completed', '2026-04-15 17:00:00'),
(308, 13, 13, 15, 'completed', '2026-04-15 17:00:00'),
(309, 13, 13, 5, 'completed', '2026-04-15 17:00:00'),
(310, 13, 14, 15, 'completed', '2026-04-15 17:00:00'),
(311, 13, 14, 5, 'completed', '2026-04-15 17:00:00'),
(312, 13, 14, 8, 'completed', '2026-04-15 17:00:00'),
(313, 13, 15, 5, 'completed', '2026-04-15 17:00:00'),
(314, 13, 15, 8, 'completed', '2026-04-15 17:00:00'),
(315, 13, 15, 9, 'completed', '2026-04-15 17:00:00'),

-- Event 15: 8 volunteers - ALL 'attended'
(316, 15, 8, 9, 'completed', '2026-04-13 17:00:00'),
(317, 15, 8, 10, 'completed', '2026-04-13 17:00:00'),
(318, 15, 8, 11, 'completed', '2026-04-13 17:00:00'),
(319, 15, 9, 10, 'completed', '2026-04-13 17:00:00'),
(320, 15, 9, 11, 'completed', '2026-04-13 17:00:00'),
(321, 15, 9, 12, 'completed', '2026-04-13 17:00:00'),
(322, 15, 10, 11, 'completed', '2026-04-13 17:00:00'),
(323, 15, 10, 12, 'completed', '2026-04-13 17:00:00'),
(324, 15, 10, 13, 'completed', '2026-04-13 17:00:00'),
(325, 15, 11, 12, 'completed', '2026-04-13 17:00:00'),
(326, 15, 11, 13, 'completed', '2026-04-13 17:00:00'),
(327, 15, 11, 14, 'completed', '2026-04-13 17:00:00'),
(328, 15, 12, 13, 'completed', '2026-04-13 17:00:00'),
(329, 15, 12, 14, 'completed', '2026-04-13 17:00:00'),
(330, 15, 12, 15, 'completed', '2026-04-13 17:00:00'),
(331, 15, 13, 14, 'completed', '2026-04-13 17:00:00'),
(332, 15, 13, 15, 'completed', '2026-04-13 17:00:00'),
(333, 15, 13, 8, 'completed', '2026-04-13 17:00:00'),
(334, 15, 14, 15, 'completed', '2026-04-13 17:00:00'),
(335, 15, 14, 8, 'completed', '2026-04-13 17:00:00'),
(336, 15, 14, 9, 'completed', '2026-04-13 17:00:00'),
(337, 15, 15, 8, 'completed', '2026-04-13 17:00:00'),
(338, 15, 15, 9, 'completed', '2026-04-13 17:00:00'),
(339, 15, 15, 10, 'completed', '2026-04-13 17:00:00'),

-- Event 18: 12 volunteers - ALL 'attended'
(340, 18, 8, 9, 'completed', '2026-04-14 00:19:47'),
(341, 18, 8, 10, 'completed', '2026-04-14 00:19:47'),
(342, 18, 8, 11, 'completed', '2026-04-14 00:19:47'),
(343, 18, 9, 10, 'pending', '2026-04-14 00:19:47'),
(344, 18, 9, 11, 'pending', '2026-04-14 00:19:47'),
(345, 18, 9, 12, 'pending', '2026-04-14 00:19:47'),
(346, 18, 10, 11, 'pending', '2026-04-14 00:19:47'),
(347, 18, 10, 12, 'pending', '2026-04-14 00:19:47'),
(348, 18, 10, 13, 'pending', '2026-04-14 00:19:47'),
(349, 18, 11, 12, 'pending', '2026-04-14 00:19:47'),
(350, 18, 11, 13, 'pending', '2026-04-14 00:19:47'),
(351, 18, 11, 14, 'pending', '2026-04-14 00:19:47'),
(352, 18, 12, 13, 'pending', '2026-04-14 00:19:47'),
(353, 18, 12, 14, 'pending', '2026-04-14 00:19:47'),
(354, 18, 12, 15, 'pending', '2026-04-14 00:19:47'),
(355, 18, 13, 14, 'pending', '2026-04-14 00:19:47'),
(356, 18, 13, 15, 'pending', '2026-04-14 00:19:47'),
(357, 18, 13, 16, 'pending', '2026-04-14 00:19:47'),
(358, 18, 14, 15, 'pending', '2026-04-14 00:19:47'),
(359, 18, 14, 16, 'pending', '2026-04-14 00:19:47'),
(360, 18, 14, 17, 'pending', '2026-04-14 00:19:47'),
(361, 18, 15, 16, 'pending', '2026-04-14 00:19:47'),
(362, 18, 15, 17, 'pending', '2026-04-14 00:19:47'),
(363, 18, 15, 18, 'pending', '2026-04-14 00:19:47'),
(364, 18, 16, 17, 'pending', '2026-04-14 00:19:47'),
(365, 18, 16, 18, 'pending', '2026-04-14 00:19:47'),
(366, 18, 16, 20, 'pending', '2026-04-14 00:19:47'),
(367, 18, 17, 18, 'pending', '2026-04-14 00:19:47'),
(368, 18, 17, 20, 'pending', '2026-04-14 00:19:47'),
(369, 18, 17, 8, 'pending', '2026-04-14 00:19:47'),
(370, 18, 18, 20, 'pending', '2026-04-14 00:19:47'),
(371, 18, 18, 8, 'pending', '2026-04-14 00:19:47'),
(372, 18, 18, 9, 'pending', '2026-04-14 00:19:47'),
(373, 18, 20, 8, 'pending', '2026-04-14 00:19:47'),
(374, 18, 20, 9, 'pending', '2026-04-14 00:19:47'),
(375, 18, 20, 10, 'pending', '2026-04-14 00:19:47'),

-- Event 21: 8 volunteers - ALL 'attended'
(376, 21, 8, 9, 'completed', '2026-04-14 17:00:00'),
(377, 21, 8, 10, 'completed', '2026-04-14 17:00:00'),
(378, 21, 8, 11, 'completed', '2026-04-14 17:00:00'),
(379, 21, 9, 10, 'completed', '2026-04-14 17:00:00'),
(380, 21, 9, 11, 'completed', '2026-04-14 17:00:00'),
(381, 21, 9, 12, 'completed', '2026-04-14 17:00:00'),
(382, 21, 10, 11, 'completed', '2026-04-14 17:00:00'),
(383, 21, 10, 12, 'completed', '2026-04-14 17:00:00'),
(384, 21, 10, 13, 'completed', '2026-04-14 17:00:00'),
(385, 21, 11, 12, 'completed', '2026-04-14 17:00:00'),
(386, 21, 11, 13, 'completed', '2026-04-14 17:00:00'),
(387, 21, 11, 14, 'completed', '2026-04-14 17:00:00'),
(388, 21, 12, 13, 'completed', '2026-04-14 17:00:00'),
(389, 21, 12, 14, 'completed', '2026-04-14 17:00:00'),
(390, 21, 12, 15, 'completed', '2026-04-14 17:00:00'),
(391, 21, 13, 14, 'completed', '2026-04-14 17:00:00'),
(392, 21, 13, 15, 'completed', '2026-04-14 17:00:00'),
(393, 21, 13, 8, 'completed', '2026-04-14 17:00:00'),
(394, 21, 14, 15, 'completed', '2026-04-14 17:00:00'),
(395, 21, 14, 8, 'completed', '2026-04-14 17:00:00'),
(396, 21, 14, 9, 'completed', '2026-04-14 17:00:00'),
(397, 21, 15, 8, 'completed', '2026-04-14 17:00:00'),
(398, 21, 15, 9, 'completed', '2026-04-14 17:00:00'),
(399, 21, 15, 10, 'completed', '2026-04-14 17:00:00'),

-- Event 35 (NEW - Apr 15, 2026) - 12 volunteers - ALL 'attended', points NOT processed
(400, 35, 8, 9, 'completed', '2026-04-15 19:00:00'),
(401, 35, 8, 10, 'completed', '2026-04-15 19:00:00'),
(402, 35, 8, 11, 'completed', '2026-04-15 19:00:00'),
(403, 35, 9, 10, 'completed', '2026-04-15 19:00:00'),
(404, 35, 9, 11, 'completed', '2026-04-15 19:00:00'),
(405, 35, 9, 12, 'completed', '2026-04-15 19:00:00'),
(406, 35, 10, 11, 'completed', '2026-04-15 19:00:00'),
(407, 35, 10, 12, 'completed', '2026-04-15 19:00:00'),
(408, 35, 10, 13, 'completed', '2026-04-15 19:00:00'),
(409, 35, 11, 12, 'completed', '2026-04-15 19:00:00'),
(410, 35, 11, 13, 'completed', '2026-04-15 19:00:00'),
(411, 35, 11, 14, 'completed', '2026-04-15 19:00:00'),
(412, 35, 12, 13, 'completed', '2026-04-15 19:00:00'),
(413, 35, 12, 14, 'completed', '2026-04-15 19:00:00'),
(414, 35, 12, 15, 'completed', '2026-04-15 19:00:00'),
(415, 35, 13, 14, 'completed', '2026-04-15 19:00:00'),
(416, 35, 13, 15, 'completed', '2026-04-15 19:00:00'),
(417, 35, 13, 16, 'completed', '2026-04-15 19:00:00'),
(418, 35, 14, 15, 'completed', '2026-04-15 19:00:00'),
(419, 35, 14, 16, 'completed', '2026-04-15 19:00:00'),
(420, 35, 14, 17, 'completed', '2026-04-15 19:00:00'),
(421, 35, 15, 16, 'completed', '2026-04-15 19:00:00'),
(422, 35, 15, 17, 'completed', '2026-04-15 19:00:00'),
(423, 35, 15, 18, 'completed', '2026-04-15 19:00:00'),
(424, 35, 16, 17, 'completed', '2026-04-15 19:00:00'),
(425, 35, 16, 18, 'completed', '2026-04-15 19:00:00'),
(426, 35, 16, 20, 'completed', '2026-04-15 19:00:00'),
(427, 35, 17, 18, 'completed', '2026-04-15 19:00:00'),
(428, 35, 17, 20, 'completed', '2026-04-15 19:00:00'),
(429, 35, 17, 8, 'completed', '2026-04-15 19:00:00'),
(430, 35, 18, 20, 'completed', '2026-04-15 19:00:00'),
(431, 35, 18, 8, 'completed', '2026-04-15 19:00:00'),
(432, 35, 18, 9, 'completed', '2026-04-15 19:00:00'),
(433, 35, 20, 8, 'completed', '2026-04-15 19:00:00'),
(434, 35, 20, 9, 'completed', '2026-04-15 19:00:00'),
(435, 35, 20, 14, 'completed', '2026-04-15 19:00:00');



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
(12, 62, 24, 'SPONSOR-1776290554-1632', '2026-04-16 03:32:34', 45000.00, '320032592030', 'accepted'),
(13, 60, 22, 'SPONSOR-1776291000-1000', '2026-04-16 04:00:00', 25000.00, '320032592031', 'accepted'),
(14, 61, 22, 'SPONSOR-1776291100-1100', '2026-04-16 04:10:00', 15000.00, '320032592032', 'accepted');

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
(1, 'planting mangrove saplings', 'plant mangrove saplings in designated blocks', 'completed', 4, 10, 10, 3, '2026-04-10 00:37:30'),
(2, 'debris removal', 'clear plastic, waste, and invasive plants', 'completed', 4, 15, 15, 3, '2026-04-10 00:38:22'),
(3, 'protective fencing setup', 'install barriers to protect young mangroves from damage', 'completed', 4, 14, 14, 3, '2026-04-10 00:40:03'),
(4, 'volunteer coordination', 'guide participants, assign zones, and manage workflow', 'completed', 4, 3, 3, 3, '2026-04-10 00:40:52'),
(5, 'Trail Waste Collection', 'Pick up plastic, bottles, and litter along the trail.', 'pending', 2, 50, 0, 3, '2026-04-10 00:51:04'),
(6, 'Waste Segregation', 'Separate collected waste into recyclable and non-recyclable categories.', 'pending', 2, 50, 0, 3, '2026-04-10 00:51:46'),
(7, 'Waste Transport Assistance', 'Help carry collected garbage down to proper disposal points.', 'pending', 2, 50, 0, 3, '2026-04-10 00:52:13'),
(8, 'Drain & Gutter Cleaning', 'Clear blocked drains to prevent flooding.', 'pending', 6, 25, 0, 3, '2026-04-10 00:53:19'),
(9, 'Waste Segregation', 'Sort collected waste into recyclable and non-recyclable items.', 'pending', 6, 25, 0, 3, '2026-04-10 00:53:48'),
(10, 'Install Disposal Bins', 'repair damaged garbage bins and install new ones where necessary', 'pending', 6, 25, 0, 3, '2026-04-10 00:54:57'),
(11, 'Shoreline Waste Collection', 'Collect plastic, glass, and debris along Unawatuna Beach.', 'pending', 1, 15, 0, 3, '2026-04-10 00:56:27'),
(12, 'Waste Sorting & Recycling', 'Separate collected waste into recyclable and non-recyclable categories.', 'pending', 1, 15, 0, 3, '2026-04-10 00:56:50'),
(13, 'Coral Fragment Planting', 'Attach and plant coral fragments onto reef structures at Nilaveli Beach.', 'completed', 3, 7, 7, 3, '2026-04-10 00:58:16'),
(14, 'Reef Cleaning & Maintenance', 'Remove algae, debris, and harmful waste from the coral restoration site.', 'completed', 3, 8, 8, 3, '2026-04-10 00:58:42'),
(15, 'Sapling Planting', 'Dig holes and plant native trees.', 'completed', 5, 10, 10, 5, '2026-04-10 01:24:04'),
(16, 'Watering & Maintenance', 'Water newly planted saplings and ensure they are stable and protected.', 'completed', 5, 9, 9, 5, '2026-04-10 01:25:03'),
(17, 'Soil Preparation & Pit Digging', 'Prepare planting pits and enrich soil with compost.', 'completed', 9, 6, 6, 5, '2026-04-10 01:26:28'),
(18, 'Plant Care & Watering', 'Water saplings and ensure proper support', 'completed', 9, 6, 6, 5, '2026-04-10 01:26:57'),
(19, 'Collect Polythene Waste', 'Pick up litter from roads, sidewalks, and public areas.', 'completed', 11, 6, 6, 3, '2026-04-10 08:32:51'),
(20, 'Waste Transport Coordination', 'Assist in moving collected waste to municipal disposal points.', 'completed', 11, 6, 6, 3, '2026-04-10 08:33:16'),
(21, 'Re-green the ocean floor', 'Plant the coral in the designates spots', 'completed', 16, 3, 3, 3, '2026-04-13 00:57:49'),
(22, 'Task 01', 'Collect polythene and plastic from the shoreline', 'completed', 12, 2, 2, 3, '2026-04-13 01:17:05'),
(23, 'Plant and Water the Saplings', 'Plant the plants using compost and later water them/', 'completed', 17, 3, 3, 3, '2026-04-13 02:02:28'),
(24, 'Beach Waste Collection', 'Collect plastic and debris from Galle Face beach', 'completed', 35, 6, 6, 3, '2026-04-15 08:00:00'),
(25, 'Waste Segregation', 'Separate recyclable and non-recyclable waste', 'completed', 35, 4, 4, 3, '2026-04-15 08:00:00'),
(26, 'Public Awareness', 'Distribute flyers and educate beach visitors', 'completed', 35, 2, 2, 3, '2026-04-15 08:00:00'),
(27, 'Task 01: Plant and Water Saplings', 'Plant and Water Saplings', 'completed', 18, 12, 12, 3, '2026-04-13 16:35:28'),
(28, 'T1', '1', 'completed', 19, 1, 1, 3, '2026-04-13 20:18:29'),
(29, 'Plastic Collection', 'Collect plastic waste from designated zones', 'completed', 25, 4, 4, 3, '2025-09-14 08:00:00'),
(30, 'Waste Sorting', 'Sort collected waste into categories', 'completed', 25, 4, 4, 3, '2025-09-14 08:00:00'),
(31, 'Tree Planting', 'Plant saplings in prepared pits', 'completed', 26, 4, 4, 3, '2025-10-19 08:00:00'),
(32, 'Watering', 'Water newly planted saplings', 'completed', 26, 4, 4, 3, '2025-10-19 08:00:00'),
(33, 'Beach Waste Collection', 'Collect waste along the shoreline', 'completed', 27, 4, 4, 3, '2025-11-09 08:00:00'),
(34, 'Reef Monitoring', 'Monitor coral health and growth', 'completed', 27, 4, 4, 3, '2025-11-09 08:00:00'),
(35, 'Mangrove Planting', 'Plant mangrove saplings in designated areas', 'completed', 28, 4, 4, 3, '2025-12-04 08:00:00'),
(36, 'Mangrove Protection', 'Install protective barriers around saplings', 'completed', 28, 4, 4, 3, '2025-12-04 08:00:00'),
(37, 'City Waste Collection', 'Collect waste from city streets', 'completed', 29, 4, 4, 3, '2026-01-14 08:00:00'),
(38, 'Public Awareness', 'Educate public on waste management', 'completed', 29, 4, 4, 3, '2026-01-14 08:00:00'),
(39, 'Mountain Trail Cleanup', 'Clean the mountain hiking trails', 'completed', 30, 4, 4, 3, '2026-02-19 08:00:00'),
(40, 'Waste Transport', 'Transport collected waste to disposal sites', 'completed', 30, 4, 4, 3, '2026-02-19 08:00:00'),
(41, 'Coral Fragment Collection', 'Collect coral fragments for restoration', 'completed', 31, 4, 4, 3, '2026-03-09 08:00:00'),
(42, 'Coral Attachment', 'Attach coral fragments to reef structures', 'completed', 31, 4, 4, 3, '2026-03-09 08:00:00'),
(43, 'Beach Zoning', 'Divide beach into zones for cleanup', 'completed', 32, 4, 4, 3, '2026-03-24 08:00:00'),
(44, 'Waste Collection', 'Collect waste from assigned zones', 'completed', 32, 4, 4, 3, '2026-03-24 08:00:00'),
(45, 'Sapling Distribution', 'Distribute saplings to planting locations', 'completed', 33, 4, 4, 3, '2026-04-04 08:00:00'),
(46, 'Tree Planting', 'Plant trees in designated areas', 'completed', 33, 4, 4, 3, '2026-04-04 08:00:00'),
(47, 'Beach Zoning', 'Divide beach into cleanup zones', 'pending', 34, 5, 0, 3, '2026-04-17 08:00:00'),
(48, 'Waste Collection', 'Collect waste from beach zones', 'pending', 34, 15, 0, 3, '2026-04-17 08:00:00'),
(49, 'Waste Sorting', 'Sort collected waste for recycling', 'pending', 34, 5, 0, 3, '2026-04-17 08:00:00');

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
-- Event 4 tasks
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

-- Event 5 tasks
(15, 8, '2026-04-10 01:24:33'),
(15, 9, '2026-04-10 01:24:33'),
(15, 11, '2026-04-10 01:24:33'),
(15, 12, '2026-04-10 01:24:33'),
(15, 13, '2026-04-10 01:24:33'),
(15, 14, '2026-04-10 01:24:33'),
(15, 15, '2026-04-10 01:24:33'),
(15, 16, '2026-04-10 01:24:33'),
(15, 17, '2026-04-10 01:24:16'),
(15, 18, '2026-04-10 01:24:33'),
(16, 19, '2026-04-10 01:25:13'),
(16, 20, '2026-04-10 01:25:13'),
(16, 21, '2026-04-10 01:25:13'),
(16, 22, '2026-04-10 01:25:13'),
(16, 23, '2026-04-10 01:25:13'),
(16, 24, '2026-04-10 01:25:13'),
(16, 26, '2026-04-10 01:25:13'),
(16, 27, '2026-04-10 01:25:13'),
(16, 28, '2026-04-10 01:25:13'),

-- Event 9 tasks
(17, 1, '2026-04-10 01:39:15'),
(17, 8, '2026-04-10 01:27:04'),
(17, 9, '2026-04-10 01:27:04'),
(17, 11, '2026-04-10 01:27:04'),
(17, 12, '2026-04-10 01:27:04'),
(17, 13, '2026-04-10 01:27:04'),
(18, 5, '2026-04-10 01:39:23'),
(18, 14, '2026-04-10 01:27:14'),
(18, 15, '2026-04-10 01:27:14'),
(18, 16, '2026-04-10 01:27:14'),
(18, 17, '2026-04-10 01:27:14'),
(18, 18, '2026-04-10 01:27:14'),

-- Event 11 tasks
(19, 1, '2026-04-10 08:33:30'),
(19, 8, '2026-04-10 08:33:30'),
(19, 9, '2026-04-10 08:33:30'),
(19, 10, '2026-04-10 08:33:30'),
(19, 11, '2026-04-10 08:33:30'),
(19, 35, '2026-04-12 23:38:33'),
(20, 12, '2026-04-12 23:38:17'),
(20, 13, '2026-04-12 23:38:17'),
(20, 14, '2026-04-12 23:38:17'),
(20, 15, '2026-04-12 23:38:17'),
(20, 16, '2026-04-12 23:38:17'),
(20, 17, '2026-04-12 23:38:17'),

-- Event 3 tasks
(13, 8, '2026-04-12 23:34:07'),
(13, 9, '2026-04-12 23:34:07'),
(13, 10, '2026-04-12 23:34:07'),
(13, 11, '2026-04-12 23:34:07'),
(13, 12, '2026-04-12 23:34:07'),
(13, 16, '2026-04-12 23:34:07'),
(13, 17, '2026-04-12 23:34:07'),
(14, 13, '2026-04-12 23:34:18'),
(14, 14, '2026-04-12 23:34:18'),
(14, 18, '2026-04-12 23:34:18'),
(14, 19, '2026-04-12 23:34:18'),
(14, 20, '2026-04-12 23:34:18'),
(14, 21, '2026-04-12 23:34:18'),
(14, 22, '2026-04-12 23:34:18'),
(14, 23, '2026-04-12 23:34:18'),

-- Event 12 tasks (2 volunteers - NO peer ratings)
(22, 8, '2026-04-13 01:18:12'),
(22, 9, '2026-04-13 01:18:12'),

-- Event 16 tasks (3 volunteers - NO peer ratings)
(21, 1, '2026-04-13 00:57:54'),
(21, 8, '2026-04-13 00:57:54'),
(21, 9, '2026-04-13 00:57:54'),

-- Event 17 tasks (3 volunteers - NO peer ratings)
(23, 8, '2026-04-13 02:02:33'),
(23, 9, '2026-04-13 02:02:33'),
(23, 10, '2026-04-13 02:02:33'),

-- Event 18 tasks (12 volunteers)
(27, 8, '2026-04-13 16:35:36'),
(27, 9, '2026-04-13 16:35:36'),
(27, 10, '2026-04-13 16:35:36'),
(27, 11, '2026-04-13 16:35:36'),
(27, 12, '2026-04-13 16:35:36'),
(27, 13, '2026-04-13 16:35:36'),
(27, 14, '2026-04-13 16:35:36'),
(27, 15, '2026-04-13 16:35:36'),
(27, 16, '2026-04-13 16:35:36'),
(27, 17, '2026-04-13 16:35:36'),
(27, 18, '2026-04-13 16:35:36'),
(27, 20, '2026-04-13 16:35:36'),

-- Event 19 tasks (3 volunteers - NO peer ratings)
(28, 8, '2026-04-13 20:18:29'),

-- Event 25 tasks (4 volunteers - NO peer ratings)
(29, 8, '2025-09-14 08:00:00'),
(29, 9, '2025-09-14 08:00:00'),
(29, 10, '2025-09-14 08:00:00'),
(30, 8, '2025-09-14 08:00:00'),
(30, 9, '2025-09-14 08:00:00'),

-- Event 26 tasks (4 volunteers - NO peer ratings)
(31, 8, '2025-10-19 08:00:00'),
(31, 9, '2025-10-19 08:00:00'),
(31, 11, '2025-10-19 08:00:00'),
(32, 8, '2025-10-19 08:00:00'),
(32, 9, '2025-10-19 08:00:00'),

-- Event 27 tasks (4 volunteers - NO peer ratings)
(33, 8, '2025-11-09 08:00:00'),
(33, 9, '2025-11-09 08:00:00'),
(33, 12, '2025-11-09 08:00:00'),
(34, 8, '2025-11-09 08:00:00'),
(34, 9, '2025-11-09 08:00:00'),

-- Event 28 tasks (4 volunteers - NO peer ratings)
(35, 8, '2025-12-04 08:00:00'),
(35, 9, '2025-12-04 08:00:00'),
(35, 13, '2025-12-04 08:00:00'),
(36, 8, '2025-12-04 08:00:00'),
(36, 9, '2025-12-04 08:00:00'),

-- Event 29 tasks (4 volunteers - NO peer ratings)
(37, 8, '2026-01-14 08:00:00'),
(37, 9, '2026-01-14 08:00:00'),
(37, 14, '2026-01-14 08:00:00'),
(38, 8, '2026-01-14 08:00:00'),
(38, 9, '2026-01-14 08:00:00'),

-- Event 30 tasks (4 volunteers - NO peer ratings)
(39, 8, '2026-02-19 08:00:00'),
(39, 9, '2026-02-19 08:00:00'),
(39, 15, '2026-02-19 08:00:00'),
(40, 8, '2026-02-19 08:00:00'),
(40, 9, '2026-02-19 08:00:00'),

-- Event 31 tasks (4 volunteers - NO peer ratings)
(41, 8, '2026-03-09 08:00:00'),
(41, 9, '2026-03-09 08:00:00'),
(41, 16, '2026-03-09 08:00:00'),
(42, 8, '2026-03-09 08:00:00'),
(42, 9, '2026-03-09 08:00:00'),

-- Event 32 tasks (4 volunteers - NO peer ratings)
(43, 8, '2026-03-24 08:00:00'),
(43, 9, '2026-03-24 08:00:00'),
(43, 17, '2026-03-24 08:00:00'),
(44, 8, '2026-03-24 08:00:00'),
(44, 9, '2026-03-24 08:00:00'),

-- Event 33 tasks (4 volunteers - NO peer ratings)
(45, 8, '2026-04-04 08:00:00'),
(45, 9, '2026-04-04 08:00:00'),
(45, 18, '2026-04-04 08:00:00'),
(46, 8, '2026-04-04 08:00:00'),
(46, 9, '2026-04-04 08:00:00'),

-- Event 34 tasks (planned - status 'pending')
(47, 8, '2026-04-17 08:00:00'),
(47, 9, '2026-04-17 08:00:00'),
(48, 8, '2026-04-17 08:00:00'),
(48, 9, '2026-04-17 08:00:00'),
(49, 8, '2026-04-17 08:00:00'),
(49, 9, '2026-04-17 08:00:00'),

-- Event 35 tasks (NEW - Apr 15, 2026 - points NOT processed)
(24, 8, '2026-04-15 07:30:00'),
(24, 9, '2026-04-15 07:30:00'),
(24, 10, '2026-04-15 07:30:00'),
(24, 11, '2026-04-15 07:30:00'),
(24, 12, '2026-04-15 07:30:00'),
(24, 13, '2026-04-15 07:30:00'),
(25, 14, '2026-04-15 07:30:00'),
(25, 15, '2026-04-15 07:30:00'),
(25, 16, '2026-04-15 07:30:00'),
(25, 17, '2026-04-15 07:30:00'),
(26, 18, '2026-04-15 07:30:00'),
(26, 20, '2026-04-15 07:30:00');


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
) ENGINE=MyISAM AUTO_INCREMENT=180 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task_performance_rating`
--

INSERT INTO `task_performance_rating` (`taskratingid`, `task_id`, `volunteer_id`, `rater_id`, `performance_score`, `comment`, `time_stamp`) VALUES
-- Event 4 task ratings
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

-- Event 5 task ratings
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

-- Event 9 task ratings
(61, 17, 1, 5, 4.00, 'Good soil preparation', '2026-04-10 18:00:00'),
(62, 17, 8, 5, 5.00, 'Excellent pit digging', '2026-04-10 18:00:00'),
(63, 17, 9, 5, 5.00, 'Great work', '2026-04-10 18:00:00'),
(64, 17, 11, 5, 4.00, 'Good effort', '2026-04-10 18:00:00'),
(65, 17, 12, 5, 4.00, 'Solid work', '2026-04-10 18:00:00'),
(66, 17, 13, 5, 5.00, 'Excellent', '2026-04-10 18:00:00'),
(67, 18, 5, 5, 4.00, 'Good watering', '2026-04-10 18:00:00'),
(68, 18, 14, 5, 5.00, 'Great care', '2026-04-10 18:00:00'),
(69, 18, 15, 5, 5.00, 'Excellent', '2026-04-10 18:00:00'),
(70, 18, 16, 5, 4.00, 'Good job', '2026-04-10 18:00:00'),
(71, 18, 17, 5, 5.00, 'Great', '2026-04-10 18:00:00'),
(72, 18, 18, 5, 4.00, 'Good', '2026-04-10 18:00:00'),

-- Event 11 task ratings
(73, 19, 1, 3, 4.00, 'Good waste collection', '2026-04-12 19:24:17'),
(74, 19, 8, 3, 4.00, 'Good work', '2026-04-12 19:24:17'),
(75, 19, 9, 3, 4.00, 'Solid effort', '2026-04-12 19:24:17'),
(76, 19, 10, 3, 4.00, 'Good', '2026-04-12 19:24:17'),
(77, 19, 11, 3, 4.00, 'Fine work', '2026-04-12 19:24:17'),
(78, 19, 35, 3, 3.00, 'Average', '2026-04-12 19:24:17'),
(79, 20, 12, 3, 5.00, 'Excellent coordination', '2026-04-12 23:39:42'),
(80, 20, 13, 3, 5.00, 'Great', '2026-04-12 23:39:42'),
(81, 20, 14, 3, 5.00, 'Excellent', '2026-04-12 23:39:42'),
(82, 20, 15, 3, 5.00, 'Superb', '2026-04-12 23:39:42'),
(83, 20, 16, 3, 5.00, 'Great work', '2026-04-12 23:39:42'),
(84, 20, 17, 3, 5.00, 'Excellent', '2026-04-12 23:39:42'),

-- Event 3 task ratings
(85, 13, 8, 3, 5.00, 'Excellent coral planting', '2026-04-12 23:34:32'),
(86, 13, 9, 3, 5.00, 'Great technique', '2026-04-12 23:34:32'),
(87, 13, 10, 3, 5.00, 'Very careful', '2026-04-12 23:34:32'),
(88, 13, 11, 3, 5.00, 'Excellent', '2026-04-12 23:34:32'),
(89, 13, 12, 3, 5.00, 'Great job', '2026-04-12 23:34:32'),
(90, 13, 16, 3, 5.00, 'Superb', '2026-04-12 23:34:32'),
(91, 13, 17, 3, 5.00, 'Excellent', '2026-04-12 23:34:32'),
(92, 14, 13, 3, 4.00, 'Room exists for improvement', '2026-04-12 23:34:46'),
(93, 14, 14, 3, 4.00, 'Good but could be better', '2026-04-12 23:34:46'),
(94, 14, 18, 3, 4.00, 'Solid effort', '2026-04-12 23:34:46'),
(95, 14, 19, 3, 4.00, 'Good work', '2026-04-12 23:34:46'),
(96, 14, 20, 3, 4.00, 'Decent job', '2026-04-12 23:34:46'),
(97, 14, 21, 3, 4.00, 'Good', '2026-04-12 23:34:46'),
(98, 14, 22, 3, 4.00, 'Fine', '2026-04-12 23:34:46'),
(99, 14, 23, 3, 4.00, 'Okay', '2026-04-12 23:34:46'),

-- Event 12 task ratings (2 volunteers)
(100, 22, 8, 3, 5.00, 'Good shoreline cleanup', '2026-04-13 01:18:29'),
(101, 22, 9, 3, 5.00, 'Excellent work', '2026-04-13 01:18:29'),

-- Event 16 task ratings (3 volunteers)
(102, 21, 1, 3, 4.00, 'Good coral planting', '2026-04-13 00:59:29'),
(103, 21, 8, 3, 4.00, 'Solid work', '2026-04-13 00:59:29'),
(104, 21, 9, 3, 4.00, 'Good effort', '2026-04-13 00:59:29'),

-- Event 17 task ratings (3 volunteers)
(105, 23, 8, 3, 4.00, 'Good planting', '2026-04-13 02:03:06'),
(106, 23, 9, 3, 4.00, 'Good work', '2026-04-13 02:03:06'),
(107, 23, 10, 3, 4.00, 'Good job', '2026-04-13 02:03:06'),

-- Event 18 task ratings (12 volunteers)
(108, 27, 8, 3, 5.00, 'Excellent mangrove planting', '2026-04-13 16:35:49'),
(109, 27, 9, 3, 5.00, 'Great work', '2026-04-13 16:35:49'),
(110, 27, 10, 3, 5.00, 'Excellent', '2026-04-13 16:35:49'),
(111, 27, 11, 3, 5.00, 'Superb', '2026-04-13 16:35:49'),
(112, 27, 12, 3, 5.00, 'Great', '2026-04-13 16:35:49'),
(113, 27, 13, 3, 5.00, 'Excellent', '2026-04-13 16:35:49'),
(114, 27, 14, 3, 5.00, 'Great job', '2026-04-13 16:35:49'),
(115, 27, 15, 3, 5.00, 'Excellent', '2026-04-13 16:35:49'),
(116, 27, 16, 3, 5.00, 'Superb', '2026-04-13 16:35:49'),
(117, 27, 17, 3, 5.00, 'Great', '2026-04-13 16:35:49'),
(118, 27, 18, 3, 5.00, 'Excellent', '2026-04-13 16:35:49'),
(119, 27, 20, 3, 5.00, 'Great work', '2026-04-13 16:35:49'),

-- Event 25 task ratings (4 volunteers - NO peer ratings)
(120, 29, 8, 3, 5.00, 'Excellent work on plastic collection', '2025-09-20 10:00:00'),
(121, 29, 9, 3, 5.00, 'Excellent work on plastic collection', '2025-09-20 10:00:00'),
(122, 29, 10, 3, 4.00, 'Good effort', '2025-09-20 10:00:00'),
(123, 30, 8, 3, 5.00, 'Great sorting skills', '2025-09-20 10:00:00'),
(124, 30, 9, 3, 4.00, 'Good job', '2025-09-20 10:00:00'),

-- Event 26 task ratings (4 volunteers)
(125, 31, 8, 3, 5.00, 'Planted trees efficiently', '2025-10-25 10:00:00'),
(126, 31, 9, 3, 5.00, 'Great planting technique', '2025-10-25 10:00:00'),
(127, 31, 11, 3, 4.00, 'Good effort', '2025-10-25 10:00:00'),
(128, 32, 8, 3, 5.00, 'Watered all saplings properly', '2025-10-25 10:00:00'),
(129, 32, 9, 3, 4.00, 'Good job', '2025-10-25 10:00:00'),

-- Event 27 task ratings (4 volunteers)
(130, 33, 8, 3, 5.00, 'Collected significant amount of waste', '2025-11-15 10:00:00'),
(131, 33, 9, 3, 5.00, 'Great teamwork', '2025-11-15 10:00:00'),
(132, 33, 12, 3, 4.00, 'Good effort', '2025-11-15 10:00:00'),
(133, 34, 8, 3, 5.00, 'Excellent reef monitoring', '2025-11-15 10:00:00'),
(134, 34, 9, 3, 4.00, 'Good observations', '2025-11-15 10:00:00'),

-- Event 28 task ratings (4 volunteers)
(135, 35, 8, 3, 5.00, 'Planted mangroves carefully', '2025-12-10 10:00:00'),
(136, 35, 9, 3, 5.00, 'Great work in muddy conditions', '2025-12-10 10:00:00'),
(137, 35, 13, 3, 4.00, 'Good effort', '2025-12-10 10:00:00'),
(138, 36, 8, 3, 5.00, 'Installed barriers effectively', '2025-12-10 10:00:00'),
(139, 36, 9, 3, 4.00, 'Good job', '2025-12-10 10:00:00'),

-- Event 29 task ratings (4 volunteers)
(140, 37, 8, 3, 5.00, 'Collected waste efficiently', '2026-01-20 10:00:00'),
(141, 37, 9, 3, 5.00, 'Great coverage of city streets', '2026-01-20 10:00:00'),
(142, 37, 14, 3, 4.00, 'Good effort', '2026-01-20 10:00:00'),
(143, 38, 8, 3, 5.00, 'Excellent public engagement', '2026-01-20 10:00:00'),
(144, 38, 9, 3, 4.00, 'Good communication skills', '2026-01-20 10:00:00'),

-- Event 30 task ratings (4 volunteers)
(145, 39, 8, 3, 5.00, 'Cleaned trail thoroughly', '2026-02-25 10:00:00'),
(146, 39, 9, 3, 5.00, 'Great work on mountain trails', '2026-02-25 10:00:00'),
(147, 39, 15, 3, 4.00, 'Good effort', '2026-02-25 10:00:00'),
(148, 40, 8, 3, 5.00, 'Coordinated waste transport well', '2026-02-25 10:00:00'),
(149, 40, 9, 3, 4.00, 'Good job', '2026-02-25 10:00:00'),

-- Event 31 task ratings (4 volunteers)
(150, 41, 8, 3, 5.00, 'Collected quality coral fragments', '2026-03-15 10:00:00'),
(151, 41, 9, 3, 5.00, 'Great selection of fragments', '2026-03-15 10:00:00'),
(152, 41, 16, 3, 4.00, 'Good effort', '2026-03-15 10:00:00'),
(153, 42, 8, 3, 5.00, 'Attached coral fragments securely', '2026-03-15 10:00:00'),
(154, 42, 9, 3, 4.00, 'Good technique', '2026-03-15 10:00:00'),

-- Event 32 task ratings (4 volunteers)
(155, 43, 8, 3, 5.00, 'Zoned beach effectively', '2026-03-30 10:00:00'),
(156, 43, 9, 3, 4.00, 'Good planning', '2026-03-30 10:00:00'),
(157, 43, 17, 3, 4.00, 'Good assistance', '2026-03-30 10:00:00'),
(158, 44, 8, 3, 5.00, 'Collected waste from zone efficiently', '2026-03-30 10:00:00'),
(159, 44, 9, 3, 5.00, 'Great coverage', '2026-03-30 10:00:00'),

-- Event 33 task ratings (4 volunteers)
(160, 45, 8, 3, 5.00, 'Distributed saplings effectively', '2026-04-10 10:00:00'),
(161, 45, 9, 3, 5.00, 'Great organization', '2026-04-10 10:00:00'),
(162, 45, 18, 3, 4.00, 'Good job', '2026-04-10 10:00:00'),
(163, 46, 8, 3, 5.00, 'Planted trees with care', '2026-04-10 10:00:00'),
(164, 46, 9, 3, 5.00, 'Excellent planting technique', '2026-04-10 10:00:00'),

-- Event 35 task ratings (NEW - Apr 15, 2026 - points NOT processed)
(165, 24, 8, 3, 5.00, 'Excellent beach waste collection, covered large area', '2026-04-15 18:00:00'),
(166, 24, 9, 3, 5.00, 'Great teamwork and efficiency', '2026-04-15 18:00:00'),
(167, 24, 10, 3, 4.50, 'Good effort, worked hard throughout', '2026-04-15 18:00:00'),
(168, 24, 11, 3, 5.00, 'Outstanding dedication', '2026-04-15 18:00:00'),
(169, 24, 12, 3, 4.00, 'Good work but could be faster', '2026-04-15 18:00:00'),
(170, 24, 13, 3, 5.00, 'Excellent, went beyond expectations', '2026-04-15 18:00:00'),
(171, 25, 14, 3, 4.50, 'Sorted waste accurately', '2026-04-15 18:00:00'),
(172, 25, 15, 3, 5.00, 'Great attention to detail', '2026-04-15 18:00:00'),
(173, 25, 16, 3, 4.00, 'Good but made few errors in sorting', '2026-04-15 18:00:00'),
(174, 25, 17, 3, 5.00, 'Excellent segregation skills', '2026-04-15 18:00:00'),
(175, 26, 18, 3, 4.50, 'Good communication with public', '2026-04-15 18:00:00'),
(176, 26, 20, 3, 5.00, 'Excellent awareness campaign', '2026-04-15 18:00:00');
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
(4, 'Seruwawila Mangrove Restoration', 'Help us restore and enhance the mangrove forests in the Seruwawila lagoon.', 'Mangrove Restoration', 1, 'completed', 0, 40, 80, '2026-04-09', '14:30:00', 'Seruwawila', 'https://www.google.com/maps?q=8.386168988007087,81.35024066833087', 'medium', 12600, 45, 42, 3, '2026-04-09 17:20:45', '5', 0, '2026-04-16 00:00:00', 0),
(5, 'Tree Planting Event - Hanthana', 'Help us reforest the hanthana mountain range damaged dure to forest fires.', 'Tree Planting', 1, 'completed', 0, 45, 90, '2026-04-09', '08:00:00', 'Hanthana - Kandy', 'https://www.google.com/maps?q=7.249068550351769,80.62711715698242', 'small', 15500, 20, 19, 5, '2026-04-09 23:39:39', '7', 0, '2026-04-16 00:00:00', 0),
(6, 'Annual City Cleanup', 'Help us take our streets back to cleanliness devoid of polythene pollutants.', 'City Cleanup', 1, 'planned', 1, 60, 120, '2026-05-30', '08:00:00', 'Colombo', '', 'large', 55000, 100, 31, 3, '2026-04-09 23:43:17', '12', 0, NULL, 0),
(7, 'Annual Beach Cleanup 2026', 'Help us clean the costal regions of Mannar to remove plastic pollutants from these pristine beaches.', 'Beach Cleanup', 0, 'planned', 1, 75, 140, '2026-06-01', '08:00:00', 'Mannar', 'https://www.google.com/maps?q=8.980447839707592,79.98934321546508', 'large', 55000, 100, 0, 3, '2026-04-09 23:56:12', '12', 0, NULL, 0),
(8, 'Annual Tree Planting 2026', 'Help us reclaim our rainforests and preserve these important ecosystems for the future.', 'Tree Planting', NULL, 'planned', 1, 80, 160, '2026-04-28', '10:00:00', 'Sinharaja Forest Reserve', 'https://www.google.com/maps?q=6.390906627702152,80.36198514497032', 'large', 47250, 90, 0, 3, '2026-04-10 00:00:16', '10', 0, NULL, 0),
(10, 'Tree Planting - Wilpattu Forest', 'Help us recover the deforested land due to logging operations.', 'Tree Planting', NULL, 'completed', 0, 50, 80, '2026-04-11', '08:00:00', 'Wilpattu National Park', 'https://www.google.com/maps?q=8.316218284723483,80.23055303844066', 'small', 17000, 20, 0, 5, '2026-04-10 01:10:26', '6', 0, '2026-04-18 00:00:00', 0),
(9, 'Tree Planting - Intercity', 'Help us regreen Maharagama City by incorporating foliage into the sidewalks.', 'Tree Planting', 1, 'completed', 0, 30, 60, '2026-04-10', '08:00:00', 'Maharagama City', 'https://www.google.com/maps?q=6.846446904140235,79.92843848844268', 'small', 4000, 12, 12, 5, '2026-04-10 00:19:50', '5', 0, '2026-04-17 00:00:00', 0),
(11, 'Gampola City Cleanup', 'Help us remove polythene waste from the streets of gampola.', 'City Cleanup', 1, 'completed', 0, 40, 80, '2026-04-10', '08:00:00', 'Gampola', 'https://www.google.com/maps?q=7.159882033571255,80.5661687521241', 'small', 4800, 12, 12, 3, '2026-04-10 08:21:55', '4', 0, '2026-04-17 00:00:00', 0),
(12, 'Coastal Revival: Mount Lavinia', 'Join us in restoring the beauty of Mount Lavinia beach by removing plastic waste and protecting marine life.', 'Beach Cleanup', 1, 'completed', 0, 55, 75, '2026-04-12', '09:00:00', 'Mount Lavinia', 'https://www.google.com/maps?q=7.239795540411543,79.84125435389834', 'medium', 16000, 40, 2, 3, '2026-04-12 15:49:46', '6', 0, '2026-04-19 00:00:00', 0),
(13, 'City Cleanup Kottawa', 'Help us clean the streets of Kottawa.', 'City Cleanup', 1, 'completed', 0, 25, 50, '2026-04-15', '06:00:00', 'Kottawa', 'https://www.google.com/maps?q=6.841558041666281,79.96465705131651', 'small', 8000, 20, 0, 5, '2026-04-12 17:41:51', '5', 0, '2026-04-22 00:00:00', 0),
(14, 'Community Clean - Maharagama', 'Help us clean the streets of Maharagama and make them polythene free.', 'City Cleanup', 1, 'planned', 1, 55, 100, '2026-04-20', '06:00:00', 'Maharagama', 'https://www.google.com/maps?q=6.848881264599564,79.92488394617419', 'large', 80000, 100, 0, 3, '2026-04-12 18:20:41', '8', 0, NULL, 0),
(15, 'Annual Tree Planting', 'Help us regreen the town of Ella and surrounding areas.', 'Tree Planting', NULL, 'completed', 1, 35, 70, '2026-04-13', '06:00:00', 'Ella', 'https://www.google.com/maps?q=6.888664950390668,81.04153660526644', 'large', 60000, 100, 0, 3, '2026-04-12 18:29:55', '8', 0, '2026-04-20 00:00:00', 0),
(16, 'Coral Restoration- Weligama', 'Help us regreen the ocean floor', 'Coral Restoration', 1, 'completed', 0, 5, 10, '2026-04-12', '14:00:00', 'Weligama', 'https://www.google.com/maps?q=5.973156201975434,80.4357660731263', 'small', 3000, 3, 3, 3, '2026-04-13 00:55:39', '12', 0, '2026-04-19 00:00:00', 0),
(17, 'Kottawa Tree Planting', 'Help us plant some saplings along the sidewalk of the kottawa bus stand', 'Tree Planting', 1, 'completed', 0, 10, 10, '2026-04-12', '08:00:00', 'Kottawa', 'https://www.google.com/maps?q=6.841718556092818,79.96509014511614', 'small', 300, 3, 3, 3, '2026-04-13 01:59:51', '2', 0, '2026-04-19 00:00:00', 0),
(18, 'Restore Mangroves Mannar', 'Help us recultivate the mangrove populations across the Mannar Coastline', 'Mangrove Restoration', 1, 'completed', 0, 30, 60, '2026-04-13', '08:00:00', 'Mannar', 'https://www.google.com/maps?q=8.97077106620987,79.90058237516463', 'small', 7400, 15, 12, 3, '2026-04-13 13:26:02', '3', 0, '2026-04-20 00:00:00', 0),
(19, 'Cleaner City - Kottawa', 'A small scale initiative to leisurely help clean the town of Kottawa.', 'City Cleanup', 1, 'completed', 0, 10, 20, '2026-04-13', '15:00:00', 'Kottawa', 'https://www.google.com/maps?q=6.841668886875638,79.96473553159555', 'small', 1000, 5, 0, 3, '2026-04-13 17:30:32', '3', 0, '2026-04-20 00:00:00', 0),
(20, 'Mangrove Restoration- Puttalam', 'A small Mangrove Restoration Event', 'Mangrove Restoration', 1, 'completed', 0, 12, 24, '2026-04-14', '10:00:00', 'Puttalam', 'https://www.google.com/maps?q=8.00859855845978,79.82839108751472', 'small', 1000, 10, 3, 3, '2026-04-14 09:08:52', '3', 0, '2026-04-21 00:00:00', 0),
(21, 'Horton Plains Cleanup', 'Help us clean up the plains and make them devoid of polythene.', 'Mountain Cleanup', 1, 'completed', 0, 25, 50, '2026-04-14', '12:00:00', 'Horton Plains', 'https://www.google.com/maps?q=6.817089810752076,80.80629633576116', 'small', 16000, 15, 0, 5, '2026-04-14 12:14:30', '6', 0, '2026-04-21 00:00:00', 0),
(22, 'National Tree Planting Day', 'Help us Regrow our burnt forests in the areas surrounding the Army Camp', 'Tree Planting', 1, 'planned', 1, 60, 100, '2026-04-20', '08:00:00', 'Diyathalawa Army Camp', 'https://www.google.com/maps/search/?api=1&query=6.80648666230706,80.94520568847656', 'large', 44800, 80, 0, 3, '2026-04-16 03:04:40', '6', 0, NULL, 0),
(23, 'World Coral Day Project', 'Help us regrow our sea-forests for the world coral day', 'Coral Restoration', 1, 'planned', 1, 45, 80, '2026-04-22', '11:00:00', 'Yala ', 'https://www.google.com/maps/search/?api=1&query=6.351726564342437,81.5087155488289', 'medium', 42000, 30, 0, 3, '2026-04-16 03:09:00', '5', 0, NULL, 0),
(24, 'World Mangrove Day', 'Help us plant mangroves along the kalu ganga.', 'Mangrove Restoration', 1, 'planned', 1, 45, 90, '2026-05-09', '16:00:00', 'Kalutara', 'https://www.google.com/maps/search/?api=1&query=6.607976017006803,79.97721904359071', 'small', 7000, 20, 0, 3, '2026-04-16 03:31:21', '5', 0, NULL, 0),
(25, 'Negombo Beach Cleanup - Sep 2025', 'Monthly beach cleanup at Negombo beach', 'Beach Cleanup', 1, 'completed', 0, 30, 50, '2025-09-15', '07:00:00', 'Negombo', 'https://maps.google.com/?q=7.2125,79.8386', 'small', 13000, 15, 4, 3, '2025-09-01 10:00:00', '6', 0, '2025-09-22 00:00:00', 0),
(26, 'Kandy City Cleanup - Oct 2025', 'City cleanup in Kandy city center', 'City Cleanup', 1, 'completed', 0, 35, 60, '2025-10-20', '08:00:00', 'Kandy', 'https://maps.google.com/?q=7.2906,80.6337', 'medium', 13000, 20, 4, 3, '2025-10-05 10:00:00', '5', 0, '2025-10-27 00:00:00', 0),
(27, 'Trincomalee Coral Restoration - Nov 2025', 'Coral restoration off Trincomalee coast', 'Coral Restoration', 1, 'completed', 0, 40, 70, '2025-11-10', '09:00:00', 'Trincomalee', 'https://maps.google.com/?q=8.5633,81.2330', 'small', 16000, 12, 4, 3, '2025-10-25 10:00:00', '4', 0, '2025-11-17 00:00:00', 0),
(28, 'Batticaloa Mangrove Planting - Dec 2025', 'Mangrove restoration along Batticaloa lagoon', 'Mangrove Restoration', 1, 'completed', 0, 35, 65, '2025-12-05', '07:30:00', 'Batticaloa', 'https://maps.google.com/?q=7.7177,81.7008', 'medium', 23000, 20, 4, 3, '2025-11-20 10:00:00', '6', 0, '2025-12-12 00:00:00', 0),
(29, 'Galle City Cleanup - Jan 2026', 'New Year city cleanup in Galle', 'City Cleanup', 1, 'completed', 0, 30, 55, '2026-01-15', '08:00:00', 'Galle', 'https://maps.google.com/?q=6.0328,80.2168', 'medium', 15000, 15, 4, 3, '2025-12-30 10:00:00', '5', 0, '2026-01-22 00:00:00', 0),
(30, 'Nuwara Eliya Mountain Cleanup - Feb 2026', 'Cleanup of mountain trails in Nuwara Eliya', 'Mountain Cleanup', 1, 'completed', 0, 35, 60, '2026-02-20', '07:00:00', 'Nuwara Eliya', 'https://maps.google.com/?q=6.9497,80.7891', 'small', 18000, 15, 4, 3, '2026-02-05 10:00:00', '4', 0, '2026-02-27 00:00:00', 0),
(31, 'Jaffna Beach Cleanup - Mar 2026', 'Spring beach cleanup in Jaffna', 'Beach Cleanup', 1, 'completed', 0, 30, 55, '2026-03-10', '07:30:00', 'Jaffna', 'https://maps.google.com/?q=9.6615,80.0255', 'small', 14000, 15, 4, 3, '2026-02-25 10:00:00', '5', 0, '2026-03-17 00:00:00', 0),
(32, 'Anuradhapura Tree Planting - Mar 2026', 'Tree planting around ancient city', 'Tree Planting', 1, 'completed', 0, 35, 65, '2026-03-25', '08:00:00', 'Anuradhapura', 'https://maps.google.com/?q=8.3114,80.4037', 'medium', 20000, 18, 4, 3, '2026-03-10 10:00:00', '4', 0, '2026-04-01 00:00:00', 0),
(33, 'Polonnaruwa City Cleanup - Apr 2026', 'City cleanup in Polonnaruwa', 'City Cleanup', 1, 'completed', 0, 30, 50, '2026-04-05', '07:00:00', 'Polonnaruwa', 'https://maps.google.com/?q=7.9393,81.0000', 'small', 11000, 15, 4, 3, '2026-03-20 10:00:00', '5', 0, '2026-04-12 00:00:00', 0),
(34, 'Negombo Beach Cleanup - Apr 2026', 'April beach cleanup at Negombo', 'Beach Cleanup', 1, 'planned', 0, 30, 50, '2026-04-20', '07:00:00', 'Negombo', 'https://maps.google.com/?q=7.2125,79.8386', 'small', 18000, 20, 6, 3, '2026-04-10 10:00:00', '5', 0, '2026-04-27 00:00:00', 0),
(35, 'Galle Face Beach Cleanup', 'Clean up the iconic Galle Face beach stretch and surrounding areas.', 'Beach Cleanup', 1, 'completed', 0, 35, 60, '2026-04-15', '07:00:00', 'Galle Face, Colombo', 'https://www.google.com/maps?q=6.9271,79.8430', 'medium', 25000, 30, 12, 3, '2026-04-10 08:00:00', '6', 0, '2026-04-22 00:00:00', 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `volunteer_badge`
--

INSERT INTO `volunteer_badge` (`badge_id`, `userid`, `badgeearned`, `earneddate`) VALUES
(1, 8, 'Mountain Sentinel', '2026-04-10'),
(2, 8, 'Mountain Sentinel', '2026-05-10');

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `volunteer_leave_history`
--

INSERT INTO `volunteer_leave_history` (`leave_id`, `volunteer_id`, `event_id`, `leave_date`, `days_before_event`, `level_points_lost`, `star_points_lost`, `reason`) VALUES
(1, 1, 13, '2026-04-12 18:47:29', 3, 14, 0, 'Voluntary withdrawal'),
(2, 1, 13, '2026-04-12 18:47:55', 3, 14, 0, 'Voluntary withdrawal'),
(3, 1, 13, '2026-04-12 18:49:28', 3, 14, 0, 'Voluntary withdrawal'),
(4, 5, 14, '2026-04-13 18:57:06', 7, 23, 0, 'Voluntary withdrawal'),
(5, 5, 14, '2026-04-13 18:57:47', 7, 23, 0, 'Voluntary withdrawal'),
(6, 5, 1, '2026-04-13 19:01:50', 17, 10, 0, 'Voluntary withdrawal'),
(7, 10, 25, '2025-09-14 10:00:00', 1, 10, 0, 'Voluntary withdrawal'),
(8, 13, 27, '2025-11-08 09:00:00', 2, 10, 0, 'Voluntary withdrawal'),
(9, 16, 30, '2026-02-18 11:00:00', 2, 10, 0, 'Voluntary withdrawal'),
(10, 18, 32, '2026-03-23 08:00:00', 2, 10, 0, 'Voluntary withdrawal');

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

--
-- Dumping data for table `volunteer_skill`
--

-- Removign Errored Peer Rating Inserts

DELETE FROM `peer_rating_assignment` WHERE `event_id` IN (12,16,17,19,20,25,26,27,28,29,30,31,32,33);
DELETE FROM `peer_rating` WHERE `event_id` IN (12,16,17,19,20,25,26,27,28,29,30,31,32,33);



-- New Additional Stuff

-- =====================================================
-- ADDITIONAL USERS (New Volunteers 64-100)
-- =====================================================

INSERT INTO `user` (`userid`, `name`, `password`, `email`, `contactnumber`, `role`, `createddate`, `status`, `profile_path`) VALUES
(64, 'Achini Perera', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v64@gmail.com', '0711001001', 'volunteer', '2026-04-10 10:00:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(65, 'Bandula Wijesiri', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v65@gmail.com', '0711001002', 'volunteer', '2026-04-10 10:05:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(66, 'Chamari Jayakody', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v66@gmail.com', '0711001003', 'volunteer', '2026-04-10 10:10:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(67, 'Dilshan Munaweera', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v67@gmail.com', '0711001004', 'volunteer', '2026-04-10 10:15:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(68, 'Erandi Rathnayake', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v68@gmail.com', '0711001005', 'volunteer', '2026-04-10 10:20:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(69, 'Faisal Hamid', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v69@gmail.com', '0711001006', 'volunteer', '2026-04-10 10:25:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(70, 'Gayani Weerasinghe', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v70@gmail.com', '0711001007', 'volunteer', '2026-04-10 10:30:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(71, 'Harsha Samarawickrama', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v71@gmail.com', '0711001008', 'volunteer', '2026-04-10 10:35:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(72, 'Imesha Gunasekara', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v72@gmail.com', '0711001009', 'volunteer', '2026-04-10 10:40:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(73, 'Janith Abeysekara', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v73@gmail.com', '0711001010', 'volunteer', '2026-04-10 10:45:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(74, 'Kavindya Peris', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v74@gmail.com', '0711001011', 'volunteer', '2026-04-10 10:50:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(75, 'Lakshan Fernando', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v75@gmail.com', '0711001012', 'volunteer', '2026-04-10 10:55:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(76, 'Madushani Hewage', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v76@gmail.com', '0711001013', 'volunteer', '2026-04-10 11:00:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(77, 'Nalaka Bandara', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v77@gmail.com', '0711001014', 'volunteer', '2026-04-10 11:05:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(78, 'Oshadhi Navaratne', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v78@gmail.com', '0711001015', 'volunteer', '2026-04-10 11:10:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(79, 'Prabath Ranasinghe', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v79@gmail.com', '0711001016', 'volunteer', '2026-04-10 11:15:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(80, 'Ruwini Senavirathne', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v80@gmail.com', '0711001017', 'volunteer', '2026-04-10 11:20:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(81, 'Sampath Liyanage', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v81@gmail.com', '0711001018', 'volunteer', '2026-04-10 11:25:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(82, 'Tharushi Jayaweera', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v82@gmail.com', '0711001019', 'volunteer', '2026-04-10 11:30:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(83, 'Upul Wickramasinghe', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v83@gmail.com', '0711001020', 'volunteer', '2026-04-10 11:35:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(84, 'Vidushi Perera', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v84@gmail.com', '0711001021', 'volunteer', '2026-04-10 11:40:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(85, 'Wasantha Kumara', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v85@gmail.com', '0711001022', 'volunteer', '2026-04-10 11:45:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(86, 'Yashodha Lakmali', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v86@gmail.com', '0711001023', 'volunteer', '2026-04-10 11:50:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(87, 'Zainab Marikkar', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v87@gmail.com', '0711001024', 'volunteer', '2026-04-10 11:55:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(88, 'Amali Rodrigo', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v88@gmail.com', '0711001025', 'volunteer', '2026-04-10 12:00:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(89, 'Buddhika Gunathilake', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v89@gmail.com', '0711001026', 'volunteer', '2026-04-10 12:05:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(90, 'Chandrika Dissanayake', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v90@gmail.com', '0711001027', 'volunteer', '2026-04-10 12:10:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(91, 'Dinesh Weerakkody', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v91@gmail.com', '0711001028', 'volunteer', '2026-04-10 12:15:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(92, 'Eshani Perera', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v92@gmail.com', '0711001029', 'volunteer', '2026-04-10 12:20:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(93, 'Gihan Rathnayake', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v93@gmail.com', '0711001030', 'volunteer', '2026-04-10 12:25:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(94, 'Hiruni Bandara', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v94@gmail.com', '0711001031', 'volunteer', '2026-04-10 12:30:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(95, 'Indika Jayawardena', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v95@gmail.com', '0711001032', 'volunteer', '2026-04-10 12:35:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(96, 'Janaki Muthumala', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v96@gmail.com', '0711001033', 'volunteer', '2026-04-10 12:40:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(97, 'Kanishka Amarasinghe', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v97@gmail.com', '0711001034', 'volunteer', '2026-04-10 12:45:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(98, 'Lahiru Madushanka', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v98@gmail.com', '0711001035', 'volunteer', '2026-04-10 12:50:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(99, 'Miyuru Kalhara', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v99@gmail.com', '0711001036', 'volunteer', '2026-04-10 12:55:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(100, 'Nipuni Samaraweera', '$2y$10$60Bc/Di8jHDhIXvj7vQwkevyRY2UCnVnyNMXtXe8YH6ThxCtWBd8S', 'v100@gmail.com', '0711001037', 'volunteer', '2026-04-10 13:00:00', 'active', '/V/uploads/profile_image/profile.jpg');

-- =====================================================
-- VOLUNTEER TABLE (New Volunteers 64-100)
-- =====================================================

INSERT INTO `volunteer` (`userid`, `levelpoints`, `starpoints`, `noofmembers`, `dob`, `QR`, `volunteer_experience`, `preferred_location_1`, `preferred_location_2`, `preferred_location_3`) VALUES
(64, 0, 0, 1, '1999-03-15', NULL, 'New volunteer excited to start contributing to environmental causes.', 'Colombo', 'Gampaha', 'Kalutara'),
(65, 25, 12, 1, '2000-07-22', NULL, 'Participated in beach cleanups in Negombo with local community groups.', 'Gampaha', 'Negombo', 'Colombo'),
(66, 0, 0, 1, '2001-11-05', NULL, 'First-time volunteer passionate about marine conservation.', 'Galle', 'Matara', 'Colombo'),
(67, 40, 20, 1, '1998-02-18', NULL, 'Volunteered with tree planting initiatives in Kandy district for 2 years.', 'Kandy', 'Matale', 'Nuwara Eliya'),
(68, 0, 0, 1, '2002-06-30', NULL, 'University student looking to gain experience in environmental projects.', 'Colombo', 'Gampaha', 'Kandy'),
(69, 15, 8, 1, '1997-09-12', NULL, 'Assisted in coral restoration awareness campaigns in Trincomalee.', 'Trincomalee', 'Batticaloa', 'Colombo'),
(70, 0, 0, 1, '2003-01-25', NULL, 'High school student eager to make a difference in local communities.', 'Colombo', 'Galle', 'Kandy'),
(71, 55, 28, 1, '1996-04-08', NULL, 'Experienced volunteer in city cleanup drives across Colombo suburbs.', 'Colombo', 'Gampaha', 'Kalutara'),
(72, 0, 0, 1, '2000-10-17', NULL, 'IT professional looking to give back to the community through environmental work.', 'Colombo', 'Gampaha', 'Kandy'),
(73, 30, 15, 1, '1999-12-03', NULL, 'Volunteered in mangrove restoration projects in Puttalam Lagoon.', 'Puttalam', 'Colombo', 'Gampaha'),
(74, 0, 0, 1, '2001-05-19', NULL, 'Fresh graduate interested in sustainability and conservation.', 'Colombo', 'Kandy', 'Galle'),
(75, 45, 22, 1, '1998-08-27', NULL, 'Active participant in mountain cleanup events in the central highlands.', 'Kandy', 'Nuwara Eliya', 'Badulla'),
(76, 0, 0, 1, '2002-02-14', NULL, 'Eager volunteer ready to join any environmental cleanup event.', 'Colombo', 'Gampaha', 'Kalutara'),
(77, 20, 10, 1, '1997-07-09', NULL, 'Volunteered in plastic waste segregation campaigns in Jaffna.', 'Jaffna', 'Colombo', 'Mannar'),
(78, 0, 0, 1, '2003-09-21', NULL, 'Young volunteer passionate about protecting marine ecosystems.', 'Galle', 'Matara', 'Hambantota'),
(79, 35, 18, 1, '2000-03-28', NULL, 'Contributed to reforestation efforts in degraded forest areas.', 'Kandy', 'Matale', 'Nuwara Eliya'),
(80, 0, 0, 1, '1999-11-11', NULL, 'Banking professional looking to volunteer on weekends.', 'Colombo', 'Gampaha', 'Kalutara'),
(81, 50, 25, 1, '1996-06-06', NULL, 'Long-time volunteer with experience in multiple beach cleanup events.', 'Colombo', 'Galle', 'Negombo'),
(82, 0, 0, 1, '2001-12-24', NULL, 'Engineering student eager to apply problem-solving skills to environmental challenges.', 'Colombo', 'Kandy', 'Galle'),
(83, 10, 5, 1, '1998-04-13', NULL, 'Beginner volunteer starting with local city cleanup events.', 'Colombo', 'Gampaha', 'Kalutara'),
(84, 0, 0, 1, '2002-08-30', NULL, 'Young professional looking to make a positive environmental impact.', 'Colombo', 'Gampaha', 'Kandy'),
(85, 60, 30, 1, '1995-10-10', NULL, 'Experienced volunteer coordinator for community-based cleanup initiatives.', 'Galle', 'Matara', 'Colombo'),
(86, 0, 0, 1, '2000-01-15', NULL, 'Medical student interested in the intersection of public health and environment.', 'Colombo', 'Gampaha', 'Kalutara'),
(87, 25, 12, 1, '1999-06-20', NULL, 'Volunteered in wetland restoration projects in Colombo suburbs.', 'Colombo', 'Gampaha', 'Kalutara'),
(88, 0, 0, 1, '2003-03-03', NULL, 'Recent high school graduate excited to start volunteering.', 'Colombo', 'Kandy', 'Galle'),
(89, 15, 8, 1, '1997-12-12', NULL, 'Participated in educational outreach programs about waste management.', 'Colombo', 'Gampaha', 'Kalutara'),
(90, 0, 0, 1, '2001-07-07', NULL, 'Marketing professional looking to volunteer for environmental causes.', 'Colombo', 'Galle', 'Kandy'),
(91, 40, 20, 1, '1998-09-09', NULL, 'Regular volunteer at local tree planting drives in Kandy district.', 'Kandy', 'Matale', 'Colombo'),
(92, 0, 0, 1, '2002-04-04', NULL, 'Psychology student interested in environmental psychology and conservation.', 'Colombo', 'Gampaha', 'Kalutara'),
(93, 20, 10, 1, '2000-11-18', NULL, 'Volunteered in coral reef monitoring programs in Hikkaduwa.', 'Galle', 'Matara', 'Colombo'),
(94, 0, 0, 1, '1999-02-28', NULL, 'Software engineer looking to use skills for environmental data collection.', 'Colombo', 'Gampaha', 'Kandy'),
(95, 35, 18, 1, '1996-08-08', NULL, 'Experienced in organizing community cleanups in residential areas.', 'Colombo', 'Gampaha', 'Kalutara'),
(96, 0, 0, 1, '2001-10-10', NULL, 'Fresh graduate eager to contribute to environmental sustainability.', 'Colombo', 'Kandy', 'Galle'),
(97, 10, 5, 1, '1998-05-05', NULL, 'Participated in one previous beach cleanup event.', 'Colombo', 'Gampaha', 'Negombo'),
(98, 0, 0, 1, '2002-12-25', NULL, 'Student volunteer excited to learn about environmental conservation.', 'Colombo', 'Gampaha', 'Kalutara'),
(99, 30, 15, 1, '1997-03-03', NULL, 'Volunteered in several city cleanup events in Colombo.', 'Colombo', 'Gampaha', 'Kandy'),
(100, 0, 0, 1, '2000-09-09', NULL, 'New volunteer looking to join upcoming environmental events.', 'Colombo', 'Galle', 'Kandy');

-- =====================================================
-- VOLUNTEER AVAILABILITY (New Volunteers 64-100)
-- =====================================================

INSERT INTO `volunteer_availability` (`userid`, `availability`) VALUES
(64, 'Sat-Morning'), (64, 'Sat-Afternoon'), (64, 'Sun-Morning'), (64, 'Sun-Afternoon'),
(65, 'Sat-Morning'), (65, 'Sat-Afternoon'), (65, 'Sun-Morning'),
(66, 'Sat-Morning'), (66, 'Sat-Afternoon'), (66, 'Sun-Morning'), (66, 'Sun-Afternoon'), (66, 'Mon-Evening'),
(67, 'Sat-Morning'), (67, 'Sat-Afternoon'), (67, 'Sun-Morning'), (67, 'Sun-Afternoon'),
(68, 'Sat-Morning'), (68, 'Sun-Morning'), (68, 'Mon-Evening'), (68, 'Tue-Evening'),
(69, 'Sat-Afternoon'), (69, 'Sun-Afternoon'), (69, 'Fri-Evening'),
(70, 'Sat-Morning'), (70, 'Sat-Afternoon'), (70, 'Sun-Morning'),
(71, 'Sat-Morning'), (71, 'Sat-Afternoon'), (71, 'Sun-Morning'), (71, 'Sun-Afternoon'), (71, 'Mon-Morning'),
(72, 'Sat-Morning'), (72, 'Sun-Morning'), (72, 'Wed-Evening'), (72, 'Thu-Evening'),
(73, 'Sat-Afternoon'), (73, 'Sun-Afternoon'), (73, 'Mon-Evening'), (73, 'Tue-Evening'),
(74, 'Sat-Morning'), (74, 'Sat-Afternoon'), (74, 'Sun-Morning'), (74, 'Sun-Afternoon'),
(75, 'Sat-Morning'), (75, 'Sat-Afternoon'), (75, 'Sun-Morning'),
(76, 'Sat-Morning'), (76, 'Sat-Afternoon'), (76, 'Sun-Morning'), (76, 'Sun-Afternoon'),
(77, 'Sat-Afternoon'), (77, 'Sun-Afternoon'), (77, 'Fri-Evening'), (77, 'Sat-Evening'),
(78, 'Sat-Morning'), (78, 'Sat-Afternoon'), (78, 'Sun-Morning'),
(79, 'Sat-Morning'), (79, 'Sat-Afternoon'), (79, 'Sun-Morning'), (79, 'Sun-Afternoon'), (79, 'Mon-Morning'),
(80, 'Sat-Morning'), (80, 'Sun-Morning'), (80, 'Thu-Evening'), (80, 'Fri-Evening'),
(81, 'Sat-Morning'), (81, 'Sat-Afternoon'), (81, 'Sun-Morning'), (81, 'Sun-Afternoon'),
(82, 'Sat-Afternoon'), (82, 'Sun-Afternoon'), (82, 'Mon-Evening'), (82, 'Tue-Evening'),
(83, 'Sat-Morning'), (83, 'Sat-Afternoon'), (83, 'Sun-Morning'),
(84, 'Sat-Morning'), (84, 'Sat-Afternoon'), (84, 'Sun-Morning'), (84, 'Sun-Afternoon'),
(85, 'Sat-Morning'), (85, 'Sat-Afternoon'), (85, 'Sun-Morning'),
(86, 'Sat-Morning'), (86, 'Sat-Afternoon'), (86, 'Sun-Morning'), (86, 'Sun-Afternoon'), (86, 'Mon-Morning'),
(87, 'Sat-Morning'), (87, 'Sun-Morning'), (87, 'Wed-Evening'), (87, 'Thu-Evening'),
(88, 'Sat-Afternoon'), (88, 'Sun-Afternoon'), (88, 'Mon-Evening'), (88, 'Tue-Evening'),
(89, 'Sat-Morning'), (89, 'Sat-Afternoon'), (89, 'Sun-Morning'), (89, 'Sun-Afternoon'),
(90, 'Sat-Morning'), (90, 'Sat-Afternoon'), (90, 'Sun-Morning'),
(91, 'Sat-Morning'), (91, 'Sat-Afternoon'), (91, 'Sun-Morning'), (91, 'Sun-Afternoon'),
(92, 'Sat-Afternoon'), (92, 'Sun-Afternoon'), (92, 'Fri-Evening'), (92, 'Sat-Evening'),
(93, 'Sat-Morning'), (93, 'Sat-Afternoon'), (93, 'Sun-Morning'),
(94, 'Sat-Morning'), (94, 'Sat-Afternoon'), (94, 'Sun-Morning'), (94, 'Sun-Afternoon'), (94, 'Mon-Morning'),
(95, 'Sat-Morning'), (95, 'Sun-Morning'), (95, 'Thu-Evening'), (95, 'Fri-Evening'),
(96, 'Sat-Morning'), (96, 'Sat-Afternoon'), (96, 'Sun-Morning'), (96, 'Sun-Afternoon'),
(97, 'Sat-Afternoon'), (97, 'Sun-Afternoon'), (97, 'Mon-Evening'), (97, 'Tue-Evening'),
(98, 'Sat-Morning'), (98, 'Sat-Afternoon'), (98, 'Sun-Morning'),
(99, 'Sat-Morning'), (99, 'Sat-Afternoon'), (99, 'Sun-Morning'), (99, 'Sun-Afternoon'),
(100, 'Sat-Morning'), (100, 'Sat-Afternoon'), (100, 'Sun-Morning');

-- =====================================================
-- NEW SPONSORS (101-105)
-- =====================================================

INSERT INTO `user` (`userid`, `name`, `password`, `email`, `contactnumber`, `role`, `createddate`, `status`, `profile_path`) VALUES
(101, 'Cargills Food City', '$2y$10$qWSKba3eJgO/WZxVY6.pjegdo0dzkDDtoiqYxf8Z9LZH.iR.FJgAK', 'cargills@cargills.lk', '0112465600', 'sponsor', '2026-04-12 09:00:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(102, 'John Keells Holdings', '$2y$10$qWSKba3eJgO/WZxVY6.pjegdo0dzkDDtoiqYxf8Z9LZH.iR.FJgAK', 'johnkeells@jkh.lk', '0112306400', 'sponsor', '2026-04-12 09:30:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(103, 'LOLC Holdings', '$2y$10$qWSKba3eJgO/WZxVY6.pjegdo0dzkDDtoiqYxf8Z9LZH.iR.FJgAK', 'lolc@lolc.lk', '0112039400', 'sponsor', '2026-04-12 10:00:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(104, 'Hemas Holdings', '$2y$10$qWSKba3eJgO/WZxVY6.pjegdo0dzkDDtoiqYxf8Z9LZH.iR.FJgAK', 'hemas@hemas.lk', '0112496000', 'sponsor', '2026-04-12 10:30:00', 'active', '/V/uploads/profile_image/profile.jpg'),
(105, 'Softlogic Holdings', '$2y$10$qWSKba3eJgO/WZxVY6.pjegdo0dzkDDtoiqYxf8Z9LZH.iR.FJgAK', 'softlogic@softlogic.lk', '0117646500', 'sponsor', '2026-04-12 11:00:00', 'active', '/V/uploads/profile_image/profile.jpg');

INSERT INTO `sponsor` (`userid`, `business_registration_number`, `year_established`, `official_website_link`, `about_company`, `organization_type`, `contact_person_name`, `contact_person_role`, `contact_person_email`, `contact_person_contact_number`, `logo_path`) VALUES
(101, 'PV00087654', '1983', 'https://www.cargillsceylon.com/', 'Cargills is Sri Lanka\'s leading modern retailer with a commitment to community development and sustainability.', 'company', 'Ranil Pathirana', 'CSR Manager', 'ranil.pathirana@cargills.lk', '0773456789', '/V/uploads/sponsor_logos/sponsor_101_1776000001.png'),
(102, 'PV00098765', '1877', 'https://www.keells.com/', 'John Keells Holdings is one of Sri Lanka\'s largest conglomerates, committed to sustainable business practices.', 'company', 'Nishani de Silva', 'Sustainability Head', 'nishani.desilva@jkh.lk', '0774567890', '/V/uploads/sponsor_logos/sponsor_102_1776000002.png'),
(103, 'PV00109876', '2003', 'https://www.lolc.com/', 'LOLC Holdings is a diversified conglomerate with strong commitment to environmental and social governance.', 'company', 'Dinesh Weerasinghe', 'CSR Director', 'dinesh.weerasinghe@lolc.lk', '0775678901', '/V/uploads/sponsor_logos/sponsor_103_1776000003.png'),
(104, 'PV00110987', '1948', 'https://www.hemas.com/', 'Hemas Holdings is a diversified conglomerate with a strong focus on healthcare, consumer goods, and sustainability.', 'company', 'Chamari Rodrigo', 'Sustainability Manager', 'chamari.rodrigo@hemas.lk', '0776789012', '/V/uploads/sponsor_logos/sponsor_104_1776000004.png'),
(105, 'PV00121098', '1991', 'https://www.softlogic.lk/', 'Softlogic Holdings is a diversified conglomerate operating in healthcare, retail, and financial services.', 'company', 'Sanjeewa Bandara', 'CSR Lead', 'sanjeewa.bandara@softlogic.lk', '0777890123', '/V/uploads/sponsor_logos/sponsor_105_1776000005.png');

-- =====================================================
-- NEW ANNUAL EVENTS (36-50) - More diverse annual events
-- =====================================================

INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(36, 'Annual Beach Cleanup - Beruwala', 'Annual cleanup of its most popular tourist beaches to remove plastic and debris before peak season.', 'Beach Cleanup', 1, 'planned', 1, 65, 130, '2026-12-05', '07:00:00', 'Beruwala Beach', 'https://www.google.com/maps?q=6.478500,79.986500', 'medium', 35000, 60, 0, 3, '2026-04-12 09:00:00', '6', 0, NULL, 0),
(37, 'Annual Coral Restoration - Pasikuda', 'Annual coral transplanting event at Pasikuda reef to restore damaged coral ecosystems.', 'Coral Restoration', 1, 'planned', 1, 85, 170, '2026-12-12', '07:30:00', 'Pasikuda', 'https://www.google.com/maps?q=7.923500,81.560500', 'medium', 45000, 30, 0, 3, '2026-04-12 10:00:00', '7', 0, NULL, 0),
(38, 'Annual Mangrove Planting - Chilaw', 'Large-scale annual mangrove restoration along the Chilaw lagoon system.', 'Mangrove Restoration', 1, 'planned', 1, 75, 150, '2026-12-18', '07:00:00', 'Chilaw', 'https://www.google.com/maps?q=7.582500,79.795500', 'large', 65000, 100, 0, 3, '2026-04-12 11:00:00', '8', 0, NULL, 0),
(39, 'Annual City Cleanup - Kurunegala', 'Annual city-wide cleanup event covering Kurunegala main commercial and residential areas.', 'City Cleanup', 1, 'planned', 1, 60, 120, '2026-12-22', '07:00:00', 'Kurunegala', 'https://www.google.com/maps?q=7.486170,80.362110', 'large', 55000, 80, 0, 3, '2026-04-12 12:00:00', '6', 0, NULL, 0),
(40, 'Annual Mountain Cleanup - Knuckles', 'Annual cleanup of the Knuckles Mountain Range trekking trails and campsites.', 'Mountain Cleanup', 1, 'planned', 1, 90, 180, '2027-01-08', '06:00:00', 'Knuckles Range', 'https://www.google.com/maps?q=7.464286,80.784500', 'large', 75000, 80, 0, 3, '2026-04-12 13:00:00', '10', 0, NULL, 0),
(41, 'Annual Tree Planting - Badulla', 'Annual reforestation event in the Badulla highlands targeting degraded cloud forest areas.', 'Tree Planting', 1, 'planned', 1, 70, 140, '2027-01-15', '07:00:00', 'Badulla', 'https://www.google.com/maps?q=6.993086,81.055289', 'large', 60000, 90, 0, 3, '2026-04-12 14:00:00', '7', 0, NULL, 0),
(42, 'Annual Beach Cleanup - Kalpitiya', 'Annual cleanup of Kalpitiya pristine beaches and the surrounding coastal areas.', 'Beach Cleanup', 1, 'planned', 1, 70, 140, '2027-01-22', '07:00:00', 'Kalpitiya', 'https://www.google.com/maps?q=8.231900,79.732900', 'medium', 40000, 70, 0, 3, '2026-04-12 15:00:00', '6', 0, NULL, 0),
(43, 'Annual Coral Survey - Hikkaduwa', 'Annual coral health survey and debris removal at Hikkaduwa Marine National Park.', 'Coral Restoration', 1, 'planned', 1, 95, 190, '2027-01-29', '07:30:00', 'Hikkaduwa', 'https://www.google.com/maps?q=6.139660,80.097290', 'medium', 50000, 40, 0, 3, '2026-04-12 16:00:00', '8', 0, NULL, 0),
(44, 'Annual Mangrove Drive - Negombo', 'Annual large-scale mangrove planting event around Negombo Lagoon.', 'Mangrove Restoration', 1, 'planned', 1, 80, 160, '2027-02-05', '07:00:00', 'Negombo Lagoon', 'https://www.google.com/maps?q=7.208743,79.838264', 'large', 70000, 120, 0, 3, '2026-04-12 17:00:00', '7', 0, NULL, 0),
(45, 'Annual City Cleanup - Galle', 'Annual heritage city cleanup focusing on Galle Fort and surrounding areas.', 'City Cleanup', 1, 'planned', 1, 65, 130, '2027-02-12', '07:00:00', 'Galle', 'https://www.google.com/maps?q=6.032800,80.216800', 'large', 60000, 100, 0, 3, '2026-04-12 18:00:00', '6', 0, NULL, 0),
(46, 'Annual Tree Planting - Ella', 'Annual tree planting event in the scenic Ella region focusing on native species restoration.', 'Tree Planting', 1, 'planned', 1, 75, 150, '2027-02-19', '07:00:00', 'Ella', 'https://www.google.com/maps?q=6.888664,81.041536', 'large', 55000, 80, 0, 3, '2026-04-12 19:00:00', '7', 0, NULL, 0),
(47, 'Annual Beach Cleanup - Arugam Bay', 'Annual flagship beach cleanup event at Sri Lankas premier surfing destination.', 'Beach Cleanup', 1, 'planned', 1, 100, 200, '2027-02-26', '06:30:00', 'Arugam Bay', 'https://www.google.com/maps?q=6.840122,81.831677', 'large', 85000, 150, 0, 3, '2026-04-12 20:00:00', '8', 0, NULL, 0),
(48, 'Annual Mountain Cleanup - Adams Peak', 'Annual pilgrimage trail cleanup of Sri Pada (Adams Peak) from Dalhousie.', 'Mountain Cleanup', 1, 'planned', 1, 110, 220, '2027-03-05', '05:00:00', 'Adams Peak', 'https://www.google.com/maps?q=6.808937,80.499771', 'large', 90000, 150, 0, 3, '2026-04-12 21:00:00', '10', 0, NULL, 0),
(49, 'Annual Mangrove Restoration - Puttalam', 'Large-scale annual mangrove replanting across the Puttalam Lagoon coastline.', 'Mangrove Restoration', 1, 'planned', 1, 85, 170, '2027-03-12', '07:00:00', 'Puttalam Lagoon', 'https://www.google.com/maps?q=8.031306,79.847870', 'large', 80000, 120, 0, 3, '2026-04-12 22:00:00', '8', 0, NULL, 0),
(50, 'Annual Coral Restoration - Trincomalee', 'Annual coral restoration event at the pristine Pigeon Island National Park.', 'Coral Restoration', 1, 'planned', 1, 105, 210, '2027-03-19', '07:00:00', 'Pigeon Island', 'https://www.google.com/maps?q=8.554560,81.224250', 'large', 95000, 50, 0, 3, '2026-04-12 23:00:00', '9', 0, NULL, 0);

-- =====================================================
-- ANNUAL EVENT APPROVALS (For new annual events 36-50)
-- =====================================================

INSERT INTO `annual_event_approvals` (`event_id`, `approver_id`, `approval_status`, `approval_date`) VALUES
(36, 6, 'approved', '2026-04-13 10:00:00'),
(36, 7, 'approved', '2026-04-13 10:30:00'),
(37, 6, 'approved', '2026-04-13 11:00:00'),
(37, 7, 'approved', '2026-04-13 11:30:00'),
(38, 6, 'approved', '2026-04-13 12:00:00'),
(38, 7, 'approved', '2026-04-13 12:30:00'),
(39, 6, 'approved', '2026-04-13 13:00:00'),
(39, 7, 'approved', '2026-04-13 13:30:00'),
(40, 6, 'approved', '2026-04-13 14:00:00'),
(40, 7, 'approved', '2026-04-13 14:30:00'),
(41, 6, 'approved', '2026-04-13 15:00:00'),
(41, 7, 'approved', '2026-04-13 15:30:00'),
(42, 6, 'approved', '2026-04-13 16:00:00'),
(42, 7, 'approved', '2026-04-13 16:30:00'),
(43, 6, 'approved', '2026-04-13 17:00:00'),
(43, 7, 'approved', '2026-04-13 17:30:00'),
(44, 6, 'approved', '2026-04-13 18:00:00'),
(44, 7, 'approved', '2026-04-13 18:30:00'),
(45, 6, 'approved', '2026-04-13 19:00:00'),
(45, 7, 'approved', '2026-04-13 19:30:00'),
(46, 6, 'approved', '2026-04-13 20:00:00'),
(46, 7, 'approved', '2026-04-13 20:30:00'),
(47, 6, 'approved', '2026-04-13 21:00:00'),
(47, 7, 'approved', '2026-04-13 21:30:00'),
(48, 6, 'approved', '2026-04-13 22:00:00'),
(48, 7, 'approved', '2026-04-13 22:30:00'),
(49, 6, 'approved', '2026-04-13 23:00:00'),
(49, 7, 'approved', '2026-04-13 23:30:00'),
(50, 6, 'approved', '2026-04-14 00:00:00'),
(50, 7, 'approved', '2026-04-14 00:30:00');

-- =====================================================
-- EVENT BUDGET ITEMS (For new annual events 36-50)
-- =====================================================

INSERT INTO `event_budget_item` (`event_id`, `item_name`, `item_price`, `created_date`) VALUES
(36, 'Trash Bags and Gloves', 8000.00, '2026-04-12 09:00:00'),
(36, 'Lunch Packets', 22000.00, '2026-04-12 09:00:00'),
(36, 'First-Aid Kits', 5000.00, '2026-04-12 09:00:00'),
(37, 'Diving Gear Rentals', 25000.00, '2026-04-12 10:00:00'),
(37, 'Coral Fragments', 10000.00, '2026-04-12 10:00:00'),
(37, 'Lunch Packets', 10000.00, '2026-04-12 10:00:00'),
(38, 'Mangrove Saplings', 30000.00, '2026-04-12 11:00:00'),
(38, 'Planting Tools', 15000.00, '2026-04-12 11:00:00'),
(38, 'Lunch Packets', 20000.00, '2026-04-12 11:00:00'),
(39, 'Large Garbage Bags', 15000.00, '2026-04-12 12:00:00'),
(39, 'Gloves and Safety Gear', 10000.00, '2026-04-12 12:00:00'),
(39, 'Lunch Packets', 30000.00, '2026-04-12 12:00:00'),
(40, 'Trash Bags and Gloves', 20000.00, '2026-04-12 13:00:00'),
(40, 'First-Aid Kits', 10000.00, '2026-04-12 13:00:00'),
(40, 'Lunch Packets', 40000.00, '2026-04-12 13:00:00'),
(40, 'Emergency Communication', 5000.00, '2026-04-12 13:00:00'),
(41, 'Sapling Stock', 30000.00, '2026-04-12 14:00:00'),
(41, 'Shovels and Tools', 15000.00, '2026-04-12 14:00:00'),
(41, 'Lunch Packets', 15000.00, '2026-04-12 14:00:00'),
(42, 'Trash Bags and Gloves', 12000.00, '2026-04-12 15:00:00'),
(42, 'Lunch Packets', 25000.00, '2026-04-12 15:00:00'),
(42, 'First-Aid Kits', 3000.00, '2026-04-12 15:00:00'),
(43, 'Diving Gear Rentals', 30000.00, '2026-04-12 16:00:00'),
(43, 'Underwater Survey Equipment', 10000.00, '2026-04-12 16:00:00'),
(43, 'Lunch Packets', 10000.00, '2026-04-12 16:00:00'),
(44, 'Mangrove Saplings', 35000.00, '2026-04-12 17:00:00'),
(44, 'Planting Tools', 15000.00, '2026-04-12 17:00:00'),
(44, 'Lunch Packets', 20000.00, '2026-04-12 17:00:00'),
(45, 'Large Garbage Bags', 15000.00, '2026-04-12 18:00:00'),
(45, 'Gloves and Safety Gear', 10000.00, '2026-04-12 18:00:00'),
(45, 'Lunch Packets', 35000.00, '2026-04-12 18:00:00'),
(46, 'Sapling Stock', 25000.00, '2026-04-12 19:00:00'),
(46, 'Shovels and Tools', 15000.00, '2026-04-12 19:00:00'),
(46, 'Lunch Packets', 15000.00, '2026-04-12 19:00:00'),
(47, 'Trash Bags and Gloves', 20000.00, '2026-04-12 20:00:00'),
(47, 'Lunch Packets', 50000.00, '2026-04-12 20:00:00'),
(47, 'First-Aid Kits', 10000.00, '2026-04-12 20:00:00'),
(47, 'Transport Assistance', 5000.00, '2026-04-12 20:00:00'),
(48, 'Trash Bags and Gloves', 25000.00, '2026-04-12 21:00:00'),
(48, 'Lunch Packets', 50000.00, '2026-04-12 21:00:00'),
(48, 'First-Aid Kits', 10000.00, '2026-04-12 21:00:00'),
(48, 'Emergency Support', 5000.00, '2026-04-12 21:00:00'),
(49, 'Mangrove Saplings', 40000.00, '2026-04-12 22:00:00'),
(49, 'Planting Tools', 20000.00, '2026-04-12 22:00:00'),
(49, 'Lunch Packets', 20000.00, '2026-04-12 22:00:00'),
(50, 'Diving Gear Rentals', 50000.00, '2026-04-12 23:00:00'),
(50, 'Coral Fragments', 20000.00, '2026-04-12 23:00:00'),
(50, 'Lunch Packets', 20000.00, '2026-04-12 23:00:00'),
(50, 'First-Aid Kits', 5000.00, '2026-04-12 23:00:00');

-- =====================================================
-- NEW REPRESENTATIVE APPLICATIONS (Volunteers 64-100 applying)
-- =====================================================

INSERT INTO `request` (`request_id`, `date`, `description`, `status`, `requester_volunteer_id`, `handler_representative_id`, `approver_manager_id`, `type`, `linkedin`) VALUES
(11, '2026-04-14', 'I want to help organize events and support volunteers in the Colombo region.', 'pending', 64, NULL, NULL, 'applytoberep', 'https://www.linkedin.com/in/achini-perera'),
(12, '2026-04-14', 'I have experience coordinating community events and want to contribute as a representative.', 'pending', 71, NULL, NULL, 'applytoberep', 'https://www.linkedin.com/in/harsha-samarawickrama'),
(13, '2026-04-14', 'Passionate about environmental conservation and want to take on leadership responsibilities.', 'pending', 85, NULL, NULL, 'applytoberep', 'https://www.linkedin.com/in/yashodha-lakmali'),
(14, '2026-04-14', 'I want to bridge the gap between volunteers and organizers to improve event coordination.', 'pending', 90, NULL, NULL, 'applytoberep', 'https://www.linkedin.com/in/chandrika-dissanayake');

-- =====================================================
-- ADDITIONAL ANNOUNCEMENTS
-- =====================================================

-- =====================================================
-- SPONSOR EVENT COMMITMENTS (New sponsors committing to events)
-- =====================================================

INSERT INTO `sponsor_event_commitment` (`sponsor_id`, `event_id`, `commitment_date`, `commitment_amount`, `status`) VALUES
(101, 36, '2026-04-14 10:00:00', 25000.00, 'accepted'),
(101, 42, '2026-04-14 10:15:00', 30000.00, 'accepted'),
(102, 38, '2026-04-14 11:00:00', 50000.00, 'accepted'),
(102, 45, '2026-04-14 11:15:00', 40000.00, 'accepted'),
(103, 40, '2026-04-14 12:00:00', 35000.00, 'accepted'),
(103, 46, '2026-04-14 12:15:00', 30000.00, 'accepted'),
(104, 37, '2026-04-14 13:00:00', 28000.00, 'accepted'),
(104, 43, '2026-04-14 13:15:00', 35000.00, 'accepted'),
(105, 41, '2026-04-14 14:00:00', 40000.00, 'accepted'),
(105, 47, '2026-04-14 14:15:00', 60000.00, 'accepted'),
(105, 50, '2026-04-14 14:30:00', 45000.00, 'accepted');

-- =====================================================
-- DONATIONS (From new sponsors)
-- =====================================================

INSERT INTO `donation` (`donationid`, `receivedamount`, `sponsorid`, `volunteer_id`, `order_id`, `transaction_date`, `event_id`, `transaction_id`, `status`) VALUES
(33, 25000.00, 101, NULL, 'SPONSOR-1776300001-0001', '2026-04-14 10:05:00', 36, '320032592100', 'complete'),
(34, 50000.00, 102, NULL, 'SPONSOR-1776300002-0002', '2026-04-14 11:05:00', 38, '320032592101', 'complete'),
(35, 35000.00, 103, NULL, 'SPONSOR-1776300003-0003', '2026-04-14 12:05:00', 40, '320032592102', 'complete'),
(36, 28000.00, 104, NULL, 'SPONSOR-1776300004-0004', '2026-04-14 13:05:00', 37, '320032592103', 'complete'),
(37, 40000.00, 105, NULL, 'SPONSOR-1776300005-0005', '2026-04-14 14:05:00', 41, '320032592104', 'complete'),
(38, 30000.00, 101, NULL, 'SPONSOR-1776300006-0006', '2026-04-14 10:10:00', 42, '320032592105', 'complete'),
(39, 40000.00, 102, NULL, 'SPONSOR-1776300007-0007', '2026-04-14 11:10:00', 45, '320032592106', 'complete'),
(40, 30000.00, 103, NULL, 'SPONSOR-1776300008-0008', '2026-04-14 12:10:00', 46, '320032592107', 'complete'),
(41, 35000.00, 104, NULL, 'SPONSOR-1776300009-0009', '2026-04-14 13:10:00', 43, '320032592108', 'complete'),
(42, 60000.00, 105, NULL, 'SPONSOR-1776300010-0010', '2026-04-14 14:10:00', 47, '320032592109', 'complete'),
(43, 45000.00, 105, NULL, 'SPONSOR-1776300011-0011', '2026-04-14 14:20:00', 50, '320032592110', 'complete');

-- =====================================================
-- DONATION USAGE (For new donations)
-- =====================================================

INSERT INTO `donation_usage` (`donationid`, `event_id`, `manager_id`, `used_amount`, `usage_date`, `purpose`) VALUES
(33, 36, 3, 25000.00, '2026-04-14', 'Beach cleanup supplies and volunteer refreshments'),
(34, 38, 3, 50000.00, '2026-04-14', 'Mangrove saplings and planting equipment'),
(35, 40, 3, 35000.00, '2026-04-14', 'Trail cleanup equipment and emergency support'),
(36, 37, 3, 28000.00, '2026-04-14', 'Diving gear rentals and coral fragments'),
(37, 41, 3, 40000.00, '2026-04-14', 'Tree saplings, tools, and volunteer meals'),
(38, 42, 3, 30000.00, '2026-04-14', 'Beach cleanup supplies and logistics'),
(39, 45, 3, 40000.00, '2026-04-14', 'City cleanup equipment and volunteer meals'),
(40, 46, 3, 30000.00, '2026-04-14', 'Tree saplings and planting tools'),
(41, 43, 3, 35000.00, '2026-04-14', 'Diving gear and survey equipment'),
(42, 47, 3, 60000.00, '2026-04-14', 'Beach cleanup supplies, transport, and meals'),
(43, 50, 3, 45000.00, '2026-04-14', 'Coral restoration equipment and diver support');

-- =====================================================
-- NOTIFICATIONS (For new events and sponsors)
-- =====================================================

-- =====================================================
-- VOLUNTEER BADGES (For active volunteers)
-- =====================================================

INSERT INTO `volunteer_badge` (`badge_id`, `userid`, `badgeearned`, `earneddate`) VALUES
(3, 71, 'City Guardian', '2026-04-14'),
(4, 75, 'Mountain Sentinel', '2026-04-14'),
(5, 81, 'Coral Guardian', '2026-04-14'),
(6, 85, 'Forest Builder', '2026-04-14'),
(7, 91, 'Mangrove Starter', '2026-03-14'),
(8, 91, 'Mountain Sentinel', '2026-04-14'),
(9, 91, 'Coral Guardian', '2026-04-15'),
(10, 91, 'Coral Guardian', '2026-04-16'),
(11, 91, 'Mangrove Starter', '2026-04-17');



-- New additoinal evenrs for demo day

-- =====================================================
-- EVENTS ORGANIZED BY USER ID 5 (Thivinya Abeyratna)
-- Dates: April 16, 17, 20, 21, 25, 30, 2026
-- =====================================================

-- Event 51: April 16, 2026 - Maharagama Urban Wetland Cleanup
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(51, 'Maharagama Urban Wetland Cleanup', 'Help us restore the urban wetland ecosystem in Maharagama by removing invasive plants and collecting plastic waste from the water bodies.', 'City Cleanup', 1, 'completed', 0, 35, 70, '2026-04-16', '07:00:00', 'Maharagama Wetland', 'https://www.google.com/maps?q=6.848881264599564,79.92488394617419', 'medium', 15000, 25, 18, 5, '2026-04-10 08:00:00', '6', 0, '2026-04-23 00:00:00', 0);

-- Event 52: April 17, 2026 - Piliyandala Canal Cleanup
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(52, 'Piliyandala Canal Cleanup', 'Join us to clear blocked canals in Piliyandala to prevent flooding and improve water flow in the urban drainage system.', 'City Cleanup', 1, 'completed', 0, 30, 60, '2026-04-17', '07:30:00', 'Piliyandala', 'https://www.google.com/maps?q=6.802000,79.920000', 'small', 10000, 20, 14, 5, '2026-04-11 09:00:00', '5', 0, '2026-04-24 00:00:00', 0);

-- Event 53: April 20, 2026 - Kottawa Forest Reserve Cleanup
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(53, 'Kottawa Forest Reserve Cleanup', 'Help us clean the Kottawa Forest Reserve trails and remove plastic waste from this important urban forest patch.', 'Mountain Cleanup', 1, 'planned', 0, 40, 80, '2026-04-20', '07:00:00', 'Kottawa Forest Reserve', 'https://www.google.com/maps?q=6.837500,79.965000', 'small', 12000, 20, 11, 5, '2026-04-12 10:00:00', '5', 0, NULL, 0);

-- Event 54: April 21, 2026 - Homagama School Tree Planting
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(54, 'Homagama School Tree Planting', 'Plant native trees and fruit trees at Homagama National School to create a greener learning environment for students.', 'Tree Planting', 1, 'planned', 0, 25, 50, '2026-04-21', '08:00:00', 'Homagama', 'https://www.google.com/maps?q=6.840000,80.000000', 'small', 8000, 15, 9, 5, '2026-04-13 11:00:00', '4', 0, NULL, 0);

-- Event 55: April 25, 2026 - Hanwella Riverside Cleanup
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(55, 'Hanwella Riverside Cleanup', 'Help us clean the banks of the Kelani River in Hanwella, removing plastic waste and educating local communities.', 'City Cleanup', 1, 'planned', 0, 45, 90, '2026-04-25', '07:00:00', 'Hanwella', 'https://www.google.com/maps?q=6.900000,80.083333', 'medium', 18000, 30, 17, 5, '2026-04-14 12:00:00', '6', 0, NULL, 0);

-- Event 56: April 30, 2026 - Kaduwela Urban Greening Project
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(56, 'Kaduwela Urban Greening Project', 'Plant flowering trees and shrubs along the main roads of Kaduwela to improve air quality and beautify the neighborhood.', 'Tree Planting', 1, 'planned', 0, 35, 70, '2026-04-30', '07:30:00', 'Kaduwela', 'https://www.google.com/maps?q=6.933333,79.983333', 'medium', 14000, 25, 13, 5, '2026-04-15 13:00:00', '5', 0, NULL, 0);

-- =====================================================
-- EVENT BUDGET ITEMS (For events 51-56)
-- =====================================================

INSERT INTO `event_budget_item` (`event_id`, `item_name`, `item_price`, `created_date`) VALUES
(51, 'Gloves and Rubber Boots', 5000.00, '2026-04-10 08:00:00'),
(51, 'Trash Bags and Nets', 4000.00, '2026-04-10 08:00:00'),
(51, 'Lunch Packets', 6000.00, '2026-04-10 08:00:00'),
(52, 'Waste Collection Tools', 3500.00, '2026-04-11 09:00:00'),
(52, 'Protective Gear', 2500.00, '2026-04-11 09:00:00'),
(52, 'Lunch Packets', 4000.00, '2026-04-11 09:00:00'),
(53, 'Trail Cleanup Equipment', 4000.00, '2026-04-12 10:00:00'),
(53, 'Trash Bags', 3000.00, '2026-04-12 10:00:00'),
(53, 'Lunch Packets', 5000.00, '2026-04-12 10:00:00'),
(54, 'Sapling Stock', 3500.00, '2026-04-13 11:00:00'),
(54, 'Shovels and Watering Cans', 2000.00, '2026-04-13 11:00:00'),
(54, 'Lunch Packets', 2500.00, '2026-04-13 11:00:00'),
(55, 'Riverside Cleanup Tools', 6000.00, '2026-04-14 12:00:00'),
(55, 'Safety Vests and Gloves', 4000.00, '2026-04-14 12:00:00'),
(55, 'Lunch Packets', 8000.00, '2026-04-14 12:00:00'),
(56, 'Sapling Stock', 6000.00, '2026-04-15 13:00:00'),
(56, 'Planting Tools and Compost', 4000.00, '2026-04-15 13:00:00'),
(56, 'Lunch Packets', 4000.00, '2026-04-15 13:00:00');

-- =====================================================
-- EVENT PARTICIPATION (For events 51-56)
-- =====================================================

-- Event 51 (Maharagama Wetland) - 18 volunteers (completed)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(51, 8, 'attended', '2026-04-12 08:00:00'),
(51, 9, 'attended', '2026-04-12 08:05:00'),
(51, 10, 'attended', '2026-04-12 08:10:00'),
(51, 11, 'attended', '2026-04-12 08:15:00'),
(51, 12, 'attended', '2026-04-12 08:20:00'),
(51, 13, 'attended', '2026-04-12 08:25:00'),
(51, 14, 'attended', '2026-04-12 08:30:00'),
(51, 15, 'attended', '2026-04-12 08:35:00'),
(51, 16, 'attended', '2026-04-12 08:40:00'),
(51, 17, 'attended', '2026-04-12 08:45:00'),
(51, 18, 'attended', '2026-04-12 08:50:00'),
(51, 20, 'attended', '2026-04-12 08:55:00'),
(51, 64, 'attended', '2026-04-12 09:00:00'),
(51, 65, 'attended', '2026-04-12 09:05:00'),
(51, 66, 'attended', '2026-04-12 09:10:00'),
(51, 67, 'attended', '2026-04-12 09:15:00'),
(51, 68, 'attended', '2026-04-12 09:20:00'),
(51, 69, 'attended', '2026-04-12 09:25:00');

-- Event 52 (Piliyandala Canal) - 14 volunteers (completed)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(52, 8, 'attended', '2026-04-13 08:00:00'),
(52, 9, 'attended', '2026-04-13 08:05:00'),
(52, 10, 'attended', '2026-04-13 08:10:00'),
(52, 11, 'attended', '2026-04-13 08:15:00'),
(52, 12, 'attended', '2026-04-13 08:20:00'),
(52, 13, 'attended', '2026-04-13 08:25:00'),
(52, 14, 'attended', '2026-04-13 08:30:00'),
(52, 15, 'attended', '2026-04-13 08:35:00'),
(52, 70, 'attended', '2026-04-13 08:40:00'),
(52, 71, 'attended', '2026-04-13 08:45:00'),
(52, 72, 'attended', '2026-04-13 08:50:00'),
(52, 73, 'attended', '2026-04-13 08:55:00'),
(52, 74, 'attended', '2026-04-13 09:00:00'),
(52, 75, 'attended', '2026-04-13 09:05:00');

-- Event 53 (Kottawa Forest) - 11 volunteers (planned)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(53, 8, 'registered', '2026-04-14 08:00:00'),
(53, 9, 'registered', '2026-04-14 08:05:00'),
(53, 10, 'registered', '2026-04-14 08:10:00'),
(53, 11, 'registered', '2026-04-14 08:15:00'),
(53, 12, 'registered', '2026-04-14 08:20:00'),
(53, 13, 'registered', '2026-04-14 08:25:00'),
(53, 76, 'registered', '2026-04-14 08:30:00'),
(53, 77, 'registered', '2026-04-14 08:35:00'),
(53, 78, 'registered', '2026-04-14 08:40:00'),
(53, 79, 'registered', '2026-04-14 08:45:00'),
(53, 80, 'registered', '2026-04-14 08:50:00');

-- Event 54 (Homagama School) - 9 volunteers (planned)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(54, 8, 'registered', '2026-04-15 08:00:00'),
(54, 9, 'registered', '2026-04-15 08:05:00'),
(54, 10, 'registered', '2026-04-15 08:10:00'),
(54, 81, 'registered', '2026-04-15 08:15:00'),
(54, 82, 'registered', '2026-04-15 08:20:00'),
(54, 83, 'registered', '2026-04-15 08:25:00'),
(54, 84, 'registered', '2026-04-15 08:30:00'),
(54, 85, 'registered', '2026-04-15 08:35:00'),
(54, 86, 'registered', '2026-04-15 08:40:00');

-- Event 55 (Hanwella Riverside) - 17 volunteers (planned)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(55, 8, 'registered', '2026-04-16 08:00:00'),
(55, 9, 'registered', '2026-04-16 08:05:00'),
(55, 10, 'registered', '2026-04-16 08:10:00'),
(55, 11, 'registered', '2026-04-16 08:15:00'),
(55, 12, 'registered', '2026-04-16 08:20:00'),
(55, 13, 'registered', '2026-04-16 08:25:00'),
(55, 14, 'registered', '2026-04-16 08:30:00'),
(55, 15, 'registered', '2026-04-16 08:35:00'),
(55, 87, 'registered', '2026-04-16 08:40:00'),
(55, 88, 'registered', '2026-04-16 08:45:00'),
(55, 89, 'registered', '2026-04-16 08:50:00'),
(55, 90, 'registered', '2026-04-16 08:55:00'),
(55, 91, 'registered', '2026-04-16 09:00:00'),
(55, 92, 'registered', '2026-04-16 09:05:00'),
(55, 93, 'registered', '2026-04-16 09:10:00'),
(55, 94, 'registered', '2026-04-16 09:15:00'),
(55, 95, 'registered', '2026-04-16 09:20:00');

-- Event 56 (Kaduwela Greening) - 13 volunteers (planned)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(56, 8, 'registered', '2026-04-17 08:00:00'),
(56, 9, 'registered', '2026-04-17 08:05:00'),
(56, 10, 'registered', '2026-04-17 08:10:00'),
(56, 11, 'registered', '2026-04-17 08:15:00'),
(56, 96, 'registered', '2026-04-17 08:20:00'),
(56, 97, 'registered', '2026-04-17 08:25:00'),
(56, 98, 'registered', '2026-04-17 08:30:00'),
(56, 99, 'registered', '2026-04-17 08:35:00'),
(56, 100, 'registered', '2026-04-17 08:40:00'),
(56, 64, 'registered', '2026-04-17 08:45:00'),
(56, 65, 'registered', '2026-04-17 08:50:00'),
(56, 66, 'registered', '2026-04-17 08:55:00'),
(56, 67, 'registered', '2026-04-17 09:00:00');

-- =====================================================
-- TASKS (For events 51-56)
-- =====================================================

INSERT INTO `task` (`task_id`, `name`, `description`, `status`, `event_id`, `max_participants`, `current_participants`, `organizer_id`, `createddate`) VALUES
(50, 'Wetland Waste Collection', 'Collect plastic and debris from the wetland edges and water surface.', 'completed', 51, 10, 10, 5, '2026-04-10 08:00:00'),
(51, 'Invasive Plant Removal', 'Remove invasive plants blocking natural water flow.', 'completed', 51, 8, 8, 5, '2026-04-10 08:00:00'),
(52, 'Canal Debris Clearing', 'Remove blockages from the main canal channels.', 'completed', 52, 8, 8, 5, '2026-04-11 09:00:00'),
(53, 'Waste Segregation', 'Sort collected waste for proper disposal and recycling.', 'completed', 52, 6, 6, 5, '2026-04-11 09:00:00'),
(54, 'Forest Trail Cleanup', 'Clear litter from the main walking trails.', 'pending', 53, 6, 0, 5, '2026-04-12 10:00:00'),
(55, 'Perimeter Fence Cleaning', 'Remove plastic stuck along the forest boundary fence.', 'pending', 53, 5, 0, 5, '2026-04-12 10:00:00'),
(56, 'Pit Digging', 'Dig holes for saplings around the school grounds.', 'pending', 54, 5, 0, 5, '2026-04-13 11:00:00'),
(57, 'Sapling Planting', 'Plant native trees and fruit saplings.', 'pending', 54, 5, 0, 5, '2026-04-13 11:00:00'),
(58, 'Riverside Waste Collection', 'Collect plastic along the Kelani River bank.', 'pending', 55, 12, 0, 5, '2026-04-14 12:00:00'),
(59, 'Public Awareness', 'Distribute flyers to local communities about river pollution.', 'pending', 55, 5, 0, 5, '2026-04-14 12:00:00'),
(60, 'Roadside Pit Preparation', 'Prepare pits along the main roads for planting.', 'pending', 56, 8, 0, 5, '2026-04-15 13:00:00'),
(61, 'Tree Planting', 'Plant flowering trees along the roadside.', 'pending', 56, 7, 0, 5, '2026-04-15 13:00:00');

-- =====================================================
-- TASK ASSIGNMENTS (For events 51-56)
-- =====================================================

-- Event 51 tasks
INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(50, 8, '2026-04-12 08:00:00'),
(50, 9, '2026-04-12 08:00:00'),
(50, 10, '2026-04-12 08:00:00'),
(50, 11, '2026-04-12 08:00:00'),
(50, 12, '2026-04-12 08:00:00'),
(50, 64, '2026-04-12 08:00:00'),
(50, 65, '2026-04-12 08:00:00'),
(50, 66, '2026-04-12 08:00:00'),
(50, 67, '2026-04-12 08:00:00'),
(50, 68, '2026-04-12 08:00:00'),
(51, 13, '2026-04-12 08:00:00'),
(51, 14, '2026-04-12 08:00:00'),
(51, 15, '2026-04-12 08:00:00'),
(51, 16, '2026-04-12 08:00:00'),
(51, 17, '2026-04-12 08:00:00'),
(51, 18, '2026-04-12 08:00:00'),
(51, 20, '2026-04-12 08:00:00'),
(51, 69, '2026-04-12 08:00:00');

-- Event 52 tasks
INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(52, 8, '2026-04-13 08:00:00'),
(52, 9, '2026-04-13 08:00:00'),
(52, 10, '2026-04-13 08:00:00'),
(52, 11, '2026-04-13 08:00:00'),
(52, 12, '2026-04-13 08:00:00'),
(52, 13, '2026-04-13 08:00:00'),
(52, 14, '2026-04-13 08:00:00'),
(52, 15, '2026-04-13 08:00:00'),
(53, 70, '2026-04-13 08:00:00'),
(53, 71, '2026-04-13 08:00:00'),
(53, 72, '2026-04-13 08:00:00'),
(53, 73, '2026-04-13 08:00:00'),
(53, 74, '2026-04-13 08:00:00'),
(53, 75, '2026-04-13 08:00:00');

-- Event 53 tasks
INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(54, 8, '2026-04-14 08:00:00'),
(54, 9, '2026-04-14 08:00:00'),
(54, 10, '2026-04-14 08:00:00'),
(54, 11, '2026-04-14 08:00:00'),
(54, 12, '2026-04-14 08:00:00'),
(54, 13, '2026-04-14 08:00:00'),
(55, 76, '2026-04-14 08:00:00'),
(55, 77, '2026-04-14 08:00:00'),
(55, 78, '2026-04-14 08:00:00'),
(55, 79, '2026-04-14 08:00:00'),
(55, 80, '2026-04-14 08:00:00');

-- Event 54 tasks
INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(56, 8, '2026-04-15 08:00:00'),
(56, 9, '2026-04-15 08:00:00'),
(56, 10, '2026-04-15 08:00:00'),
(56, 81, '2026-04-15 08:00:00'),
(56, 82, '2026-04-15 08:00:00'),
(57, 83, '2026-04-15 08:00:00'),
(57, 84, '2026-04-15 08:00:00'),
(57, 85, '2026-04-15 08:00:00'),
(57, 86, '2026-04-15 08:00:00');

-- Event 55 tasks
INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(58, 8, '2026-04-16 08:00:00'),
(58, 9, '2026-04-16 08:00:00'),
(58, 10, '2026-04-16 08:00:00'),
(58, 11, '2026-04-16 08:00:00'),
(58, 12, '2026-04-16 08:00:00'),
(58, 13, '2026-04-16 08:00:00'),
(58, 14, '2026-04-16 08:00:00'),
(58, 15, '2026-04-16 08:00:00'),
(58, 87, '2026-04-16 08:00:00'),
(58, 88, '2026-04-16 08:00:00'),
(58, 89, '2026-04-16 08:00:00'),
(58, 90, '2026-04-16 08:00:00'),
(59, 91, '2026-04-16 08:00:00'),
(59, 92, '2026-04-16 08:00:00'),
(59, 93, '2026-04-16 08:00:00'),
(59, 94, '2026-04-16 08:00:00'),
(59, 95, '2026-04-16 08:00:00');

-- Event 56 tasks
INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(60, 8, '2026-04-17 08:00:00'),
(60, 9, '2026-04-17 08:00:00'),
(60, 10, '2026-04-17 08:00:00'),
(60, 11, '2026-04-17 08:00:00'),
(60, 96, '2026-04-17 08:00:00'),
(60, 97, '2026-04-17 08:00:00'),
(60, 98, '2026-04-17 08:00:00'),
(61, 99, '2026-04-17 08:00:00'),
(61, 100, '2026-04-17 08:00:00'),
(61, 64, '2026-04-17 08:00:00'),
(61, 65, '2026-04-17 08:00:00'),
(61, 66, '2026-04-17 08:00:00'),
(61, 67, '2026-04-17 08:00:00');

-- =====================================================
-- ATTENDANCE RATINGS (For completed events 51-52)
-- =====================================================

-- Event 51 attendance ratings
INSERT INTO `attendance_rating` (`event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
(51, 8, 5, 5.00, '2026-04-16 18:00:00'),
(51, 9, 5, 5.00, '2026-04-16 18:00:00'),
(51, 10, 5, 4.50, '2026-04-16 18:00:00'),
(51, 11, 5, 5.00, '2026-04-16 18:00:00'),
(51, 12, 5, 4.00, '2026-04-16 18:00:00'),
(51, 13, 5, 5.00, '2026-04-16 18:00:00'),
(51, 14, 5, 5.00, '2026-04-16 18:00:00'),
(51, 15, 5, 4.50, '2026-04-16 18:00:00'),
(51, 16, 5, 5.00, '2026-04-16 18:00:00'),
(51, 17, 5, 5.00, '2026-04-16 18:00:00'),
(51, 18, 5, 4.00, '2026-04-16 18:00:00'),
(51, 20, 5, 5.00, '2026-04-16 18:00:00'),
(51, 64, 5, 5.00, '2026-04-16 18:00:00'),
(51, 65, 5, 4.50, '2026-04-16 18:00:00'),
(51, 66, 5, 5.00, '2026-04-16 18:00:00'),
(51, 67, 5, 5.00, '2026-04-16 18:00:00'),
(51, 68, 5, 4.00, '2026-04-16 18:00:00'),
(51, 69, 5, 5.00, '2026-04-16 18:00:00');

-- Event 52 attendance ratings
INSERT INTO `attendance_rating` (`event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
(52, 8, 5, 5.00, '2026-04-17 18:00:00'),
(52, 9, 5, 5.00, '2026-04-17 18:00:00'),
(52, 10, 5, 4.50, '2026-04-17 18:00:00'),
(52, 11, 5, 5.00, '2026-04-17 18:00:00'),
(52, 12, 5, 4.00, '2026-04-17 18:00:00'),
(52, 13, 5, 5.00, '2026-04-17 18:00:00'),
(52, 14, 5, 5.00, '2026-04-17 18:00:00'),
(52, 15, 5, 4.50, '2026-04-17 18:00:00'),
(52, 70, 5, 5.00, '2026-04-17 18:00:00'),
(52, 71, 5, 5.00, '2026-04-17 18:00:00'),
(52, 72, 5, 4.00, '2026-04-17 18:00:00'),
(52, 73, 5, 5.00, '2026-04-17 18:00:00'),
(52, 74, 5, 5.00, '2026-04-17 18:00:00'),
(52, 75, 5, 4.50, '2026-04-17 18:00:00');

-- =====================================================
-- TASK PERFORMANCE RATINGS (For completed events 51-52)
-- =====================================================

INSERT INTO `task_performance_rating` (`task_id`, `volunteer_id`, `rater_id`, `performance_score`, `comment`, `time_stamp`) VALUES
(50, 8, 5, 5.00, 'Excellent waste collection in the wetland area', '2026-04-16 17:00:00'),
(50, 9, 5, 5.00, 'Great teamwork and efficiency', '2026-04-16 17:00:00'),
(50, 10, 5, 4.50, 'Good effort, worked hard throughout', '2026-04-16 17:00:00'),
(50, 11, 5, 5.00, 'Outstanding dedication', '2026-04-16 17:00:00'),
(50, 12, 5, 4.00, 'Good work but could be faster', '2026-04-16 17:00:00'),
(50, 64, 5, 5.00, 'Excellent first-time volunteer', '2026-04-16 17:00:00'),
(50, 65, 5, 4.50, 'Good initiative', '2026-04-16 17:00:00'),
(50, 66, 5, 5.00, 'Very thorough', '2026-04-16 17:00:00'),
(50, 67, 5, 5.00, 'Great attention to detail', '2026-04-16 17:00:00'),
(50, 68, 5, 4.00, 'Solid performance', '2026-04-16 17:00:00'),
(51, 13, 5, 5.00, 'Excellent invasive plant removal', '2026-04-16 17:00:00'),
(51, 14, 5, 5.00, 'Very thorough', '2026-04-16 17:00:00'),
(51, 15, 5, 4.50, 'Good technique', '2026-04-16 17:00:00'),
(51, 16, 5, 5.00, 'Outstanding work', '2026-04-16 17:00:00'),
(51, 17, 5, 5.00, 'Great effort', '2026-04-16 17:00:00'),
(51, 18, 5, 4.00, 'Good but needs improvement', '2026-04-16 17:00:00'),
(51, 20, 5, 5.00, 'Excellent', '2026-04-16 17:00:00'),
(51, 69, 5, 5.00, 'Very dedicated', '2026-04-16 17:00:00'),
(52, 8, 5, 5.00, 'Excellent canal clearing work', '2026-04-17 17:00:00'),
(52, 9, 5, 5.00, 'Great teamwork', '2026-04-17 17:00:00'),
(52, 10, 5, 4.50, 'Good effort', '2026-04-17 17:00:00'),
(52, 11, 5, 5.00, 'Outstanding', '2026-04-17 17:00:00'),
(52, 12, 5, 4.00, 'Solid work', '2026-04-17 17:00:00'),
(52, 13, 5, 5.00, 'Excellent', '2026-04-17 17:00:00'),
(52, 14, 5, 5.00, 'Great job', '2026-04-17 17:00:00'),
(52, 15, 5, 4.50, 'Good', '2026-04-17 17:00:00'),
(53, 70, 5, 5.00, 'Excellent waste segregation', '2026-04-17 17:00:00'),
(53, 71, 5, 5.00, 'Very organized', '2026-04-17 17:00:00'),
(53, 72, 5, 4.00, 'Good but could be more efficient', '2026-04-17 17:00:00'),
(53, 73, 5, 5.00, 'Great attention to detail', '2026-04-17 17:00:00'),
(53, 74, 5, 5.00, 'Excellent', '2026-04-17 17:00:00'),
(53, 75, 5, 4.50, 'Good effort', '2026-04-17 17:00:00');

-- =====================================================
-- PEER RATING ASSIGNMENTS (For completed events 51-52)
-- =====================================================

-- Event 51 peer assignments
INSERT INTO `peer_rating_assignment` (`event_id`, `rater_id`, `ratee_id`, `status`, `created_date`) VALUES
(51, 8, 9, 'completed', '2026-04-16 18:30:00'),
(51, 8, 10, 'completed', '2026-04-16 18:30:00'),
(51, 8, 11, 'completed', '2026-04-16 18:30:00'),
(51, 9, 10, 'completed', '2026-04-16 18:30:00'),
(51, 9, 11, 'completed', '2026-04-16 18:30:00'),
(51, 9, 12, 'completed', '2026-04-16 18:30:00'),
(51, 10, 11, 'completed', '2026-04-16 18:30:00'),
(51, 10, 12, 'completed', '2026-04-16 18:30:00'),
(51, 10, 13, 'completed', '2026-04-16 18:30:00'),
(51, 11, 12, 'completed', '2026-04-16 18:30:00'),
(51, 11, 13, 'completed', '2026-04-16 18:30:00'),
(51, 11, 14, 'completed', '2026-04-16 18:30:00'),
(51, 12, 13, 'completed', '2026-04-16 18:30:00'),
(51, 12, 14, 'completed', '2026-04-16 18:30:00'),
(51, 12, 15, 'completed', '2026-04-16 18:30:00'),
(51, 13, 14, 'completed', '2026-04-16 18:30:00'),
(51, 13, 15, 'completed', '2026-04-16 18:30:00'),
(51, 13, 16, 'completed', '2026-04-16 18:30:00'),
(51, 14, 15, 'completed', '2026-04-16 18:30:00'),
(51, 14, 16, 'completed', '2026-04-16 18:30:00'),
(51, 14, 17, 'completed', '2026-04-16 18:30:00'),
(51, 15, 16, 'completed', '2026-04-16 18:30:00'),
(51, 15, 17, 'completed', '2026-04-16 18:30:00'),
(51, 15, 18, 'completed', '2026-04-16 18:30:00');

-- Event 52 peer assignments
INSERT INTO `peer_rating_assignment` (`event_id`, `rater_id`, `ratee_id`, `status`, `created_date`) VALUES
(52, 8, 9, 'completed', '2026-04-17 18:30:00'),
(52, 8, 10, 'completed', '2026-04-17 18:30:00'),
(52, 8, 11, 'completed', '2026-04-17 18:30:00'),
(52, 9, 10, 'completed', '2026-04-17 18:30:00'),
(52, 9, 11, 'completed', '2026-04-17 18:30:00'),
(52, 9, 12, 'completed', '2026-04-17 18:30:00'),
(52, 10, 11, 'completed', '2026-04-17 18:30:00'),
(52, 10, 12, 'completed', '2026-04-17 18:30:00'),
(52, 10, 13, 'completed', '2026-04-17 18:30:00'),
(52, 11, 12, 'completed', '2026-04-17 18:30:00'),
(52, 11, 13, 'completed', '2026-04-17 18:30:00'),
(52, 11, 14, 'completed', '2026-04-17 18:30:00'),
(52, 12, 13, 'completed', '2026-04-17 18:30:00'),
(52, 12, 14, 'completed', '2026-04-17 18:30:00'),
(52, 12, 15, 'completed', '2026-04-17 18:30:00'),
(52, 13, 14, 'completed', '2026-04-17 18:30:00'),
(52, 13, 15, 'completed', '2026-04-17 18:30:00'),
(52, 13, 70, 'completed', '2026-04-17 18:30:00'),
(52, 14, 15, 'completed', '2026-04-17 18:30:00'),
(52, 14, 70, 'completed', '2026-04-17 18:30:00'),
(52, 14, 71, 'completed', '2026-04-17 18:30:00'),
(52, 15, 70, 'completed', '2026-04-17 18:30:00'),
(52, 15, 71, 'completed', '2026-04-17 18:30:00'),
(52, 15, 72, 'completed', '2026-04-17 18:30:00');

-- =====================================================
-- PEER RATINGS (For completed events 51-52)
-- =====================================================

INSERT INTO `peer_rating` (`peer_rating_score`, `comment`, `rater_id`, `ratee_id`, `event_id`, `time_stamp`) VALUES
(5.00, 'Great teamwork on the wetland cleanup', 8, 9, 51, '2026-04-16 19:00:00'),
(4.50, 'Good effort overall', 8, 10, 51, '2026-04-16 19:00:00'),
(5.00, 'Excellent collaboration', 8, 11, 51, '2026-04-16 19:00:00'),
(5.00, 'Very organized and helpful', 9, 10, 51, '2026-04-16 19:00:00'),
(4.50, 'Good communication', 9, 11, 51, '2026-04-16 19:00:00'),
(4.00, 'Solid work overall', 9, 12, 51, '2026-04-16 19:00:00'),
(5.00, 'Really dedicated to the cause', 10, 11, 51, '2026-04-16 19:00:00'),
(4.00, 'Good but could be more proactive', 10, 12, 51, '2026-04-16 19:00:00'),
(5.00, 'Great leadership qualities', 10, 13, 51, '2026-04-16 19:00:00'),
(4.50, 'Worked well with the team', 11, 12, 51, '2026-04-16 19:00:00'),
(5.00, 'Excellent invasive plant removal', 11, 13, 51, '2026-04-16 19:00:00'),
(4.50, 'Good energy throughout', 11, 14, 51, '2026-04-16 19:00:00'),
(4.00, 'Consistent effort', 12, 13, 51, '2026-04-16 19:00:00'),
(4.50, 'Helpful with coordination', 12, 14, 51, '2026-04-16 19:00:00'),
(5.00, 'Went above and beyond', 12, 15, 51, '2026-04-16 19:00:00'),
(5.00, 'Great attitude', 13, 14, 51, '2026-04-16 19:00:00'),
(4.50, 'Good teamwork', 13, 15, 51, '2026-04-16 19:00:00'),
(4.00, 'Solid performer', 13, 16, 51, '2026-04-16 19:00:00'),
(5.00, 'Excellent contribution', 14, 15, 51, '2026-04-16 19:00:00'),
(4.50, 'Good effort', 14, 16, 51, '2026-04-16 19:00:00'),
(4.00, 'Worked hard', 14, 17, 51, '2026-04-16 19:00:00'),
(5.00, 'Great team player', 15, 16, 51, '2026-04-16 19:00:00'),
(4.50, 'Good communication skills', 15, 17, 51, '2026-04-16 19:00:00'),
(5.00, 'Excellent work ethic', 15, 18, 51, '2026-04-16 19:00:00'),
(5.00, 'Great canal cleanup work', 8, 9, 52, '2026-04-17 19:00:00'),
(4.50, 'Good effort', 8, 10, 52, '2026-04-17 19:00:00'),
(5.00, 'Excellent teamwork', 8, 11, 52, '2026-04-17 19:00:00'),
(5.00, 'Very efficient', 9, 10, 52, '2026-04-17 19:00:00'),
(4.00, 'Solid work', 9, 11, 52, '2026-04-17 19:00:00'),
(4.50, 'Good coordination', 9, 12, 52, '2026-04-17 19:00:00'),
(5.00, 'Great dedication', 10, 11, 52, '2026-04-17 19:00:00'),
(4.00, 'Good but could improve speed', 10, 12, 52, '2026-04-17 19:00:00'),
(5.00, 'Excellent', 10, 13, 52, '2026-04-17 19:00:00'),
(4.50, 'Good teamwork', 11, 12, 52, '2026-04-17 19:00:00'),
(5.00, 'Outstanding effort', 11, 13, 52, '2026-04-17 19:00:00'),
(4.50, 'Good contribution', 11, 14, 52, '2026-04-17 19:00:00'),
(4.00, 'Consistent performer', 12, 13, 52, '2026-04-17 19:00:00'),
(4.50, 'Helpful attitude', 12, 14, 52, '2026-04-17 19:00:00'),
(5.00, 'Excellent work', 12, 15, 52, '2026-04-17 19:00:00'),
(5.00, 'Great energy', 13, 14, 52, '2026-04-17 19:00:00'),
(4.50, 'Good communication', 13, 15, 52, '2026-04-17 19:00:00'),
(5.00, 'Outstanding new volunteer', 13, 70, 52, '2026-04-17 19:00:00'),
(5.00, 'Excellent work ethic', 14, 15, 52, '2026-04-17 19:00:00'),
(5.00, 'Great team player', 14, 70, 52, '2026-04-17 19:00:00'),
(4.50, 'Good effort', 14, 71, 52, '2026-04-17 19:00:00'),
(5.00, 'Outstanding', 15, 70, 52, '2026-04-17 19:00:00'),
(4.50, 'Good performance', 15, 71, 52, '2026-04-17 19:00:00'),
(4.00, 'Solid work', 15, 72, 52, '2026-04-17 19:00:00');

-- =====================================================
-- ANNOUNCEMENTS (For events 51-56)
-- =====================================================

-- =====================================================
-- NOTIFICATIONS (For events 51-56)
-- =====================================================




--  NEW peer rating inserts and inserting more peer rating stuff hehe

-- =====================================================
-- CASE 1: Event organized by Manager (userid=3) on April 8, 2026
-- Volunteer ID 1 has enrolled and has 3 pending peer ratings
-- Points are NOT yet processed
-- =====================================================

-- Event 57: April 8, 2026 - Dehiwala Beach Cleanup (organized by manager)
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(57, 'Dehiwala Beach Cleanup', 'Help us clean the Dehiwala beach stretch, removing plastic waste and debris to protect marine life and keep the beach beautiful for the community.', 'Beach Cleanup', 1, 'completed', 0, 40, 80, '2026-04-08', '07:00:00', 'Dehiwala Beach', 'https://www.google.com/maps?q=6.841558,79.874657', 'medium', 18000, 30, 15, 3, '2026-04-01 09:00:00', '6', 0, '2026-04-22 00:00:00', 0);

-- Event 57 - Budget Items
INSERT INTO `event_budget_item` (`event_id`, `item_name`, `item_price`, `created_date`) VALUES
(57, 'Trash Bags and Gloves', 5000.00, '2026-04-01 09:00:00'),
(57, 'Lunch Packets', 10000.00, '2026-04-01 09:00:00'),
(57, 'First-Aid Kits', 3000.00, '2026-04-01 09:00:00');

-- Event 57 - Tasks
INSERT INTO `task` (`task_id`, `name`, `description`, `status`, `event_id`, `max_participants`, `current_participants`, `organizer_id`, `createddate`) VALUES
(62, 'Shoreline Waste Collection', 'Collect plastic, bottles, and debris along the shoreline.', 'completed', 57, 8, 8, 3, '2026-04-01 09:00:00'),
(63, 'Tideline Sweep', 'Collect waste from the high tide line where most debris accumulates.', 'completed', 57, 7, 7, 3, '2026-04-01 09:00:00');

-- Event 57 - Event Participation (15 volunteers including volunteer ID 1)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(57, 1, 'attended', '2026-04-02 08:00:00'),
(57, 8, 'attended', '2026-04-02 08:05:00'),
(57, 9, 'attended', '2026-04-02 08:10:00'),
(57, 10, 'attended', '2026-04-02 08:15:00'),
(57, 11, 'attended', '2026-04-02 08:20:00'),
(57, 12, 'attended', '2026-04-02 08:25:00'),
(57, 13, 'attended', '2026-04-02 08:30:00'),
(57, 14, 'attended', '2026-04-02 08:35:00'),
(57, 15, 'attended', '2026-04-02 08:40:00'),
(57, 16, 'attended', '2026-04-02 08:45:00'),
(57, 17, 'attended', '2026-04-02 08:50:00'),
(57, 18, 'attended', '2026-04-02 08:55:00'),
(57, 20, 'attended', '2026-04-02 09:00:00'),
(57, 64, 'attended', '2026-04-02 09:05:00'),
(57, 65, 'attended', '2026-04-02 09:10:00');

-- Event 57 - Task Assignments
INSERT INTO `task_assignment` (`task_id`, `volunteer_id`, `assignment_date`) VALUES
(62, 1, '2026-04-02 08:00:00'),
(62, 8, '2026-04-02 08:00:00'),
(62, 9, '2026-04-02 08:00:00'),
(62, 10, '2026-04-02 08:00:00'),
(62, 11, '2026-04-02 08:00:00'),
(62, 12, '2026-04-02 08:00:00'),
(62, 13, '2026-04-02 08:00:00'),
(62, 14, '2026-04-02 08:00:00'),
(63, 15, '2026-04-02 08:00:00'),
(63, 16, '2026-04-02 08:00:00'),
(63, 17, '2026-04-02 08:00:00'),
(63, 18, '2026-04-02 08:00:00'),
(63, 20, '2026-04-02 08:00:00'),
(63, 64, '2026-04-02 08:00:00'),
(63, 65, '2026-04-02 08:00:00');

-- Event 57 - Attendance Ratings
INSERT INTO `attendance_rating` (`event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
(57, 1, 3, 5.00, '2026-04-08 18:00:00'),
(57, 8, 3, 5.00, '2026-04-08 18:00:00'),
(57, 9, 3, 5.00, '2026-04-08 18:00:00'),
(57, 10, 3, 4.50, '2026-04-08 18:00:00'),
(57, 11, 3, 5.00, '2026-04-08 18:00:00'),
(57, 12, 3, 4.00, '2026-04-08 18:00:00'),
(57, 13, 3, 5.00, '2026-04-08 18:00:00'),
(57, 14, 3, 5.00, '2026-04-08 18:00:00'),
(57, 15, 3, 4.50, '2026-04-08 18:00:00'),
(57, 16, 3, 5.00, '2026-04-08 18:00:00'),
(57, 17, 3, 5.00, '2026-04-08 18:00:00'),
(57, 18, 3, 4.00, '2026-04-08 18:00:00'),
(57, 20, 3, 5.00, '2026-04-08 18:00:00'),
(57, 64, 3, 5.00, '2026-04-08 18:00:00'),
(57, 65, 3, 4.50, '2026-04-08 18:00:00');

-- Event 57 - Task Performance Ratings
INSERT INTO `task_performance_rating` (`task_id`, `volunteer_id`, `rater_id`, `performance_score`, `comment`, `time_stamp`) VALUES
(62, 1, 3, 5.00, 'Excellent work on shoreline waste collection', '2026-04-08 17:00:00'),
(62, 8, 3, 5.00, 'Great teamwork and efficiency', '2026-04-08 17:00:00'),
(62, 9, 3, 5.00, 'Outstanding dedication', '2026-04-08 17:00:00'),
(62, 10, 3, 4.50, 'Good effort overall', '2026-04-08 17:00:00'),
(62, 11, 3, 5.00, 'Excellent performance', '2026-04-08 17:00:00'),
(62, 12, 3, 4.00, 'Solid work', '2026-04-08 17:00:00'),
(62, 13, 3, 5.00, 'Very thorough', '2026-04-08 17:00:00'),
(62, 14, 3, 5.00, 'Excellent', '2026-04-08 17:00:00'),
(63, 15, 3, 4.50, 'Good tideline sweep', '2026-04-08 17:00:00'),
(63, 16, 3, 5.00, 'Great attention to detail', '2026-04-08 17:00:00'),
(63, 17, 3, 5.00, 'Excellent', '2026-04-08 17:00:00'),
(63, 18, 3, 4.00, 'Good but could be faster', '2026-04-08 17:00:00'),
(63, 20, 3, 5.00, 'Outstanding', '2026-04-08 17:00:00'),
(63, 64, 3, 5.00, 'Great first-time volunteer', '2026-04-08 17:00:00'),
(63, 65, 3, 4.50, 'Good effort', '2026-04-08 17:00:00');

-- Event 57 - Peer Rating Assignments (Volunteer 1 needs to rate 3 peers: 8, 9, 10 - all pending)
INSERT INTO `peer_rating_assignment` (`event_id`, `rater_id`, `ratee_id`, `status`, `created_date`) VALUES
(57, 1, 8, 'pending', '2026-04-08 18:30:00'),
(57, 1, 9, 'pending', '2026-04-08 18:30:00'),
(57, 1, 10, 'pending', '2026-04-08 18:30:00'),
(57, 8, 1, 'completed', '2026-04-08 18:30:00'),
(57, 8, 9, 'completed', '2026-04-08 18:30:00'),
(57, 8, 10, 'completed', '2026-04-08 18:30:00'),
(57, 9, 1, 'completed', '2026-04-08 18:30:00'),
(57, 9, 10, 'completed', '2026-04-08 18:30:00'),
(57, 9, 11, 'completed', '2026-04-08 18:30:00'),
(57, 10, 1, 'completed', '2026-04-08 18:30:00'),
(57, 10, 11, 'completed', '2026-04-08 18:30:00'),
(57, 10, 12, 'completed', '2026-04-08 18:30:00'),
(57, 11, 12, 'completed', '2026-04-08 18:30:00'),
(57, 11, 13, 'completed', '2026-04-08 18:30:00'),
(57, 11, 14, 'completed', '2026-04-08 18:30:00'),
(57, 12, 13, 'completed', '2026-04-08 18:30:00'),
(57, 12, 14, 'completed', '2026-04-08 18:30:00'),
(57, 12, 15, 'completed', '2026-04-08 18:30:00'),
(57, 13, 14, 'completed', '2026-04-08 18:30:00'),
(57, 13, 15, 'completed', '2026-04-08 18:30:00'),
(57, 13, 16, 'completed', '2026-04-08 18:30:00'),
(57, 14, 15, 'completed', '2026-04-08 18:30:00'),
(57, 14, 16, 'completed', '2026-04-08 18:30:00'),
(57, 14, 17, 'completed', '2026-04-08 18:30:00'),
(57, 15, 16, 'completed', '2026-04-08 18:30:00'),
(57, 15, 17, 'completed', '2026-04-08 18:30:00'),
(57, 15, 18, 'completed', '2026-04-08 18:30:00'),
(57, 16, 17, 'completed', '2026-04-08 18:30:00'),
(57, 16, 18, 'completed', '2026-04-08 18:30:00'),
(57, 16, 20, 'completed', '2026-04-08 18:30:00'),
(57, 17, 18, 'completed', '2026-04-08 18:30:00'),
(57, 17, 20, 'completed', '2026-04-08 18:30:00'),
(57, 17, 64, 'completed', '2026-04-08 18:30:00'),
(57, 18, 20, 'completed', '2026-04-08 18:30:00'),
(57, 18, 64, 'completed', '2026-04-08 18:30:00'),
(57, 18, 65, 'completed', '2026-04-08 18:30:00'),
(57, 20, 64, 'completed', '2026-04-08 18:30:00'),
(57, 20, 65, 'completed', '2026-04-08 18:30:00'),
(57, 20, 1, 'completed', '2026-04-08 18:30:00'),
(57, 64, 65, 'completed', '2026-04-08 18:30:00'),
(57, 64, 1, 'completed', '2026-04-08 18:30:00'),
(57, 64, 8, 'completed', '2026-04-08 18:30:00'),
(57, 65, 1, 'completed', '2026-04-08 18:30:00'),
(57, 65, 8, 'completed', '2026-04-08 18:30:00'),
(57, 65, 9, 'completed', '2026-04-08 18:30:00');

-- Event 57 - Peer Ratings (All completed EXCEPT volunteer 1's 3 pending ratings)
INSERT INTO `peer_rating` (`peer_rating_score`, `comment`, `rater_id`, `ratee_id`, `event_id`, `time_stamp`) VALUES
(5.00, 'Great team player on the beach cleanup', 8, 1, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent work ethic', 8, 9, 57, '2026-04-08 19:00:00'),
(4.50, 'Good effort overall', 8, 10, 57, '2026-04-08 19:00:00'),
(5.00, 'Very helpful with coordination', 9, 1, 57, '2026-04-08 19:00:00'),
(4.50, 'Good communication', 9, 10, 57, '2026-04-08 19:00:00'),
(5.00, 'Great energy', 9, 11, 57, '2026-04-08 19:00:00'),
(4.00, 'Solid performance', 10, 1, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent', 10, 11, 57, '2026-04-08 19:00:00'),
(4.00, 'Good but could improve', 10, 12, 57, '2026-04-08 19:00:00'),
(5.00, 'Great teamwork', 11, 12, 57, '2026-04-08 19:00:00'),
(4.50, 'Good effort', 11, 13, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent dedication', 11, 14, 57, '2026-04-08 19:00:00'),
(4.00, 'Solid work', 12, 13, 57, '2026-04-08 19:00:00'),
(4.50, 'Good collaboration', 12, 14, 57, '2026-04-08 19:00:00'),
(5.00, 'Outstanding', 12, 15, 57, '2026-04-08 19:00:00'),
(5.00, 'Great attitude', 13, 14, 57, '2026-04-08 19:00:00'),
(4.50, 'Good teamwork', 13, 15, 57, '2026-04-08 19:00:00'),
(4.00, 'Consistent effort', 13, 16, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent contribution', 14, 15, 57, '2026-04-08 19:00:00'),
(4.50, 'Good effort', 14, 16, 57, '2026-04-08 19:00:00'),
(4.00, 'Worked hard', 14, 17, 57, '2026-04-08 19:00:00'),
(5.00, 'Great team player', 15, 16, 57, '2026-04-08 19:00:00'),
(4.50, 'Good communication', 15, 17, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent work ethic', 15, 18, 57, '2026-04-08 19:00:00'),
(4.00, 'Good but room for improvement', 16, 17, 57, '2026-04-08 19:00:00'),
(4.50, 'Solid performer', 16, 18, 57, '2026-04-08 19:00:00'),
(5.00, 'Great job', 16, 20, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent', 17, 18, 57, '2026-04-08 19:00:00'),
(4.50, 'Good effort', 17, 20, 57, '2026-04-08 19:00:00'),
(5.00, 'Outstanding new volunteer', 17, 64, 57, '2026-04-08 19:00:00'),
(4.00, 'Solid work', 18, 20, 57, '2026-04-08 19:00:00'),
(5.00, 'Great first-timer', 18, 64, 57, '2026-04-08 19:00:00'),
(4.50, 'Good effort', 18, 65, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent teamwork', 20, 64, 57, '2026-04-08 19:00:00'),
(4.50, 'Good performance', 20, 65, 57, '2026-04-08 19:00:00'),
(5.00, 'Great leadership', 20, 1, 57, '2026-04-08 19:00:00'),
(4.50, 'Good collaboration', 64, 65, 57, '2026-04-08 19:00:00'),
(5.00, 'Very helpful', 64, 1, 57, '2026-04-08 19:00:00'),
(5.00, 'Great mentor', 64, 8, 57, '2026-04-08 19:00:00'),
(5.00, 'Excellent guidance', 65, 1, 57, '2026-04-08 19:00:00'),
(4.50, 'Good teamwork', 65, 8, 57, '2026-04-08 19:00:00'),
(5.00, 'Great energy', 65, 9, 57, '2026-04-08 19:00:00');

-- =====================================================
-- CASE 2: PAST ANNUAL EVENTS (2025-2026)
-- =====================================================

-- Event 58: Annual Beach Cleanup - Negombo (2025)
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(58, 'Annual Beach Cleanup - Negombo 2025', 'Annual flagship beach cleanup event at Negombo beach. Volunteers removed over 2 tons of plastic waste from the shoreline.', 'Beach Cleanup', 1, 'completed', 1, 80, 160, '2025-12-15', '07:00:00', 'Negombo Beach', 'https://www.google.com/maps?q=7.193965,79.836407', 'large', 85000, 120, 85, 3, '2025-11-15 09:00:00', '8', 0, '2025-12-22 00:00:00', 1);

-- Event 58 - Annual Event Approvals
INSERT INTO `annual_event_approvals` (`event_id`, `approver_id`, `approval_status`, `approval_date`) VALUES
(58, 6, 'approved', '2025-11-20 10:00:00'),
(58, 7, 'approved', '2025-11-20 10:30:00');

-- Event 58 - Budget Items
INSERT INTO `event_budget_item` (`event_id`, `item_name`, `item_price`, `created_date`) VALUES
(58, 'Trash Bags and Gloves', 25000.00, '2025-11-15 09:00:00'),
(58, 'Lunch Packets', 50000.00, '2025-11-15 09:00:00'),
(58, 'First-Aid Kits', 10000.00, '2025-11-15 09:00:00');

-- Event 58 - Tasks
INSERT INTO `task` (`task_id`, `name`, `description`, `status`, `event_id`, `max_participants`, `current_participants`, `organizer_id`, `createddate`) VALUES
(64, 'Main Beach Sweep', 'Collect waste from the main Negombo beach stretch.', 'completed', 58, 50, 50, 3, '2025-11-15 09:00:00'),
(65, 'North End Collection', 'Collect waste from the northern end near the lagoon mouth.', 'completed', 58, 35, 35, 3, '2025-11-15 09:00:00');

-- Event 58 - Event Participation (85 volunteers - sample)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(58, 1, 'attended', '2025-12-01 08:00:00'),
(58, 5, 'attended', '2025-12-01 08:05:00'),
(58, 6, 'attended', '2025-12-01 08:10:00'),
(58, 7, 'attended', '2025-12-01 08:15:00'),
(58, 8, 'attended', '2025-12-01 08:20:00'),
(58, 9, 'attended', '2025-12-01 08:25:00'),
(58, 10, 'attended', '2025-12-01 08:30:00'),
(58, 11, 'attended', '2025-12-01 08:35:00'),
(58, 12, 'attended', '2025-12-01 08:40:00'),
(58, 13, 'attended', '2025-12-01 08:45:00'),
(58, 14, 'attended', '2025-12-01 08:50:00'),
(58, 15, 'attended', '2025-12-01 08:55:00'),
(58, 16, 'attended', '2025-12-01 09:00:00'),
(58, 17, 'attended', '2025-12-01 09:05:00'),
(58, 18, 'attended', '2025-12-01 09:10:00'),
(58, 19, 'attended', '2025-12-01 09:15:00'),
(58, 20, 'attended', '2025-12-01 09:20:00'),
(58, 21, 'attended', '2025-12-01 09:25:00'),
(58, 22, 'attended', '2025-12-01 09:30:00'),
(58, 23, 'attended', '2025-12-01 09:35:00'),
(58, 24, 'attended', '2025-12-01 09:40:00'),
(58, 26, 'attended', '2025-12-01 09:45:00'),
(58, 27, 'attended', '2025-12-01 09:50:00'),
(58, 30, 'attended', '2025-12-01 09:55:00'),
(58, 31, 'attended', '2025-12-01 10:00:00'),
(58, 32, 'attended', '2025-12-01 10:05:00'),
(58, 33, 'attended', '2025-12-01 10:10:00'),
(58, 34, 'attended', '2025-12-01 10:15:00'),
(58, 38, 'attended', '2025-12-01 10:20:00'),
(58, 40, 'attended', '2025-12-01 10:25:00'),
(58, 41, 'attended', '2025-12-01 10:30:00'),
(58, 42, 'attended', '2025-12-01 10:35:00'),
(58, 49, 'attended', '2025-12-01 10:40:00'),
(58, 50, 'attended', '2025-12-01 10:45:00'),
(58, 51, 'attended', '2025-12-01 10:50:00'),
(58, 52, 'attended', '2025-12-01 10:55:00'),
(58, 53, 'attended', '2025-12-01 11:00:00'),
(58, 54, 'attended', '2025-12-01 11:05:00'),
(58, 55, 'attended', '2025-12-01 11:10:00'),
(58, 56, 'attended', '2025-12-01 11:15:00'),
(58, 57, 'attended', '2025-12-01 11:20:00'),
(58, 58, 'attended', '2025-12-01 11:25:00'),
(58, 59, 'attended', '2025-12-01 11:30:00');

-- Event 58 - Attendance Ratings
INSERT INTO `attendance_rating` (`event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
(58, 1, 3, 5.00, '2025-12-15 18:00:00'),
(58, 8, 3, 5.00, '2025-12-15 18:00:00'),
(58, 9, 3, 5.00, '2025-12-15 18:00:00'),
(58, 10, 3, 4.50, '2025-12-15 18:00:00'),
(58, 11, 3, 5.00, '2025-12-15 18:00:00'),
(58, 12, 3, 4.00, '2025-12-15 18:00:00'),
(58, 13, 3, 5.00, '2025-12-15 18:00:00'),
(58, 14, 3, 5.00, '2025-12-15 18:00:00'),
(58, 15, 3, 4.50, '2025-12-15 18:00:00'),
(58, 16, 3, 5.00, '2025-12-15 18:00:00'),
(58, 17, 3, 5.00, '2025-12-15 18:00:00'),
(58, 18, 3, 4.00, '2025-12-15 18:00:00'),
(58, 20, 3, 5.00, '2025-12-15 18:00:00');

-- Event 59: Annual Mangrove Planting - Mannar (2025)
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(59, 'Annual Mangrove Planting - Mannar 2025', 'Annual large-scale mangrove restoration event along the Mannar coastline. Volunteers planted over 3,000 mangrove saplings.', 'Mangrove Restoration', 1, 'completed', 1, 90, 180, '2025-11-20', '07:00:00', 'Mannar Coastline', 'https://www.google.com/maps?q=8.970771,79.900582', 'large', 95000, 100, 72, 3, '2025-10-20 09:00:00', '8', 0, '2025-11-27 00:00:00', 1);

-- Event 59 - Annual Event Approvals
INSERT INTO `annual_event_approvals` (`event_id`, `approver_id`, `approval_status`, `approval_date`) VALUES
(59, 6, 'approved', '2025-10-25 10:00:00'),
(59, 7, 'approved', '2025-10-25 10:30:00');

-- Event 59 - Budget Items
INSERT INTO `event_budget_item` (`event_id`, `item_name`, `item_price`, `created_date`) VALUES
(59, 'Mangrove Saplings', 45000.00, '2025-10-20 09:00:00'),
(59, 'Planting Tools', 25000.00, '2025-10-20 09:00:00'),
(59, 'Lunch Packets', 25000.00, '2025-10-20 09:00:00');

-- Event 59 - Tasks
INSERT INTO `task` (`task_id`, `name`, `description`, `status`, `event_id`, `max_participants`, `current_participants`, `organizer_id`, `createddate`) VALUES
(66, 'Mangrove Planting - Zone A', 'Plant saplings in the northern zone of the Mannar coastline.', 'completed', 59, 36, 36, 3, '2025-10-20 09:00:00'),
(67, 'Mangrove Planting - Zone B', 'Plant saplings in the southern zone of the Mannar coastline.', 'completed', 59, 36, 36, 3, '2025-10-20 09:00:00');

-- Event 59 - Event Participation (72 volunteers - sample)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(59, 1, 'attended', '2025-11-05 08:00:00'),
(59, 8, 'attended', '2025-11-05 08:05:00'),
(59, 9, 'attended', '2025-11-05 08:10:00'),
(59, 10, 'attended', '2025-11-05 08:15:00'),
(59, 11, 'attended', '2025-11-05 08:20:00'),
(59, 12, 'attended', '2025-11-05 08:25:00'),
(59, 13, 'attended', '2025-11-05 08:30:00'),
(59, 14, 'attended', '2025-11-05 08:35:00'),
(59, 15, 'attended', '2025-11-05 08:40:00'),
(59, 16, 'attended', '2025-11-05 08:45:00'),
(59, 17, 'attended', '2025-11-05 08:50:00'),
(59, 18, 'attended', '2025-11-05 08:55:00'),
(59, 20, 'attended', '2025-11-05 09:00:00');

-- Event 60: Annual Tree Planting - Kandy (2026)
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(60, 'Annual Tree Planting - Kandy 2026', 'Annual reforestation event in the Kandy hills. Volunteers planted over 1,500 native trees to restore degraded forest areas.', 'Tree Planting', 1, 'completed', 1, 75, 150, '2026-03-18', '07:00:00', 'Kandy Hills', 'https://www.google.com/maps?q=7.249068,80.627117', 'large', 70000, 80, 62, 3, '2026-02-18 09:00:00', '7', 0, '2026-03-25 00:00:00', 1);

-- Event 60 - Annual Event Approvals
INSERT INTO `annual_event_approvals` (`event_id`, `approver_id`, `approval_status`, `approval_date`) VALUES
(60, 6, 'approved', '2026-02-22 10:00:00'),
(60, 7, 'approved', '2026-02-22 10:30:00');

-- Event 60 - Budget Items
INSERT INTO `event_budget_item` (`event_id`, `item_name`, `item_price`, `created_date`) VALUES
(60, 'Sapling Stock', 35000.00, '2026-02-18 09:00:00'),
(60, 'Shovels and Tools', 20000.00, '2026-02-18 09:00:00'),
(60, 'Lunch Packets', 15000.00, '2026-02-18 09:00:00');

-- Event 60 - Tasks
INSERT INTO `task` (`task_id`, `name`, `description`, `status`, `event_id`, `max_participants`, `current_participants`, `organizer_id`, `createddate`) VALUES
(68, 'Pit Digging', 'Dig planting pits on the hillside terrain.', 'completed', 60, 31, 31, 3, '2026-02-18 09:00:00'),
(69, 'Tree Planting', 'Plant native saplings and provide initial support.', 'completed', 60, 31, 31, 3, '2026-02-18 09:00:00');

-- Event 60 - Event Participation (62 volunteers - sample)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(60, 1, 'attended', '2026-03-05 08:00:00'),
(60, 8, 'attended', '2026-03-05 08:05:00'),
(60, 9, 'attended', '2026-03-05 08:10:00'),
(60, 10, 'attended', '2026-03-05 08:15:00'),
(60, 11, 'attended', '2026-03-05 08:20:00'),
(60, 12, 'attended', '2026-03-05 08:25:00'),
(60, 13, 'attended', '2026-03-05 08:30:00'),
(60, 14, 'attended', '2026-03-05 08:35:00'),
(60, 15, 'attended', '2026-03-05 08:40:00'),
(60, 16, 'attended', '2026-03-05 08:45:00'),
(60, 17, 'attended', '2026-03-05 08:50:00'),
(60, 18, 'attended', '2026-03-05 08:55:00'),
(60, 20, 'attended', '2026-03-05 09:00:00');

-- Event 60 - Attendance Ratings
INSERT INTO `attendance_rating` (`event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
(60, 1, 3, 5.00, '2026-03-18 18:00:00'),
(60, 8, 3, 5.00, '2026-03-18 18:00:00'),
(60, 9, 3, 5.00, '2026-03-18 18:00:00'),
(60, 10, 3, 4.50, '2026-03-18 18:00:00'),
(60, 11, 3, 5.00, '2026-03-18 18:00:00'),
(60, 12, 3, 4.00, '2026-03-18 18:00:00'),
(60, 13, 3, 5.00, '2026-03-18 18:00:00'),
(60, 14, 3, 5.00, '2026-03-18 18:00:00'),
(60, 15, 3, 4.50, '2026-03-18 18:00:00'),
(60, 16, 3, 5.00, '2026-03-18 18:00:00'),
(60, 17, 3, 5.00, '2026-03-18 18:00:00'),
(60, 18, 3, 4.00, '2026-03-18 18:00:00'),
(60, 20, 3, 5.00, '2026-03-18 18:00:00');

-- Event 61: Annual Coral Restoration - Hikkaduwa (2026)
INSERT INTO `volunteering_program` (`event_id`, `name`, `description`, `event_type`, `isauthorized`, `state_of_event`, `is_annual`, `starpoints_reward`, `levelpoints_reward`, `event_date`, `time`, `location`, `gmap_link`, `scale`, `allocated_budget`, `max_participants`, `current_participants`, `organizer_id`, `createddate`, `duration`, `is_deleted`, `peer_rating_open_until`, `points_processed`) VALUES
(61, 'Annual Coral Restoration - Hikkaduwa 2026', 'Annual coral transplanting dive event at Hikkaduwa Marine Sanctuary. Divers restored damaged reef areas with over 500 coral fragments.', 'Coral Restoration', 1, 'completed', 1, 100, 200, '2026-02-25', '07:30:00', 'Hikkaduwa', 'https://www.google.com/maps?q=6.139660,80.097290', 'medium', 55000, 30, 22, 3, '2026-01-25 09:00:00', '8', 0, '2026-03-04 00:00:00', 1);

-- Event 61 - Annual Event Approvals
INSERT INTO `annual_event_approvals` (`event_id`, `approver_id`, `approval_status`, `approval_date`) VALUES
(61, 6, 'approved', '2026-01-30 10:00:00'),
(61, 7, 'approved', '2026-01-30 10:30:00');

-- Event 61 - Budget Items
INSERT INTO `event_budget_item` (`event_id`, `item_name`, `item_price`, `created_date`) VALUES
(61, 'Diving Gear Rentals', 30000.00, '2026-01-25 09:00:00'),
(61, 'Coral Fragments', 15000.00, '2026-01-25 09:00:00'),
(61, 'Lunch Packets', 10000.00, '2026-01-25 09:00:00');

-- Event 61 - Tasks
INSERT INTO `task` (`task_id`, `name`, `description`, `status`, `event_id`, `max_participants`, `current_participants`, `organizer_id`, `createddate`) VALUES
(70, 'Coral Transplant Dive - Morning Session', 'Morning dive session for coral fragment transplanting.', 'completed', 61, 11, 11, 3, '2026-01-25 09:00:00'),
(71, 'Coral Transplant Dive - Afternoon Session', 'Afternoon dive session for coral fragment transplanting.', 'completed', 61, 11, 11, 3, '2026-01-25 09:00:00');

-- Event 61 - Event Participation (22 divers - sample)
INSERT INTO `event_participation` (`event_id`, `volunteer_id`, `participation_status`, `registration_date`) VALUES
(61, 1, 'attended', '2026-02-10 08:00:00'),
(61, 8, 'attended', '2026-02-10 08:05:00'),
(61, 9, 'attended', '2026-02-10 08:10:00'),
(61, 10, 'attended', '2026-02-10 08:15:00'),
(61, 11, 'attended', '2026-02-10 08:20:00'),
(61, 12, 'attended', '2026-02-10 08:25:00'),
(61, 13, 'attended', '2026-02-10 08:30:00'),
(61, 14, 'attended', '2026-02-10 08:35:00'),
(61, 15, 'attended', '2026-02-10 08:40:00'),
(61, 16, 'attended', '2026-02-10 08:45:00'),
(61, 17, 'attended', '2026-02-10 08:50:00'),
(61, 18, 'attended', '2026-02-10 08:55:00'),
(61, 20, 'attended', '2026-02-10 09:00:00');

-- Event 61 - Attendance Ratings
INSERT INTO `attendance_rating` (`event_id`, `volunteer_id`, `rater_id`, `attendance_score`, `rating_date`) VALUES
(61, 1, 3, 5.00, '2026-02-25 18:00:00'),
(61, 8, 3, 5.00, '2026-02-25 18:00:00'),
(61, 9, 3, 5.00, '2026-02-25 18:00:00'),
(61, 10, 3, 5.00, '2026-02-25 18:00:00'),
(61, 11, 3, 5.00, '2026-02-25 18:00:00'),
(61, 12, 3, 4.50, '2026-02-25 18:00:00'),
(61, 13, 3, 5.00, '2026-02-25 18:00:00'),
(61, 14, 3, 5.00, '2026-02-25 18:00:00'),
(61, 15, 3, 4.50, '2026-02-25 18:00:00'),
(61, 16, 3, 5.00, '2026-02-25 18:00:00'),
(61, 17, 3, 5.00, '2026-02-25 18:00:00'),
(61, 18, 3, 4.00, '2026-02-25 18:00:00'),
(61, 20, 3, 5.00, '2026-02-25 18:00:00');

-- =====================================================
-- NOTIFICATION: Remind Volunteer 1 about pending peer ratings
-- =====================================================


-- =====================================================
-- ANNOUNCEMENTS for past annual events
-- =====================================================




-- adding final corrections to processed points and stuff


UPDATE event_participation ep
JOIN volunteering_program vp ON ep.event_id = vp.event_id
SET ep.participation_status = 'completed'
WHERE vp.points_processed = 1 
AND ep.participation_status = 'attended';



UPDATE volunteering_program 
SET points_processed = 1 
WHERE event_id IN (3, 4, 5, 9, 10, 11, 13, 15, 18, 21, 25, 26, 27, 28, 29, 30, 31, 32, 33, 51, 52);

































COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;