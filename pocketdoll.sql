-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.53 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 pocketdoll 的数据库结构
CREATE DATABASE IF NOT EXISTS `pocketdoll` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `pocketdoll`;

-- 导出  表 pocketdoll.admin_menu 结构
CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_menu 的数据：14 rows
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `created_at`, `updated_at`) VALUES
	(1, 0, 1, '控制台', 'fa-bar-chart', '/', NULL, '2017-10-12 15:47:40'),
	(2, 0, 2, '管理员', 'fa-tasks', NULL, NULL, '2017-10-12 15:47:00'),
	(3, 2, 3, '用户', 'fa-users', 'auth/users', NULL, '2017-10-12 15:05:10'),
	(4, 2, 4, '角色', 'fa-user', 'auth/roles', NULL, '2017-10-12 15:05:40'),
	(5, 2, 5, '权限', 'fa-ban', 'auth/permissions', NULL, '2017-10-12 15:06:18'),
	(6, 2, 6, '菜单', 'fa-bars', 'auth/menu', NULL, '2017-10-12 15:06:30'),
	(7, 2, 7, '操作日志', 'fa-history', 'auth/logs', NULL, '2017-10-12 15:06:45'),
	(8, 0, 0, '商品管理', 'fa-shopping-bag', NULL, '2017-10-12 16:14:04', '2017-10-12 16:14:04'),
	(9, 8, 0, '娃娃管理', 'fa-shopping-basket', 'goods/', '2017-10-12 16:17:11', '2017-10-13 14:40:09'),
	(10, 8, 0, '娃娃机管理', 'fa-simplybuilt', 'machine', '2017-10-13 14:12:45', '2017-10-13 14:37:36'),
	(11, 8, 0, '标签', 'fa-tags', 'tags', '2017-10-13 15:14:10', '2017-10-13 15:14:10'),
	(12, 0, 0, '公告/活动', 'fa-bullhorn', NULL, '2017-10-13 17:20:24', '2017-10-13 17:20:24'),
	(13, 12, 0, '公告管理', 'fa-copy', 'notice', '2017-10-13 17:21:29', '2017-10-13 17:21:29'),
	(14, 12, 0, '玩家秀', 'fa-star-o', 'usershow', '2017-10-13 17:41:04', '2017-10-13 17:41:04');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_operation_log 结构
