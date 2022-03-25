
/*Data for the table `acm_admin_chart_of_accounts` */
INSERT INTO `acm_admin_chart_of_accounts` (`chart_of_account_id`, `chart_of_account_code`, `text`, `parent_id`, `level`, `actioned_user_id`, `action_date`, `last_action_status`)
SELECT (MAX(`chart_of_account_id`) + 1), '', 'Unearned Gift Voucher Revenue', 10, 3, 1, '2021-12-13 22:50:00', 'added' FROM `acm_admin_chart_of_accounts`;

/*Data for the table `acm_admin_prime_entry_books` */
INSERT INTO `acm_admin_prime_entry_books` (`prime_entry_book_id`, `prime_entry_book_name`, `description`, `actioned_user_id`, `action_date`, `last_action_status`)
SELECT (MAX(`prime_entry_book_id`) + 1), 'Receive Payment from a Debtor in Gift Voucher', '', 1, '2021-12-13 22:50:00', 'added' FROM `acm_admin_prime_entry_books`;

SELECT @primeEntryBookId := (MAX(prime_entry_book_id)) FROM `acm_admin_prime_entry_books`;
SELECT @chartOfAccountId := (MAX(chart_of_account_id)) FROM `acm_admin_chart_of_accounts`;

/*Data for the table `acm_admin_prime_entry_book_chart_of_accounts` */
INSERT INTO `acm_admin_prime_entry_book_chart_of_accounts` (`prime_entry_book_id`, `chart_of_account_id`, `debit_or_credit`, `actioned_user_id`, `action_date`, `last_action_status`) VALUES
(@primeEntryBookId, @chartOfAccountId, 'debit', 1, '2021-12-13 22:50:00', 'added');

INSERT INTO `acm_admin_prime_entry_book_chart_of_accounts` (`prime_entry_book_id`, `chart_of_account_id`, `debit_or_credit`, `actioned_user_id`, `action_date`, `last_action_status`) VALUES
(@primeEntryBookId, 102, 'credit', 1, '2021-12-13 22:50:00', 'added');

/*Table structure for table `acm_admin_multicurrency` */
DROP TABLE IF EXISTS `acm_admin_multicurrency`;

CREATE TABLE `acm_admin_multicurrency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(50) DEFAULT NULL,
  `currency_symbol` varchar(10) DEFAULT NULL,
  `base_currency` varchar(10) DEFAULT 'No',
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_admin_multicurrency_daily_rates` */
DROP TABLE IF EXISTS `acm_admin_multicurrency_daily_rates`;

CREATE TABLE `acm_admin_multicurrency_daily_rates` (
  `currency_daily_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `from_currency_id` int(11) NOT NULL,
  `to_currency_id` int(11) NOT NULL,
  `daily_rate` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`currency_daily_rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `acm_admin_multicurrency_monthly_average_rates` */
DROP TABLE IF EXISTS `acm_admin_multicurrency_monthly_average_rates`;

CREATE TABLE `acm_admin_multicurrency_monthly_average_rates` (
  `currency_monthly_average_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `from_currency_id` int(11) NOT NULL,
  `to_currency_id` int(11) NOT NULL,
  `monthly_average_rate` decimal(20,4) NOT NULL,
  `actioned_user_id` int(11) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `last_action_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`currency_monthly_average_rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Alter `acm_admin_chart_of_accounts` Table*/
ALTER TABLE `acm_admin_chart_of_accounts`
    ADD COLUMN `operating_currency` int(11) DEFAULT '0' AFTER `level`;

/*Alter `acm_bookkeeping_gl_transactions` Table*/
ALTER TABLE `acm_bookkeeping_gl_transactions`
    ADD COLUMN `currency_id` int(11) DEFAULT '0' AFTER `chart_of_account_id`;

/*Alter `acm_bookkeeping_gl_transactions_for_previous_years` Table*/
ALTER TABLE `acm_bookkeeping_gl_transactions_for_previous_years`
    ADD COLUMN `currency_id` int(11) DEFAULT '0' AFTER `chart_of_account_id`;

/*Alter `acm_bookkeeping_gl_transactions_history` Table*/
ALTER TABLE `acm_bookkeeping_gl_transactions_history`
    ADD COLUMN `currency_id` int(11) DEFAULT '0' AFTER `chart_of_account_id`;