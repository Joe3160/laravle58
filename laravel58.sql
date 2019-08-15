/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50724
Source Host           : 127.0.0.1:3306
Source Database       : laravel58

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-08-15 15:27:54
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_migrations
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_permissions
-- ----------------------------
INSERT INTO `wja_permissions` VALUES ('1', '0', '1', '权限管理', 'rbac_manager', null, '一级菜单-权限管理', null, '2019-08-14 15:51:37', '2019-08-14 15:51:37');
INSERT INTO `wja_permissions` VALUES ('2', '1', '1', '权限列表', 'permission_list', 'api/permission/index', '二级菜单-权限列表', null, '2019-08-14 15:56:08', '2019-08-14 15:56:08');
INSERT INTO `wja_permissions` VALUES ('3', '1', '0', '添加权限', 'permission_add', 'api/permission/add', '二级菜单-添加权限', null, '2019-08-14 16:05:05', '2019-08-14 16:05:07');
INSERT INTO `wja_permissions` VALUES ('4', '1', '0', '编辑权限', 'permission_edit', 'api/permission/edit', '二级菜单-编辑权限', null, '2019-08-14 16:06:18', '2019-08-14 16:06:20');
INSERT INTO `wja_permissions` VALUES ('5', '1', '0', '删除权限', 'permission_del', 'api/permission/del', '二级菜单-删除权限', null, '2019-08-14 16:08:27', '2019-08-14 16:08:29');
INSERT INTO `wja_permissions` VALUES ('6', '1', '1', '角色列表', 'role_list', 'api/role/index', '二级菜单-角色列表', null, '2019-08-14 16:13:04', '2019-08-14 16:13:07');
INSERT INTO `wja_permissions` VALUES ('7', '1', '0', '添加角色', 'role_add', 'api/role/add', '二级菜单-添加角色', null, '2019-08-14 16:13:58', '2019-08-14 16:14:01');
INSERT INTO `wja_permissions` VALUES ('8', '1', '0', '编辑角色', 'role_edit', 'api/role/edit', '二级菜单-编辑角色', null, '2019-08-14 16:17:46', '2019-08-14 16:17:48');
INSERT INTO `wja_permissions` VALUES ('9', '1', '0', '删除角色', 'role_del', 'api/role/del', '二级菜单-删除角色', null, '2019-08-14 16:19:09', '2019-08-14 16:19:11');
INSERT INTO `wja_permissions` VALUES ('10', '1', '0', '获取角色权限', 'role_permission', 'api/role/permission', '二级菜单-角色权限', null, '2019-08-14 16:20:47', '2019-08-14 16:20:49');
INSERT INTO `wja_permissions` VALUES ('11', '1', '0', '更新角色权限', 'sync_permission', 'api/role/sync_permission', '二级菜单-更新角色权限', null, '2019-08-14 16:39:13', '2019-08-14 16:39:15');
INSERT INTO `wja_permissions` VALUES ('12', '1', '1', '用户列表', 'user_list', 'api/user/index', '二级菜单-商户列表', null, '2019-08-14 16:51:05', '2019-08-14 16:51:07');
INSERT INTO `wja_permissions` VALUES ('13', '1', '0', '添加用户', 'user_add', 'api/user/add', '二级菜单-添加商户', null, '2019-08-14 16:52:41', '2019-08-14 16:52:43');
INSERT INTO `wja_permissions` VALUES ('14', '1', '0', '编辑用户', 'user_edit', 'api/user/edit', '二级菜单-编辑商户', null, '2019-08-14 16:54:59', '2019-08-14 16:55:01');
INSERT INTO `wja_permissions` VALUES ('15', '1', '0', '删除用户', 'user_del', 'api/user/del', '二级菜单-删除商户', null, '2019-08-14 16:56:27', '2019-08-14 16:56:31');
INSERT INTO `wja_permissions` VALUES ('16', '1', '0', '获取用户角色', 'user_roles', 'api/user/roles', '二级菜单-获取商户角色', null, '2019-08-14 16:58:10', '2019-08-14 16:58:13');
INSERT INTO `wja_permissions` VALUES ('17', '1', '0', '更新用户角色', 'user_sync_roles', 'api/user/sync_roles', '二级菜单-更新商户角色', null, '2019-08-14 16:59:51', '2019-08-14 16:59:54');
INSERT INTO `wja_permissions` VALUES ('18', '0', '1', '公告管理', 'notice', '', '一级菜单-实例', null, '2019-08-14 17:41:42', '2019-08-14 17:41:44');
INSERT INTO `wja_permissions` VALUES ('19', '18', '1', '公告列表', 'notice_list', 'api/notice/index', '一级菜单-实例-列表', null, '2019-08-14 17:45:21', '2019-08-14 17:45:23');
INSERT INTO `wja_permissions` VALUES ('20', '18', '0', '添加公告', 'notice_add', 'api/notice/add', '一级菜单-实例-添加', null, '2019-08-14 17:45:25', '2019-08-14 17:45:27');
INSERT INTO `wja_permissions` VALUES ('21', '18', '0', '编辑公告', 'notice_edit', 'api/notice/edite', '一级菜单-实例-编辑', null, '2019-08-14 17:46:51', '2019-08-14 17:46:53');
INSERT INTO `wja_permissions` VALUES ('22', '18', '0', '删除公告', 'notice_del', 'api/notice/del', '一级菜单-实例-删除', null, '2019-08-14 17:47:46', '2019-08-14 17:47:52');
INSERT INTO `wja_permissions` VALUES ('23', '18', '0', '发布公告', 'notice_publish', 'api/notice/publish', '一级菜单-实例-发布', null, '2019-08-14 17:48:50', '2019-08-14 17:48:52');
INSERT INTO `wja_permissions` VALUES ('24', '18', '0', '公告详情', 'notice_detail', 'api/notice/detail', '二级菜单-实例-详情', null, '2019-08-14 17:50:16', '2019-08-14 17:50:19');
INSERT INTO `wja_permissions` VALUES ('25', '0', '1', '订单管理', 'order', '', '一级菜单-实例', null, '2019-08-14 17:53:33', '2019-08-14 17:53:35');
INSERT INTO `wja_permissions` VALUES ('26', '25', '1', '订单列表', 'order_list', 'api/order/index', '一级菜单-实例-列表', null, '2019-08-14 17:54:38', '2019-08-14 17:54:40');
INSERT INTO `wja_permissions` VALUES ('27', '25', '0', '订单详情', 'order_detail', 'api/order/detail', '一级菜单-实例-详情', null, '2019-08-14 17:55:52', '2019-08-14 18:32:48');

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
INSERT INTO `wja_permission_role` VALUES ('2', '1');
INSERT INTO `wja_permission_role` VALUES ('3', '1');
INSERT INTO `wja_permission_role` VALUES ('4', '1');
INSERT INTO `wja_permission_role` VALUES ('5', '1');
INSERT INTO `wja_permission_role` VALUES ('6', '1');
INSERT INTO `wja_permission_role` VALUES ('7', '1');
INSERT INTO `wja_permission_role` VALUES ('8', '1');
INSERT INTO `wja_permission_role` VALUES ('9', '1');
INSERT INTO `wja_permission_role` VALUES ('10', '1');
INSERT INTO `wja_permission_role` VALUES ('11', '1');
INSERT INTO `wja_permission_role` VALUES ('12', '1');
INSERT INTO `wja_permission_role` VALUES ('13', '1');
INSERT INTO `wja_permission_role` VALUES ('14', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_roles
-- ----------------------------
INSERT INTO `wja_roles` VALUES ('1', '厂商', null, '生产商品，提供售后支持', null, '2019-08-14 18:41:00', '2019-08-15 11:37:33');
INSERT INTO `wja_roles` VALUES ('2', '服务商', null, '提供售后服务，发展下线', null, '2019-08-14 18:43:23', '2019-08-14 18:43:23');
INSERT INTO `wja_roles` VALUES ('3', '零售商', null, '负责商品销售', null, '2019-08-14 18:44:04', '2019-08-14 18:44:04');

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
INSERT INTO `wja_role_user` VALUES ('1', '2');
INSERT INTO `wja_role_user` VALUES ('2', '2');

-- ----------------------------
-- Table structure for wja_users
-- ----------------------------
DROP TABLE IF EXISTS `wja_users`;
CREATE TABLE `wja_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `is_admin` tinyint(2) DEFAULT '0' COMMENT '是否超级管理员：0否，1是',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '手机号码不为空',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name_phone` (`name`,`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wja_users
-- ----------------------------
INSERT INTO `wja_users` VALUES ('1', '1', 'admin', '69499569@qq.com', '18244973184', '$2y$10$NjvQ7tBNtOJ6qFEMoRRMr.YdCCvTOLUMVTn9r9KwcJLo9PMTnPpGK', '5d54f33d67434', '2019-08-15 13:53:01', null, '2019-08-14 15:37:04', '2019-08-15 13:53:01');
INSERT INTO `wja_users` VALUES ('2', '0', 'fuwu', '879743970@qq.com', '13512783986', '$2y$10$NjvQ7tBNtOJ6qFEMoRRMr.YdCCvTOLUMVTn9r9KwcJLo9PMTnPpGK', '5d54f8c425ff0', '2019-08-15 14:16:36', null, '2019-08-15 10:27:46', '2019-08-15 14:16:36');
INSERT INTO `wja_users` VALUES ('3', '0', 'lingshou', null, '13800138002', '$2y$10$hLpaeK4gvxcejZfASySCMuvOZzgCaGxDVnLgauhZ5B2r3ZKj5pUbe', null, null, null, '2019-08-15 12:21:08', '2019-08-15 12:21:08');
