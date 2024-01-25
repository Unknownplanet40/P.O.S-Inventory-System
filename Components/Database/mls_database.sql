-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2024 at 09:30 AM
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

CREATE TABLE `account` (
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
  `LoginTimeout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`UUID`, `profile`, `name`, `username`, `password`, `role`, `status`, `date_created`, `last_accessed`, `isLogin`, `LoginTimeout`) VALUES
('3f2671b4-ab55-11ee-8123-2c600cc734ef', NULL, 'James Matthew Veloria', 'Jamesthew123', '@Veloria123', 1, 1, '2024-01-05 19:35:59', '2024-01-05 19:35:59', 0, NULL),
('e2fd4d44-ab44-11ee-8123-2c600cc734ef', NULL, 'Ryan James Capadocia', 'Ryanjames123', '@Capadocia123', 0, 1, '2024-01-05 19:35:59', '2024-01-25 14:35:00', 1, '2024-01-26 14:35:00');

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

CREATE TABLE `customer_information` (
  `Cust_ID` bigint(20) NOT NULL,
  `Cust_first_name` varchar(255) NOT NULL,
  `Cust_last_name` varchar(255) NOT NULL,
  `Cust_number` varchar(255) NOT NULL,
  `Cust_Address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_information`
--

INSERT INTO `customer_information` (`Cust_ID`, `Cust_first_name`, `Cust_last_name`, `Cust_number`, `Cust_Address`) VALUES
(1, 'Emilee', 'Heugel', '4451-663-4501', '4 Pankratz Terrace'),
(2, 'Libbi', 'Signorelli', '9702-936-5069', '36 Carey Way'),
(3, 'Derrik', 'Stollberger', '7483-567-3326', '275 Arapahoe Drive'),
(4, 'Terencio', 'Wanderschek', '1524-259-3756', '9207 Vernon Center'),
(5, 'Angeline', 'Avesque', '6645-838-1316', '8834 Eggendart Place'),
(6, 'Rollin', 'Hanvey', '2156-667-1575', '0 Bashford Circle'),
(7, 'Cassondra', 'Rathmell', '3227-668-0031', '86768 Surrey Alley'),
(8, 'Leanor', 'Fahy', '2098-236-0651', '78 Straubel Alley'),
(9, 'Kayla', 'Castlake', '3549-616-2904', '8430 Fieldstone Court'),
(10, 'Ryan James', 'Capadocia', '0910-773-7595', 'Phase 1, Block 11, Lot 14, Savanna ville, Malagasang 1-C, Imus, Cavite'),
(11, 'James', 'Veloria', '0901-123-1231', 'tapat ng sm molino'),
(12, 'Jeric', 'Dayandante', '0912-123-1112', 'sa may prima nadaan'),
(16, 'Ryan', 'James', '0910-773-7595', 'Phase 1, Block 11, Lot 14, Savanna ville, Malagasang 1-C, Imus, Cavite'),
(17, 'jose', 'mangungupal', '0994-989-1234', 'kupalan str. brgy tigasin'),
(18, 'Emilee', 'Heugel', '4451-663-4501', '4 Pankratz Terrace');

-- --------------------------------------------------------

--
-- Table structure for table `pos_products`
--

CREATE TABLE `pos_products` (
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
  `Achieved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pos_products`
--

INSERT INTO `pos_products` (`id`, `product_name`, `category`, `price`, `quantity`, `ml`, `perML_order`, `Current_ML`, `Total_ML`, `CurrentStock`, `isLowStock`, `image_path`, `Achieved`) VALUES
(1, 'Laundry Detergent', 'Powder', 9.99, 20, 0, 125, 0, 0, 20, 0, NULL, 0),
(2, 'Fabric Softener', 'Liquid', 5.99, 30, 1000, 125, 1000, 30000, 30, 0, NULL, 0),
(3, 'Bleach', 'Liquid', 3.49, 40, 750, 125, 750, 30000, 40, 0, NULL, 0),
(4, 'Stain Remover', 'Spray', 4.99, 15, 0, 125, 0, 0, 15, 0, NULL, 0),
(5, 'Laundry Bags', 'Accessories', 2.99, 100, NULL, 125, 0, 0, 86, 0, NULL, 0),
(6, 'Dryer Sheets', 'Sheets', 3.99, 45, NULL, 125, 0, 0, 30, 0, NULL, 0),
(7, 'Washing Machine Cleaner', 'Liquid', 6.49, 20, 500, 125, 125, 10000, 20, 0, NULL, 0),
(8, 'Clothespins', 'Accessories', 1.99, 75, NULL, 125, 0, 0, 54, 0, NULL, 0),
(9, 'Lint Roller', 'Roller', 2.49, 30, 0, 125, 0, 0, 30, 0, NULL, 0),
(10, 'Laundry Basket', 'Basket', 7.99, 35, NULL, 125, 0, 0, 25, 0, NULL, 0),
(11, 'Perfume', 'Liquid', 12.5, 50, 125, 125, 125, 0, 50, 0, NULL, 0),
(12, 'Plastic Bag', 'Accessories', 10, 15, 0, 0, 0, 0, 15, 0, NULL, 0);

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
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `TID` bigint(20) NOT NULL,
  `Items` text DEFAULT NULL,
  `Overall` double NOT NULL DEFAULT 0,
  `Date_Issued` datetime NOT NULL DEFAULT current_timestamp(),
  `Issued_By` char(64) NOT NULL,
  `Issued_To` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`TID`, `Items`, `Overall`, `Date_Issued`, `Issued_By`, `Issued_To`) VALUES
(1, '1x Laundry Detergent - 9.99 = 9.99, 2x Stain Remover - 4.99 = 9.98', 19.97, '2024-01-18 15:29:47', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '445-663-4501'),
(2, '1x Laundry Detergent - 9.99 = 9.99, 1x Dryer Sheets - 3.99 = 3.99, 1x Laundry Bags - 2.99 = 2.99', 16.97, '2024-01-18 15:40:44', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '091-773-7595'),
(3, '3x Lint Roller - 2.49 = 7.47, 2x Clothespins - 1.99 = 3.98, 3x Washing Machine Cleaner - 6.49 = 19.47', 30.92, '2024-01-18 20:08:47', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '091-773-7595'),
(4, '3x Laundry Bags - 2.99 = 8.97, 1x Dryer Sheets - 3.99 = 3.99, 2x Lint Roller - 2.49 = 4.98', 17.94, '2024-01-18 20:09:32', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '091-773-7595'),
(7, '2x Dryer Sheets - 3.99 = 7.98, 3x Lint Roller - 2.49 = 7.47, 4x Clothespins - 1.99 = 7.96, 3x Laundry Basket - 7.99 = 23.97', 47.38, '2024-01-19 00:21:34', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '092-223-8989'),
(8, '2x Dryer Sheets - 3.99 = 7.98, 3x Lint Roller - 2.49 = 7.47, 1x Clothespins - 1.99 = 1.99, 1x Laundry Basket - 7.99 = 7.99, 2x Laundry Bags - 2.99 = 5.98, 5x Laundry Bags - 2.99 = 14.95', 46.36, '2024-01-19 00:24:06', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '090-123-1231'),
(9, '3x Laundry Bags - 2.99 = 8.97', 8.97, '2024-01-19 00:30:03', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '090-333-1234'),
(10, '1x Clothespins - 1.99 = 1.99', 1.99, '2024-01-19 00:32:29', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '091-123-1112'),
(11, '2x Bleach - 3.49 = 6.98', 6.98, '2024-01-23 00:45:43', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '0910-773-7595'),
(12, '1x Fabric Softener - 5.99 = 5.99, 5x Dryer Sheets - 3.99 = 19.95, 5x Clothespins - 1.99 = 9.95', 35.89, '2024-01-23 01:00:56', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '0994-989-1234'),
(13, '6x Bleach - 3.49 = 20.94, 1x Fabric Softener - 5.99 = 5.99', 26.93, '2024-01-23 01:30:09', 'e2fd4d44-ab44-11ee-8123-2c600cc734ef', '4451-663-4501');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`UUID`);

--
-- Indexes for table `customer_information`
--
ALTER TABLE `customer_information`
  ADD PRIMARY KEY (`Cust_ID`);

--
-- Indexes for table `pos_products`
--
ALTER TABLE `pos_products`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`TID`),
  ADD KEY `FOREIGN` (`Issued_By`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_information`
--
ALTER TABLE `customer_information`
  MODIFY `Cust_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `TID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `FOREIGN` FOREIGN KEY (`Issued_By`) REFERENCES `account` (`UUID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
