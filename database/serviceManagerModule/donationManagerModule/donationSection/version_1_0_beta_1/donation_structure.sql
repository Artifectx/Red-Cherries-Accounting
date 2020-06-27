
/*Table structure for table `svm_dsm_donation_donations` */
DROP TABLE IF EXISTS `svm_dsm_donation_donations`;

CREATE TABLE `svm_dsm_donation_donations` (
  `donation_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(255) NOT NULL,
  `program_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `donor_id` int(11) NOT NULL,
  `amount` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`donation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_donations_history` */
DROP TABLE IF EXISTS `svm_dsm_donation_donations_history`;

CREATE TABLE `svm_dsm_donation_donations_history` (
  `donation_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `donation_id` int(11) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `program_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `donor_id` int(11) NOT NULL,
  `amount` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`donation_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_donation_journal_entries` */
DROP TABLE IF EXISTS `svm_dsm_donation_donation_journal_entries`;

CREATE TABLE `svm_dsm_donation_donation_journal_entries` (
    `donation_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
    `donation_id` int(11) NOT NULL,
    `prime_entry_book_id` int(11) NOT NULL,
    `journal_entry_id` int(11) NOT NULL,
    `type` varchar(100) NOT NULL,
    `actioned_user_id` int(11) DEFAULT NULL,
    `action_date` datetime DEFAULT NULL,
    `last_action_status` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`donation_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_activities` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_activities`;

CREATE TABLE `svm_dsm_donation_program_activities` (
  `program_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_id` int(11) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `owner_id` int(11) NOT NULL,
  `activity_budget` decimal(20,4) NOT NULL,
  `activity_completion` decimal(20,4) NOT NULL,
  `actual_start_date` date NOT NULL,
  `actual_finished_date` date NOT NULL,
  `activity_cost` decimal(20,4) NOT NULL,
  `budget_varience` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`program_activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_activities_history` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_activities_history`;

CREATE TABLE `svm_dsm_donation_program_activities_history` (
  `program_activity_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_activity_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `owner_id` int(11) NOT NULL,
  `activity_budget` decimal(20,4) NOT NULL,
  `activity_completion` decimal(20,4) NOT NULL,
  `actual_start_date` date NOT NULL,
  `actual_finished_date` date NOT NULL,
  `activity_cost` decimal(20,4) NOT NULL,
  `budget_varience` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`program_activity_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_activity_budget_issue` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_activity_budget_issue`;

CREATE TABLE `svm_dsm_donation_program_activity_budget_issue` (
  `budget_issue_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `program_activity_id` int(11) NOT NULL,
  `budget_issue_amount` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`budget_issue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_activity_budget_issue_history` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_activity_budget_issue_history`;

CREATE TABLE `svm_dsm_donation_program_activity_budget_issue_history` (
  `budget_issue_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `budget_issue_id` int(11) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `program_activity_id` int(11) NOT NULL,
  `budget_issue_amount` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`budget_issue_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_budget_issue_journal_entries` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_budget_issue_journal_entries`;

CREATE TABLE `svm_dsm_donation_program_budget_issue_journal_entries` (
    `budget_issue_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
    `program_activity_id` int(11) NOT NULL,
    `prime_entry_book_id` int(11) NOT NULL,
    `journal_entry_id` int(11) NOT NULL,
    `type` varchar(100) NOT NULL,
    `actioned_user_id` int(11) DEFAULT NULL,
    `action_date` datetime DEFAULT NULL,
    `last_action_status` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`budget_issue_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_activity_budget_return` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_activity_budget_return`;

CREATE TABLE `svm_dsm_donation_program_activity_budget_return` (
  `budget_return_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `program_activity_id` int(11) NOT NULL,
  `budget_return_amount` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`budget_return_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_activity_budget_return_history` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_activity_budget_return_history`;

CREATE TABLE `svm_dsm_donation_program_activity_budget_return_history` (
  `budget_return_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `budget_return_id` int(11) NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `program_activity_id` int(11) NOT NULL,
  `budget_return_amount` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`budget_return_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `svm_dsm_donation_program_budget_return_journal_entries` */
DROP TABLE IF EXISTS `svm_dsm_donation_program_budget_return_journal_entries`;

CREATE TABLE `svm_dsm_donation_program_budget_return_journal_entries` (
    `budget_return_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
    `program_activity_id` int(11) NOT NULL,
    `prime_entry_book_id` int(11) NOT NULL,
    `journal_entry_id` int(11) NOT NULL,
    `type` varchar(100) NOT NULL,
    `actioned_user_id` int(11) DEFAULT NULL,
    `action_date` datetime DEFAULT NULL,
    `last_action_status` varchar(100) DEFAULT NULL,
    PRIMARY KEY (`budget_return_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;