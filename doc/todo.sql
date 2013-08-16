/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Version : 50525
 Source Host           : localhost
 Source Database       : test

 Target Server Version : 50525
 File Encoding         : utf-8

 Date: 08/16/2013 09:57:55 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `todo`
-- ----------------------------
DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `todo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

