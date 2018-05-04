/*
Navicat MySQL Data Transfer

Source Server         : lukachen
Source Server Version : 50148
Source Host           : qdm169738575.my3w.com:3306
Source Database       : qdm169738575_db

Target Server Type    : MYSQL
Target Server Version : 50148
File Encoding         : 65001

Date: 2018-05-02 11:10:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for esu_url
-- ----------------------------
DROP TABLE IF EXISTS `esu_url`;
CREATE TABLE `esu_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '短网址code',
  `long_url` varchar(1024) NOT NULL DEFAULT '' COMMENT '长网址',
  `long_url_hash` varchar(32) NOT NULL DEFAULT '' COMMENT '长网址做hash后的值',
  `request_num` int(11) NOT NULL DEFAULT '0' COMMENT '请求次数',
  `ip` varchar(32) NOT NULL DEFAULT '' COMMENT '请求ip',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='长短网址对应表';
