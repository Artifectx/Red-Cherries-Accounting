
/*Table structure for table `urm_user_roles_permissions` */
DROP TABLE IF EXISTS `urm_user_roles_permissions`;

CREATE TABLE `urm_user_roles_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_section_feature_id` int(11) DEFAULT NULL,
  `permission_type` varchar(10) DEFAULT '',
  `permission` varchar(255) DEFAULT NULL,
  `permission_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `module_id` (`module_section_feature_id`),
  CONSTRAINT `urm_user_roles_permissions_ibfk_1` FOREIGN KEY (`module_section_feature_id`) REFERENCES `system_module_section_features` (`module_section_feature_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_user_roles` */
DROP TABLE IF EXISTS `urm_user_roles_user_roles`;

CREATE TABLE `urm_user_roles_user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_role_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(255) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_default_user_role_permissions` */
DROP TABLE IF EXISTS `urm_user_roles_default_user_role_permissions`;

CREATE TABLE `urm_user_roles_default_user_role_permissions` (
  `role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  KEY `permission_id` (`permission_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `urm_user_roles_default_user_role_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `urm_user_roles_permissions` (`permission_id`) ON DELETE CASCADE,
  CONSTRAINT `urm_user_roles_default_user_role_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `urm_user_roles_user_roles` (`role_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_derive_user_roles` */
DROP TABLE IF EXISTS `urm_user_roles_derive_user_roles`;

CREATE TABLE `urm_user_roles_derive_user_roles` (
  `derive_user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `derive_user_role_name` varchar(50) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`derive_user_role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `urm_user_roles_derive_user_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `urm_user_roles_user_roles` (`role_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_derive_user_role_permissions` */
DROP TABLE IF EXISTS `urm_user_roles_derive_user_role_permissions`;

CREATE TABLE `urm_user_roles_derive_user_role_permissions` (
  `derive_user_role_id` int(11) DEFAULT NULL,
  `permission_id` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  KEY `derive_user_role_id` (`derive_user_role_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `urm_user_roles_derive_user_role_permissions_ibfk_1` FOREIGN KEY (`derive_user_role_id`) REFERENCES `urm_user_roles_derive_user_roles` (`derive_user_role_id`) ON DELETE CASCADE,
  CONSTRAINT `urm_user_roles_derive_user_role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `urm_user_roles_permissions` (`permission_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_permissions_advanced` */
DROP TABLE IF EXISTS `urm_user_roles_permissions_advanced`;

CREATE TABLE `urm_user_roles_permissions_advanced` (
  `advanced_permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `child_permission_id` int(11) NOT NULL,
  PRIMARY KEY (`advanced_permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_user` */
DROP TABLE IF EXISTS `urm_user_roles_user`;

CREATE TABLE `urm_user_roles_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user id',
  `people_id` int(11) DEFAULT NULL,
  `user_name` varchar(25) DEFAULT NULL COMMENT 'user name',
  `user_password` varchar(255) DEFAULT NULL COMMENT 'password',
  `salt` varchar(255) DEFAULT NULL COMMENT 'Random Salt for OpenSSL',
  `status` int(2) DEFAULT '1' COMMENT 'enable=1 disable=0',
  `theme` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `main_nav_btn` varchar(5) DEFAULT NULL,
  `role_id` int(11) DEFAULT '3',
  `derive_user_role_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  `default_system_module_status` int(2) DEFAULT '0',
  `default_system_module` varchar(255) DEFAULT NULL,
  `dashboard_url` varchar(255) DEFAULT NULL,
  `accessible_warehouses` varchar(20) DEFAULT 'All',
  `accessible_locations` varchar(20) DEFAULT 'All',
  PRIMARY KEY (`user_id`),
  KEY `derive_user_role_id` (`derive_user_role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `urm_user_roles_user_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `urm_user_roles_user_roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_user_accessible_locations` */
DROP TABLE IF EXISTS `urm_user_roles_user_accessible_locations`;

CREATE TABLE `urm_user_roles_user_accessible_locations` (
  `accessible_location_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`accessible_location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_user_accessible_warehouses` */
DROP TABLE IF EXISTS `urm_user_roles_user_accessible_warehouses`;

CREATE TABLE `urm_user_roles_user_accessible_warehouses` (
  `accessible_warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`accessible_warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Table structure for table `urm_user_roles_user_not_accessible_prime_entry_books` */
DROP TABLE IF EXISTS `urm_user_roles_user_not_accessible_prime_entry_books`;

CREATE TABLE `urm_user_roles_user_not_accessible_prime_entry_books` (
  `not_accessible_prime_entry_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`not_accessible_prime_entry_book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;