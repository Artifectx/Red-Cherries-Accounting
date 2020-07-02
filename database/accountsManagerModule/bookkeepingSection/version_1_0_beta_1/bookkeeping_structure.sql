
/*Table structure for table `acm_bookkeeping_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_journal_entries`;

CREATE TABLE `acm_bookkeeping_journal_entries` (
  `journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `prime_entry_book_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `payee_payer_type` varchar(50) DEFAULT '',
  `delivery_route_id` int(11) DEFAULT '0',
  `payee_payer_id` int(11) DEFAULT '0',
  `due_date` date DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `reference_no` varchar(20) DEFAULT '',
  `should_have_a_payment_journal_entry` varchar(10) DEFAULT 'No',
  `reference_transaction_type_id` int(11) DEFAULT '0',
  `reference_transaction_id` int(11) DEFAULT '0',
  `reference_journal_entry_id` int(11) DEFAULT '0',
  `balance_amount` decimal(20,2) DEFAULT '0.00',
  `description` varchar(255) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  `post_type` varchar(100) DEFAULT '',
  `status` varchar(50) DEFAULT 'Open',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_journal_entries_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_journal_entries_history`;

CREATE TABLE `acm_bookkeeping_journal_entries_history` (
  `journal_entry_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_entry_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `payee_payer_type` varchar(50) DEFAULT '',
  `delivery_route_id` int(11) DEFAULT '0',
  `payee_payer_id` int(11) DEFAULT '0',
  `due_date` date DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `reference_no` varchar(20) DEFAULT '',
  `should_have_a_payment_journal_entry` varchar(10) DEFAULT 'No',
  `reference_transaction_type_id` int(11) DEFAULT '0',
  `reference_transaction_id` int(11) DEFAULT '0',
  `reference_journal_entry_id` int(11) DEFAULT '0',
  `balance_amount` decimal(20,2) DEFAULT '0.00',
  `description` varchar(255) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL,
  `post_type` varchar(100) DEFAULT '',
  `status` varchar(50) DEFAULT 'Open',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`journal_entry_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_journal_entries_history`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_journal_entry_claim_references` */
DROP TABLE IF EXISTS `acm_bookkeeping_journal_entry_claim_references`;

CREATE TABLE `acm_bookkeeping_journal_entry_claim_references` (
  `claim_reference_id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_entry_id` int(11) NOT NULL,
  `claim_reference_journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`claim_reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_gl_transactions` */
DROP TABLE IF EXISTS `acm_bookkeeping_gl_transactions`;

CREATE TABLE `acm_bookkeeping_gl_transactions` (
  `gl_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) DEFAULT NULL,
  `chart_of_account_id` int(11) NOT NULL,
  `debit_value` decimal(20,2) DEFAULT '0.00',
  `credit_value` decimal(20,2) DEFAULT '0.00',
  `transaction_complete` varchar(20) DEFAULT 'Yes',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gl_transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_gl_transactions`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE,
   ADD FOREIGN KEY (chart_of_account_id) REFERENCES acm_admin_chart_of_accounts(chart_of_account_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_gl_transactions_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_gl_transactions_history`;

CREATE TABLE `acm_bookkeeping_gl_transactions_history` (
  `gl_transaction_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `gl_transaction_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) DEFAULT NULL,
  `chart_of_account_id` int(11) NOT NULL,
  `debit_value` decimal(20,2) DEFAULT '0.00',
  `credit_value` decimal(20,2) DEFAULT '0.00',
  `transaction_complete` varchar(20) DEFAULT 'Yes',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gl_transaction_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_gl_transactions_history`
   ADD FOREIGN KEY (gl_transaction_id) REFERENCES acm_bookkeeping_gl_transactions(gl_transaction_id) ON DELETE CASCADE,
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE,
   ADD FOREIGN KEY (chart_of_account_id) REFERENCES acm_admin_chart_of_accounts(chart_of_account_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_gl_transactions_for_previous_years` */
DROP TABLE IF EXISTS `acm_bookkeeping_gl_transactions_for_previous_years`;

