
/*Table structure for table `acm_admin_chart_of_accounts` */
DROP TABLE IF EXISTS `acm_admin_chart_of_accounts`;

CREATE TABLE `acm_admin_chart_of_accounts` (
  `chart_of_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `chart_of_account_code` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `account_type` int(11) DEFAULT '0',
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`chart_of_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_admin_prime_entry_books` */
DROP TABLE IF EXISTS `acm_admin_prime_entry_books`;

CREATE TABLE `acm_admin_prime_entry_books` (
  `prime_entry_book_id` int(11) NOT NULL AUTO_INCREMENT,
  `prime_entry_book_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `has_a_reference_journal_entry` int(11) DEFAULT '0',
  `applicable_module_id` int(11) DEFAULT '0',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`prime_entry_book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_admin_prime_entry_book_chart_of_accounts` */
DROP TABLE IF EXISTS `acm_admin_prime_entry_book_chart_of_accounts`;

CREATE TABLE `acm_admin_prime_entry_book_chart_of_accounts` (
  `prime_entry_book_chart_of_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `prime_entry_book_id` int(11) NOT NULL,
  `chart_of_account_id` int(11) NOT NULL,
  `debit_or_credit` varchar(25) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`prime_entry_book_chart_of_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_admin_prime_entry_book_chart_of_accounts`
   ADD FOREIGN KEY (chart_of_account_id) REFERENCES acm_admin_chart_of_accounts(chart_of_account_id) ON DELETE CASCADE;

/*Table structure for table `acm_admin_bank` */
DROP TABLE IF EXISTS `acm_admin_bank`;

CREATE TABLE `acm_admin_bank` (
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_code` varchar(100) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_admin_bank_branch` */
DROP TABLE IF EXISTS `acm_admin_bank_branch`;

CREATE TABLE `acm_admin_bank_branch` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` int(11) NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_admin_bank_branch`
   ADD FOREIGN KEY (bank_id) REFERENCES acm_admin_bank(bank_id) ON DELETE CASCADE;

