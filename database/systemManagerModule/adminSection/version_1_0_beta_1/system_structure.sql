
/*Table structure for table `system_modules` */
DROP TABLE IF EXISTS `system_modules`;

CREATE TABLE `system_modules` (
  `system_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_module` varchar(255) DEFAULT NULL,
  `system_modules_status` tinyint(1) DEFAULT NULL,
  `status_change_option` tinyint(1) DEFAULT NULL,
  `system_module_image_url` varchar(255) DEFAULT NULL,
  `dashboard_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`system_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `system_module_sections` */
DROP TABLE IF EXISTS `system_module_sections`;

CREATE TABLE `system_module_sections` (
  `module_section_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_section_name` varchar(255) DEFAULT NULL,
  `module_section_status` tinyint(1) DEFAULT NULL,
  `status_change_option` tinyint(1) DEFAULT NULL COMMENT 'true=1 or false=0',
  `system_module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`module_section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `system_module_section_features` */
DROP TABLE IF EXISTS `system_module_section_features`;

CREATE TABLE `system_module_section_features` (
  `module_section_feature_id` int(11) NOT NULL DEFAULT '0',
  `module_section_id` int(11) DEFAULT NULL,
  `module_section_feature_name` varchar(255) DEFAULT NULL,
  `showing_status` varchar(10) DEFAULT 'Yes',
  PRIMARY KEY (`module_section_feature_id`),
  KEY `module_section_id` (`module_section_id`),
  CONSTRAINT `system_module_section_features_ibfk_1` FOREIGN KEY (`module_section_id`) REFERENCES `system_module_sections` (`module_section_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `system_common_web_settings` */
DROP TABLE IF EXISTS `system_common_web_settings`;

CREATE TABLE `system_common_web_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system_module` varchar(255) DEFAULT NULL,
  `dashboard_url` varchar(255) DEFAULT NULL,
  `main_nav_btn` varchar(5) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `system_country` */
DROP TABLE IF EXISTS `system_country`;

CREATE TABLE `system_country` (
  `country_code` CHAR(2) not NULL DEFAULT '',
  `name` VARCHAR(80) not NULL DEFAULT '',
  `country_name` VARCHAR(80) not NULL DEFAULT '',
  `iso3` CHAR(3) DEFAULT NULL,
  `numcode` SMALLINT(6) DEFAULT NULL,
  PRIMARY KEY  (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `system_common_configurations` */
DROP TABLE IF EXISTS `system_common_configurations`;

CREATE TABLE `system_common_configurations` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `config_filed_name` varchar(255) DEFAULT NULL,
  `config_filed_value` text DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `system_api_keys` */
DROP TABLE IF EXISTS `system_api_keys`;

CREATE TABLE `system_api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rest_api_key` varchar(255) DEFAULT NULL,
  `level` int(2) DEFAULT NULL,
  `ignore_limits` tinyint(1) DEFAULT '0',
  `is_private_key` tinyint(1) DEFAULT '0',
  `ip_addresses` text,
  `date_created` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

/*Table structure for table `system_api_access` */
DROP TABLE IF EXISTS `system_api_access`;

CREATE TABLE `system_api_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL DEFAULT '',
  `all_access` tinyint(1) NOT NULL DEFAULT '0',
  `controller` varchar(50) NOT NULL DEFAULT '',
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `system_api_logs` */
DROP TABLE IF EXISTS `system_api_logs`;

CREATE TABLE `system_api_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `system_sub_modules` */
DROP TABLE IF EXISTS `system_sub_modules`;

CREATE TABLE `system_sub_modules` (
  `system_sub_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_module_id` int(11) DEFAULT NULL,
  `system_sub_module` varchar(255) DEFAULT NULL,
  `system_sub_modules_status` tinyint(1) DEFAULT NULL,
  `status_change_option` tinyint(1) DEFAULT NULL,
  `system_sub_module_image_url` varchar(255) DEFAULT NULL,
  `system_sub_module_dashboard_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`system_sub_module_id`),
  KEY `system_module_id` (`system_module_id`),
  CONSTRAINT `system_sub_modules_ibfk_1` FOREIGN KEY (`system_module_id`) REFERENCES `system_modules` (`system_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Alter `admin_module` Table*/
ALTER TABLE `system_module_sections`
    ADD COLUMN `system_sub_module_id` int(11) DEFAULT NULL AFTER `system_module_id`;

/*Table structure for table `system_language_strings` */
DROP TABLE IF EXISTS `system_language_strings`;

CREATE TABLE `system_language_strings` (
  `language_string_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_string` varchar(500) DEFAULT NULL,
  `language_string_type` varchar(100) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT '',
  `system_module_id` int(11) DEFAULT NULL,
  `screen_name` varchar(255) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`language_string_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `system_language_translations` */
DROP TABLE IF EXISTS `system_language_translations`;

CREATE TABLE `system_language_translations` (
  `language_translation_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_string_id` int(11) DEFAULT NULL,
  `language_name` varchar(100) DEFAULT NULL,
  `translated_string` varchar(500) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`language_translation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `system_language_translations_generation_status` */
DROP TABLE IF EXISTS `system_language_translations_generation_status`;

CREATE TABLE `system_language_translations_generation_status` (
  `translation_generation_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(100) DEFAULT NULL,
  `generation_status` varchar(255) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`translation_generation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
