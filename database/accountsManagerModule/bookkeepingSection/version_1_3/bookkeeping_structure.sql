
/*Table structure for table `acm_bookkeeping_gift_voucher_payment` */
DROP TABLE IF EXISTS `acm_bookkeeping_gift_voucher_payment`;

CREATE TABLE `acm_bookkeeping_gift_voucher_payment` (
  `gift_voucher_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `date` date NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`gift_voucher_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_gift_voucher_payment_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_gift_voucher_payment_history`;

CREATE TABLE `acm_bookkeeping_gift_voucher_payment_history` (
  `gift_voucher_payment_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `gift_voucher_payment_id` int(11) NOT NULL,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `date` date NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`gift_voucher_payment_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_journal_entry_bulk_uploads` */
DROP TABLE IF EXISTS `acm_bookkeeping_journal_entry_bulk_uploads`;

CREATE TABLE `acm_bookkeeping_journal_entry_bulk_uploads` (
  `bulk_upload_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `uploaded_user_id` int(11) NOT NULL,
  `posted_user_id` int(11) NOT NULL,
  `uploaded_date` datetime NOT NULL,
  `posted_date` datetime NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`bulk_upload_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_journal_entry_bulk_upload_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_journal_entry_bulk_upload_entries`;

CREATE TABLE `acm_bookkeeping_journal_entry_bulk_upload_entries` (
  `bulk_upload_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `bulk_upload_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `location_id` varchar(150) DEFAULT '',
  `prime_entry_book_id` varchar(255) DEFAULT '',
  `stakeholder_id` varchar(50) DEFAULT '',
  `reference_no` varchar(150) DEFAULT '',
  `description` varchar(500) DEFAULT '',
  `debit_chart_of_account` varchar(255) DEFAULT '',
  `credit_chart_of_account` varchar(255) DEFAULT '',
  `amount` decimal(20,2) NOT NULL,
  `referetnce_transaction_reference_no` varchar(150) DEFAULT '',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`bulk_upload_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_journal_entry_bulk_upload_entries`
   ADD FOREIGN KEY (bulk_upload_id) REFERENCES acm_bookkeeping_journal_entry_bulk_uploads(bulk_upload_id) ON DELETE CASCADE;

/*Alter `acm_bookkeeping_journal_entries` Table*/
ALTER TABLE `acm_bookkeeping_journal_entries`
    CHANGE COLUMN `reference_no` `reference_no` varchar(150);

/*Alter `acm_bookkeeping_journal_entries_history` Table*/
ALTER TABLE `acm_bookkeeping_journal_entries_history`
    CHANGE COLUMN `reference_no` `reference_no` varchar(150);

/*Alter `acm_bookkeeping_journal_entries` Table*/
ALTER TABLE `acm_bookkeeping_journal_entries`
    ADD COLUMN `bulk_upload_id` int(11) DEFAULT '0' AFTER `journal_entry_id`;

/*Alter `acm_bookkeeping_journal_entries_history` Table*/
ALTER TABLE `acm_bookkeeping_journal_entries_history`
    ADD COLUMN `bulk_upload_id` int(11) DEFAULT '0' AFTER `journal_entry_id`;