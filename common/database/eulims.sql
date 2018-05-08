/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 5.7.16-log : Database - eulims
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `eulims`;

/*Table structure for table `tbl_auth_assignment` */

DROP TABLE IF EXISTS `tbl_auth_assignment`;

CREATE TABLE `tbl_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `tbl_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_auth_assignment` */

insert  into `tbl_auth_assignment`(`item_name`,`user_id`,`created_at`) values ('access-his-profile','5',1514427468),('basic-role','18',1517984550),('lab-manager','5',1516858459),('super-administrator','1',NULL);

/*Table structure for table `tbl_auth_item` */

DROP TABLE IF EXISTS `tbl_auth_item`;

CREATE TABLE `tbl_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `tbl_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `tbl_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_auth_item` */

insert  into `tbl_auth_item`(`name`,`type`,`description`,`rule_name`,`data`,`created_at`,`updated_at`) values ('/*',2,NULL,NULL,NULL,1513914178,1513914178),('/accounting/*',2,NULL,NULL,NULL,1515371555,1515371555),('/admin/*',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/assignment/*',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/assignment/assign',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/assignment/index',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/assignment/revoke',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/assignment/view',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/default/*',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/default/index',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/menu/*',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/menu/create',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/menu/delete',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/menu/index',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/menu/update',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/menu/view',2,NULL,NULL,NULL,1512924430,1512924430),('/admin/permission/*',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/permission/assign',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/permission/create',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/permission/delete',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/permission/index',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/permission/remove',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/permission/update',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/permission/view',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/*',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/assign',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/create',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/delete',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/index',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/remove',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/update',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/role/view',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/route/*',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/route/assign',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/route/create',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/route/index',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/route/refresh',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/route/remove',2,NULL,NULL,NULL,1512924431,1512924431),('/admin/rule/*',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/rule/create',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/rule/delete',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/rule/index',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/rule/update',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/rule/view',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/*',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/activate',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/change-password',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/deactivate',2,NULL,NULL,NULL,1513914178,1513914178),('/admin/user/delete',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/index',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/login',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/logout',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/reset-password',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/signup',2,NULL,NULL,NULL,1512924432,1512924432),('/admin/user/update',2,NULL,NULL,NULL,1513914178,1513914178),('/admin/user/view',2,NULL,NULL,NULL,1512924432,1512924432),('/api/*',2,NULL,NULL,NULL,1518163424,1518163424),('/api/create',2,NULL,NULL,NULL,1518163424,1518163424),('/api/delete',2,NULL,NULL,NULL,1518163424,1518163424),('/api/index',2,NULL,NULL,NULL,1518163424,1518163424),('/api/options',2,NULL,NULL,NULL,1518163424,1518163424),('/api/update',2,NULL,NULL,NULL,1518163424,1518163424),('/api/view',2,NULL,NULL,NULL,1518163424,1518163424),('/cashiering/*',2,NULL,NULL,NULL,1515379311,1515379311),('/debug/*',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/default/*',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/default/db-explain',2,NULL,NULL,NULL,1512924432,1512924432),('/debug/default/download-mail',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/default/index',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/default/toolbar',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/default/view',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/user/*',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/user/reset-identity',2,NULL,NULL,NULL,1512924433,1512924433),('/debug/user/set-identity',2,NULL,NULL,NULL,1512924433,1512924433),('/finance/*',2,NULL,NULL,NULL,1522048795,1522048795),('/gii/*',2,NULL,NULL,NULL,1512924433,1512924433),('/gii/default/*',2,NULL,NULL,NULL,1512924433,1512924433),('/gii/default/action',2,NULL,NULL,NULL,1512924433,1512924433),('/gii/default/diff',2,NULL,NULL,NULL,1512924433,1512924433),('/gii/default/index',2,NULL,NULL,NULL,1512924433,1512924433),('/gii/default/preview',2,NULL,NULL,NULL,1512924433,1512924433),('/gii/default/view',2,NULL,NULL,NULL,1512924433,1512924433),('/gridview/*',2,NULL,NULL,NULL,1516673162,1516673162),('/gridview/export/*',2,NULL,NULL,NULL,1516673161,1516673161),('/gridview/export/download',2,NULL,NULL,NULL,1516673160,1516673160),('/imagemanager/*',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/default/*',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/default/index',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/manager/*',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/manager/crop',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/manager/delete',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/manager/get-original-image',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/manager/index',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/manager/upload',2,NULL,NULL,NULL,1516673162,1516673162),('/imagemanager/manager/view',2,NULL,NULL,NULL,1516673162,1516673162),('/inventory/*',2,NULL,NULL,NULL,1515133710,1515133710),('/inventory/categorytype/*',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/categorytype/create',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/categorytype/delete',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/categorytype/index',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/categorytype/update',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/categorytype/view',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/default/*',2,NULL,NULL,NULL,1516673162,1516673162),('/inventory/default/index',2,NULL,NULL,NULL,1516673162,1516673162),('/inventory/products/*',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/add-inventory-entries',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/add-inventory-withdrawaldetails',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/create',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/delete',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/index',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/pdf',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/update',2,NULL,NULL,NULL,1517209185,1517209185),('/inventory/products/view',2,NULL,NULL,NULL,1517209185,1517209185),('/lab/*',2,NULL,NULL,NULL,1514814971,1514814971),('/lab/default/*',2,NULL,NULL,NULL,1516673162,1516673162),('/lab/default/index',2,NULL,NULL,NULL,1516673162,1516673162),('/maintenance/*',2,NULL,NULL,NULL,1514539173,1514539173),('/maintenance/index',2,NULL,NULL,NULL,1514539139,1514539139),('/message/*',2,NULL,NULL,NULL,1515721342,1515721342),('/message/message/*',2,NULL,NULL,NULL,1515721342,1515721342),('/message/message/check-for-new-messages',2,NULL,NULL,NULL,1515721341,1515721341),('/message/message/compose',2,NULL,NULL,NULL,1515721342,1515721342),('/message/message/delete',2,NULL,NULL,NULL,1515721342,1515721342),('/message/message/ignorelist',2,NULL,NULL,NULL,1515721341,1515721341),('/message/message/inbox',2,NULL,NULL,NULL,1515721341,1515721341),('/message/message/mark-all-as-read',2,NULL,NULL,NULL,1515721342,1515721342),('/message/message/sent',2,NULL,NULL,NULL,1515721341,1515721341),('/message/message/view',2,NULL,NULL,NULL,1515721342,1515721342),('/package/*',2,NULL,NULL,NULL,1514431824,1514431824),('/package/createmodule',2,NULL,NULL,NULL,1515390508,1515390508),('/package/export',2,NULL,NULL,NULL,1515390508,1515390508),('/package/extract',2,NULL,NULL,NULL,1515054294,1515054294),('/package/getcss',2,NULL,NULL,NULL,1515721342,1515721342),('/package/index',2,NULL,NULL,NULL,1514431824,1514431824),('/package/manager',2,NULL,NULL,NULL,1515721342,1515721342),('/package/removemodule',2,NULL,NULL,NULL,1515390508,1515390508),('/package/update',2,NULL,NULL,NULL,1515721342,1515721342),('/package/upload',2,NULL,NULL,NULL,1515390507,1515390507),('/package/view',2,NULL,NULL,NULL,1515721342,1515721342),('/package/writeini',2,NULL,NULL,NULL,1515054294,1515054294),('/packagedetails/*',2,NULL,NULL,NULL,1522742054,1522742054),('/profile/*',2,NULL,NULL,NULL,1513914178,1513914178),('/profile/create',2,NULL,NULL,NULL,1513914178,1513914178),('/profile/delete',2,NULL,NULL,NULL,1513914178,1513914178),('/profile/deleteimage',2,NULL,NULL,NULL,1514536468,1514536468),('/profile/index',2,NULL,NULL,NULL,1513914178,1513914178),('/profile/update',2,NULL,NULL,NULL,1513914178,1513914178),('/profile/uploadPhoto',2,NULL,NULL,NULL,1513930949,1513930949),('/profile/view',2,NULL,NULL,NULL,1513914178,1513914178),('/sample/*',2,NULL,NULL,NULL,1515141962,1515141962),('/settings/*',2,NULL,NULL,NULL,1514536468,1514536468),('/settings/disable',2,NULL,NULL,NULL,1514536468,1514536468),('/settings/enable',2,NULL,NULL,NULL,1514536468,1514536468),('/settings/index',2,NULL,NULL,NULL,1514536468,1514536468),('/site/*',2,NULL,NULL,NULL,1512923763,1512923763),('/site/about',2,NULL,NULL,NULL,1513840641,1513840641),('/site/captcha',2,NULL,NULL,NULL,1513840641,1513840641),('/site/contact',2,NULL,NULL,NULL,1513840641,1513840641),('/site/error',2,NULL,NULL,NULL,1512924433,1512924433),('/site/index',2,NULL,NULL,NULL,1512924433,1512924433),('/site/login',2,NULL,NULL,NULL,1512924433,1512924433),('/site/logout',2,NULL,NULL,NULL,1512924433,1512924433),('/site/query',2,NULL,NULL,NULL,1518163424,1518163424),('/site/request-password-reset',2,NULL,NULL,NULL,1513840641,1513840641),('/site/requestpasswordreset',2,NULL,NULL,NULL,1516091491,1516091491),('/site/reset-password',2,NULL,NULL,NULL,1514249865,1514249865),('/site/sendmail',2,NULL,NULL,NULL,1516091490,1516091490),('/site/signup',2,NULL,NULL,NULL,1513840641,1513840641),('/site/success',2,NULL,NULL,NULL,1516091491,1516091491),('/site/upload',2,NULL,NULL,NULL,1513930949,1513930949),('/site/verify',2,NULL,NULL,NULL,1516091491,1516091491),('/tagging/*',2,NULL,NULL,NULL,1515130615,1515130615),('/tagging/default/*',2,NULL,NULL,NULL,1516673162,1516673162),('/tagging/default/index',2,NULL,NULL,NULL,1516673162,1516673162),('/test2/*',2,NULL,NULL,NULL,1516085459,1516085459),('/test3/*',2,NULL,NULL,NULL,1516085788,1516085788),('/tt/*',2,NULL,NULL,NULL,1516086131,1516086131),('/uploads/*',2,NULL,NULL,NULL,1514350073,1514350073),('/user/*',2,NULL,NULL,NULL,1513843345,1513843345),('/user/create',2,NULL,NULL,NULL,1513843345,1513843345),('/user/delete',2,NULL,NULL,NULL,1513843345,1513843345),('/user/index',2,NULL,NULL,NULL,1513843344,1513843344),('/user/update',2,NULL,NULL,NULL,1513843345,1513843345),('/user/view',2,NULL,NULL,NULL,1513843344,1513843344),('access-accounting',2,'This permission allow user to access accounting module',NULL,NULL,1515371555,1515371555),('access-api',2,'Access on API Permissions',NULL,NULL,1518163478,1518163478),('access-assignment',2,'Permission will allow user to access assignment',NULL,NULL,1514425828,1514425828),('access-cashiering',2,'This permission allow user to access cashiering module',NULL,NULL,1515379311,1515379311),('access-debug',2,'This Permission allow user to access debug module',NULL,NULL,1513840103,1513840103),('access-finance',2,'This permission allow user to access finance module',NULL,NULL,1522048795,1522048795),('access-gii',2,'This permission allow user to access GII Tool',NULL,NULL,1513839929,1513839929),('access-his-profile',2,'This permission will only allow user access on his own profile',NULL,NULL,1513925187,1513925187),('access-inventory',2,'This permission allow user to access inventory module',NULL,NULL,1515133710,1515133710),('access-lab',2,'This permission allow user to access Laboratory module',NULL,NULL,1514815010,1514815010),('access-menu',2,'Permission to allow access menu ',NULL,NULL,1514426762,1514426762),('access-message',2,'This permssion allow user to access message module',NULL,NULL,1515721386,1515721386),('access-package',2,'This permission allow user to access package manager',NULL,NULL,1514431815,1514431815),('access-package-list',2,'Allow Users to access package list',NULL,NULL,1515486771,1515486771),('access-packagedetails',2,'this will allow access on package details',NULL,NULL,1522742254,1522742254),('access-permission',2,'Permission to access permission',NULL,NULL,1514426671,1514426671),('access-procurement',2,'This permission allow user to access procurement module',NULL,NULL,1519980796,1519980796),('access-profile',2,'This permission allow users access on Profile',NULL,NULL,1513924948,1513924948),('access-rbac',2,'This permission allow users to access RBAC but depends on other permissions to access other features of RBAC.',NULL,NULL,1514364821,1514364821),('access-role',2,'Permission to allow access role',NULL,NULL,1514426382,1514426382),('access-route',2,'Permission to allow access route',NULL,NULL,1514425999,1514425999),('access-rule',2,'Permission to access Rule',NULL,NULL,1514426816,1514426896),('access-sample',2,'This permission allow user to access sample module',NULL,NULL,1515141962,1515141962),('access-settings',2,'This permission allows user to access settings',NULL,NULL,1514536456,1514536456),('access-signup',2,'This permission allow user to signup',NULL,NULL,1513840579,1513840579),('access-tagging',2,'This permission allow user to access tagging module',NULL,NULL,1515130615,1515130615),('access-test',2,'This permission allow user to access test module',NULL,NULL,1516084596,1516084596),('access-test2',2,'This permission allow user to access test2 module',NULL,NULL,1516085459,1516085459),('access-test3',2,'This permission allow user to access test3 module',NULL,NULL,1516085788,1516085788),('access-tt',2,'This permission allow user to access tt module',NULL,NULL,1516086131,1516086131),('access-user',2,'This permission allow user to access User Account',NULL,NULL,1514425679,1514425679),('allow-access-backend',2,'This Permission allow users to access backend',NULL,NULL,1513908976,1513908976),('allow-gridview-export',2,'this permissions will allow access export/download',NULL,NULL,1517209167,1517209167),('basic-role',1,'Basic role for newly created user',NULL,NULL,1517967802,1517967802),('can-delete-profile',2,'This permission allow user to delete profile',NULL,NULL,1514428789,1514428789),('Guest',1,'This the default Role',NULL,NULL,1517381088,1517381088),('lab-manager',1,'This is a role for Laboratory Manager',NULL,NULL,1516858383,1516858383),('profile-full-access',2,'This permission allow users to access profile with full access',NULL,NULL,1513914161,1513914161),('rbac-assign-permission',2,'This permission allows user to assign roles',NULL,NULL,1512924223,1513840446),('rbac-full-access',2,'This permission has all the rights to access rbac',NULL,NULL,1513840364,1513840364),('super-administrator',1,'This role reserve all the rights and permissions',NULL,NULL,1513838897,1513840008),('user-full-access',2,'This Permission allows user to access User module',NULL,NULL,1513843398,1513843398);

/*Table structure for table `tbl_auth_item_child` */

DROP TABLE IF EXISTS `tbl_auth_item_child`;

CREATE TABLE `tbl_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `tbl_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tbl_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_auth_item_child` */