CREATE TABLE IF NOT EXISTS `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=588 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_operation_log 的数据：587 rows
/*!40000 ALTER TABLE `admin_operation_log` DISABLE KEYS */;
INSERT INTO `admin_operation_log` (`id`, `user_id`, `path`, `method`, `ip`, `input`, `created_at`, `updated_at`) VALUES
	(1, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 10:59:15', '2017-10-12 10:59:15'),
	(2, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 10:59:30', '2017-10-12 10:59:30'),
	(3, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container","per_page":"50"}', '2017-10-12 10:59:49', '2017-10-12 10:59:49'),
	(4, 1, 'admin/auth/users/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users\\/create","_pjax":"#pjax-container"}', '2017-10-12 10:59:51', '2017-10-12 10:59:51'),
	(5, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","per_page":"50","_pjax":"#pjax-container"}', '2017-10-12 11:00:33', '2017-10-12 11:00:33'),
	(6, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","per_page":"50","_pjax":"#pjax-container","_export_":"all"}', '2017-10-12 11:00:43', '2017-10-12 11:00:43'),
	(7, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 11:02:04', '2017-10-12 11:02:04'),
	(8, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 11:16:53', '2017-10-12 11:16:53'),
	(9, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 11:16:57', '2017-10-12 11:16:57'),
	(10, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 11:17:08', '2017-10-12 11:17:08'),
	(11, 1, 'admin/auth/roles/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles\\/create","_pjax":"#pjax-container"}', '2017-10-12 11:17:12', '2017-10-12 11:17:12'),
	(12, 1, 'admin/auth/roles', 'POST', '127.0.0.1', '{"slug":null,"name":null,"permissions":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/roles?_url=%2Fadmin%2Fauth%2Froles","_url":"\\/admin\\/auth\\/roles"}', '2017-10-12 11:17:24', '2017-10-12 11:17:24'),
	(13, 1, 'admin/auth/roles/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles\\/create"}', '2017-10-12 11:17:24', '2017-10-12 11:17:24'),
	(14, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 11:45:29', '2017-10-12 11:45:29'),
	(15, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 11:45:49', '2017-10-12 11:45:49'),
	(16, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 11:57:50', '2017-10-12 11:57:50'),
	(17, 1, 'admin/auth/users/1/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users\\/1\\/edit","_pjax":"#pjax-container"}', '2017-10-12 11:57:53', '2017-10-12 11:57:53'),
	(18, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 11:57:57', '2017-10-12 11:57:57'),
	(19, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 11:58:00', '2017-10-12 11:58:00'),
	(20, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 11:58:01', '2017-10-12 11:58:01'),
	(21, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 11:58:17', '2017-10-12 11:58:17'),
	(22, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 12:02:01', '2017-10-12 12:02:01'),
	(23, 1, 'admin/auth/roles/1/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles\\/1\\/edit","_pjax":"#pjax-container"}', '2017-10-12 12:02:16', '2017-10-12 12:02:16'),
	(24, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 12:03:34', '2017-10-12 12:03:34'),
	(25, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles"}', '2017-10-12 13:04:48', '2017-10-12 13:04:48'),
	(26, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 14:13:31', '2017-10-12 14:13:31'),
	(27, 1, 'admin/auth/setting', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/setting","_pjax":"#pjax-container"}', '2017-10-12 14:18:39', '2017-10-12 14:18:39'),
	(28, 1, 'admin/auth/setting', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/setting"}', '2017-10-12 14:22:23', '2017-10-12 14:22:23'),
	(29, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 14:22:53', '2017-10-12 14:22:53'),
	(30, 1, 'admin/auth/setting', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/setting","_pjax":"#pjax-container"}', '2017-10-12 14:22:57', '2017-10-12 14:22:57'),
	(31, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 14:41:12', '2017-10-12 14:41:12'),
	(32, 1, 'admin/auth/setting', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/setting","_pjax":"#pjax-container"}', '2017-10-12 14:41:25', '2017-10-12 14:41:25'),
	(33, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 14:42:31', '2017-10-12 14:42:31'),
	(34, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 14:52:35', '2017-10-12 14:52:35'),
	(35, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 14:56:34', '2017-10-12 14:56:34'),
	(36, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 14:57:34', '2017-10-12 14:57:34'),
	(37, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 14:57:38', '2017-10-12 14:57:38'),
	(38, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 14:57:50', '2017-10-12 14:57:50'),
	(39, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 14:58:04', '2017-10-12 14:58:04'),
	(40, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:00:26', '2017-10-12 15:00:26'),
	(41, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:00:40', '2017-10-12 15:00:40'),
	(42, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:00:56', '2017-10-12 15:00:56'),
	(43, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:01:03', '2017-10-12 15:01:03'),
	(44, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:02:26', '2017-10-12 15:02:26'),
	(45, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:02:39', '2017-10-12 15:02:39'),
	(46, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:03:08', '2017-10-12 15:03:08'),
	(47, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:03:32', '2017-10-12 15:03:32'),
	(48, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:03:44', '2017-10-12 15:03:44'),
	(49, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 15:04:53', '2017-10-12 15:04:53'),
	(50, 1, 'admin/auth/menu/3/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/3\\/edit","_pjax":"#pjax-container"}', '2017-10-12 15:04:57', '2017-10-12 15:04:57'),
	(51, 1, 'admin/auth/menu/3', 'PUT', '127.0.0.1', '{"parent_id":"2","title":"\\u7528\\u6237","icon":"fa-users","uri":"auth\\/users","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/3"}', '2017-10-12 15:05:09', '2017-10-12 15:05:09'),
	(52, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:05:10', '2017-10-12 15:05:10'),
	(53, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:05:14', '2017-10-12 15:05:14'),
	(54, 1, 'admin/auth/menu/4/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/4\\/edit","_pjax":"#pjax-container"}', '2017-10-12 15:05:24', '2017-10-12 15:05:24'),
	(55, 1, 'admin/auth/menu/4', 'PUT', '127.0.0.1', '{"parent_id":"2","title":"\\u89d2\\u8272","icon":"fa-user","uri":"auth\\/roles","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/4"}', '2017-10-12 15:05:40', '2017-10-12 15:05:40'),
	(56, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:05:40', '2017-10-12 15:05:40'),
	(57, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-12 15:05:44', '2017-10-12 15:05:44'),
	(58, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 15:05:51', '2017-10-12 15:05:51'),
	(59, 1, 'admin/auth/menu/5/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/5\\/edit","_pjax":"#pjax-container"}', '2017-10-12 15:05:54', '2017-10-12 15:05:54'),
	(60, 1, 'admin/auth/menu/5', 'PUT', '127.0.0.1', '{"parent_id":"2","title":"\\u6743\\u9650","icon":"fa-ban","uri":"auth\\/permissions","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/5"}', '2017-10-12 15:06:18', '2017-10-12 15:06:18'),
	(61, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:06:18', '2017-10-12 15:06:18'),
	(62, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 15:06:20', '2017-10-12 15:06:20'),
	(63, 1, 'admin/auth/menu/6/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/6\\/edit","_pjax":"#pjax-container"}', '2017-10-12 15:06:24', '2017-10-12 15:06:24'),
	(64, 1, 'admin/auth/menu/6', 'PUT', '127.0.0.1', '{"parent_id":"2","title":"\\u83dc\\u5355","icon":"fa-bars","uri":"auth\\/menu","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/6"}', '2017-10-12 15:06:30', '2017-10-12 15:06:30'),
	(65, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:06:30', '2017-10-12 15:06:30'),
	(66, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 15:06:35', '2017-10-12 15:06:35'),
	(67, 1, 'admin/auth/menu/7/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/7\\/edit","_pjax":"#pjax-container"}', '2017-10-12 15:06:37', '2017-10-12 15:06:37'),
	(68, 1, 'admin/auth/menu/7', 'PUT', '127.0.0.1', '{"parent_id":"2","title":"\\u64cd\\u4f5c\\u65e5\\u5fd7","icon":"fa-history","uri":"auth\\/logs","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/7"}', '2017-10-12 15:06:45', '2017-10-12 15:06:45'),
	(69, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:06:46', '2017-10-12 15:06:46'),
	(70, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:06:58', '2017-10-12 15:06:58'),
	(71, 1, 'admin/auth/logout', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/logout","_pjax":"#pjax-container"}', '2017-10-12 15:08:10', '2017-10-12 15:08:10'),
	(72, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:40:29', '2017-10-12 15:40:29'),
	(73, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 15:45:17', '2017-10-12 15:45:17'),
	(74, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 15:45:23', '2017-10-12 15:45:23'),
	(75, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-12 15:46:33', '2017-10-12 15:46:33'),
	(76, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 15:46:36', '2017-10-12 15:46:36'),
	(77, 1, 'admin/auth/menu/2/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/2\\/edit","_pjax":"#pjax-container"}', '2017-10-12 15:46:39', '2017-10-12 15:46:39'),
	(78, 1, 'admin/auth/menu/2', 'PUT', '127.0.0.1', '{"parent_id":"0","title":"\\u7ba1\\u7406\\u5458","icon":"fa-tasks","uri":null,"roles":["1",null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/2"}', '2017-10-12 15:47:00', '2017-10-12 15:47:00'),
	(79, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:47:00', '2017-10-12 15:47:00'),
	(80, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 15:47:09', '2017-10-12 15:47:09'),
	(81, 1, 'admin/auth/login', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/login"}', '2017-10-12 15:47:20', '2017-10-12 15:47:20'),
	(82, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 15:47:21', '2017-10-12 15:47:21'),
	(83, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 15:47:27', '2017-10-12 15:47:27'),
	(84, 1, 'admin/auth/menu/1/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/1\\/edit","_pjax":"#pjax-container"}', '2017-10-12 15:47:30', '2017-10-12 15:47:30'),
	(85, 1, 'admin/auth/menu/1', 'PUT', '127.0.0.1', '{"parent_id":"0","title":"\\u63a7\\u5236\\u53f0","icon":"fa-bar-chart","uri":"\\/","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/1"}', '2017-10-12 15:47:40', '2017-10-12 15:47:40'),
	(86, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:47:40', '2017-10-12 15:47:40'),
	(87, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 15:47:44', '2017-10-12 15:47:44'),
	(88, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 15:50:33', '2017-10-12 15:50:33'),
	(89, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 15:59:25', '2017-10-12 15:59:25'),
	(90, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 15:59:31', '2017-10-12 15:59:31'),
	(91, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 16:00:49', '2017-10-12 16:00:49'),
	(92, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":null,"icon":"fa-bars","uri":null,"roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:07:11', '2017-10-12 16:07:11'),
	(93, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:07:11', '2017-10-12 16:07:11'),
	(94, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-12 16:08:04', '2017-10-12 16:08:04'),
	(95, 1, 'admin/auth/permissions/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions\\/create","_pjax":"#pjax-container"}', '2017-10-12 16:08:10', '2017-10-12 16:08:10'),
	(96, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-12 16:08:37', '2017-10-12 16:08:37'),
	(97, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 16:09:25', '2017-10-12 16:09:25'),
	(98, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 16:09:31', '2017-10-12 16:09:31'),
	(99, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-12 16:09:33', '2017-10-12 16:09:33'),
	(100, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 16:09:36', '2017-10-12 16:09:36'),
	(101, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 16:11:55', '2017-10-12 16:11:55'),
	(102, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":"\\u5546\\u54c1\\u7ba1\\u7406","icon":"fa-shopping-bag","uri":null,"roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:14:04', '2017-10-12 16:14:04'),
	(103, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:14:04', '2017-10-12 16:14:04'),
	(104, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:15:03', '2017-10-12 16:15:03'),
	(105, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 16:15:08', '2017-10-12 16:15:08'),
	(106, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 16:15:12', '2017-10-12 16:15:12'),
	(107, 1, 'admin/auth/menu/8/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/8\\/edit","_pjax":"#pjax-container"}', '2017-10-12 16:15:18', '2017-10-12 16:15:18'),
	(108, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 16:15:43', '2017-10-12 16:15:43'),
	(109, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 16:15:44', '2017-10-12 16:15:44'),
	(110, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"8","title":"\\u5a03\\u5a03\\u7ba1\\u7406","icon":"fa-female","uri":"\\/admin\\/goods\\/index","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:17:11', '2017-10-12 16:17:11'),
	(111, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:17:11', '2017-10-12 16:17:11'),
	(112, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 16:17:15', '2017-10-12 16:17:15'),
	(113, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 16:17:17', '2017-10-12 16:17:17'),
	(114, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 16:19:21', '2017-10-12 16:19:21'),
	(115, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 16:32:06', '2017-10-12 16:32:06'),
	(116, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 16:32:33', '2017-10-12 16:32:33'),
	(117, 1, 'admin/auth/menu/9/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/9\\/edit","_pjax":"#pjax-container"}', '2017-10-12 16:32:36', '2017-10-12 16:32:36'),
	(118, 1, 'admin/auth/menu/9', 'PUT', '127.0.0.1', '{"parent_id":"8","title":"\\u5a03\\u5a03\\u7ba1\\u7406","icon":"fa-female","uri":"goods\\/index","roles":[null],"_token":"ftqNhQHZQgw61mnYJKWYu47IR82FOnyqaUroEpbC","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/9"}', '2017-10-12 16:32:44', '2017-10-12 16:32:44'),
	(119, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:32:45', '2017-10-12 16:32:45'),
	(120, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-12 16:32:50', '2017-10-12 16:32:50'),
	(121, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:32:52', '2017-10-12 16:32:52'),
	(122, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 16:32:57', '2017-10-12 16:32:57'),
	(123, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 16:35:37', '2017-10-12 16:35:37'),
	(124, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:42:16', '2017-10-12 16:42:16'),
	(125, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:42:44', '2017-10-12 16:42:44'),
	(126, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:44:35', '2017-10-12 16:44:35'),
	(127, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:44:44', '2017-10-12 16:44:44'),
	(128, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 16:53:56', '2017-10-12 16:53:56'),
	(129, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:54:48', '2017-10-12 16:54:48'),
	(130, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:56:33', '2017-10-12 16:56:33'),
	(131, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 16:56:35', '2017-10-12 16:56:35'),
	(132, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:02:50', '2017-10-12 17:02:50'),
	(133, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:06:09', '2017-10-12 17:06:09'),
	(134, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:08:54', '2017-10-12 17:08:54'),
	(135, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:09:05', '2017-10-12 17:09:05'),
	(136, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:15:35', '2017-10-12 17:15:35'),
	(137, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:16:49', '2017-10-12 17:16:49'),
	(138, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:27:17', '2017-10-12 17:27:17'),
	(139, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:27:50', '2017-10-12 17:27:50'),
	(140, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:31:06', '2017-10-12 17:31:06'),
	(141, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 17:33:29', '2017-10-12 17:33:29'),
	(142, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:35:47', '2017-10-12 17:35:47'),
	(143, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:36:46', '2017-10-12 17:36:46'),
	(144, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:37:12', '2017-10-12 17:37:12'),
	(145, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:37:54', '2017-10-12 17:37:54'),
	(146, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:39:06', '2017-10-12 17:39:06'),
	(147, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 17:39:15', '2017-10-12 17:39:15'),
	(148, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:39:17', '2017-10-12 17:39:17'),
	(149, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:41:52', '2017-10-12 17:41:52'),
	(150, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 17:41:54', '2017-10-12 17:41:54'),
	(151, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:42:49', '2017-10-12 17:42:49'),
	(152, 1, 'admin/auth/setting', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/setting","_pjax":"#pjax-container"}', '2017-10-12 17:43:02', '2017-10-12 17:43:02'),
	(153, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:44:22', '2017-10-12 17:44:22'),
	(154, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 17:46:07', '2017-10-12 17:46:07'),
	(155, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 17:49:49', '2017-10-12 17:49:49'),
	(156, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-12 17:50:18', '2017-10-12 17:50:18'),
	(157, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 17:56:00', '2017-10-12 17:56:00'),
	(158, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 17:59:00', '2017-10-12 17:59:00'),
	(159, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-12 17:59:02', '2017-10-12 17:59:02'),
	(160, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 17:59:57', '2017-10-12 17:59:57'),
	(161, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-12 17:59:59', '2017-10-12 17:59:59'),
	(162, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:00:16', '2017-10-12 18:00:16'),
	(163, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-12 18:00:17', '2017-10-12 18:00:17'),
	(164, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:01:01', '2017-10-12 18:01:01'),
	(165, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-12 18:01:03', '2017-10-12 18:01:03'),
	(166, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:02:20', '2017-10-12 18:02:20'),
	(167, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-12 18:02:22', '2017-10-12 18:02:22'),
	(168, 1, 'admin/goods/index/create/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create\\/create","_pjax":"#pjax-container"}', '2017-10-12 18:02:25', '2017-10-12 18:02:25'),
	(169, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:02:37', '2017-10-12 18:02:37'),
	(170, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:02:53', '2017-10-12 18:02:53'),
	(171, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:04:39', '2017-10-12 18:04:39'),
	(172, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 18:06:48', '2017-10-12 18:06:48'),
	(173, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:06:51', '2017-10-12 18:06:51'),
	(174, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-12 18:07:08', '2017-10-12 18:07:08'),
	(175, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:07:10', '2017-10-12 18:07:10'),
	(176, 1, 'admin/auth/setting', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/setting"}', '2017-10-12 18:07:39', '2017-10-12 18:07:39'),
	(177, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:07:43', '2017-10-12 18:07:43'),
	(178, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:12:27', '2017-10-12 18:12:27'),
	(179, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-12 18:12:30', '2017-10-12 18:12:30'),
	(180, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:12:32', '2017-10-12 18:12:32'),
	(181, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-12 18:12:36', '2017-10-12 18:12:36'),
	(182, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:18:21', '2017-10-12 18:18:21'),
	(183, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:21', '2017-10-12 18:18:21'),
	(184, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:22', '2017-10-12 18:18:22'),
	(185, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:22', '2017-10-12 18:18:22'),
	(186, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:22', '2017-10-12 18:18:22'),
	(187, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:23', '2017-10-12 18:18:23'),
	(188, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:23', '2017-10-12 18:18:23'),
	(189, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:23', '2017-10-12 18:18:23'),
	(190, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:24', '2017-10-12 18:18:24'),
	(191, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:24', '2017-10-12 18:18:24'),
	(192, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:25', '2017-10-12 18:18:25'),
	(193, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:25', '2017-10-12 18:18:25'),
	(194, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:25', '2017-10-12 18:18:25'),
	(195, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:26', '2017-10-12 18:18:26'),
	(196, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:26', '2017-10-12 18:18:26'),
	(197, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:26', '2017-10-12 18:18:26'),
	(198, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:27', '2017-10-12 18:18:27'),
	(199, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:27', '2017-10-12 18:18:27'),
	(200, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:27', '2017-10-12 18:18:27'),
	(201, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:28', '2017-10-12 18:18:28'),
	(202, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:28', '2017-10-12 18:18:28'),
	(203, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:29', '2017-10-12 18:18:29'),
	(204, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:40', '2017-10-12 18:18:40'),
	(205, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:42', '2017-10-12 18:18:42'),
	(206, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:42', '2017-10-12 18:18:42'),
	(207, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-12 18:18:43', '2017-10-12 18:18:43'),
	(208, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 18:18:58', '2017-10-12 18:18:58'),
	(209, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:19:01', '2017-10-12 18:19:01'),
	(210, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 18:19:02', '2017-10-12 18:19:02'),
	(211, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:22:26', '2017-10-12 18:22:26'),
	(212, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 18:22:27', '2017-10-12 18:22:27'),
	(213, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 18:22:57', '2017-10-12 18:22:57'),
	(214, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:23:00', '2017-10-12 18:23:00'),
	(215, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 18:23:00', '2017-10-12 18:23:00'),
	(216, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-12 18:23:08', '2017-10-12 18:23:08'),
	(217, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin","_pjax":"#pjax-container"}', '2017-10-12 18:23:11', '2017-10-12 18:23:11'),
	(218, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:23:15', '2017-10-12 18:23:15'),
	(219, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-12 18:23:16', '2017-10-12 18:23:16'),
	(220, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-12 18:26:30', '2017-10-12 18:26:30'),
	(221, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 18:26:32', '2017-10-12 18:26:32'),
	(222, 1, 'admin/auth/menu/7/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/7\\/edit","_pjax":"#pjax-container"}', '2017-10-12 18:26:42', '2017-10-12 18:26:42'),
	(223, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-12 18:26:50', '2017-10-12 18:26:50'),
	(224, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-12 18:40:51', '2017-10-12 18:40:51'),
	(225, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-12 18:43:12', '2017-10-12 18:43:12'),
	(226, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-13 09:27:36', '2017-10-13 09:27:36'),
	(227, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:27:50', '2017-10-13 09:27:50'),
	(228, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:44:46', '2017-10-13 09:44:46'),
	(229, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-13 09:46:23', '2017-10-13 09:46:23'),
	(230, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-13 09:46:24', '2017-10-13 09:46:24'),
	(231, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-13 09:46:25', '2017-10-13 09:46:25'),
	(232, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-13 09:46:26', '2017-10-13 09:46:26'),
	(233, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-13 09:46:27', '2017-10-13 09:46:27'),
	(234, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-13 09:46:28', '2017-10-13 09:46:28'),
	(235, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-13 09:46:29', '2017-10-13 09:46:29'),
	(236, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 09:46:30', '2017-10-13 09:46:30'),
	(237, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:46:32', '2017-10-13 09:46:32'),
	(238, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 09:46:33', '2017-10-13 09:46:33'),
	(239, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:46:38', '2017-10-13 09:46:38'),
	(240, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:50:38', '2017-10-13 09:50:38'),
	(241, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 09:51:35', '2017-10-13 09:51:35'),
	(242, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:52:20', '2017-10-13 09:52:20'),
	(243, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:52:26', '2017-10-13 09:52:26'),
	(244, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:52:26', '2017-10-13 09:52:26'),
	(245, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:55:51', '2017-10-13 09:55:51'),
	(246, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:55:51', '2017-10-13 09:55:51'),
	(247, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:56:01', '2017-10-13 09:56:01'),
	(248, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:56:02', '2017-10-13 09:56:02'),
	(249, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:56:08', '2017-10-13 09:56:08'),
	(250, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:56:09', '2017-10-13 09:56:09'),
	(251, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:56:20', '2017-10-13 09:56:20'),
	(252, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:56:20', '2017-10-13 09:56:20'),
	(253, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:56:24', '2017-10-13 09:56:24'),
	(254, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:56:25', '2017-10-13 09:56:25'),
	(255, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 09:57:55', '2017-10-13 09:57:55'),
	(256, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 09:58:02', '2017-10-13 09:58:02'),
	(257, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:12:33', '2017-10-13 10:12:33'),
	(258, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 10:18:22', '2017-10-13 10:18:22'),
	(259, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:21:45', '2017-10-13 10:21:45'),
	(260, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 10:22:47', '2017-10-13 10:22:47'),
	(261, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:26:02', '2017-10-13 10:26:02'),
	(262, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:26:05', '2017-10-13 10:26:05'),
	(263, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:42:10', '2017-10-13 10:42:10'),
	(264, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:42:12', '2017-10-13 10:42:12'),
	(265, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 10:42:16', '2017-10-13 10:42:16'),
	(266, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:42:53', '2017-10-13 10:42:53'),
	(267, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:42:55', '2017-10-13 10:42:55'),
	(268, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 10:43:16', '2017-10-13 10:43:16'),
	(269, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:43:19', '2017-10-13 10:43:19'),
	(270, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:43:20', '2017-10-13 10:43:20'),
	(271, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:46:17', '2017-10-13 10:46:17'),
	(272, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:46:30', '2017-10-13 10:46:30'),
	(273, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:47:05', '2017-10-13 10:47:05'),
	(274, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:47:07', '2017-10-13 10:47:07'),
	(275, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:47:28', '2017-10-13 10:47:28'),
	(276, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:47:30', '2017-10-13 10:47:30'),
	(277, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:47:50', '2017-10-13 10:47:50'),
	(278, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:47:52', '2017-10-13 10:47:52'),
	(279, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 10:48:33', '2017-10-13 10:48:33'),
	(280, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:48:35', '2017-10-13 10:48:35'),
	(281, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:48:37', '2017-10-13 10:48:37'),
	(282, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 10:49:59', '2017-10-13 10:49:59'),
	(283, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:50:00', '2017-10-13 10:50:00'),
	(284, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:50:29', '2017-10-13 10:50:29'),
	(285, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:50:32', '2017-10-13 10:50:32'),
	(286, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 10:51:00', '2017-10-13 10:51:00'),
	(287, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 10:51:02', '2017-10-13 10:51:02'),
	(288, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:55:02', '2017-10-13 10:55:02'),
	(289, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:55:29', '2017-10-13 10:55:29'),
	(290, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 10:57:42', '2017-10-13 10:57:42'),
	(291, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 11:03:33', '2017-10-13 11:03:33'),
	(292, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 11:03:49', '2017-10-13 11:03:49'),
	(293, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 11:04:09', '2017-10-13 11:04:09'),
	(294, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 11:04:24', '2017-10-13 11:04:24'),
	(295, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 11:06:08', '2017-10-13 11:06:08'),
	(296, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create"}', '2017-10-13 11:06:15', '2017-10-13 11:06:15'),
	(297, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 11:06:50', '2017-10-13 11:06:50'),
	(298, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 11:06:52', '2017-10-13 11:06:52'),
	(299, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 11:09:10', '2017-10-13 11:09:10'),
	(300, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 11:09:12', '2017-10-13 11:09:12'),
	(301, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 11:21:45', '2017-10-13 11:21:45'),
	(302, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 11:21:47', '2017-10-13 11:21:47'),
	(303, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 11:25:54', '2017-10-13 11:25:54'),
	(304, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 11:25:56', '2017-10-13 11:25:56'),
	(305, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 11:35:07', '2017-10-13 11:35:07'),
	(306, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 11:37:02', '2017-10-13 11:37:02'),
	(307, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 11:37:08', '2017-10-13 11:37:08'),
	(308, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","id":null,"create_at":{"start":"2017-10-13 00:00:00","end":null},"_pjax":"#pjax-container"}', '2017-10-13 11:37:40', '2017-10-13 11:37:40'),
	(309, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","id":null,"create_at":{"start":"2017-10-13 00:00:00","end":null}}', '2017-10-13 11:37:56', '2017-10-13 11:37:56'),
	(310, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","create_at":{"start":"2017-10-13 00:00:00"},"id":null,"created_at":{"start":"2017-10-12 00:01:00","end":null},"_pjax":"#pjax-container"}', '2017-10-13 11:38:11', '2017-10-13 11:38:11'),
	(311, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","create_at":{"start":"2017-10-13 00:00:00"},"id":null,"created_at":{"start":"2017-10-12 00:01:00","end":null},"_pjax":"#pjax-container"}', '2017-10-13 11:38:15', '2017-10-13 11:38:15'),
	(312, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","create_at":{"start":"2017-10-13 00:00:00"},"_pjax":"#pjax-container"}', '2017-10-13 11:38:21', '2017-10-13 11:38:21'),
	(313, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 11:39:20', '2017-10-13 11:39:20'),
	(314, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 11:40:53', '2017-10-13 11:40:53'),
	(315, 1, 'admin/goods/index/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index\\/create","_pjax":"#pjax-container"}', '2017-10-13 11:40:55', '2017-10-13 11:40:55'),
	(316, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 12:51:03', '2017-10-13 12:51:03'),
	(317, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 12:51:06', '2017-10-13 12:51:06'),
	(318, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index"}', '2017-10-13 12:51:07', '2017-10-13 12:51:07'),
	(319, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 12:51:12', '2017-10-13 12:51:12'),
	(320, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 12:51:15', '2017-10-13 12:51:15'),
	(321, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 12:51:16', '2017-10-13 12:51:16'),
	(322, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 13:09:33', '2017-10-13 13:09:33'),
	(323, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 13:09:37', '2017-10-13 13:09:37'),
	(324, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 13:09:38', '2017-10-13 13:09:38'),
	(325, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 13:09:45', '2017-10-13 13:09:45'),
	(326, 1, 'admin/auth/menu/9/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/9\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:09:50', '2017-10-13 13:09:50'),
	(327, 1, 'admin/auth/menu/9', 'PUT', '127.0.0.1', '{"parent_id":"8","title":"\\u5a03\\u5a03\\u7ba1\\u7406","icon":"fa-female","uri":"goods","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/9"}', '2017-10-13 13:09:57', '2017-10-13 13:09:57'),
	(328, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 13:09:58', '2017-10-13 13:09:58'),
	(329, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 13:10:03', '2017-10-13 13:10:03'),
	(330, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 13:10:04', '2017-10-13 13:10:04'),
	(331, 1, 'admin/goods/index', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/index","_pjax":"#pjax-container"}', '2017-10-13 13:10:13', '2017-10-13 13:10:13'),
	(332, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 13:10:13', '2017-10-13 13:10:13'),
	(333, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 13:10:22', '2017-10-13 13:10:22'),
	(334, 1, 'admin/auth/menu/9/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/9\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:10:25', '2017-10-13 13:10:25'),
	(335, 1, 'admin/auth/menu/9', 'PUT', '127.0.0.1', '{"parent_id":"8","title":"\\u5a03\\u5a03\\u7ba1\\u7406","icon":"fa-female","uri":"goods\\/","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/9"}', '2017-10-13 13:10:32', '2017-10-13 13:10:32'),
	(336, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 13:10:33', '2017-10-13 13:10:33'),
	(337, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 13:10:42', '2017-10-13 13:10:42'),
	(338, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:10:47', '2017-10-13 13:10:47'),
	(339, 1, 'admin/goods/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/create","_pjax":"#pjax-container"}', '2017-10-13 13:10:54', '2017-10-13 13:10:54'),
	(340, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:11:35', '2017-10-13 13:11:35'),
	(341, 1, 'admin/goods/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/create","_pjax":"#pjax-container"}', '2017-10-13 13:11:38', '2017-10-13 13:11:38'),
	(342, 1, 'admin/goods', 'POST', '127.0.0.1', '{"name":"\\u661f\\u661f\\u5305","coin":"10","goods_cate_id":"1","tag_id":"1","status":"1","spec":"1","addtime":"2017-10-13 13:11:38","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/goods","_url":"\\/admin\\/goods"}', '2017-10-13 13:14:55', '2017-10-13 13:14:55'),
	(343, 1, 'admin/goods/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/create"}', '2017-10-13 13:14:58', '2017-10-13 13:14:58'),
	(344, 1, 'admin/goods', 'POST', '127.0.0.1', '{"name":"\\u661f\\u661f\\u5305","coin":"10","goods_cate_id":"1","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/goods"}', '2017-10-13 13:19:48', '2017-10-13 13:19:48'),
	(345, 1, 'admin/goods/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/create"}', '2017-10-13 13:19:50', '2017-10-13 13:19:50'),
	(346, 1, 'admin/goods', 'POST', '127.0.0.1', '{"name":"\\u661f\\u661f\\u5305","coin":"10","goods_cate_id":"1","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/goods"}', '2017-10-13 13:20:14', '2017-10-13 13:20:14'),
	(347, 1, 'admin/goods/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/create"}', '2017-10-13 13:20:17', '2017-10-13 13:20:17'),
	(348, 1, 'admin/goods', 'POST', '127.0.0.1', '{"name":"\\u661f\\u661f\\u5305","goods_cate_id":"1","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/goods"}', '2017-10-13 13:20:29', '2017-10-13 13:20:29'),
	(349, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods"}', '2017-10-13 13:20:29', '2017-10-13 13:20:29'),
	(350, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:21:16', '2017-10-13 13:21:16'),
	(351, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:21:19', '2017-10-13 13:21:19'),
	(352, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:21:22', '2017-10-13 13:21:22'),
	(353, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:22:50', '2017-10-13 13:22:50'),
	(354, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:23:05', '2017-10-13 13:23:05'),
	(355, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:23:08', '2017-10-13 13:23:08'),
	(356, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:23:35', '2017-10-13 13:23:35'),
	(357, 1, 'admin/goods/2/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/2\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:23:41', '2017-10-13 13:23:41'),
	(358, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:29:48', '2017-10-13 13:29:48'),
	(359, 1, 'admin/goods/1/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/1\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:29:52', '2017-10-13 13:29:52'),
	(360, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:29:56', '2017-10-13 13:29:56'),
	(361, 1, 'admin/goods/2/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/2\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:29:59', '2017-10-13 13:29:59'),
	(362, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:31:35', '2017-10-13 13:31:35'),
	(363, 1, 'admin/goods/5/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/5\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:31:38', '2017-10-13 13:31:38'),
	(364, 1, 'admin/goods/5/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/5\\/edit"}', '2017-10-13 13:32:19', '2017-10-13 13:32:19'),
	(365, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:32:24', '2017-10-13 13:32:24'),
	(366, 1, 'admin/goods/2/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/2\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:32:29', '2017-10-13 13:32:29'),
	(367, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:41:21', '2017-10-13 13:41:21'),
	(368, 1, 'admin/goods/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods\\/create","_pjax":"#pjax-container"}', '2017-10-13 13:41:24', '2017-10-13 13:41:24'),
	(369, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 13:41:34', '2017-10-13 13:41:34'),
	(370, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 13:55:50', '2017-10-13 13:55:50'),
	(371, 1, 'admin/auth/menu/9/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/9\\/edit","_pjax":"#pjax-container"}', '2017-10-13 13:55:56', '2017-10-13 13:55:56'),
	(372, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 14:12:14', '2017-10-13 14:12:14'),
	(373, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"8","title":"\\u5a03\\u5a03\\u673a\\u7ba1\\u7406","icon":"fa-bars","uri":"machine","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 14:12:45', '2017-10-13 14:12:45'),
	(374, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 14:12:46', '2017-10-13 14:12:46'),
	(375, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 14:14:15', '2017-10-13 14:14:15'),
	(376, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:14:21', '2017-10-13 14:14:21'),
	(377, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:18:00', '2017-10-13 14:18:00'),
	(378, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:18:31', '2017-10-13 14:18:31'),
	(379, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:19:58', '2017-10-13 14:19:58'),
	(380, 1, 'admin/machine/1/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/1\\/edit","_pjax":"#pjax-container"}', '2017-10-13 14:20:56', '2017-10-13 14:20:56'),
	(381, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:26:24', '2017-10-13 14:26:24'),
	(382, 1, 'admin/machine/1/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/1\\/edit","_pjax":"#pjax-container"}', '2017-10-13 14:26:34', '2017-10-13 14:26:34'),
	(383, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:34:44', '2017-10-13 14:34:44'),
	(384, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 14:34:51', '2017-10-13 14:34:51'),
	(385, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 14:34:55', '2017-10-13 14:34:55'),
	(386, 1, 'admin/auth/menu/10/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/10\\/edit","_pjax":"#pjax-container"}', '2017-10-13 14:34:58', '2017-10-13 14:34:58'),
	(387, 1, 'admin/auth/menu/10', 'PUT', '127.0.0.1', '{"parent_id":"8","title":"\\u5a03\\u5a03\\u673a\\u7ba1\\u7406","icon":"fa-simplybuilt","uri":"machine","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/10"}', '2017-10-13 14:37:36', '2017-10-13 14:37:36'),
	(388, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 14:37:37', '2017-10-13 14:37:37'),
	(389, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 14:38:01', '2017-10-13 14:38:01'),
	(390, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:38:06', '2017-10-13 14:38:06'),
	(391, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:38:12', '2017-10-13 14:38:12'),
	(392, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 14:39:14', '2017-10-13 14:39:14'),
	(393, 1, 'admin/auth/menu/9/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu\\/9\\/edit","_pjax":"#pjax-container"}', '2017-10-13 14:39:20', '2017-10-13 14:39:20'),
	(394, 1, 'admin/auth/menu/9', 'PUT', '127.0.0.1', '{"parent_id":"8","title":"\\u5a03\\u5a03\\u7ba1\\u7406","icon":"fa-shopping-basket","uri":"goods\\/","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/auth\\/menu","_url":"\\/admin\\/auth\\/menu\\/9"}', '2017-10-13 14:40:09', '2017-10-13 14:40:09'),
	(395, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 14:40:10', '2017-10-13 14:40:10'),
	(396, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 14:40:16', '2017-10-13 14:40:16'),
	(397, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:50:24', '2017-10-13 14:50:24'),
	(398, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:53:46', '2017-10-13 14:53:46'),
	(399, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:55:24', '2017-10-13 14:55:24'),
	(400, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:57:02', '2017-10-13 14:57:02'),
	(401, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:58:15', '2017-10-13 14:58:15'),
	(402, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:58:50', '2017-10-13 14:58:50'),
	(403, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 14:59:15', '2017-10-13 14:59:15'),
	(404, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine"}', '2017-10-13 14:59:20', '2017-10-13 14:59:20'),
	(405, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:00:30', '2017-10-13 15:00:30'),
	(406, 1, 'admin/machine/6/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/6\\/edit","_pjax":"#pjax-container"}', '2017-10-13 15:02:12', '2017-10-13 15:02:12'),
	(407, 1, 'admin/machine/6', 'PUT', '127.0.0.1', '{"cate_name":"\\u6d77\\u7ef5\\u661f","spec":"30","coin":"20","tag_id":"1","win_rate":"7","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/machine","_url":"\\/admin\\/machine\\/6"}', '2017-10-13 15:02:22', '2017-10-13 15:02:22'),
	(408, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine"}', '2017-10-13 15:02:22', '2017-10-13 15:02:22'),
	(409, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:02:50', '2017-10-13 15:02:50'),
	(410, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 15:04:24', '2017-10-13 15:04:24'),
	(411, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:04:35', '2017-10-13 15:04:35'),
	(412, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-13 15:04:47', '2017-10-13 15:04:47'),
	(413, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 15:04:50', '2017-10-13 15:04:50'),
	(414, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-13 15:05:22', '2017-10-13 15:05:22'),
	(415, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-13 15:05:24', '2017-10-13 15:05:24'),
	(416, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-13 15:05:25', '2017-10-13 15:05:25'),
	(417, 1, 'admin/auth/users', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/users","_pjax":"#pjax-container"}', '2017-10-13 15:05:27', '2017-10-13 15:05:27'),
	(418, 1, 'admin/auth/roles', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/roles","_pjax":"#pjax-container"}', '2017-10-13 15:05:29', '2017-10-13 15:05:29'),
	(419, 1, 'admin/auth/permissions', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/permissions","_pjax":"#pjax-container"}', '2017-10-13 15:05:32', '2017-10-13 15:05:32'),
	(420, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 15:05:33', '2017-10-13 15:05:33'),
	(421, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:05:47', '2017-10-13 15:05:47'),
	(422, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 15:07:43', '2017-10-13 15:07:43'),
	(423, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:07:54', '2017-10-13 15:07:54'),
	(424, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 15:08:04', '2017-10-13 15:08:04'),
	(425, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:08:45', '2017-10-13 15:08:45'),
	(426, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 15:08:51', '2017-10-13 15:08:51'),
	(427, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:09:47', '2017-10-13 15:09:47'),
	(428, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 15:09:50', '2017-10-13 15:09:50'),
	(429, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:10:10', '2017-10-13 15:10:10'),
	(430, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 15:10:13', '2017-10-13 15:10:13'),
	(431, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:10:25', '2017-10-13 15:10:25'),
	(432, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 15:10:28', '2017-10-13 15:10:28'),
	(433, 1, 'admin/machine', 'POST', '127.0.0.1', '{"cate_name":"\\u9cc4\\u9c7c\\u5b9d\\u5b9d","spec":"30","coin":"20","tag_id":"1","win_rate":"10","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/machine","_url":"\\/admin\\/machine"}', '2017-10-13 15:11:00', '2017-10-13 15:11:00'),
	(434, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create"}', '2017-10-13 15:11:02', '2017-10-13 15:11:02'),
	(435, 1, 'admin/machine', 'POST', '127.0.0.1', '{"cate_name":"\\u9cc4\\u9c7c\\u5b9d\\u5b9d","spec":"30","coin":"20","tag_id":"1","win_rate":"9","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/machine"}', '2017-10-13 15:11:26', '2017-10-13 15:11:26'),
	(436, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create"}', '2017-10-13 15:11:28', '2017-10-13 15:11:28'),
	(437, 1, 'admin/machine', 'POST', '127.0.0.1', '{"cate_name":"\\u9cc4\\u9c7c\\u5b9d\\u5b9d","spec":"30","coin":"20","tag_id":"1","win_rate":"9","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/machine"}', '2017-10-13 15:11:59', '2017-10-13 15:11:59'),
	(438, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine"}', '2017-10-13 15:12:00', '2017-10-13 15:12:00'),
	(439, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 15:12:09', '2017-10-13 15:12:09'),
	(440, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container","_sort":{"column":"id","type":"desc"}}', '2017-10-13 15:12:36', '2017-10-13 15:12:36'),
	(441, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container","_sort":{"column":"id","type":"asc"}}', '2017-10-13 15:12:39', '2017-10-13 15:12:39'),
	(442, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-13 15:13:06', '2017-10-13 15:13:06'),
	(443, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 15:13:19', '2017-10-13 15:13:19'),
	(444, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"8","title":"\\u6807\\u7b7e","icon":"fa-tags","uri":"tags","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:14:10', '2017-10-13 15:14:10'),
	(445, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:14:10', '2017-10-13 15:14:10'),
	(446, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:22:06', '2017-10-13 15:22:06'),
	(447, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:23:06', '2017-10-13 15:23:06'),
	(448, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:23:08', '2017-10-13 15:23:08'),
	(449, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:24:31', '2017-10-13 15:24:31'),
	(450, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:24:35', '2017-10-13 15:24:35'),
	(451, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:24:36', '2017-10-13 15:24:36'),
	(452, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:26:51', '2017-10-13 15:26:51'),
	(453, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:28:12', '2017-10-13 15:28:12'),
	(454, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:28:13', '2017-10-13 15:28:13'),
	(455, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:29:15', '2017-10-13 15:29:15'),
	(456, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:29:18', '2017-10-13 15:29:18'),
	(457, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:29:20', '2017-10-13 15:29:20'),
	(458, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:31:03', '2017-10-13 15:31:03'),
	(459, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:31:20', '2017-10-13 15:31:20'),
	(460, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:31:22', '2017-10-13 15:31:22'),
	(461, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:31:52', '2017-10-13 15:31:52'),
	(462, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:31:54', '2017-10-13 15:31:54'),
	(463, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:39:05', '2017-10-13 15:39:05'),
	(464, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:39:10', '2017-10-13 15:39:10'),
	(465, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:39:11', '2017-10-13 15:39:11'),
	(466, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:39:41', '2017-10-13 15:39:41'),
	(467, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:39:45', '2017-10-13 15:39:45'),
	(468, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:39:47', '2017-10-13 15:39:47'),
	(469, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:40:05', '2017-10-13 15:40:05'),
	(470, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:40:06', '2017-10-13 15:40:06'),
	(471, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:40:18', '2017-10-13 15:40:18'),
	(472, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:40:19', '2017-10-13 15:40:19'),
	(473, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:40:56', '2017-10-13 15:40:56'),
	(474, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 15:40:57', '2017-10-13 15:40:57'),
	(475, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:41:33', '2017-10-13 15:41:33'),
	(476, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:43:51', '2017-10-13 15:43:51'),
	(477, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:47:35', '2017-10-13 15:47:35'),
	(478, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:48:27', '2017-10-13 15:48:27'),
	(479, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:49:24', '2017-10-13 15:49:24'),
	(480, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:54:52', '2017-10-13 15:54:52'),
	(481, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:55:20', '2017-10-13 15:55:20'),
	(482, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:55:38', '2017-10-13 15:55:38'),
	(483, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:55:50', '2017-10-13 15:55:50'),
	(484, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:56:34', '2017-10-13 15:56:34'),
	(485, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:56:44', '2017-10-13 15:56:44'),
	(486, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:57:07', '2017-10-13 15:57:07'),
	(487, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 15:57:17', '2017-10-13 15:57:17'),
	(488, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 15:59:00', '2017-10-13 15:59:00'),
	(489, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 15:59:48', '2017-10-13 15:59:48'),
	(490, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:02:44', '2017-10-13 16:02:44'),
	(491, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create"}', '2017-10-13 16:04:40', '2017-10-13 16:04:40'),
	(492, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:04:46', '2017-10-13 16:04:46'),
	(493, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 16:09:56', '2017-10-13 16:09:56'),
	(494, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:10:00', '2017-10-13 16:10:00'),
	(495, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 16:10:02', '2017-10-13 16:10:02'),
	(496, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 16:10:54', '2017-10-13 16:10:54'),
	(497, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:10:57', '2017-10-13 16:10:57'),
	(498, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 16:10:59', '2017-10-13 16:10:59'),
	(499, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:11:31', '2017-10-13 16:11:31'),
	(500, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 16:11:33', '2017-10-13 16:11:33'),
	(501, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:12:44', '2017-10-13 16:12:44'),
	(502, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:13:09', '2017-10-13 16:13:09'),
	(503, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:13:55', '2017-10-13 16:13:55'),
	(504, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/"}', '2017-10-13 16:15:16', '2017-10-13 16:15:16'),
	(505, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:15:20', '2017-10-13 16:15:20'),
	(506, 1, 'admin/tags', 'POST', '127.0.0.1', '{"name":null,"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/tags"}', '2017-10-13 16:15:24', '2017-10-13 16:15:24'),
	(507, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:15:26', '2017-10-13 16:15:26'),
	(508, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:24:06', '2017-10-13 16:24:06'),
	(509, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:27:37', '2017-10-13 16:27:37'),
	(510, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:32:01', '2017-10-13 16:32:01'),
	(511, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-13 16:33:34', '2017-10-13 16:33:34'),
	(512, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:33:38', '2017-10-13 16:33:38'),
	(513, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 16:38:26', '2017-10-13 16:38:26'),
	(514, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":null,"icon":"fa-bars","uri":null,"roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 16:38:29', '2017-10-13 16:38:29'),
	(515, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 16:38:30', '2017-10-13 16:38:30'),
	(516, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":null,"icon":"fa-bars","uri":null,"roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 16:38:38', '2017-10-13 16:38:38'),
	(517, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 16:38:39', '2017-10-13 16:38:39'),
	(518, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:39:54', '2017-10-13 16:39:54'),
	(519, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-13 16:40:38', '2017-10-13 16:40:38'),
	(520, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:40:41', '2017-10-13 16:40:41'),
	(521, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:40:51', '2017-10-13 16:40:51'),
	(522, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create","_pjax":"#pjax-container"}', '2017-10-13 16:40:54', '2017-10-13 16:40:54'),
	(523, 1, 'admin/tags', 'POST', '127.0.0.1', '{"tag_name":null,"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/tags","_url":"\\/admin\\/tags"}', '2017-10-13 16:40:58', '2017-10-13 16:40:58'),
	(524, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create"}', '2017-10-13 16:40:58', '2017-10-13 16:40:58'),
	(525, 1, 'admin/tags', 'POST', '127.0.0.1', '{"tag_name":null,"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/tags"}', '2017-10-13 16:46:02', '2017-10-13 16:46:02'),
	(526, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create"}', '2017-10-13 16:46:03', '2017-10-13 16:46:03'),
	(527, 1, 'admin/tags', 'POST', '127.0.0.1', '{"tag_name":null,"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/tags"}', '2017-10-13 16:49:35', '2017-10-13 16:49:35'),
	(528, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create"}', '2017-10-13 16:49:36', '2017-10-13 16:49:36'),
	(529, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create","_pjax":"#pjax-container"}', '2017-10-13 16:52:46', '2017-10-13 16:52:46'),
	(530, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create","_pjax":"#pjax-container"}', '2017-10-13 16:52:49', '2017-10-13 16:52:49'),
	(531, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create","_pjax":"#pjax-container"}', '2017-10-13 16:52:50', '2017-10-13 16:52:50'),
	(532, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 16:52:54', '2017-10-13 16:52:54'),
	(533, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:54:35', '2017-10-13 16:54:35'),
	(534, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:55:12', '2017-10-13 16:55:12'),
	(535, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 16:55:36', '2017-10-13 16:55:36'),
	(536, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create","_pjax":"#pjax-container"}', '2017-10-13 16:59:45', '2017-10-13 16:59:45'),
	(537, 1, 'admin/tags', 'POST', '127.0.0.1', '{"tag_name":"\\u6700\\u70ed","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/tags","_url":"\\/admin\\/tags"}', '2017-10-13 17:00:04', '2017-10-13 17:00:04'),
	(538, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create"}', '2017-10-13 17:00:06', '2017-10-13 17:00:06'),
	(539, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-13 17:01:19', '2017-10-13 17:01:19'),
	(540, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin"}', '2017-10-13 17:01:26', '2017-10-13 17:01:26'),
	(541, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags","_pjax":"#pjax-container"}', '2017-10-13 17:01:29', '2017-10-13 17:01:29'),
	(542, 1, 'admin/tags/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/create","_pjax":"#pjax-container"}', '2017-10-13 17:01:33', '2017-10-13 17:01:33'),
	(543, 1, 'admin/tags', 'POST', '127.0.0.1', '{"tag_name":"\\u6700\\u70ed","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/tags","_url":"\\/admin\\/tags"}', '2017-10-13 17:01:45', '2017-10-13 17:01:45'),
	(544, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 17:01:46', '2017-10-13 17:01:46'),
	(545, 1, 'admin/tags/2/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags\\/2\\/edit","_pjax":"#pjax-container"}', '2017-10-13 17:06:08', '2017-10-13 17:06:08'),
	(546, 1, 'admin/tags/2', 'PUT', '127.0.0.1', '{"tag_name":"\\u6700\\u70ed\\u6b3e","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/tags","_url":"\\/admin\\/tags\\/2"}', '2017-10-13 17:06:22', '2017-10-13 17:06:22'),
	(547, 1, 'admin/tags', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/tags"}', '2017-10-13 17:06:22', '2017-10-13 17:06:22'),
	(548, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 17:07:17', '2017-10-13 17:07:17'),
	(549, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 17:07:20', '2017-10-13 17:07:20'),
	(550, 1, 'admin/machine', 'POST', '127.0.0.1', '{"cate_name":null,"spec":"0","coin":"0","tag_id":"2","win_rate":"0","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/machine","_url":"\\/admin\\/machine"}', '2017-10-13 17:07:40', '2017-10-13 17:07:40'),
	(551, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create"}', '2017-10-13 17:07:42', '2017-10-13 17:07:42'),
	(552, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create"}', '2017-10-13 17:08:42', '2017-10-13 17:08:42'),
	(553, 1, 'admin/machine', 'POST', '127.0.0.1', '{"cate_name":null,"spec":"0","coin":"0","tag_id":"1","win_rate":"0","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/machine"}', '2017-10-13 17:08:46', '2017-10-13 17:08:46'),
	(554, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create"}', '2017-10-13 17:08:46', '2017-10-13 17:08:46'),
	(555, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 17:14:49', '2017-10-13 17:14:49'),
	(556, 1, 'admin/machine/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine\\/create","_pjax":"#pjax-container"}', '2017-10-13 17:14:51', '2017-10-13 17:14:51'),
	(557, 1, 'admin/machine', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/machine","_pjax":"#pjax-container"}', '2017-10-13 17:14:52', '2017-10-13 17:14:52'),
	(558, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods","_pjax":"#pjax-container"}', '2017-10-13 17:15:16', '2017-10-13 17:15:16'),
	(559, 1, 'admin/goods', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/goods"}', '2017-10-13 17:15:44', '2017-10-13 17:15:44'),
	(560, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 17:18:49', '2017-10-13 17:18:49'),
	(561, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"0","title":"\\u516c\\u544a\\/\\u6d3b\\u52a8","icon":"fa-bullhorn","uri":null,"roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:20:24', '2017-10-13 17:20:24'),
	(562, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:20:25', '2017-10-13 17:20:25'),
	(563, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"12","title":"\\u516c\\u544a\\u7ba1\\u7406","icon":"fa-copy","uri":"notice","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:21:29', '2017-10-13 17:21:29'),
	(564, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:21:30', '2017-10-13 17:21:30'),
	(565, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:21:35', '2017-10-13 17:21:35'),
	(566, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice"}', '2017-10-13 17:32:51', '2017-10-13 17:32:51'),
	(567, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice"}', '2017-10-13 17:33:08', '2017-10-13 17:33:08'),
	(568, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice"}', '2017-10-13 17:33:29', '2017-10-13 17:33:29'),
	(569, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice"}', '2017-10-13 17:34:19', '2017-10-13 17:34:19'),
	(570, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice"}', '2017-10-13 17:34:35', '2017-10-13 17:34:35'),
	(571, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice"}', '2017-10-13 17:35:12', '2017-10-13 17:35:12'),
	(572, 1, 'admin/notice/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice\\/create","_pjax":"#pjax-container"}', '2017-10-13 17:35:18', '2017-10-13 17:35:18'),
	(573, 1, 'admin/notice/create', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice\\/create"}', '2017-10-13 17:38:14', '2017-10-13 17:38:14'),
	(574, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice","_pjax":"#pjax-container"}', '2017-10-13 17:38:17', '2017-10-13 17:38:17'),
	(575, 1, 'admin/notice/1/edit', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice\\/1\\/edit","_pjax":"#pjax-container"}', '2017-10-13 17:38:26', '2017-10-13 17:38:26'),
	(576, 1, 'admin/notice/1', 'PUT', '127.0.0.1', '{"title":"\\u6d4b\\u8bd5\\u7528\\u7684","contents":"\\u6d4b\\u8bd5\\u6d4b\\u8bd5","_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_method":"PUT","_previous_":"http:\\/\\/www.pocketdoll.cp\\/admin\\/notice","_url":"\\/admin\\/notice\\/1"}', '2017-10-13 17:38:42', '2017-10-13 17:38:42'),
	(577, 1, 'admin/notice', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/notice"}', '2017-10-13 17:38:43', '2017-10-13 17:38:43'),
	(578, 1, 'admin', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/","_pjax":"#pjax-container"}', '2017-10-13 17:39:19', '2017-10-13 17:39:19'),
	(579, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu","_pjax":"#pjax-container"}', '2017-10-13 17:39:22', '2017-10-13 17:39:22'),
	(580, 1, 'admin/auth/menu', 'POST', '127.0.0.1', '{"parent_id":"12","title":"\\u73a9\\u5bb6\\u79c0","icon":"fa-star-o","uri":"usershow","roles":[null],"_token":"uL9gWMh1mOgu9w48F87f0ROopQujFTPIuw8rmPfp","_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:41:04', '2017-10-13 17:41:04'),
	(581, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:41:05', '2017-10-13 17:41:05'),
	(582, 1, 'admin/auth/menu', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/auth\\/menu"}', '2017-10-13 17:54:58', '2017-10-13 17:54:58'),
	(583, 1, 'admin/usershow', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/usershow"}', '2017-10-13 17:55:28', '2017-10-13 17:55:28'),
	(584, 1, 'admin/usershow', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/usershow"}', '2017-10-13 17:57:51', '2017-10-13 17:57:51'),
	(585, 1, 'admin/usershow', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/usershow"}', '2017-10-13 18:09:55', '2017-10-13 18:09:55'),
	(586, 1, 'admin/usershow', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/usershow"}', '2017-10-13 18:11:07', '2017-10-13 18:11:07'),
	(587, 1, 'admin/usershow', 'GET', '127.0.0.1', '{"_url":"\\/admin\\/usershow"}', '2017-10-13 18:24:58', '2017-10-13 18:24:58');
/*!40000 ALTER TABLE `admin_operation_log` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_permissions 结构
CREATE TABLE IF NOT EXISTS `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_permissions 的数据：5 rows
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`) VALUES
	(1, 'All permission', '*', '', '*', NULL, NULL),
	(2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL),
	(3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL),
	(4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL),
	(5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_roles 结构
CREATE TABLE IF NOT EXISTS `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_roles 的数据：1 rows
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'administrator', '2017-10-12 10:58:48', '2017-10-12 10:58:48');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_role_menu 结构
CREATE TABLE IF NOT EXISTS `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_role_menu 的数据：1 rows
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`) VALUES
	(1, 2, NULL, NULL);
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_role_permissions 结构
CREATE TABLE IF NOT EXISTS `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_role_permissions 的数据：1 rows
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL);
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_role_users 结构
CREATE TABLE IF NOT EXISTS `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_role_users 的数据：1 rows
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL);
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_users 结构
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_users 的数据：1 rows
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', '$2y$10$tFQtJ47J23eN9qZFRGzO0uq03K0nZkHTUwPV1SgTdx5xHwtgxbKcW', 'Administrator', NULL, 'OMcjY6TT9uvnbktcPh2nsfOJO35pX5ky8a1E0Ull1yugXHc4CYiYICOWgeyW', '2017-10-12 10:58:48', '2017-10-12 10:58:48');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;

