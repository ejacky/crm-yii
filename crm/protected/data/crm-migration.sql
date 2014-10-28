CREATE DATABASE `crm-migration` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;


DROP TABLE IF EXISTS `keycompany`;
CREATE TABLE IF NOT EXISTS `keycompany` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `CName` varchar(200) DEFAULT NULL,
  `CType` varchar(100) DEFAULT NULL,
  `CScope` varchar(200) DEFAULT NULL,
  `CScale` varchar(100) DEFAULT NULL,
  `CMail` varchar(500) DEFAULT NULL,
  `CFax` varchar(100) DEFAULT NULL,
  `CDress` varchar(500) DEFAULT NULL,
  `CPhone` varchar(100) DEFAULT NULL,
  `CCreater` varchar(100) DEFAULT NULL,
  `CTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CEditor` varchar(5000) DEFAULT NULL,
  `FolderID` varchar(100) DEFAULT NULL,
  `Share` varchar(20) DEFAULT NULL,
  `CRemark` text,
  `CNet` varchar(500) DEFAULT NULL,
  `CPostal` varchar(50) DEFAULT NULL,
  `F1` varchar(500) DEFAULT NULL,
  `F2` varchar(500) DEFAULT NULL,
  `CManage` varchar(100) DEFAULT NULL,
  `CMobile` varchar(100) DEFAULT NULL,
  `CVCnt` int(10) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `PK_KeyCompany` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `keyconnect`;
CREATE TABLE IF NOT EXISTS `keyconnect` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `CName` varchar(50) DEFAULT NULL,
  `CSex` varchar(50) DEFAULT NULL,
  `CDuty` varchar(50) DEFAULT NULL,
  `CPhone` varchar(50) DEFAULT NULL,
  `CMSN` varchar(50) DEFAULT NULL,
  `CQQ` varchar(50) DEFAULT NULL,
  `CMobile` varchar(50) DEFAULT NULL,
  `CEmail` varchar(50) DEFAULT NULL,
  `CNote` varchar(2000) DEFAULT NULL,
  `FID` int(10) DEFAULT NULL,
  `CActor` varchar(20) DEFAULT NULL,
  `CF1` varchar(50) DEFAULT NULL,
  `CF2` varchar(50) DEFAULT NULL,
  `CF3` varchar(50) DEFAULT NULL,
  `CF4` varchar(50) DEFAULT NULL,
  `CF5` varchar(50) DEFAULT NULL,
  `CF6` varchar(50) DEFAULT NULL,
  `CF7` varchar(200) DEFAULT NULL,
  `CF8` varchar(200) DEFAULT NULL,
  `Skype` varchar(100) DEFAULT NULL,
  `CreUser` int(10) DEFAULT NULL,
  `CreDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `PK_KeyConnect` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- 转存表中的数据 `keycompany`
--


DROP TABLE IF EXISTS `keycustomer_ls`;
CREATE TABLE IF NOT EXISTS `keycustomer_ls` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `CustomerID` int(10) DEFAULT NULL,
  `CustomerCID` int(10) DEFAULT NULL,
  `Type1` varchar(100) DEFAULT NULL,
  `Type2` varchar(500) DEFAULT NULL,
  `LSA0188` int(10) DEFAULT NULL,
  `LSDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NLSDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Remark` text,
  `Remark1` varchar(5000) DEFAULT NULL,
  `JDA0188` int(10) DEFAULT NULL,
  `JDDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `PK_KeyCustomer_LS` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;