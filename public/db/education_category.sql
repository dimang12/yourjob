-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2014 at 05:11 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ourjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `education_category`
--

CREATE TABLE IF NOT EXISTS `education_category` (
`education_category_id` int(3) NOT NULL,
  `edca_name` varchar(200) NOT NULL,
  `edca_ordering` int(3) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `education_category`
--

INSERT INTO `education_category` (`education_category_id`, `edca_name`, `edca_ordering`) VALUES
(1, 'Scholarship', 1),
(2, 'Training Course', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `education_category`
--
ALTER TABLE `education_category`
 ADD PRIMARY KEY (`education_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `education_category`
--
ALTER TABLE `education_category`
MODIFY `education_category_id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
