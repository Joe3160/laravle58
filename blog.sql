/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50724
Source Host           : 127.0.0.1:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-08-14 15:30:31
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
  `created_at` datetime DEFAULT NULL,
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
  `parent_id` int(10) unsigned DEFAULT '0' COMMENT '父级ID',
  `is_menu` tinyint(2) DEFAULT '0' COMMENT '是否显示在菜单栏',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '权限名唯一标识',
  `uri` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '请示地址',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permission_unique_key` (`unique_key`),
  KEY `permit_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_permissions
-- ----------------------------
INSERT INTO `wja_permissions` VALUES ('1', '0', '1', '公告管理', 'notice', '', '一级菜单-公告管理', null, '2019-08-12 15:04:59', '2019-08-12 15:45:39');
INSERT INTO `wja_permissions` VALUES ('2', '1', '1', '公告列表', 'notice_list', '/user/roles', '二级菜单-公告列表', null, '2019-08-12 15:06:41', '2019-08-12 15:06:41');
INSERT INTO `wja_permissions` VALUES ('3', '1', '0', '公告详情', 'notice_detail', '/news/detail', '二级菜单-公告详情', null, '2019-08-12 15:07:13', '2019-08-12 15:07:13');
INSERT INTO `wja_permissions` VALUES ('4', '1', '0', '编辑公告', 'notice_edit', '/news/edit', '二级菜单-编辑公告', null, '2019-08-12 15:07:30', '2019-08-12 15:07:30');
INSERT INTO `wja_permissions` VALUES ('5', '1', '0', '发布公告', 'notice_publish', '/news/publish', '二级菜单-发布公告', null, '2019-08-12 15:07:54', '2019-08-12 15:07:54');
INSERT INTO `wja_permissions` VALUES ('6', '1', '0', '删除公告', 'notice_del', '/news/del', '二级菜单-删除公告', null, '2019-08-12 15:35:37', '2019-08-12 15:35:37');
INSERT INTO `wja_permissions` VALUES ('8', '0', '1', '客户管理', 'customer', null, '一级菜单-客户管理', null, '2019-08-13 18:43:39', '2019-08-13 18:43:42');
INSERT INTO `wja_permissions` VALUES ('9', '8', '1', '客户列表', 'customer_list', '/customer/index', '二级菜单-客户列表', null, '2019-08-13 18:45:42', '2019-08-13 18:45:46');
INSERT INTO `wja_permissions` VALUES ('10', '8', '0', '客户详情', 'customer_detail', '/customer/detail', '二级菜单-客户详情', null, '2019-08-13 18:45:48', '2019-08-13 18:45:51');
INSERT INTO `wja_permissions` VALUES ('11', '8', '0', '添加客户', 'customer_add', '/customer/add', '二级菜单-添加客户', null, '2019-08-13 18:47:02', '2019-08-13 18:47:04');
INSERT INTO `wja_permissions` VALUES ('12', '0', '1', '商户管理', 'store', null, '一级菜单-商户管理', null, '2019-08-14 10:11:28', '2019-08-14 10:11:28');
INSERT INTO `wja_permissions` VALUES ('13', '12', '1', '商户列表', 'store_list', '/store/index', '二级菜单-商户列表', null, '2019-08-14 10:14:39', '2019-08-14 10:14:39');

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
INSERT INTO `wja_permission_role` VALUES ('1', '2');
INSERT INTO `wja_permission_role` VALUES ('2', '2');
INSERT INTO `wja_permission_role` VALUES ('3', '2');
INSERT INTO `wja_permission_role` VALUES ('4', '2');
INSERT INTO `wja_permission_role` VALUES ('5', '2');
INSERT INTO `wja_permission_role` VALUES ('8', '3');
INSERT INTO `wja_permission_role` VALUES ('9', '3');
INSERT INTO `wja_permission_role` VALUES ('10', '3');
INSERT INTO `wja_permission_role` VALUES ('11', '3');

-- ----------------------------
-- Table structure for wja_roles
-- ----------------------------
DROP TABLE IF EXISTS `wja_roles`;
CREATE TABLE `wja_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_roles
-- ----------------------------
INSERT INTO `wja_roles` VALUES ('1', '厂商', null, '生产商品', null, '2019-08-12 11:18:57', '2019-08-12 11:18:57');
INSERT INTO `wja_roles` VALUES ('2', '服务商', null, '服务商提供服务，发展自己的渠道', null, '2019-08-12 11:20:31', '2019-08-12 11:20:31');
INSERT INTO `wja_roles` VALUES ('3', '零售商', null, '零售商', null, '2019-08-12 11:21:45', '2019-08-12 12:16:08');
INSERT INTO `wja_roles` VALUES ('4', '厂商客服', null, '厂商客服', null, '2019-08-13 18:50:41', '2019-08-13 18:50:43');

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
INSERT INTO `wja_role_user` VALUES ('2', '1');
INSERT INTO `wja_role_user` VALUES ('3', '1');
INSERT INTO `wja_role_user` VALUES ('4', '1');
INSERT INTO `wja_role_user` VALUES ('2', '2');
INSERT INTO `wja_role_user` VALUES ('3', '2');

-- ----------------------------
-- Table structure for wja_users
-- ----------------------------
DROP TABLE IF EXISTS `wja_users`;
CREATE TABLE `wja_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(2) DEFAULT '0' COMMENT '是否超级管理员：0否，1是',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码不为空',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name_phone` (`name`,`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_users
-- ----------------------------
INSERT INTO `wja_users` VALUES ('1', '1', 'admin', '694995669@qq.com', '18244973184', '$2y$10$NjvQ7tBNtOJ6qFEMoRRMr.YdCCvTOLUMVTn9r9KwcJLo9PMTnPpGK', '5d536d666724b', '2019-08-14 10:09:42', null, '2019-08-09 10:07:14', '2019-08-14 10:09:42');
INSERT INTO `wja_users` VALUES ('2', '0', 'fuwu', '', '13512783986', '$2y$10$NjvQ7tBNtOJ6qFEMoRRMr.YdCCvTOLUMVTn9r9KwcJLo9PMTnPpGK', '5d539e44ab232', '2019-08-14 13:38:12', null, '2019-08-12 17:54:04', '2019-08-14 13:38:12');
INSERT INTO `wja_users` VALUES ('3', '0', 'lingshou', '', '13800138000', '$2y$10$3/ysU6ZcPD0E28jdGTtFTueMkhxeNq15MoJ3M2IMNP6AVn2FKCV2W', null, null, null, '2019-08-12 18:18:46', '2019-08-12 18:20:17');
INSERT INTO `wja_users` VALUES ('4', '0', 'fuwu0', '', '13800138001', '$2y$10$tx.ezcgkA5Vv7FsQgyvIJuAP2s8eiXI2xrAqX35rjPJs4Pq3R3rdS', '5d539e009d346', '2019-08-14 13:37:04', null, '2019-08-13 14:40:24', '2019-08-14 13:37:04');
