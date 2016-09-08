-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2016 年 03 月 07 日 02:28
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `hm`
--
CREATE DATABASE IF NOT EXISTS `hm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hm`;

-- --------------------------------------------------------

--
-- 表的结构 `hm_class`
--

CREATE TABLE IF NOT EXISTS `hm_class` (
  `bno` varchar(9) NOT NULL,
  `bname` varchar(32) NOT NULL,
  `bnum` int(11) NOT NULL,
  PRIMARY KEY (`bno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hm_class`
--

INSERT INTO `hm_class` (`bno`, `bname`, `bnum`) VALUES
('134010101', '计科131班', 35),
('134010102', '计科132班', 35);

-- --------------------------------------------------------

--
-- 表的结构 `hm_course`
--

CREATE TABLE IF NOT EXISTS `hm_course` (
  `cno` char(11) NOT NULL,
  `cname` varchar(20) NOT NULL,
  `credit` int(11) NOT NULL,
  PRIMARY KEY (`cno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hm_course`
--

INSERT INTO `hm_course` (`cno`, `cname`, `credit`) VALUES
('100001', '计算机网络', 4),
('100002', 'JavaWeb入门', 2),
('100005', '大学英语', 4);

-- --------------------------------------------------------

--
-- 表的结构 `hm_manage`
--

CREATE TABLE IF NOT EXISTS `hm_manage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `managename` varchar(10) NOT NULL,
  `managepwd` varchar(32) NOT NULL,
  `logintime` int(10) unsigned NOT NULL,
  `loginip` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `hm_manage`
--

INSERT INTO `hm_manage` (`id`, `managename`, `managepwd`, `logintime`, `loginip`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1452147255, '0.0.0.0');

-- --------------------------------------------------------

--
-- 表的结构 `hm_student`
--

CREATE TABLE IF NOT EXISTS `hm_student` (
  `sno` char(11) NOT NULL,
  `sname` varchar(12) NOT NULL,
  `password` char(32) NOT NULL,
  `bno` varchar(9) NOT NULL,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hm_student`
--

INSERT INTO `hm_student` (`sno`, `sname`, `password`, `bno`) VALUES
('13401010101', '陈丽', 'e10adc3949ba59abbe56e057f20f883e', '134010101'),
('13401010102', '杨剑敏', 'e10adc3949ba59abbe56e057f20f883e', '134010101'),
('13401010103', '高佳慧', 'e10adc3949ba59abbe56e057f20f883e', '134010101'),
('13401010123', '吴俊杰', 'e10adc3949ba59abbe56e057f20f883e', '134010101'),
('13401010133', '李贵祥', 'e10adc3949ba59abbe56e057f20f883e', '134010101'),
('13401010137', '宁伟', 'e10adc3949ba59abbe56e057f20f883e', '134010101'),
('13401010138', '许吉发', 'e10adc3949ba59abbe56e057f20f883e', '134010101'),
('13401010201', '刘欢', 'e10adc3949ba59abbe56e057f20f883e', '134010102'),
('13401010210', '霍炳雳', 'e10adc3949ba59abbe56e057f20f883e', '134010102');

-- --------------------------------------------------------

--
-- 表的结构 `hm_sup`
--

CREATE TABLE IF NOT EXISTS `hm_sup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sno` char(11) NOT NULL,
  `score` int(11) NOT NULL,
  `comment` varchar(50) NOT NULL,
  `tmp_name` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `error` int(2) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `cno` varchar(11) NOT NULL,
  `theme` varchar(32) NOT NULL,
  `other` varchar(50) NOT NULL,
  `uptime` int(10) NOT NULL,
  `tno` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `hm_sup`
--

INSERT INTO `hm_sup` (`id`, `sno`, `score`, `comment`, `tmp_name`, `name`, `error`, `type`, `size`, `cno`, `theme`, `other`, `uptime`, `tno`) VALUES
(7, '13401010138', 80, '再接再厉', 'C:\\xampp\\tmp\\phpA9EA.tmp', '数据库理论与技术实验报告二.doc', 0, 'application/msword', 181813, '100001', '作业2', '2222222222222222', 1451808048, '00000000001'),
(8, '13401010123', 100, '不错哟', 'C:\\xampp\\tmp\\php762.tmp', '附件一：分组.xls', 0, 'application/vnd.ms-excel', 8704, '100001', '作业1111111', '我去你吗', 1451885778, '00000000001'),
(9, '13401010138', 0, '', 'C:\\xampp\\tmp\\phpD660.tmp', 'student.xlsx', 0, 'application/vnd.openxmlformats', 9810, '100001', '计算机网络作业1', '', 1452086646, '00000000001');

-- --------------------------------------------------------

--
-- 表的结构 `hm_teacher`
--

CREATE TABLE IF NOT EXISTS `hm_teacher` (
  `tno` varchar(11) NOT NULL,
  `tname` varchar(12) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`tno`),
  UNIQUE KEY `tno` (`tno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hm_teacher`
--

INSERT INTO `hm_teacher` (`tno`, `tname`, `password`) VALUES
('00000000001', '王五ddd', 'e10adc3949ba59abbe56e057f20f883e'),
('00000000002', '赵六', 'e10adc3949ba59abbe56e057f20f883e'),
('10010100103', '张三', 'e10adc3949ba59abbe56e057f20f883e'),
('10010100104', '李四', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- 表的结构 `hm_teach_course`
--

CREATE TABLE IF NOT EXISTS `hm_teach_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cno` char(11) NOT NULL,
  `tno` varchar(11) NOT NULL,
  `bno` varchar(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `hm_teach_course`
--

INSERT INTO `hm_teach_course` (`id`, `cno`, `tno`, `bno`) VALUES
(11, '100001', '00000000001', '134010101'),
(12, '100002', '00000000001', '134010102'),
(13, '100005', '00000000001', '134010101');

-- --------------------------------------------------------

--
-- 表的结构 `hm_teattach`
--

CREATE TABLE IF NOT EXISTS `hm_teattach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tmp_name` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `error` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `hm_teattach`
--

INSERT INTO `hm_teattach` (`id`, `tmp_name`, `name`, `size`, `type`, `error`) VALUES
(12, 'C:\\xampp\\tmp\\php81B.tmp', '封面.doc', 163840, 'application/msword', 0),
(13, 'C:\\xampp\\tmp\\php1D80.tmp', 'XXX系统报告1.doc', 42496, 'application/msword', 0),
(14, '', '', 0, '', 4),
(15, 'C:\\xampp\\tmp\\php5F02.tmp', '数据库期末总复习.doc', 162315, 'application/msword', 0),
(16, 'C:\\xampp\\tmp\\php1E6D.tmp', 'JavaEE实验报告.doc', 2011648, 'application/msword', 0);

-- --------------------------------------------------------

--
-- 表的结构 `hm_teawork`
--

CREATE TABLE IF NOT EXISTS `hm_teawork` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cno` char(11) NOT NULL,
  `homework_theme` varchar(32) NOT NULL,
  `homework_detail` varchar(255) NOT NULL,
  `publishtime` int(10) NOT NULL,
  `deadline` int(20) NOT NULL,
  `tmp_name` varchar(30) NOT NULL,
  `tno` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `hm_teawork`
--

INSERT INTO `hm_teawork` (`id`, `cno`, `homework_theme`, `homework_detail`, `publishtime`, `deadline`, `tmp_name`, `tno`) VALUES
(12, '100001', '计算机网络作业1', '作业一，请大家认真完成', 1451746609, 1452182400, 'C:\\xampp\\tmp\\php81B.tmp', '00000000001'),
(13, '100002', 'JavaWeb作业1', 'Javaweb第一次作业，一定好好完成', 1451746680, 1452182400, 'C:\\xampp\\tmp\\php1D80.tmp', '00000000001'),
(14, '100001', '作业2', '我没想说的', 1451806398, 1452182400, '', '00000000001'),
(15, '100001', '作业1111111', '飓风桑迪框架啊发了卡萨丁付了款 ', 1451885669, 1452873600, 'C:\\xampp\\tmp\\php5F02.tmp', '00000000001'),
(16, '100005', 'dfsd', 'fdsa', 1452146482, 1452700800, 'C:\\xampp\\tmp\\php1E6D.tmp', '00000000001');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