insert  into `tbl_auth_item_child`(`parent`,`child`) values ('access-accounting','/accounting/*'),('rbac-full-access','/admin/*'),('rbac-assign-permission','/admin/assignment/*'),('access-assignment','/admin/assignment/index'),('access-assignment','/admin/assignment/view'),('access-rbac','/admin/assignment/view'),('access-menu','/admin/menu/index'),('access-menu','/admin/menu/view'),('access-permission','/admin/permission/index'),('access-permission','/admin/permission/view'),('access-role','/admin/role/index'),('access-role','/admin/role/view'),('access-route','/admin/route/assign'),('access-route','/admin/route/index'),('access-rule','/admin/rule/index'),('access-rule','/admin/rule/view'),('access-user','/admin/user/*'),('access-api','/api/*'),('access-cashiering','/cashiering/*'),('access-debug','/debug/*'),('access-finance','/finance/*'),('access-gii','/gii/*'),('allow-gridview-export','/gridview/*'),('access-inventory','/inventory/*'),('access-lab','/lab/*'),('Guest','/maintenance/*'),('access-message','/message/*'),('access-package','/package/*'),('access-package','/package/createmodule'),('access-package','/package/export'),('access-package','/package/extract'),('access-package','/package/index'),('access-package','/package/removemodule'),('access-package','/package/upload'),('access-package','/package/writeini'),('access-packagedetails','/packagedetails/*'),('access-his-profile','/profile/*'),('profile-full-access','/profile/*'),('access-his-profile','/profile/create'),('access-his-profile','/profile/index'),('access-profile','/profile/index'),('access-his-profile','/profile/update'),('access-his-profile','/profile/uploadPhoto'),('profile-full-access','/profile/uploadPhoto'),('access-his-profile','/profile/view'),('access-profile','/profile/view'),('access-sample','/sample/*'),('access-settings','/settings/*'),('Guest','/site/*'),('access-signup','/site/signup'),('super-administrator','/site/signup'),('profile-full-access','/site/upload'),('access-tagging','/tagging/*'),('access-test2','/test2/*'),('access-test3','/test3/*'),('access-tt','/tt/*'),('user-full-access','/user/*'),('super-administrator','access-accounting'),('Guest','access-api'),('super-administrator','access-assignment'),('super-administrator','access-cashiering'),('super-administrator','access-debug'),('super-administrator','access-gii'),('basic-role','access-his-profile'),('super-administrator','access-inventory'),('lab-manager','access-lab'),('super-administrator','access-lab'),('super-administrator','access-menu'),('basic-role','access-message'),('super-administrator','access-message'),('super-administrator','access-package'),('super-administrator','access-package-list'),('super-administrator','access-packagedetails'),('super-administrator','access-permission'),('super-administrator','access-procurement'),('profile-full-access','access-profile'),('super-administrator','access-profile'),('super-administrator','access-rbac'),('super-administrator','access-role'),('super-administrator','access-route'),('super-administrator','access-rule'),('super-administrator','access-settings'),('Guest','access-signup'),('super-administrator','access-signup'),('super-administrator','access-tagging'),('super-administrator','access-user'),('super-administrator','allow-access-backend'),('basic-role','allow-gridview-export'),('super-administrator','allow-gridview-export'),('super-administrator','can-delete-profile'),('super-administrator','profile-full-access'),('rbac-full-access','rbac-assign-permission'),('super-administrator','rbac-full-access'),('super-administrator','user-full-access');

