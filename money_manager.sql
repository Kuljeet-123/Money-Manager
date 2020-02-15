-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2014 at 02:01 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `money_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `AccountId` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` int(5) NOT NULL,
  `AccountName` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`AccountId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Triggers `account`
--
DROP TRIGGER IF EXISTS `GenerateAccount`;
DELIMITER //
CREATE TRIGGER `GenerateAccount` AFTER INSERT ON `account`
 FOR EACH ROW INSERT INTO totals(UserId, AccountId, totals) values (new.UserId, new.AccountId, '0')
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `AssetsId` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` int(5) NOT NULL,
  `Title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Date` date NOT NULL,
  `CategoryId` int(5) NOT NULL,
  `AccountId` int(5) NOT NULL,
  `Amount` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`AssetsId`),
  KEY `fk_test` (`AccountId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Triggers `assets`
--
DROP TRIGGER IF EXISTS `GenerateTotalAccount`;
DELIMITER //
CREATE TRIGGER `GenerateTotalAccount` AFTER INSERT ON `assets`
 FOR EACH ROW UPDATE totals SET totals.totals=totals.totals + new.amount where totals.userid=new.userid and totals.accountid=new.accountid
//
DELIMITER ;
DROP TRIGGER IF EXISTS `GenerateTotalUpdate`;
DELIMITER //
CREATE TRIGGER `GenerateTotalUpdate` AFTER UPDATE ON `assets`
 FOR EACH ROW UPDATE totals SET totals.totals=(select sum(Amount) from assets where assets.userid=new.userid and assets.accountid=new.accountid) where totals.userid=new.userid and totals.accountid=new.accountid
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE IF NOT EXISTS `bills` (
  `BillsId` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` int(5) NOT NULL,
  `Title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Dates` date NOT NULL,
  `CategoryId` int(5) NOT NULL,
  `AccountId` int(5) NOT NULL,
  `Amount` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`BillsId`),
  KEY `fk_testt` (`AccountId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Triggers `bills`
--
DROP TRIGGER IF EXISTS `GenerateExpense`;
DELIMITER //
CREATE TRIGGER `GenerateExpense` AFTER INSERT ON `bills`
 FOR EACH ROW UPDATE totals SET totals.totals=totals.totals - new.amount where totals.userid=new.userid and totals.accountid=new.accountid
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE IF NOT EXISTS `budget` (
  `BudgetId` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` int(5) NOT NULL,
  `CategoryId` int(5) NOT NULL,
  `Dates` date NOT NULL,
  `Amount` int(10) NOT NULL,
  PRIMARY KEY (`BudgetId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CategoryId` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` int(5) NOT NULL,
  `CategoryName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Level` int(2) NOT NULL,
  PRIMARY KEY (`CategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `totals`
--

CREATE TABLE IF NOT EXISTS `totals` (
  `TotalsId` int(5) NOT NULL AUTO_INCREMENT,
  `UserId` int(5) NOT NULL,
  `AccountId` int(5) NOT NULL,
  `Totals` int(10) NOT NULL,
  PRIMARY KEY (`TotalsId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserId` int(5) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `LastName` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `Currency` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Triggers `user`
--
DROP TRIGGER IF EXISTS `GenerateDefaultAccount`;
DELIMITER //
CREATE TRIGGER `GenerateDefaultAccount` AFTER INSERT ON `user`
 FOR EACH ROW INSERT INTO account (UserId, AccountName) VALUES (new.UserId, 'Cash'), (new.UserId, 'Account'), (new.UserId, 'Card')
//
DELIMITER ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `fk_test` FOREIGN KEY (`AccountId`) REFERENCES `account` (`AccountId`) ON DELETE CASCADE;

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `fk_testt` FOREIGN KEY (`AccountId`) REFERENCES `account` (`AccountId`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
