-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2014 at 07:39 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ourjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

DROP TABLE IF EXISTS `resume`;
CREATE TABLE IF NOT EXISTS `resume` (
`resume_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  `category_id` int(3) NOT NULL,
  `industry_id` int(3) NOT NULL,
  `city_id` int(3) NOT NULL,
  `resu_current_position` varchar(255) DEFAULT NULL,
  `resu_position_level` varchar(255) DEFAULT NULL,
  `resu_schedule` varchar(120) NOT NULL,
  `resu_age` int(3) NOT NULL,
  `resu_gender` enum('Male','Female') NOT NULL,
  `resu_nationality` varchar(30) NOT NULL,
  `resu_salary` float NOT NULL,
  `resu_current_degree` varchar(100) NOT NULL,
  `resu_year_experience` int(2) NOT NULL,
  `resu_language` varchar(120) NOT NULL,
  `resu_interesting` varchar(255) NOT NULL,
  `resu_skill` text NOT NULL,
  `resu_image` varchar(255) DEFAULT NULL,
  `resu_dob` date NOT NULL,
  `resu_pob` varchar(255) NOT NULL,
  `resu_address` varchar(300) NOT NULL,
  `resu_posting_date` date DEFAULT NULL,
  `resu_status` char(1) DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`resume_id`, `user_id`, `category_id`, `industry_id`, `city_id`, `resu_current_position`, `resu_position_level`, `resu_schedule`, `resu_age`, `resu_gender`, `resu_nationality`, `resu_salary`, `resu_current_degree`, `resu_year_experience`, `resu_language`, `resu_interesting`, `resu_skill`, `resu_image`, `resu_dob`, `resu_pob`, `resu_address`, `resu_posting_date`, `resu_status`) VALUES
(1, 1, 3, 0, 3, 'Student Pilot', 'Pilot', 'Part Time', 34, 'Female', '', 500, '', 0, 'Chines - Khmer', 'Music', 'Communicated', '53dfa33b47c19.JPG', '0000-00-00', '', '', '2014-08-04', '0'),
(2, 1, 8, 0, 4, 'Sale Officer', 'Sale Manager', 'Full time', 34, 'Male', '', 400, '', 0, 'Khmer - English', 'Music , read book , exercise', 'Communication with Customer', '53e0fbb12cef2.jpg', '0000-00-00', '', '', '2014-08-05', '1'),
(3, 6, 0, 0, 0, NULL, NULL, '', 0, 'Male', 'Khmer', 0, '', 0, '', '', '', NULL, '2014-11-05', 'Kampong Cham', '#39343', '2014-11-22', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `resume`
--
ALTER TABLE `resume`
 ADD PRIMARY KEY (`resume_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resume`
--
ALTER TABLE `resume`
MODIFY `resume_id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;