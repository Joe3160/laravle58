/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50724
Source Host           : 127.0.0.1:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-08-12 18:58:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wja_migrations
-- ----------------------------
DROP TABLE IF EXISTS `wja_migrations`;
CREATE TABLE `wja_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_migrations
-- ----------------------------
INSERT INTO `wja_migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `wja_migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `wja_migrations` VALUES ('3', '2019_08_08_093518_create_rbac_tables', '1');

-- ----------------------------
-- Table structure for wja_password_resets
-- ----------------------------
DROP TABLE IF EXISTS `wja_password_resets`;
CREATE TABLE `wja_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `wja_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for wja_permissions
-- ----------------------------
DROP TABLE IF EXISTS `wja_permissions`;
CREATE TABLE `wja_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '请示地址',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_permissions
-- ----------------------------
INSERT INTO `wja_permissions` VALUES ('2', '公告列表', null, '/news/index', 'haa haa', null, '2019-08-12 15:04:59', '2019-08-12 15:45:39');
INSERT INTO `wja_permissions` VALUES ('3', '公告详情', null, null, '公告详情~~', null, '2019-08-12 15:06:41', '2019-08-12 15:06:41');
INSERT INTO `wja_permissions` VALUES ('4', '新增公告', null, null, '新增公告', null, '2019-08-12 15:07:13', '2019-08-12 15:07:13');
INSERT INTO `wja_permissions` VALUES ('5', '编辑公告', null, null, '编辑公告', null, '2019-08-12 15:07:30', '2019-08-12 15:07:30');
INSERT INTO `wja_permissions` VALUES ('6', '发布公告', null, null, '发布公告', null, '2019-08-12 15:07:54', '2019-08-12 15:07:54');
INSERT INTO `wja_permissions` VALUES ('7', '删除公告', null, '/permission/del', '删除公告~~', null, '2019-08-12 15:35:37', '2019-08-12 15:35:37');

-- ----------------------------
-- Table structure for wja_permission_role
-- ----------------------------
DROP TABLE IF EXISTS `wja_permission_role`;
CREATE TABLE `wja_permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  UNIQUE KEY `permin_role_id` (`permission_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_permission_role
-- ----------------------------
INSERT INTO `wja_permission_role` VALUES ('1', '1');

-- ----------------------------
-- Table structure for wja_roles
-- ----------------------------
DROP TABLE IF EXISTS `wja_roles`;
CREATE TABLE `wja_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `deleted_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_roles
-- ----------------------------
INSERT INTO `wja_roles` VALUES ('1', 'admin', 'admin', '超级管理员', null, '2019-08-08 19:15:02', '2019-08-08 19:15:02');
INSERT INTO `wja_roles` VALUES ('2', '厂商', null, '生产商品', null, '2019-08-12 11:18:57', '2019-08-12 11:18:57');
INSERT INTO `wja_roles` VALUES ('3', '服务商', null, '服务商提供服务，发展自己的渠道', null, '2019-08-12 11:20:31', '2019-08-12 11:20:31');
INSERT INTO `wja_roles` VALUES ('4', '零售商', null, '零售商', '2019-08-12 18:37:13', '2019-08-12 11:21:45', '2019-08-12 12:16:08');

-- ----------------------------
-- Table structure for wja_role_user
-- ----------------------------
DROP TABLE IF EXISTS `wja_role_user`;
CREATE TABLE `wja_role_user` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_role_user
-- ----------------------------
INSERT INTO `wja_role_user` VALUES ('1', '1');

-- ----------------------------
-- Table structure for wja_users
-- ----------------------------
DROP TABLE IF EXISTS `wja_users`;
CREATE TABLE `wja_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码不为空',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name_phone` (`name`,`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_users
-- ----------------------------
INSERT INTO `wja_users` VALUES ('1', 'admin', '694995669@qq.com', '18244973184', '$2y$10$NjvQ7tBNtOJ6qFEMoRRMr.YdCCvTOLUMVTn9r9KwcJLo9PMTnPpGK', '5555', null, '2019-08-09 10:07:14', '2019-08-12 18:09:24');
INSERT INTO `wja_users` VALUES ('2', 'fuwu', '', '13512783986', '$2y$10$NjvQ7tBNtOJ6qFEMoRRMr.YdCCvTOLUMVTn9r9KwcJLo9PMTnPpGK', null, null, '2019-08-12 17:54:04', '2019-08-12 17:54:04');
INSERT INTO `wja_users` VALUES ('5', 'lingshou', '', '13800138000', '$2y$10$3/ysU6ZcPD0E28jdGTtFTueMkhxeNq15MoJ3M2IMNP6AVn2FKCV2W', null, null, '2019-08-12 18:18:46', '2019-08-12 18:20:17');
