-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2024 at 12:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bmis`
--

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` int(11) NOT NULL,
  `lrif_number` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` int(11) NOT NULL DEFAULT 0 COMMENT '0 - none, 1 - male, 2 - female',
  `file1` varchar(255) DEFAULT NULL,
  `file2` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 - pending, 1 - approved, 2 - rejected',
  `birthday` date DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `skill` varchar(255) NOT NULL,
  `household_category` int(11) NOT NULL DEFAULT 0 COMMENT '0 - none, 1 - living in makeshift housing, 2 - informal settlers',
  `category_category` int(11) NOT NULL DEFAULT 0 COMMENT '0 - n/a, 1 - pgw, 2 - elderly, 3 - solo parent',
  `income_and_livelihood` int(11) NOT NULL DEFAULT 0 COMMENT '0- n/a, 1- income below poverty threshold, 2 - income below food threshold, 3 - experienced food shortage',
  `water_and_sanitation` int(11) NOT NULL DEFAULT 0 COMMENT '0 - n/a, 1 - without access to safe water, 2 - without access to sanitary toilet facility',
  `property` int(11) NOT NULL DEFAULT 0 COMMENT '0 - n/a, 1 - private, 2 - public',
  `email` varchar(255) DEFAULT NULL,
  `image_file_name` varchar(255) DEFAULT NULL,
  `indigent_start_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0 - not deleted, 1 - deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beneficiaries`
--

INSERT INTO `beneficiaries` (`id`, `lrif_number`, `first_name`, `last_name`, `middle_name`, `address`, `gender`, `file1`, `file2`, `status`, `birthday`, `mobile_number`, `skill`, `household_category`, `category_category`, `income_and_livelihood`, `water_and_sanitation`, `property`, `email`, `image_file_name`, `indigent_start_date`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, '0', 'first name0', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email0@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(2, '1', 'first name1', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email1@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(3, '2', 'first name2', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email2@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(4, '3', 'first name3', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email3@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(5, '4', 'first name4', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email4@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(6, '5', 'first name5', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email5@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(7, '6', 'first name6', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email6@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(8, '7', 'first name7', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email7@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(9, '8', 'first name8', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email8@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(10, '9', 'first name9', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email9@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(11, '10', 'first name10', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email10@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(12, '11', 'first name11', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email11@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(13, '12', 'first name12', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email12@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(14, '13', 'first name13', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email13@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(15, '14', 'first name14', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email14@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(16, '15', 'first name15', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email15@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(17, '16', 'first name16', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email16@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(18, '17', 'first name17', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email17@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(19, '18', 'first name18', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email18@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(20, '19', 'first name19', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email19@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(21, '20', 'first name20', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 0, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email20@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(22, '21', 'first name21', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email21@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(23, '22', 'first name22', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email22@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(24, '23', 'first name23', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email23@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(25, '24', 'first name24', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email24@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(26, '25', 'first name25', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email25@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(27, '26', 'first name26', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email26@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(28, '27', 'first name27', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email27@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(29, '28', 'first name28', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email28@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(30, '29', 'first name29', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email29@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(31, '30', 'first name30', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email30@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(32, '31', 'first name31', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email31@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(33, '32', 'first name32', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email32@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(34, '33', 'first name33', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email33@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(35, '34', 'first name34', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email34@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(36, '35', 'first name35', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email35@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(37, '36', 'first name36', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email36@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(38, '37', 'first name37', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email37@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(39, '38', 'first name38', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email38@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(40, '39', 'first name39', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email39@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(41, '40', 'first name40', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email40@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(42, '41', 'first name41', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email41@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(43, '42', 'first name42', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email42@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(44, '43', 'first name43', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email43@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(45, '44', 'first name44', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email44@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(46, '45', 'first name45', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email45@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(47, '46', 'first name46', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email46@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(48, '47', 'first name47', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email47@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(49, '48', 'first name48', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email48@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(50, '49', 'first name49', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email49@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(51, '50', 'first name50', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email50@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(52, '51', 'first name51', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email51@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(53, '52', 'first name52', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email52@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(54, '53', 'first name53', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email53@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(55, '54', 'first name54', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email54@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(56, '55', 'first name55', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email55@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(57, '56', 'first name56', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email56@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(58, '57', 'first name57', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email57@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(59, '58', 'first name58', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email58@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(60, '59', 'first name59', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email59@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(61, '60', 'first name60', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 2, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email60@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 0),
(62, '41', 'first name41', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email41@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(63, '42', 'first name42', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email42@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(64, '43', 'first name43', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email43@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(65, '44', 'first name44', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email44@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(66, '45', 'first name45', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email45@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(67, '46', 'first name46', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email46@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(68, '47', 'first name47', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email47@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(69, '48', 'first name48', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email48@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(70, '49', 'first name49', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email49@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(71, '50', 'first name50', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email50@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(72, '51', 'first name51', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email51@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(73, '52', 'first name52', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email52@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(74, '53', 'first name53', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email53@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(75, '54', 'first name54', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email54@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(76, '55', 'first name55', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email55@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(77, '56', 'first name56', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email56@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(78, '57', 'first name57', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email57@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(79, '58', 'first name58', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email58@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(80, '59', 'first name59', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email59@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(81, '60', 'first name60', 'last_name', 'middle_name', 'address', 1, NULL, NULL, 1, '2000-01-01', '123455555555', '', 1, 1, 1, 1, 1, 'email60@test.com', NULL, '2000-01-01', '2024-02-20 01:21:06', '2024-02-20 01:21:06', 1),
(82, '121212', 'asdasd', 'asdasd', 'asdasd', 'asdasd', 1, '240219062148_asdasd_asdasd.jpg', '240219062148_asdasd_asdasd.jpg', 1, '2024-02-07', '23131313121', 'asdsad', 1, 1, 1, 1, 1, 'asdasd@test.com', '240219062148_asdasd_asdasd.jpg', '2024-02-01', '2024-02-20 01:21:48', '2024-02-20 01:21:58', 0),
(83, '123123213', 'asdasd', 'dsadsa', 'asda', 'asdsad', 1, '240219062753_dsadsa_asdasd.', NULL, 0, '2019-08-08', '12313123131', '', 1, 1, 1, 1, 1, '12313123131@asdsad.com', NULL, '2024-02-09', '2024-02-20 01:27:53', '2024-02-20 01:27:53', 0),
(84, '121212', 'sadsad', 'dasdsa', 'asdsa', 'asdsadsad', 1, '240219063007_dasdsa_sadsad.png', NULL, 0, '2019-08-08', '12313123213', '', 1, 1, 1, 1, 1, 'asdasd@test.com', NULL, '2024-02-08', '2024-02-20 01:30:07', '2024-02-20 01:30:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `beneficiary_family_members`
--

CREATE TABLE `beneficiary_family_members` (
  `id` int(11) NOT NULL,
  `beneficiary_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL COMMENT '0 - none, 1 - male, 2 - female',
  `skill` varchar(255) DEFAULT NULL,
  `family_role` int(11) NOT NULL DEFAULT 0,
  `birthday` date DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0 - no, 1 - yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `family_role_ref`
