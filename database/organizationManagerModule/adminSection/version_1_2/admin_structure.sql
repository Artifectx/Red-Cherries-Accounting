
/*Alter `ogm_admin_welfare_company_credit_accounts` Table*/
ALTER TABLE `ogm_admin_welfare_company_credit_accounts`
    ADD COLUMN `selected_for_credit_payment` decimal(20,2) DEFAULT '0.00' AFTER `received_credit_payment`;

/*Alter `ogm_admin_welfare_company_cheque_payments` Table*/
ALTER TABLE `ogm_admin_welfare_company_cheque_payments`
    ADD COLUMN `job_category_id` int(11) DEFAULT '0' AFTER `department_id`;

/*Table structure for table `ogm_admin_welfare_company_accounts_for_cheque_payment` */
DROP TABLE IF EXISTS `ogm_admin_welfare_company_accounts_for_cheque_payment`;

CREATE TABLE `ogm_admin_welfare_company_accounts_for_cheque_payment` (
  `account_for_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) NOT NULL,
  `credit_account_id` int(11) NOT NULL,
  `welfare_company_payment_id` int(11) DEFAULT NULL,
  `actioned_user_id` int(11) NOT NULL,
  `action_date` datetime NOT NULL,
  `last_action_status` varchar(100) NOT NULL,
  PRIMARY KEY (`account_for_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;