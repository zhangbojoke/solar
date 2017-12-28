/*
Navicat MySQL Data Transfer

Source Server         : ubuntu
Source Server Version : 50720
Source Host           : 192.168.116.129:3306
Source Database       : solar

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2017-12-28 18:28:39
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `mobile` varchar(11) DEFAULT '0' COMMENT '手机号',
  `open_id` varchar(32) DEFAULT NULL,
  `union_id` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `open_id` (`open_id`) USING BTREE,
  UNIQUE KEY `union_id` (`union_id`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('4', 'admi测试', '', 'admin', '5DOGW90JSJGSjfQkn9_yKyZlVeR9HlUz', '$2y$13$KE6/hhDt2VRLuqn4OgCTketoW.gBL8E1eGMxlNX2Uty9z2zVRWlyK', '', '', '4', '10', '1502000721', '1503847412', '18032259400', '', '');
INSERT INTO `user` VALUES ('5', null, null, 'invoker', 'rwj60QWc2AYuTnjaA8cElbqJ7ZBqFa6c', '$2y$13$NO2ieNaY9bqRQnhCzFK5FesQChywi8uR6M2LCNEWDMuf4MI6z.dum', null, '1248789116@qq.com', '0', '10', '1514429048', '1514429048', '0', null, null);

-- ----------------------------
-- Table structure for `user_extends`
-- ----------------------------
DROP TABLE IF EXISTS `user_extends`;
CREATE TABLE `user_extends` (
  `id` int(11) NOT NULL COMMENT '用户ID主键关联',
  `company` varchar(255) DEFAULT NULL,
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
INSERT INTO `user_extends` VALUES ('1', '北京灵动科技', null, null, null, null, null);