-- 导出  表 pocketdoll.admin_user_permissions 结构
CREATE TABLE IF NOT EXISTS `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.admin_user_permissions 的数据：0 rows
/*!40000 ALTER TABLE `admin_user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_permissions` ENABLE KEYS */;

-- 导出  表 pocketdoll.awards 结构
CREATE TABLE IF NOT EXISTS `awards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '奖励项id',
  `contents` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '奖励内容',
  `award_coin` int(11) NOT NULL COMMENT '奖励的金币',
  `award_point` int(11) NOT NULL COMMENT '奖励的积分',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.awards 的数据：1 rows
/*!40000 ALTER TABLE `awards` DISABLE KEYS */;
INSERT INTO `awards` (`id`, `contents`, `award_coin`, `award_point`, `created_at`, `updated_at`) VALUES
	(1, '奖励10金币 5积分', 10, 5, NULL, NULL);
/*!40000 ALTER TABLE `awards` ENABLE KEYS */;

-- 导出  表 pocketdoll.goods 结构
CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '娃娃id',
  `goods_cate_id` int(11) NOT NULL COMMENT '娃娃种类',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '娃娃名称',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '娃娃图片',
  `status` enum('0','1','-1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '娃娃的状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.goods 的数据：5 rows
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` (`id`, `goods_cate_id`, `name`, `pic`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, '派大星', '', '0', '2017-10-06 11:24:04', '2017-10-06 11:24:04'),
	(2, 9, '哈密瓜', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '0', '2017-10-06 11:24:26', '2017-10-06 12:08:30'),
	(3, 1, '派大星', '', '-1', '2017-10-06 12:10:49', '2017-10-06 12:13:52'),
	(4, 1, '派大星', 'D:\\Project\\PocketDoll\\storage\\image/C8gh9Ew9HLWqLEuhdVhnEhbC3y82fSjeUsb2wEsJ.jpeg', '0', '2017-10-06 12:11:15', '2017-10-06 12:11:15'),
	(5, 1, '星星包', 'images/36b6a0b291fa8b2bdb67bad75429cc72.jpg', '0', '2017-10-13 13:20:29', '2017-10-13 13:20:29');
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;

-- 导出  表 pocketdoll.goods_category 结构
CREATE TABLE IF NOT EXISTS `goods_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '类别id',
  `cate_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '类别名称',
  `win_rate` double(6,5) NOT NULL COMMENT '赢得比例',
  `spec` int(10) NOT NULL COMMENT '娃娃规格',
  `tag_id` int(10) NOT NULL COMMENT '标签id',
  `coin` int(10) NOT NULL COMMENT '金币',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '对应图片',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.goods_category 的数据：10 rows
/*!40000 ALTER TABLE `goods_category` DISABLE KEYS */;
INSERT INTO `goods_category` (`id`, `cate_name`, `win_rate`, `spec`, `tag_id`, `coin`, `pic`, `created_at`, `updated_at`) VALUES
	(1, '海绵宝宝与派大星', 0.00100, 30, 1, 20, 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-07 11:28:04', '2017-10-07 11:28:04'),
	(2, '海绵宝宝与派大星', 1.00000, 30, 1, 20, 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-07 11:29:13', '2017-10-07 11:29:13'),
	(3, '海绵宝宝与派大星', 2.00000, 30, 1, 20, 'D:\\Project\\PocketDoll\\storage\\image/HMZL2ntIComIyMI9DYDTwg5HMCmCD2bTVbcpnW4D.jpeg', '2017-10-07 11:29:24', '2017-10-07 11:29:24'),
	(4, '海绵宝宝与派大星', 5.00000, 30, 1, 20, 'D:\\Project\\PocketDoll\\storage\\image/TA4aOJsRUaYXGOPas5b4NevE4QAirBmWKCTwoy1m.jpeg', '2017-10-07 11:29:31', '2017-10-07 11:29:31'),
	(5, '海绵宝宝与派大星', 6.00000, 30, 1, 20, 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-07 11:29:37', '2017-10-07 11:29:37'),
	(6, '海绵星', 7.00000, 30, 1, 20, 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-07 11:29:41', '2017-10-13 15:02:22'),
	(10, '鳄鱼宝宝', 9.00000, 30, 1, 20, 'images/4496503d44e6ddd57b978a3e8c0b60a3.jpg', '2017-10-13 15:11:59', '2017-10-13 15:11:59'),
	(7, '海绵宝宝与派大星', 8.00000, 30, 1, 20, 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-07 11:29:50', '2017-10-07 11:29:50'),
	(8, '海绵宝宝与派大星', 9.00000, 30, 1, 20, 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-07 11:29:56', '2017-10-07 11:29:56'),
	(9, '海盗船长', 9.00000, 30, 1, 20, 'images/X6U3LcXxVphDDrfOU4uZSFj7xJGH1wxRLilpVRij.jpeg', '2017-10-07 11:31:40', '2017-10-07 11:31:40');
/*!40000 ALTER TABLE `goods_category` ENABLE KEYS */;

-- 导出  表 pocketdoll.goods_tags_cate 结构
CREATE TABLE IF NOT EXISTS `goods_tags_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签id',
  `tag_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标签名称',
  `tag_icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标签图片',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.goods_tags_cate 的数据：2 rows
/*!40000 ALTER TABLE `goods_tags_cate` DISABLE KEYS */;
INSERT INTO `goods_tags_cate` (`id`, `tag_name`, `tag_icon`, `created_at`, `updated_at`) VALUES
	(1, '八折', 'images/36b6a0b291fa8b2bdb67bad75429cc72.jpg', '2017-10-13 14:53:37', '2017-10-13 14:53:39'),
	(2, '最热款', 'images/e2ad36f20759ffa34e0459fd93b553f8.jpg', '2017-10-13 17:01:45', '2017-10-13 17:06:22');
/*!40000 ALTER TABLE `goods_tags_cate` ENABLE KEYS */;

-- 导出  表 pocketdoll.migrations 结构
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.migrations 的数据：20 rows
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2017_10_02_021330_create_notice_table', 1),
	(2, '2017_10_02_022835_create_awards_table', 1),
	(3, '2017_10_02_023511_create_signin_table', 1),
	(4, '2017_10_02_023947_create_goods_table', 1),
	(5, '2017_10_02_025801_create_goods_category_table', 1),
	(6, '2017_10_02_030325_create_goods_tag_table', 1),
	(7, '2017_10_02_030656_create_user_table', 1),
	(8, '2017_10_02_031609_create_recharge_log_table', 1),
	(9, '2017_10_02_032441_create_recharge_amount_table', 1),
	(10, '2017_10_02_033945_create_mission_table', 1),
	(11, '2017_10_02_035329_create_user_mission_table', 1),
	(12, '2017_10_02_040118_create_user_rucksack_table', 1),
	(13, '2017_10_02_040942_create_user_show_table', 1),
	(14, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
	(15, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
	(16, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
	(17, '2016_06_01_000004_create_oauth_clients_table', 2),
	(18, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2),
	(19, '2017_10_10_182904_create_mission_type_table', 3),
	(20, '2016_01_04_173148_create_admin_tables', 4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- 导出  表 pocketdoll.mission 结构
CREATE TABLE IF NOT EXISTS `mission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '任务id',
  `contents` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '任务内容',
  `award_id` int(11) NOT NULL COMMENT '奖励id',
  `type` int(11) NOT NULL COMMENT '任务种类',
  `need_num` int(11) NOT NULL COMMENT '需要完成次数或天数',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '完成状态',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '任务图标',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.mission 的数据：4 rows
/*!40000 ALTER TABLE `mission` DISABLE KEYS */;
INSERT INTO `mission` (`id`, `contents`, `award_id`, `type`, `need_num`, `status`, `icon`, `created_at`, `updated_at`) VALUES
	(2, '抓 5 次娃娃', 1, 1, 5, '0', 'D:\\Project\\PocketDoll\\storage\\image/3pcFMfANa9gQ5vj7w1kxJ589cVtz8QyiQrWaFw3j.jpeg', '2017-10-11 11:29:53', '2017-10-11 13:58:27'),
	(3, '抓 2 次娃娃', 1, 2, 2, '0', '', '2017-10-11 14:31:12', '2017-10-11 14:31:12'),
	(4, '抓 2 次娃娃', 1, 3, 2, '0', '', '2017-10-11 14:31:41', '2017-10-11 14:31:41'),
	(5, '抓 10 次娃娃', 1, 1, 10, '0', '', '2017-10-11 14:41:41', '2017-10-11 14:41:41');
/*!40000 ALTER TABLE `mission` ENABLE KEYS */;

-- 导出  表 pocketdoll.mission_type 结构
CREATE TABLE IF NOT EXISTS `mission_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '任务系列id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '任务系列名称',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.mission_type 的数据：3 rows
/*!40000 ALTER TABLE `mission_type` DISABLE KEYS */;
INSERT INTO `mission_type` (`id`, `title`, `created_at`, `updated_at`) VALUES
	(1, '充值系列', NULL, NULL),
	(2, '抓取任务', '2017-10-11 14:13:23', '2017-10-11 14:13:23'),
	(3, '邀请任务', '2017-10-11 14:36:29', '2017-10-11 14:36:29');
/*!40000 ALTER TABLE `mission_type` ENABLE KEYS */;

-- 导出  表 pocketdoll.notice 结构
CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '公告id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公告标题',
  `contents` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公告内容',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '对应图片',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
  `status` enum('1','-1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公告状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.notice 的数据：11 rows
/*!40000 ALTER TABLE `notice` DISABLE KEYS */;
INSERT INTO `notice` (`id`, `title`, `contents`, `pic`, `addtime`, `status`, `created_at`, `updated_at`) VALUES
	(1, '测试用的', '测试测试', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:38:42', '1', '2017-10-13 17:34:58', '2017-10-13 17:38:42'),
	(2, '测试', '1233', 'asdsadsadasdimages/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:35:02', '1', '2017-10-13 17:34:59', '2017-10-13 17:35:02'),
	(5, '娃娃上新公告', '一批新娃娃商家啦', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:35:03', '1', '2017-10-13 17:34:56', '2017-10-13 17:35:03'),
	(4, '修改', '修改的内容', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:34:56', '1', '2017-10-13 17:34:56', '2017-10-02 17:37:50'),
	(6, '娃娃上新公告', '一批新娃娃商家啦', 'public/image/hyl4towvvMTYIA5buc4y0Ad3lGDex9nY1WU7Zkt9.jpeg', '2017-10-13 17:35:04', '1', '2017-10-13 17:34:53', '2017-10-13 17:35:04'),
	(7, '娃娃上新公告', '一批新娃娃商家啦', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:35:05', '1', '2017-10-13 17:34:55', '2017-10-13 17:35:05'),
	(8, '娃娃上新公告', '一批新娃娃商家啦', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:35:05', '1', '2017-10-13 17:34:54', '2017-10-13 17:35:05'),
	(9, '娃娃上新公告', '一批新娃娃商家啦', 'D:\\Project\\PocketDoll\\storage\\image/NGSYyZITBZsEXNFldM1hT1OJ8gqgLF9donrUE2FZ.jpeg', '2017-10-13 17:35:07', '1', '2017-10-13 17:34:52', '2017-10-13 17:35:06'),
	(10, '娃娃上新公告', '一批新娃娃商家啦', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:35:06', '1', '2017-10-13 17:34:51', '2017-10-13 17:35:06'),
	(11, '娃娃上新公告', '一批新娃娃商家啦', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:34:13', '1', '2017-10-06 11:33:47', '2017-10-06 11:33:47'),
	(12, '娃娃上新公告', '一批新娃娃商家啦', 'images/6de1d441e41d488279b8625cd5de57f3.jpg', '2017-10-13 17:34:12', '1', '2017-10-06 11:35:03', '2017-10-06 11:35:03');
/*!40000 ALTER TABLE `notice` ENABLE KEYS */;

-- 导出  表 pocketdoll.oauth_access_tokens 结构
CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.oauth_access_tokens 的数据：0 rows
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;

-- 导出  表 pocketdoll.oauth_auth_codes 结构
CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.oauth_auth_codes 的数据：0 rows
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;

-- 导出  表 pocketdoll.oauth_clients 结构
CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.oauth_clients 的数据：2 rows
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'Laravel Personal Access Client', 'CQfvgMttaT4aGIWScGOF0JCbwJqkU2b2FjnRSlAx', 'http://localhost', 1, 0, 0, '2017-10-07 13:56:01', '2017-10-07 13:56:01'),
	(2, NULL, 'Laravel Password Grant Client', 'weHZGyxvYo6faKUztcd4EF2RVriS1A6VtJsDQjSQ', 'http://localhost', 0, 1, 0, '2017-10-07 13:56:01', '2017-10-07 13:56:01');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;

-- 导出  表 pocketdoll.oauth_personal_access_clients 结构
CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.oauth_personal_access_clients 的数据：1 rows
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2017-10-07 13:56:01', '2017-10-07 13:56:01');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;

-- 导出  表 pocketdoll.oauth_refresh_tokens 结构
CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.oauth_refresh_tokens 的数据：0 rows
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;

-- 导出  表 pocketdoll.recharge_amount 结构
CREATE TABLE IF NOT EXISTS `recharge_amount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '充值额度id',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '充值额度的名称',
  `coin_num` int(11) NOT NULL COMMENT '额度数量',
  `award_num` int(11) NOT NULL COMMENT '奖励金币数量',
  `price` double(10,2) NOT NULL COMMENT '对应金额',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.recharge_amount 的数据：4 rows
/*!40000 ALTER TABLE `recharge_amount` DISABLE KEYS */;
INSERT INTO `recharge_amount` (`id`, `title`, `coin_num`, `award_num`, `price`, `pic`, `created_at`, `updated_at`) VALUES
	(1, '充值100', 100, 10, 10.00, '', '2017-10-06 15:41:32', '2017-10-06 15:41:32'),
	(3, '充值80', 80, 8, 8.80, '', '2017-10-06 15:56:56', '2017-10-06 15:56:56'),
	(4, '充值88', 88, 8, 8.80, 'D:\\Project\\PocketDoll\\storage\\image/XAj8LPnelMhXKrrQfm2ttJD6EJYAcLVnRg3RumQX.jpeg', '2017-10-06 16:01:03', '2017-10-06 16:24:06'),
	(5, '充值80', 80, 8, 8.80, 'D:\\Project\\PocketDoll\\storage\\image/CAHX7QuSIQGx0rjUfTJ9hGqmupxzx0DKGkKLmqga.jpeg', '2017-10-06 16:09:16', '2017-10-06 16:09:16');
/*!40000 ALTER TABLE `recharge_amount` ENABLE KEYS */;

-- 导出  表 pocketdoll.recharge_log 结构
CREATE TABLE IF NOT EXISTS `recharge_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `pay` double(10,2) NOT NULL,
  `coin` int(11) NOT NULL COMMENT '充值额度id',
  `status` enum('1','-1','-99') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-1' COMMENT '支付状态',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '充值时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.recharge_log 的数据：0 rows
/*!40000 ALTER TABLE `recharge_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `recharge_log` ENABLE KEYS */;

-- 导出  表 pocketdoll.signin 结构
CREATE TABLE IF NOT EXISTS `signin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '签到id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `sign_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '签到时间',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '签到状态',
  `sign_day_num` int(11) NOT NULL COMMENT '签到天数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.signin 的数据：0 rows
/*!40000 ALTER TABLE `signin` DISABLE KEYS */;
/*!40000 ALTER TABLE `signin` ENABLE KEYS */;

-- 导出  表 pocketdoll.user 结构
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `openid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户openid',
  `coin` int(11) NOT NULL COMMENT '用户持有的金币数量',
  `point` int(11) NOT NULL COMMENT '用户积分',
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '登录时间',
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户昵称',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户头像',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.user 的数据：2 rows
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `openid`, `coin`, `point`, `login_time`, `nickname`, `icon`, `created_at`, `updated_at`) VALUES
	(1, 'asddefasfasdefafsafaf', 380, 5, '2017-10-10 16:54:57', 'dwdasd', 'wdsadw', '0000-00-00 00:00:00', '2017-10-10 16:54:57'),
	(2, 'odh7zsgI75iT8FRh0fGlSojc9PWM', 0, 0, '2017-10-10 16:56:06', 'overtrue', 'http://wx.qlogo.cn/mmopen/C2rEUskXQiblFYMUl9O0G05Q6pKibg7V1WpHX6CIQaic824apriabJw4r6EWxziaSt5BATrlbx1GVzwW2qjUCqtYpDvIJLjKgP1ug/0', '2017-10-09 11:51:14', '2017-10-10 16:56:06');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- 导出  表 pocketdoll.user_mission 结构
CREATE TABLE IF NOT EXISTS `user_mission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '关联表id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `mission_id` int(11) NOT NULL COMMENT '任务id',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.user_mission 的数据：0 rows
/*!40000 ALTER TABLE `user_mission` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_mission` ENABLE KEYS */;

-- 导出  表 pocketdoll.user_rucksack 结构
CREATE TABLE IF NOT EXISTS `user_rucksack` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '背包id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `goods_id` int(11) NOT NULL COMMENT '娃娃id',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '提取状态',
  `withdraw_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '提取时间',
  `gain_time` timestamp NULL DEFAULT NULL COMMENT '获取时间',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.user_rucksack 的数据：8 rows
/*!40000 ALTER TABLE `user_rucksack` DISABLE KEYS */;
INSERT INTO `user_rucksack` (`id`, `user_id`, `goods_id`, `status`, `withdraw_time`, `gain_time`, `created_at`, `updated_at`) VALUES
	(1, 1, 3, '1', '2017-10-07 18:31:33', '2017-10-07 17:40:13', '2017-10-07 17:40:13', '2017-10-07 18:31:33'),
	(2, 1, 3, '0', '2017-10-07 17:45:28', '2017-10-07 17:45:28', '2017-10-07 17:45:28', '2017-10-07 17:45:28'),
	(3, 1, 3, '0', NULL, '2017-10-10 16:44:00', '2017-10-10 16:44:00', '2017-10-10 16:44:00'),
	(4, 1, 3, '0', NULL, '2017-10-10 16:45:23', '2017-10-10 16:45:23', '2017-10-10 16:45:23'),
	(5, 1, 3, '0', NULL, '2017-10-10 16:45:52', '2017-10-10 16:45:52', '2017-10-10 16:45:52'),
	(6, 1, 3, '0', NULL, '2017-10-10 16:48:39', '2017-10-10 16:48:39', '2017-10-10 16:48:39'),
	(7, 1, 3, '0', NULL, '2017-10-10 16:48:51', '2017-10-10 16:48:51', '2017-10-10 16:48:51'),
	(8, 1, 3, '0', NULL, '2017-10-10 16:49:50', '2017-10-10 16:49:50', '2017-10-10 16:49:50');
/*!40000 ALTER TABLE `user_rucksack` ENABLE KEYS */;

-- 导出  表 pocketdoll.user_show 结构
CREATE TABLE IF NOT EXISTS `user_show` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `contents` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户发言',
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户美照',
  `status` enum('-1','1') COLLATE utf8mb4_unicode_ci DEFAULT '-1' COMMENT '审核状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  pocketdoll.user_show 的数据：5 rows
/*!40000 ALTER TABLE `user_show` DISABLE KEYS */;
INSERT INTO `user_show` (`id`, `user_id`, `contents`, `pic`, `status`, `created_at`, `updated_at`) VALUES
	(1, 2, '这个娃娃非常好呀好好', '', '-1', '2017-10-06 13:20:09', '2017-10-06 13:20:09'),
	(2, 2, '这个娃娃非常好呀好好', 'D:\\Project\\PocketDoll\\storage\\image/6MTVGcCYbdvXaJF2HGE7dmSyHkJEWmz9UvMK6vST.jpeg', '-1', '2017-10-06 13:20:24', '2017-10-06 13:20:24'),
	(4, 2, '这个娃娃非常好呀好好', 'D:\\Project\\PocketDoll\\storage\\image/LmoM4JbmCIJXwYkR4wZGgvjla5jMdS8PesboDdAN.jpeg', '-1', '2017-10-06 13:25:35', '2017-10-06 13:25:35'),
	(5, 2, '这个娃娃非常好呀好好', 'D:\\Project\\PocketDoll\\storage\\image/NRjN9seYXUlp8jvmZX5upIssKa0X9gl8QCWGppew.jpeg', '1', '2017-10-06 13:25:36', '2017-10-06 14:45:30'),
	(6, 2, '这个娃娃非常好呀好好', 'D:\\Project\\PocketDoll\\storage\\image/b71F4IguPx3wTKfajOz01RYyxvZPxWJzUfcaGBpO.jpeg', '-1', '2017-10-06 14:37:18', '2017-10-06 14:37:18');
/*!40000 ALTER TABLE `user_show` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
