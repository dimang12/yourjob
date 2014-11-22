-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2014 at 07:37 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ourjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

CREATE TABLE IF NOT EXISTS `industries` (
`industry_id` int(8) NOT NULL,
  `indu_parent` int(8) NOT NULL,
  `indu_name` varchar(80) COLLATE utf8_bin NOT NULL,
  `indu_alias` varchar(85) COLLATE utf8_bin NOT NULL,
  `indu_order` int(8) NOT NULL,
  `indu_details` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=47 ;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`industry_id`, `indu_parent`, `indu_name`, `indu_alias`, `indu_order`, `indu_details`) VALUES
(1, 0, 'Accounting/Audit/Tax Service', 'accounting-audit-tax-service', 1, '- Accounting\r\n- Audit\r\n- Tax Service'),
(2, 0, 'Advertising/Media/Publish', 'advertising-media-publish', 3, ''),
(3, 0, 'Airline', 'airline', 10, ''),
(4, 0, 'Architecture/Construction', 'architecture-construction', 2, ''),
(5, 0, 'Automobile/Vehicle', 'automobile-vehicle', 4, ''),
(6, 0, 'Banking & Finance', 'banking-finance', 5, ''),
(7, 0, 'Catering', 'catering', 11, ''),
(8, 0, 'Charity/Scial Service', 'charity-scial-service', 0, ''),
(9, 0, 'Chmical/Plastic/Paper', 'chmical-plastic-paper', 0, ''),
(10, 0, 'Civil Service', 'civil-service', 0, ''),
(11, 0, 'Clothing/Garment/Textile', 'clothing-garment-textile', 0, ''),
(12, 0, 'Cosmetic & Beauty', 'cosmetic-beauty', 0, ''),
(13, 0, 'Education', 'education', 0, ''),
(14, 0, 'Electronics/Electrical', 'electronics-electrical', 0, ''),
(15, 0, 'Energy/Power/Water', 'energy-power-water', 0, ''),
(16, 0, 'Engineering', 'engineering', 0, ''),
(17, 0, 'Entertainment', 'entertainment', 0, ''),
(18, 0, 'Food & Bervarage', 'food-bervarage', 0, ''),
(19, 0, 'Freight/Shipping', 'freight-shipping', 0, ''),
(20, 0, 'General Business services', 'general-business-services', 0, ''),
(21, 0, 'Health/Personal Care', 'health-personal-care', 0, ''),
(22, 0, 'Hospitality', 'hospitality', 0, ''),
(23, 0, 'Human Resource/Consultant', 'human-resource-consultant', 0, ''),
(24, 0, 'Industry Machinery/Auto', 'industry-machinery-auto', 0, ''),
(25, 0, 'Information Technology', 'information-technology', 0, ''),
(26, 0, 'Insurance', 'insurance', 0, ''),
(27, 0, 'Jewelry/Gems/Watches', 'jewelry-gems-watches', 0, ''),
(28, 0, 'Legal services', 'legal-services', 0, ''),
(29, 0, 'Logistics/Housekeeping', 'logistics-housekeeping', 0, ''),
(30, 0, 'Manufacturing', 'manufacturing', 0, ''),
(31, 0, 'Medical/Pharmaceutical', 'medical-pharmaceutical', 0, ''),
(32, 0, 'Packaging', 'packaging', 0, ''),
(33, 0, 'Performance/Mesical', 'performance-mesical', 0, ''),
(34, 0, 'Property Management', 'property-management', 0, ''),
(35, 0, 'Real Estate', 'real-estate', 0, ''),
(36, 0, 'Real Estate Leasing', 'real-estate-leasing', 0, ''),
(37, 0, 'Recruiting Services', 'recruiting-services', 0, ''),
(38, 0, 'Security/Fire', 'security-fire', 0, ''),
(39, 0, 'Sports & Recreation', 'sports-recreation', 0, ''),
(40, 0, 'Stationery/Books', 'stationery-books', 0, ''),
(41, 0, 'Telecommunication', 'telecommunication', 0, ''),
(42, 0, 'Tourism', 'tourism', 0, ''),
(43, 0, 'Trading', 'trading', 0, ''),
(44, 0, 'Vehcle Repair', 'vehcle-repair', 0, ''),
(45, 0, 'Wholesale/ Retail', 'wholesale-retail', 0, ''),
(46, 0, 'Others', 'others', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `industries`
--
ALTER TABLE `industries`
 ADD PRIMARY KEY (`industry_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `industries`
--
ALTER TABLE `industries`
MODIFY `industry_id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;