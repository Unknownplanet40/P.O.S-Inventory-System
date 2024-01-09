-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2024 at 01:02 AM
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
-- Database: `mls_database`
--
CREATE DATABASE IF NOT EXISTS `mls_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mls_database`;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--
-- Creation: Jan 06, 2024 at 01:20 AM
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `UUID` char(64) NOT NULL COMMENT 'User Unique ID',
  `profile` text DEFAULT NULL COMMENT 'Profile Picture',
  `name` varchar(256) NOT NULL COMMENT 'Name of User',
  `username` varchar(512) NOT NULL,
  `password` varchar(512) NOT NULL,
  `role` int(128) NOT NULL DEFAULT 1 COMMENT '0 - Admin,\r\n1 - Staff',
  `status` int(128) NOT NULL DEFAULT 1 COMMENT '0 - Archived,\r\n1 - Active,\r\n2 - Inactive,\r\n3 - Locked,\r\n4 - Suspended',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `last_accessed` datetime NOT NULL DEFAULT current_timestamp(),
  `isLogin` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Check if user currently Login',
  PRIMARY KEY (`UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `account`:
--

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`UUID`, `profile`, `name`, `username`, `password`, `role`, `status`, `date_created`, `last_accessed`, `isLogin`) VALUES('3f2671b4-ab55-11ee-8123-2c600cc734ef', NULL, 'James Matthew Veloria', 'Jamesthew123', '@Veloria123', 1, 1, '2024-01-05 19:35:59', '2024-01-05 19:35:59', 0);
INSERT INTO `account` (`UUID`, `profile`, `name`, `username`, `password`, `role`, `status`, `date_created`, `last_accessed`, `isLogin`) VALUES('e2fd4d44-ab44-11ee-8123-2c600cc734ef', NULL, 'Ryan James Capadocia', 'Ryanjames123', '@Capadocia123', 0, 1, '2024-01-05 19:35:59', '2024-01-08 09:42:59', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
