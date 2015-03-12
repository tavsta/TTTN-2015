-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2014 at 09:08 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `birthdate` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `address`, `email`, `name`, `password`, `telephone`, `sex`, `type`, `username`, `job`, `company`, `lastvisit`, `createddate`, `enable`, `birthdate`) VALUES
(42, 'Quận 11, HCM', 'tavsta47@gmail.com', 'Trần Phúc', '202cb962ac59075b964b07152d234b70', '01689 167 693', 0, '', 'phuc', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '1992-10-04'),
(43, '', '', 'Trung', '202cb962ac59075b964b07152d234b70', '', 0, '', 'trung', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `globalid` bigint(20) NOT NULL,
  `memberid` bigint(20) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `globalid`, `memberid`, `time`, `content`) VALUES
(1, 70, 42, '2014-12-18 19:34:46', 'Xin chào'),
(2, 70, 42, '2014-12-18 19:43:00', 'I want to tell you the most thing');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `status` int(11) DEFAULT '-1',
  `model` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `manufacturer` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `status`, `model`, `quantity`, `manufacturer`, `type`, `description`) VALUES
(1, 'Dell Vostro 1450', -1, 'Dell Vostro 1450', 10, 'Dell', 'Laptop', 'Laptop này đã sữ dụng 1 năm.\r\nCấu hình: '),
(2, 'Oppo Joy R1001', -1, 'Oppo Joy R1001', 2, 'Oppo', 'Smart Phone', 'OPPO Joy R1001 mang trên mình thiết kế nhỏ gọn, vừa vặn trong lòng bàn tay người dùng. Mặt sau máy được làm từ nhựa cao cấp trong khi viền kim loại ở cạnh bên giả kim loại sáng bóng đầy sang trọng. Logo OPPO là điểm nhấn duy nhất ở mặt sau, nằm dưới camera và đèn flash. Cảm giác cầm máy rất thoải mái, cho phép bạn thao tác một thời gian dài mà không thấy mỏi mệt.');

-- --------------------------------------------------------

--
-- Table structure for table `global`
--

CREATE TABLE IF NOT EXISTS `global` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `belongto` bigint(20) NOT NULL,
  `leaderid` bigint(20) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `enddate` text NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `type` text NOT NULL,
  `startdate` text NOT NULL,
  `createddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

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
(76, 71, 42, '', '2014-10-09', 'Đọc tài liệu', 'TASK', '2014-10-09', '2014-12-17 19:36:09');

-- --------------------------------------------------------

--
-- Table structure for table `global_equipment`
--

CREATE TABLE IF NOT EXISTS `global_equipment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `equipmentid` bigint(20) NOT NULL,
  `globalid` bigint(20) NOT NULL,
  `startdate` text NOT NULL,
  `enddate` text,
  `quality` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `global_member`
--

CREATE TABLE IF NOT EXISTS `global_member` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `joineddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memberid` bigint(20) DEFAULT NULL,
  `globalid` bigint(20) DEFAULT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `globalid` (`globalid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8439 ;

--
-- Dumping data for table `global_member`
--

INSERT INTO `global_member` (`id`, `joineddate`, `memberid`, `globalid`, `status`) VALUES
(8327, '2014-12-11 18:05:35', 41, 47, ''),
(8328, '2014-12-11 18:10:53', 0, 48, ''),
(8329, '2014-12-11 18:12:53', 0, 49, ''),
(8330, '2014-12-11 18:15:45', 0, 50, ''),
(8331, '2014-12-11 18:16:22', 0, 51, ''),
(8334, '2014-12-11 18:27:07', 42, 53, ''),
(8335, '2014-12-11 18:27:38', 42, 54, ''),
(8336, '2014-12-11 18:27:39', 41, 54, ''),
(8337, '2014-12-11 18:28:16', 42, 55, ''),
(8338, '2014-12-11 18:28:16', 41, 55, ''),
(8340, '2014-12-12 11:55:37', 42, 49, ''),
(8341, '2014-12-12 11:55:37', 41, 49, ''),
(8342, '2014-12-12 11:58:40', 0, 50, ''),
(8343, '2014-12-12 11:59:51', 0, 51, ''),
(8345, '2014-12-12 12:15:13', 0, 53, ''),
(8346, '2014-12-12 12:31:29', 0, 54, ''),
(8347, '2014-12-12 13:01:36', 0, 55, ''),
(8349, '2014-12-12 13:51:32', 0, 57, ''),
(8350, '2014-12-12 18:19:50', 0, 58, ''),
(8351, '2014-12-12 18:23:12', 0, 59, ''),
(8352, '2014-12-15 12:34:35', 0, 60, ''),
(8353, '2014-12-15 12:37:33', 0, 61, ''),
(8354, '2014-12-15 12:37:54', 0, 62, ''),
(8355, '2014-12-15 13:13:23', 42, 0, ''),
(8405, '2014-12-15 19:54:38', 0, 63, ''),
(8408, '2014-12-16 02:21:30', 42, 44, ''),
(8409, '2014-12-16 02:21:38', 0, 56, ''),
(8410, '2014-12-16 03:29:15', 41, 52, ''),
(8411, '2014-12-16 03:41:08', 0, 65, ''),
(8412, '2014-12-16 03:41:24', 0, 66, ''),
(8413, '2014-12-16 03:49:57', 0, 67, ''),
(8414, '2014-12-16 03:59:27', 0, 68, ''),
(8415, '2014-12-16 04:00:07', 0, 69, ''),
(8418, '2014-12-16 04:21:54', 42, 73, ''),
(8419, '2014-12-16 04:21:54', 43, 73, ''),
(8421, '2014-12-16 04:34:23', 0, 74, ''),
(8434, '2014-12-18 18:56:05', 42, 71, ''),
(8437, '2014-12-18 19:06:14', 0, 75, ''),
(8438, '2014-12-18 19:51:34', 0, 76, '');

-- --------------------------------------------------------

--
-- Table structure for table `member_skill`
--

CREATE TABLE IF NOT EXISTS `member_skill` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `memberid` bigint(20) NOT NULL,
  `skillid` bigint(20) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `predecessor`
--

CREATE TABLE IF NOT EXISTS `predecessor` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `child` bigint(20) NOT NULL,
  `parent` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `belongto` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
