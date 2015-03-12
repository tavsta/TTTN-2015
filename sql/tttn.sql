-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2015 at 04:20 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tttn`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
`id` bigint(20) NOT NULL,
  `address` text CHARACTER SET utf8 NOT NULL,
  `email` text NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `sex` int(11) NOT NULL,
  `type` text CHARACTER SET utf8 NOT NULL,
  `username` text NOT NULL,
  `job` text CHARACTER SET utf8 NOT NULL,
  `company` text CHARACTER SET utf8 NOT NULL,
  `lastvisit` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `enable` int(11) NOT NULL DEFAULT '1',
  `birthdate` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `address`, `email`, `name`, `password`, `telephone`, `sex`, `type`, `username`, `job`, `company`, `lastvisit`, `createddate`, `enable`, `birthdate`) VALUES
(45, '', '', 'Phúc', '6dd544e6b7ab3369a62d4c994362a3cc', '', 0, '', 'phuc123', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `attr`
--

CREATE TABLE IF NOT EXISTS `attr` (
`id` bigint(20) NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `type` text NOT NULL,
  `projectid` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attr`
--

INSERT INTO `attr` (`id`, `name`, `description`, `type`, `projectid`) VALUES
(3, 'hẹ', 'skđhfkshdf', '', 70);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
`id` bigint(20) NOT NULL,
  `globalid` bigint(20) NOT NULL,
  `memberid` bigint(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `globalid`, `memberid`, `time`, `content`) VALUES
(1, 70, 42, '2014-12-18 19:34:46', 'Xin chào'),
(2, 70, 42, '2014-12-18 19:43:00', 'I want to tell you the most thing'),
(3, 77, 45, '2015-03-13 03:04:37', 'khv v ;df '),
(4, 77, 45, '2015-03-13 03:04:42', 'smfs llsjf ');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
`id` bigint(20) NOT NULL,
  `taskid` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `model` text NOT NULL,
  `group` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `taskid`, `name`, `model`, `group`, `description`) VALUES
(3, 77, 'jsdf ', 'kahs d', 'NORMAL', ''),
(4, 0, 'Iphone', '123', 'NORMAL', 'Iphone 5');

-- --------------------------------------------------------

--
-- Table structure for table `global`
--

CREATE TABLE IF NOT EXISTS `global` (
`id` bigint(20) NOT NULL,
  `belongto` bigint(20) NOT NULL,
  `leaderid` bigint(20) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `enddate` text NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `type` text NOT NULL,
  `startdate` text NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global`
--

INSERT INTO `global` (`id`, `belongto`, `leaderid`, `description`, `enddate`, `name`, `type`, `startdate`, `createddate`) VALUES
(70, 0, 42, 'Xây dựng website "Quản lý dự án phần mềm"', '2014-12-22', 'Thực tập tốt nghiệp', 'PROJECT', '2014-09-09', '2014-12-16 04:02:23'),
(71, 70, 42, '', '2014-10-09', 'Đọc và hiểu đề tài', 'TASK', '2014-09-09', '2014-12-16 04:03:12'),
(72, 0, 43, 'Làm một website', '2014-12-12', 'Xây dựng phần mềm Quản lý dự án', 'PROJECT', '2014-09-09', '2014-12-16 04:12:51'),
(73, 72, 43, '', '2014-09-10', 'Đọc đề tài', 'TASK', '2014-09-09', '2014-12-16 04:21:54'),
(74, 73, 43, '', '2014-10-10', 'Tìm kiếm tài liệu', 'TASK', '2014-10-09', '2014-12-16 04:26:18'),
(75, 70, 43, '', '2014-12-22', 'Phân tích yêu cầu', 'TASK', '2014-11-07', '2014-12-16 04:35:26'),
(76, 71, 42, '', '2014-10-09', 'Đọc tài liệu', 'TASK', '2014-10-09', '2014-12-17 19:36:09'),
(77, 71, 0, 'Hiểu tài liệu như thế nào', '2014-10-09', 'Hiểu', 'TASK', '2014-09-09', '2015-03-13 02:58:22');

-- --------------------------------------------------------

--
-- Table structure for table `global_attribute`
--

CREATE TABLE IF NOT EXISTS `global_attribute` (
`id` bigint(20) NOT NULL,
  `attributeid` bigint(20) NOT NULL,
  `globalid` bigint(20) NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `global_attribute`
--

INSERT INTO `global_attribute` (`id`, `attributeid`, `globalid`, `value`) VALUES
(1, 3, 77, 'ào ào'),
(2, 3, 77, ''),
(3, 3, 77, ''),
(4, 3, 77, ''),
(5, 3, 77, ''),
(6, 3, 77, ''),
(7, 3, 77, ''),
(8, 3, 77, ''),
(9, 3, 77, ''),
(10, 3, 77, ''),
(11, 3, 77, ''),
(12, 3, 77, ''),
(13, 3, 77, ''),
(14, 3, 77, ''),
(15, 3, 77, ''),
(16, 3, 77, ''),
(17, 3, 77, ''),
(18, 3, 77, '');

-- --------------------------------------------------------

--
-- Table structure for table `global_equipment`
--

CREATE TABLE IF NOT EXISTS `global_equipment` (
`id` bigint(20) NOT NULL,
  `equipmentid` bigint(20) NOT NULL,
  `globalid` bigint(20) NOT NULL,
  `startdate` text NOT NULL,
  `enddate` text,
  `quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `global_member`
--

CREATE TABLE IF NOT EXISTS `global_member` (
`id` bigint(20) NOT NULL,
  `joineddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memberid` bigint(20) DEFAULT NULL,
  `globalid` bigint(20) DEFAULT NULL,
  `status` text NOT NULL,
  `mission` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8439 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `member_skill`
--

CREATE TABLE IF NOT EXISTS `member_skill` (
`id` bigint(20) NOT NULL,
  `memberid` bigint(20) NOT NULL,
  `skillid` bigint(20) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `predecessor`
--

CREATE TABLE IF NOT EXISTS `predecessor` (
`id` bigint(20) NOT NULL,
  `child` bigint(20) NOT NULL,
  `parent` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
`id` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `belongto` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attr`
--
ALTER TABLE `attr`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global`
--
ALTER TABLE `global`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_attribute`
--
ALTER TABLE `global_attribute`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_equipment`
--
ALTER TABLE `global_equipment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global_member`
--
ALTER TABLE `global_member`
 ADD PRIMARY KEY (`id`), ADD KEY `globalid` (`globalid`);

--
-- Indexes for table `member_skill`
--
ALTER TABLE `member_skill`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predecessor`
--
ALTER TABLE `predecessor`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `attr`
--
ALTER TABLE `attr`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `global`
--
ALTER TABLE `global`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `global_attribute`
--
ALTER TABLE `global_attribute`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `global_equipment`
--
ALTER TABLE `global_equipment`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `global_member`
--
ALTER TABLE `global_member`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8439;
--
-- AUTO_INCREMENT for table `member_skill`
--
ALTER TABLE `member_skill`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `predecessor`
--
ALTER TABLE `predecessor`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
