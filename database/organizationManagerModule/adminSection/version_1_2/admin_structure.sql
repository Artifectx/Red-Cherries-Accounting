
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

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    ADD COLUMN `gender` varchar(20) DEFAULT '' AFTER `birth_day`,
    ADD COLUMN `grade` varchar(30) DEFAULT '' AFTER `worker_terminated_date`,
    ADD COLUMN `class` varchar(30) DEFAULT '' AFTER `grade`,
    ADD COLUMN `guardian_name` varchar(255) DEFAULT '' AFTER `class`,
    ADD COLUMN `guardian_tn_country_code` varchar(10) DEFAULT '' AFTER `guardian_name`,
    ADD COLUMN `guardian_telephone_number` varchar(25) DEFAULT '' AFTER `guardian_tn_country_code`;

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    ADD COLUMN `gender` varchar(20) DEFAULT '' AFTER `birth_day`,
    ADD COLUMN `grade` varchar(30) DEFAULT '' AFTER `worker_terminated_date`,
    ADD COLUMN `class` varchar(30) DEFAULT '' AFTER `grade`,
    ADD COLUMN `guardian_name` varchar(255) DEFAULT '' AFTER `class`,
    ADD COLUMN `guardian_tn_country_code` varchar(10) DEFAULT '' AFTER `guardian_name`,
    ADD COLUMN `guardian_telephone_number` varchar(25) DEFAULT '' AFTER `guardian_tn_country_code`;

/*Alter `ogm_admin_people` Table*/
ALTER TABLE `ogm_admin_people`
    CHANGE COLUMN `birth_day` `birth_day` date DEFAULT '0000-00-00',
    CHANGE COLUMN `location_id` `location_id` int(11) DEFAULT '0',
    CHANGE COLUMN `vehicle_id` `vehicle_id` int(11) DEFAULT '0',
    CHANGE COLUMN `login_status` `login_status` int(11) DEFAULT '0',
    CHANGE COLUMN `worker_registered_date` `worker_registered_date` date DEFAULT '0000-00-00',
    CHANGE COLUMN `worker_terminated_date` `worker_terminated_date` date DEFAULT '0000-00-00';

/*Alter `ogm_admin_people_history` Table*/
ALTER TABLE `ogm_admin_people_history`
    CHANGE COLUMN `birth_day` `birth_day` date DEFAULT '0000-00-00',
    CHANGE COLUMN `location_id` `location_id` int(11) DEFAULT '0',
    CHANGE COLUMN `vehicle_id` `vehicle_id` int(11) DEFAULT '0',
    CHANGE COLUMN `login_status` `login_status` int(11) DEFAULT '0',
    CHANGE COLUMN `worker_registered_date` `worker_registered_date` date DEFAULT '0000-00-00',
    CHANGE COLUMN `worker_terminated_date` `worker_terminated_date` date DEFAULT '0000-00-00';