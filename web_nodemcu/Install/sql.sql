-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 07 月 21 日 15:08
-- 服务器版本: 5.5.47
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ms`
--

-- --------------------------------------------------------

--
-- 表的结构 `v_count`
--

CREATE TABLE IF NOT EXISTS `v_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `count` int(11) NOT NULL,
  `datetime` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `v_count`
--

INSERT INTO `v_count` (`id`, `count`, `datetime`) VALUES
(1, 558, '2017-07-21');

-- --------------------------------------------------------

--
-- 表的结构 `v_info`
--

CREATE TABLE IF NOT EXISTS `v_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` int(11) NOT NULL,
  `start_yue` text NOT NULL,
  `end_yue` text NOT NULL,
  `rate` int(11) NOT NULL,
  `Tj` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `v_info`
--

INSERT INTO `v_info` (`id`, `month`, `start_yue`, `end_yue`, `rate`, `Tj`) VALUES
(1, 6, '2017-06-25', '2017-06-30', 300, '15'),
(4, 1, '2016-05-12', '2016-05-16', 400, '20');


CREATE TABLE IF NOT EXISTS `status_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wendu` int(11) NOT NULL,
  `shidu` int(11) NOT NULL,
  `room` text NOT NULL,
  `weather` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