/*Table structure for table `tbl_auth_rule` */

DROP TABLE IF EXISTS `tbl_auth_rule`;

CREATE TABLE `tbl_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_auth_rule` */

/*Table structure for table `tbl_imagemanager` */

DROP TABLE IF EXISTS `tbl_imagemanager`;

CREATE TABLE `tbl_imagemanager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fileName` varchar(128) NOT NULL,
  `fileHash` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `createdBy` int(10) unsigned DEFAULT NULL,
  `modifiedBy` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_imagemanager` */

insert  into `tbl_imagemanager`(`id`,`fileName`,`fileHash`,`created`,`modified`,`createdBy`,`modifiedBy`) values (21,'DOST-XI.jpg','_6l0KmBXSf-N66ifLeIHLsCrv01Jj7jh','2018-01-15 16:41:37','2018-01-15 16:41:37',NULL,NULL),(22,'ab0551ea9fa84e128d4c483a04c86d99479e9408.jpg','fSP0soWS9gn3vcEB987TDc6IHIfClpLl','2018-01-15 16:43:37','2018-01-15 16:43:37',NULL,NULL),(23,'c1f44f4d32ce6b10fcb6ec71f292cfa43323ee6c.jpg','LFfWrKffJEgDqdOpxE0als3_E5_PorzR','2018-01-15 16:44:03','2018-01-15 16:44:03',NULL,NULL),(25,'ab0551ea9fa84e128d4c483a04c86d99479e9408_crop_486x507.jpg','cV16OuH8IjljOXQVx5SHh55zAERPT2nj','2018-01-22 13:30:23','2018-01-22 13:30:23',NULL,NULL),(29,'26971913-1546772542043190-774125253-o.jpg','Jn3RHKW2voCPAI_5HJEeXvBDOdZDI35y','2018-01-22 14:23:02','2018-01-22 14:23:02',NULL,NULL);

/*Table structure for table `tbl_industry` */

DROP TABLE IF EXISTS `tbl_industry`;

CREATE TABLE `tbl_industry` (
  `industry_id` int(11) NOT NULL AUTO_INCREMENT,
  `classification` varchar(250) CHARACTER SET latin1 NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`industry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_industry` */

insert  into `tbl_industry`(`industry_id`,`classification`,`active`) values (1,'Agriculture, forestry and fishing',1),(2,'Mining and Quarrying',1),(3,'Manufacturing',1),(4,'Electricity, gas, steam and air-conditioning supply',1),(5,'Water supply, sewerage, waste management and remediation activities',1),(6,'Construction',1),(7,'Wholesale and retail trade; repair of motor vehicles and motorcycles',1),(8,'Transportation and Storage',1),(9,'Accommodation and food service activities',1),(10,'Information and Communication',1),(11,'Financial and insurance activities',1),(12,'Real estate activities',1),(13,'Professional, scientific and technical services',1),(14,'Administrative and support service activities',1),(15,'Public administrative and defense; compulsory social security',1),(16,'Education',1),(17,'Human health and social work activities',1),(18,'Arts, entertainment and recreation',1),(19,'Other service activities',1),(20,'Activities of private households as employers and undifferentiated goods and services and producing activities of households for own use',1),(21,'Activities of extraterritorial organizations and bodies',1);

/*Table structure for table `tbl_menu` */

DROP TABLE IF EXISTS `tbl_menu`;

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `tbl_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tbl_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_menu` */

insert  into `tbl_menu`(`id`,`name`,`parent`,`route`,`order`,`data`) values (1,'Home',NULL,'/site/index',1,NULL);

/*Table structure for table `tbl_message` */

DROP TABLE IF EXISTS `tbl_message`;

CREATE TABLE `tbl_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL,
  `from` int(11) DEFAULT NULL,
  `to` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `message` text,
  `created_at` datetime NOT NULL,
  `context` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_message` */

insert  into `tbl_message`(`id`,`hash`,`from`,`to`,`status`,`title`,`message`,`created_at`,`context`) values (1,'413de46eb1c6e970e0018752cc663b91',1,2,1,'Test','Testing emai;l','2018-01-12 11:05:13',''),(2,'c161f92cc41ea66b50f668da2f7cbe19',1,2,1,'Test','fggggfgfgfgf','2018-01-12 11:05:47',''),(3,'1745c19267b5aeddcd062048d7ec4912',2,1,1,'Re: Test','OK admin...thanks','2018-01-12 12:02:31',''),(4,'b1f0d2b59640dbacb0e8b6710a9f2df8',2,1,1,'Re: Test','OK admin...thanks','2018-01-12 12:04:38',''),(5,'f33d46bb69f6104b58d1c926bd017f3a',2,1,1,'Re: Test','OK admin...thanks','2018-01-12 12:05:12',''),(6,'3c086e0f7ebf689f790e84b6031b8ab2',2,1,1,'Re: Test','OK admin...thanks','2018-01-12 12:05:34',''),(7,'68470d890b92b328e34ff6d00186c107',2,1,1,'Re: Test','OK admin...thanks','2018-01-12 12:06:05',''),(8,'76314a7c2850538bc488854861b16493',1,2,1,'Re: Test','','2018-01-12 12:42:32',''),(9,'0d10174be52f4d448873193cde61128e',2,1,-1,'Test Multiple messages','<h1>Testing</h1>\r\nThis is a message...','2018-01-12 14:12:06',''),(10,'6eea46ea65b69bdad5ac83df39b3c7c4',2,1,1,'Test Multiple messages','<h1>Testing</h1>\r\nThis is a message...','2018-01-12 14:13:43',''),(11,'5ab804eca05589b676281bcfb956c640',2,5,0,'Test Multiple messages','<h1>Testing</h1>\r\nThis is a message...','2018-01-12 14:13:49',''),(12,'3be914d9a89936a5e03d37317ba1f68f',1,2,2,'testing email','<p>Hi <strong>Jane,</strong></p>\r\n\r\n<p>please click this link&nbsp;<a href=\"https://web.onelab.ph\">OneLab</a></p>\r\n','2018-01-15 16:57:54',''),(13,'2f13dd38c25ca28b5f588af3fb2610c0',2,1,1,'Re: testing email','<p>OK I will</p>\r\n','2018-01-15 16:59:01','');

/*Table structure for table `tbl_message_allowed_contacts` */

DROP TABLE IF EXISTS `tbl_message_allowed_contacts`;

CREATE TABLE `tbl_message_allowed_contacts` (
  `user_id` int(11) NOT NULL,
  `is_allowed_to_write` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`is_allowed_to_write`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_message_allowed_contacts` */

