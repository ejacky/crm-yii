-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 07 月 19 日 14:59
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.5

#CREATE DATABASE `crm` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;





DROP TABLE IF EXISTS `co_department_title`;
CREATE TABLE IF NOT EXISTS `co_department_title` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `departmentID` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `co_property`;
CREATE TABLE IF NOT EXISTS `co_property` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `topic_id` int(10) NOT NULL,
  `nameSpace` varchar(255) NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `co_property` (`id`, `topic_id`, `nameSpace`, `title`) VALUES
(1, 0, 'crm-title', '组长,副组长,工人');


DROP TABLE IF EXISTS `co_department`;
CREATE TABLE IF NOT EXISTS `co_department` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fatherId` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `displayName` varchar(255) NOT NULL,
  `order` int(10) NOT NULL,
  `departmentPosition` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
INSERT INTO `co_department` (`id`, `fatherId`, `name`, `displayName`, `order`, `departmentPosition`) VALUES
(1, 0, 'sales', '销售部3', 0, 'sales,marketing'),
(2, 1, 'sales-one', '销售一组', 0, '');


DROP TABLE IF EXISTS `co_position`;
CREATE TABLE IF NOT EXISTS `co_position` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `displayName` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `co_position` (`name`, `displayName`) VALUES
('sales', '销售专员'),
('marketing', '市场部专员');


DROP TABLE IF EXISTS `co_staff`;
CREATE TABLE IF NOT EXISTS `co_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ename` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `birthday` VARCHAR(255) NOT NULL,
  `hobby` varchar(255) NOT NULL,
  `mobilePhone` VARCHAR(255) NOT NULL,
  `qq` VARCHAR(255) NOT NULL,
  `msn` VARCHAR(255) NOT NULL,
  `skype` VARCHAR(255) NOT NULL,
  `hometown` VARCHAR(255) NOT NULL,
  `idCard` VARCHAR(255) NOT NULL,
  `entryDate` VARCHAR(255) NOT NULL,
  `educational` VARCHAR(255) NOT NULL,
  `graduateSchool` VARCHAR(255) NOT NULL,
  `graduationYear` VARCHAR(255) NOT NULL,
  `bank` VARCHAR(255) NOT NULL,
  `bankCard` VARCHAR(255) NOT NULL,
  `emcName` VARCHAR(255) NOT NULL,
  `emcPhone` VARCHAR(255) NOT NULL,
  `hasPet` VARCHAR(255) NOT NULL,
  `petType` VARCHAR(255) NOT NULL,
  `nation` VARCHAR(255) NOT NULL,
  `politics` VARCHAR(255) NOT NULL,
  `marital` VARCHAR(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `calendarTheme` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
INSERT INTO `co_staff` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'ejacky001@gmail.com'),
(2, 'root', 'e10adc3949ba59abbe56e057f20f883e', NULL),
(3, 'abc', 'e10adc3949ba59abbe56e057f20f883e', 'ejacky001@gmail.com'),
(4, 'Temp', 'e10adc3949ba59abbe56e057f20f883e', 'null');


DROP TABLE IF EXISTS `co_role`;
CREATE TABLE IF NOT EXISTS `co_role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `displayName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `co_role` (`name`, `displayName`, `description`) VALUES
('roleA', '角色A', '这个是角色A');


DROP TABLE IF EXISTS `co_role_task`;
CREATE TABLE IF NOT EXISTS `co_role_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `co_role_task` (`role_name`, `task_name`) VALUES
('roleA', 'privilege'),
('roleA', 'taskC');


DROP TABLE IF EXISTS `co_user_task`;
CREATE TABLE IF NOT EXISTS `co_user_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `co_task`;
CREATE TABLE IF NOT EXISTS `co_task` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `displayName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `co_task` (`name`, `displayName`, `description`) VALUES
('privilege', '权限B', '某权限'),
('taskC', '权限C', '');


DROP TABLE IF EXISTS `pa_attachment`;
CREATE TABLE IF NOT EXISTS `pa_attachment` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `uploadName` varchar(255) NOT NULL,
  `systemName` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `size` int(10) NOT NULL,
  `path` varchar(255) NOT NULL,
  `uploadTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `no_file`;
CREATE TABLE IF NOT EXISTS `no_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `userName_re` varchar(255) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `attachment_id` int(11) NOT NULL,
  `fileName_re` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pa_form`;
CREATE TABLE IF NOT EXISTS `pa_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `label` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `isEdit` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `groupName` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=11 ;
INSERT INTO `pa_form` (`name`, `label`, `isEdit`, `groupName`) VALUES
('client', '客户表单', 'yes', ''),
('contact', '联系人表单', 'yes', ''),
('staff', '员工表单', 'yes', ''),
('file', '文件表单', 'yes', ''),
('newField', '新建字段', 'no', ''),
('newForm', '新建表单', 'no', ''),
('course', '课程表单', 'yes', ''),
('lecturer', '讲师表单', 'yes', ''),
('trainee', '学员表单', 'yes', ''),
('questionnaire', '问卷信息表单', 'yes', ''),
('task', '任务表单', 'yes', ''),
('group', '分组表单', 'yes', ''),
('department', '部门', 'yes', ''),
('privilegeTask', '权限', 'yes', ''),
('role', '角色（权限组）', 'yes', ''),
('position', '职位', 'yes', ''),
('assist', '程序', 'yes', ''),
('coreTable', 'Table系统', 'yes', ''),
('coTask', '权限表单', 'yes', ''),
('coRole', '角色表单', 'yes', '');


DROP TABLE IF EXISTS `pa_field`;
CREATE TABLE IF NOT EXISTS `pa_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `defaultValue` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `type` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `nameSpace` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `attr` varchar(255) COLLATE utf8_general_ci 	 DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `label` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `isMust` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `explain` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;
INSERT INTO `pa_field` (`type`, `name`,  `label`, `nameSpace` ) VALUES
('text', 'textName', '文本框', 'fieldType' ),
('textarea', 'textareaName', '文本域', 'fieldType' ),
('SingleInnerSelect', 'SISName', '单级下拉菜单（attr）', 'fieldType'),
('SingleOutsideSelect', 'SOSName', '单级下拉菜单（外表）', 'fieldType'),
('SingleAndCanAddOptionSelect', 'SAOSName', '动态添加选项', 'fieldType'),
('MultipleOutsideSelect', 'MOSName', '多级下拉菜单', 'fieldType'),
('innerRadio', 'innerRadioName', '单选项(attr)', 'fieldType'),
('outsideRadio', 'outsideRadioName', '单选项(外表)', 'fieldType'),
('innerCheckbox', 'innerCheckboxName', '多选框(attr)', 'fieldType'),
('outsideCheckbox', 'outsideCheckboxName', '多选框(外表)', 'fieldType'),
('password', 'passwordName', '密码框', 'fieldType'),
('uploadPic', 'uploadPicName', '上传图片头像', 'fieldType'),
('postAttach', 'postAttachName', '上传附件', 'fieldType'),
('provincePicker', 'provincePickerName', '省份选择', 'fieldType'),
('monthPicker', 'monthPickerName', '月份选择', 'fieldType'),
('datePicker', 'datePickerName', '日期选择', 'fieldType'),
('label', 'labelName', '文本内容', 'fieldType' ),
('emptyLabel', 'emptylabelName', '空内容', 'fieldType' ),
('selectByStaticMethod', 'selectByStaticMethodName', '静态方法显示下拉菜单', 'fieldType'),
('checkboxByStaticMethod', 'checkboxByStaticMethodName', '静态方法显示单选按钮', 'fieldType'),
('singleSpecialSelect', 'SSSName', '单级特殊下拉菜单（外表）', 'fieldType');


DROP TABLE IF EXISTS `pa_form_field`;
CREATE TABLE IF NOT EXISTS `pa_form_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) NOT NULL,
  `fieldName` varchar(255) NOT NULL,
  `fieldNameCover` TEXT NOT NULL,
  `fieldName0` varchar(255) NOT NULL,
  `fieldNameCondition0` varchar(255) NOT NULL,
  `fieldNameCover0` TEXT  NOT NULL,
  `fieldName1` varchar(255) NOT NULL,
  `fieldNameCondition1` varchar(255) NOT NULL,
  `fieldNameCover1` TEXT  NOT NULL,
  `fieldName2` varchar(255) NOT NULL,
  `fieldNameCondition2` varchar(255) NOT NULL,
  `fieldNameCover2` TEXT  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;
