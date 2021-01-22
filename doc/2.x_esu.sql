/*
 Navicat Premium Data Transfer
 Source Server Type    : MySQL
 Date: 06/01/2021 10:54:34
*/

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for esu_url
-- ----------------------------
DROP TABLE IF EXISTS `esu_url`;
CREATE TABLE `esu_url`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '短网址code',
  `long_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '长网址',
  `long_url_hash` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '长网址做hash后的值',
  `request_num` int(11) NOT NULL DEFAULT 0 COMMENT '请求次数',
  `ip` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '请求ip',
  `access_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密钥',
  `created_at` datetime(0) NOT NULL COMMENT '创建时间',
  `updated_at` datetime(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '长短网址对应表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for esu_access
-- ----------------------------
DROP TABLE IF EXISTS `esu_access`;
CREATE TABLE `esu_access`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密钥',
  `access_domain` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '可跳转域名',
  `created_at` datetime(0) NOT NULL COMMENT '创建时间',
  `updated_at` datetime(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '授权表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of esu_access
-- ----------------------------
INSERT INTO `esu_access` VALUES (1, 'esu', 'lukachen.com', '2021-01-05 18:34:48', '2021-01-05 18:34:48');

SET FOREIGN_KEY_CHECKS = 1;
