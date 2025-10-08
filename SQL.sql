USE sahyog1;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2025 at 10:01 AM
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
-- Database: `sahyog1`
--

-- --------------------------------------------------------

--
-- Table structure for table `ngo_users`
--

CREATE TABLE `ngo_users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nameofNGO` varchar(250) NOT NULL,
  `location` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ngo_users`
--

INSERT INTO `ngo_users` (`id`, `fullname`, `email`, `mobile_number`, `password`, `nameofNGO`, `location`) VALUES
(1, 'Ananya Sharma', 'help.hands@gmail.com', '', '$2y$10$euulj1crVihFHZdCTIlz5eZTGNk/1hmqkit.1ajelmFfl052czJ7C', 'Helping Hands', 'mumbai,india'),
(2, 'Rohan Verma', 'green.future@gmail.com', '9123456780', '$2y$10$J7eaz6.LSQZgUgWsCXdeyOOISdYffTW28etOIgBKsyeKtsExULHz.', 'Green Future', 'Bengaluru'),
(3, 'Priya SIngh', 'smile@gmail.com', '9988776655', '$2y$10$WAJIlBUISCtVrmEGxIRCDu/OBQjCO/IWu2mmvgbYiPjX5ReDH2JWe', 'Smile Foundation', 'Delhi,India'),
(5, 'Arjun mehta', 'Arjun.future8@gmail.com', '800898069', '$2y$10$1ajNAZyvjD874n742znWyO5FqTbGdDdMMWIs.i0rIpNHcDlfYKeg2', 'Bright Horizons', 'Chennai, India'),
(6, 'kavya reddy', 'waterfall,fall@gmail.com', '8958426190', '$2y$10$dI610i2ar2bSsL8e.lnC1eku6P3MnbuJezMiV0cHemYDnMkKzyDUq', 'Water for all', 'Kolkata, India'),
(7, 'Aditya kumar', 'teachAditya@32gmail.com', '8374910872', '$2y$10$lfrc4yNPlH/7Nf5Ktjguu.5uvE61cWVkag5gOuIuMRS11jgS398gK', 'Teach the world', 'Hyderabad,India'),
(8, 'Sneha Joshi', 'food.everyone@gmail.com', '9334455671', '$2y$10$zPgSZTpebPLWV2T5EeD/6e4XQ35EPVsjtNUFuaeaoAOs5yCFq6Zp2', 'Food for everyone', 'Pune, India'),
(9, 'Varun patel', 'varunrun@gmail.com', '8990079675', '$2y$10$4NBn52BiGapjI9BPCx2PRO8GyFyhR3nu7S0SgbVNVbgHVTQU0T8kW', 'Safe shelter', 'secunderabad, India'),
(10, 'Anusha', 'anu@243gmail.com', '8009007002', '$2y$10$YKLdM71bOWv4Ytoy19mf7uTZu.4gRQqOqo818i9McVBC0xVjMdTri', 'do or die', 'warangal, India '),
(12, 'Priyanka', 'Oxfam@gmail.com', '9638527410', '$2y$10$5xVBGago4Bx8.MzHERz2cOWkSXF/qClbvJn8Xcjcp8HdwBZZasaB2', 'Oxfam', 'Ranchi,India'),
(26, 'Priya Reddy', 'priyareddy@gmail.com', '9876543210', '$2y$10$uKl214PTLi0B7zNO3waqMewntfYHYA6OX8J2FCvDaccYrZJoOrjiO', 'Light of Hope', 'Pune');

-- --------------------------------------------------------

--
-- Table structure for table `rural_users`
--

CREATE TABLE `rural_users` (
  `ID` int(11) NOT NULL,
  `FullName` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `MobileNumber` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Age` varchar(2) NOT NULL,
  `Skills` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `Needs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rural_users`
--

INSERT INTO `rural_users` (`ID`, `FullName`, `Email`, `MobileNumber`, `password`, `Age`, `Skills`, `location`, `Needs`) VALUES
(1, 'Ramesh kaur', 'ramesh@gmail.com', '9876543210', '$2y$10$H', '24', '', 'Madhya Pradesh', 'Microloan,Training'),
(2, 'Sita Devi', 'sita@gmail.com', '9876543211', '$2y$10$x', '30', 'Weaving,Cooking', 'Uttar Pradesh', 'Education,Funding'),
(3, 'Mohan Lal', 'Mohan@gmail.com', '9876543212', '$2y$10$P', '28', 'Masonry,Agriculture', 'Rajasthan', 'Tools,Training'),
(5, 'Mohan Lal', 'Mohan@gmail.com', '9876543213', '$2y$10$e', '28', 'Masonry,Agriculture', 'Rajasthan', 'Tools,Training'),
(6, 'Gita Rani', 'Gita@gmail.com', '9874563213', '$2y$10$Z', '20', 'Tailoring,Agriculture', 'Jharkand', 'Sewing Machine,Seeds'),
(7, 'Sandhya', 'Sandhya@gmail.com', '9877564123', '$2y$10$V', '30', 'Weaving,Tailoring,Agriculture', 'Hyderabad,India', 'Training,Education'),
(9, 'Sandhya', 'Sandhya@gmail.com', '9877564122', '$2y$10$f', '30', 'Weaving,Tailoring,Agriculture', 'Hyderabad,India', 'Training,Education'),
(10, 'Kiran', 'Kiran@gmail.com', '8526975123', '$2y$10$P', '28', 'Goat Rearing,Farming', 'chennai,india', 'Livestock,Training'),
(11, 'Kiran Kumar', 'KiranK@gmail.com', '9865237410', '$2y$10$/', '25', 'Carpentry , Dairy Farming', 'Tamil Nadu,India', 'Microloan,Training'),
(12, 'Rajesh Yadav', 'Ry@gmail.com', '9875623147', '$2y$10$Z7fz7OquI6mrarXKQ8iFf.cBLArjWochE9hXtIIc7aaYqzozZDMd2', '31', 'Goat Rearing,Farming', 'Jamshedpur,Jharkhand', 'Livestock ,Training');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ngo_users`
--
ALTER TABLE `ngo_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fullname` (`fullname`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`),
  ADD UNIQUE KEY `nameofNGO` (`nameofNGO`),
  ADD UNIQUE KEY `location` (`location`),
  ADD UNIQUE KEY `mobile_number_2` (`mobile_number`),
  ADD UNIQUE KEY `mobile_number_3` (`mobile_number`),
  ADD UNIQUE KEY `mobile_number_4` (`mobile_number`),
  ADD UNIQUE KEY `mobile_number_5` (`mobile_number`),
  ADD UNIQUE KEY `mobile_number_6` (`mobile_number`),
  ADD UNIQUE KEY `mobile_number_7` (`mobile_number`);

--
-- Indexes for table `rural_users`
--
ALTER TABLE `rural_users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `MobileNumber` (`MobileNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ngo_users`
--
ALTER TABLE `ngo_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rural_users`
--
ALTER TABLE `rural_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
SHOW TABLES;
SELECT * FROM ngo_users;
SELECT * FROM rural_users;
DESCRIBE ngo_users;