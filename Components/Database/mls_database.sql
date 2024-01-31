-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2024 at 04:19 AM
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
  `LoginTimeout` datetime DEFAULT NULL,
  PRIMARY KEY (`UUID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`UUID`, `profile`, `name`, `username`, `password`, `role`, `status`, `date_created`, `last_accessed`, `isLogin`, `LoginTimeout`) VALUES
('3f2671b4-ab55-11ee-8123-2c600cc734ef', NULL, 'James Matthew Veloria', 'Jamesthew123', '@Veloria123', 1, 1, '2024-01-05 19:35:59', '2024-01-05 19:35:59', 0, NULL),
('e2fd4d44-ab44-11ee-8123-2c600cc734ef', NULL, 'Ryan James Capadocia', 'Ryanjames123', '@Capadocia123', 0, 1, '2024-01-05 19:35:59', '2024-01-31 11:12:38', 1, '2024-02-01 11:12:38');

--
-- Triggers `account`
--
DELIMITER $$
CREATE TRIGGER `update_login_timeout` BEFORE UPDATE ON `account` FOR EACH ROW BEGIN
    IF NEW.last_accessed IS NOT NULL THEN
        SET NEW.LoginTimeout = NEW.last_accessed + INTERVAL 1 DAY;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_information`
--

CREATE TABLE IF NOT EXISTS `customer_information` (
  `Cust_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Cust_first_name` varchar(255) NOT NULL,
  `Cust_last_name` varchar(255) NOT NULL,
  `Cust_number` varchar(255) NOT NULL,
  `Cust_Address` text NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Week` bigint(20) NOT NULL DEFAULT 0,
  `Month` bigint(20) NOT NULL DEFAULT 0,
  `Archived` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Cust_ID`),
  UNIQUE KEY `UNIQUE` (`Cust_number`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_information`
--

INSERT INTO `customer_information` (`Cust_ID`, `Cust_first_name`, `Cust_last_name`, `Cust_number`, `Cust_Address`, `Date`, `Week`, `Month`, `Archived`) VALUES
(1, 'Emilee', 'Heugel', '44516634501', '4 Pankratz Terrace', '2024-01-28 15:48:18', 1, 4, 0),
(2, 'Libbi', 'Signorelli', '97029365069', '36 Carey Way', '2024-01-28 15:48:18', 0, 0, 0),
(3, 'Derrik', 'Stollberger', '74835673326', '275 Arapahoe Drive', '2024-01-28 15:48:18', 0, 0, 0),
(4, 'Terencio', 'Wanderschek', '15242593756', '9207 Vernon Center', '2024-01-28 15:48:18', 0, 0, 0),
(5, 'Angeline', 'Avesque', '66458381316', '8834 Eggendart Place', '2024-01-28 15:48:18', 0, 0, 0),
(6, 'Rollin', 'Hanvey', '21566671575', '0 Bashford Circle', '2024-01-28 15:48:18', 0, 0, 0),
(7, 'Cassondra', 'Rathmell', '32276680031', '86768 Surrey Alley', '2024-01-28 15:48:18', 0, 0, 0),
(8, 'Leanor', 'Fahy', '20982360651', '78 Straubel Alley', '2024-01-28 15:48:18', 0, 0, 0),
(9, 'Kayla', 'Castlake', '35496162904', '8430 Fieldstone Court', '2024-01-28 15:48:18', 0, 0, 1),
(10, 'Ryan James', 'Capadocia', '09107737595', 'Phase 1, Block 11, Lot 14, Savanna ville, Malagasang 1-C, Imus, Cavite', '2024-01-28 15:48:18', 0, 0, 0);

--
-- Triggers `customer_information`
--
DELIMITER $$
CREATE TRIGGER `Weekly_Reset` BEFORE UPDATE ON `customer_information` FOR EACH ROW BEGIN
    DECLARE current_day VARCHAR(9);
    
    -- Get the current day of the week
    SET current_day = UPPER(DATE_FORMAT(NOW(), '%W'));
    
    -- Check if the current day is Sunday and the current time is after 11:59 PM
    IF current_day = 'SUNDAY' AND CURRENT_TIME() > '23:59:00' THEN
        -- Reset the 'Week' column to 0
        SET NEW.Week = 0;
    END IF;

    -- Check if the 'Week' column is updated and not being reset
    IF NEW.Week != OLD.Week AND NEW.Week != 0 THEN
        -- Increment the 'Month' column by 1
        SET NEW.Month = NEW.Month + 1;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reset_month` BEFORE UPDATE ON `customer_information` FOR EACH ROW BEGIN
    DECLARE last_day_of_month INT;
    
    -- Get the last day of the current month
    SET last_day_of_month = DAY(LAST_DAY(NOW()));
    
    -- Check if it's the last day of the month
    IF DAY(NOW()) = last_day_of_month THEN
        -- Reset the 'Month' column to 0
        SET NEW.Month = 0;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `machine_availability`
--

CREATE TABLE IF NOT EXISTS `machine_availability` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '1 - "WashOnly" 2 - "WashDry"',
  `WashOnly_Machine` tinyint(1) NOT NULL,
  `WashDry_Machine_1` tinyint(1) NOT NULL,
  `WashDry_Machine_2` tinyint(1) NOT NULL,
  `WashDry_Machine_3` tinyint(1) NOT NULL,
  `WashDry_Machine_4` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `machine_availability`
--

INSERT INTO `machine_availability` (`ID`, `WashOnly_Machine`, `WashDry_Machine_1`, `WashDry_Machine_2`, `WashDry_Machine_3`, `WashDry_Machine_4`) VALUES
(1, 0, 0, 0, 0, 0),
(2, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_products`
--

CREATE TABLE IF NOT EXISTS `pos_products` (
  `id` bigint(20) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'others',
  `price` double NOT NULL DEFAULT 0,
  `quantity` bigint(255) NOT NULL DEFAULT 0,
  `ml` bigint(255) DEFAULT NULL,
  `perML_order` int(255) NOT NULL DEFAULT 125,
  `Current_ML` double NOT NULL DEFAULT 0,
  `Total_ML` decimal(10,0) NOT NULL DEFAULT 0,
  `CurrentStock` bigint(255) NOT NULL DEFAULT 0,
  `isLowStock` tinyint(1) NOT NULL DEFAULT 0,
  `image_path` text DEFAULT NULL,
  `Achieved` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_products`
--

INSERT INTO `pos_products` (`id`, `product_name`, `category`, `price`, `quantity`, `ml`, `perML_order`, `Current_ML`, `Total_ML`, `CurrentStock`, `isLowStock`, `image_path`, `Achieved`) VALUES
(1, 'Laundry Detergent', 'Powder', 9.99, 20, 0, 125, 0, 0, 14, 0, NULL, 0),
(2, 'Fabric Softener', 'Liquid', 5.99, 30, 1000, 125, 1000, 30000, 29, 0, NULL, 0),
(3, 'Bleach', 'Liquid', 3.49, 40, 750, 125, 375, 30000, 40, 0, NULL, 0),
(4, 'Stain Remover', 'Spray', 4.99, 15, 0, 125, 0, 0, 10, 0, NULL, 0),
(5, 'Laundry Bags', 'Accessories', 2.99, 100, NULL, 125, 0, 0, 68, 0, NULL, 0),
(6, 'Dryer Sheets', 'Sheets', 3.99, 45, NULL, 125, 0, 0, 22, 1, NULL, 0),
(7, 'Washing Machine Cleaner', 'Liquid', 6.49, 20, 500, 125, 375, 10000, 19, 0, NULL, 0),
(8, 'Clothespins', 'Accessories', 1.99, 75, NULL, 125, 0, 0, 42, 0, NULL, 0),
(9, 'Lint Roller', 'Roller', 2.49, 30, 0, 125, 0, 0, 19, 0, NULL, 0),
(10, 'Laundry Basket', 'Basket', 7.99, 35, NULL, 125, 0, 0, 10, 1, NULL, 0),
(11, 'Perfume', 'Liquid', 12.5, 50, 125, 125, 125, 0, 50, 0, NULL, 1),
(12, 'Plastic Bag', 'Accessories', 10, 15, 0, 0, 0, 0, 15, 0, NULL, 1);

--
-- Triggers `pos_products`
--
DELIMITER $$
CREATE TRIGGER `Low_Stock_Trigger` BEFORE UPDATE ON `pos_products` FOR EACH ROW BEGIN
	-- Compute the 50% of Quantity
    DECLARE threshold INT;
    SET threshold = 0.5 * NEW.quantity;

	-- if the Current stock is less than 50%
    IF NEW.CurrentStock < threshold THEN
    	-- set the islowStock to True(1)
        SET NEW.isLowStock = 1;
    ELSE
    	-- set to False(0)
        SET NEW.isLowStock = 0;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `system_reminders`
--

CREATE TABLE IF NOT EXISTS `system_reminders` (
  `SRID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Status` int(11) NOT NULL,
  `Date_Added` datetime NOT NULL DEFAULT current_timestamp(),
  `Displayed_Date` datetime NOT NULL,
  PRIMARY KEY (`SRID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE IF NOT EXISTS `transaction_history` (
  `TID` bigint(20) NOT NULL AUTO_INCREMENT,
  `RTID` bigint(20) NOT NULL,
  `Items` text DEFAULT NULL,
  `WashType` varchar(255) NOT NULL,
  `Overall` double NOT NULL DEFAULT 0,
  `Date_Issued` datetime NOT NULL DEFAULT current_timestamp(),
  `Issued_By` char(64) NOT NULL,
  `Issued_To` varchar(255) NOT NULL,
  `Machine` int(5) NOT NULL,
  `Status` varchar(255) NOT NULL DEFAULT '' COMMENT '1 - Pending, 2 - washing, 3 - Completed',
  PRIMARY KEY (`TID`),
  KEY `FOREIGN` (`Issued_By`),
  KEY `ISSUED TO` (`Issued_To`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`TID`, `RTID`, `Items`, `WashType`, `Overall`, `Date_Issued`, `Issued_By`, `Issued_To`, `Machine`, `Status`) VALUES
(1, 0, '1x Laundry Detergent - 9.99 = 9.99, 2x Stain Remover - 4.99 = 9.98', '', 19.97, '2024-01-18 15:29:47', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '44516634501', 0, ''),
(2, 0, '1x Laundry Detergent - 9.99 = 9.99, 1x Dryer Sheets - 3.99 = 3.99, 1x Laundry Bags - 2.99 = 2.99', '', 16.97, '2024-01-18 15:40:44', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(3, 0, '3x Lint Roller - 2.49 = 7.47, 2x Clothespins - 1.99 = 3.98, 3x Washing Machine Cleaner - 6.49 = 19.47', '', 30.92, '2024-01-18 20:08:47', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(4, 0, '3x Laundry Bags - 2.99 = 8.97, 1x Dryer Sheets - 3.99 = 3.99, 2x Lint Roller - 2.49 = 4.98', '', 17.94, '2024-01-18 20:09:32', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(7, 0, '2x Dryer Sheets - 3.99 = 7.98, 3x Lint Roller - 2.49 = 7.47, 4x Clothespins - 1.99 = 7.96, 3x Laundry Basket - 7.99 = 23.97', '', 47.38, '2024-01-19 00:21:34', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(8, 0, '2x Dryer Sheets - 3.99 = 7.98, 3x Lint Roller - 2.49 = 7.47, 1x Clothespins - 1.99 = 1.99, 1x Laundry Basket - 7.99 = 7.99, 2x Laundry Bags - 2.99 = 5.98, 5x Laundry Bags - 2.99 = 14.95', '', 46.36, '2024-01-19 00:24:06', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(9, 0, '3x Laundry Bags - 2.99 = 8.97', '', 8.97, '2024-01-19 00:30:03', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(10, 0, '1x Clothespins - 1.99 = 1.99', '', 1.99, '2024-01-19 00:32:29', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(11, 0, '2x Bleach - 3.49 = 6.98', '', 6.98, '2024-01-23 00:45:43', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(12, 0, '1x Fabric Softener - 5.99 = 5.99, 5x Dryer Sheets - 3.99 = 19.95, 5x Clothespins - 1.99 = 9.95', '', 35.89, '2024-01-23 01:00:56', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(13, 0, '6x Bleach - 3.49 = 20.94, 1x Fabric Softener - 5.99 = 5.99', '', 26.93, '2024-01-23 01:30:09', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, ''),
(14, 0, '1x Perfume - 12.5 = 12.5', '', 12.5, '2024-01-25 17:08:30', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '15242593756', 0, ''),
(15, 0, '1x Fabric Softener - 5.99 = 5.99, 1x Laundry Bags - 2.99 = 2.99, 1x Clothespins - 1.99 = 1.99, 1x Lint Roller - 2.49 = 2.49', '', 13.46, '2024-01-26 06:07:34', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(16, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:12:55', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(17, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:13:11', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(18, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:15:27', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(19, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:16:01', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(20, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:16:51', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(21, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:18:09', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '21566671575', 0, ''),
(22, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:20:08', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '66458381316', 0, ''),
(23, 0, '1x Washing Machine Cleaner - 6.49 = 6.49', '', 6.49, '2024-01-26 06:21:40', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '32276680031', 0, ''),
(24, 0, '1x Stain Remover - 4.99 = 4.99, 1x Laundry Bags - 2.99 = 2.99, 1x Dryer Sheets - 3.99 = 3.99', '', 11.97, '2024-01-26 06:54:20', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(25, 0, '1x Clothespins - 1.99 = 1.99, 1x Lint Roller - 2.49 = 2.49, 1x Laundry Bags - 2.99 = 2.99', '', 7.47, '2024-01-26 06:56:14', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(26, 0, '2x Laundry Bags - 2.99 = 5.98, 2x Dryer Sheets - 3.99 = 7.98', '', 13.96, '2024-01-26 07:01:34', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '21566671575', 0, ''),
(27, 0, '1x Laundry Detergent - 9.99 = 9.99, 1x Laundry Bags - 2.99 = 2.99, 1x Dryer Sheets - 3.99 = 3.99', '', 16.97, '2024-01-26 07:05:45', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '20982360651', 0, ''),
(28, 0, '1x Laundry Bags - 2.99 = 2.99, 1x Dryer Sheets - 3.99 = 3.99', '', 6.98, '2024-01-26 07:12:10', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '20982360651', 0, ''),
(29, 0, '1x Laundry Bags - 2.99 = 2.99, 1x Dryer Sheets - 3.99 = 3.99', '', 6.98, '2024-01-26 07:13:42', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '20982360651', 0, ''),
(30, 0, '1xLaundry Bags - 2.99 = 2.99, 1xDryer Sheets - 3.99 = 3.99, 1xStain Remover - 4.99 = 4.99', '', 11.97, '2024-01-26 07:16:39', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(31, 0, '1xLaundry Bags - 2.99 = 2.99, 1xDryer Sheets - 3.99 = 3.99', '', 6.98, '2024-01-26 07:25:32', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(32, 0, '1xLaundry Bags - 2.99 = 2.99, 1xClothespins - 1.99 = 1.99, 1xLint Roller - 2.49 = 2.49', '', 7.47, '2024-01-26 07:28:57', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '32276680031', 0, ''),
(33, 0, '1xClothespins - 1.99 = 1.99, 1xLint Roller - 2.49 = 2.49, 1xBleach - 3.49 = 3.49, 1xFabric Softener - 5.99 = 5.99', '', 13.96, '2024-01-26 07:30:54', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '21566671575', 0, ''),
(34, 0, '1xBleach - 3.49 = 3.49, 1xFabric Softener - 5.99 = 5.99, 1xClothespins - 1.99 = 1.99, 1xLint Roller - 2.49 = 2.49', '', 13.96, '2024-01-26 07:34:08', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '21566671575', 0, ''),
(35, 0, '1xClothespins - 1.99 = 1.99, 1xLint Roller - 2.49 = 2.49', '', 4.48, '2024-01-26 07:36:23', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '21566671575', 0, ''),
(36, 0, '1x Clothespins - 1.99 = 1.99, 1x Lint Roller - 2.49 = 2.49, 1x Fabric Softener - 5.99 = 5.99, 1x Laundry Detergent - 9.99 = 9.99', '', 20.46, '2024-01-26 07:38:34', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '21566671575', 0, ''),
(37, 0, '1x Clothespins - 1.99 = 1.99, 1x Lint Roller - 2.49 = 2.49, 1x Laundry Detergent - 9.99 = 9.99, 1x Fabric Softener - 5.99 = 5.99', '', 20.46, '2024-01-26 07:42:57', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '15242593756', 0, ''),
(38, 0, '1x Laundry Bags - 2.99 = 2.99, 1x Laundry Bags - 2.99 = 2.99, 1x Stain Remover - 4.99 = 4.99', '', 10.97, '2024-01-26 07:45:43', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(39, 943086, '1x Fabric Softener - 5.99 = 5.99, 1x Laundry Bags - 2.99 = 2.99, 1x Lint Roller - 2.49 = 2.49, 1x Clothespins - 1.99 = 1.99', '', 13.46, '2024-01-26 07:54:34', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(40, 211596, '1x Fabric Softener - 5.99 = 5.99, 1x Laundry Bags - 2.99 = 2.99, 1x Lint Roller - 2.49 = 2.49, 1x Clothespins - 1.99 = 1.99', '', 13.46, '2024-01-26 07:58:36', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(41, 274376, '1x Laundry Detergent - 9.99 = 9.99, 1x Washing Machine Cleaner - 6.49 = 6.49, 1x Clothespins - 1.99 = 1.99, 1x Lint Roller - 2.49 = 2.49', '', 20.96, '2024-01-26 08:02:07', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '74835673326', 0, ''),
(42, 387910, '1x Laundry Detergent - 9.99 = 9.99, 1x Laundry Bags - 2.99 = 2.99, 1x Clothespins - 1.99 = 1.99', '', 14.97, '2024-01-26 09:02:49', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '15242593756', 0, ''),
(43, 199145, '1x Laundry Detergent - 9.99 = 9.99, 1x Fabric Softener - 5.99 = 5.99, 1x Bleach - 3.49 = 3.49, 1x Stain Remover - 4.99 = 4.99, 1x Laundry Bags - 2.99 = 2.99, 1x Wash and Dry - 120 = 120, 1x Fold - 20 = 20, 1x Delivery - 20 = 20', '3', 187.45, '2024-01-26 09:03:36', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '15242593756', 0, ''),
(44, 202372, '1x Laundry Bags - 2.99 = 2.99, 1x Stain Remover - 4.99 = 4.99, 1x Wash and Dry - 120 = 120, 1x Fold - 20 = 20, 1x Delivery - 20 = 20', '2', 167.98, '2024-01-28 10:10:33', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '09107737595', 0, '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `FOREIGN` FOREIGN KEY (`Issued_By`) REFERENCES `account` (`UUID`),
  ADD CONSTRAINT `ISSUED TO` FOREIGN KEY (`Issued_To`) REFERENCES `customer_information` (`Cust_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
