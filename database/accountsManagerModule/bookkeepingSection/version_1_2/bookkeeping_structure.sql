
/*Alter `acm_bookkeeping_income_cheque` Table*/
ALTER TABLE `acm_bookkeeping_income_cheque`
    ADD COLUMN `has_many_reference_journal_entries` varchar(10) DEFAULT 'No' AFTER `cheque_reference_journal_entry_id`;

/*Table structure for table `acm_bookkeeping_income_cheque_reference_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_income_cheque_reference_journal_entries`;

CREATE TABLE `acm_bookkeeping_income_cheque_reference_journal_entries` (
  `reference_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `cheque_id` int(11) DEFAULT NULL,
  `cheque_reference_journal_entry_id` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`reference_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_income_cheque_reference_journal_entries`
   ADD FOREIGN KEY (cheque_id) REFERENCES acm_bookkeeping_income_cheque(cheque_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_dashboard_summary_figures` */
DROP TABLE IF EXISTS `acm_bookkeeping_dashboard_summary_figures`;

CREATE TABLE `acm_bookkeeping_dashboard_summary_figures` (
  `summary_figure_id` int(11) NOT NULL AUTO_INCREMENT,
  `summary_category_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `summary_category_main_type` varchar(50) NOT NULL,
  `summary_category_sub_type` varchar(50) NOT NULL,
  `summary_value` decimal(20,2) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`summary_figure_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


