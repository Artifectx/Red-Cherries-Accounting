/*Table structure for table `svm_dsm_admin_programs` */
DROP TABLE IF EXISTS `svm_dsm_admin_programs`;

CREATE TABLE `svm_dsm_admin_programs` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `coordinator_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `fund_available` decimal(20,4) DEFAULT '0.00',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_admin_programs_history` */
DROP TABLE IF EXISTS `svm_dsm_admin_programs_history`;

CREATE TABLE `svm_dsm_admin_programs_history` (
  `program_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `coordinator_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `fund_available` decimal(20,4) DEFAULT '0.00',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`program_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;