-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 20, 2016 at 09:47 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `registration`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) unsigned NOT NULL,
  `type` enum('residence','office') COLLATE utf8_bin NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `fax` bigint(12) DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `pin_no` int(7) DEFAULT NULL,
  `city` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `state` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `state_id` (`state`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `communication`
--

CREATE TABLE IF NOT EXISTS `communication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `communication`
--

INSERT INTO `communication` (`id`, `type`) VALUES
(1, 'Mail'),
(2, 'Message'),
(3, 'Phone call'),
(4, 'Any');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) COLLATE utf8_bin NOT NULL,
  `middle_name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `date_of_birth` date NOT NULL,
  `prefix` varchar(3) COLLATE utf8_bin NOT NULL,
  `photo` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `note` text COLLATE utf8_bin,
  `gender` enum('Male','Female') COLLATE utf8_bin NOT NULL,
  `marital_status` varchar(10) COLLATE utf8_bin NOT NULL,
  `communication` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `employment` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `employer` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employment_id` (`employment`),
  KEY `employer_id` (`employer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=36 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(1, 'Andaman and Nicobar Islands'),
(2, 'Andhra Pradesh'),
(3, 'Arunachal Pradesh'),
(4, 'Assam'),
(5, 'Bihar'),
(6, 'Chandigarh'),
(7, 'Chhattisgarh'),
(8, 'Dadra and Nagar Haveli'),
(9, 'Daman and Diu'),
(10, 'Delhi'),
(11, 'Goa'),
(12, 'Gujarat'),
(13, 'Haryana'),
(14, 'Himachal Pradesh'),
(15, 'Jammu and Kashmir'),
(16, 'Jharkhand'),
(17, 'Karnataka'),
(18, 'Kerala'),
(19, 'Lakshadweep'),
(20, 'Madhya Pradesh'),
(21, 'Maharashtra'),
(22, 'Manipur'),
(23, 'Meghalaya'),
(24, 'Mizoram'),
(25, 'Nagaland'),
(26, 'Orissa'),
(27, 'Pondicherry'),
(28, 'Punjab'),
(29, 'Rajasthan'),
(30, 'Sikkim'),
(31, 'Tamil Nadu'),
(32, 'Tripura'),
(34, 'Uttar Pradesh'),
(33, 'Uttaranchal'),
(35, 'West Bengal');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `employee` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
