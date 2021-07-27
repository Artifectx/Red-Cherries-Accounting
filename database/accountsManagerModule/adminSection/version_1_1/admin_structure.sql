
/*Table structure for table `acm_admin_financial_year_ends` */
DROP TABLE IF EXISTS `acm_admin_financial_year_ends`;

CREATE TABLE `acm_admin_financial_year_ends` (
  `financial_year_id` int(11) NOT NULL AUTO_INCREMENT,
  `financial_year_start_date` date DEFAULT NULL,
  `financial_year_end_date` date DEFAULT NULL,
  `year_end_process_status` varchar(50) DEFAULT 'Pending',
  `year_end_process_user_id` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`financial_year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;