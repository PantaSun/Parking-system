-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-03-22 03:10:12
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `parking_system`
--

-- --------------------------------------------------------

--
-- 表的结构 `ps_car`
--

CREATE TABLE IF NOT EXISTS `ps_car` (
  `psc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `psc_username` varchar(20) NOT NULL,
  `psc_platenumber` varchar(8) NOT NULL,
  `psc_type` char(10) NOT NULL,
  `psc_color` char(8) NOT NULL,
  `psc_state` char(1) DEFAULT NULL,
  PRIMARY KEY (`psc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `ps_car`
--

INSERT INTO `ps_car` (`psc_id`, `psc_username`, `psc_platenumber`, `psc_type`, `psc_color`, `psc_state`) VALUES
(2, 'test1', '辽Fqq399', '奔驰666', '蓝色', '1'),
(3, 'test', '辽Fqq363', '夏利233', '白色', '1');

-- --------------------------------------------------------

--
-- 表的结构 `ps_inout`
--

CREATE TABLE IF NOT EXISTS `ps_inout` (
  `psi_id` int(11) NOT NULL AUTO_INCREMENT,
  `psi_position` char(3) DEFAULT NULL,
  `psi_platenumber` char(7) NOT NULL,
  `psi_intime` datetime DEFAULT NULL,
  `psi_outtime` datetime DEFAULT NULL,
  PRIMARY KEY (`psi_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `ps_inout`
--

INSERT INTO `ps_inout` (`psi_id`, `psi_position`, `psi_platenumber`, `psi_intime`, `psi_outtime`) VALUES
(24, '110', '辽Fqq399', '2016-03-21 23:31:37', NULL),
(23, '111', '辽Fqq363', '2016-03-21 23:31:00', NULL),
(22, '111', '辽Fqq399', '2016-03-13 15:57:32', '2016-03-13 15:59:34'),
(21, '111', '辽Fqq399', '2016-03-12 21:20:48', '2016-03-13 15:59:34'),
(20, '111', '辽Fqq399', '2016-03-12 21:18:55', '2016-03-13 15:59:34');

-- --------------------------------------------------------

--
-- 表的结构 `ps_position`
--

CREATE TABLE IF NOT EXISTS `ps_position` (
  `psp_id` int(3) NOT NULL AUTO_INCREMENT,
  `psp_state` char(1) DEFAULT NULL,
  `psp_platenumber` char(7) DEFAULT NULL,
  PRIMARY KEY (`psp_id`),
  UNIQUE KEY `psp_platenumber` (`psp_platenumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=214 ;

--
-- 转存表中的数据 `ps_position`
--

INSERT INTO `ps_position` (`psp_id`, `psp_state`, `psp_platenumber`) VALUES
(111, '1', '辽Fqq363'),
(110, '1', '辽Fqq399'),
(109, NULL, NULL),
(108, NULL, NULL),
(107, NULL, NULL),
(106, NULL, NULL),
(105, NULL, NULL),
(104, NULL, NULL),
(103, NULL, NULL),
(100, NULL, NULL),
(112, NULL, NULL),
(113, NULL, NULL),
(114, NULL, NULL),
(115, NULL, NULL),
(116, NULL, NULL),
(117, NULL, NULL),
(118, NULL, NULL),
(119, NULL, NULL),
(120, NULL, NULL),
(121, NULL, NULL),
(122, NULL, NULL),
(123, NULL, NULL),
(124, NULL, NULL),
(125, NULL, NULL),
(126, NULL, NULL),
(127, NULL, NULL),
(128, NULL, NULL),
(129, NULL, NULL),
(130, NULL, NULL),
(131, NULL, NULL),
(132, NULL, NULL),
(133, NULL, NULL),
(134, NULL, NULL),
(135, NULL, NULL),
(136, NULL, NULL),
(137, NULL, NULL),
(138, NULL, NULL),
(139, NULL, NULL),
(140, NULL, NULL),
(141, NULL, NULL),
(142, NULL, NULL),
(143, NULL, NULL),
(144, NULL, NULL),
(145, NULL, NULL),
(146, NULL, NULL),
(147, NULL, NULL),
(148, NULL, NULL),
(149, NULL, NULL),
(150, NULL, NULL),
(151, NULL, NULL),
(152, NULL, NULL),
(153, NULL, NULL),
(154, NULL, NULL),
(155, NULL, NULL),
(156, NULL, NULL),
(157, NULL, NULL),
(158, NULL, NULL),
(159, NULL, NULL),
(160, NULL, NULL),
(161, NULL, NULL),
(162, NULL, NULL),
(163, NULL, NULL),
(164, NULL, NULL),
(165, NULL, NULL),
(166, NULL, NULL),
(167, NULL, NULL),
(168, NULL, NULL),
(169, NULL, NULL),
(170, NULL, NULL),
(171, NULL, NULL),
(172, NULL, NULL),
(173, NULL, NULL),
(174, NULL, NULL),
(175, NULL, NULL),
(176, NULL, NULL),
(177, NULL, NULL),
(178, NULL, NULL),
(179, NULL, NULL),
(180, NULL, NULL),
(181, NULL, NULL),
(182, NULL, NULL),
(183, NULL, NULL),
(184, NULL, NULL),
(185, NULL, NULL),
(186, NULL, NULL),
(187, NULL, NULL),
(188, NULL, NULL),
(189, NULL, NULL),
(190, NULL, NULL),
(191, NULL, NULL),
(192, NULL, NULL),
(193, NULL, NULL),
(194, NULL, NULL),
(195, NULL, NULL),
(196, NULL, NULL),
(197, NULL, NULL),
(198, NULL, NULL),
(199, NULL, NULL),
(102, NULL, NULL),
(101, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ps_user`
--

CREATE TABLE IF NOT EXISTS `ps_user` (
  `psu_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `psu_uniqid` char(40) NOT NULL,
  `psu_username` varchar(20) NOT NULL,
  `psu_password` char(40) NOT NULL,
  `psu_sex` char(1) NOT NULL,
  `psu_phone` varchar(11) NOT NULL,
  `psu_platenumber` char(7) NOT NULL,
  `psu_reg_time` datetime NOT NULL,
  `psu_money` double DEFAULT '0',
  `psu_auth` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`psu_id`),
  UNIQUE KEY `ps_username` (`psu_username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `ps_user`
--

INSERT INTO `ps_user` (`psu_id`, `psu_uniqid`, `psu_username`, `psu_password`, `psu_sex`, `psu_phone`, `psu_platenumber`, `psu_reg_time`, `psu_money`, `psu_auth`) VALUES
(2, '87de933814aea86a4bc5d73c081a1ad84e1eab93', '请问请问1', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽D11sd1', '2016-02-29 10:28:14', 100, 0),
(3, 'ca2e7a2f1b85607a67de363a2058b04e93b22e6c', 'test', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903023', '辽Fqq363', '2016-03-01 17:04:02', 10070, 0),
(4, '5a39668a9a63027994937c17a5aa737a4a3a45c6', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽FQQ345', '2016-03-06 21:08:49', 0, 1),
(5, 'f704e01cbe3be2efadc9ca5fa4b0d103c31c95cf', 'test1', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽Fqq399', '2016-03-08 01:12:27', 1180, 0),
(6, '1c7165bd239fa02c017bb1c51deb5737b4358b5e', 'test3', '7c4a8d09ca3762af61e59520943dc26494f8941b', '女', '18710903022', '辽Qqq360', '2016-03-08 01:14:31', 40, 0),
(7, 'asfsdfsfsdgfsgdg', 'test4', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(8, 'asfsdfsfsdgfsgdg', 'test5', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(9, 'asfsdfsfsdgfsgdg', 'test6', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(10, 'asfsdfsfsdgfsgdg', 'test7', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(11, 'asfsdfsfsdgfsgdg', 'test8', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(12, 'asfsdfsfsdgfsgdg', 'test9', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(13, 'asfsdfsfsdgfsgdg', 'test10', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(14, 'asfsdfsfsdgfsgdg', 'test11', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(15, 'asfsdfsfsdgfsgdg', 'test12', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽F11360', '2016-03-10 00:00:00', 190, 0),
(16, 'dca5f9c2de4bad34a26532cdadb6b7577c03689a', 'test120', '7c4a8d09ca3762af61e59520943dc26494f8941b', '男', '18710903022', '辽FQQ360', '2016-03-12 21:01:00', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