--

CREATE TABLE `family_role_ref` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0 COMMENT '0 - no, 1 - yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `family_role_ref`
--

INSERT INTO `family_role_ref` (`id`, `name`, `is_deleted`) VALUES
(1, 'Others', 0),
(2, 'Father', 0),
(3, 'Mother', 0),
(4, 'Sibling', 0);

-- --------------------------------------------------------

--
-- Table structure for table `history_log`
--

CREATE TABLE `history_log` (
  `id` int(11) NOT NULL,
  `page_url` varchar(500) NOT NULL,
  `actions` varchar(500) NOT NULL,
  `page_name` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_log`
--

INSERT INTO `history_log` (`id`, `page_url`, `actions`, `page_name`, `created_at`, `user_id`) VALUES
(1, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:29:16', 1),
(2, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:30:27', 1),
(3, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:32:24', 1),
(4, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:32:57', 1),
(5, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:35:26', 1),
(6, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:35:45', 1),
(7, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:36:02', 1),
(8, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:36:59', 1),
(9, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:37:28', 1),
(10, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:39:43', 1),
(11, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:40:05', 1),
(12, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:40:12', 1),
(13, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:40:44', 1),
(14, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:40:56', 1),
(15, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:41:32', 1),
(16, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:41:51', 1),
(17, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:42:15', 1),
(18, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:43:49', 1),
(19, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:45:03', 1),
(20, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:46:00', 1),
(21, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:46:37', 1),
(22, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:48:05', 1),
(23, 'C:xampphtdocsBMISgenerate_report.php', 'Generate Beneficiaries Report', 'Beneficiaries Report', '2024-02-20 00:48:20', 1),
(24, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:49:17', 1),
(25, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:49:38', 1),
(26, 'C:xampphtdocsBMISgenerate_dashboard_report.php', 'Generate Database Report', 'My Profile', '2024-02-20 00:50:07', 1),
(27, 'Login.php', 'Failed Logged In', 'Login', '2024-02-20 00:51:16', 0),
(28, 'Login.php', 'Successfully Logged In', 'Login', '2024-02-20 00:51:21', 1),
(29, 'C:xampphtdocsBMISeneficiaries.php', 'Add Beneficiary', 'Beneficiaries', '2024-02-20 01:01:20', 1),
(30, 'C:xampphtdocsBMISeneficiaries.php', 'Add Beneficiary', 'Beneficiaries', '2024-02-20 01:06:40', 1),
(31, 'C:xampphtdocsBMISeneficiary.php', 'Update beneficiaty / Save Family member', 'Beneficiary', '2024-02-20 01:15:36', 1),
(32, 'C:xampphtdocsBMISeneficiaries.php', 'Add Beneficiary', 'Beneficiaries', '2024-02-20 01:19:00', 1),
(33, 'C:xampphtdocsBMISeneficiaries.php', 'Add Beneficiary', 'Beneficiaries', '2024-02-20 01:21:48', 1),
(34, 'C:xampphtdocsBMISeneficiary.php', 'Update beneficiaty / Save Family member', 'Beneficiary', '2024-02-20 01:21:58', 1),
(35, 'C:xampphtdocsBMISeneficiaries.php', 'Add Beneficiary', 'Beneficiaries', '2024-02-20 01:27:53', 1),
(36, 'C:xampphtdocsBMISeneficiaries.php', 'Add Beneficiary', 'Beneficiaries', '2024-02-20 01:30:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL COMMENT 'beneficiaries.id',
  `message` varchar(500) NOT NULL,
  `remarks` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_read` int(11) DEFAULT 0 COMMENT '0 - no, 1 - yes',
  `sent_by_id` int(11) NOT NULL COMMENT 'users.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `can_register` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `can_register`) VALUES
(1, 'Admin', 0),
(2, 'Staff', 1),
(6, 'SuperAdmin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_actions`
--

CREATE TABLE `role_actions` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_actions`
--

INSERT INTO `role_actions` (`id`, `name`) VALUES
(1, 'file_management_can_upload'),
(2, 'file_management_can_view'),
(3, 'file_management_can_delete'),
(4, 'file_management_can_update'),
(5, 'file_management_can_approve'),
(6, 'events_can_view'),
(7, 'events_can_add'),
(8, 'events_can_update'),
(9, 'events_can_delete');

-- --------------------------------------------------------

--
-- Table structure for table `role_assignments`
--

CREATE TABLE `role_assignments` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `role_actions_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_assignments`
--

INSERT INTO `role_assignments` (`id`, `role_id`, `role_actions_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 2, 2),
(12, 2, 5),
(13, 3, 2),
(14, 3, 5),
(15, 4, 2),
(16, 4, 5),
(17, 5, 2),
(18, 5, 6),
(19, 2, 3),
(20, 3, 3),
(21, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(14) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 1 COMMENT 'role table',
  `birthday` date NOT NULL,
  `gender` int(11) NOT NULL DEFAULT 1 COMMENT '1 - male, 2 - female',
  `created_by` int(255) DEFAULT NULL COMMENT 'users.id',
  `image_file_name` varchar(255) DEFAULT NULL,
  `approval_status` int(11) DEFAULT 0 COMMENT '0 - pending, 1 - approved, 2 - rejected, 3 - archived',
  `approved_date` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact_no`, `password`, `role`, `birthday`, `gender`, `created_by`, `image_file_name`, `approval_status`, `approved_date`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin One', 'superAdmin1@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 3, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(2, 'Super Admin Two', 'superAdmin2@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 3, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(3, 'Super Admin Three', 'superAdmin3@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 3, '2000-08-01', 2, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(4, 'Admin One', 'admin1@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 1, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(5, 'Admin Two', 'admin2@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 1, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(6, 'Admin Three', 'admin3@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 1, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(7, 'Staff One', 'staff1@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 2, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(8, 'Staff Two', 'staff2@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 2, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(9, 'Staff Three', 'staff3@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 2, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(10, 'Staff Four', 'staff4@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 2, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39'),
(11, 'Staff Five', 'staff5@test.com', '01231312312', '$2y$10$UvYTT0VhlfD3i0hWel88P.i6dwc8HEQt2.fsjmvRF449x.83rK/.a', 2, '2000-08-01', 1, NULL, NULL, 1, NULL, NULL, '2024-01-30 17:02:21', '2024-02-20 00:24:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiary_family_members`
--
ALTER TABLE `beneficiary_family_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_role_ref`
--
ALTER TABLE `family_role_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history_log`
--
ALTER TABLE `history_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_actions`
--
ALTER TABLE `role_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_assignments`
--
ALTER TABLE `role_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `id` (`id`,`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beneficiary_family_members`
--
ALTER TABLE `beneficiary_family_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `family_role_ref`
--
ALTER TABLE `family_role_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history_log`
--
ALTER TABLE `history_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_actions`
--
ALTER TABLE `role_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_assignments`
--
ALTER TABLE `role_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
