/*
Navicat MySQL Data Transfer

Source Server         : ubuntu
Source Server Version : 50720
Source Host           : 192.168.116.129:3306
Source Database       : solar

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2017-12-29 18:00:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `station`
-- ----------------------------
DROP TABLE IF EXISTS `station`;
CREATE TABLE `station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `installer` int(11) NOT NULL COMMENT '安装商',
  `user` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '当前状态',
  `created_at` int(11) NOT NULL,
  `location` varchar(60) NOT NULL COMMENT '所在经纬度',
  `cell` text NOT NULL COMMENT '电池组',
  `inverter` text NOT NULL COMMENT '逆变器',
  `collector` text NOT NULL COMMENT '采集器 ',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '并网方式',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `remark` varchar(100) NOT NULL COMMENT '备注',
  `update_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user` (`user`) USING BTREE,
  KEY `installer` (`installer`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of station
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nick` varchar(80) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `images` varchar(80) DEFAULT NULL COMMENT '用户头像',
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `mobile` varchar(11) DEFAULT '0' COMMENT '手机号',
  `bind_code` varchar(32) DEFAULT NULL COMMENT '绑定码 终端用户用',
  `parent` int(11) DEFAULT NULL COMMENT '普通用户的父级',
  `birthday` int(11) DEFAULT NULL COMMENT '用户生日',
  `solar_id` int(11) DEFAULT NULL COMMENT 'api用户的id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('4', 'admi测试', '', 'admin', '5DOGW90JSJGSjfQkn9_yKyZlVeR9HlUz', '$2y$13$KE6/hhDt2VRLuqn4OgCTketoW.gBL8E1eGMxlNX2Uty9z2zVRWlyK', '', '4', '10', '1502000721', '1503847412', '18032259400', null, null, null, null);
INSERT INTO `user` VALUES ('5', null, null, 'invoker', 'rwj60QWc2AYuTnjaA8cElbqJ7ZBqFa6c', '$2y$13$NO2ieNaY9bqRQnhCzFK5FesQChywi8uR6M2LCNEWDMuf4MI6z.dum', '1248789116@qq.com', '0', '10', '1514429048', '1514429048', '0', null, null, null, null);
INSERT INTO `user` VALUES ('22', '张博', null, 'zhangbo1', 'xL6zeashqDo9Jt7Z_LeMW3WW_3WArR9-', '$2y$13$WybKwRxMwq4J8szjG8QY3uiKoPQkdBv/P5GLUmHZ1U/XCtzHAz0HG', null, '2', '10', '1514517378', '1514517378', '18032259400', '942689', null, null, null);
INSERT INTO `user` VALUES ('24', '张博', null, 'zhangbo', 'XRs87RfMBpTk2kCONgcwXjxH7EGpHF4P', '$2y$13$kiS5dLbuYVBZTS4J/IRGt.MasK./q30MC/ARDRAcreawupL3Y2jhq', 'zhangbo@gmail.com', '1', '0', '1514540037', '1514540037', '18032259400', '005004', null, '1490371200', null);

-- ----------------------------
-- Table structure for `user_extends`
-- ----------------------------
DROP TABLE IF EXISTS `user_extends`;
CREATE TABLE `user_extends` (
  `id` int(11) NOT NULL COMMENT '用户ID主键关联',
  `company` varchar(64) DEFAULT NULL,
  `identity` varchar(32) DEFAULT NULL,
  `brand` varchar(64) DEFAULT NULL COMMENT '品牌信息',
  `mobile` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `logo` varchar(80) DEFAULT NULL COMMENT 'logo地址',
  `license` varchar(80) DEFAULT NULL COMMENT '营业执照',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING HASH,
  UNIQUE KEY `company` (`company`) USING HASH,
  UNIQUE KEY `identity` (`identity`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of user_extends
-- ----------------------------
INSERT INTO `user_extends` VALUES ('22', '北京灵动', '12313', '灵动', '18032259400', '123fsdfst', '123');

-- ----------------------------
-- Table structure for `wechat_user`
-- ----------------------------
DROP TABLE IF EXISTS `wechat_user`;
CREATE TABLE `wechat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `union_id` varchar(32) NOT NULL,
  `open_id` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '对应的用户id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `union_id` (`union_id`) USING HASH
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of wechat_user
-- ----------------------------
