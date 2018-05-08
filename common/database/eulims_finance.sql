-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2018 at 08:31 AM
-- Server version: 5.7.11
-- PHP Version: 7.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eulims_finance`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetWalletDetails` (`mCustomerID` INT(11))  READS SQL DATA
BEGIN
         select `customer_name` 
         from `eulims_lab`.`tbl_customer` 
         inner join `eulims_finance`.`tbl_customerwallet` on `eulims_finance`.`tbl_customerwallet`.`customer_id`=`eulims_lab`.`tbl_customer`.`customer_id`
         where `eulims_lab`.`tbl_customer`.`customer_id`=mCustomerID;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customertransaction`
--

CREATE TABLE `tbl_customertransaction` (
  `customertransaction_id` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `transactiontype` tinyint(1) NOT NULL,
  `amount` decimal(11,2) NOT NULL,
  `balance` decimal(11,2) NOT NULL,
  `customerwallet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customerwallet`
--

CREATE TABLE `tbl_customerwallet` (
  `customerwallet_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `balance` decimal(11,2) NOT NULL,
  `customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_customertransaction`
--
ALTER TABLE `tbl_customertransaction`
  ADD PRIMARY KEY (`customertransaction_id`),
  ADD KEY `customerwallet_id` (`customerwallet_id`);

--
-- Indexes for table `tbl_customerwallet`
--
ALTER TABLE `tbl_customerwallet`
  ADD PRIMARY KEY (`customerwallet_id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_customertransaction`
--
ALTER TABLE `tbl_customertransaction`
  MODIFY `customertransaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_customerwallet`
--
ALTER TABLE `tbl_customerwallet`
  MODIFY `customerwallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_customertransaction`
--
ALTER TABLE `tbl_customertransaction`
  ADD CONSTRAINT `tbl_customertransaction_ibfk_1` FOREIGN KEY (`customerwallet_id`) REFERENCES `tbl_customerwallet` (`customerwallet_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
