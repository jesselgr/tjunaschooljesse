# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.9)
# Database: albacore
# Generation Time: 2014-02-12 10:17:16 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table cms_session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cms_session`;

CREATE TABLE `cms_session` (
  `session_id` varchar(40) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `ip_address` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET latin1 NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `cms_session` WRITE;
/*!40000 ALTER TABLE `cms_session` DISABLE KEYS */;

INSERT INTO `cms_session` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`)
VALUES
	('0fc8825e9887a1f42515dcb28c6f7533','0.0.0.0','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_0) App',1392199731,'a:5:{s:8:\"username\";s:5:\"tjuna\";s:12:\"is_logged_in\";s:40:\"278e6a452af073fc7e9299f4fb2abc77f4c795ff\";s:13:\"user_group_id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:7:\"site_id\";s:1:\"1\";}');

/*!40000 ALTER TABLE `cms_session` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content`;

CREATE TABLE `content` (
  `content_id` int(10) NOT NULL AUTO_INCREMENT,
  `page_id` int(10) NOT NULL COMMENT 'fk -> page',
  `template_section_id` int(10) NOT NULL,
  `content_type_id` int(10) NOT NULL,
  `file_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `restricted` tinyint(1) NOT NULL,
  `create_date` int(11) NOT NULL,
  `last_edit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;

INSERT INTO `content` (`content_id`, `page_id`, `template_section_id`, `content_type_id`, `file_id`, `sort_order`, `restricted`, `create_date`, `last_edit_date`)
VALUES
	(6,4,2,1,0,0,0,0,'2013-04-17 21:40:50'),
	(7,5,2,1,0,0,0,0,'2013-04-17 21:43:50'),
	(9,7,2,1,0,0,0,0,'2013-06-04 17:32:50'),
	(12,5,2,2,0,0,0,0,'2013-07-24 15:40:18'),
	(14,1,1,1,0,0,0,0,'2013-10-01 10:04:39');

/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content_default
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content_default`;

CREATE TABLE `content_default` (
  `content_default_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) NOT NULL,
  `template_section_id` int(11) DEFAULT NULL,
  `content_type_id` int(11) NOT NULL,
  `title` varchar(512) NOT NULL DEFAULT '',
  `sub_title` varchar(512) DEFAULT NULL,
  `description` text NOT NULL,
  `restricted` tinyint(1) NOT NULL,
  PRIMARY KEY (`content_default_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `content_default` WRITE;
/*!40000 ALTER TABLE `content_default` DISABLE KEYS */;

INSERT INTO `content_default` (`content_default_id`, `template_id`, `template_section_id`, `content_type_id`, `title`, `sub_title`, `description`, `restricted`)
VALUES
	(1,2,2,1,'Hoofdtekst','','<p>\n [ Vul hier tekst in ]</p>\n',0);

/*!40000 ALTER TABLE `content_default` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content_description
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content_description`;

CREATE TABLE `content_description` (
  `content_description_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) NOT NULL,
  `language_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `sub_title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `publish_state` tinyint(1) NOT NULL DEFAULT '0',
  `mobile` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`content_description_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `content_description` WRITE;
/*!40000 ALTER TABLE `content_description` DISABLE KEYS */;

INSERT INTO `content_description` (`content_description_id`, `content_id`, `language_id`, `title`, `sub_title`, `content`, `publish_state`, `mobile`)
VALUES
	(12,6,1,'Hoofdtekst','','<p>404 - Page not Found</p>\n',0,NULL),
	(13,6,2,'Hoofdtekst','','<p>404 - Pagina is niet gevonden</p>\n',0,NULL),
	(15,7,1,'ante elit. Fusce pharetra lectus id purus porta accumsan. Duis turpis urna, accumsan a luctus at, c','','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquet venenatis laoreet. Praesent tincidunt lacus non odio pulvinar iaculis. Nam gravida dictum consectetur. Suspendisse commodo ante at felis egestas, quis semper tortor congue. Curabitur eu consequat nibh. Donec et mi ante. Praesent et ante elit. Fusce pharetra lectus id purus porta accumsan. Duis turpis urna, accumsan a luctus at, condimentum in sem. Mauris quis elit vulputate, varius nunc id, ultrices mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed posuere vitae enim euismod ullamcorper.</p>\n\n<p>Donec ut massa vulputate, lobortis ante ac, hendrerit felis. Nullam auctor, lectus eget scelerisque sollicitudin, enim orci condimentum risus, luctus blandit&nbsp;</p>\n',0,NULL),
	(16,7,2,'o ante at felis egestas, quis semper tortor congue. Curabitur eu consequat nibh. Donec et mi ante. Praesent et','','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquet venenatis laoreet. Praesent tincidunt lacus non odio pulvinar iaculis. Nam gravida dictum consectetur. Suspendisse commodo ante at felis egestas, quis semper tortor congue. Curabitur eu consequat nibh. Donec et mi ante. Praesent et ante elit. Fusce pharetra lectus id purus porta accumsan. Duis turpis urna, accumsan a luctus at, condimentum in sem. Mauris quis elit vulputate, varius nunc id, ultrices mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed posuere vitae enim euismod ullamcorper.</p>\n\n<p>Donec ut massa vulputate, lobortis ante ac, hendrerit felis. Nullam auctor, lectus eget scelerisque sollicitudin, enim orci condimentum risus, luctus blandit&nbsp;</p>\n',0,NULL),
	(18,8,1,'404','','<p>\n [ Vul hier tekst in ]</p>\n',0,NULL),
	(19,8,2,'404','','<p>\n [ Vul hier tekst in ]</p>\n',0,NULL),
	(21,9,1,'About','','<p>Albacore is the Tjuna CMS.</p>\n',0,0),
	(22,9,2,'Over Albacore','','<p>Albacore is het Tjuna CMS.</p>\n',0,0),
	(30,12,2,' mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos','','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquet venenatis laoreet. Praesent tincidunt lacus non odio pulvinar iaculis. Nam gravida dictum consectetur. Suspendisse commodo ante at felis egestas, quis semper tortor congue. Curabitur eu consequat nibh. Donec et mi ante. Praesent et ante elit. Fusce pharetra lectus id purus porta accumsan. Duis turpis urna, accumsan a luctus at, condimentum in sem. Mauris quis elit vulputate, varius nunc id, ultrices mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed posuere vitae enim euismod ullamcorper.</p>\n\n<p>Donec ut massa vulputate, lobortis ante ac, hendrerit felis. Nullam auctor, lectus eget scelerisque sollicitudin, enim orci condimentum risus, luctus blandit&nbsp;</p>\n',0,NULL),
	(31,12,1,' mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos','','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent aliquet venenatis laoreet. Praesent tincidunt lacus non odio pulvinar iaculis. Nam gravida dictum consectetur. Suspendisse commodo ante at felis egestas, quis semper tortor congue. Curabitur eu consequat nibh. Donec et mi ante. Praesent et ante elit. Fusce pharetra lectus id purus porta accumsan. Duis turpis urna, accumsan a luctus at, condimentum in sem. Mauris quis elit vulputate, varius nunc id, ultrices mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed posuere vitae enim euismod ullamcorper.</p>\n\n<p>Donec ut massa vulputate, lobortis ante ac, hendrerit felis. Nullam auctor, lectus eget scelerisque sollicitudin, enim orci condimentum risus, luctus blandit&nbsp;</p>\n',0,NULL),
	(36,14,2,'Albacore','','<p>Welkom bij Albacore!</p>\n',0,NULL),
	(37,14,1,'Albacore','','<p>Welcome to Albacore!</p>\n',0,NULL);

/*!40000 ALTER TABLE `content_description` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table content_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `content_type`;

CREATE TABLE `content_type` (
  `content_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `editor` varchar(255) NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL,
  `language_dependant` tinyint(1) NOT NULL,
  `serialized` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `content_type` WRITE;
/*!40000 ALTER TABLE `content_type` DISABLE KEYS */;

INSERT INTO `content_type` (`content_type_id`, `title`, `editor`, `sort`, `language_dependant`, `serialized`)
VALUES
	(1,'text','content_text_form',1,1,0),
	(2,'image','content_img_form',2,1,0);

/*!40000 ALTER TABLE `content_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file` (
  `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_category_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `sha1` varchar(128) NOT NULL DEFAULT '',
  `extension` varchar(4) NOT NULL,
  `is_image` tinyint(1) NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(21) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `file` WRITE;
/*!40000 ALTER TABLE `file` DISABLE KEYS */;

INSERT INTO `file` (`file_id`, `file_category_id`, `title`, `sha1`, `extension`, `is_image`, `date_create`, `date_modified`, `type`)
VALUES
	(2,1,'Albacore logo','1218fc3675351a80e75dfca9be87e6284737c368','png',1,'2013-10-01 10:47:03','0000-00-00 00:00:00',''),
	(8,1,'Tjuna Logo (old)','8e13869d0473f9dcb0fa18882c70d371d00ef724','png',1,'2014-02-12 11:09:05','0000-00-00 00:00:00','image');

/*!40000 ALTER TABLE `file` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table file_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `file_category`;

CREATE TABLE `file_category` (
  `file_category_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `parent_file_category_id` int(11) DEFAULT NULL,
  `has_children` tinyint(1) NOT NULL,
  PRIMARY KEY (`file_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `file_category` WRITE;
/*!40000 ALTER TABLE `file_category` DISABLE KEYS */;

INSERT INTO `file_category` (`file_category_id`, `title`, `parent_file_category_id`, `has_children`)
VALUES
	(1,'Content',NULL,0);

/*!40000 ALTER TABLE `file_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table input_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `input_type`;

CREATE TABLE `input_type` (
  `input_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(23) NOT NULL DEFAULT '',
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`input_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `input_type` WRITE;
/*!40000 ALTER TABLE `input_type` DISABLE KEYS */;

INSERT INTO `input_type` (`input_type_id`, `file_name`, `serialized`)
VALUES
	(1,'input_text',0),
	(2,'input_image',0),
	(3,'input_text_area',0),
	(4,'input_status',0),
	(5,'input_boolean',0),
	(6,'input_number',0),
	(7,'input_date',0),
	(8,'input_file',0),
	(9,'input_hidden',0),
	(10,'input_multi_select',0),
	(11,'input_password',0);

/*!40000 ALTER TABLE `input_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table language
# ------------------------------------------------------------

DROP TABLE IF EXISTS `language`;

CREATE TABLE `language` (
  `language_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(4) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `sort_order` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `locale` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `language` WRITE;
/*!40000 ALTER TABLE `language` DISABLE KEYS */;

INSERT INTO `language` (`language_id`, `code`, `name`, `sort_order`, `status`, `locale`)
VALUES
	(1,'en','English',2,1,'en_US'),
	(2,'nl','Nederlands',1,1,'nl_NL');

/*!40000 ALTER TABLE `language` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table language_description
# ------------------------------------------------------------

DROP TABLE IF EXISTS `language_description`;

CREATE TABLE `language_description` (
  `language_description_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`language_description_id`),
  UNIQUE KEY `language_id` (`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `language_description` WRITE;
/*!40000 ALTER TABLE `language_description` DISABLE KEYS */;

INSERT INTO `language_description` (`language_description_id`, `language_id`, `name`)
VALUES
	(1,2,'English'),
	(2,1,'Nederlands');

/*!40000 ALTER TABLE `language_description` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table language_label
# ------------------------------------------------------------

DROP TABLE IF EXISTS `language_label`;

CREATE TABLE `language_label` (
  `language_label_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`language_label_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page`;

CREATE TABLE `page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_page_id` varchar(10) DEFAULT NULL COMMENT 'fk -> page',
  `site_id` int(11) DEFAULT NULL,
  `template_id` int(10) NOT NULL COMMENT 'fk -> layout',
  `thumb` varchar(127) DEFAULT NULL,
  `mobile_thumb` varchar(127) DEFAULT NULL,
  `publish_front` tinyint(1) NOT NULL DEFAULT '0',
  `fixed` varchar(20) DEFAULT NULL,
  `nav_prio` int(10) NOT NULL,
  `in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `in_tree` tinyint(1) NOT NULL DEFAULT '1',
  `restricted` tinyint(1) NOT NULL,
  `children` tinyint(1) DEFAULT NULL,
  `in_footer` tinyint(1) NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `depth` int(11) NOT NULL,
  `group` enum('pages') NOT NULL DEFAULT 'pages',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;

INSERT INTO `page` (`page_id`, `parent_page_id`, `site_id`, `template_id`, `thumb`, `mobile_thumb`, `publish_front`, `fixed`, `nav_prio`, `in_menu`, `in_tree`, `restricted`, `children`, `in_footer`, `date_modified`, `depth`, `group`)
VALUES
	(1,'root',1,2,'2','0',0,'home',1,1,1,1,0,0,'2014-02-12 10:55:16',0,'pages'),
	(4,'root',1,2,'',NULL,0,'404',4,0,1,0,0,0,'2014-02-12 10:55:21',0,'pages'),
	(5,'7',1,2,'',NULL,0,'',3,1,1,0,0,0,'2014-02-12 10:55:23',0,'pages'),
	(7,'root',1,2,'97',NULL,0,'',2,1,1,0,1,0,'2014-02-12 10:55:23',0,'pages');

/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table page_description
# ------------------------------------------------------------

DROP TABLE IF EXISTS `page_description`;

CREATE TABLE `page_description` (
  `page_description_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `url_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `title` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `sub_title` varchar(255) NOT NULL DEFAULT '',
  `meta_keywords` varchar(255) DEFAULT '',
  `meta_description` text,
  `publish_state` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_description_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `page_description` WRITE;
/*!40000 ALTER TABLE `page_description` DISABLE KEYS */;

INSERT INTO `page_description` (`page_description_id`, `page_id`, `language_id`, `url_name`, `title`, `sub_title`, `meta_keywords`, `meta_description`, `publish_state`)
VALUES
	(37,1,1,'home','Home','','','',1),
	(38,1,2,'home','Home','','','',1),
	(44,4,2,'404','404','','','',1),
	(45,4,1,'404','404','','','',1),
	(47,5,2,'meer-info','Meer Info','','','',1),
	(48,5,1,'more-info','More info','','','',1),
	(53,7,2,'over-albacore','over Albacore','','','',1),
	(54,7,1,'about-albacore','about Albacore','','','',1);

/*!40000 ALTER TABLE `page_description` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission` (
  `permission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;

INSERT INTO `permission` (`permission_id`, `key`)
VALUES
	(2,'read_content'),
	(3,'files'),
	(4,'tjuna'),
	(5,'create_content'),
	(6,'update_content'),
	(7,'delete_content'),
	(8,'create_page'),
	(9,'read_page'),
	(10,'update_page'),
	(11,'delete_page'),
	(12,'update_page_full'),
	(13,'all_sites'),
	(14,'editor'),
	(15,'publisher'),
	(16,'sort_pages'),
	(23,'languages'),
	(24,'create_category'),
	(25,'update_setting'),
	(26,'update_user_self');

/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `setting_id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) DEFAULT NULL,
  `user_group_id` varchar(10) NOT NULL DEFAULT '',
  `input_type_id` int(11) NOT NULL,
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `group` enum('front','back') NOT NULL DEFAULT 'front',
  `serialized` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;

INSERT INTO `setting` (`setting_id`, `site_id`, `user_group_id`, `input_type_id`, `key`, `value`, `group`, `serialized`)
VALUES
	(1,1,'1',1,'sitetitle','Albacore 2.5','front',0),
	(2,1,'1',1,'contact','','front',0),
	(3,1,'1',1,'google_analytics','','front',0);

/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table site
# ------------------------------------------------------------

DROP TABLE IF EXISTS `site`;

CREATE TABLE `site` (
  `site_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `ssl` varchar(255) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`site_id`),
  UNIQUE KEY `URL` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

LOCK TABLES `site` WRITE;
/*!40000 ALTER TABLE `site` DISABLE KEYS */;

INSERT INTO `site` (`site_id`, `name`, `url`, `ssl`, `status`)
VALUES
	(1,X'536974652031',X'687474703A2F2F6C6F63616C686F73742F616C6261636F72652F',X'',1);

/*!40000 ALTER TABLE `site` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table template
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template`;

CREATE TABLE `template` (
  `template_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `view_file_name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;

INSERT INTO `template` (`template_id`, `title`, `view_file_name`, `description`)
VALUES
	(2,'default','page','');

/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table template_section
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template_section`;

CREATE TABLE `template_section` (
  `template_section_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL,
  `position` varchar(11) NOT NULL DEFAULT '',
  PRIMARY KEY (`template_section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `template_section` WRITE;
/*!40000 ALTER TABLE `template_section` DISABLE KEYS */;

INSERT INTO `template_section` (`template_section_id`, `title`, `sort_order`, `position`)
VALUES
	(1,'top',1,''),
	(2,'main',2,'');

/*!40000 ALTER TABLE `template_section` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table template_section_to_content_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template_section_to_content_type`;

CREATE TABLE `template_section_to_content_type` (
  `template_section_id` int(11) NOT NULL,
  `content_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `template_section_to_content_type` WRITE;
/*!40000 ALTER TABLE `template_section_to_content_type` DISABLE KEYS */;

INSERT INTO `template_section_to_content_type` (`template_section_id`, `content_type_id`)
VALUES
	(3,1),
	(4,1),
	(5,1),
	(5,2),
	(2,1),
	(2,2),
	(1,2);

/*!40000 ALTER TABLE `template_section_to_content_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table template_setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template_setting`;

CREATE TABLE `template_setting` (
  `template_setting_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) DEFAULT NULL,
  `key` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`template_setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table template_setting_value
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template_setting_value`;

CREATE TABLE `template_setting_value` (
  `template_setting_value_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_setting_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `value` varchar(127) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`template_setting_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table template_to_template_section
# ------------------------------------------------------------

DROP TABLE IF EXISTS `template_to_template_section`;

CREATE TABLE `template_to_template_section` (
  `template_id` int(11) NOT NULL,
  `template_section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `template_to_template_section` WRITE;
/*!40000 ALTER TABLE `template_to_template_section` DISABLE KEYS */;

INSERT INTO `template_to_template_section` (`template_id`, `template_section_id`)
VALUES
	(2,1),
	(2,2);

/*!40000 ALTER TABLE `template_to_template_section` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`user_id`, `user_group_id`, `site_id`, `username`, `password`, `email`, `status`)
VALUES
	(1,1,1,'tjuna','$2a$10$k5bVgqX4uNZdAZXmnkoMXeDH4FO/x8qgGut8L82d66LUIPR8EGw/6','erik@tjuna.com',1),
	(3,2,1,'admin','$2a$10$TsYETjNysNX1c7/7mwHxSeFZKT3ItYVYRSuuljNptYQbGIn3f2pB.','erik@tjuna.com',1);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `user_group_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `ac_cms_access` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;

INSERT INTO `user_group` (`user_group_id`, `name`, `description`, `ac_cms_access`)
VALUES
	(1,'master','<p> Tjuna Master</p>',1),
	(2,'site admin',NULL,1);

/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_group_to_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_group_to_permission`;

CREATE TABLE `user_group_to_permission` (
  `user_group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `user_group_to_permission` WRITE;
/*!40000 ALTER TABLE `user_group_to_permission` DISABLE KEYS */;

INSERT INTO `user_group_to_permission` (`user_group_id`, `permission_id`)
VALUES
	(1,2),
	(1,3),
	(1,4),
	(1,5),
	(1,6),
	(1,7),
	(1,8),
	(1,9),
	(1,10),
	(1,11),
	(1,12),
	(1,13),
	(1,14),
	(1,15),
	(1,16),
	(1,23),
	(1,24),
	(1,25),
	(1,26);

/*!40000 ALTER TABLE `user_group_to_permission` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
