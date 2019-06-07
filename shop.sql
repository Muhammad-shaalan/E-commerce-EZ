-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2018 at 06:07 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `parent` tinyint(4) NOT NULL,
  `visibility` tinyint(4) NOT NULL DEFAULT '0',
  `allow_comment` tinyint(4) NOT NULL DEFAULT '0',
  `allow_ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `ordering`, `parent`, `visibility`, `allow_comment`, `allow_ads`) VALUES
(22, 'Home Made', 'Homemade Item', 1, 0, 0, 0, 0),
(23, 'Computers', 'Computer Items', 2, 0, 1, 1, 1),
(25, 'Tools', 'Tools Item', 4, 0, 0, 0, 0),
(27, 'Samsung', 'Phone', 0, 24, 0, 0, 0),
(28, 'Games', 'For GAmes', 0, 0, 0, 0, 0),
(31, 'Fifa', 'From Fifa Company', 0, 25, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cId` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `commentDate` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cId`, `comment`, `status`, `commentDate`, `item_id`, `user_id`) VALUES
(19, 'Cool', 1, '2018-07-12', 29, 797),
(20, 'Nice', 1, '2018-07-18', 26, 797),
(21, 'It Is Not CoOol', 0, '2018-07-30', 26, 794),
(22, 'It Is Not CoOol', 1, '2018-07-30', 26, 794),
(23, 'It Is Not CoOol', 0, '2018-07-30', 26, 794),
(24, 'It Is Not CoOol', 0, '2018-07-30', 26, 797),
(25, 'Niceeee', 1, '2018-07-30', 26, 797),
(26, 'Niceeee', 0, '2018-07-30', 26, 797),
(27, 'Niceeee', 0, '2018-07-30', 26, 797),
(28, 'Nice', 1, '2018-07-30', 30, 797),
(29, 'Nice', 0, '2018-07-30', 30, 797),
(30, 'Nice', 0, '2018-07-30', 30, 797),
(31, 'It&#39;s Ok', 0, '2018-07-30', 35, 797),
(32, '@#$OOOoOk', 1, '2018-07-30', 35, 797);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `addDate` date NOT NULL,
  `tags` varchar(225) NOT NULL,
  `countryMade` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemId`, `name`, `description`, `price`, `addDate`, `tags`, `countryMade`, `image`, `status`, `rating`, `cat_id`, `member_id`, `approve`) VALUES
(25, 'Voice Machiene', 'For Ears', '$55', '2018-07-25', '', 'Egype', '', '2', 0, 23, 793, 0),
(26, 'Ring', 'For Girls', '$32', '2018-07-25', '', 'Soria', '', '1', 0, 22, 794, 0),
(28, 'Mouse', 'Wirless Mouse', '$15', '2018-07-25', '', 'France', '', '1', 0, 23, 795, 0),
(29, 'Keyboard', 'Touch', '$31', '2018-07-25', '', 'Italy', '', '1', 0, 23, 793, 0),
(30, 'Hard', '2 Tera', '$200', '2018-07-25', '', 'Soudia Arabia', '', '1', 0, 23, 796, 1),
(31, 'Handfree', 'For Ears', '$25', '2018-07-26', '', 'Egupt', '', '1', 0, 23, 797, 1),
(35, 'Game', 'Hello Hello Hello', '10', '2018-07-27', '', 'USA', '', '2', 0, 22, 797, 1),
(40, 'shose', 'for Women', '30', '2018-07-30', '', 'Egypt', '', '2', 0, 22, 797, 1),
(41, 'cars', 'no desc', '$344', '2018-08-01', '', 'usa', '', '1', 0, 23, 797, 1),
(42, 'sdww', 'wdq', '631', '2018-08-01', 'efs', 'qf', '', '3', 0, 25, 797, 1),
(43, 'eee', 'eeee', '852', '2018-08-01', 'eee, RPg', 'ee', '', '3', 0, 31, 797, 1),
(45, 'pes', 'for boys', '300', '2018-08-01', 'Rpg, teXt, src', 'usa', '', '1', 0, 28, 797, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userName` varchar(255) CHARACTER SET utf32 NOT NULL COMMENT 'To login',
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL COMMENT 'Show In The Website',
  `groupId` int(11) NOT NULL DEFAULT '0',
  `trustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Seller Rank',
  `regStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'User Approval',
  `images` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `password`, `email`, `Date`, `fullName`, `groupId`, `trustStatus`, `regStatus`, `images`) VALUES
(1, 'muhammad', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'kl@m.v', '0000-00-00', 'MUHAMMAD Shaalan', 1, 0, 1, ''),
(792, 'Alin', '2ea6201a068c5fa0eea5d81a3863321a87f8d533', 'a@a', '2018-07-24', 'Ali Nasr', 0, 0, 1, ''),
(793, 'Ahmed', 'a5afbe2ae99a425af4cd9e79b15c5e99b8ff71be', 'W@w', '2018-07-24', 'Ahmed Shaalan', 0, 0, 1, ''),
(794, 'Sara', 'af38e33986d47fb48ac5ec761b6f6e723caa2737', 'S@s', '2018-07-24', 'Sara Muhammad', 0, 0, 1, ''),
(795, 'Abdulrhman', 'a07ac98d82e3aa50376f3c9947a37d44c4f02635', 'W@W', '2018-07-24', 'Abdulrhman Shaalan', 0, 0, 1, ''),
(796, 'Momo', 'a14b77b7d159a74da1454e7a60a59f8a27ac886d', 's@s', '2018-07-24', 'momo mame', 0, 0, 1, ''),
(797, 'moma', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'm@m', '2018-07-25', 'ldc. fc', 0, 0, 1, ''),
(798, 'mostafa', '123321', 'd@d', '2018-07-18', 'Mostafa Shaalan', 0, 0, 1, ''),
(799, 'ffffffffffff', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'o@o.com', '2018-07-27', '', 0, 0, 1, ''),
(800, 'momomo', 'b55593db3f83483e94bf67206c45a7385c1e65be', 'mo@mo.com', '2018-07-27', '', 0, 0, 1, ''),
(801, 'hahaha', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'mo@mo.com', '2018-07-27', '', 0, 0, 1, ''),
(802, 'Ali Mostafa', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Ali@Ali.com', '2018-07-27', '', 0, 0, 1, ''),
(809, 'hahaa', '5b9fe558f673d63309beb13bfa5da6c30a3ca1bf', 'm@m', '2018-08-02', 'moo mol', 0, 0, 1, ''),
(810, 'mohamed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'M@m', '2018-08-02', 'Mohamed shaalan', 0, 0, 1, '300361833_Capture.PNG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cId`),
  ADD KEY `itemComment` (`item_id`),
  ADD KEY `userComment` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`),
  ADD KEY `member_i` (`member_id`),
  ADD KEY `cat_i` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=811;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `itemComment` FOREIGN KEY (`item_id`) REFERENCES `items` (`itemId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userComment` FOREIGN KEY (`user_id`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_i` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_i` FOREIGN KEY (`member_id`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