CREATE TABLE `acm_bookkeeping_gl_transactions_for_previous_years` (
  `gl_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) DEFAULT NULL,
  `chart_of_account_id` int(11) NOT NULL,
  `debit_value` decimal(20,2) DEFAULT '0.00',
  `credit_value` decimal(20,2) DEFAULT '0.00',
  `transaction_complete` varchar(20) DEFAULT 'Yes',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gl_transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_gl_transactions_for_previous_years`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE,
   ADD FOREIGN KEY (chart_of_account_id) REFERENCES acm_admin_chart_of_accounts(chart_of_account_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_purchase_note` */
DROP TABLE IF EXISTS `acm_bookkeeping_purchase_note`;

CREATE TABLE `acm_bookkeeping_purchase_note` (
  `purchase_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `type` varchar(100) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`purchase_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_purchase_note_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_purchase_note_history`;

CREATE TABLE `acm_bookkeeping_purchase_note_history` (
  `purchase_note_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_note_id` int(11) NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `type` varchar(100) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`purchase_note_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_purchase_note_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_purchase_note_journal_entries`;

CREATE TABLE `acm_bookkeeping_purchase_note_journal_entries` (
  `purchase_note_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_note_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`purchase_note_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_purchase_note_journal_entries`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_sales_note` */
DROP TABLE IF EXISTS `acm_bookkeeping_sales_note`;

CREATE TABLE `acm_bookkeeping_sales_note` (
  `sales_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `territory_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `sales_amount` decimal(20,2) DEFAULT NULL,
  `free_issue_amount` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT NULL,
  `amount_payable` decimal(20,2) DEFAULT '0.00',
  `cheque_payment_amount` decimal(20,2) DEFAULT '0.00',
  `customer_saleable_return_id` int(11) DEFAULT '0',
  `customer_market_return_id` int(11) DEFAULT '0',
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sales_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_sales_note_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_sales_note_history`;

CREATE TABLE `acm_bookkeeping_sales_note_history` (
  `sales_note_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_note_id` int(11) NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `territory_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `sales_amount` decimal(20,2) DEFAULT NULL,
  `free_issue_amount` decimal(20,2) DEFAULT NULL,
  `discount` decimal(20,2) DEFAULT NULL,
  `amount_payable` decimal(20,2) DEFAULT '0.00',
  `cheque_payment_amount` decimal(20,2) DEFAULT '0.00',
  `customer_saleable_return_id` int(11) DEFAULT '0',
  `customer_market_return_id` int(11) DEFAULT '0',
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sales_note_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_sales_note_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_sales_note_journal_entries`;

CREATE TABLE `acm_bookkeeping_sales_note_journal_entries` (
  `sales_note_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_note_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `transaction_type_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sales_note_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_sales_note_journal_entries`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_customer_return_note` */
DROP TABLE IF EXISTS `acm_bookkeeping_customer_return_note`;

CREATE TABLE `acm_bookkeeping_customer_return_note` (
  `customer_return_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `territory_id` int(11) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`customer_return_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_customer_return_note_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_customer_return_note_history`;

CREATE TABLE `acm_bookkeeping_customer_return_note_history` (
  `customer_return_note_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_return_note_id` int(11) NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `territory_id` int(11) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`customer_return_note_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_customer_return_note_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_customer_return_note_journal_entries`;

CREATE TABLE `acm_bookkeeping_customer_return_note_journal_entries` (
  `customer_return_note_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_return_note_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `transaction_type_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`customer_return_note_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_customer_return_note_journal_entries`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_supplier_return_note` */
DROP TABLE IF EXISTS `acm_bookkeeping_supplier_return_note`;

CREATE TABLE `acm_bookkeeping_supplier_return_note` (
  `supplier_return_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`supplier_return_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_supplier_return_note_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_supplier_return_note_history`;

CREATE TABLE `acm_bookkeeping_supplier_return_note_history` (
  `supplier_return_note_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_return_note_id` int(11) NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `amount` decimal(20,2) DEFAULT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`supplier_return_note_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_supplier_return_note_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_supplier_return_note_journal_entries`;

CREATE TABLE `acm_bookkeeping_supplier_return_note_journal_entries` (
  `supplier_return_note_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_return_note_id` int(11) NOT NULL,
  `prime_entry_book_id` int(11) NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `transaction_type_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`supplier_return_note_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_supplier_return_note_journal_entries`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_receive_payment` */
DROP TABLE IF EXISTS `acm_bookkeeping_receive_payment`;

CREATE TABLE `acm_bookkeeping_receive_payment` (
  `receive_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `payer_type` varchar(50) NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `payer_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`receive_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_receive_payment_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_receive_payment_history`;

CREATE TABLE `acm_bookkeeping_receive_payment_history` (
  `receive_payment_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_payment_id` int(11) NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `payer_type` varchar(50) NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `payer_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`receive_payment_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_receive_payment_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_receive_payment_journal_entries`;

CREATE TABLE `acm_bookkeeping_receive_payment_journal_entries` (
  `receive_payment_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_payment_id` int(11) NOT NULL,
  `receive_payment_method_id` int(11) DEFAULT '0',
  `prime_entry_book_id` int(11) NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`receive_payment_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_receive_payment_journal_entries`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_make_payment` */
DROP TABLE IF EXISTS `acm_bookkeeping_make_payment`;

CREATE TABLE `acm_bookkeeping_make_payment` (
  `make_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `payee_type` varchar(50) NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `payee_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`make_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_make_payment_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_make_payment_history`;

CREATE TABLE `acm_bookkeeping_make_payment_history` (
  `make_payment_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `make_payment_id` int(11) NOT NULL,
  `reference_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `payee_type` varchar(50) NOT NULL,
  `delivery_route_id` int(11) DEFAULT '0',
  `payee_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `remark` varchar(255) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `added_date` datetime DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`make_payment_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_make_payment_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_make_payment_journal_entries`;

CREATE TABLE `acm_bookkeeping_make_payment_journal_entries` (
  `make_payment_journal_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `make_payment_id` int(11) NOT NULL,
  `make_payment_method_id` int(11) DEFAULT '0',
  `prime_entry_book_id` int(11) NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`make_payment_journal_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_make_payment_journal_entries`
   ADD FOREIGN KEY (journal_entry_id) REFERENCES acm_bookkeeping_journal_entries(journal_entry_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_income_cheque` */
DROP TABLE IF EXISTS `acm_bookkeeping_income_cheque`;

CREATE TABLE `acm_bookkeeping_income_cheque` (
  `cheque_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `payer_id` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `reference_no` varchar(100) NOT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `bank` varchar(150) DEFAULT NULL,
  `branch` varchar(150) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `third_party_cheque` varchar(10) DEFAULT 'No',
  `amount` decimal(10,4) NOT NULL,
  `crossed_cheque` varchar(10) DEFAULT 'No',
  `cheque_reference_journal_entry_id` int(11) DEFAULT '0',
  `cheque_deposit_prime_entry_book_id` int(11) DEFAULT '0',
  `status` varchar(100) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`cheque_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_income_cheque_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_income_cheque_history`;

CREATE TABLE `acm_bookkeeping_income_cheque_history` (
  `cheque_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `cheque_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `payer_id` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `reference_no` varchar(100) NOT NULL,
  `cheque_number` varchar(255) DEFAULT NULL,
  `bank` varchar(150) DEFAULT NULL,
  `branch` varchar(150) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `third_party_cheque` varchar(10) DEFAULT 'No',
  `amount` decimal(10,4) NOT NULL,
  `crossed_cheque` varchar(10) DEFAULT 'No',
  `cheque_reference_journal_entry_id` int(11) DEFAULT '0',
  `cheque_deposit_prime_entry_book_id` int(11) DEFAULT '0',
  `status` varchar(100) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`cheque_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_expense_cheque` */
DROP TABLE IF EXISTS `acm_bookkeeping_expense_cheque`;

CREATE TABLE `acm_bookkeeping_expense_cheque` (
  `cheque_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `reference_no` varchar(100) DEFAULT '',
  `payee_id` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `cheque_number` varchar(255) DEFAULT NULL,
  `bank` varchar(150) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `cheque_payment_prime_entry_book_id` int(11) DEFAULT '0',
  `status` varchar(100) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`cheque_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_expense_cheque_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_expense_cheque_history`;

CREATE TABLE `acm_bookkeeping_expense_cheque_history` (
  `cheque_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `cheque_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `reference_no` varchar(100) DEFAULT '',
  `payee_id` int(11) DEFAULT '0',
  `location_id` int(11) DEFAULT '0',
  `cheque_number` varchar(255) DEFAULT NULL,
  `bank` varchar(150) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `cheque_payment_prime_entry_book_id` int(11) DEFAULT '0',
  `status` varchar(100) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`cheque_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_sales_note_receive_payment` */
DROP TABLE IF EXISTS `acm_bookkeeping_sales_note_receive_payment`;

CREATE TABLE `acm_bookkeeping_sales_note_receive_payment` (
  `sales_note_receive_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_note_id` int(11) NOT NULL,
  `receive_cash_payment_method_id` int(11) DEFAULT '0',
  `receive_cheque_payment_method_id` int(11) DEFAULT '0',
  `receive_credit_card_payment_method_id` int(11) DEFAULT '0',
  `added_from` varchar(100) DEFAULT '',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sales_note_receive_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_sales_note_cancelled_journal_entries` */
DROP TABLE IF EXISTS `acm_bookkeeping_sales_note_cancelled_journal_entries`;

CREATE TABLE `acm_bookkeeping_sales_note_cancelled_journal_entries` (
  `sales_note_cancelled_id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_note_id` int(11) NOT NULL,
  `sales_note_sales_entry_journal_entry_id` int(11) DEFAULT '0',
  `sales_note_cost_entry_journal_entry_id` int(11) DEFAULT '0',
  `sales_note_discount_entry_journal_entry_id` int(11) DEFAULT '0',
  `sales_note_free_issue_entry_journal_entry_id` int(11) DEFAULT '0',
  `customer_saleable_return_sales_entry_journal_entry_id` int(11) DEFAULT '0',
  `customer_saleable_return_cost_entry_journal_entry_id` int(11) DEFAULT '0',
  `customer_market_return_sales_entry_journal_entry_id` int(11) DEFAULT '0',
  `customer_market_return_cost_entry_journal_entry_id` int(11) DEFAULT '0',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sales_note_cancelled_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_make_payment_method_records` */
DROP TABLE IF EXISTS `acm_bookkeeping_make_payment_method_records`;

CREATE TABLE `acm_bookkeeping_make_payment_method_records` (
  `make_payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `make_payment_id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `cash_payment_id` int(11) DEFAULT NULL,
  `payment_account_id` int(11) DEFAULT NULL,
  `cheque_type` varchar(20) DEFAULT NULL,
  `cheque_id` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`make_payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_make_payment_method_records`
    ADD FOREIGN KEY (make_payment_id) REFERENCES acm_bookkeeping_make_payment(make_payment_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_make_payment_method_records_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_make_payment_method_records_history`;

CREATE TABLE `acm_bookkeeping_make_payment_method_records_history` (
  `make_payment_method_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `make_payment_method_id` int(11) NOT NULL,
  `make_payment_id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `cash_payment_id` int(11) DEFAULT NULL,
  `payment_account_id` int(11) DEFAULT NULL,
  `cheque_type` varchar(20) DEFAULT NULL,
  `cheque_id` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`make_payment_method_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_make_payment_method_records_history`
    ADD FOREIGN KEY (make_payment_id) REFERENCES acm_bookkeeping_make_payment(make_payment_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_make_payment_reference_transactions` */
DROP TABLE IF EXISTS `acm_bookkeeping_make_payment_reference_transactions`;

CREATE TABLE `acm_bookkeeping_make_payment_reference_transactions` (
  `make_payment_reference_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `make_payment_id` int(11) NOT NULL,
  `reference_transaction_type_id` int(11) NOT NULL,
  `reference_transaction_id` int(11) NOT NULL,
  `reference_journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`make_payment_reference_transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_make_payment_reference_transactions`
    ADD FOREIGN KEY (make_payment_id) REFERENCES acm_bookkeeping_make_payment(make_payment_id) ON DELETE CASCADE;

ALTER TABLE `acm_bookkeeping_make_payment_journal_entries`
    ADD FOREIGN KEY (make_payment_id) REFERENCES acm_bookkeeping_make_payment(make_payment_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_make_payment_reference_trans_histry` */
DROP TABLE IF EXISTS `acm_bookkeeping_make_payment_reference_trans_histry`;

CREATE TABLE `acm_bookkeeping_make_payment_reference_trans_histry` (
  `make_payment_reference_transaction_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `make_payment_reference_transaction_id` int(11) NOT NULL,
  `make_payment_id` int(11) NOT NULL,
  `reference_transaction_type_id` int(11) NOT NULL,
  `reference_transaction_id` int(11) NOT NULL,
  `reference_journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`make_payment_reference_transaction_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_make_payment_reference_trans_histry`
    ADD FOREIGN KEY (make_payment_id) REFERENCES acm_bookkeeping_make_payment(make_payment_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_receive_payment_method_records` */
DROP TABLE IF EXISTS `acm_bookkeeping_receive_payment_method_records`;

CREATE TABLE `acm_bookkeeping_receive_payment_method_records` (
  `receive_payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_payment_id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `card_type` varchar(50) DEFAULT '',
  `cash_payment_id` int(11) DEFAULT '0',
  `cheque_id` int(11) DEFAULT '0',
  `credit_card_payment_id` int(11) DEFAULT '0',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`receive_payment_method_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_receive_payment_method_records`
    ADD FOREIGN KEY (receive_payment_id) REFERENCES acm_bookkeeping_receive_payment(receive_payment_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_receive_payment_method_records_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_receive_payment_method_records_history`;

CREATE TABLE `acm_bookkeeping_receive_payment_method_records_history` (
  `receive_payment_method_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_payment_method_id` int(11) NOT NULL,
  `receive_payment_id` int(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `card_type` varchar(50) DEFAULT '',
  `cash_payment_id` int(11) DEFAULT '0',
  `cheque_id` int(11) DEFAULT '0',
  `credit_card_payment_id` int(11) DEFAULT '0',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`receive_payment_method_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_receive_payment_method_records_history`
    ADD FOREIGN KEY (receive_payment_id) REFERENCES acm_bookkeeping_receive_payment(receive_payment_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_receive_payment_reference_transactions` */
DROP TABLE IF EXISTS `acm_bookkeeping_receive_payment_reference_transactions`;

CREATE TABLE `acm_bookkeeping_receive_payment_reference_transactions` (
  `receive_payment_reference_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_payment_id` int(11) NOT NULL,
  `reference_transaction_type_id` int(11) NOT NULL,
  `reference_transaction_id` int(11) NOT NULL,
  `reference_journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`receive_payment_reference_transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_receive_payment_reference_transactions`
    ADD FOREIGN KEY (receive_payment_id) REFERENCES acm_bookkeeping_receive_payment(receive_payment_id) ON DELETE CASCADE;

ALTER TABLE `acm_bookkeeping_receive_payment_journal_entries`
    ADD FOREIGN KEY (receive_payment_id) REFERENCES acm_bookkeeping_receive_payment(receive_payment_id) ON DELETE CASCADE;

/*Table structure for table `acm_bookkeeping_receive_payment_reference_trans_histry` */
DROP TABLE IF EXISTS `acm_bookkeeping_receive_payment_reference_trans_histry`;

CREATE TABLE `acm_bookkeeping_receive_payment_reference_trans_histry` (
  `receive_payment_reference_transaction_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_payment_reference_transaction_id` int(11) NOT NULL,
  `receive_payment_id` int(11) NOT NULL,
  `reference_transaction_type_id` int(11) NOT NULL,
  `reference_transaction_id` int(11) NOT NULL,
  `reference_journal_entry_id` int(11) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`receive_payment_reference_transaction_history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

ALTER TABLE `acm_bookkeeping_receive_payment_reference_trans_histry`
    ADD FOREIGN KEY (receive_payment_id) REFERENCES acm_bookkeeping_receive_payment(receive_payment_id) ON DELETE CASCADE;

/*Alter `acm_bookkeeping_sales_note` Table*/
ALTER TABLE `acm_bookkeeping_sales_note`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount_payable`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `customer_return_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_sales_note_history` Table*/
ALTER TABLE `acm_bookkeeping_sales_note_history`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount_payable`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `customer_return_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_customer_return_note` Table*/
ALTER TABLE `acm_bookkeeping_customer_return_note`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount`,
  ADD COLUMN `cheque_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cash_payment_amount`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `sales_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_customer_return_note_history` Table*/
ALTER TABLE `acm_bookkeeping_customer_return_note_history`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount`,
  ADD COLUMN `cheque_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cash_payment_amount`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `sales_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_purchase_note` Table*/
ALTER TABLE `acm_bookkeeping_purchase_note`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount`,
  ADD COLUMN `cheque_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cash_payment_amount`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `supplier_return_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_purchase_note_history` Table*/
ALTER TABLE `acm_bookkeeping_purchase_note_history`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount`,
  ADD COLUMN `cheque_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cash_payment_amount`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `supplier_return_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_supplier_return_note` Table*/
ALTER TABLE `acm_bookkeeping_supplier_return_note`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount`,
  ADD COLUMN `cheque_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cash_payment_amount`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `purchase_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_supplier_return_note_history` Table*/
ALTER TABLE `acm_bookkeeping_supplier_return_note_history`
  ADD COLUMN `cash_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `amount`,
  ADD COLUMN `cheque_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cash_payment_amount`,
  ADD COLUMN `credit_card_payment_amount` decimal(20,2) DEFAULT '0.00' AFTER `cheque_payment_amount`,
  ADD COLUMN `balance_payment` decimal(20,2) DEFAULT '0.00' AFTER `credit_card_payment_amount`,
  ADD COLUMN `purchase_note_claimed` decimal(20,2) DEFAULT '0.00' AFTER `balance_payment`,
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;

/*Alter `acm_bookkeeping_receive_payment_reference_transactions` Table*/
ALTER TABLE `acm_bookkeeping_receive_payment_reference_transactions`
  ADD COLUMN `claim_amount` decimal(20,2) DEFAULT '0.00' AFTER `reference_journal_entry_id`;

/*Alter `acm_bookkeeping_receive_payment_reference_trans_histry` Table*/
ALTER TABLE `acm_bookkeeping_receive_payment_reference_trans_histry`
  ADD COLUMN `claim_amount` decimal(20,2) DEFAULT '0.00' AFTER `reference_journal_entry_id`;

/*Alter `acm_bookkeeping_make_payment_reference_transactions` Table*/
ALTER TABLE `acm_bookkeeping_make_payment_reference_transactions`
  ADD COLUMN `claim_amount` decimal(20,2) DEFAULT '0.00' AFTER `reference_journal_entry_id`;

/*Alter `acm_bookkeeping_make_payment_reference_trans_histry` Table*/
ALTER TABLE `acm_bookkeeping_make_payment_reference_trans_histry`
  ADD COLUMN `claim_amount` decimal(20,2) DEFAULT '0.00' AFTER `reference_journal_entry_id`;

/*Table structure for table `acm_bookkeeping_cash_payment` */
DROP TABLE IF EXISTS `acm_bookkeeping_cash_payment`;

CREATE TABLE `acm_bookkeeping_cash_payment` (
  `cash_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `date` date NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`cash_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_cash_payment_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_cash_payment_history`;

CREATE TABLE `acm_bookkeeping_cash_payment_history` (
  `cash_payment_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `cash_payment_id` int(11) NOT NULL,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `date` date NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`cash_payment_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_credit_card_payment` */
DROP TABLE IF EXISTS `acm_bookkeeping_credit_card_payment`;

CREATE TABLE `acm_bookkeeping_credit_card_payment` (
  `credit_card_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `date` date NOT NULL,
  `card_type` varchar(50) DEFAULT NULL,
  `amount` decimal(10,4) NOT NULL,
  `card_payment_prime_entry_book_id` int(11) DEFAULT '0',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`credit_card_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_bookkeeping_credit_card_payment_history` */
DROP TABLE IF EXISTS `acm_bookkeeping_credit_card_payment_history`;

CREATE TABLE `acm_bookkeeping_credit_card_payment_history` (
  `credit_card_payment_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_card_payment_id` int(11) NOT NULL,
  `transaction_type` varchar(255) DEFAULT '',
  `transaction_id` int(11) DEFAULT '0',
  `date` date NOT NULL,
  `card_type` varchar(50) DEFAULT NULL,
  `amount` decimal(10,4) NOT NULL,
  `card_payment_prime_entry_book_id` int(11) DEFAULT '0',
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`credit_card_payment_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Alter `stm_sales_sales_return` Table
ALTER TABLE `stm_sales_sales_return`
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;*/

/*Alter `stm_sales_sales_return_history` Table
ALTER TABLE `stm_sales_sales_return_history`
  ADD COLUMN `status` varchar(10) DEFAULT 'Open' AFTER `remark`;*/
