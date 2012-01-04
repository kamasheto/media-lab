-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2012 at 07:31 AM
-- Server version: 5.5.19
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `advlab`
--

-- --------------------------------------------------------

--
-- Table structure for table `tracking_order`
--

CREATE TABLE IF NOT EXISTS `tracking_order` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tracking_order`
--

INSERT INTO `tracking_order` (`id`, `message`) VALUES
(12345, 'Your order is on route, ETA is 15 mins.'),
(37169, 'Your order will be on route in 5 mins'),
(1, 'Almost there.');