/*Table structure for table `tbl_message_ignorelist` */

DROP TABLE IF EXISTS `tbl_message_ignorelist`;

CREATE TABLE `tbl_message_ignorelist` (
  `user_id` int(11) NOT NULL,
  `blocks_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`blocks_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_message_ignorelist` */

/*Table structure for table `tbl_migration` */

DROP TABLE IF EXISTS `tbl_migration`;

CREATE TABLE `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_migration` */

insert  into `tbl_migration`(`version`,`apply_time`) values ('m000000_000000_base',1515723504),('m161028_084412_init',1515723507),('m161214_134749_create_table_tbl_message_ignorelist',1515723508),('m170116_094811_add_context_field_to_tbl_message_table',1515723510),('m170203_090001_create_table_tbl_message_allowed_contacts',1515723511);

/*Table structure for table `tbl_package` */

DROP TABLE IF EXISTS `tbl_package`;

CREATE TABLE `tbl_package` (
  `PackageID` int(11) NOT NULL AUTO_INCREMENT,
  `PackageName` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`PackageID`),
  UNIQUE KEY `PackageName` (`PackageName`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_package` */

insert  into `tbl_package`(`PackageID`,`PackageName`,`icon`,`created_at`,`updated_at`) values (21,'lab','fa fa-bookmark',1515397499,1515634107),(22,'inventory','fa fa-assistive-listening-systems',1515398542,1515575300),(23,'tagging','fa fa-tag',1515475587,1515575270),(24,'finance',NULL,1522048795,1522048795);

/*Table structure for table `tbl_package_details` */

DROP TABLE IF EXISTS `tbl_package_details`;

CREATE TABLE `tbl_package_details` (
  `Package_DetailID` int(11) NOT NULL AUTO_INCREMENT,
  `PackageID` int(11) NOT NULL,
  `Package_Detail` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`Package_DetailID`),
  UNIQUE KEY `Package_Detail` (`Package_Detail`),
  KEY `PackageID` (`PackageID`),
  CONSTRAINT `tbl_package_details_ibfk_1` FOREIGN KEY (`PackageID`) REFERENCES `tbl_package` (`PackageID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_package_details` */

insert  into `tbl_package_details`(`Package_DetailID`,`PackageID`,`Package_Detail`,`icon`,`created_at`,`updated_at`) values (1,21,'Test','fa fa-address-book-o',1522745698,1522745698),(2,21,'test2','fa fa-bars',1522800196,1522800196);

/*Table structure for table `tbl_profile` */

DROP TABLE IF EXISTS `tbl_profile`;

CREATE TABLE `tbl_profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `middleinitial` varchar(50) DEFAULT NULL,
  `rstl_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `contact_numbers` varchar(100) DEFAULT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `rstl_id` (`rstl_id`),
  CONSTRAINT `tbl_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`user_id`),
  CONSTRAINT `tbl_profile_ibfk_2` FOREIGN KEY (`rstl_id`) REFERENCES `tbl_rstl` (`rstl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_profile` */

insert  into `tbl_profile`(`profile_id`,`user_id`,`lastname`,`firstname`,`designation`,`middleinitial`,`rstl_id`,`lab_id`,`contact_numbers`,`image_url`,`avatar`) values (1,1,'Sunico','Nolan','System Administrator','Francisco',11,1,'+639058051739','Nolan.jpg','c1f44f4d32ce6b10fcb6ec71f292cfa43323ee6c.jpg'),(2,2,'Sunico','Jane','Teacher','Cabeltes',14,1,'09058051739','24058747_1499346930119085_3886918050854750796_n.jpg','ab0551ea9fa84e128d4c483a04c86d99479e9408.jpg'),(3,5,'Sunico','Kyle','Student','Cabeltes',4,5,'None','WIN_20170906_08_59_13_Pro.jpg','eaecb6031db12110b3e5223042373dde19165d1d.jpg'),(4,18,'Tailor','Nolan','Programmer','Francisco',11,2,'09058051739',NULL,NULL),(5,13,'grapa','Janeedi','SRS1','A',11,1,'09976639656','','');

/*Table structure for table `tbl_quarter` */

DROP TABLE IF EXISTS `tbl_quarter`;

CREATE TABLE `tbl_quarter` (
  `quarter_id` int(11) NOT NULL AUTO_INCREMENT,
  `quarter` varchar(11) NOT NULL,
  `period_month` varchar(22) NOT NULL,
  PRIMARY KEY (`quarter_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_quarter` */

insert  into `tbl_quarter`(`quarter_id`,`quarter`,`period_month`) values (1,'1st Quarter','January - March'),(2,'2nd Quarter','April - June'),(3,'3rd Quarter','July - September'),(4,'4th Quarter','October - December');

/*Table structure for table `tbl_rstl` */

DROP TABLE IF EXISTS `tbl_rstl`;

CREATE TABLE `tbl_rstl` (
  `rstl_id` int(11) NOT NULL AUTO_INCREMENT,
  `region_id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `code` varchar(10) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`rstl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_rstl` */

insert  into `tbl_rstl`(`rstl_id`,`region_id`,`name`,`code`) values (1,3,'DOST-I','R1'),(2,4,'DOST-II','R2'),(3,5,'DOST-III','R3'),(4,6,'DOST-IVA-L1','R4AL1'),(5,6,'DOST-IVA-L2','R4AL2'),(6,7,'DOST-IVB','R4B'),(7,8,'DOST-V','R5'),(8,9,'DOST-VI','R6'),(9,10,'DOST-VII','R7'),(10,11,'DOST-VIII','R8'),(11,12,'DOST-IX','R9'),(12,13,'DOST-X','R10'),(13,14,'DOST-XI','R11'),(14,15,'DOST-XII-L1','R12L1'),(15,15,'DOST-XII-L2','R12L2'),(16,2,'DOST-CAR','CAR'),(17,17,'DOST-CARAGA','R13'),(18,18,'DOST-ARMM','ARMM'),(19,19,'DOST-FNRI','FNRI'),(20,20,'DOST-FPRDI','FPRDI'),(21,21,'DOST-ITDI','ITDI'),(22,22,'DOST-MIRDC','MIRDC'),(23,23,'DOST-PTRI','PTRI'),(24,24,'DOST-PNRI','PNRI'),(25,6,'DOST-IVA-L3','R4AL3'),(26,6,'DOST-IVA-L4','R4AL4'),(27,21,'DOST-ADMATEL','ADMATEL');

/*Table structure for table `tbl_status` */

DROP TABLE IF EXISTS `tbl_status`;

CREATE TABLE `tbl_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_status` */

insert  into `tbl_status`(`status_id`,`status`) values (1,'On-going'),(2,'Graduated/ Completed'),(3,'Terminated'),(4,'Withdrawn'),(5,'Non-Compliance'),(6,'Duplicate');

/*Table structure for table `tbl_status_sub` */

DROP TABLE IF EXISTS `tbl_status_sub`;

CREATE TABLE `tbl_status_sub` (
  `status_sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `subname` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`status_sub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

/*Data for the table `tbl_status_sub` */

insert  into `tbl_status_sub`(`status_sub_id`,`status_id`,`subname`) values (1,1,'Good Standing'),(2,1,'Suspended'),(3,1,'Leave Of Absence'),(4,1,'No Report'),(5,2,'Graduated'),(6,3,'Terminated'),(7,4,'Withdrawn'),(8,5,'Non-Compliance');

/*Table structure for table `tbl_upload_package` */

DROP TABLE IF EXISTS `tbl_upload_package`;

CREATE TABLE `tbl_upload_package` (
  `upload_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(100) DEFAULT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_upload_package` */

insert  into `tbl_upload_package`(`upload_id`,`package_name`,`module_name`,`created_at`,`updated_at`) values (1,'lab.zip','Lab.zip',1515397495,1515397495);

/*Table structure for table `tbl_user` */

DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`user_id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`) values (1,'Admin','H06d598TowxCUB1bRLqPHNsPMtkp3MCK','$2y$13$FZqPeW2UZnylgrGIQyToGekR9YhIMlpif2IAOZaLr7qm.ffJAqA02','4CnX1D1IKs70gFic28bClG-vbQfzldAB_1517198782','nolansunico@gmail.com',10,1512923120,1517198782),(2,'Jane','hbCjwM0lqOoBGNjCwnh1DET0eplo_LtA','$2y$13$lQ3yHlv2uIMXhx/J8Yx1befwUD5kPaV91Bx6YFvN1adTGdvwcRFIy',NULL,'janesunico2015@gmail.com',10,1513845779,1513908174),(5,'Kyle','7QcI5fZmXdkOsCy711C-wS1GlUjIfA7t','$2y$13$ImnGqbmO/1AMHDna6nAw8OUQgvzjRHRA1HWiu2THmO8FEtaVS/9Eu',NULL,'kylesunico@gmail.com',10,1513846447,1513907171),(13,'Janeedi','9zd8cSZUlbzKQCput-BQCk2anM0_aVrT','$2y$13$p05tmqpnvPvNZJVwJcEnN.Dkxk9vlvp0hs2TFYu4bTFSEwXp8mNKe',NULL,'grapajaneedi@gmail.com',10,1516093201,1521097835),(18,'Nolan','Ay4LPzV1vSFoB_2JeCy7XB4zGgqXGdVR','$2y$13$AyeXtRl68mOmu8ZpQ0luB.MsT0BAK380ZGr0LzhZeHq65ml/5uIlm',NULL,'nolan2@tailormadetraffic.com',10,1517984507,1517984550),(19,'papa','gR8jzaTQlUhSO78oOrthZBC9FePYNC5A','$2y$13$NeDyUf/cBOv8/gz/Q9XLA.ayrFPoAylkYfzbq3ebCu8w/C2rnI0SW',NULL,'nolan@tailormadetraffic.com',0,1519972939,1519972939);

/*Table structure for table `vw_getuser` */

DROP TABLE IF EXISTS `vw_getuser`;

/*!50001 DROP VIEW IF EXISTS `vw_getuser` */;
/*!50001 DROP TABLE IF EXISTS `vw_getuser` */;

/*!50001 CREATE TABLE  `vw_getuser`(
 `user_id` int(11) ,
 `username` varchar(32) ,
 `auth_key` varchar(32) ,
 `password_hash` varchar(255) ,
 `password_reset_token` varchar(255) ,
 `email` varchar(255) ,
 `status` smallint(6) ,
 `created_at` int(11) ,
 `updated_at` int(11) ,
 `lastname` varchar(50) ,
 `firstname` varchar(50) 
)*/;

/*View structure for view vw_getuser */

/*!50001 DROP TABLE IF EXISTS `vw_getuser` */;
/*!50001 DROP VIEW IF EXISTS `vw_getuser` */;

/*!50001 CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `vw_getuser` AS (select `tbl_user`.`user_id` AS `user_id`,`tbl_user`.`username` AS `username`,`tbl_user`.`auth_key` AS `auth_key`,`tbl_user`.`password_hash` AS `password_hash`,`tbl_user`.`password_reset_token` AS `password_reset_token`,`tbl_user`.`email` AS `email`,`tbl_user`.`status` AS `status`,`tbl_user`.`created_at` AS `created_at`,`tbl_user`.`updated_at` AS `updated_at`,`tbl_profile`.`lastname` AS `lastname`,`tbl_profile`.`firstname` AS `firstname` from (`tbl_user` join `tbl_profile` on((`tbl_profile`.`user_id` = `tbl_user`.`user_id`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