INSERT INTO `pa_form_field` (`form_name`, `fieldName`, `fieldNameCover`, `fieldName0`, `fieldNameCondition0`, `fieldNameCover0`, `fieldName1`, `fieldNameCondition1`, `fieldNameCover1`, `fieldName2`, `fieldNameCondition2`, `fieldNameCover2`) VALUES
('newForm', 'textName', '{"name":"name","label":"表单类名","isMust":"必填","explain":"必填","groupName":"def"}', 0, '', '', 0, '', '', 0, '', ''),
('newForm', 'textName', '{"name":"label","label":"表单显示名","groupName":"abc"}', 0, '', '', 0, '', '', 0, '', ''),
('newForm', 'innerRadioName', '{"name":"isEdit","label":"是否可编辑","attr":"yes,no","groupName":"def"}', 0, '', '', 0, '', '', 0, '', ''),
('newForm', 'textareaName', '{"name":"groupName","label":"组名","groupName":"abc"}', 0, '', '', 0, '', '', 0, '', ''),
#(321, 'newField', 17, '{"name":"label","label":"文本内容"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'SAOSName', '{"name":"type","label":"字段类型"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'SOSName', '{"name":"form_name","label":"所属表单","tableModelName":"PaForm","key":"label"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'SSSName', '{"name":"groupName","label":"分组","tableModelName":"PaForm","key":"groupName"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"name","label":"所属表字段程序名","isMust":"必填"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"label","label":"所属表字段显示名","isMust":"必填"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"textType","label":"TEXT类型"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"defaultValue","label":"默认值"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'innerRadioName', '{"name":"category","label":"类别","attr":"basic,udf"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'innerRadioName', '{"name":"isMust","label":"是否必填","attr":"必填,非必填"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'innerRadioName', '{"name":"rules","label":"使用JS规则","attr":"电话,手机,邮箱,邮编,身份证,不使用"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textareaName', '{"name":"customCheck","label":"自定义JS验证"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textareaName', '{"name":"explain","label":"说明(字段的说明)"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textareaName', '{"name":"attr","label":"attr属性","explain":"属性以逗号隔开","attr":"必填,非必填"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"tableModelName","label":"model名称"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"key","label":"键名称"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"nameSpace","label":"多级分类使用命名空间"}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"name":"condition","label":"多级选择条件","explain":"条件为以冒号(:)分隔字符串"}', 0, '', '', 0, '', '', 0, '', ''),
('assist', 'innerRadioName', '{"type":"innerRadio","form_id":"17","name":"sqlData","label":"\\u6570\\u636e","textType":"","defaultValue":"crm","category":"basic","explain":"","attr":"crm,mini","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"username","label":"\\u7528\\u6237\\u540d","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'passwordName', '{"type":"password","form_id":"3","name":"password","label":"\\u5bc6\\u7801","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'uploadPicName', '{"type":"uploadPic","form_id":"3","name":"avatar","label":"\\u5934\\u50cf","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"name","label":"\\u59d3\\u540d","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"ename","label":"\\u82f1\\u6587\\u540d","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'innerRadioName', '{"type":"innerRadio","form_id":"3","name":"sex","label":"\\u6027\\u522b","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u7537,\\u5973","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'datePickerName', '{"type":"datePicker","form_id":"3","name":"birthday","label":"\\u751f\\u65e5","textType":"","defaultValue":"","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textareaName', '{"type":"textarea","form_id":"3","name":"hobby","label":"\\u7231\\u597d","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"mobilePhone","label":"\\u624b\\u673a","textType":"","defaultValue":"","category":"basic","rules":"\\u624b\\u673a","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"qq","label":"qq","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"msn","label":"msn","textType":"","defaultValue":"","category":"basic","rules":"\\u90ae\\u7bb1","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"skype","label":"skype","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'provincePickerName', '{"type":"provincePicker","form_id":"3","name":"hometown","label":"\\u7c4d\\u8d2f","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"idCard","label":"\\u8eab\\u4efd\\u8bc1\\u53f7\\u7801","textType":"","defaultValue":"","category":"basic","rules":"\\u8eab\\u4efd\\u8bc1","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'monthPickerName', '{"type":"monthPicker","form_id":"3","name":"entryDate","label":"\\u5165\\u804c\\u65f6\\u95f4","textType":"","defaultValue":"","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'SISName', '{"type":"SingleInnerSelect","form_id":"3","name":"educational","label":"\\u5b66\\u5386","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u9ad8\\u4e2d,\\u5927\\u4e13,\\u672c\\u79d1,\\u7855\\u58eb,\\u535a\\u58eb,\\u5176\\u4ed6","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"graduateSchool","label":"\\u6bd5\\u4e1a\\u5b66\\u6821","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'monthPickerName', '{"type":"monthPicker","form_id":"3","name":"graduationYear","label":"\\u6bd5\\u4e1a\\u65f6\\u95f4","textType":"","defaultValue":"","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"bank","label":"\\u5de5\\u8d44\\u5361\\u6240\\u5728\\u94f6\\u884c","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"bankCard","label":"\\u94f6\\u884c\\u5361\\u5e10\\u53f7","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"emcName","label":"\\u7d27\\u6025\\u8054\\u7cfb\\u4eba\\u59d3\\u540d","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"emcPhone","label":"\\u7d27\\u6025\\u8054\\u7cfb\\u4eba\\u8054\\u7cfb\\u65b9\\u5f0f","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'innerRadioName', '{"type":"innerRadio","form_id":"3","name":"hasPet","label":"\\u662f\\u5426\\u6709\\u5ba0\\u7269","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u662f,\\u5426","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"petType","label":"\\u5ba0\\u7269\\u7c7b\\u578b","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'SISName', '{"type":"SingleInnerSelect","form_id":"3","name":"nation","label":"\\u6c11\\u65cf","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u6c49\\u65cf,\\u8499\\u53e4\\u65cf,\\u5f5d\\u65cf,\\u4f97\\u65cf,\\u54c8\\u8428\\u514b\\u65cf,\\u7572\\u65cf,\\u7eb3\\u897f\\u65cf,\\u4eeb\\u4f6c\\u65cf,\\u4ee1\\u4f6c\\u65cf,\\u6012\\u65cf,\\u4fdd\\u5b89\\u65cf,\\u9102\\u4f26\\u6625\\u65cf,\\u56de\\u65cf,\\u58ee\\u65cf,\\u7476\\u65cf,\\u50a3\\u65cf,\\u9ad8\\u5c71\\u65cf,\\u666f\\u9887\\u65cf,\\u7f8c\\u65cf,\\u9521\\u4f2f\\u65cf,\\u4e4c\\u5b5c\\u522b\\u514b\\u65cf,\\u88d5\\u56fa\\u65cf,\\u8d6b\\u54f2\\u65cf,\\u85cf\\u65cf,\\u5e03\\u4f9d\\u65cf,\\u767d\\u65cf,\\u9ece\\u65cf,\\u62c9\\u795c\\u65cf,\\u67ef\\u5c14\\u514b\\u5b5c\\u65cf,\\u5e03\\u6717\\u65cf,\\u963f\\u660c\\u65cf,\\u4fc4\\u7f57\\u65af\\u65cf,\\u4eac\\u65cf,\\u95e8\\u5df4\\u65cf,\\u7ef4\\u543e\\u5c14\\u65cf,\\u671d\\u9c9c\\u65cf,\\u571f\\u5bb6\\u65cf,\\u5088\\u50f3\\u65cf,\\u6c34\\u65cf,\\u571f\\u65cf,\\u6492\\u62c9\\u65cf,\\u666e\\u7c73\\u65cf,\\u9102\\u6e29\\u514b\\u65cf,\\u5854\\u5854\\u5c14\\u65cf,\\u73de\\u5df4\\u65cf,\\u82d7\\u65cf,\\u6ee1\\u65cf,\\u54c8\\u5c3c\\u65cf,\\u4f64\\u65cf,\\u4e1c\\u4e61\\u65cf,\\u8fbe\\u65a1\\u5c14\\u65cf,\\u6bdb\\u5357\\u65cf,\\u5854\\u5409\\u514b\\u65cf,\\u5fb7\\u6602\\u65cf,\\u72ec\\u9f99\\u65cf,\\u57fa\\u8bfa\\u65cf","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'SISName', '{"type":"SingleInnerSelect","form_id":"3","name":"politics","label":"\\u653f\\u6cbb\\u9762\\u8c8c","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u65e0,\\u56e2\\u5458,\\u515a\\u5458,\\u5176\\u4ed6","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'innerRadioName', '{"type":"innerRadio","form_id":"3","name":"marital","label":"\\u5a5a\\u59fb\\u72b6\\u51b5","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u5df2\\u5a5a,\\u672a\\u5a5a","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('staff', 'textName', '{"type":"text","form_id":"3","name":"email","label":"\\u90ae\\u7bb1","textType":"","defaultValue":"","category":"basic","rules":"\\u90ae\\u7bb1","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('role', 'textName', '{"type":"text","form_id":"15","name":"roleDisplayName","label":"\\u89d2\\u8272\\uff08\\u6743\\u9650\\u7ec4\\uff09\\u663e\\u793a\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('role', 'textName', '{"type":"text","form_id":"15","name":"roleSystemName","label":"\\u89d2\\u8272\\uff08\\u6743\\u9650\\u7ec4\\uff09\\u7cfb\\u7edf\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('role', 'textareaName', '{"type":"textarea","form_id":"15","name":"roleDescription","label":"\\u89d2\\u8272\\uff08\\u6743\\u9650\\u7ec4\\uff09\\u8bf4\\u660e","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'SISName', '{"type":"SingleInnerSelect","form_id":"1","name":"trade","label":"\\u884c\\u4e1a","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"name","label":"\\u5ba2\\u6237\\u5168\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"starLevel","label":"\\u5ba2\\u6237\\u7b49\\u7ea7","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"simpleName","label":"\\u5ba2\\u6237\\u7b80\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"companySize","label":"\\u5ba2\\u6237\\u89c4\\u6a21","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"majorProduct","label":"\\u4e3b\\u8981\\u4ea7\\u54c1","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"address","label":"\\u5730\\u5740","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"phone","label":"\\u603b\\u673a","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u7535\\u8bdd","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"email","label":"\\u7535\\u5b50\\u90ae\\u4ef6","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u90ae\\u7bb1","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"fax","label":"\\u4f20\\u771f","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'postAttachName', '{"type":"postAttach","form_id":"1","name":"postAttach","label":"\\u5ba2\\u6237\\u9644\\u4ef6","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"webSite","label":"\\u7f51\\u5740","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"1","name":"sales_id","label":"\\u9500\\u552e","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textareaName', '{"type":"textarea","form_id":"1","name":"introduction","label":"\\u5ba2\\u6237\\u7b80\\u4ecb","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"Staff","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"founder","label":"\\u521b\\u59cb\\u4eba","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"Staff","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textName', '{"type":"text","form_id":"1","name":"createTime","label":"\\u521b\\u59cb\\u65f6\\u95f4","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"Staff","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('client', 'textareaName', '{"type":"textarea","form_id":"1","name":"clientSource","label":"\\u5ba2\\u6237\\u6765\\u6e90","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u730e\\u5934,IT,\\u623f\\u5730\\u4ea7","tableModelName":"Staff","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"contact","name":"client_id","label":"\\u5ba2\\u6237","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"name","label":"\\u8054\\u7cfb\\u4eba\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"ename","label":"\\u8054\\u7cfb\\u4eba\\u82f1\\u6587\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"department","label":"\\u90e8\\u95e8","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"position","label":"\\u804c\\u4f4d","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"mobilePhone","label":"\\u624b\\u673a","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u624b\\u673a","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"phone","label":"\\u56fa\\u5b9a\\u7535\\u8bdd","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u7535\\u8bdd","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"email","label":"\\u90ae\\u7bb1","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u90ae\\u7bb1","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"personalEmail","label":"\\u4e2a\\u4eba\\u90ae\\u7bb1","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u90ae\\u7bb1","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'datePickerName', '{"type":"datePicker","form_id":"contact","name":"birthday","label":"\\u51fa\\u751f\\u65e5\\u671f","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u90ae\\u7bb1","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'SISName', '{"type":"SingleInnerSelect","form_id":"contact","name":"educational","label":"\\u5b66\\u5386","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u90ae\\u7bb1","explain":"","attr":"\\u9ad8\\u4e2d,\\u5927\\u4e13,\\u672c\\u79d1,\\u7855\\u58eb,\\u535a\\u58eb,\\u5176\\u4ed6","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"workingYears","label":"\\u5de5\\u4f5c\\u5e74\\u9650","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u9ad8\\u4e2d,\\u5927\\u4e13,\\u672c\\u79d1,\\u7855\\u58eb,\\u535a\\u58eb,\\u5176\\u4ed6","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'innerRadioName', '{"type":"innerRadio","form_id":"contact","name":"gender","label":"\\u6027\\u522b","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"qq","label":"QQ","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"msn","label":"MSN","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"skype","label":"SKYPE","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"address","label":"\\u5730\\u5740","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textareaName', '{"type":"textarea","form_id":"contact","name":"remark","label":"\\u5907\\u6ce8","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"contact","name":"sales_id","label":"\\u9500\\u552e","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"weiBo","label":"\\u65b0\\u6d6a\\u5fae\\u535a","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('contact', 'textName', '{"type":"text","form_id":"contact","name":"tQq","label":"\\u817e\\u8baf\\u5fae\\u535a","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"\\u7537,\\u5973","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"7","name":"lecturer_id","label":"\\u8bb2\\u5e08","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"TrainCourse","key":"courseName","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"7","name":"contact_id","label":"\\u8054\\u7cfb\\u4eba","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"Contact","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"7","name":"followCourseId","label":"\\u8ddf\\u8bfe\\u4eba","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'textName', '{"type":"text","form_id":"7","name":"courseName","label":"\\u8bfe\\u7a0b\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'textName', '{"type":"text","form_id":"7","name":"courseAddress","label":"\\u8bfe\\u7a0b\\u5730\\u5740","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'datePickerName', '{"type":"datePicker","form_id":"7","name":"courseTime","label":"\\u5f00\\u8bfe\\u65f6\\u95f4","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'textName', '{"type":"text","form_id":"7","name":"contactPhone","label":"\\u8054\\u7cfb\\u4eba\\u7535\\u8bdd","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u7535\\u8bdd","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'postAttachName', '{"type":"postAttach","form_id":"7","name":"courseIntroduction","label":"\\u8bfe\\u7a0b\\u5927\\u7eb2","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'postAttachName', '{"type":"postAttach","form_id":"7","name":"courseHandOuts","label":"\\u8bfe\\u7a0b\\u8bb2\\u4e49","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('course', 'textName', '{"type":"text","form_id":"7","name":"courseVideo","label":"\\u8bfe\\u7a0b\\u89c6\\u9891","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('trainee', 'textName', '{"type":"text","form_id":"9","name":"traineeName","label":"\\u5b66\\u5458\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('trainee', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"9","name":"client_id","label":"\\u5ba2\\u6237","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('trainee', 'textName', '{"type":"text","form_id":"9","name":"department","label":"\\u90e8\\u95e8","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('trainee', 'textName', '{"type":"text","form_id":"9","name":"position","label":"\\u804c\\u4f4d","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('trainee', 'textName', '{"type":"text","form_id":"9","name":"workingYears","label":"\\u5de5\\u4f5c\\u5e74\\u9650","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('trainee', 'textName', '{"type":"text","form_id":"9","name":"serviceYears","label":"\\u670d\\u52a1\\u5e74\\u9650","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('trainee', 'textareaName', '{"type":"textarea","form_id":"9","name":"remark","label":"\\u5907\\u6ce8","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'textName', '{"type":"text","form_id":"8","name":"lecturerName","label":"\\u8bb2\\u5e08\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'uploadPicName', '{"type":"uploadPic","form_id":"8","name":"avatar","label":"\\u7167\\u7247","textType":"","defaultValue":"","category":"basic","isMust":"\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'textName', '{"type":"text","form_id":"8","name":"introduction","label":"\\u7b80\\u4ecb","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'textareaName', '{"type":"textarea","form_id":"8","name":"specialty","label":"\\u4e13\\u957f","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'textName', '{"type":"text","form_id":"8","name":"mobilePhone","label":"\\u624b\\u673a","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u624b\\u673a","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'textName', '{"type":"text","form_id":"8","name":"email","label":"\\u90ae\\u7bb1","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u90ae\\u7bb1","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'textName', '{"type":"text","form_id":"8","name":"qq","label":"Qq","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('lecturer', 'textName', '{"type":"text","form_id":"8","name":"msn","label":"Msn","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('task', 0, '', 'labelName', '{"index":"0","module":"\\/index.php","controller":"client","action":"addTask","parameter":"clientId"}', '{"type":"label","form_id":"11","name":"client_id","label":"\\u5ba2\\u6237\\u540d\\u79f0","textType":"","defaultValue":"","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', ''),
('task', 0, '', 'SOSName', '{"index":"0","module":"\\/index.php","controller":"contact","action":"addTask","parameter":"contactId"}', '{"type":"SingleOutsideSelect","form_id":"11","name":"client_id","label":"\\u5ba2\\u6237\\u540d\\u79f0","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"Client","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', ''),
('task', 0, '', 'labelName', '{"index":"0","module":"\\/index.php","controller":"contact","action":"addTask","parameter":"contactId"}', '{"type":"label","form_id":"11","name":"contact_id","label":"\\u8054\\u7cfb\\u4eba","textType":"","defaultValue":"","explain":"","attr":"","tableModelName":"Contact","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', ''),
('task', 0, '', 'SOSName', '{"index":"0","module":"\\/index.php","controller":"client","action":"addTask","parameter":"clientId"}', '{"type":"SingleOutsideSelect","form_id":"11","name":"contact_id","label":"\\u8054\\u7cfb\\u4eba","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"Contact","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', ''),
('task', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"11","name":"project_id","label":"\\u9879\\u76ee","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"TrainCourse","key":"courseName","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('task', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"11","name":"contact_id","label":"\\u8054\\u7cfb\\u4eba","textType":"","defaultValue":"","category":"basic","explain":"","attr":"","tableModelName":"Contact","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('task', 'SISName', '{"type":"SingleInnerSelect","form_id":"11","name":"contactType","label":"\\u8054\\u7cfb\\u7c7b\\u578b","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u6253\\u7535\\u8bdd,\\u53d1\\u90ae\\u4ef6,\\u9700\\u6c42\\u8ba8\\u8bba,\\u62dc\\u8bbf,\\u975e\\u6b63\\u5f0f\\u4f1a\\u8c08,\\u5546\\u52a1\\u8c08\\u5224,\\u5efa\\u8bae\\u4e66,\\u8d77\\u8349\\u5408\\u540c","tableModelName":"Contact","key":"name","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('task', 'SOSName', '{"type":"SingleOutsideSelect","form_id":"11","name":"staff_id","label":"\\u8d1f\\u8d23\\u5458\\u5de5","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u6253\\u7535\\u8bdd,\\u53d1\\u90ae\\u4ef6,\\u9700\\u6c42\\u8ba8\\u8bba,\\u62dc\\u8bbf,\\u975e\\u6b63\\u5f0f\\u4f1a\\u8c08,\\u5546\\u52a1\\u8c08\\u5224,\\u5efa\\u8bae\\u4e66,\\u8d77\\u8349\\u5408\\u540c","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('task', 'SISName', '{"type":"SingleInnerSelect","form_id":"11","name":"taskState","label":"\\u4efb\\u52a1\\u72b6\\u6001","textType":"","defaultValue":"","category":"basic","explain":"","attr":"\\u672a\\u5f00\\u59cb,\\u8fdb\\u884c\\u4e2d,\\u5df2\\u5b8c\\u6210","tableModelName":"Staff","key":"username","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('coreTable', 'textareaName', '{"type":"textarea","form_id":"18","name":"sql","label":"SQL","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('coreTable', 'emptylabelName', '{"type":"emptyLabel","form_id":"18","name":"test","label":"test","textType":"","defaultValue":"","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('coreTable', 'textName', '{"type":"text","form_id":"18","name":"name","label":"Table\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('coreTable', 'textName', '{"type":"text","form_id":"18","name":"label","label":"Table\\u6807\\u9898","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('coreTable', 'textName', '{"type":"text","form_id":"18","name":"numPerPage","label":"\\u6bcf\\u9875\\u663e\\u793a\\u6761\\u76ee\\u6570","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('newField', 'textName', '{"type":"text","form_id":"5","name":"orderId","label":"\\u6392\\u5e8f","textType":"","defaultValue":"","category":"basic","isMust":"\\u975e\\u5fc5\\u586b","rules":"\\u4e0d\\u4f7f\\u7528","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":""}', 0, '', '', 0, '', '', 0, '', ''),
('position', 'textName', '{"type":"text","form_name":"position","name":"name","label":"\\u7cfb\\u7edf\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('position', 'textName', '{"type":"text","form_name":"position","name":"displayName","label":"\\u663e\\u793a\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('department', 'textName', '{"type":"text","form_name":"department","name":"name","label":"\\u90e8\\u95e8\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('department', 'selectByStaticMethodName', '{"type":"selectByStaticMethod","form_name":"department","name":"fatherId","label":"\\u4e0a\\u7ea7\\u90e8\\u95e8","textType":"DepartmentHelper::getDepartmentsForSelect","defaultValue":"","isMust":"\\u975e\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('department', 'textName', '{"type":"text","form_name":"department","name":"displayName","label":"\\u90e8\\u95e8\\u663e\\u793a\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('department', 'textName', '{"type":"text","form_name":"department","name":"order","label":"\\u6392\\u5e8f","textType":"","defaultValue":"","isMust":"\\u975e\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('department', 'checkboxByStaticMethodName', '{"type":"checkboxByStaticMethod","form_name":"department","name":"departmentPosition","label":"\\u90e8\\u95e8\\u804c\\u4f4d","textType":"DepartmentHelper::getPositionForCheckbox","defaultValue":"","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('coTask', 'textName', '{"type":"text","form_name":"coTask","name":"name","label":"\\u7cfb\\u7edf\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('coTask', 'textName', '{"type":"text","form_name":"coTask","name":"displayName","label":"\\u663e\\u793a\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('coTask', 'textareaName', '{"type":"textarea","form_name":"coTask","name":"description","label":"\\u63cf\\u8ff0\\u4fe1\\u606f","textType":"","defaultValue":"","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('coRole', 'textName', '{"type":"text","form_name":"coRole","name":"name","label":"\\u7cfb\\u7edf\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('coRole', 'textName', '{"type":"text","form_name":"coRole","name":"displayName","label":"\\u663e\\u793a\\u540d\\u79f0","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('coRole', 'textareaName', '{"type":"textarea","form_name":"coRole","name":"description","label":"\\u63cf\\u8ff0\\u4fe1\\u606f","textType":"","defaultValue":"","isMust":"\\u5fc5\\u586b","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', ''),
('coRole', 'checkboxByStaticMethodName', '{"type":"checkboxByStaticMethod","form_name":"coRole","name":"roleTask","label":"\\u89d2\\u8272\\u62e5\\u6709\\u7684\\u6743\\u9650","textType":"CoRoleHelper::getTaskForCheckbox","defaultValue":"","explain":"","attr":"","tableModelName":"","key":"","nameSpace":"","condition":"","orderId":""}', 0, '', '', '', '', '', '', '', '');


DROP TABLE IF EXISTS `pa_category`;
CREATE TABLE IF NOT EXISTS `pa_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `nameSpace` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `sequence` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `pa_category` ( `nameSpace`, `name`, `key`, `value`) VALUES
('FormField', 'type', 'text', '文本框'),
('FormField', 'type', 'textarea', '文本域'),
('FormField', 'type', 'singleInnerSelect', '单级下拉菜单(attr)'),
('FormField', 'type', 'singleOutsideSelect', '单级下拉菜单(外表)'),
('FormField', 'type', 'singleAndCanAddOptionSelect', '动态添加选项'),
('FormField', 'type', 'multipleOutsideSelect', '多级下拉菜单'),
('FormField', 'type', 'innerRadio', '单选(attr)'),
('FormField', 'type', 'outsideRadio', '单选项(外表)'),
('FormField', 'type', 'innerCheckbox', '多选框(attr)'),
('FormField', 'type', 'outsideCheckbox', '多选框(外表)'),
('FormField', 'type', 'password', '密码框'),
('FormField', 'type', 'uploadPic', '上传图片'),
('FormField', 'type', 'postAttach', '上传附件'),
('FormField', 'type', 'provincePicker', '省份选择'),
('FormField', 'type', 'monthPicker', '月份选择'),
('FormField', 'type', 'datePicker', '日期选择'),
('FormField', 'type', 'label', '文本内容'),
('FormField', 'type', 'emptyLabel', '空内容'),
('FormField', 'type', 'selectByStaticMethod', '静态方法显示下拉菜单'),
('FormField', 'type', 'checkboxByStaticMethod', '静态方法显示多选按钮'),
('FormField', 'type', 'singleSpecialSelect', '特殊下拉菜单');
INSERT INTO `pa_category` ( `user_id`, `nameSpace`, `name`, `key`, `value`) VALUES
( 1, 'file', 'setting', 'fileSize', '10'),
( 1, 'file', 'setting', 'fileType', 'txt,docx,doc,png,jpg,xlsx');


DROP TABLE IF EXISTS `pa_multiple_level_category`;
CREATE TABLE IF NOT EXISTS `pa_multiple_level_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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


DROP TABLE IF EXISTS `pa_table`;
CREATE TABLE IF NOT EXISTS `pa_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `numPerPage` int(10) NOT NULL,
  `sql` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;
INSERT INTO `pa_table` (`name`, `label`, `numPerPage`, `sql`) VALUES
('test', '测试显示table中的数据', 50, 'SELECT * FROM pa_form'),
('tableList', '所有表格列表', 50, 'SELECT * FROM pa_table'),
('position', '职位列表', 50, 'SELECT * FROM co_position'),
('department', '部门列表', 50, 'SELECT id, displayName, name, `order`, fatherId, departmentPosition FROM co_department'),
('coTask', '权限列表', 50, 'SELECT * FROM co_task'),
('coRole', '角色列表', 50, 'SELECT r.id id, r.name name, r.displayName displayName, r.description description, GROUP_CONCAT(t.displayName) taskName FROM co_role r LEFT JOIN co_role_task rt ON (r.name = rt.role_name) LEFT JOIN co_task t ON (rt.task_name = t.name) GROUP BY r.name'),
('newFormTable', 'form表单', 50, 'select * from pa_form'),
('newFieldTable', 'field列表', 50, 'select * from pa_field'),
('formFieldTable', 'formField列表', 50, 'select * from pa_form_field WHERE form_name = "{form_name}"'),
('formTable', 'form列表', 50, 'select * from pa_form'),
('clientTable', '客户列表', 50, 'select *,0,0 from fu_crm_client'),
('contactTable', '联系人列表', 50, 'select *,0 from fu_crm_contact'),
('courseTable', '课程列表', 50, 'select * from in_tra_course'),
('traineeTable', '学员列表', 50, 'select * from in_tra_trainee'),
('lecturerTable', '讲师列表', 50, 'select * from in_tra_lecturer'),
('staffTable', '员工列表', 50, 'select * from co_staff');


DROP TABLE IF EXISTS `pa_table_item`;
CREATE TABLE IF NOT EXISTS `pa_table_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemDisplayMethod` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `itemOrder` varchar(255) NOT NULL,
  `enable` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `pa_table_item` (`table_name`, `title`, `itemName`, `itemDisplayMethod`, `html`, `itemOrder`, `enable`) VALUES
('test', '', 'id', 'TableDisplay::display', '', 'true', 1),
('test', '', 'name', 'TableDisplay::display', '', 'true', 1),
('test', '', 'label', 'TableDisplay::display', '', 'false', 1),
('test', '', 'isEdit', 'TableDisplay::display', '', 'true', 1),
('test', '操作', 'operater', '', '<a href="/admin.php/tableSet/tableIndex?name={name}">编辑</a>', '', 0),
('tableList', '', 'id', 'TableDisplay::display', '', 'true', 0),
('tableList', 'Table名称', 'name', 'TableDisplay::display', '', 'true', 1),
('tableList', '显示名称', 'label', 'TableDisplay::display', '', 'true', 1),
('tableList', '每页显示行数', 'numPerPage', 'TableDisplay::display', '', 'true', 1),
('tableList', '查询语句', 'sql', 'TableDisplay::display', '', 'true', 1),
('tableList', '操作', 'operater', '', '<a href="/admin.php/tableSet/tableIndex?name={name}">编辑</a>', '', 1),
('formFieldTable', '', 'id', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'form_name', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_name', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_id_cover', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_name0', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_id_condition0', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_id_cover0', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_name1', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_id_condition1', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_id_cover1', 'TableDisplay::display', '', 'true', 1),
('formFieldTable', '', 'field_name2', 'TableDisplay::display', '', 'true', 0),
('formFieldTable', '', 'field_id_condition2', 'TableDisplay::display', '', 'true', 0),
('formFieldTable', '', 'field_id_cover2', 'TableDisplay::display', '', 'true', 0),
('formFieldTable', '操作', 'operater', '', '<a href="/admin.php/customForm/index?name={name}">编辑</a>|<a href="/admin.php/customForm/index?name={name}">删除</a>', '', 1),
('clientTable', 'Id号', 'id', 'TableDisplay::display', '', 'true', 1),
('clientTable', '负责员工', 'staff_id', 'TableDisplay::display', '', 'true', 1),
('clientTable', '联系记录', 'task_id', 'TableDisplay::display', '', 'true', 1),
('clientTable', '销售名称', 'sales_id', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户名称', 'name', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户等级', 'starLevel', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户简称', 'simpleName', 'TableDisplay::display', '', 'true', 1),
('clientTable', '行业', 'trade', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户规模', 'companySize', 'TableDisplay::display', '', 'true', 1),
('clientTable', '主要产品', 'majorProduct', 'TableDisplay::display', '', 'true', 1),
('clientTable', '地址', 'address', 'TableDisplay::display', '', 'true', 1),
('clientTable', '总机', 'phone', 'TableDisplay::display', '', 'true', 1),
('clientTable', '传真', 'fax', 'TableDisplay::display', '', 'true', 1),
('clientTable', '网址', 'webSite', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户简介', 'introduction', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户附件', 'companyAttach', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户邮箱', 'email', 'TableDisplay::display', '', 'true', 1),
('clientTable', '创始人', 'founder', 'TableDisplay::display', '', 'true', 1),
('clientTable', '创始时间', 'createTime', 'TableDisplay::display', '', 'true', 1),
('clientTable', '客户来源', 'clientSource', 'TableDisplay::display', '', 'true', 1),
('clientTable', '日期', 'date', 'TableDisplay::display', '', 'true', 1),
('clientTable', '联系记录', '0', 'TableDisplay::displayTaskName', '', 'true', 1),
('clientTable', '联系人', '0', 'TableDisplay::display', '', 'true', 1),
('clientTable', '操作', 'operater', '', '<a href="/index.php/client/editClient?clientId={id}">编辑</a>|<a href="/index.php/deleteClient/deleteClient?clientId={id}">删除</a>', '', 1),
('formTable', 'Id号', 'id', 'TableDisplay::displayFormToField', '', 'true', 1),
('formTable', '名称', 'name', 'TableDisplay::display', '', 'true', 1),
('formTable', '显示名称', 'label', 'TableDisplay::display', '', 'false', 1),
('formTable', '是否可编辑', 'isEdit', 'TableDisplay::display', '', 'true', 1),
('formTable', '操作', 'operater', '', '<a href="/admin.php/customForm/paFormEdit?name={name}">编辑</a>|<a href="/admin.php/customForm/deleteForm?name={name}">删除</a>', '', 1),
('newFieldTable', 'id号', 'id', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'form_id', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'orderId', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'defaultValue', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'type', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'nameSpace', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'name', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'attr', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'category', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'label', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'isMust', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '', 'explain', 'TableDisplay::display', '', 'true', 1),
('newFieldTable', '操作', 'operater', '', '<a href="/admin.php/customForm/paFieldEdit?name={name}">编辑</a>|<a href="/admin.php/customForm/index?name={name}">删除</a>', '', 1),
('contactTable', 'Id号', 'id', 'TableDisplay::display', '', 'false', 1),
('contactTable', '负责员工', 'staff_id', 'TableDisplay::display', '', 'false', 1),
('contactTable', '客户名称', 'client_id', 'TableDisplay::display', '', 'false', 1),
('contactTable', '销售名称', 'sales_id', 'TableDisplay::display', '', 'false', 1),
('contactTable', '联系人', 'name', 'TableDisplay::display', '', 'false', 1),
('contactTable', '英文名称', 'ename', 'TableDisplay::display', '', 'false', 1),
('contactTable', '部门', 'department', 'TableDisplay::display', '', 'false', 1),
('contactTable', '职位', 'position', 'TableDisplay::display', '', 'false', 1),
('contactTable', '手机', 'mobilePhone', 'TableDisplay::display', '', 'false', 1),
('contactTable', '固定电话', 'phone', 'TableDisplay::display', '', 'false', 1),
('contactTable', '邮箱', 'email', 'TableDisplay::display', '', 'false', 1),
('contactTable', '个人邮箱', 'personalEmail', 'TableDisplay::display', '', 'false', 1),
('contactTable', '出生日期', 'birthday', 'TableDisplay::display', '', 'false', 1),
('contactTable', '学历', 'educational', 'TableDisplay::display', '', 'false', 1),
('contactTable', '工作年限', 'workingYears', 'TableDisplay::display', '', 'false', 1),
('contactTable', '性别', 'gender', 'TableDisplay::display', '', 'false', 1),
('contactTable', 'QQ号码', 'qq', 'TableDisplay::display', '', 'false', 1),
('contactTable', 'MSN号码', 'msn', 'TableDisplay::display', '', 'false', 1),
('contactTable', 'SKYPE号码', 'skype', 'TableDisplay::display', '', 'false', 1),
('contactTable', '地址', 'address', 'TableDisplay::display', '', 'false', 1),
('contactTable', '新浪微博', 'weiBo', 'TableDisplay::display', '', 'false', 1),
('contactTable', '腾讯微博', 'tQq', 'TableDisplay::display', '', 'false', 1),
('contactTable', '备注', 'remark', 'TableDisplay::display', '', 'false', 1),
('contactTable', '日期', 'date', 'TableDisplay::display', '', 'false', 1),
('contactTable', '联系记录', '0', 'TableDisplay::display', '', 'false', 1),
('contactTable', '操作', 'operater', '', '<a href="/index.php/contact/editContact?contactId={id}">编辑</a>|<a href="/index.php/contact/deleteContact?contactId={id}">删除</a>', '', 1),
('courseTable', 'Id号', 'id', 'TableDisplay::displayCourseToBrowse', '', 'false', 1),
('courseTable', '讲师', 'lecturer_id', 'TableDisplay::display', '', 'false', 1),
('courseTable', '联系人名称', 'contact_id', 'TableDisplay::display', '', 'false', 1),
('courseTable', '跟客人', 'followCourseId', 'TableDisplay::display', '', 'false', 1),
('courseTable', '课程名称', 'courseName', 'TableDisplay::display', '', 'false', 1),
('courseTable', '讲课地址', 'courseAddress', 'TableDisplay::display', '', 'false', 1),
('courseTable', '开课时间', 'courseTime', 'TableDisplay::display', '', 'false', 1),
('courseTable', '客户联系电话', 'contactPhone', 'TableDisplay::display', '', 'false', 1),
('courseTable', '课程大纲', 'courseIntroduction', 'TableDisplay::display', '', 'false', 1),
('courseTable', '课程讲义', 'courseHandOuts', 'TableDisplay::display', '', 'false', 1),
('courseTable', '课程视频', 'courseVideo', 'TableDisplay::display', '', 'false', 1),
('courseTable', '操作', 'operater', '', '<a href="./index?name={courseName}">编辑</a>', '', 1),
('traineeTable', 'Id号码', 'id', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '客户名称', 'client_id', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '问题名称', 'questionnaire_id', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '学员名称', 'traineeName', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '部门', 'department', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '职位', 'position', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '工作年限', 'workingYears', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '服务年限', 'serviceYears', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '备注', 'remark', 'TableDisplay::display', '', 'false', 1),
('traineeTable', '操作', 'operater', '', '<a href="./index?name={traineeName}">编辑</a>', '', 1),
('lecturerTable', 'Id号', 'id', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', '讲师名称', 'lecturerName', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', '头像', 'avatar', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', '简介', 'introduction', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', '特长', 'specialty', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', '手机', 'mobilePhone', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', '邮箱', 'email', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', 'QQ号码', 'qq', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', 'MSN号码', 'Msn', 'TableDisplay::display', '', 'false', 1),
('lecturerTable', '操作', 'operater', '', '<a href="./index?name={lecturerName}">编辑</a>', '', 1),
('position', '', 'id', 'TableDisplay::display', '', 'true', 0),
('position', '系统名称', 'name', 'TableDisplay::display', '', 'true', 1),
('position', '显示名称', 'displayName', 'TableDisplay::display', '', 'true', 1),
('position', '操作', 'operater', '', '<a href="/admin.php/organization/positionMaker?name={name}">编辑</a>', '', 1),
('department', '', 'id', 'TableDisplay::display', '', 'false', 0),
('department', '显示名称', 'displayName', 'TableDisplay::displayDepartmentName', '', 'false', 1),
('department', '系统名称', 'name', 'TableDisplay::display', '', 'false', 1),
('department', '排序', 'order', 'TableDisplay::display', '', 'false', 1),
('department', '上级部门', 'fatherId', 'TableDisplay::display', '', 'false', 0),
('department', '该部门下属职位', 'departmentPosition', 'TableDisplay::display', '', 'false', 1),
('department', '操作', 'operater', '', '<a href="/admin.php/organization/departmentMaker?name={name}">编辑</a>', '', 1),
('coTask', '', 'id', 'TableDisplay::display', '', 'false', 0),
('coTask', '系统名称', 'name', 'TableDisplay::display', '', 'false', 1),
('coTask', '显示名称', 'displayName', 'TableDisplay::display', '', 'false', 1),
('coTask', '描述信息', 'description', 'TableDisplay::display', '', 'false', 1),
('coTask', '操作', 'operater', '', '<a href="/admin.php/authority/taskMaker?name={name}">编辑</a>', '', 1),
('coRole', '', 'id', 'TableDisplay::display', '', 'false', 0),
('coRole', '系统名称', 'name', 'TableDisplay::display', '', 'false', 1),
('coRole', '显示名称', 'displayName', 'TableDisplay::display', '', 'false', 1),
('coRole', '描述信息', 'description', 'TableDisplay::display', '', 'false', 1),
('coRole', '拥有权限', 'taskName', 'TableDisplay::display', '', 'false', 1),
('coRole', '操作', 'operater', '', '<a href="/admin.php/authority/roleMaker?name={name}">编辑</a>', '', 1),
('staffTable', '序列号', 'id', 'TableDisplay::display', '', 'false', 1),
('staffTable', '用户名称', 'username', 'TableDisplay::display', '', 'false', 1),
('staffTable', '密码', 'password', 'TableDisplay::display', '', 'false', 1),
('staffTable', '头像', 'avatar', 'TableDisplay::display', '', 'false', 1),
('staffTable', '姓名', 'name', 'TableDisplay::display', '', 'false', 1),
('staffTable', '英文名', 'ename', 'TableDisplay::display', '', 'false', 1),
('staffTable', '性别', 'sex', 'TableDisplay::display', '', 'false', 1),
('staffTable', '生日', 'birthday', 'TableDisplay::display', '', 'false', 1),
('staffTable', '爱好', 'hobby', 'TableDisplay::display', '', 'false', 1),
('staffTable', '手机', 'mobilePhone', 'TableDisplay::display', '', 'false', 1),
('staffTable', 'QQ号码', 'qq', 'TableDisplay::display', '', 'false', 1),
('staffTable', 'MSN号码', 'msn', 'TableDisplay::display', '', 'false', 1),
('staffTable', 'SKYPE号码', 'skype', 'TableDisplay::display', '', 'false', 1),
('staffTable', '家乡', 'hometown', 'TableDisplay::display', '', 'false', 1),
('staffTable', '身份证', 'idCard', 'TableDisplay::display', '', 'false', 1),
('staffTable', '加入时间', 'entryDate', 'TableDisplay::display', '', 'false', 1),
('staffTable', '学历', 'educational', 'TableDisplay::display', '', 'false', 1),
('staffTable', '毕业学校', 'graduateSchool', 'TableDisplay::display', '', 'false', 1),
('staffTable', '毕业年限', 'graduationYear', 'TableDisplay::display', '', 'false', 1),
('staffTable', '银行', 'bank', 'TableDisplay::display', '', 'false', 1),
('staffTable', '银行卡号', 'bankCard', 'TableDisplay::display', '', 'false', 1),
('staffTable', 'Emc名称', 'emcName', 'TableDisplay::display', '', 'false', 1),
('staffTable', 'Emc手机', 'emcPhone', 'TableDisplay::display', '', 'false', 1),
('staffTable', '宠物', 'hasPet', 'TableDisplay::display', '', 'false', 1),
('staffTable', '宠物类型', 'petType', 'TableDisplay::display', '', 'false', 1),
('staffTable', '国籍', 'nation', 'TableDisplay::display', '', 'false', 1),
('staffTable', '婚否', 'marital', 'TableDisplay::display', '', 'false', 1),
('staffTable', '邮箱', 'email', 'TableDisplay::display', '', 'false', 1),
('staffTable', '日历主题', 'calendarTheme', 'TableDisplay::display', '', 'false', 1),
('staffTable', '政党', 'politics', 'TableDisplay::display', '', 'false', 1),
('staffTable', '操作', 'operater', '', '<a href="/admin.php/staff/updatestaff?staff={id}">编辑</a>', '', 1);


DROP TABLE IF EXISTS `fu_crm_table`;
CREATE TABLE IF NOT EXISTS `fu_crm_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `tableName` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `selectedField` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;
INSERT INTO `fu_crm_table` (`id`, `staff_id`, `tableName`, `selectedField`) VALUES
(1, 1, 'Client-grid', 'trade,name,phone,email'),
(2, 1, 'staff-grid', 'username,ename,name,phone,sex'),
(3, 1, 'contact-grid', 'name');
INSERT INTO `fu_crm_table` (`staff_id`, `tableName`, `selectedField`) VALUES
( 1, 'task-grid', 'taskSystemName');


DROP TABLE IF EXISTS `fu_crm_client`;
CREATE TABLE IF NOT EXISTS `fu_crm_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `starLevel` varchar(255) NOT NULL,
  `simpleName` varchar(255) NOT NULL,
  `trade` varchar(255) DEFAULT NULL,
  `companySize` varchar(255) NOT NULL,
  `majorProduct` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax` int(11) NOT NULL,
  `webSite` int(11) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `companyAttach` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `founder` varchar(255) DEFAULT NULL,
  `createTime` varchar(255) DEFAULT NULL,
  `clientSource` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
INSERT INTO `fu_crm_client` (`id`, `staff_id`, `task_id`, `sales_id`, `name`, `starLevel`, `simpleName`, `trade`, `companySize`, `majorProduct`, `address`, `phone`, `fax`, `webSite`, `introduction`, `companyAttach`, `email`, `date`) VALUES
(1, 1, 1, 0, 'test', '', '', NULL, '', '', NULL, NULL, 0, 0, '', '', NULL, '');


DROP TABLE IF EXISTS `fu_crm_udf`;
CREATE TABLE IF NOT EXISTS `fu_crm_udf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formPrimaryIndex` int(11) NOT NULL,
  `distinguishForm` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `name` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `value` mediumtext COLLATE utf8_general_ci 	 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `fu_crm_field_group`;
CREATE TABLE IF NOT EXISTS `fu_crm_field_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `nameSpace` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;
INSERT INTO `fu_crm_field_group` (`id`, `groupName`, `nameSpace`) VALUES
(1, 'basic', 'client'),
(2, 'basic', 'staff'),
(3, 'basic', 'customForm');
INSERT INTO `fu_crm_field_group` (`groupName`, `nameSpace`) VALUES
( 'basic', 'task'),
( 'basic', 'role'),
( 'basic', 'title'),
( 'basic', 'property'),
( 'basic', 'setting'),
( 'basic', 'file');


DROP TABLE IF EXISTS `fu_crm_contact`;
CREATE TABLE IF NOT EXISTS `fu_crm_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ename` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `mobilePhone` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `personalEmail` varchar(255) NOT NULL,
  `birthday` varchar(255) NOT NULL,
  `educational` varchar(255) NOT NULL,
  `workingYears` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `qq` varchar(255) NOT NULL,
  `msn` varchar(255) NOT NULL,
  `skype` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `weiBo` varchar(255) NOT NULL,
  `tQq` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
INSERT INTO `fu_crm_contact` (`id`, `staff_id`, `client_id`, `sales_id`, `name`, `ename`, `department`, `position`, `mobilePhone`, `phone`, `email`, `birthday`, `educational`, `workingYears`, `gender`, `qq`, `msn`, `skype`, `address`, `remark`, `date`) VALUES
(1, 1, 1, 0, 'test', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '');


DROP TABLE IF EXISTS `fu_crm_client_history`;
CREATE TABLE IF NOT EXISTS `fu_crm_client_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `diff` text COLLATE utf8_general_ci 	 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;
INSERT INTO `fu_crm_client_history` (`id`, `staff_id`, `client_id`, `task_id`, `type`, `diff`, `date`) VALUES
(1, 1, 1, 0, 'create', '{"name":"test","phone":"1234567","trade":"\\u730e\\u5934","address":"","email":"test@qq.com"}', '');


DROP TABLE IF EXISTS `fu_crm_client_log`;
CREATE TABLE IF NOT EXISTS `fu_crm_client_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `recentInfo` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `type` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;
INSERT INTO `fu_crm_client_log` (`id`, `client_id`, `recentInfo`, `type`, `date`) VALUES
(1, 1, '{"trade":"\\u730e\\u5934","name":"test","starLevel":"","fullName":"","companySize":"","majorProduct":"","address":"","phone":"1234567","email":"test@qq.com","fax":"","webSite":"","introduction":"","salesId":"3"}', 'create', '2012-09-24 11:33:34');


DROP TABLE IF EXISTS `fu_crm_contact_history`;
CREATE TABLE IF NOT EXISTS `fu_crm_contact_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `diff` text COLLATE utf8_general_ci 	 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `fu_crm_contact_log`;
CREATE TABLE IF NOT EXISTS `fu_crm_contact_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `recentInfo` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,

  `type` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `fu_crm_task`;
CREATE TABLE IF NOT EXISTS `fu_crm_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `contactType` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `fu_crm_custom_form`;
CREATE TABLE IF NOT EXISTS `fu_crm_custom_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `category` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `in_tra_course`;
CREATE TABLE IF NOT EXISTS `in_tra_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `followCourseId` varchar(255) NOT NULL,
  `courseName` varchar(255) NOT NULL,
  `courseAddress` varchar(255) NOT NULL,
  `courseTime` varchar(255) NOT NULL,
  `contactPhone` int(11) NOT NULL,
  `courseIntroduction` text NOT NULL,
  `courseHandOuts` text NOT NULL,
  `courseVideo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=2 ;
INSERT INTO `in_tra_course` (`id`, `lecturer_id`, `contact_id`, `followCourseId`, `courseName`, `courseAddress`, `courseTime`, `contactPhone`, `courseIntroduction`, `courseHandOuts`, `courseVideo`) VALUES
(1, 1, 1, 1, '测试课程名称', '测试课程地址', '', 0, '', '', '');


DROP TABLE IF EXISTS `in_tra_lecturer`;
CREATE TABLE IF NOT EXISTS `in_tra_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturerName` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `avatar` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `introduction` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `specialty` text COLLATE utf8_general_ci 	 NOT NULL,
  `mobilePhone` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `qq` int(11) NOT NULL,
  `Msn` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=2 ;
INSERT INTO `in_tra_lecturer` (`id`, `lecturerName`, `avatar`, `introduction`, `specialty`, `mobilePhone`, `email`, `qq`, `Msn`) VALUES
(1, '测试讲师', '讲师A', '好讲师', '心理学', 0, '', 0, 0);


DROP TABLE IF EXISTS `in_tra_questionnaire`;
CREATE TABLE IF NOT EXISTS `in_tra_questionnaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `answer` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=2 ;
INSERT INTO `in_tra_questionnaire` (`id`, `question`, `answer`) VALUES
(1, '问题一', '答案');


DROP TABLE IF EXISTS `in_tra_course_log`;
CREATE TABLE IF NOT EXISTS `in_tra_course_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `recentInfo` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,

  `type` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `in_tra_course_history`;
CREATE TABLE IF NOT EXISTS `in_tra_course_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `diff` text COLLATE utf8_general_ci 	 NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `in_tra_trainee`;
CREATE TABLE IF NOT EXISTS `in_tra_trainee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `questionnaire_id` int(11) DEFAULT NULL,
  `traineeName` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `department` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `position` varchar(255) COLLATE utf8_general_ci 	 NOT NULL,
  `workingYears` int(11) NOT NULL,
  `serviceYears` int(11) NOT NULL,
  `remark` text COLLATE utf8_general_ci 	 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci 	 AUTO_INCREMENT=2 ;
INSERT INTO `in_tra_trainee` (`id`, `client_id`, `questionnaire_id`, `traineeName`, `department`, `position`, `workingYears`, `serviceYears`, `remark`) VALUES
(1, 1, 1, '张三', '', '', 0, 0, '');


DROP TABLE IF EXISTS `no_calendar`;
CREATE TABLE IF NOT EXISTS `no_calendar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `allday` tinyint(1) NOT NULL,
  `startDate` DATE NOT NULL,
  `endDate` DATE NOT NULL,
  `originalTime` datetime NOT NULL,
  `frequency` tinyint(1) NOT NULL,
  `repeatType` varchar(255) NOT NULL,
  `repeatWeek` varchar(255) NOT NULL,
  `repeatMonth` tinyint(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  `belongID` int(11) NOT NULL,
  `dataType` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  index (`repeatType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


