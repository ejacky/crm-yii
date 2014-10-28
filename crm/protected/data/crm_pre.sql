-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 07 月 17 日 11:20
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `crm`
--

-- --------------------------------------------------------

--
-- 表的结构 `co_category`
--

DROP TABLE IF EXISTS `co_category`;
CREATE TABLE IF NOT EXISTS `co_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `name_space` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `weight` int(10) NOT NULL,
  `father_id` int(10) NOT NULL,
  `level` int(10) NOT NULL,
  `tail` int(10) NOT NULL,
  `item` int(10) NOT NULL,
  `value1` int(10) NOT NULL,
  `value2` int(10) NOT NULL,
  `value3` varchar(255) NOT NULL,
  `value4` varchar(255) NOT NULL,
  `value5` text NOT NULL,
  `value6` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `co_category`
--


-- --------------------------------------------------------

--
-- 表的结构 `co_department_position`
--

DROP TABLE IF EXISTS `co_department_position`;
CREATE TABLE IF NOT EXISTS `co_department_position` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `department_id` int(10) NOT NULL,
  `position` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `co_department_position`
--


-- --------------------------------------------------------

--
-- 表的结构 `co_property`
--

DROP TABLE IF EXISTS `co_property`;
CREATE TABLE IF NOT EXISTS `co_property` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `org_id` int(10) NOT NULL,
  `topic_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `co_property`
--


-- --------------------------------------------------------

--
-- 表的结构 `co_role`
--

DROP TABLE IF EXISTS `co_role`;
CREATE TABLE IF NOT EXISTS `co_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `system_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `co_role`
--


-- --------------------------------------------------------

--
-- 表的结构 `co_role_task`
--

DROP TABLE IF EXISTS `co_role_task`;
CREATE TABLE IF NOT EXISTS `co_role_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `org_id` int(10) NOT NULL,
  `role_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `co_role_task`
--


-- --------------------------------------------------------

--
-- 表的结构 `co_staff`
--

DROP TABLE IF EXISTS `co_staff`;
CREATE TABLE IF NOT EXISTS `co_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `task_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `co_staff`
--

INSERT INTO `co_staff` (`id`, `username`, `password`, `email`, `task_id`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'ejacky001@gmail.com', 0),
(2, 'root', 'e10adc3949ba59abbe56e057f20f883e', NULL, 0),
(3, 'abc', 'e10adc3949ba59abbe56e057f20f883e', 'ejacky001@gmail.com', 0);

-- --------------------------------------------------------

--
-- 表的结构 `co_task`
--

DROP TABLE IF EXISTS `co_task`;
CREATE TABLE IF NOT EXISTS `co_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `org_id` int(10) NOT NULL,
  `system_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `co_task`
--


-- --------------------------------------------------------

--
-- 表的结构 `fu_crm_client_company`
--

DROP TABLE IF EXISTS `fu_crm_client_company`;
CREATE TABLE IF NOT EXISTS `fu_crm_client_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `editStaff_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `trade` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `incomePerYear` float DEFAULT NULL,
  `peopleNumber` int(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fu_crm_client_company`
--


--
-- 表的结构 `fu_crm_client_employees`
--

DROP TABLE IF EXISTS `fu_crm_client_employees`;
CREATE TABLE IF NOT EXISTS `fu_crm_client_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fu_crm_client_employees`
--


-- --------------------------------------------------------

--
-- 表的结构 `fu_crm_company_log`
--

DROP TABLE IF EXISTS `fu_crm_company_log`;
CREATE TABLE IF NOT EXISTS `fu_crm_company_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `diff` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fu_crm_company_log`
--


--
-- 表的结构 `fu_crm_company_record`
--

DROP TABLE IF EXISTS `fu_crm_company_record`;
CREATE TABLE IF NOT EXISTS `fu_crm_company_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `companyLog_id` int(11) NOT NULL,
  `newRecord` tinyint(1) NOT NULL,
  `recentInfo` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fu_crm_company_record`
--


-- --------------------------------------------------------

--
-- 表的结构 `fu_crm_employees_log`
--

DROP TABLE IF EXISTS `fu_crm_employees_log`;
CREATE TABLE IF NOT EXISTS `fu_crm_employees_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `diff` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `fu_crm_employees_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `fu_crm_task`
--

DROP TABLE IF EXISTS `fu_crm_task`;
CREATE TABLE IF NOT EXISTS `fu_crm_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `employees_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- 转存表中的数据 `fu_crm_task`
--


